<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forfeit extends CI_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        ini_set("memory_limit", -1);
        set_time_limit(0);

        $date = date('Y-m-d');
        // $date = '2019-06-19';

        $sql = "SELECT 
        invoice_loan_id as id,
        invoice_loan_member_id as member_id,
        invoice_loan_member_product_id as member_product_id,
        invoice_loan_product_id as product_id,
        invoice_loan_number as 'number',
        invoice_loan_trans_number as trans_number,
        invoice_loan_period as 'period',
        invoice_loan_date as 'date',
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
        invoice_loan_is_paid_off as is_paid_off,
        invoice_loan_paid_datetime as paid_datetime,
        member_product_forfeit_percent as forfeit_percent
        FROM sys_invoice_loan
        JOIN sys_member_product_loan ON member_product_id = invoice_loan_member_product_id
        WHERE invoice_loan_is_paid_off = 0 AND invoice_loan_forfeit_date <= '$date'";

        $data_invoice = $this->db->query($sql)->result();

        foreach ($data_invoice as $val) {
            print_r($val);
            $type = 'monthly';
            $principal = $val->principal_value - $val->principal_paid;
            if($principal > 0){
                $nominal_denda = $principal * $val->forfeit_percent;
                $date1 = date_create($val->forfeit_date);
                $date2 = date_create($date);
                $diff = date_diff($date1, $date2);
                if($type == 'monthly'){
                    $ke = $diff->format("%m") + 1;
                    if(!$this->check_denda_armot_detail($val->member_product_id, $val->period, $ke)){
                        $armot_detail = array();
                        $armot_detail['denda_detail_product_member_id'] = $val->member_product_id;
                        $armot_detail['denda_detail_periode'] = $val->period;
                        $armot_detail['denda_detail_ke'] = $ke;
                        $armot_detail['denda_detail_type'] = 1;
                        $armot_detail['denda_detail_nominal'] = $nominal_denda;
                        $armot_detail['denda_detail_input_date'] = $date;

                        $this->db->insert('denda_armot_detail', $armot_detail);
                        if($this->check_denda_armot($val->member_product_id)){
                            // update
                            $sql_update = "UPDATE denda_armot SET denda_total = (SELECT sum(denda_detail_nominal) FROM denda_armot_detail WHERE denda_detail_product_member_id = {$val->member_product_id}) WHERE denda_product_member_id = {$val->member_product_id}";
                            $this->db->query($sql_update);
                        }else{
                            // insert
                            $armot = array();
                            $armot['denda_product_member_id'] = $val->member_product_id;
                            $armot['denda_total'] = $nominal_denda;
                            $armot['denda_total_terbayar'] = 0;
                            $armot['denda_total_pemutihan'] = 0;
                            $armot['denda_note'] = 'Note belum tau';
                            $this->db->insert('denda_armot', $armot);
                        }
                        $sql_update_invoice = "UPDATE sys_invoice_loan SET invoice_loan_forfeit_value = (SELECT sum(denda_detail_nominal) FROM denda_armot_detail WHERE denda_detail_product_member_id = {$val->member_product_id} AND denda_detail_periode = {$val->period}) WHERE invoice_loan_id = {$val->id}";
                        $this->db->query($sql_update_invoice);
                        $sql_update_total = "UPDATE sys_invoice_loan SET invoice_loan_total_value = invoice_loan_forfeit_value + invoice_loan_principal_value + invoice_loan_interest_value WHERE invoice_loan_id = {$val->id}";
                        $this->db->query($sql_update_total);
                    }
                }else{
                    $ke = $diff->format("%d") + 1;
                    if (!$this->check_denda_armot_detail($val->member_product_id, $val->period, $ke)) {
                        $armot_detail = array();
                        $armot_detail['denda_detail_product_member_id'] = $val->member_product_id;
                        $armot_detail['denda_detail_periode'] = $val->period;
                        $armot_detail['denda_detail_ke'] = $ke;
                        $armot_detail['denda_detail_type'] = 0;
                        $armot_detail['denda_detail_nominal'] = $nominal_denda;
                        $armot_detail['denda_detail_input_date'] = $date;

                        $this->db->insert('denda_armot_detail', $armot_detail);
                        if ($this->check_denda_armot($val->member_product_id)) {
                            // update
                            $sql_update = "UPDATE denda_armot SET denda_total = (SELECT sum(denda_detail_nominal) FROM denda_armot_detail WHERE denda_detail_product_member_id = {$val->member_product_id}) WHERE denda_product_member_id = {$val->member_product_id}";
                            $this->db->query($sql_update);
                        } else {
                            // insert
                            $armot = array();
                            $armot['denda_product_member_id'] = $val->member_product_id;
                            $armot['denda_total'] = $nominal_denda;
                            $armot['denda_total_terbayar'] = 0;
                            $armot['denda_total_pemutihan'] = 0;
                            $armot['denda_note'] = 'Note belum tau';
                            $this->db->insert('denda_armot', $armot);
                        }
                        $sql_update_invoice = "UPDATE sys_invoice_loan SET invoice_loan_forfeit_value = (SELECT sum(denda_detail_nominal) FROM denda_armot_detail WHERE denda_detail_product_member_id = {$val->member_product_id} AND denda_detail_periode = {$val->period}) WHERE invoice_loan_id = {$val->id}";
                        $this->db->query($sql_update_invoice);
                        $sql_update_total = "UPDATE sys_invoice_loan SET invoice_loan_total_value = invoice_loan_forfeit_value + invoice_loan_principal_value + invoice_loan_interest_value WHERE invoice_loan_id = {$val->id}";
                        $this->db->query($sql_update_total);
                    }
                }
            }
        }
    }

    private function check_denda_armot($member_product_id){
        $sql = "SELECT count(denda_id) as jumlah FROM denda_armot WHERE denda_product_member_id = $member_product_id";
        return $this->db->query($sql)->row('jumlah') == 0 ? false : true;
    }

    private function check_denda_armot_detail($member_product_id, $period,  $ke){
        $sql = "SELECT count(denda_detail_id) as jumlah FROM denda_armot_detail WHERE denda_detail_product_member_id = $member_product_id AND denda_detail_periode = $period AND denda_detail_ke = $ke";
        return $this->db->query($sql)->row('jumlah') == 0 ? false : true;
    }


}

/* End of file Forfeit.php */
