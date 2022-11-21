<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lkh extends Auth_Api_Controller {

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
            'transaction_id',
            'transaction_member_id',
            'member_name',
            'member_code',
            'member_temp_code',
            'transaction_product_saving_id',
            'transaction_product_loan_id',
            'transaction_balance_log_id',
            'transaction_debet',
            'transaction_kredit',
            'transaction_note',
            'transaction_input_datetime',
            'transaction_datetime',
            'transaction_administrator_id',
            'transaction_administrator_name',
            'transaction_administrator_username',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'transaction_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_transaction
            JOIN sys_member ON transaction_member_id = member_id
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
            SELECT COUNT(member_id) as total
            FROM sys_transaction
            JOIN sys_member ON transaction_member_id = member_id
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

/* End of file Lkh.php */
