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
                        'kredit' => 0,
                        'debet' => 0,
                        'note' => '',
                        'manual_code' => ''
                    )
                );
            }
        }
        
        $data['arr_data_autocomplete'] = $arr_data_autocomplete;

        $this->template->content("accounting/jurnal_view", $data);
        $this->template->show('template');
    }
    
    public function get_data() {
        
        $array_search_by = array(
            'date' => 'ledger_datetime',
            'trans_number' => 'ledger_trans_number',
            'trans_number_manual' => 'ledger_trans_number_manually',
            'coa_number' => 'coa_master_number',
            'coa_title' => 'coa_master_title',
            'note' => 'ledger_note',
        );
        
        $post_limit = $this->input->get('limit', TRUE);
        $post_search_by = $this->input->get('search_by', TRUE);
        $post_search_value = $this->input->get('search_value', TRUE);
        
        //Set default value
        $limit = isset($post_limit) ? $post_limit : 100;
        $search_by = isset($post_search_by) && isset($array_search_by[$post_search_by]) && !empty($post_search_value) ? $array_search_by[$post_search_by] : '';
        $search_value = isset($post_search_value) && !empty($post_search_value) ? $post_search_value : '';
        
        if($post_search_by == 'date'){
            $search_value = validate_date($search_value, 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $search_value))) : '';
        }
        
        $res = $this->curl->get(URL_API . 'accounting/jurnal/get_data', array(
            "limit" => $limit,
            "search_by" => $search_by,
            "search_value" => $search_value,
        ));
        
        echo $res;
    }
    
    public function get_data_coa($type = 'aktiva') {
        $arr_coa_type = array('aktiva', 'pasiva', 'pendapatan', 'biaya', 'nominal');
        
        $json_except = $this->input->get('except');
        $arr_except = json_decode($json_except);
        
        if (!in_array($type, $arr_coa_type)) {
            $type = 'aktiva';
        }

        $arr_filter[] = array(
            "type" => "string",
            "field" => "coa_master_type",
            "value" => $type,
            "comparison" => "="
        );
        
        $res = $this->curl->get(URL_API . 'setup/coa_master/get_data', array(
            "limit" => 1000,
            "page" => 1,
            "filter" => $arr_filter,
            "sort" => "coa_master_id",
            "dir" => "ASC",
        ));
        $response = json_decode($res);

        $json_cat = array();
        if ($response->status == 200) {
            $results = $response->data->results;
            foreach ($results as $row) {
                $data_row = array(
                    "key" => $row->coa_master_id,
                    "parentId" => $row->coa_master_parent_id,
                    "coaName" => $row->coa_master_title,
                    "title" => $row->coa_master_number,
                    "alias" => $row->coa_master_title_alias,
                    "isPositive" => $row->coa_master_is_positive,
                    "coaType" => $row->coa_master_type,
                    "tag" => $row->coa_master_tag,
                    "folder" => false,
                    "expanded" => true,
                    "isExcept" => in_array($row->coa_master_id, $arr_except)
                );

                array_push($json_cat, $data_row);
            }
        }

        if (sizeof($json_cat) == 0) {
            echo json_encode($json_cat);
        } else {
            echo json_encode($this->array_nested_builder($json_cat));
        }
    }

    public function array_nested_builder(array $flat, $idField = 'key', $parentIdField = 'parentId', $childNodesField = 'children') {

        $indexed = array();

        foreach ($flat as $row) {
            if ($row[$idField] > 0) {
                $indexed[$row[$idField]] = $row;
                $indexed[$row[$idField]][$childNodesField] = array();
            }
        }

        $root = null;
        foreach ($indexed as $id => $row) {
            $indexed[$row[$parentIdField]][$childNodesField][$id] = & $indexed[$id];
            array_multisort($indexed[$row[$parentIdField]][$childNodesField], SORT_ASC);

            if (sizeof($indexed[$row[$parentIdField]][$childNodesField]) > 0) {
                $indexed[$row[$parentIdField]]['folder'] = true;
            }

            if (!$row[$parentIdField]) {
                $root = $id;
            }
        }

        return $indexed[0][$childNodesField];
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
            "value" => '0',
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
    
    function act_add() {
        $date = validate_date($_POST['date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : NULL;
        
        if ($date != NULL) {
            $_POST['date'] = $date;
            $res = $this->curl->post(URL_API . 'accounting/jurnal/act_add_memorial', $this->input->post());
            
            $result = json_decode($res);
            if($result->status == 200 && !empty($_POST['title'])){
                
                $_POST['type'] = 0;
                $res = $this->curl->post(URL_API . 'setup/jurnal_master/act_add', $this->input->post());
                $result = json_decode($res);
                if($result->status == 200){
                    $res = array(
                        'status' => 200,
                        'msg' => 'success',
                        'data' => 'Berhasil tambah data jurnal dan template jurnal.'
                    );
                }else{
                    $res = array(
                        'status' => 200,
                        'msg' => 'success',
                        'data' => 'Berhasil tambah data jurnal. Gagal tambah data template jurnal. ' . $result->msg
                    );
                }
            }else if($result->status > 200){
                $res = array(
                    'status' => 400,
                    'msg' => $result->msg
                );
            }else{
                $res = array(
                    'status' => 200,
                    'msg' => 'success',
                    'data' => 'Berhasil tambah data jurnal.'
                );
            }
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal proses data! Format tanggal jurnal salah. Silahkan coba lagi.'
            );
        }
        echo json_encode($res);
    }

}
