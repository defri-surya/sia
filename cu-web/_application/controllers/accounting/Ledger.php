<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $arr_data_autocomplete = array();
        $res = $this->curl->get(URL_API . 'option/coa_master');
        $result = json_decode($res);
        if($result->status == 200){
            $arr_coa = $result->data->results;
            
            foreach ($arr_coa as $key => $value) {
                $arr_data_autocomplete[] = array(
                    'label' => $value->number . ' - ' . $value->title,
                    'data' => array(
                        'coa_master_id' => $value->id,
                        'name' => $value->title,
                        'number' => $value->number,
                    )
                );
            }
        }
        
        $data['arr_data_autocomplete'] = $arr_data_autocomplete;

        $this->template->content("accounting/ledger_view", $data);
        $this->template->show('template');
    }
    
    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $coa_master_id = $this->input->post('coa_master_id');
        $start_date = validate_date($this->input->post('start_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('start_date')))) : NULL;
        $end_date = validate_date($this->input->post('end_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('end_date')))) : NULL;

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'ledger_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        $res = $this->curl->get(URL_API . 'accounting/ledger/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "coa_master_id" => $coa_master_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
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

                $entry = array('id' => $row->ledger_trans_number,
                    'cell' => array(
                        'ledger_datetime' => convert_date($row->ledger_datetime, 'id', 'num', '/'),
                        'ledger_trans_number' => $row->ledger_trans_number,
                        'ledger_trans_number_manually' => $row->ledger_trans_number_manually,
                        'ledger_note' => $row->ledger_note,
                        'ledger_debet' => number_format($row->ledger_debet, 0, ',', '.'),
                        'ledger_kredit' => number_format($row->ledger_kredit, 0, ',', '.'),
                        'ledger_input_datetime' => convert_datetime($row->ledger_input_datetime, 'id'),
                        'ledger_input_admin_name' => $row->ledger_input_admin_name,
                        'ledger_input_admin_username' => $row->ledger_input_admin_username,
                        'accumulative_balance' => number_format($row->accumulative_balance, 0, ',', '.'),
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    function get_summary() {
        
        $coa_master_id = $this->input->post('coa_master_id');
        $start_date = validate_date($this->input->post('start_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('start_date')))) : NULL;
        $end_date = validate_date($this->input->post('end_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('end_date')))) : NULL;
        
        $res = $this->curl->get(URL_API . 'accounting/ledger/get_summary', array(
            "coa_master_id" => $coa_master_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
        ));
        
        header("Content-type: application/json");
        echo $res;
    }
    
    public function get_data_jurnal() {
        
        $post_search_value = $this->input->get('search_value', TRUE);
        
        //Set default value
        $search_value = isset($post_search_value) && !empty($post_search_value) ? $post_search_value : '';
        
        $res = $this->curl->get(URL_API . 'accounting/jurnal/get_data', array(
            "limit" => 1000,
            "search_by" => 'ledger_trans_number',
            "search_value" => $search_value,
        ));
        
        echo $res;
    }
    
    public function export_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');
        
        $coa_master_id = $this->input->post('coa_master_id');
        $start_date = validate_date($this->input->post('start_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('start_date')))) : NULL;
        $end_date = validate_date($this->input->post('end_date'), 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('end_date')))) : NULL;

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'ledger_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        $res = $this->curl->get(URL_API . 'accounting/ledger/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "coa_master_id" => $coa_master_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
        ));
        $response = json_decode($res);

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            
//            foreach ($results as $key => $value) {
//                $results[$key]->member_identity_type = $arr_identity_type[$results[$key]->member_identity_type];
//                $results[$key]->member_gender = $arr_gender[$results[$key]->member_gender];
//                $results[$key]->member_status = $arr_status[$results[$key]->member_status];
//                $results[$key]->member_nationality = $arr_nationality[$results[$key]->member_nationality];
//                $results[$key]->member_entrance_fee_paid_off = $arr_entrance_fee_paid_off[$results[$key]->member_entrance_fee_paid_off];
//            }

            $data = array();
            $data['title'] = 'Data Buku Besar';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo '<script>alert("Gagal export data!\n' . $response->msg . '"); window.close();</script>';
        }
    }

}
