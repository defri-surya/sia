<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $data = array();
        $this->template->content("dashboard", $data);
        $this->template->show('template');
    }

}
