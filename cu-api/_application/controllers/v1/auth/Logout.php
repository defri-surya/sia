<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends Auth_Api_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function index_post()
    {
        $this->db->where('user_auth_token', $this->get_user('user_auth_token'));
        $this->db->delete('user_auth');
        if($this->db->affected_rows() > 0){
            $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil Logout');
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal Logout');
        }
    }

}

/* End of file Logout.php */
