<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Institution_management extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $this->load->view('comingsoon');
    }

}
