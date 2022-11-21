<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debt extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_option_year_get(){
        $sql_get = "SELECT DISTINCT YEAR(rep_hutang_piutang_month_year) as 'year' FROM rep_hutang_piutang";
        $data = $this->db->query($sql_get)->result();

        $res = array(
            'results' => empty($data) ? array(date('Y')) : $data
        );
        $this->createResponse(REST_Controller::HTTP_OK, $res);

    }

    public function get_data_get()
    {
        $limit = (integer)$this->get('limit') <= 0 ? 10 : (integer)$this->get('limit');
        $page = (integer)$this->get('page') <= 0 ? 1 : (integer)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_lhk($start, $limit, $sort, $dir, $filter);
        $total = (integer)$results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    private function get_lhk($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'rep_hutang_piutang_id',
            'rep_hutang_piutang_member_id',
            'rep_hutang_piutang_member_name',
            'rep_hutang_piutang_member_code',
            'rep_hutang_piutang_piutang_value',
            'rep_hutang_piutang_hutang_value',
            'rep_hutang_piutang_month_year',
            'rep_hutang_piutang_last_updated',
            'rep_hutang_piutang_kolektibilitas',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'rep_hutang_piutang_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM rep_hutang_piutang
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_lhk($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_lhk($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(rep_hutang_piutang_id) as total
            FROM rep_hutang_piutang
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
    

}

/* End of file Debt.php */
