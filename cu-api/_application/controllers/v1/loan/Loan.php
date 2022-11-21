<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends Auth_Api_Controller {

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

        $start = ($page - 1) * $limit;

        $results = $this->get_member_product_loan($start, $limit, $sort, $dir, $filter);
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

    private function get_member_product_loan($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_product_id',
            'member_product_member_id',
            'member_product_product_loan_id',
            'member_product_product_loan_name',
            'member_product_product_loan_name_alias',
            'member_product_code',
            'member_product_plafon',
            'member_product_plafon_balance',
            'member_product_tenor',
            'member_product_service_percent',
            'member_product_service_loan_percent1',
            'member_product_service_loan_percent2',
            'member_product_forfeit_percent',
            'member_product_interest_percent',
            'member_product_interest_type',
            'member_product_collateral_type',
            'member_product_is_daperma',
            'member_product_disbursement_date',
            'member_product_due_date',
            'member_code',
            'member_name',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'member_product_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member_product_loan
            JOIN sys_member ON member_product_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member_product_loan($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member_product_loan($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_product_id) as total
            FROM sys_member_product_loan
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

/* End of file Loan.php */
