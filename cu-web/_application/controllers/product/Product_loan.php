<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_loan extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("product/product_loan_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'product_loan_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'product/product_loan/get_data', array(
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
                
            $arr_interest_type = array('Flat/Tetap', 'Efektif/Menurun');
            $arr_is_daperma = array('Tidak', 'Ya');

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->product_loan_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalEdit(' . $row->product_loan_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->product_loan_id,
                    'cell' => array(
                        'product_loan_code' => $row->product_loan_code,
                        'product_loan_name' => $row->product_loan_name,
                        'product_loan_name_alias' => $row->product_loan_name_alias,
                        'product_loan_max_plafon' => number_format($row->product_loan_max_plafon, 0, ',', '.'),
                        'product_loan_service_percent' => number_format($row->product_loan_service_percent, 2, ',', '.'),
                        'product_loan_service_loan_percent1' => number_format($row->product_loan_service_loan_percent1, 2, ',', '.'),
                        'product_loan_service_loan_percent2' => number_format($row->product_loan_service_loan_percent2, 2, ',', '.'),
                        'product_loan_forfeit_percent' => number_format($row->product_loan_forfeit_percent, 2, ',', '.'),
                        'product_loan_interest_percent' => number_format($row->product_loan_interest_percent, 2, ',', '.'),
                        'product_loan_interest_type' => $arr_interest_type[$row->product_loan_interest_type],
                        'product_loan_pinalty_fee_percent' => number_format($row->product_loan_pinalty_fee_percent, 2, ',', '.'),
                        'product_loan_collateral_type' => $row->product_loan_collateral_type,
                        'product_loan_is_daperma' => $arr_is_daperma[$row->product_loan_is_daperma],
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'product/product_loan/act_update', $this->input->post());
        echo $res;
    }

}
