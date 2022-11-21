<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $query_action = array();
        $res = $this->curl->get(URL_API . 'administrator/menu/get_ref_action');
        $response = json_decode($res);
        
        if($response->status == 200){
            $query_action = $response->data;
        }
        
        $data['query_action'] = $query_action;
        
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $this->template->content("administrator/menu_list_view", $data);
        $this->template->show('template');
    }
    
    public function get_data($menu_par_id = 0) {
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'administrator_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'administrator/menu/get_data', array(
            "par_id" => $menu_par_id,
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

                //is_active
                if ($row->administrator_menu_is_active == '1') {
                    $stat = 'Active';
                    $image_stat = 'bulb_on.png';
                } else {
                    $stat = 'Inactive';
                    $image_stat = 'bulb_off.png';
                }
                $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

                //edit
                $edit = '<a href="javascript:;" onclick="return editMenu(' . $row->administrator_menu_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

                //submenu
                $submenu = '<a href="javascript:;" onclick="getMenu(' . $row->administrator_menu_id . ', \'' . $row->administrator_menu_title . '\')"><img src="' . base_url() . _dir_icon . 'node-tree.png" border="0" alt="Sub Menu" title="Sub Menu" style="width:16px" /></a>';

                //class
                $menu_class = '<div style="padding:0"><i class="' . $row->administrator_menu_class . '" style="font-size:16px"></i></div>';

                $entry = array('id' => $row->administrator_menu_id,
                    'cell' => array(
                        'administrator_menu_id' => $row->administrator_menu_id,
                        'administrator_menu_title' => $row->administrator_menu_title,
                        'administrator_menu_link' => $row->administrator_menu_link,
                        'administrator_menu_class' => $menu_class,
                        'administrator_menu_is_active' => $is_active,
                        'edit' => $edit,
                        'submenu' => $submenu,
                    ),
                );
                $json_data['rows'][] = $entry;
            }
        }
        
        echo json_encode($json_data);
    }
    
    function get_ref_class_icon() {
        $this->template->content("administrator/menu_ref_class_icon_view");
        $this->template->show('template');
    }
    
    public function act_add() {
        $res = $this->curl->post(URL_API . 'administrator/menu/act_add', $this->input->post());
        echo $res;
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'administrator/menu/act_update', $this->input->post());
        echo $res;
    }
    
    public function act_activate() {
        $res = $this->curl->put(URL_API . 'administrator/menu/act_activate', $this->input->post());
        echo $res;
    }
    
    public function act_deactivate() {
        $res = $this->curl->put(URL_API . 'administrator/menu/act_deactivate', $this->input->post());
        echo $res;
    }
    
    public function act_update_up() {
        $res = $this->curl->put(URL_API . 'administrator/menu/act_update_up', $this->input->post());
        echo $res;
    }
    
    public function act_update_down() {
        $res = $this->curl->put(URL_API . 'administrator/menu/act_update_down', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'administrator/menu/act_delete', $this->input->post());
        echo $res;
    }

}
