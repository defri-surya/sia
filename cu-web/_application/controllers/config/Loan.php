<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $arr_results = array();
        
        $res = $this->curl->get(URL_API . 'config/general/get_detail', array(
            'id' => 1
        ));

        $response = json_decode($res);

        if ($response->status == 200) {
            $arr_results = $response->data;
        }
        $data['results'] = $arr_results;

        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("config/loan_list_view", $data);
        $this->template->show('template');
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'config/general/act_update', $this->input->post());
        echo $res;
    }

}
