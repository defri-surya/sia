<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("report/member_list_view", $data);
        $this->template->show('template');
    }
    
    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_status = $this->input->post('member_status');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        if($member_status == "member"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "0",
                "comparison" => "="
            ));
        }else if($member_status == "alb"){
            array_push($filter, array(
                "type" => "list",
                "field" => "member_status",
                "value" => "1::3",
                "comparison" => "bet"
            ));
        }else if($member_status == "alb-special"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "4",
                "comparison" => "="
            ));
        }else if($member_status == "calon"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "5",
                "comparison" => "="
            ));
        }else{
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "6",
                "comparison" => "="
            ));
        }
        
        $res = $this->curl->get(URL_API . 'report/member/get_data', array(
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
                        'member_working_in' => WORKING_IN[$row->member_working_in],
                        'member_ethnic_group' => $row->member_ethnic_group,
                        'member_residence_status' => RESIDENCE_STATUS[$row->member_residence_status],
                        'member_blood_type' => BLOOD_TYPE[$row->member_blood_type],
                        'member_shirt_size' => SHIRT_SIZE[$row->member_shirt_size],
                        'member_entrance_fee_paid_off' => ENTRANCE_FEE_PAID_OFF[$row->member_entrance_fee_paid_off],
                        'member_is_diksar' => IS_DIKSAR[$row->member_is_diksar],
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function export_data_member() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');
        $member_status = $this->input->post('member_status');
        
        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
        if($member_status == "member"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "0",
                "comparison" => "="
            ));
        }else if($member_status == "alb"){
            array_push($filter, array(
                "type" => "list",
                "field" => "member_status",
                "value" => "1::3",
                "comparison" => "bet"
            ));
        }else if($member_status == "alb-special"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "4",
                "comparison" => "="
            ));
        }else if($member_status == "calon"){
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "5",
                "comparison" => "="
            ));
        }else{
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "6",
                "comparison" => "="
            ));
        }

        $res = $this->curl->get(URL_API . 'report/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "export" => 1,
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
            $data['title'] = 'Laporan Data Anggota';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
