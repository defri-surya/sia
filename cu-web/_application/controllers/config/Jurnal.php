<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $this->template->content("config/jurnal_list_view");
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'config/jurnal/get_data', array(
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
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->jurnal_config_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalEdit(' . $row->jurnal_config_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->jurnal_config_id,
                    'cell' => array(
                        'jurnal_master_title' => $row->jurnal_master_title,
                        'jurnal_config_name' => $row->jurnal_config_name,
                        'jurnal_config_title' => $row->jurnal_config_title,
                        'detail' => $detail,
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function get_data_jurnal_master() {

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
        $sort = isset($sortname_grid) ? $sortname_grid : 'jurnal_master_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
        array_push($filter, array(
            "type" => "string",
            "field" => 'jurnal_master_type',
            "value" => '1',
            "comparison" => '='
        ));

        $res = $this->curl->get(URL_API . 'config/jurnal/get_data_jurnal_master', array(
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

            $arr_type = array('Memorial', 'Otomatis');

            foreach ($results as $row) {

                $entry = array('id' => $row->jurnal_master_id,
                    'cell' => array(
                        'jurnal_master_title' => $row->jurnal_master_title,
                        'jurnal_master_type' => $arr_type[$row->jurnal_master_type],
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function get_data_jurnal_master_detail() {

        //Get variable from flexigrid
        $jurnal_master_id = $this->input->post('jurnal_master_id');

        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);

        array_push($filter, array(
            "type" => "string",
            "field" => 'jurnal_master_detail_jurnal_master_id',
            "value" => $jurnal_master_id,
            "comparison" => '='
        ));

        $sort = isset($sortname_grid) ? $sortname_grid : 'jurnal_master_detail_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'config/jurnal/get_data_jurnal_master_detail', array(
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

                $entry = array('id' => $row->jurnal_master_detail_id,
                    'cell' => array(
                        'jurnal_master_detail_note' => $row->jurnal_master_detail_note,
                        'jurnal_master_detail_debet' => number_format($row->jurnal_master_detail_debet, 0, ',', '.'),
                        'jurnal_master_detail_kredit' => number_format($row->jurnal_master_detail_kredit, 0, ',', '.'),
                        'coa_master_title' => $row->coa_master_title,
                        'coa_master_number' => $row->coa_master_number,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    function get_jurnal_master_detail() {
        $jurnal_master_id = $this->input->get('jurnal_master_id');

        $res = $this->curl->get(URL_API . 'config/jurnal/get_data_jurnal_master_detail', array(
            "filter" => array(array(
                    "type" => "string",
                    "field" => 'jurnal_master_detail_jurnal_master_id',
                    "value" => $jurnal_master_id,
                    "comparison" => '='
                ))
        ));

        $response = json_decode($res);

        if ($response->status != 200) {
            $response = array(
                'status' => 404,
                'msg' => 'Not Found'
            );
        }
        
        echo json_encode($response);
    }
    
    public function act_add() {
        $res = $this->curl->post(URL_API . 'config/jurnal/act_add', $this->input->post());
        echo $res;
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'config/jurnal/act_update', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'config/jurnal/act_delete', $this->input->post());
        echo $res;
    }
    
    public function export_data_jurnal() {
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'config/jurnal/get_data', array(
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
            $data['title'] = 'Data Konfigurasi Jurnal';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }
}
