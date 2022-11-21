<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Labarugi extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    

    public function get_data_get(){
        $month = (string) $this->get('month');

        if(!empty($month) && validate_date(($month))){
            $results = $this->get_laba_rugi($month);

            $data = array(
                'results' => $results,
            );
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Tanggal tidak valid');
        }
    }

    private function get_laba_rugi($month){
        $date = date('Y-m-t', strtotime($month));

        $result = array();

        $sum_pendapatan = 0;
        $sum_biaya = 0;

        $sql_get_pendapatan = "SELECT 
            coa_master_id as id,
            coa_master_parent_id as parent_id,
            coa_master_number as 'number',
            coa_master_title as title,
            coa_master_is_positive as is_positive,
            coa_master_tag as tag
            FROM sys_coa_master
            WHERE coa_master_type = 'pendapatan'
        ";

        $coa_pendapatan = $this->db->query($sql_get_pendapatan)->result();

        $result['pendapatan'] = array();

        foreach ($coa_pendapatan as $row_pen) {
            $sql_get_saldo = "SELECT SUM(ledger_debet) as debet, SUM(ledger_kredit) as kredit
                FROM sys_ledger
                WHERE ledger_coa_master_id = {$row_pen->id}
                AND DATE(ledger_datetime) <= '$date' 
            ";
            $data_saldo = $this->db->query($sql_get_saldo)->row();
            $saldo = $data_saldo->kredit - $data_saldo->debet;
            if($row_pen->is_positive == 1){
                $sum_pendapatan = $sum_pendapatan + $saldo;
            }else{
                $sum_pendapatan = $sum_pendapatan - $saldo;
            }
            $row_pen->balance = $saldo;
            $result['pendapatan'][] = $row_pen;
        }


        $sql_get_biaya = "SELECT 
            coa_master_id as id,
            coa_master_parent_id as parent_id,
            coa_master_number as number,
            coa_master_title as title,
            coa_master_is_positive as is_positive,
            coa_master_tag as tag
            FROM sys_coa_master
            WHERE coa_master_type = 'biaya'
        ";

        $coa_biaya = $this->db->query($sql_get_biaya)->result();

        $result['biaya'] = array();

        foreach ($coa_biaya as $row_biy) {
            $sql_get_saldo = "SELECT SUM(ledger_debet) as debet, SUM(ledger_kredit) as kredit
                FROM sys_ledger
                WHERE ledger_coa_master_id = {$row_biy->id}
                AND DATE(ledger_datetime) <= '$date' 
            ";
            $data_saldo = $this->db->query($sql_get_saldo)->row();
            $saldo = $data_saldo->debet - $data_saldo->kredit;
            if ($row_biy->is_positive == 1) {
                $sum_biaya = $sum_biaya + $saldo;
            } else {
                $sum_biaya = $sum_biaya - $saldo;
            }
            $row_biy->balance = $saldo;
            $result['biaya'][] = $row_biy;
        }

        $result['total_pendapatan'] = $sum_pendapatan;
        $result['total_biaya'] = $sum_biaya;
        $result['total_laba_rugi'] = $sum_pendapatan - $sum_biaya;


        return $result;
    }

}

/* End of file Labarugi.php */
