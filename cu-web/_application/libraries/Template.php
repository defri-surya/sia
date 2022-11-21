<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  --------------------------------------------------------------------------------
  --------------------------------------------------------------------------------
  template_helper.php
  CodeIgniter Template Library
  Hubert Ursua
  https://github.com/hyubs/CodeIgniter-Template-Library
  --------------------------------------------------------------------------------
  --------------------------------------------------------------------------------
 */

class Template {

    private $CI;
    private $template_params;

    public function __construct() {
        $this->CI = & get_instance();
        $this->template_params = array();
    }

    // Sets the content of a template position
    public function set($position, $data, $append = true) {
        if (!isset($this->template_params[$position]) || $append === false) {
            $this->template_params[$position] = $data;
        } else {
            $this->template_params[$position] .= $data;
        }
    }

    // Gets the content of a template position
    public function get($position) {
        if (isset($this->template_params[$position])) {
            return $this->template_params[$position];
        } else {
            return '';
        }
    }

    // Sets the title of the page
    public function title($title = '') {
        $this->template_params['title'] = $title;
    }

    // Sets the content of the page
    public function content($view, $params = array(), $position = 'content', $append = true) {
        $data = $this->CI->load->view($view, $params, true);
        $this->set($position, $data, $append);
    }

    // Displays the page using the parameters preset using the set methods of this class
    public function show($template_view = 'template', $return_string = true) {
        
        $data = array();
        $complete_page = $this->CI->load->view($template_view, $data, true);

        if ($return_string == true) {
            echo $complete_page;
        } else {
            return $complete_page;
        }
    }

    public function blank($view, $params = array()){
        $this->CI->load->view($view, $params);
    }

}
