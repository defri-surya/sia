<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrawal extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    

    public function get_option_get()
    {
        $member_id = (string)$this->get('member_code');

        if (!empty($member_id)) {
            $sql_get_member_detail = "SELECT
                member_id,
                member_code,
                member_temp_code,
                member_name,
                branch_name
                FROM sys_member 
                JOIN sys_branch ON branch_id = member_branch_id
                WHERE member_id = '$member_id'
            ";
            $detail_member = $this->db->query($sql_get_member_detail)->row();

            if (!empty($detail_member)) {
                $sql_get_saving = "SELECT 
                    member_product_saving_id as saving_id,
                    product_saving_name_alias as name_alias,
                    member_product_saving_product_saving_id as id, 
                    member_product_saving_name as 'name', 
                    member_product_saving_member_balance as balance, 
                    member_product_saving_account_number as account_number, 
                    product_saving_min_balance as min_balance, 
                    product_saving_is_withdrawal_fee as is_withdrawal_fee, 
                    product_saving_withdraw_fee_percent as withdraw_fee_percent,
                    CONCAT(product_saving_name_alias, ' - ', member_product_saving_account_number) as 'label'
                    FROM sys_member_product_saving 
                    JOIN sys_product_saving ON product_saving_id = member_product_saving_product_saving_id
                    WHERE member_product_saving_member_id = $member_id AND product_saving_is_withdrawal = 1 AND member_product_saving_is_active = 1 AND member_product_saving_is_blocked = 0
                ";
                $arr_saving_option = $this->db->query($sql_get_saving)->result();

                $data = array(
                    'detail_member' => $detail_member,
                    'option_withdrawal' => $arr_saving_option
                );

                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data tidak ditemukan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan pilihan penarikan.');
        }
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('saving_id', '<b>Produk Simpanan</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('nominal_withdraw', '<b>Jumlah Penarikan</b>', 'required|callback_withdrawal_check[' . $this->post('saving_id') . ']');
        $this->form_validation->set_rules('date', '<b>Tanggal Penarikan</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();
            
            $str_msg = "";

            try {

                $saving_id = $this->post('saving_id');
                $nominal_withdraw = $this->post('nominal_withdraw');
                $note = $this->post('note');
                $date = $this->post('date');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');
                $input_admin_id = $this->get_user('user_auth_user_id');
                $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                $input_datetime = $datetime = date('Y-m-d H:i:s');
                $now = date('Y-m-d');
                if ($date != $now) {
                    $datetime = $this->common_model->get_dateime_by_date_transaction($date);
                }

                $member_product = $this->get_detail_saving($saving_id);
                $str_msg = $member_product->product_name . ' atas nama ' . $member_product->member_name . '.';

                $mb_log = array();
                $mb_log['member_product_saving_log_member_product_saving_id'] = $member_product->saving_id;
                $mb_log['member_product_saving_log_member_id'] = $member_product->member_id;
                $mb_log['member_product_saving_log_code'] = $member_product->saving_id . '/' . strtotime($input_datetime); // sementara tak kaya giniin om
                $mb_log['member_product_saving_log_kredit'] = $nominal_withdraw;
                $mb_log['member_product_saving_log_note'] = $note;
                $mb_log['member_product_saving_log_datetime'] = $datetime; 
                $mb_log['member_product_saving_log_input_datetime'] = $input_datetime; 
                $mb_log['member_product_saving_log_input_datetime'] = $input_datetime;
                $mb_log['member_product_saving_log_input_admin_name'] = $input_admin_name;
                $mb_log['member_product_saving_log_input_admin_username'] = $input_admin_username;
                $mb_log['member_product_saving_log_input_admin_id'] = $input_admin_id;
                $this->db->insert('sys_member_product_saving_log', $mb_log);
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                $this->db->set('member_product_saving_member_balance', 'member_product_saving_member_balance-' . $nominal_withdraw, false);
                $this->db->where('member_product_saving_id', $member_product->saving_id);
                $this->db->update('sys_member_product_saving');
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                $note_trans = strtoupper("Penarikan {$member_product->product_name} atas nama {$member_product->member_name}, nomor anggota {$member_product->member_code}, nomor rekening {$member_product->account_number}");
                $trans_code = $this->common_model->generate_trans_code($date);
                $trans = array();
                $trans['transaction_branch_id'] = $input_admin_branch_id;
                $trans['transaction_member_id'] = $member_product->member_id;
                $trans['transaction_product_saving_id'] = $member_product->id;
                $trans['transaction_code'] = $trans_code;
                $trans['transaction_kredit'] = $nominal_withdraw;
                $trans['transaction_note'] = $note_trans;
                $trans['transaction_datetime'] = $datetime;
                $trans['transaction_input_datetime'] = $input_datetime;
                $trans['transaction_administrator_id'] = $input_admin_id;
                $trans['transaction_administrator_name'] = $input_admin_name;
                $trans['transaction_administrator_username'] = $input_admin_username;
                $this->db->insert('sys_transaction', $trans);
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if (!$this->common_model->insert_hutang_piutang('piutang', 'out', $nominal_withdraw, $member_product->member_name, $member_product->member_code, $member_product->member_id)) {
                    $is_error = true;
                }

                $jurnal_id = $this->common_model->get_jurnal_withdrawal_saving_product($member_product->id, $input_admin_branch_id);

                if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $nominal_withdraw, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                    $is_error = true;
                }

            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan penarikan! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan penarikan ' . $str_msg);
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan penarikan! Silahkan coba lagi.');
            }
        }
    }

    private function get_detail_saving($saving_id)
    {
        $sql_get_saving = "SELECT 
            member_id,
            member_product_saving_name as product_name,
            member_product_saving_product_saving_id as id,
            member_product_saving_member_code as member_code,
            member_product_saving_member_name as member_name,
            member_product_saving_account_number as account_number,
            member_product_saving_member_balance as saldo,
            member_product_saving_id as saving_id,
            member_name
            FROM sys_member_product_saving 
            JOIN sys_member ON member_id = member_product_saving_member_id
            WHERE member_product_saving_id = $saving_id
        ";
        return $this->db->query($sql_get_saving)->row();
    }

    public function withdrawal_check($str, $params)
    {
        if (!empty($str)) {
            if (is_numeric($str)) {
                $saving_id = $params;
                $sql_get_saving = "SELECT 
                    member_product_saving_member_balance as balance,
                    product_saving_min_balance as min_balance, 
                    product_saving_is_withdrawal_fee as is_withdrawal_fee, 
                    product_saving_withdraw_fee_percent as withdraw_fee_percent
                    FROM sys_member_product_saving 
                    JOIN sys_product_saving ON product_saving_id = member_product_saving_product_saving_id
                    WHERE member_product_saving_id = '$saving_id' AND member_product_saving_is_active = 1 AND member_product_saving_is_blocked = 0 AND product_saving_is_withdrawal = 1
                ";
                $query = $this->db->query($sql_get_saving);
                if ($query->num_rows() > 0) {
                    $data = $query->row();

                    $last_balance = $data->balance - $str;
                    if ($data->min_balance <= $last_balance) {
                        $sql_collateral = "SELECT IFNULL(sum(collateral_saving_value),0) as collateral FROM collateral_saving WHERE collateral_saving_member_product_saving_id = '$saving_id' AND collateral_saving_value > 0";
                        $collateral_balance = $this->db->query( $sql_collateral)->row('collateral');
                        $last_balance = $data->balance - $str - $collateral_balance;
                        if ($data->min_balance <= $last_balance) {
                            return true;
                        }
                        $dapat_ditarik = $data->balance - $collateral_balance - $data->min_balance;
                        $this->form_validation->set_message('withdrawal_check', '{field} melebihi batas minimal saldo mengendap. Minimal saldo mengendap saat ini Rp. ' . number_format($data->min_balance, 0, ',', '.') . '. Saldo anda saat ini adalah Rp. ' . number_format($data->balance, 0, ',', '.') . '. Saldo anda yang masih dijadikan jaminan adalah Rp. ' . number_format( $collateral_balance, 0, ',', '.') . '. Saldo anda yang dapat ditarik adalah Rp. ' . number_format( $dapat_ditarik, 0, ',', '.') . '.');
                        return false;
                    } else {
                        $this->form_validation->set_message('withdrawal_check', '{field} melebihi batas minimal saldo mengendap. Minimal saldo mengendap saat ini Rp. '.number_format($data->min_balance, 0, ',','.'). '. Dan saldo anda saat ini adalah Rp. ' . number_format($data->balance, 0, ',', '.') .'.');
                        return false;
                    }
                } else {
                    $this->form_validation->set_message('withdrawal_check', '{field} simpanan tidak ditemukan.');
                    return false;
                }
            } else {
                $this->form_validation->set_message('withdrawal_check', '{field} harus angka.');
                return false;
            }
        } else {
            $this->form_validation->set_message('withdrawal_check', '{field} tidak boleh kosong.');
            return false;
        }
    }

}

/* End of file Withdrawal.php */
