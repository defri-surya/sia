<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_saving extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("product/product_saving_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'product/product_saving/get_data', array(
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
                
            $arr_yes_no = array('Tidak', 'Ya');
            $arr_deposit_service_method = array('Harian', 'Bulanan');
            $arr_deposit_service_is_last_balance = array('Saldo Terakhir', 'Saldo Terendah');

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->product_saving_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalEdit(' . $row->product_saving_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->product_saving_id,
                    'cell' => array(
                        'product_saving_code' => $row->product_saving_code,
                        'product_saving_name' => $row->product_saving_name,
                        'product_saving_name_alias' => $row->product_saving_name_alias,
                        'product_saving_deposit_service_percent' => number_format($row->product_saving_deposit_service_percent, 2, ',', '.'),
                        'product_saving_deposit_service_method' => $arr_deposit_service_method[$row->product_saving_deposit_service_method],
                        'product_saving_deposit_service_is_last_balance' => $arr_deposit_service_is_last_balance[$row->product_saving_deposit_service_is_last_balance],
                        'product_saving_deposit_service_min_balance' => number_format($row->product_saving_deposit_service_min_balance, 0, ',', '.'),
                        'product_saving_initial_deposit_value' => number_format($row->product_saving_initial_deposit_value, 0, ',', '.'),
                        'product_saving_max_acc_deposit_per_month_value' => number_format($row->product_saving_max_acc_deposit_per_month_value, 0, ',', '.'),
                        'product_saving_min_acc_deposit_value' => number_format($row->product_saving_min_acc_deposit_value, 0, ',', '.'),
                        'product_saving_book_change_fee' => number_format($row->product_saving_book_change_fee, 0, ',', '.'),
                        'product_saving_book_lost_fee' => number_format($row->product_saving_book_lost_fee, 0, ',', '.'),
                        'product_saving_open_adm_fee' => number_format($row->product_saving_open_adm_fee, 0, ',', '.'),
                        'product_saving_closing_adm_fee' => number_format($row->product_saving_closing_adm_fee, 0, ',', '.'),
                        'product_saving_monthly_adm_fee' => number_format($row->product_saving_monthly_adm_fee, 0, ',', '.'),
                        'product_saving_is_monthly_adm_fee' => $arr_yes_no[$row->product_saving_is_monthly_adm_fee],
                        'product_saving_min_balance' => number_format($row->product_saving_min_balance, 0, ',', '.'),
                        'product_saving_is_loan_guarantee' => $arr_yes_no[$row->product_saving_is_loan_guarantee],
                        'product_saving_is_withdrawal' => $arr_yes_no[$row->product_saving_is_withdrawal],
                        'product_saving_is_withdrawal_represented' => $arr_yes_no[$row->product_saving_is_withdrawal_represented],
                        'product_saving_withdraw_fee_percent' => number_format($row->product_saving_withdraw_fee_percent, 2, ',', '.'),
                        'product_saving_is_withdrawal_fee' => $arr_yes_no[$row->product_saving_is_withdrawal_fee],
                        'product_saving_is_period' => $arr_yes_no[$row->product_saving_is_period],
                        'product_saving_min_period' => $row->product_saving_min_period . ' Bulan',
                        'product_saving_is_insured' => $arr_yes_no[$row->product_saving_is_insured],
                        'detail' => $detail,
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'product/product_saving/act_update', $this->input->post());
        echo $res;
    }

}
