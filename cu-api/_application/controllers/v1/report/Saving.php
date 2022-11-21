<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Saving extends Auth_Api_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
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
        $is_export = (integer)$this->get('export');
        if ($is_export != 0 && $is_export != 1) {
            $is_export = 0;
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_saving($start, $limit, $sort, $dir, $filter, $is_export);
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

    private function get_saving($start, $limit, $sort, $dir, $filter, $is_export)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_product_saving_id',
            'member_product_saving_member_id',
            'member_product_saving_member_code',
            'member_product_saving_member_name',
            'member_product_saving_account_number',
            'member_product_saving_member_balance',
            'member_product_saving_product_saving_id',
            'member_product_saving_name',
            'member_product_saving_name_alias',
            'member_product_saving_period',
            'member_product_saving_is_blocked',
            'member_product_saving_is_active',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'member_product_saving_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_limit = "LIMIT $start, $limit";
        if ($is_export == 1) {
            $sql_limit = '';
        }

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member_product_saving
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            $sql_limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_saving($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_saving($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_product_saving_id) as total
            FROM sys_member_product_saving
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

/* End of file Saving.php */
