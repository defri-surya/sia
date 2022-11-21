<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $this->load->helper('form');
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $arr_menu_privilege = array();
        
        $res = $this->curl->get(URL_API . 'administrator/group/get_menu');
        $response = json_decode($res);
        
        if($response->status == 200){
            $arr_menu_privilege = (array) $response->data->results;
            foreach ($arr_menu_privilege as $key => $value) {
                $arr_menu_privilege[$key] = (array) $value;
            }
        }
        
        $data['arr_menu_privilege'] = $arr_menu_privilege;
        
        $this->template->content("administrator/group_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'administrator_group_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'administrator/group/get_data', array(
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
            $arr_status = array(
                '<img src="' . site_url(_dir_icon . 'bulb_off.png') . '" alt="Tidak Aktif" title="Tidak Aktif" border="0" />',
                '<img src="' . site_url(_dir_icon . 'bulb_on.png') . '" alt="Aktif" title="Aktif" border="0" />'
            );
            $arr_group_type_name = array('superuser' => 'Super User', 'administrator_company' => 'Administrator Perusahaan', 'administrator_branch' => 'Administrator Unit');
            foreach ($results as $row) {
                $edit = '<a href="javascript:;" onclick="editAdministratorGroup(' . $row->administrator_group_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->administrator_group_id,
                    'cell' => array(
                        'administrator_group_is_active' => $arr_status[$row->administrator_group_is_active],
                        'administrator_group_title' => $row->administrator_group_title,
                        'branch_name' => $row->branch_name,
                        'administrator_group_type' => $arr_group_type_name[$row->administrator_group_type],
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function act_add() {
        $res = $this->curl->post(URL_API . 'administrator/group/act_add', $this->input->post());
        echo $res;
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'administrator/group/act_update', $this->input->post());
        echo $res;
    }
    
    public function act_activate() {
        $res = $this->curl->put(URL_API . 'administrator/group/act_activate', $this->input->post());
        echo $res;
    }
    
    public function act_deactivate() {
        $res = $this->curl->put(URL_API . 'administrator/group/act_deactivate', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'administrator/group/act_delete', $this->input->post());
        echo $res;
    }

}
