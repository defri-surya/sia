<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kader extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("membership/kader_list_view", $data);
        $this->template->show('template');
    }
    
    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_is_pic",
            "value" => "1",
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = array();

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openDetail(' . $row->member_id . ', \'' . $row->member_name . '\')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';

                $entry = array('id' => $row->member_id,
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_pic_area' => $row->member_pic_area,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_birthplace' => $row->member_birthplace,
                        'member_address' => $row->member_address,
                        'member_province' => $row->member_province,
                        'member_city' => $row->member_city,
                        'member_subdistrict' => $row->member_subdistrict,
                        'member_kelurahan' => $row->member_kelurahan,
                        'member_rt_number' => $row->member_rt_number,
                        'member_rw_number' => $row->member_rw_number,
                        'member_zipcode' => $row->member_zipcode,
                        'member_address_domicile' => $row->member_address_domicile,
                        'member_domicile_province' => $row->member_domicile_province,
                        'member_domicile_city' => $row->member_domicile_city,
                        'member_domicile_subdistrict' => $row->member_domicile_subdistrict,
                        'member_domicile_kelurahan' => $row->member_domicile_kelurahan,
                        'member_domicile_rt_number' => $row->member_domicile_rt_number,
                        'member_domicile_rw_number' => $row->member_domicile_rw_number,
                        'member_domicile_zipcode' => $row->member_domicile_zipcode,
                        'member_nationality' => NATIONALITY[$row->member_nationality],
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_job_detail' => $row->member_job_detail,
                        'member_average_income' => AVERAGE_INCOME[$row->member_average_income],
                        'member_last_education' => LAST_EDUCATION[$row->member_last_education],
                        'member_religion' => RELIGION[$row->member_religion],
                        'member_is_married' => IS_MARRIED[$row->member_is_married],
                        'member_husband_wife_name' => $row->member_husband_wife_name,
                        'member_child_name' => $row->member_child_name,
                        'member_mother_name' => $row->member_mother_name,
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_is_registered_others_cu' => $row->member_is_registered_others_cu,
                        'member_others_cu_name' => $row->member_others_cu_name,
                        'member_heir_name' => $row->member_heir_name,
                        'member_heir_status' => $row->member_heir_status,
                        'member_join_datetime' => convert_datetime($row->member_join_datetime),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'branch_name' => $row->branch_name,
                        'member_working_in' => WORKING_IN[$row->member_working_in],
                        'member_ethnic_group' => $row->member_ethnic_group,
                        'member_residence_status' => RESIDENCE_STATUS[$row->member_residence_status],
                        'member_blood_type' => BLOOD_TYPE[$row->member_blood_type],
                        'member_shirt_size' => SHIRT_SIZE[$row->member_shirt_size],
                        'detail' => $detail,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function get_data_detail() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_kader_id = $this->input->post('member_kader_id');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_pic_member_id",
            "value" => $member_kader_id,
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = array();

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );

            foreach ($results as $row) {
                
                $entry = array('id' => $row->member_id,
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_birthplace' => $row->member_birthplace,
                        'member_address' => $row->member_address,
                        'member_province' => $row->member_province,
                        'member_city' => $row->member_city,
                        'member_subdistrict' => $row->member_subdistrict,
                        'member_kelurahan' => $row->member_kelurahan,
                        'member_rt_number' => $row->member_rt_number,
                        'member_rw_number' => $row->member_rw_number,
                        'member_zipcode' => $row->member_zipcode,
                        'member_address_domicile' => $row->member_address_domicile,
                        'member_domicile_province' => $row->member_domicile_province,
                        'member_domicile_city' => $row->member_domicile_city,
                        'member_domicile_subdistrict' => $row->member_domicile_subdistrict,
                        'member_domicile_kelurahan' => $row->member_domicile_kelurahan,
                        'member_domicile_rt_number' => $row->member_domicile_rt_number,
                        'member_domicile_rw_number' => $row->member_domicile_rw_number,
                        'member_domicile_zipcode' => $row->member_domicile_zipcode,
                        'member_nationality' => NATIONALITY[$row->member_nationality],
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_job_detail' => $row->member_job_detail,
                        'member_average_income' => AVERAGE_INCOME[$row->member_average_income],
                        'member_last_education' => LAST_EDUCATION[$row->member_last_education],
                        'member_religion' => RELIGION[$row->member_religion],
                        'member_is_married' => IS_MARRIED[$row->member_is_married],
                        'member_husband_wife_name' => $row->member_husband_wife_name,
                        'member_child_name' => $row->member_child_name,
                        'member_mother_name' => $row->member_mother_name,
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_is_registered_others_cu' => $row->member_is_registered_others_cu,
                        'member_others_cu_name' => $row->member_others_cu_name,
                        'member_heir_name' => $row->member_heir_name,
                        'member_heir_status' => $row->member_heir_status,
                        'member_join_datetime' => convert_datetime($row->member_join_datetime),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'branch_name' => $row->branch_name,
                        'member_working_in' => WORKING_IN[$row->member_working_in],
                        'member_ethnic_group' => $row->member_ethnic_group,
                        'member_residence_status' => RESIDENCE_STATUS[$row->member_residence_status],
                        'member_blood_type' => BLOOD_TYPE[$row->member_blood_type],
                        'member_shirt_size' => SHIRT_SIZE[$row->member_shirt_size],
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function get_data_kader() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $except_kader = $this->input->post('except_kader');
        $except_member = json_decode($this->input->post('except_member'));
        
        $arr_except = array();
        if(is_numeric($except_kader) && $except_kader > 0){
            $arr_except[] = $except_kader;
        }
        
        if(is_array($except_member) && count($except_member) > 0){
            foreach ($except_member as $value) {
                $arr_except[] = $value->id;
            }
        }

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_is_pic",
            "value" => "0",
            "comparison" => "="
        ));
        
        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_pic_member_id",
            "value" => "0",
            "comparison" => "="
        ));

        if (count($arr_except) > 0) {
            array_push($filter, array(
                "type" => "list",
                "field" => "member_id",
                "value" => count($arr_except) == 1 ? implode("::", $arr_except) . "::" : implode('::', $arr_except),
                "comparison" => "no"
            ));
        }

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = array();

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );

            $countIndex = 1;
            foreach ($results as $row) {

                $data_id = array(
                    'id' => $row->member_id,
                    'code' => $row->member_code,
                    'temp_code' => $row->member_temp_code,
                    'name' => $row->member_name
                );

                $entry = array('id' => json_encode($data_id),
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_birthplace' => $row->member_birthplace,
                        'member_address' => $row->member_address,
                        'member_province' => $row->member_province,
                        'member_city' => $row->member_city,
                        'member_subdistrict' => $row->member_subdistrict,
                        'member_kelurahan' => $row->member_kelurahan,
                        'member_rt_number' => $row->member_rt_number,
                        'member_rw_number' => $row->member_rw_number,
                        'member_zipcode' => $row->member_zipcode,
                        'member_address_domicile' => $row->member_address_domicile,
                        'member_domicile_province' => $row->member_domicile_province,
                        'member_domicile_city' => $row->member_domicile_city,
                        'member_domicile_subdistrict' => $row->member_domicile_subdistrict,
                        'member_domicile_kelurahan' => $row->member_domicile_kelurahan,
                        'member_domicile_rt_number' => $row->member_domicile_rt_number,
                        'member_domicile_rw_number' => $row->member_domicile_rw_number,
                        'member_domicile_zipcode' => $row->member_domicile_zipcode,
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_average_income' => AVERAGE_INCOME[$row->member_average_income],
                        'member_last_education' => LAST_EDUCATION[$row->member_last_education],
                        'member_religion' => RELIGION[$row->member_religion],
                        'member_is_married' => IS_MARRIED[$row->member_is_married],
                        'member_husband_wife_name' => $row->member_husband_wife_name,
                        'member_child_name' => $row->member_child_name,
                        'member_mother_name' => $row->member_mother_name,
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_is_registered_others_cu' => $row->member_is_registered_others_cu,
                        'member_others_cu_name' => $row->member_others_cu_name,
                        'member_heir_name' => $row->member_heir_name,
                        'member_heir_status' => $row->member_heir_status,
                        'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'branch_name' => $row->branch_name,
                    ),
                );

                $json_data['rows'][] = $entry;
                $countIndex++;
            }
        }
        echo json_encode($json_data);
    }
    
    public function get_data_member() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $except_kader = $this->input->post('except_kader');
        $except_member = json_decode($this->input->post('except_member'));
        
        $arr_except = array();
        if(is_numeric($except_kader) && $except_kader > 0){
            $arr_except[] = $except_kader;
        }
        
        if(is_array($except_member) && count($except_member) > 0){
            foreach ($except_member as $value) {
                $arr_except[] = $value->id;
            }
        }

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_is_pic",
            "value" => "0",
            "comparison" => "="
        ));
        
        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_pic_member_id",
            "value" => "0",
            "comparison" => "="
        ));

        if (count($arr_except) > 0) {
            array_push($filter, array(
                "type" => "list",
                "field" => "member_id",
                "value" => count($arr_except) == 1 ? implode("::", $arr_except) . "::" : implode('::', $arr_except),
                "comparison" => "no"
            ));
        }

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = array();

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );

            $countIndex = 1;
            foreach ($results as $row) {

                $data_id = array(
                    'id' => $row->member_id,
                    'code' => $row->member_code,
                    'temp_code' => $row->member_temp_code,
                    'name' => $row->member_name
                );

                $entry = array('id' => json_encode($data_id),
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_birthplace' => $row->member_birthplace,
                        'member_address' => $row->member_address,
                        'member_province' => $row->member_province,
                        'member_city' => $row->member_city,
                        'member_subdistrict' => $row->member_subdistrict,
                        'member_kelurahan' => $row->member_kelurahan,
                        'member_rt_number' => $row->member_rt_number,
                        'member_rw_number' => $row->member_rw_number,
                        'member_zipcode' => $row->member_zipcode,
                        'member_address_domicile' => $row->member_address_domicile,
                        'member_domicile_province' => $row->member_domicile_province,
                        'member_domicile_city' => $row->member_domicile_city,
                        'member_domicile_subdistrict' => $row->member_domicile_subdistrict,
                        'member_domicile_kelurahan' => $row->member_domicile_kelurahan,
                        'member_domicile_rt_number' => $row->member_domicile_rt_number,
                        'member_domicile_rw_number' => $row->member_domicile_rw_number,
                        'member_domicile_zipcode' => $row->member_domicile_zipcode,
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_average_income' => AVERAGE_INCOME[$row->member_average_income],
                        'member_last_education' => LAST_EDUCATION[$row->member_last_education],
                        'member_religion' => RELIGION[$row->member_religion],
                        'member_is_married' => IS_MARRIED[$row->member_is_married],
                        'member_husband_wife_name' => $row->member_husband_wife_name,
                        'member_child_name' => $row->member_child_name,
                        'member_mother_name' => $row->member_mother_name,
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_is_registered_others_cu' => $row->member_is_registered_others_cu,
                        'member_others_cu_name' => $row->member_others_cu_name,
                        'member_heir_name' => $row->member_heir_name,
                        'member_heir_status' => $row->member_heir_status,
                        'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'branch_name' => $row->branch_name,
                    ),
                );

                $json_data['rows'][] = $entry;
                $countIndex++;
            }
        }
        echo json_encode($json_data);
    }
    
    function act_add() {
        $arr_member_id = array();
        $arr_member = json_decode($_POST['arr_member']);
        if(is_array($arr_member) && count($arr_member) > 0){
            foreach ($arr_member as $value) {
                $arr_member_id[] = $value->id;
            }
        }
        $_POST['arr_member'] = json_encode($arr_member_id);
        $res = $this->curl->post(URL_API . 'membership/kader/act_add', $this->input->post());
        echo $res;
    }
    
    function act_update() {
        $arr_member_id = array();
        $arr_member = json_decode($_POST['arr_member']);
        if(is_array($arr_member) && count($arr_member) > 0){
            foreach ($arr_member as $value) {
                $arr_member_id[] = $value->id;
            }
        }
        $_POST['arr_member'] = json_encode($arr_member_id);
        $res = $this->curl->post(URL_API . 'membership/kader/act_add', $this->input->post());
        echo $res;
    }
    
    function act_delete() {
        $res = $this->curl->post(URL_API . 'membership/kader/act_delete', $this->input->post());
        echo $res;
    }
    
    public function export_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_is_pic",
            "value" => "1",
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "export" => 1
        ));
        $response = json_decode($res);
        
        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            
            foreach ($results as $key => $value) {
                $results[$key]->member_identity_type = IDENTITY_TYPE[$results[$key]->member_identity_type];
                $results[$key]->member_gender = GENDER[$results[$key]->member_gender];
                $results[$key]->member_average_income = AVERAGE_INCOME[$results[$key]->member_average_income];
                $results[$key]->member_last_education = LAST_EDUCATION[$results[$key]->member_last_education];
                $results[$key]->member_religion = RELIGION[$results[$key]->member_religion];
                $results[$key]->member_is_married = IS_MARRIED[$results[$key]->member_is_married];
                $results[$key]->member_status = MEMBER_STATUS_TEXT[$results[$key]->member_status];
                $results[$key]->member_working_in = WORKING_IN[$results[$key]->member_working_in];
                $results[$key]->member_residence_status = RESIDENCE_STATUS[$results[$key]->member_residence_status];
                $results[$key]->member_blood_type = BLOOD_TYPE[$results[$key]->member_blood_type];
                $results[$key]->member_shirt_size = SHIRT_SIZE[$results[$key]->member_shirt_size];
            }

            $data = array();
            $data['title'] = 'Data Kader';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }
    
    public function export_data_detail() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_kader_id = $this->input->post('member_kader_id');
        $member_kader_name = $this->input->post('member_kader_name');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_pic_member_id",
            "value" => $member_kader_id,
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "export" => 1
        ));
        $response = json_decode($res);
        
        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            
            foreach ($results as $key => $value) {
                $results[$key]->member_identity_type = IDENTITY_TYPE[$results[$key]->member_identity_type];
                $results[$key]->member_gender = GENDER[$results[$key]->member_gender];
                $results[$key]->member_average_income = AVERAGE_INCOME[$results[$key]->member_average_income];
                $results[$key]->member_last_education = LAST_EDUCATION[$results[$key]->member_last_education];
                $results[$key]->member_religion = RELIGION[$results[$key]->member_religion];
                $results[$key]->member_is_married = IS_MARRIED[$results[$key]->member_is_married];
                $results[$key]->member_status = MEMBER_STATUS_TEXT[$results[$key]->member_status];
                $results[$key]->member_working_in = WORKING_IN[$results[$key]->member_working_in];
                $results[$key]->member_residence_status = RESIDENCE_STATUS[$results[$key]->member_residence_status];
                $results[$key]->member_blood_type = BLOOD_TYPE[$results[$key]->member_blood_type];
                $results[$key]->member_shirt_size = SHIRT_SIZE[$results[$key]->member_shirt_size];
            }

            $data = array();
            $data['title'] = 'Data Anggota dari Kader ' . $member_kader_name;
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
