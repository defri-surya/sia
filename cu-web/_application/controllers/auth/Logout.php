<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Backend_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->curl->post(URL_API . 'auth/logout');
        $array_items = array(
            'administrator_id',
            'administrator_group_id',
            'administrator_group_title',
            'administrator_group_type',
            'administrator_group_company_id',
            'administrator_group_branch_id',
            'administrator_username',
            'administrator_name',
            'administrator_email',
            'administrator_image',
            'administrator_last_login',
            'administrator_logged_in',
            'administrator_last_last_login',
            'administrator_last_username',
            'administrator_last_name',
            'is_superuser',
            'menu',
            'token'
        );

        $this->session->unset_userdata($array_items);

        if ($this->session->userdata('administrator_logged_in')) {
            $this->session->sess_destroy();
        }

        $redirect = _login_uri;
        redirect($redirect);
    }

}
