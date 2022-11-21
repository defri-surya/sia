<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Saving_interest extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function index(){

    }
    
    public function daily()
    {
        ini_set("memory_limit", -1);
        set_time_limit(0);

        $datetime = date('Y-m-d H:i:s');
        $date = date('Y-m-d');
        $yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        $period = 0;
        $metode = 'daily';
        $product = $this->get_data_product_saving($period);

        $arr_message = array();

        foreach($product as $pro){
            $member = $this->get_data_member_saving($pro->id, $pro->min_balance);

            $succes = 0;
            foreach($member as $mem){
                $is_error = false;
                $this->db->trans_begin();
                try{
                    if($this->check_bjs_is_counted($mem->id, $period, $date)){
                        throw new Exception("Error Bunga Sudah Dihitung", 1);
                    }

                    $bjs = 0;
                    $percent = 0;
                    $balance = $mem->balance;
                    if($pro->is_last_balance == 1){
                        $min_balance = $this->get_lower_balance($mem->id, $metode, $yesterday);
                        if (!empty($min_balance)) {
                            $balance = $min_balance->balance;
                        }
                    }

                    if (!isset($pro->config_json->bjs)) {
                        $bjs = $balance * $pro->percent / 100;
                        $percent = $pro->percent;
                    } else {
                        if ($pro->config_json->bjs->type == 'nominal') {
                            foreach ($pro->config_json->bjs->range as $row) {
                                if ($row->min == $row->max) {
                                    if ($balance > $row->min) {
                                        $bjs = $balance * $row->value / 100;
                                        $percent = $row->value;
                                    }
                                } else {
                                    if ($row->min < $balance && $balance <= $row->max) {
                                        $bjs = $balance * $row->value / 100;
                                        $percent = $row->value;
                                    }
                                }
                            }
                        } else if ($pro->config_json->bjs->type == 'period') {
                            foreach ($pro->config_json->bjs->range as $row) {
                                if ($row->period == $mem->period) {
                                    $bjs = $balance * $row->value / 100;
                                    $percent = $row->value;
                                }
                            }
                        }
                    }

                    $interest = array();
                    $interest['member_product_saving_interest_member_product_saving_id'] = $mem->id;
                    $interest['member_product_saving_interest_type'] = $period;
                    $interest['member_product_saving_interest_code'] = 'Belum Tau Formatnya';
                    $interest['member_product_saving_interest_value'] = $bjs;
                    $interest['member_product_saving_interest_percent'] = $percent;
                    $interest['member_product_saving_interest_note'] = 'belum tau note nya';
                    $interest['member_product_saving_interest_input_datetime'] = $datetime;
                    if(!$this->db->insert('sys_member_product_saving_interest', $interest)){
                        throw new Exception("Error Processing Insert Bunga", 1);
                    }

                    $last_balance = $mem->balance + $bjs;

                    $mb_log = array();
                    $mb_log['member_product_saving_log_member_product_saving_id'] = $mem->id;
                    $mb_log['member_product_saving_log_member_id'] = $mem->member_id;
                    $mb_log['member_product_saving_log_code'] = $mem->id . '/' . strtotime($datetime); // sementara tak kaya giniin om
                    $mb_log['member_product_saving_log_debet'] = $bjs;
                    $mb_log['member_product_saving_log_last_balance'] = $last_balance;
                    $mb_log['member_product_saving_log_note'] = 'belum tau note nya';
                    $mb_log['member_product_saving_log_datetime'] = $datetime;
                    $mb_log['member_product_saving_log_input_datetime'] = $datetime;
                    $mb_log['member_product_saving_log_input_admin_name'] = 'Sistem';
                    $mb_log['member_product_saving_log_input_admin_username'] = 'sistem';
                    $mb_log['member_product_saving_log_input_admin_id'] = 0;
                    if(!$this->db->insert('sys_member_product_saving_log', $mb_log)){
                        throw new Exception("Error Processing Insert Member Log", 1);
                    }

                    $this->db->set('member_product_saving_member_balance', 'member_product_saving_member_balance  + ' . $bjs, false);
                    $this->db->where('member_product_saving_id', $mem->id);
                    $this->db->update('sys_member_product_saving');
                    if ($this->db->affected_rows() <= 0) {
                        throw new Exception("Error Processing Update Member Saving Balance", 1);
                    }

                }catch(Exception $ex){
                    $is_error = true;
                }
                if($is_error){
                    $this->db->trans_rollback();
                }else{
                    if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                        $succes++;
                    }
                }
            }
            $arr_message[] = array(
                'product' => $pro->name.'/'.$pro->alias,
                'datebjs' => $date,
                'dateyesterday' => $yesterday,
                'metode' => $metode,
                'success' => $succes,
                'member_count' => count($member)
            );
        }

        echo '<pre>';
        print_r($arr_message);
    }

    public function monthly()
    {
        ini_set("memory_limit", -1);
        set_time_limit(0);

        $datetime = date('Y-m-01 H:i:s');
        $date = date('Y-m');
        $yesterday = date("Y-m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        $period = 1;
        $metode = 'monthly';
        $product = $this->get_data_product_saving($period);

        $arr_message = array();

        foreach ($product as $pro) {
            $member = $this->get_data_member_saving($pro->id, $pro->min_balance);

            $pro->config_json = json_decode($pro->config_json);

            $succes = 0;
            foreach ($member as $mem) {
                $is_error = false;
                $this->db->trans_begin();
                try {
                    if ($this->check_bjs_is_counted($mem->id, $period, $date)) {
                        throw new Exception("Error Bunga Sudah Dihitung", 1);
                    }

                    $bjs = 0;
                    $percent = 0;
                    $balance = $mem->balance;
                    if ($pro->is_last_balance == 1) {
                        $min_balance = $this->get_lower_balance($mem->id, $metode, $yesterday);
                        if (!empty($min_balance)) {
                            $balance = $min_balance->balance;
                        }
                    }

                    if (!isset($pro->config_json->bjs)) {
                        $bjs = $balance * $pro->percent / 100;
                        $percent = $pro->percent;
                    } else {
                        if ($pro->config_json->bjs->type == 'nominal') {
                            foreach ($pro->config_json->bjs->range as $row) {
                                if ($row->min == $row->max) {
                                    if ($balance > $row->min) {
                                        $bjs = $balance * $row->value / 100;
                                        $percent = $row->value;
                                    }
                                } else {
                                    if ($row->min < $balance && $balance <= $row->max) {
                                        $bjs = $balance * $row->value / 100;
                                        $percent = $row->value;
                                    }
                                }
                            }
                        } else if ($pro->config_json->bjs->type == 'period') {
                            foreach ($pro->config_json->bjs->range as $row) {
                                if ($row->period == $mem->period) {
                                    $bjs = $balance * $row->value / 100;
                                    $percent = $row->value;
                                }
                            }
                        }
                    }

                    $interest = array();
                    $interest['member_product_saving_interest_member_product_saving_id'] = $mem->id;
                    $interest['member_product_saving_interest_type'] = $period;
                    $interest['member_product_saving_interest_code'] = 'Belum Tau Formatnya';
                    $interest['member_product_saving_interest_value'] = $bjs;
                    $interest['member_product_saving_interest_percent'] = $percent;
                    $interest['member_product_saving_interest_note'] = 'belum tau note nya';
                    $interest['member_product_saving_interest_input_datetime'] = $datetime;
                    if (!$this->db->insert('sys_member_product_saving_interest', $interest)) {
                        throw new Exception("Error Processing Insert Bunga", 1);
                    }

                    $last_balance = $mem->balance + $bjs;

                    $mb_log = array();
                    $mb_log['member_product_saving_log_member_product_saving_id'] = $mem->id;
                    $mb_log['member_product_saving_log_member_id'] = $mem->member_id;
                    $mb_log['member_product_saving_log_code'] = $mem->id . '/' . strtotime($datetime); // sementara tak kaya giniin om
                    $mb_log['member_product_saving_log_debet'] = $bjs;
                    $mb_log['member_product_saving_log_last_balance'] = $last_balance;
                    $mb_log['member_product_saving_log_note'] = 'belum tau note nya';
                    $mb_log['member_product_saving_log_datetime'] = $datetime;
                    $mb_log['member_product_saving_log_input_datetime'] = $datetime;
                    $mb_log['member_product_saving_log_input_admin_name'] = 'Sistem';
                    $mb_log['member_product_saving_log_input_admin_username'] = 'sistem';
                    $mb_log['member_product_saving_log_input_admin_id'] = 0;
                    if (!$this->db->insert('sys_member_product_saving_log', $mb_log)) {
                        throw new Exception("Error Processing Insert Member Log", 1);
                    }

                    $this->db->set('member_product_saving_member_balance', 'member_product_saving_member_balance  + ' . $bjs, false);
                    $this->db->where('member_product_saving_id', $mem->id);
                    $this->db->update('sys_member_product_saving');
                    if ($this->db->affected_rows() <= 0) {
                        throw new Exception("Error Processing Update Member Saving Balance", 1);
                    }

                } catch (Exception $ex) {
                    $is_error = true;
                }
                if ($is_error) {
                    $this->db->trans_rollback();
                } else {
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                        $succes++;
                    }
                }
            }
            $arr_message[] = array(
                'product' => $pro->name . '/' . $pro->alias,
                'datebjs' => $date,
                'dateyesterday' => $yesterday,
                'metode' => $metode,
                'success' => $succes,
                'member_count' => count($member)
            );
        }

        echo '<pre>';
        print_r($arr_message);
    }

    private function check_bjs_is_counted($saving_id, $type, $date){
        $where = "AND date(member_product_saving_interest_input_datetime) = '$date'";
        if($type == 1){
            $where = "AND left(member_product_saving_interest_input_datetime, 7) = '$date'";
        }
        $sql = "SELECT member_product_saving_interest_id FROM sys_member_product_saving_interest
        WHERE member_product_saving_interest_member_product_saving_id = $saving_id
        AND member_product_saving_interest_type = $type
        $where";
        return $this->db->query($sql)->num_rows() > 0 ? true : false;
    }

    private function get_lower_balance($saving_id, $type, $date){
        $where = "AND date(member_product_saving_log_datetime) = '$date'";
        if($type == 'monthly'){
            $where = "AND LEFT(member_product_saving_log_datetime, 7) = '$date'";
        }
        $sql = "SELECT min(member_product_saving_log_last_balance) as balance
            FROM sys_member_product_saving_log
            WHERE member_product_saving_log_member_product_saving_id = $saving_id
            $where
        ";
        return $this->db->query($sql)->row();
    }

    private function get_data_member_saving($product_id, $min_balance){
        $sql = "SELECT
                member_product_saving_id as id,
                member_product_saving_member_id as member_id,
                member_product_saving_member_code as member_code,
                member_product_saving_member_name as member_name,
                member_product_saving_account_number as account_number,
                member_product_saving_period as 'period',
                member_product_saving_member_balance as balance
            FROM sys_member_product_saving
            WHERE member_product_saving_product_saving_id = $product_id
            AND member_product_saving_member_balance > $min_balance
            AND member_product_saving_is_blocked = 0
            AND member_product_saving_is_active = 1
        ";
        return $this->db->query($sql)->result();
    }

    private function get_data_product_saving($period){
        $sql = "SELECT 
                product_saving_id as id,
                product_saving_code as code,
                product_saving_name as 'name',
                product_saving_name_alias as alias,
                product_saving_deposit_service_percent as percent,
                product_saving_deposit_service_method as method,
                product_saving_deposit_service_min_balance as min_balance,
                product_saving_deposit_service_is_last_balance as is_last_balance,
                IFNULL(json_extract(product_saving_config_json, '$.results'), '[]') AS config_json
            FROM sys_product_saving
            WHERE product_saving_deposit_service_method = $period
        ";

        return $this->db->query($sql)->result();
    }

}

/* End of file Saving_interest.php */
