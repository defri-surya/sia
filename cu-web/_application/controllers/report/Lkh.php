<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lkh extends Backend_Controller {

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
        $separator_saving = "";
        
        $str_option_loan = '';
        $separator_loan = "";
        
        $res_saving = $this->curl->get(URL_API . 'option/product_saving');
        $res_loan = $this->curl->get(URL_API . 'option/product_loan');
        
        $response_saving = json_decode($res_saving);
        if($response_saving->status == 200){
            foreach ($response_saving->data->results as $saving) {
                $str_option_saving .= $separator_saving . $saving->product_saving_id . ":[" . $saving->product_saving_code . "] " . $saving->product_saving_name;
                $separator_saving = "|";
            }
        }
        
        $response_loan = json_decode($res_loan);
        if($response_loan->status == 200){
            foreach ($response_loan->data->results as $loan) {
                $str_option_loan .= $separator_loan . $loan->product_loan_id . ":[" . $loan->product_loan_code . "] " . $loan->product_loan_name;
                $separator_loan = "|";
            }
        }
        
        $data['option_saving'] = $str_option_saving;
        $data['option_loan'] = $str_option_loan;

        $this->template->content("report/lkh_list_view", $data);
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

        $res = $this->curl->get(URL_API . 'report/lkh/get_data', array(
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
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function export_data_lkh() {
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'transaction_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'report/lkh/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            
            $data = array();
            $data['title'] = 'Laporan Data LKH';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
