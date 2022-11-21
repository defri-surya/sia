<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('curl');
        $this->curl->headers = array(
            'Authorization' => AUTH_API,
            'Content-Type' => 'application/x-www-form-urlencoded',
        );
    }

    public function index() {
        $this->login();
    }

    public function login() {

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        if ($this->session->userdata('administrator_logged_in')) {
            redirect('dashboard');
        } else {
            if (isset($_SESSION['redirect_url']) && trim($_SESSION['redirect_url']) != '') {
                $data['redirect_url'] = $_SESSION['redirect_url'];
            } else {
                $data['redirect_url'] = '';
            }
            $this->template->content("auth/login_view", $data);
            $this->template->show('template_login');
        }
    }

    public function verify() {
        $this->load->library('form_validation');

        $username = addslashes($this->input->post('username'));
        $password = addslashes($this->input->post('password'));
        $redirect_url = $this->input->post('redirect_url');
        
        if(ENVIRONMENT !== 'development'){
            $this->form_validation->set_rules('captcha', '<b>Kode unik</b>', 'required|callback_check_captcha');
        }
        
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required');
        $this->form_validation->set_rules('password', '<b>Password</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', validation_errors());
            $this->session->set_flashdata('username', $this->input->post('username'));
            redirect(_login_uri);
        } else {
            $res = $this->curl->post(URL_API . 'auth/login', array(
                'username' => $username,
                'password' => $password
            ));
            $response = json_decode($res);
            if (!empty($response)) {
                switch ($response->status) {
                    case 200:
                        $admin = $response->data->admin;
                        $token = $response->data->token;
                        $array_items = array(
                            'administrator_id' => $admin->administrator_id,
                            'administrator_group_id' => $admin->administrator_group_id,
                            'administrator_group_title' => $admin->administrator_group_title,
                            'administrator_group_type' => $admin->administrator_group_type,
                            'administrator_group_company_id' => $admin->administrator_group_company_id,
                            'administrator_group_branch_id' => $admin->administrator_group_warehouse_id,
                            'administrator_username' => $admin->administrator_username,
                            'administrator_name' => $admin->administrator_name,
                            'administrator_email' => $admin->administrator_email,
                            'administrator_image' => $admin->administrator_image,
                            'administrator_last_login' => $admin->administrator_last_login,
                            'administrator_logged_in' => $admin->administrator_logged_in,
                            'administrator_last_last_login' => $admin->administrator_last_last_login,
                            'administrator_last_username' => $admin->administrator_last_username,
                            'administrator_last_name' => $admin->administrator_last_name,
                            'is_superuser' => $admin->is_superuser,
                            'menu' => $admin->menu,
                            'token' => $token
                        );
                        $this->session->set_userdata($array_items);
                        if (trim($redirect_url) != '') {
                            $redirect = $redirect_url;
                        } else {
                            $redirect = 'dashboard';
                        }
                        break;

                    case 400:
                        $this->session->set_flashdata('confirmation', $response->msg);
                        $this->session->set_flashdata('username', $this->input->post('username'));
                        if (trim($redirect_url) != '') {
                            $this->session->set_flashdata('redirect_url', $redirect_url);
                        } else {
                            $redirect = _login_uri;
                        }
                        break;

                    default:
                        $this->session->set_flashdata('confirmation', '<p>Terjadi kesalahan sistem. Mohon coba lagi.</p>');
                        $this->session->set_flashdata('username', $this->input->post('username'));
                        if (trim($redirect_url) != '') {
                            $this->session->set_flashdata('redirect_url', $redirect_url);
                        } else {
                            $redirect = _login_uri;
                        }
                        break;
                }
            }
            redirect($redirect);
        }
    }

    function check_captcha($str) {
        $this->load->library('captcha');
        if ($this->captcha->verify($str)) {
            return true;
        } else {
            $this->form_validation->set_message('check_captcha', '{field} yang anda masukkan salah.');
            return false;
        }
    }

    public function captcha() {
        $this->load->library('captcha');
        $config = array(
            'background_image' => _dir_captcha . 'captcha-widget-3.png',
            'image_width' => 265,
            'image_height' => 54,
        );
        $this->captcha->generate_image($config);
    }

}
