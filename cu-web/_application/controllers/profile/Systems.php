<?php

/*
 * Backend Systems Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends Backend_controller {

    public function __construct() {
        parent::__construct();

        $this->image_width = 250;
        $this->image_height = 250;
        $this->max_size = 1024;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->file_dir = _dir_administrator;
    }

    public function index() {
        $this->profile();
    }

    function profile() {
        $data['arr_breadcrumbs'] = array(
            'Profil Saya' => 'profile/systems/profile',
        );

        $res = $this->curl->get(URL_API . 'administrator/user/get_detail', array(
            "id" => $_SESSION['administrator_id'],
        ));

        $response = json_decode($res);

        $data_profile = array();

        if ($response->status == 200) {
            $data_profile = $response->data;
        }

        $data['data_profile'] = $data_profile;
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'profile/systems/act_profile';

        $this->template->content("profile/profile_edit_view", $data);
        $this->template->show('template');
    }

    function act_profile() {
        $this->load->library('upload');
        $this->load->library('image_lib');

        $no_image = FALSE;
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
        }else{
            $no_image = TRUE;
        }

        $_POST['error_upload_msg'] = ($is_error_upload) ? $this->upload->display_errors() : '';
        $_POST['image'] = $file_name;
        $_POST['image_path'] = $path;
        $_POST['id'] = $_SESSION['administrator_id'];

        $res = $this->curl->put(URL_API . 'administrator/user/act_update', $this->input->post());
        $results = json_decode($res);
        if(is_array($results) && $results->status == 200){
            $array_items = array(
                'administrator_username' => $_POST['username'],
                'administrator_name' => $_POST['name'],
                'administrator_email' => $_POST['email'],
                'administrator_image' => $admin->administrator_image,
            );
            if(!$no_image && !$is_error_upload){
                $array_items['administrator_image'] = $_POST['image'];
            }
            $this->session->set_userdata($array_items);
        }
        
        echo $res;
    }

    function password() {
        $data['arr_breadcrumbs'] = array(
            'Password Saya' => 'profile/systems/password',
        );
        
        $res = $this->curl->get(URL_API . 'administrator/user/get_detail', array(
            "id" => $_SESSION['administrator_id'],
        ));

        $response = json_decode($res);

        $data_profile = array();

        if ($response->status == 200) {
            $data_profile = $response->data;
        }

        $data['data_profile'] = $data_profile;
        $data['form_action'] = 'profile/systems/act_password';

        $this->template->content("profile/password_edit_view", $data);
        $this->template->show('template');
    }

    function act_password() {
        $_POST['id'] = $_SESSION['administrator_id'];
        $res = $this->curl->put(URL_API . 'administrator/user/act_update_password', $this->input->post());
        echo $res;
    }

    function password_check($str) {
        $password = $this->session->userdata('administrator_password');
        if (password_verify($str, $password)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', '%s is wrong. Please try again.');
            return FALSE;
        }
    }

}
