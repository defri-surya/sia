<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function get_group($start, $limit, $sort, $dir, $filter = null, $user_auth_type)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'administrator_group_id',
            'administrator_group_company_id',
            'administrator_group_branch_id',
            'administrator_group_title',
            'administrator_group_type',
            'administrator_group_is_active',
            'company_title',
            'branch_name'
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'administrator_group_id';
        }

        $where_detail = '0=0';
        if ($user_auth_type != 'superuser') {
            $where_detail = " administrator_group_type != 'superuser'";
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_administrator_group
            JOIN sys_company ON company_id = administrator_group_company_id
            LEFT JOIN sys_branch ON branch_id = administrator_group_branch_id
            WHERE $where_detail
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_group($where_detail, $query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    public function count_group($where_detail, $query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(administrator_group_id) as total
            FROM sys_administrator_group
            JOIN sys_company ON company_id = administrator_group_company_id
            LEFT JOIN sys_branch ON branch_id = administrator_group_branch_id
            WHERE $where_detail
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    public function get_group_list_privilege($id){
        $sql = "
        SELECT administrator_menu_id,
        administrator_privilege_action,
        json_extract(administrator_privilege_action, '$.results') AS results 
        FROM sys_administrator_privilege
        INNER JOIN sys_administrator_menu ON administrator_menu_id = administrator_privilege_administrator_menu_id
        WHERE administrator_privilege_administrator_group_id = '" . $id . "'
        ";
        return $this->db->query($sql)->result();
    }

    function get_group_detail($id, $user_auth_type = 'administrator')
    {
        $where = "";
        if ($user_auth_type != 'superuser') {
            $where = "AND administrator_group_type != 'superuser'";
        }
        $sql = "
            SELECT administrator_group_id, administrator_group_company_id, administrator_group_branch_id, administrator_group_title, administrator_group_type, administrator_group_is_active 
            FROM sys_administrator_group 
            WHERE administrator_group_id = $id $where
        ";
        return $this->db->query($sql)->row();
    }
    
    function get_superuser_menu()
    {
        $sql = "
            SELECT sys_administrator_menu.*,
            IFNULL(json_extract(administrator_menu_action, '$.results'), '[]') AS results 
            FROM sys_administrator_menu
            WHERE administrator_menu_is_active = '1'
            ORDER BY administrator_menu_order_by ASC
        ";
        return $this->db->query($sql);
    }
    
    function get_administrator_menu($administrator_group_id = 0)
    {
        $sql = "
            SELECT sys_administrator_menu.*,
            json_extract(administrator_menu_action, '$.results') AS results,
            administrator_privilege_action
            FROM sys_administrator_menu
            INNER JOIN sys_administrator_privilege ON administrator_menu_id = administrator_privilege_administrator_menu_id
            WHERE administrator_menu_is_active = '1'
            AND administrator_privilege_administrator_group_id = '" . $administrator_group_id . "'
            ORDER BY administrator_menu_order_by ASC
        ";
        return $this->db->query($sql);
    }

}

/* End of file Group_model.php */
