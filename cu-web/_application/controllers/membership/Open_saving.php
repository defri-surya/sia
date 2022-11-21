<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Open_saving extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $arr_list_branch = array();
        $res = $this->curl->get(URL_API . 'option/branch', array('id' => 1));
        $response = json_decode($res);
        if ($response->status == 200) {
            $arr_list_branch = $response->data->results;
        }

        $arr_list_product_saving = array();
        $res = $res = $this->curl->get(URL_API . 'option/product_saving');
        $response = json_decode($res);
        if ($response->status == 200) {
            $arr_list_product_saving = $response->data->results;
        }

        $data['arr_list_product_saving'] = $arr_list_product_saving;
        $data['arr_list_branch'] = $arr_list_branch;
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("membership/open_saving_list_view2", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        $res = $this->curl->get(URL_API . 'membership/open_saving/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir
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

            $arr_is_blocked = array('<span class="label label-info">Tidak Terblokir</span>', '<span class="label label-danger">Terblokir</span>');
            $arr_is_active = array('<span class="label label-default">Tidak Aktif</span>', '<span class="label label-warning">Aktif</span>');

            foreach ($results as $row) {

                $entry = array('id' => $row->member_product_saving_member_id,
                    'cell' => array(
                        'member_product_saving_member_code' => $row->member_product_saving_member_code,
                        'member_name' => $row->member_name,
                        'member_product_saving_account_number' => $row->member_product_saving_account_number,
                        'member_product_saving_member_balance' => number_format($row->member_product_saving_member_balance, 0, ',', '.'),
                        'member_product_saving_name' => $row->member_product_saving_name,
                        'member_product_saving_name_alias' => $row->member_product_saving_name_alias,
                        'member_product_saving_period' => $row->member_product_saving_period . ' Bulan',
                        'member_product_saving_is_blocked' => $arr_is_blocked[$row->member_product_saving_is_blocked],
                        'member_product_saving_is_active' => $arr_is_active[$row->member_product_saving_is_active],
                    ),
                );

                $json_data['rows'][] = $entry;
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
        
//        $member_status = $this->input->post('member_status');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
//        if($member_status == 1){
//            array_push($filter, array(
//                "type" => "list",
//                "field" => "member_status",
//                "value" => "0::1",
//                "comparison" => "bet"
//            ));
//        }else{
//            array_push($filter, array(
//                "type" => "numeric",
//                "field" => "member_status",
//                "value" => "2",
//                "comparison" => "="
//            ));
//        }

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
                $entry = array('id' => $row->member_id, 'additionalClass' => 'control-row',
                    'additionalAttr' => array(
                        'name' => 'tabindex',
                        'value' => $countIndex
                        ),
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

    public function act_add_saving() {
        $member_birthdate = validate_date($_POST['birthdate'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['birthdate']))) : NULL;
        if ($member_birthdate != NULL) {
            $_POST['birthdate'] = $member_birthdate;
            $_POST['saving_priode'] = str_replace(' Bulan', '', $_POST['saving_period']);
            $res = $this->curl->put(URL_API . 'membership/member/act_update', $this->input->post());
            $response = json_decode($res);

            if ($response->status == 200) {
                $res = $this->curl->post(URL_API . 'membership/registration/act_add_saving', $this->input->post());
                echo $res;
            } else {
                echo $res;
            }
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function export_data_saving() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'membership/open_saving/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $arr_is_blocked = array('Tidak Terblokir', 'Terblokir');
        $arr_is_active = array('Tidak Aktif', 'Aktif');

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;

            foreach ($results as $key => $value) {
                $results[$key]->member_product_saving_is_blocked = $arr_is_blocked[$results[$key]->member_product_saving_is_blocked];
                $results[$key]->member_product_saving_is_active = $arr_is_active[$results[$key]->member_product_saving_is_active];
            }

            $data = array();
            $data['title'] = 'Data Tabungan Anggota';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
