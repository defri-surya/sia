<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function province_get()
    {
        $province_id = (string)(isset($_GET['province_id']) ? $_GET['province_id'] : '');

        $sql_where = '';
        if ($province_id != '') {
            $sql_where = 'WHERE province_id = ' . $province_id;
        }

        $sql_get = "
            SELECT 
                province_id, province_name
            FROM ref_province
            $sql_where
        ";

        $query = $this->db->query($sql_get);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK,  $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function city_get()
    {
        $province_id = (string)(isset($_GET['province_id']) ? $_GET['province_id'] : '');

        $sql_where = '';
        if ($province_id != '') {
            $sql_where = 'WHERE city_province_id = ' . $province_id;
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }

        $sql_get = "
            SELECT 
                city_id, city_name
            FROM ref_city
            $sql_where
        ";

        $query = $this->db->query($sql_get);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK,  $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function subdistrict_get()
    {
        $city_id = (string)(isset($_GET['city_id']) ? $_GET['city_id'] : '');

        $sql_where = '';
        if ($city_id != '') {
            $sql_where = 'WHERE subdistrict_city_id = ' . $city_id;
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }

        $sql_get = "
            SELECT 
                subdistrict_id, subdistrict_name
            FROM ref_subdistrict
            $sql_where
        ";

        $query = $this->db->query($sql_get);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function village_get()
    {
        $subdistrict_id = (string)(isset($_GET['subdistrict_id']) ? $_GET['subdistrict_id'] : '');

        $sql_where = '';
        if ($subdistrict_id != '') {
            $sql_where = 'WHERE village_subdistrict_id = ' . $subdistrict_id;
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }

        $sql_get = "
            SELECT 
                village_id, village_name
            FROM ref_village
            $sql_where
        ";

        $query = $this->db->query($sql_get);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function branch_get()
    {
        $id = $this->input->get('id');
        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT branch_id, branch_code, branch_name
                FROM sys_branch
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $result = array(
                    'results' => $query->result_array()
                );
                $this->createResponse(REST_Controller::HTTP_OK, $result);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    function group_list_get()
    {
        $where = "";
        if ($this->get_user('user_auth_type') != 'superuser') {
            $where .= " AND administrator_group_type != 'superuser'";
        }
        $sql = "
        SELECT administrator_group_id, administrator_group_title, administrator_group_type
        FROM sys_administrator_group
        WHERE administrator_group_is_active = 1 $where
        ORDER BY administrator_group_title ASC
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    function admin_list_get()
    {
        $where = "";
        $exclude = $this->get('exclude');

        if(!empty($exclude)){
            $exclude = explode(',', $exclude);
            for ($q = 0; $q < count($exclude); $q++) {
                $exclude[$q] = "'" . $exclude[$q] . "'";
            }
            $value = implode(',', $exclude);
            $where = "AND administrator_id NOT IN ({$value})";
        }

        $sql = "
            SELECT administrator_id as id, administrator_name as name, administrator_username as username
            FROM sys_administrator
            WHERE administrator_is_active = 1 $where
            ORDER BY administrator_name ASC
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    function coa_master_get()
    {
        $where = "";
        $exclude = $this->get('exclude');

        if(!empty($exclude)){
            $exclude = explode(',', $exclude);
            for ($q = 0; $q < count($exclude); $q++) {
                $exclude[$q] = "'" . $exclude[$q] . "'";
            }
            $value = implode(',', $exclude);
            $where = "AND coa_master_id NOT IN ({$value})";
        }

        $sql = "SELECT coa_master_id as id, coa_master_number as 'number', coa_master_title as title
            FROM sys_coa_master
            WHERE 0=0 $where
            ORDER BY coa_master_id ASC
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function code_get()
    {
        $arr_table = array(
            'sys_branch',
            'sys_coa_master',
            'sys_product_saving',
            'sys_product_loan',
            'sys_member',
            'sys_member_product_saving',
        );

        $arr_field = array(
            'branch_code',
            'coa_master_code',
            'product_saving_code',
            'product_loan_code',
            'member_code',
            'member_product_account_number',
        );

        $code = '';

        $table = $this->get('table');
        $field = $this->get('field');

        $key_table = array_search($table, $arr_table);
        $key_field = array_search($field, $arr_field);

        if($key_field === $key_table && is_numeric($key_field) && is_numeric($key_table)){
            $code = $this->common_model->generate_code($table, $field);
        }

        if (!empty($code)) {
            $this->createResponse(REST_Controller::HTTP_OK, $code);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan Kode Unit.');
        }
    }

    public function product_saving_get()
    {
        $sql = "
            SELECT product_saving_id, product_saving_code, product_saving_name, product_saving_initial_deposit_value, product_saving_is_period
            FROM sys_product_saving
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }

    public function product_loan_get()
    {
        $sql = "
            SELECT product_loan_id, product_loan_code, product_loan_name, product_loan_name_alias
            FROM sys_product_loan
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = array(
                'results' => $query->result_array()
            );
            $this->createResponse(REST_Controller::HTTP_OK, $result);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data Tidak Ditemukan!');
        }
    }


}

/* End of file Option.php */
