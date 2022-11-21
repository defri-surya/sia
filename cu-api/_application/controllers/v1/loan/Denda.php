<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Denda extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function get_data_denda_get()
    {
        $limit = (int) $this->get('limit') <= 0 ? 10 : (int) $this->get('limit');
        $page = (int) $this->get('page') <= 0 ? 1 : (int) $this->get('page');
        $filter = (array) $this->get('filter');
        $sort = (string) $this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_denda_armot($start, $limit, $sort, $dir, $filter);
        $total = (int) $results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    private function get_denda_armot($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'denda_id',
            'denda_product_member_id',
            'denda_total',
            'denda_total_terbayar',
            'denda_total_pemutihan',
            'denda_note',
            'member_product_member_id',
            'member_product_product_loan_name',
            'member_product_product_loan_name_alias',
            'member_product_code',
            'member_product_plafon',
            'member_product_plafon_balance',
            'member_product_tenor',
            'member_code',
            'member_temp_code',
            'member_name',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'denda_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM denda_armot
            JOIN sys_member_product_loan ON denda_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_denda_armot($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_denda_armot($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(denda_id) as total
            FROM denda_armot
            JOIN sys_member_product_loan ON denda_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0 = 0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    public function get_data_denda_detail_get()
    {
        $limit = (int) $this->get('limit') <= 0 ? 10 : (int) $this->get('limit');
        $page = (int) $this->get('page') <= 0 ? 1 : (int) $this->get('page');
        $filter = (array) $this->get('filter');
        $sort = (string) $this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_denda_armot_detail($start, $limit, $sort, $dir, $filter);
        $total = (int) $results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    private function get_denda_armot_detail($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'denda_detail_id',
            'denda_detail_product_member_id',
            'denda_detail_periode',
            'denda_detail_ke',
            'denda_detail_type',
            'denda_detail_nominal',
            'denda_detail_input_date',
            'member_product_member_id',
            'member_product_product_loan_name',
            'member_product_product_loan_name_alias',
            'member_product_code',
            'member_product_plafon',
            'member_product_plafon_balance',
            'member_product_tenor',
            'member_code',
            'member_temp_code',
            'member_name',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'denda_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM denda_armot_detail
            JOIN sys_member_product_loan ON denda_detail_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_denda_armot_detail($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_denda_armot_detail($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(denda_detail_id) as total
            FROM denda_armot_detail
            JOIN sys_member_product_loan ON denda_detail_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0 = 0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }


    public function get_data_denda_terbayar_get()
    {
        $limit = (int) $this->get('limit') <= 0 ? 10 : (int) $this->get('limit');
        $page = (int) $this->get('page') <= 0 ? 1 : (int) $this->get('page');
        $filter = (array) $this->get('filter');
        $sort = (string) $this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_denda_armot_terbayar($start, $limit, $sort, $dir, $filter);
        $total = (int) $results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    private function get_denda_armot_terbayar($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'denda_terbayar_id',
            'denda_terbayar_product_member_id',
            'denda_terbayar_admin_id',
            'denda_terbayar_nominal',
            'denda_terbayar_nominal_cash',
            'denda_terbayar_nominal_bank',
            'denda_terbayar_nominal_titipan',
            'denda_terbayar_nominal_affiliasi_hc',
            'denda_terbayar_nominal_kas_besar',
            'denda_no_bukti_manual',
            'denda_no_bukti_system',
            'denda_note',
            'denda_terbayar_input_datetime',
            'denda_terbayar_paid_datetime',
            'member_product_member_id',
            'member_product_product_loan_name',
            'member_product_product_loan_name_alias',
            'member_product_code',
            'member_product_plafon',
            'member_product_plafon_balance',
            'member_product_tenor',
            'member_code',
            'member_temp_code',
            'member_name',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'denda_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM denda_armot_terbayar
            JOIN sys_member_product_loan ON denda_terbayar_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_denda_armot_terbayar($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_denda_armot_terbayar($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(denda_id) as total
            FROM denda_armot_terbayar
            JOIN sys_member_product_loan ON denda_terbayar_product_member_id = member_product_id
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0 = 0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

}

/* End of file Denda.php */
