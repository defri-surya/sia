<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $this->template->content("administrator/user_list_view", $data);
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'administrator_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'administrator/user/get_data', array(
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
            
            foreach ($results as $row) {
                $edit = '<a href="javascript:;" onclick="editAdministrator(' . $row->administrator_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';
                $edit_password = '<a href="javascript:;" onclick="editPassword(' . $row->administrator_id . ')"><img src="' . base_url() . _dir_icon . 'lock_edit.png" border="0" alt="Ubah Password" title="Ubah Password" /></a>';
                $entry = array('id' => $row->administrator_id,
                    'cell' => array(
                        'administrator_is_active' => $arr_status[$row->administrator_is_active],
                        'administrator_group_title' => $row->administrator_group_title,
                        'administrator_username' => $row->administrator_username,
                        'administrator_name' => $row->administrator_name,
                        'administrator_mobilephone' => $row->administrator_mobilephone,
                        'administrator_email' => $row->administrator_email,
                        'administrator_last_login' => $row->administrator_last_login,
                        'administrator_image' => $row->administrator_image,
                        'edit' => $edit,
                        'password' => $edit_password
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    function act_add() {
        $this->load->library('upload');
        $this->load->library('image_lib');
        
        $is_error_upload = FALSE;
        $file_name = '';
        $path = '';
        
        if (!empty($_FILES['image']['tmp_name'])) {
            if ($this->upload->fileUpload('image', _dir_administrator, 'jpg|jpeg|gif|png', 1024)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != 250 || $height != 250) {
                    $this->image_lib->resizeImage($upload['full_path'], 250, 250);
                    $this->image_lib->cropCenterImage($upload['full_path'], 250, 250);
                }

                $image_filename = url_title($this->input->post('name')) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $file_name = $image_filename;
                $path = _dir_administrator;
            } else {
                $is_error_upload = TRUE;
            }
        }
        
        $_POST['error_upload_msg'] = ($is_error_upload) ? $this->upload->display_errors() : '';
        $_POST['image'] = $file_name;
        $_POST['image_path'] = $path;
        
        $res = $this->curl->post(URL_API . 'administrator/user/act_add', $this->input->post());
        echo $res;
    }
    
    function act_update() {
        $this->load->library('upload');
        $this->load->library('image_lib');
        
        $is_error_upload = FALSE;
        $file_name = '';
        $path = '';
        
        if (!empty($_FILES['image']['tmp_name'])) {
            if ($this->upload->fileUpload('image', _dir_administrator, 'jpg|jpeg|gif|png', 1024)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != 250 || $height != 250) {
                    $this->image_lib->resizeImage($upload['full_path'], 250, 250);
                    $this->image_lib->cropCenterImage($upload['full_path'], 250, 250);
                }

                $image_filename = url_title($this->input->post('name')) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $file_name = $image_filename;
                $path = _dir_administrator;
            } else {
                $is_error_upload = TRUE;
            }
        }
        
        $_POST['error_upload_msg'] = ($is_error_upload) ? $this->upload->display_errors() : '';
        $_POST['image'] = $file_name;
        $_POST['image_path'] = $path;
        
        $res = $this->curl->put(URL_API . 'administrator/user/act_update', $this->input->post());
        echo $res;
    }
    
    function act_update_password() {
        $res = $this->curl->put(URL_API . 'administrator/user/act_update_password', $this->input->post());
        echo $res;
    }
    
    public function act_activate() {
        $res = $this->curl->put(URL_API . 'administrator/user/act_activate', $this->input->post());
        echo $res;
    }
    
    public function act_deactivate() {
        $res = $this->curl->put(URL_API . 'administrator/user/act_deactivate', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'administrator/user/act_delete', $this->input->post());
        echo $res;
    }
}
