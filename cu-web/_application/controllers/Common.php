<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Backend_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!$this->input->is_ajax_request()) {
            die(json_encode(
                    array(
                        'status' => 401,
                        'msg' => 'Unauthorized'
                    )
                ));
        }
    }

    public function general() {
        $uri = str_replace('common/general/', '', uri_string());
        
        $method = $this->input->method(TRUE);
        
        $res = json_encode(
            array(
                'status' => 400,
                'msg' => 'Gagal mendapatkan data.',
            ));
        
        if($method == 'GET'){
            $response = $this->curl->get(URL_API . $uri, $this->input->get());
            
            if(isJSON($response)){
                $res = $response;
            }
        }
        
        if($method == 'POST'){
            $response = $this->curl->post(URL_API . $uri, $this->input->post());
            
            if(isJSON($response)){
                $res = $response;
            }
        }
        
        echo $res;
    }

}
