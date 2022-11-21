<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("transaction/payment_list_view3", $data);
        $this->template->show('template');
    }

    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'transaction_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        if (count($filter) <= 0 && (empty($start_date) || empty($end_date))) {
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $res = $this->curl->get(URL_API . 'transaction/payment/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "start_date" => $start_date,
            "end_date" => $end_date
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

                $entry = array('id' => $row->transaction_id,
                    'cell' => array(
                        'member_name' => $row->member_name,
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'transaction_debet' => number_format($row->transaction_debet, 0, ',', '.'),
                        'transaction_kredit' => number_format($row->transaction_kredit, 0, ',', '.'),
                        'transaction_note' => $row->transaction_note,
                        'transaction_datetime' => convert_date($row->transaction_datetime, 'id'),
                        'transaction_administrator_name' => $row->transaction_administrator_name,
                        'transaction_administrator_username' => $row->transaction_administrator_username,
                        'transaction_input_datetime' => convert_datetime($row->transaction_input_datetime, 'id'),
//                        'branch_name' => $row->branch_name,
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
        
        $search_type = $this->input->post('search_type');
        $search_value = $this->input->post('search_value');
        
        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
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

    public function get_member_balance_log($type = 'monthly') {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_id = $this->input->post('member_id');
        $config_name = $this->input->post('payment_name');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        $res = $this->curl->get(URL_API . 'transaction/payment/get_member_balance_log', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "member_id" => $member_id,
            "config_name" => $config_name
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
                
            $arr_month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            
            foreach ($results as $row) {

                $entry = array('id' => $row->balance_log_id,
                    'cell' => array(
                        'balance_log_datetime' => convert_date($row->balance_log_datetime, 'id'),
                        'balance_log_debet' => number_format($row->balance_log_debet, 0, ',', '.'),
                        'balance_log_kedit' => number_format($row->balance_log_kedit, 0, ',', '.'),
                        'balance_log_last_balance' => number_format($row->balance_log_last_balance, 0, ',', '.'),
                        'balance_log_month_year' => $type == 'monthly' ? $arr_month[date("n",strtotime($row->balance_log_month_year)) - 1] . ' ' . date("Y",strtotime($row->balance_log_month_year)) : date("Y",strtotime($row->balance_log_month_year)),
                        'balance_log_input_datetime' => convert_datetime($row->balance_log_input_datetime, 'id'),
                        'balance_log_administrator_username' => $row->balance_log_administrator_username,
                        'balance_log_administrator_name' => $row->balance_log_administrator_name,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function get_member_saving_log() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_id = $this->input->post('member_id');
        $saving_id = $this->input->post('saving_id');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_product_saving_log_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        $res = $this->curl->get(URL_API . 'transaction/payment/get_member_saving_log', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "member_id" => $member_id,
            "saving_id" => $saving_id
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

                $entry = array('id' => $row->member_product_saving_log_id,
                    'cell' => array(
                        'member_product_saving_log_code' => $row->member_product_saving_log_code,
                        'member_product_saving_log_debet' => number_format($row->member_product_saving_log_debet, 0, ',', '.'),
                        'member_product_saving_log_kredit' => number_format($row->member_product_saving_log_kredit, 0, ',', '.'),
                        'member_product_saving_log_last_balance' => number_format($row->member_product_saving_log_last_balance, 0, ',', '.'),
                        'member_product_saving_log_datetime' => convert_date($row->member_product_saving_log_datetime, 'id'),
                        'member_product_saving_log_input_datetime' => convert_datetime($row->member_product_saving_log_input_datetime, 'id'),
                        'member_product_saving_log_input_admin_name' => $row->member_product_saving_log_input_admin_name,
                        'member_product_saving_log_input_admin_username' => $row->member_product_saving_log_input_admin_username,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function act_add_premium() {
        $date = validate_date($_POST['date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : NULL;
        if ($date != NULL) {
            $_POST['date'] = $date;
            $_POST['nominal_saving'] = convert_format_rp($_POST['nominal_saving']);
            $res = $this->curl->post(URL_API . 'transaction/payment/act_add_premium', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function act_add_saving() {
        $date = validate_date($_POST['date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : NULL;
        if ($date != NULL) {
            $_POST['date'] = $date;
            $_POST['nominal_saving'] = convert_format_rp($_POST['nominal_saving']);
            $res = $this->curl->post(URL_API . 'transaction/payment/act_add_saving', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function act_add_withdrawal() {
        $date = validate_date($_POST['date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : NULL;
        if ($date != NULL) {
            $_POST['date'] = $date;
            $_POST['nominal_withdraw'] = convert_format_rp($_POST['nominal_withdraw']);
            $res = $this->curl->post(URL_API . 'transaction/withdrawal/act_add', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function export_data_lkh() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'transaction/payment/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "start_date" => $start_date,
            "end_date" => $end_date
        ));
        $response = json_decode($res);

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            
            $str_date = convert_date(date('Y-m-d'), 'id') . ' sampai ' . convert_date(date('Y-m-d'), 'id');
            if(!empty($start_date) && !empty($end_date)){
                $str_date = convert_date($start_date, 'id') . ' sampai ' . convert_date($end_date, 'id');
            }

            $data = array();
            $data['title'] = 'Data LKH ' . $str_date;
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
