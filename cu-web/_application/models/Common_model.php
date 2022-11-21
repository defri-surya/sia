<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function generate_code($table_name = '', $fieldname = '', $extra = '', $digit = 5) {
        $sql = "
            SELECT
            IFNULL(LPAD(MAX(CAST(RIGHT(" . $fieldname . ", " . $digit . ") AS SIGNED) + 1), " . $digit . ", '0'), '" . sprintf('%0' . $digit . 'd', 1) ."') AS code 
            FROM " . $table_name . "
            " . $extra . "
          ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return '';
        }
    }
    
    function generate_sku($product_variant_name) {
        $arr = explode(' ', $product_variant_name);
        $product_name = '';
        
        foreach($arr as $row) {
            
            if (!is_numeric($row)) {
                if (strlen($row) >= 3) {
                    $product_name .= substr($row, 0, 3).'-';
                } else {
                    $product_name .= substr($row, 0, 1).'-';
                }
            } else {
                $product_name .= $row.'-';
            }
        }
        
        $product_name = rtrim($product_name, '-');
        
        $sql = "
            SELECT COUNT(product_variant_sku_code) AS total
            FROM sys_product_variant 
            WHERE product_variant_sku_code = '".$product_name."'
        ";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            
            $total = $row->total;
            
            if ($total > 0) {
                $product_name .= '-'. ($total + 1);
            }
        }
        return $product_name;
    }
    
    function get_list_branch() {
        $res = $this->curl->get(URL_API . 'setup/branch/get_data', array(
            "limit" => 100,
            "page" => 1,
            "filter" => array(),
            "sort" => 'branch_id',
            "dir" => 'ASC',
        ));
        $response = json_decode($res);
        
        if($response->status == 200){
            $results = $response->data->results;
            return $results;
        }else{
            return array();
        }
    }

}
