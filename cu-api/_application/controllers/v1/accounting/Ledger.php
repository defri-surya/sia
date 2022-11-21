<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get(){
        $coa_master_id = (int) $this->get('coa_master_id');
        $start_date = (string) $this->get('start_date');
        $end_date = (string) $this->get('end_date');
        $limit = (int) $this->get('limit') <= 0 ? 10 : (int) $this->get('limit');
        $page = (int) $this->get('page') <= 0 ? 1 : (int) $this->get('page');
        $sort = (string) $this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }
        $start = ($page - 1) * $limit;

        if (validate_date($start_date) && validate_date($end_date)) {
            $results = $this->get_ledger($start_date, $end_date, $coa_master_id, $start, $limit, $sort, $dir);
            $total = (int) $results['count'];

            # -- pagination -- #
            $pagination = page_generate($total, $page, $limit);
            # -- pagination -- #

            $data = array(
                'results' => $results['data'],
                'pagination' => $pagination
            );
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Tanggal tidak valid');
        }
    }

    public function get_summary_get(){
        $coa_master_id = (int) $this->get('coa_master_id');
        $start_date = (string) $this->get('start_date');
        $end_date = (string) $this->get('end_date');

        if(validate_date($start_date) && validate_date($end_date)){
            $results = $this->get_summary($start_date, $end_date, $coa_master_id);

            $data = array(
                'results' => $results,
            );
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Tanggal tidak valid');
        }
    }

    private function get_ledger($start_date, $end_date, $coa_master_id, $start, $limit, $sort, $dir){
        $result_arr = array();
        $query_search = "AND ledger_coa_master_id = $coa_master_id
            AND date(ledger_datetime) >= '$start_date'
            AND date(ledger_datetime) <= '$end_date'";

        $arr_field = array(
            'ledger_trans_number',
            'ledger_trans_number_manually',
            'ledger_note',
            'ledger_debet',
            'ledger_kredit',
            'ledger_datetime',
            'ledger_input_admin_name',
            'ledger_input_admin_username',
        );

        if (!in_array($sort, $arr_field)) {
            $sort = 'ledger_datetime';
        }

        $sql_get = "
            SELECT
                ledger_id,
                ledger_trans_number,
                ledger_trans_number_manually,
                ledger_note,
                ledger_debet,
                ledger_kredit,
                ledger_datetime,
                ledger_input_datetime,
                ledger_input_admin_name,
                ledger_input_admin_username,
                coa_master_id,
                coa_master_number,
                coa_master_title,
                coa_master_type
            FROM sys_ledger
            JOIN sys_coa_master ON ledger_coa_master_id = coa_master_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get)->result_array();

        $result_arr['count'] = $this->count_ladger($query_search);
        $result_arr['data'] = array();

        if(count($result) > 0){
            $dates = array_column($result, 'ledger_datetime');
            $date_start = min($dates);
    
            $sql_sum_before = "SELECT 
                ifnull(sum(ledger_debet), 0) as debet,
                ifnull(sum(ledger_kredit), 0) as kredit
                FROM sys_ledger
                WHERE ledger_coa_master_id = $coa_master_id
                AND ledger_datetime < '$date_start'
            ";
            $before = $this->db->query($sql_sum_before)->row();
    
            $sql_check_coa = "SELECT coa_master_type as 'type', coa_master_is_positive as is_positive FROM sys_coa_master WHERE coa_master_id = $coa_master_id";
            $coa = $this->db->query($sql_check_coa)->row();
            $type = $coa->type;
    
            $start_balance = $this->get_sum_by_coa($before->debet, $before->kredit, $type);
            
            foreach ($result as $row) {
                $start_balance = $start_balance + $this->get_sum_by_coa($row['ledger_debet'], $row['ledger_kredit'], $type);
                $row['accumulative_balance'] = $start_balance;
                $row['ledger_kredit'] = (int)$row['ledger_kredit'];
                $row['ledger_debet'] = (int)$row['ledger_debet'];
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }

        return $result_arr;
    }

    private function count_ladger($query_search = ''){
        $total = 0;

        $sql_total = "
            SELECT COUNT(ledger_id) as total
            FROM sys_ledger
            JOIN sys_coa_master ON ledger_coa_master_id = coa_master_id
            WHERE 0=0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    private function get_summary($start_date, $end_date, $coa_master_id){

        $sql_check_coa = "SELECT coa_master_type as 'type', coa_master_is_positive as is_positive FROM sys_coa_master WHERE coa_master_id = $coa_master_id";
        $coa = $this->db->query($sql_check_coa)->row();
        $type = $coa->type;

        $sql_sum_before = "SELECT 
            ifnull(sum(ledger_debet), 0) as debet,
            ifnull(sum(ledger_kredit), 0) as kredit
            FROM sys_ledger
            WHERE ledger_coa_master_id = $coa_master_id
            AND date(ledger_datetime) < '$start_date'
        ";
        $before = $this->db->query($sql_sum_before)->row();

        $saldo_before = $this->get_sum_by_coa($before->debet, $before->kredit, $type);

        $sql_sum_period = "SELECT 
            ifnull(sum(ledger_debet), 0) as debet,
            ifnull(sum(ledger_kredit), 0) as kredit
            FROM sys_ledger
            WHERE ledger_coa_master_id = $coa_master_id
            AND date(ledger_datetime) >= '$start_date'
            AND date(ledger_datetime) <= '$end_date'
        ";
        $period = $this->db->query($sql_sum_period)->row();

        $saldo_period = $saldo_before + $this->get_sum_by_coa($period->debet, $period->kredit, $type);

        return array(
            'start_balance' => $saldo_before,
            'sum_debet' => (int)$period->debet,
            'sum_kredit' => (int)$period->kredit,
            'end_balance' => $saldo_period,
        );
    }

    private function get_sum_by_coa($debet, $kredit, $type){
        if($type == 'aktiva' || $type == 'biaya'){
            return $debet - $kredit;
        }else if($type == 'pasiva' || $type == 'pendapatan'){
            return $kredit - $debet;
        }
        return 0;
    }
}

/* End of file Ledger.php */
