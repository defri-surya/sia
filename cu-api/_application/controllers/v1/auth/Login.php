<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package    v1/auth/login
* @author     Om Racun <info@omracun.web.id>
* @link       http://omracun.web.id
* @copyright  Copyright (c) 2019, Om Racun
*/

class Login extends Base_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    

    public function index_post()
    {
        $this->form_validation->set_rules('username', '<b>Username</b>', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password', '<b>Password</b>', 'trim|htmlspecialchars|required');

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $this->load->model('v1/auth/login_model');
            $username = addslashes($this->post('username'));
            $password = addslashes($this->post('password'));
            $query = $this->login_model->get_data_administrator_by_username($username);
            if ($query->num_rows() > 0) {
                $row = (object)array_map("convertNullToString", $query->row_array()) ;
                $pass_verify = $row->administrator_password;
                if (($row->administrator_username === $username) && password_verify($password, $pass_verify)) {
                    //sukses
                    $query_last_login = $this->login_model->get_data_administrator_last_login();
                    $row_last_login = $query_last_login->row();
                    $arr_menu = $this->login_model->get_data_administrator_menu($row->administrator_group_id, $row->administrator_group_type);

                    $array_items = array(
                        'administrator_id' => $row->administrator_id,
                        'administrator_group_id' => $row->administrator_group_id,
                        'administrator_group_title' => $row->administrator_group_title,
                        'administrator_group_type' => $row->administrator_group_type,
                        'administrator_group_company_id' => $row->administrator_group_company_id,
                        'administrator_group_branch_id' => $row->administrator_group_branch_id,
                        'administrator_username' => $row->administrator_username,
                        'administrator_name' => $row->administrator_name,
                        'administrator_email' => $row->administrator_email,
                        'administrator_image' => $row->administrator_image,
                        'administrator_last_login' => $row->administrator_last_login,
                        'administrator_logged_in' => true,
                        'administrator_last_last_login' => $row_last_login->administrator_last_login,
                        'administrator_last_username' => $row_last_login->administrator_username,
                        'administrator_last_name' => $row_last_login->administrator_name,
                        'is_superuser' => ($row->administrator_group_type == 'superuser' ? 'true' : 'false'),
                        'menu' => $arr_menu
                    );

                    $user_auth_created_datetime = time();
                    $user_auth_expired_datetime = strtotime(TOKEN_TIMEOUT, $user_auth_created_datetime);
                    $token = $this->generateToken($array_items['administrator_username'], $this->input->ip_address());

                    $data = array(
                        'user_auth_user_id' => $array_items['administrator_id'],
                        'user_auth_group_id' => $array_items['administrator_group_id'],
                        'user_auth_branch_id' => $array_items['administrator_group_branch_id'],
                        'user_auth_type' => $array_items['administrator_group_type'],
                        'user_auth_name' => $array_items['administrator_name'],
                        'user_auth_username' => $array_items['administrator_username'],
                        'user_auth_token' => $token,
                        'user_auth_device' => 'web',
                        'user_auth_ip_address' => $this->input->ip_address(),
                        'user_auth_created_datetime' => $user_auth_created_datetime,
                        'user_auth_expired_datetime' => $user_auth_expired_datetime
                    );

                    // $this->db->where('user_auth_user_id', $row->administrator_id);
                    // $this->db->delete('user_auth');

                    if($this->db->insert('user_auth', $data)){
                        $data = array();
                        $data['administrator_last_login'] = date('Y-m-d H:i:s');
                        $this->db->where('administrator_id', $row->administrator_id);
                        $this->db->update('sys_administrator', $data);

                        $respon = array(
                            'admin' => $array_items,
                            'token' => $token
                        );

                        $this->createResponse(REST_Controller::HTTP_OK, $respon);
                    }else{
                        $this->error(REST_Controller::HTTP_BAD_REQUEST, '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                    }
                } else {
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                }
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
            }
        }
    }

}

/* End of file Login.php */
