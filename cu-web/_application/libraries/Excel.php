<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/phpexcel/PHPExcel.php';
require_once dirname(__FILE__) . '/phpexcel/PHPExcel/IOFactory.php';

class Excel extends PHPExcel {

    function __construct() {
        parent::__construct();
    }

}
