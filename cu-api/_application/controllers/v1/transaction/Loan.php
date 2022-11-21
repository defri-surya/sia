<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loan extends Auth_Api_Controller
{

    public function index()
    {
    }

    public function get_option_loan_get()
    {
        $member_id = (string)$this->get('member_id'); // id member

        if (!empty($member_id)) {
            $sql_get = "SELECT member_product_id as id, member_product_product_loan_name as 'name', member_product_product_loan_name_alias as name_alias, member_product_code as code
                FROM sys_member_product_loan
                WHERE member_product_member_id = {$member_id}
            ";

            $result = $this->db->query($sql_get);

            $result_arr = array();

            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    $result_arr[] = array_map("convertNullToString", $row);
                }
            }


            if (!empty($result_arr)) {
                $this->createResponse(REST_Controller::HTTP_OK, $result_arr);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data tidak ditemukan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan pilihan pinjaman.');
        }
    }

    public function get_data_invoice_get()
    {
        $id = (string)$this->get('id'); // id pinjaman ==> member_product_id
        if (!empty($id)) {

            $sql_get = "SELECT 
                invoice_loan_id as id,
                invoice_loan_member_id as member_id,
                invoice_loan_member_product_id as member_product_id,
                invoice_loan_product_id as product_id,
                invoice_loan_number as 'number',
                invoice_loan_trans_number as trans_number,
                invoice_loan_period as period,
                invoice_loan_date as date,
                invoice_loan_due_date as due_date,
                invoice_loan_forfeit_date as forfeit_date,
                invoice_loan_total_value as total_value,
                invoice_loan_interest_value as interest_value,
                invoice_loan_principal_value as principal_value,
                invoice_loan_total_paid as total_paid,
                invoice_loan_interest_paid as interest_paid,
                invoice_loan_principal_paid as principal_paid,
                invoice_loan_kompensasi_paid as kompensasi_paid,
                invoice_loan_discount_value as discount_value,
                invoice_loan_forfeit_value as forfeit_value,
                invoice_loan_forfeit_paid as forfeit_paid,
                invoice_loan_paid_datetime as paid_datetime,
                invoice_loan_is_paid_off as is_paid_off
                FROM sys_invoice_loan
                WHERE invoice_loan_member_product_id = {$id}
                ORDER BY invoice_loan_period ASC
            ";
            $result = $this->db->query($sql_get);

            $paid = array();
            $unpaid = array();
            $last_paid = '';
            $due_date = '';
            $last_period = '';

            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    $row['period'] = (int)$row['period'];
                    $row['total_value'] = (int)$row['total_value'];
                    $row['interest_value'] = (int)$row['interest_value'];
                    $row['principal_value'] = (int)$row['principal_value'];
                    $row['total_paid'] = (int)$row['total_paid'];
                    $row['interest_paid'] = (int)$row['interest_paid'];
                    $row['principal_paid'] = (int)$row['principal_paid'];
                    $row['forfeit_value'] = (int)$row['forfeit_value'];
                    $row['forfeit_paid'] = (int)$row['forfeit_paid'];
                    if ($row['is_paid_off'] == 1) {
                        $last_paid = $row['paid_datetime'];
                        $due_date = $row['due_date'];
                        $last_period = $row['period'];
                        $paid[] = array_map("convertNullToString", $row);
                    } else {
                        $unpaid[] = array_map("convertNullToString", $row);
                    }
                }
            }

            $sql_collateral = "SELECT
                collateral_taksasi_value,
                collateral_options,
                collateral_vehicle_type,
                collateral_vehicle_brand,
                collateral_created_year,
                collateral_nopol,
                collateral_nobpkb,
                collateral_norangka,
                collateral_nomesin,
                collateral_stnk_name,
                collateral_bpkb_name,
                collateral_sertifikat_name,
                collateral_nohm,
                collateral_area_size,
                collateral_atas_nama,
                collateral_location,
                collateral_measuring_number,
                collateral_deposito_type,
                collateral_deposito_name,
                collateral_deposito_address,
                collateral_deposito_account_number,
                collateral_deposito_due_date,
                collateral_deposito_value,
                collateral_note
                FROM collateral
                WHERE collateral_member_product_loan_id = {$id}
            ";

            $collateral = $this->db->query($sql_collateral)->result();


            $sql_collateral_saving = "SELECT
                collateral_saving_member_product_saving_id,
                collateral_saving_member_id,
                collateral_saving_status,
                collateral_saving_start_value,
                collateral_saving_value,
                member_product_saving_name,
                member_product_saving_name_alias,
                member_product_saving_member_balance,
                member_product_saving_account_number
                FROM collateral_saving
                JOIN sys_member_product_saving ON collateral_saving_member_product_saving_id = member_product_saving_id
                WHERE collateral_saving_member_product_loan_id = {$id}
            ";

            $collateral_saving = $this->db->query($sql_collateral_saving)->result();

            $result_arr = array(
                'paid' => $paid,
                'unpaid' => $unpaid,
                'last_paid_date' => $last_paid,
                'last_paid_period' => $last_period,
                'last_due_date' => $due_date,
                'collateral' => $collateral,
                'collateral_saving' => $collateral_saving
            );


            if (!empty($result_arr)) {
                $this->createResponse(REST_Controller::HTTP_OK, $result_arr);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data tidak ditemukan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data tagihan.');
        }
    }

    public function act_add_paid_post()
    {
        $this->form_validation->set_rules('id', '<b>Data Pinjaman</b>', 'required');
        $this->form_validation->set_rules('period', '<b>Periode Pinjaman</b>', 'required|is_natural_no_zero|callback_check_period');
        $this->form_validation->set_rules('principal', '<b>Pokok Pinjaman</b>', 'required');
        $this->form_validation->set_rules('interest', '<b>Bunga Pinjaman</b>', 'required');
        $this->form_validation->set_rules('forfeit', '<b>Denda Pinjaman</b>', 'required');
        $this->form_validation->set_rules('is_lkh', '<b>Masuk LKH</b>', 'required');
        $this->form_validation->set_rules('member_id', '<b>Data Member</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();
            $str_msg = "";
            try {
                $id = $this->post('id');
                $period = $this->post('period');
                $principal = $this->post('principal');
                $interest = $this->post('interest');
                $forfeit = $this->post('forfeit');
                $is_lkh = $this->post('is_lkh');
                $member_id = $this->post('member_id');

                $input_datetime = $datetime = date('Y-m-d H:i:s');

                $last_period = $this->get_last_period($id);
                if ($period > 1) {
                    for ($i = 1; $i <= $period; $i++) {
                        $this->db->set('invoice_loan_total_paid', 'invoice_loan_total_value', false);
                        $this->db->set('invoice_loan_interest_paid', 'invoice_loan_interest_value', false);
                        $this->db->set('invoice_loan_principal_paid', 'invoice_loan_principal_value', false);
                        $this->db->set('invoice_loan_forfeit_paid', 'invoice_loan_forfeit_value', false);
                        $this->db->set('invoice_loan_paid_datetime', $input_datetime);
                        $this->db->set('invoice_loan_is_paid_off', '1');
                        $this->db->where('invoice_loan_member_product_id', $id);
                        $this->db->where('invoice_loan_period', $last_period);
                        if (!$this->db->update('sys_invoice_loan')) {
                            throw new Exception("Error Processing Request", 1);
                        }
                        $last_period++;
                    }
                } else {
                    $total_paid = $principal + $interest + $forfeit;

                    $total_value = (int)$this->get_total_invoice($id, $last_period);

                    if ($total_value == $total_paid) {
                        $this->db->set('invoice_loan_is_paid_off', 1);
                        $this->db->set('invoice_loan_paid_datetime', $input_datetime);
                    }

                    $this->db->set('invoice_loan_total_paid', 'invoice_loan_total_paid + ' . $total_paid, false);
                    $this->db->set('invoice_loan_interest_paid', 'invoice_loan_interest_paid + ' . $interest, false);
                    $this->db->set('invoice_loan_principal_paid', 'invoice_loan_principal_paid + ' . $principal, false);
                    $this->db->set('invoice_loan_forfeit_paid', 'invoice_loan_forfeit_paid + ' . $forfeit, false);
                    $this->db->where('invoice_loan_member_product_id', $id);
                    $this->db->where('invoice_loan_period', $last_period);
                    if (!$this->db->update('sys_invoice_loan')) {
                        throw new Exception("Error Processing Request", 1);
                    }
                }

                $this->db->set('collateral_saving_value', 'collateral_saving_value - ' . $principal, false);
                $this->db->where('collateral_saving_member_product_loan_id', $id);
                $this->db->where('collateral_saving_member_id', $member_id);
                if (!$this->db->update('collateral_saving')) {
                    throw new Exception("Error Processing Request", 1);
                }

                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');
                $input_admin_id = $this->get_user('user_auth_user_id');
                $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                $date = date('Y-m-d');

                $member_detail = $this->common_model->get_member_name_code($member_id);
                $trans_code = $this->common_model->generate_trans_code($date);
                $note_trans = "Pembayaran Pinjaman sejumlah {$period} periode atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}";

                if ($is_lkh) {
                    $total_paid = $principal + $interest + $forfeit;
                    $trans = array();
                    $trans['transaction_branch_id'] = $input_admin_branch_id;
                    $trans['transaction_member_id'] = $member_id;
                    $trans['transaction_product_loan_id'] = $id;
                    $trans['transaction_code'] = $trans_code;
                    $trans['transaction_debet'] = $total_paid;
                    $trans['transaction_note'] = strtoupper($note_trans);
                    $trans['transaction_datetime'] = $datetime;
                    $trans['transaction_input_datetime'] = $input_datetime;
                    $trans['transaction_administrator_id'] = $input_admin_id;
                    $trans['transaction_administrator_name'] = $input_admin_name;
                    $trans['transaction_administrator_username'] = $input_admin_username;
                    $this->db->insert('sys_transaction', $trans);
                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }
                }

                if (!$this->common_model->insert_hutang_piutang('hutang', 'out', $principal, $member_detail->member_name, $member_detail->member_code, $member_id)) {
                    $is_error = true;
                }

                if ($principal > 0) {
                    $jurnal_id = $this->common_model->get_jurnal_loan_principal($id, $input_admin_branch_id);

                    if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $principal, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                        $is_error = true;
                    }
                }
                if ($interest > 0) {
                    $jurnal_id = $this->common_model->get_jurnal_loan_interest($id, $input_admin_branch_id);

                    if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $interest, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                        $is_error = true;
                    }
                }
                if ($forfeit > 0) {
                    $denda_terbayar = array();

                    $denda_terbayar['denda_terbayar_product_member_id'] = $id;
                    $denda_terbayar['denda_terbayar_admin_id'] = $input_admin_id;
                    $denda_terbayar['denda_terbayar_nominal'] = $forfeit;
                    $denda_terbayar['denda_terbayar_nominal_cash'] = $forfeit;
                    $denda_terbayar['denda_terbayar_nominal_bank'] = 0;
                    $denda_terbayar['denda_terbayar_nominal_titipan'] = 0;
                    $denda_terbayar['denda_terbayar_nominal_affiliasi_hc'] = 0;
                    $denda_terbayar['denda_terbayar_nominal_kas_besar'] = 0;
                    $denda_terbayar['denda_no_bukti_manual'] = '';
                    $denda_terbayar['denda_no_bukti_system'] = $trans_code;
                    $denda_terbayar['denda_note'] = $note_trans;
                    $denda_terbayar['denda_terbayar_input_datetime'] = $input_datetime;
                    $denda_terbayar['denda_terbayar_paid_datetime'] = $datetime;
                    if (!$this->db->insert('denda_armot_terbayar', $denda_terbayar)) {
                        $is_error = true;
                    }

                    $sql_update = "UPDATE denda_armot SET denda_total_terbayar = (SELECT sum(denda_terbayar_nominal) FROM denda_armot_terbayar WHERE denda_terbayar_product_member_id = {$id}) WHERE denda_product_member_id = {$id}";
                    $this->db->query($sql_update);


                    $jurnal_id = $this->common_model->get_jurnal_loan_forfeit($id, $input_admin_branch_id);

                    if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $forfeit, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                        $is_error = true;
                    }
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran pinjaman! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan pembayaran pinjaman' . $str_msg);
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran pinjaman! Silahkan coba lagi.');
            }
        }
    }

    private function get_last_period($id)
    {
        return $this->db->query("SELECT IFNULL(MIN(invoice_loan_period),0) as last_period FROM sys_invoice_loan WHERE invoice_loan_member_product_id = {$id} AND invoice_loan_is_paid_off = 0 ")->row('last_period');
    }

    private function get_total_invoice($id, $period)
    {
        return $this->db->query("SELECT 
            sum(invoice_loan_total_value-invoice_loan_total_paid) as total
            FROM sys_invoice_loan
            WHERE invoice_loan_member_product_id = {$id}
            AND invoice_loan_period = {$period}
        ")->row('total');
    }

    public function check_period($str)
    {
        $id = $this->post('id');
        $principal = $this->post('principal');
        $interest = $this->post('interest');
        $forfeit = $this->post('forfeit');
        $last_period = $this->get_last_period($id);
        $next_period = $last_period + $str - 1;

        $sql_get = "SELECT 
            sum(invoice_loan_interest_value-invoice_loan_interest_paid) as interest,
            sum(invoice_loan_principal_value-invoice_loan_principal_paid) as principal,
            sum(invoice_loan_forfeit_value-invoice_loan_forfeit_paid) as forfeit
            FROM sys_invoice_loan
            WHERE invoice_loan_member_product_id = {$id}
            AND invoice_loan_is_paid_off = 0
            AND invoice_loan_period BETWEEN {$last_period} AND $next_period
        ";

        $data = $this->db->query($sql_get)->row();
        $message = '';
        $data->principal = (int)$data->principal;
        $data->interest = (int)$data->interest;
        $data->forfeit = (int)$data->forfeit;

        if ($str == 1) {
            if ($principal > $data->principal) {
                $message = '<b>Pokok Pinjaman</b> melebihi nominal seharusnya.';
            }
            if ($interest > $data->interest) {
                $message = '<b>Bunga Pinjaman</b> melebihi nominal seharusnya.';
            }
            if ($forfeit > $data->forfeit) {
                $message = '<b>Denda Pinjaman</b> melebihi nominal seharusnya.';
            }
        } else {
            if ($principal != $data->principal) {
                $message = '<b>Pokok Pinjaman</b> tidak sama dengan nominal seharusnya.';
            }
            if ($interest != $data->interest) {
                $message = '<b>Bunga Pinjaman</b> tidak sama dengan nominal seharusnya.';
            }
            if ($forfeit != $data->forfeit) {
                $message = '<b>Denda Pinjaman</b> tidak sama dengan nominal seharusnya.';
            }
        }

        if (!empty($message)) {
            $this->form_validation->set_message('check_period', $message);
            return false;
        } else {
            return true;
        }
    }
}

/* End of file Loan.php */
