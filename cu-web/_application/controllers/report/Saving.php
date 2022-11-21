<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Saving extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        $str_option_saving = '';
        $separator = "";
        $res = $this->curl->get(URL_API . 'option/product_saving');
        $response = json_decode($res);
        if($response->status == 200){
            foreach ($response->data->results as $saving) {
                $str_option_saving .= $separator . $saving->product_saving_id . ":[" . $saving->product_saving_code . "] " . $saving->product_saving_name;
                $separator = "|";
            }
        }
        $data['list_option_saving'] = $str_option_saving;
        $this->template->content("report/saving_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        $res = $this->curl->get(URL_API . 'report/saving/get_data', array(
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
                
            $arr_is_blocked = array('<span class="label label-info">Tidak Terblokir</span>', '<span class="label label-danger">Terblokir</span>');
            $arr_is_active = array('<span class="label label-default">Tidak Aktif</span>', '<span class="label label-warning">Aktif</span>');
            
            foreach ($results as $row) {

                $entry = array('id' => $row->member_product_saving_id,
                    'cell' => array(
                        'member_product_saving_member_code' => $row->member_product_saving_member_code,
                        'member_product_saving_member_name' => $row->member_product_saving_member_name,
                        'member_product_saving_account_number' => $row->member_product_saving_account_number,
                        'member_product_saving_member_balance' => number_format($row->member_product_saving_member_balance, 0, ',', '.'),
                        'member_product_saving_name' => $row->member_product_saving_name,
                        'member_product_saving_name_alias' => $row->member_product_saving_name_alias,
                        'member_product_saving_period' => number_format($row->member_product_saving_period, 0, ',', '.'),
                        'member_product_saving_is_blocked' => $arr_is_blocked[$row->member_product_saving_is_blocked],
                        'member_product_saving_is_active' => $arr_is_active[$row->member_product_saving_is_active],
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
        $total_data_grid = $this->input->post('total_data');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'report/saving/get_data', array(
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
            $data['title'] = 'Laporan Data Tabungan Anggota';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
