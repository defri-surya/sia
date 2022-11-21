<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Auth_Api_Controller {

    
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

        $results = $this->get_member($start, $limit, $sort, $dir, $filter, $is_export);
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

    private function get_member($start, $limit, $sort, $dir, $filter, $is_export)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_id',
            'member_branch_id',
            'member_code',
            'member_temp_code',
            'member_name',
            'member_identity_number',
            'member_identity_type',
            'member_gender',
            'member_birthdate',
            'member_birthplace',
            'member_status',
            'member_join_datetime',
            'member_registered_date',
            'member_input_admin_name',
            'member_input_datetime',
            'member_is_diksar',
            'member_diksar_date',
            'member_nationality',
            'member_working_in',
            'member_entrance_fee_paid_off',
            'member_entrance_fee_due_date',
            'member_address',
            'member_province',
            'member_city',
            'member_subdistrict',
            'member_kelurahan',
            'member_rt_number',
            'member_rw_number',
            'member_zipcode',
            'member_address_domicile',
            'member_domicile_province',
            'member_domicile_city',
            'member_domicile_subdistrict',
            'member_domicile_kelurahan',
            'member_domicile_rt_number',
            'member_domicile_rw_number',
            'member_domicile_zipcode',
            'member_phone_number',
            'member_mobilephone_number',
            'member_job',
            'member_job_detail',
            'member_average_income',
            'member_last_education',
            'member_religion',
            'member_ethnic_group',
            'member_is_married',
            'member_husband_wife_name',
            'member_child_name',
            'member_mother_name',
            'member_is_registered_others_cu',
            'member_others_cu_name',
            'member_heir_name',
            'member_heir_status',
            'member_signature_filename',
            'member_signature_path',
            'member_photo_filename',
            'member_photo_path',
            'member_identity_filename',
            'member_identity_path',
            'member_school_name',
            'member_class_at_school',
            'member_school_address',
            'member_father_name',
            'member_family_address',
            'member_family_phone_number',
            'member_number_of_siblings',
            'member_residence_status',
            'member_blood_type',
            'member_shirt_size',
            'branch_id',
            'branch_code',
            'branch_name',
            'branch_address',
            'branch_province_name',
            'branch_city_name',
            'branch_subdistrict_name',
            'branch_village_name',
            'branch_zip_code',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'member_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_limit = "LIMIT $start, $limit";
        if ($is_export == 1) {
            $sql_limit = '';
        }

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member
            JOIN sys_member_address ON member_id = member_address_id
            JOIN sys_member_profile ON member_id = member_profile_id
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            $sql_limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_id) as total
            FROM sys_member
            JOIN sys_member_address ON member_id = member_address_id
            JOIN sys_member_profile ON member_id = member_profile_id
            JOIN sys_branch ON branch_id = member_branch_id
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

/* End of file Member.php */
