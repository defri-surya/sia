<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Auth_Api_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function migration_post() {
        $is_error = false;

        $this->db->trans_begin();

        $json_data = $this->post('json_data');
        $arr_data = json_decode($json_data, TRUE);
        $total_items = count($arr_data);
        $data = $arr_data;
//        print_r($data);die;
        $this->db->insert_batch('sys_member', $data);

        if ($this->db->affected_rows() < 0) {
            $is_error = true;
        }

        if (!$is_error) {
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.a');
            } else {
                $this->db->trans_commit();
                $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil tambah data.');
            }
        } else {
            $this->db->trans_rollback();
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.b');
        }
    }


    public function entrance_fee_post(){
        $json_data = $this->post('json_data');
        $arr_data = json_decode($json_data);

        $succes = 0;
        $failed = 0;

        if(is_array($arr_data)){
            foreach($arr_data as $key => $val){
                $is_error = false;
                $this->db->trans_begin();
                try{
                    $nominal = $val->nominal;
                    $period = $val->period;
                    $member_code = $val->member_code;
                    $member_id = $this->common_model->get_member_id($member_code);
                    $member_detail = $this->common_model->get_member_name_code($member_id);
                    $config = $this->common_model->get_config_entrance_fee();

                    $input_datetime = $member_detail->member_registered_date;

                    $count_lunas = 0;
                    $arr_entrance_fee = array();
                    foreach ($config as $row) {
                        $count_lunas++;
                        $data = array();
                        $data['entrance_fee_member_id'] = $member_id;
                        $data['entrance_fee_name'] = $row->name;
                        $data['entrance_fee_value'] = $row->value;
                        if($row->name == 'principal'){
                            $data['entrance_fee_value'] = $nominal;
                            if($row->value != $nominal){
                                $count_lunas--;
                            }
                        }
                        $data['entrance_fee_note'] = '-';
                        $data['entrance_fee_datetime'] = $input_datetime;
                        $data['entrance_fee_administrator_username'] = 'Superuser';
                        $data['entrance_fee_administrator_name'] = 'superuser';

                        $this->db->insert('sys_trans_entrance_fee', $data);
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }

                        $balance_log_id = 0;
                        $note_trans = "Pembayaran {$row->title} atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}";

                        $trans = array();
                        $trans['transaction_branch_id'] = 1;
                        $trans['transaction_member_id'] = $member_id;
                        $trans['transaction_balance_log_id'] = $balance_log_id;
                        $trans['transaction_debet'] = $row->value;
                        if ($row->name == 'principal') {
                            $trans['transaction_debet'] = $nominal;
                        }
                        $trans['transaction_note'] = strtoupper($note_trans);
                        $trans['transaction_datetime'] = $input_datetime;
                        $trans['transaction_input_datetime'] = $input_datetime;
                        $trans['transaction_administrator_id'] = '1';
                        $trans['transaction_administrator_name'] = 'Superuser';
                        $trans['transaction_administrator_username'] = 'superuser';
                        $this->db->insert('sys_transaction', $trans);
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }

                        if ($row->name == 'principal' || $row->name == 'obligation' || $row->name == 'social') {
                            $month_year = '';
                            if ($row->type == 'period') {
                                if ($row->period == 'monthly') {
                                    $month_year = date("Y-m-01", strtotime($member_detail->member_registered_date));
                                }
                                if ($row->period == 'annually') {
                                    $month_year = date("Y-01-01", strtotime($member_detail->member_registered_date));
                                }
                            }
                            $balance_now = $this->common_model->get_member_balance_by_type($member_id, $row->name);
                            $last_balance = $balance_now + $row->value;
                            $balance_log = array();
                            $balance_log['balance_log_member_id'] = $member_id;
                            $balance_log['balance_log_name'] = $row->name;
                            $balance_log['balance_log_debet'] = $row->value;
                            if ($row->name == 'principal') {
                                $balance_log['balance_log_debet'] = $nominal;
                            }
                            $balance_log['balance_log_datetime'] = $input_datetime;
                            $balance_log['balance_log_last_balance'] = $last_balance;
                            $balance_log['balance_log_input_datetime'] = $input_datetime;
                            $balance_log['balance_log_month_year'] = $month_year;
                            $balance_log['balance_log_administrator_name'] = 'Superuser';
                            $balance_log['balance_log_administrator_username'] = 'superuser';
                            $balance_log['balance_log_administrator_id'] = '0';
                            $this->db->insert('sys_member_balance_log', $balance_log);
                            if ($this->db->affected_rows() < 0) {
                                $is_error = true;
                            }
                            $balance_log_id = $this->db->insert_id();

                            $this->db->set('member_balance_' . $row->name, 'member_balance_' . $row->name . ' + ' . $row->value, false);
                            $this->db->where('member_balance_member_id', $member_id);
                            $this->db->update('sys_member_balance');
                            if ($this->db->affected_rows() < 0) {
                                $is_error = true;
                            }
                        }
                    }
                    if ($count_lunas == count($config)) {

                        $this->db->set('member_entrance_fee_paid_off', 1);
                        $this->db->where('member_id', $member_id);
                        $this->db->update('sys_member');
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        } else {
                            $this->common_model->update_member_status($member_id);
                        }
                    }

                    $nominal_saving = 0;
                    $last_balance = 0;
                    $balance_now = $this->common_model->get_member_balance_by_type($member_id, 'obligation');
                    
                    for ($i = 1; $i <= $period; $i++) {
                        $month_year = date("Y-m-01", strtotime("+$i month", strtotime($member_detail->member_registered_date)));
                        $datetime = date('Y-m-d H:i:s', strtotime($month_year));
                        
                        $last_balance = $balance_now + (5000 * $i);


                        $balance_log = array();
                        $balance_log['balance_log_member_id'] = $member_id;
                        $balance_log['balance_log_name'] = 'obligation';
                        $balance_log['balance_log_debet'] = 5000;
                        $balance_log['balance_log_datetime'] = $datetime;
                        $balance_log['balance_log_last_balance'] = $last_balance;
                        $balance_log['balance_log_input_datetime'] = $datetime;
                        $balance_log['balance_log_month_year'] = $month_year;
                        $balance_log['balance_log_administrator_name'] = 'Superuser';
                        $balance_log['balance_log_administrator_username'] = 'superuser';
                        $balance_log['balance_log_administrator_id'] = 0;
                        if (!$this->db->insert('sys_member_balance_log', $balance_log)) {
                            $is_error = true;
                        }

                        $this->db->set('member_balance_obligation', 'member_balance_obligation + ' . $nominal_saving, false);
                        $this->db->where('member_balance_member_id', $member_id);
                        $this->db->update('sys_member_balance');
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }

                        $note_trans = "Pembayaran Iuran Simpanan Wajib sejumlah 1 periode atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}";
                        $trans = array();
                        $trans['transaction_branch_id'] = $this->get_user('user_auth_branch_id');
                        $trans['transaction_member_id'] = $member_id;
                        $trans['transaction_debet'] = 5000;
                        $trans['transaction_note'] = strtoupper($note_trans);
                        $trans['transaction_datetime'] = $datetime;
                        $trans['transaction_input_datetime'] = $datetime;
                        $trans['transaction_administrator_id'] = '1';
                        $trans['transaction_administrator_name'] = 'Superuser';
                        $trans['transaction_administrator_username'] = 'superuser';
                        $this->db->insert('sys_transaction', $trans);
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }
                    }
                }catch (Exception $ex) {
                    $is_error = true;
                }

                if (!$is_error) {
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        $failed++;
                    } else {
                        $this->db->trans_commit();
                        $succes++;
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
                
            }
        }

        if($succes > 0){
            $str = "$succes data berhasil. $failed data gagal.";
            $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan inject saldo. '. $str);
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan inject saldo! Silahkan coba lagi.');
        }

    }


    public function inject_sipari_post(){
        $json_data = $this->post('json_data');
        $arr_data = json_decode($json_data);

        $succes = 0;
        $failed = 0;

        if (is_array($arr_data)) {
            foreach ($arr_data as $key => $val) {
                $is_error = false;
                $this->db->trans_begin();
                try {
                    $member_name = $val->member_name;
                    $member_detail = $this->get_member($member_name);
                    if(empty($member_detail)){
                        $is_error = true;
                    }else{
                        $member_id = $member_detail->member_id;
                        $member_code = $member_detail->member_code;
                        $product_saving_id = 1;
                        $detail_product = $this->get_detail_product($product_saving_id);
                        
                        $no_rekening = $this->common_model->generate_code('sys_member_product_saving', 'member_product_saving_account_number', 'WHERE member_product_saving_product_saving_id = ' . $product_saving_id, 6);
    
                        $data['member_product_saving_member_id'] = $member_id;
                        $data['member_product_saving_member_code'] = $member_code;
                        $data['member_product_saving_account_number'] = 'SPR.'.$member_detail->branch_code.'.'.$no_rekening;
                        $data['member_product_saving_member_balance'] = $val->saldo;
                        $data['member_product_saving_is_active'] = 1;
                        $data['member_product_saving_period'] = 0;
                        $data['member_product_saving_product_saving_id'] = $product_saving_id;
                        $data['member_product_saving_name'] = $detail_product->product_saving_name;
                        $data['member_product_saving_name_alias'] = $detail_product->product_saving_name_alias;
    
                        if(!$this->db->insert('sys_member_product_saving', $data)){
                            $is_error = true;
                        }
                    }
                } catch (Exception $ex) {
                    $is_error = true;
                }

                if (!$is_error) {
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        $failed++;
                    } else {
                        $this->db->trans_commit();
                        $succes++;
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }

            }
        }

        if ($succes > 0) {
            $str = "$succes data berhasil. $failed data gagal.";
            $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan inject saldo. ' . $str);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan inject saldo! Silahkan coba lagi.');
        }
    }

    private function get_member($name){
        $sql = "SELECT member_id, member_code, branch_code FROM sys_member JOIN sys_branch ON member_branch_id = branch_id WHERE member_name = '{$name}' LIMIT 1";
        $data = $this->db->query($sql);
        if($data->num_rows() > 0){
            return $data->row();
        }else{
            return array();
        }
    }

    private function get_detail_product($product_id)
    {

        $sql_get = "SELECT
            product_saving_id,
            product_saving_code,
            product_saving_name,
            product_saving_name_alias
            FROM sys_product_saving
            WHERE product_saving_id = {$product_id}
        ";

        return $this->db->query($sql_get)->row();
    }

}
