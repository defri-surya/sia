<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Neraca extends Auth_Api_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get()
    {
        $month = (string) $this->get('month');

        if (!empty($month) && validate_date(($month))) {
            $results = $this->get_neraca($month);

            $data = array(
                'results' => $results,
            );
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Tanggal tidak valid');
        }
    }

    private function get_neraca($month)
    {
        $date = date('Y-m-t', strtotime($month));

        $result = array();

        $sum_aktiva = 0;
        $sum_pasiva = 0;

        $sql_get_aktiva = "SELECT 
            coa_master_id as id,
            coa_master_parent_id as parent_id,
            coa_master_number as 'number',
            coa_master_title as title,
            coa_master_type as 'type',
            coa_master_is_positive as is_positive,
            coa_master_tag as tag
            FROM sys_coa_master
            WHERE coa_master_type = 'aktiva'
            AND coa_master_parent_id = 0
        ";

        $coa_aktiva = $this->db->query($sql_get_aktiva)->result();

        $result['aktiva'] = array();

        foreach ($coa_aktiva as $row_akt) {
            if ($this->check_sub_coa($row_akt->id) > 0) {
                $sub_coa = $this->get_sum_sub_coa($row_akt->id, $date);
                $sum_aktiva = $sum_aktiva + $sub_coa['balance'];
                $row_akt->balance = $sub_coa['balance'];
                $result['aktiva'] = array_merge($result['aktiva'], $sub_coa['data']);
            } else {
                $sql_get_saldo = "SELECT SUM(ledger_debet) as debet, SUM(ledger_kredit) as kredit
                    FROM sys_ledger
                    WHERE ledger_coa_master_id = {$row_akt->id}
                    AND DATE(ledger_datetime) <= '$date' 
                ";
                $data_saldo = $this->db->query($sql_get_saldo)->row();
                $saldo = $data_saldo->debet - $data_saldo->kredit;
                if ($row_akt->is_positive == 1) {
                    $sum_aktiva = $sum_aktiva + $saldo;
                } else {
                    $sum_aktiva = $sum_aktiva - $saldo;
                }
                $row_akt->balance = $saldo;
            }
            // if($saldo > 0){
            $result['aktiva'][] = $row_akt;
            // }
        }

        $sql_get_pasiva = "SELECT 
            coa_master_id as id,
            coa_master_parent_id as parent_id,
            coa_master_number as 'number',
            coa_master_title as title,
            coa_master_type as 'type',
            coa_master_is_positive as is_positive,
            coa_master_tag as tag
            FROM sys_coa_master
            WHERE coa_master_type = 'pasiva'
            AND coa_master_parent_id = 0
        ";

        $coa_pasiva = $this->db->query($sql_get_pasiva)->result();

        $result['pasiva'] = array();

        foreach ($coa_pasiva as $row_pas) {
            if ($this->check_sub_coa($row_pas->id) > 0) {
                $sub_coa = $this->get_sum_sub_coa($row_pas->id, $date);
                $sum_pasiva = $sum_pasiva + $sub_coa['balance'];
                $row_pas->balance = $sub_coa['balance'];
                $result['pasiva'] = array_merge($result['pasiva'], $sub_coa['data']);
            } else {
                $sql_get_saldo = "SELECT SUM(ledger_debet) as debet, SUM(ledger_kredit) as kredit
                    FROM sys_ledger
                    WHERE ledger_coa_master_id = {$row_pas->id}
                    AND DATE(ledger_datetime) <= '$date' 
                ";
                $data_saldo = $this->db->query($sql_get_saldo)->row();
                $saldo = $data_saldo->kredit - $data_saldo->debet;
                if ($row_pas->is_positive == 1) {
                    $sum_pasiva = $sum_pasiva + $saldo;
                } else {
                    $sum_pasiva = $sum_pasiva - $saldo;
                }
                $row_pas->balance = $saldo;
            }
            // if($saldo > 0){
            $result['pasiva'][] = $row_pas;
            // }
        }

        $result['total_aktiva'] = $sum_aktiva;
        $result['total_pasiva'] = $sum_pasiva;

        return $result;
    }

    private function get_sum_sub_coa($coa_id, $date)
    {
        $sql_get_master = "SELECT 
            coa_master_id as id,
            coa_master_parent_id as parent_id,
            coa_master_number as 'number',
            coa_master_title as title,
            coa_master_type as 'type',
            coa_master_is_positive as is_positive,
            coa_master_tag as tag
            FROM sys_coa_master
            WHERE coa_master_parent_id = $coa_id
        ";

        $arr_data = array();

        $coa_master = $this->db->query($sql_get_master)->result();
        $sum_saldo = 0;
        foreach ($coa_master as $row) {

            if ($this->check_sub_coa($row->id) > 0) {
                $sub_coa = $this->get_sum_sub_coa($row->id, $date);
                $sum_saldo = $sum_saldo + $sub_coa['balance'];
                $row->balance = $sub_coa['balance'];
                $arr_data = array_merge($arr_data, $sub_coa['data']);
            } else {
                $sql_get_saldo = "SELECT SUM(ledger_debet) as debet, SUM(ledger_kredit) as kredit
                    FROM sys_ledger
                    WHERE ledger_coa_master_id = {$row->id}
                    AND DATE(ledger_datetime) <= '$date' 
                ";
                $data_saldo = $this->db->query($sql_get_saldo)->row();
                if($row->type == 'aktiva'){
                    $saldo = $data_saldo->debet - $data_saldo->kredit;
                }
                if($row->type == 'pasiva'){
                    $saldo = $data_saldo->kredit - $data_saldo->debet;
                }

                if ($row->is_positive == 1) {
                    $sum_saldo = $sum_saldo + $saldo;
                } else {
                    $sum_saldo = $sum_saldo - $saldo;
                }
                $row->balance = $saldo;
            }
            $arr_data[] = $row;
        }
        return array('data' => $arr_data, 'balance' => $sum_saldo);
    }

    private function check_sub_coa($coa_id)
    {
        $sql_count = "SELECT count(coa_master_id) as jumlah FROM sys_coa_master WHERE coa_master_parent_id = $coa_id";
        return $this->db->query($sql_count)->row('jumlah');
    }

    private function get_laba_rugi($month)
    {
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
            if ($row_pen->is_positive == 1) {
                $sum_pendapatan = $sum_pendapatan + $saldo;
            } else {
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
            $saldo = $data_saldo->kredit - $data_saldo->debet;
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

/* End of file Neraca.php */
