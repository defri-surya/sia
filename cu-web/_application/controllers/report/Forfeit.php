<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forfeit extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
         $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("report/forfeit_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'denda_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
        $res = $this->curl->get(URL_API . 'loan/denda/get_data_denda', array(
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
                
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->denda_product_member_id . ', \'' . $row->member_product_product_loan_name . ' Atas nama ' . $row->member_name . '\')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';

                $entry = array('id' => $row->denda_id,
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_product_code' => $row->member_product_code,
                        'member_product_product_loan_name' => $row->member_product_product_loan_name,
                        'member_product_product_loan_name_alias' => $row->member_product_product_loan_name_alias,
                        'member_product_plafon' => number_format($row->member_product_plafon, 0, ',', '.'),
                        'member_product_plafon_balance' => number_format($row->member_product_plafon_balance, 0, ',', '.'),
                        'member_product_tenor' => $row->member_product_tenor,
                        'denda_total' => number_format($row->denda_total, 0, ',', '.'),
                        'denda_total_terbayar' => number_format($row->denda_total_terbayar, 0, ',', '.'),
                        'denda_total_pemutihan' => number_format($row->denda_total_pemutihan, 0, ',', '.'),
                        'denda_note' => $row->denda_note,
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
        $member_product_id = $this->input->post('member_product_id');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'denda_detail_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
        array_push($filter, array(
            "type" => "numeric",
            "field" => "denda_detail_product_member_id",
            "value" => $member_product_id,
            "comparison" => "="
        ));
        
        $res = $this->curl->get(URL_API . 'loan/denda/get_data_denda_detail', array(
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

                $entry = array('id' => $row->denda_detail_id,
                    'cell' => array(
                        'denda_detail_periode' => number_format($row->denda_detail_periode, 0, ',', '.'),
                        'denda_detail_ke' => number_format($row->denda_detail_ke, 0, ',', '.'),
                        'denda_detail_type' => $row->denda_detail_type,
                        'denda_detail_nominal' => number_format($row->denda_detail_nominal, 0, ',', '.'),
                        'denda_detail_input_date' => convert_date($row->denda_detail_input_date, 'id'),
                        'member_product_product_loan_name' => $row->member_product_product_loan_name,
                        'member_product_product_loan_name_alias' => $row->member_product_product_loan_name_alias,
                        'member_product_code' => number_format($row->member_product_code, 0, ',', '.'),
                        'member_product_plafon' => number_format($row->member_product_plafon, 0, ',', '.'),
                        'member_product_plafon_balance' => number_format($row->member_product_plafon_balance, 0, ',', '.'),
                        'member_product_tenor' => number_format($row->member_product_tenor, 0, ',', '.'),
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function export_data_saving() {
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'denda_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
        $res = $this->curl->get(URL_API . 'loan/denda/get_data_denda', array(
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

            $data = array();
            $data['title'] = 'Laporan Denda Pinjaman';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
