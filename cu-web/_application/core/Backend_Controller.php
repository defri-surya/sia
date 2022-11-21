<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $this->is_superuser = $_SESSION['administrator_group_type'] == 'superuser' ? TRUE : FALSE;
        $this->user_group = $_SESSION['administrator_group_type'];

        $this->arr_menu = $_SESSION['menu'];

        $arr_uri_string_except = array(
            'profile/systems/profile',
            'profile/systems/act_profile',
            'profile/systems/password',
            'logout',
            'dashboard',
            'common/general'
        );

        $is_authorized = FALSE;

        $uri_segment1 = '';
        $uri_segment2 = '';
        $uri_segment3 = '';
        $uri_string = rtrim(uri_string(), "/");
        $arr_action_split = array();

        $arr_uri = explode('/', $uri_string);

        if (isset($arr_uri[0])) {
            $uri_segment1 = $arr_uri[0];
        }

        if (isset($arr_uri[1])) {
            $uri_segment2 = $arr_uri[1];
        }

        if (isset($arr_uri[2])) {
            $uri_segment3 = $arr_uri[2];

            if (startsWith($arr_uri[2], 'act_')) {
                $arr_action_split = explode('_', $uri_segment3);
            }
        }

        $url_link_check = $uri_segment1 . '/' . $uri_segment2;
        $menu_privilege = array();
        $index_menu = array_search($url_link_check . "/show", array_column($this->arr_menu, 'administrator_menu_link'));
        if ($index_menu !== FALSE) {
            if($this->is_superuser){
                $menu_privilege_decode = json_decode($this->arr_menu[$index_menu]->administrator_menu_action, TRUE)['results'];
            }else{
                $menu_privilege_decode = json_decode($this->arr_menu[$index_menu]->administrator_privilege_action, TRUE);
            }
            $menu_privilege = array_column($menu_privilege_decode, 'name');
        }else{
            $index_menu = '';
        }

        if ($this->is_superuser) {
            $is_authorized = TRUE;
        } else {
            foreach ($arr_uri_string_except as $uri_string_except) {
                if (preg_match('/' . str_replace('/', '\/', rtrim($uri_string_except, "/")) . '$/', $uri_string)) {
                    $is_authorized = TRUE;
                }
            }

            if (!$is_authorized) {
                if ($index_menu !== '') {
                    $menu_link = $this->arr_menu[$index_menu]->administrator_menu_link;

                    if ($menu_link !== '#') {
                        if (strtolower($url_link_check) . '/show' == strtolower($menu_link)) {
                            if ($uri_segment3 == 'show' || startsWith($uri_segment3, 'get_') || startsWith($uri_segment3, 'export_')) {
                                $is_authorized = TRUE;
                            }
                            if (startsWith($uri_segment3, 'act_')) {
                                if (!empty($arr_action_split)) {
                                    if (in_array($arr_action_split[1], $menu_privilege)) {
                                        $is_authorized = TRUE;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!isset($_SESSION['token'])) {
            if ($this->input->is_ajax_request()) {
                echo "expired#";
            } else {
                $origin = $this->uri->uri_string();
                $this->session->set_flashdata('redirect_url', $origin);
                $this->session->keep_flashdata('redirect_url');
                redirect(_login_uri);
            }
        } else if (!$is_authorized) {
            if ($this->input->is_ajax_request()) {
                echo "Unauthorized#";
            }else{
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Anda tidak diizinkan mengakses halaman tersebut.</div>');
                $this->session->keep_flashdata('confirmation');
                redirect('dashboard');
            }
        } else {
            $this->load->library('curl');
            $this->curl->headers = array(
                'Authorization' => AUTH_API,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'token' => $_SESSION['token']
            );
            
            $this->index_menu = $index_menu;
            $this->menu_privilege = $menu_privilege;
            $this->json_menu_privilege = json_encode($menu_privilege);
        }
    }
}
