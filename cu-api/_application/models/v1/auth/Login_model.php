<?php

class Login_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_data_administrator_by_username($username)
    {
        $sql = "
            SELECT * 
            FROM sys_administrator 
            INNER JOIN sys_administrator_group ON administrator_group_id = administrator_administrator_group_id 
            WHERE administrator_username = '" . $username . "' 
        ";
        return $this->db->query($sql);
    }

    function get_data_administrator_last_login()
    {
        $sql_last_login = "
            SELECT * 
            FROM sys_administrator 
            ORDER BY administrator_last_login DESC 
            LIMIT 1
        ";
        return $this->db->query($sql_last_login);
    }


    function get_data_administrator_menu($group_id, $group_type){

        if($group_type == 'superuser'){
            $sql = "
                SELECT *
                FROM  sys_administrator_menu
            ";
        }else{
            $sql = "
                SELECT 
                    sys_administrator_menu.*, 
                    json_extract(administrator_privilege_action, '$.results') AS administrator_privilege_action 
                FROM sys_administrator_privilege 
                JOIN sys_administrator_menu ON administrator_privilege_administrator_menu_id = administrator_menu_id
                WHERE administrator_privilege_administrator_group_id = $group_id
            ";
        }
        $result = $this->db->query($sql);

        $result_arr = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr[] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;

    }

}