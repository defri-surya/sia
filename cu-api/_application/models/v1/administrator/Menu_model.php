<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_menu($par_id, $start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'administrator_menu_id',
            'administrator_menu_title',
            'administrator_menu_description',
            'administrator_menu_link',
            'administrator_menu_icon',
            'administrator_menu_class',
            'administrator_menu_order_by',
            'administrator_menu_is_active',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'administrator_menu_order_by';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search,
            administrator_menu_par_id,
            IFNULL(json_extract(administrator_menu_action, '$.results'), '[]') AS administrator_menu_action
            FROM sys_administrator_menu
            WHERE administrator_menu_par_id = $par_id
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_menu($par_id, $query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    public function count_menu($par_id, $query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(administrator_menu_id) as total
            FROM sys_administrator_menu
            WHERE administrator_menu_par_id = $par_id
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    public function get_ref_action(){
        $sql = "
            SELECT administrator_menu_ref_action_name as name, 
            administrator_menu_ref_action_title as title
            FROM sys_administrator_menu_ref_action
        ";

        $data = array();
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = array_map("convertNullToString", $row);
            }
        }
        return $data;
    }

    public function get_option_parent(){
        $sql = "
            SELECT administrator_menu_id as id, administrator_menu_title as title
            FROM sys_administrator_menu
            WHERE administrator_menu_par_id = 0
        ";

        $data = array();
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = array_map("convertNullToString", $row);
            }
        }
        return $data;
    }

    public function update_menu_order_by($id, $sort)
    {

        $arr_error['is_error'] = false;
        $arr_error['is_over'] = false;

        $sql_current = "
                    SELECT administrator_menu_par_id, 
                    administrator_menu_order_by 
                    FROM sys_administrator_menu 
                    WHERE administrator_menu_id = '" . $id . "'
                ";

        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();

        $par_id = $row_current->administrator_menu_par_id;
        $order_by = $row_current->administrator_menu_order_by;

        $sql_total = "
                    SELECT COUNT(*) AS row_count 
                    FROM sys_administrator_menu 
                    WHERE administrator_menu_par_id = '" . $par_id . "'
                ";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;

        if (($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT administrator_menu_id, 
                    administrator_menu_order_by 
                    FROM sys_administrator_menu 
                    WHERE administrator_menu_par_id = '" . $par_id . "' 
                    AND administrator_menu_order_by <= " . $order_by . " 
                    AND administrator_menu_id <> '" . $id . "' 
                    ORDER BY administrator_menu_order_by DESC 
                    LIMIT 1
                ";
            } else if ($sort == 'down') {
                $sql = "
                    SELECT administrator_menu_id, 
                    administrator_menu_order_by 
                    FROM sys_administrator_menu 
                    WHERE administrator_menu_par_id = '" . $par_id . "' 
                    AND administrator_menu_order_by >= " . $order_by . " 
                    AND administrator_menu_id <> '" . $id . "' 
                    ORDER BY administrator_menu_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE sys_administrator_menu 
                SET administrator_menu_order_by = '" . $order_by . "' 
                WHERE administrator_menu_id = '" . $row->administrator_menu_id . "'
            ";
            $this->db->query($sql_update);

            if ($this->db->affected_rows() < 0) {
                $arr_error['is_error'] = true;
            }

            $sql_update = "
                UPDATE sys_administrator_menu 
                SET administrator_menu_order_by = '" . $row->administrator_menu_order_by . "' 
                WHERE administrator_menu_id = '" . $id . "'
            ";
            $this->db->query($sql_update);

            if ($this->db->affected_rows() < 0) {
                $arr_error['is_error'] = true;
            }

        } else {
            $arr_error['is_over'] = true;
        }

        return $arr_error;
    }
    

}

/* End of file Menu_model.php */
