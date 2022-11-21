<?php

/*
 * Common Function Libraries
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_function {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    function object_to_array($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }
    
    function array_to_object($d) {
        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return (object) array_map(__FUNCTION__, $d);
        } else {
            // Return object
            return $d;
        }
    }
    
    function set_number_format($number, $is_int = true) {
        if((is_numeric($number) && floor($number) != $number) || $is_int == false) {
            return number_format($number, 2, '.', ',');
        } else {
            return number_format($number, 0, '.', ',');
        }
    }
    
    function set_gender_label($gender = '') {
        if($gender != '') {
            if($gender == 'male') {
                $label = 'Pria';
            } elseif($gender == 'female') {
                $label = 'Wanita';
            } else {
                $label = '-';
            }
        } else {
            $label = '-';
        }
        
        return $label;
    }

    function get_one($table = '', $select = null, $where = null, $sort = 'asc') {
        $this->CI->db->select($select);
        $this->CI->db->where($where);
        $this->CI->db->order_by($select, $sort);
        $this->CI->db->offset(0);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get($table);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->$select;
        } else {
            $result = '';
        }

        return $result;
    }

    function get_count($table = '', $where = '') {
        if($where != '') {
            $where = " WHERE " . $where;
        }
        
        $sql = "SELECT COUNT(*) AS data_count FROM " . $table . $where . "";
        $query = $this->CI->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->data_count;
        } else {
            return 0;
        }
    }

    function get_max($table = '', $select = null, $where = null) {
        $this->CI->db->select("IFNULL(MAX(" . $select . "), 0) AS " . $select, false);
        if ($where != null) {
            if (is_array($where)) {
                $this->CI->db->where($where);
            } else {
                $this->CI->db->where($where, false);
            }
        }
        $query = $this->CI->db->get($table);
        $row = $query->row();
        return $row->$select;
    }

    function get_min($table = '', $select = null, $where = null) {
        $this->CI->db->select("IFNULL(MIN(" . $select . "), 0) AS " . $select, false);
        if ($where != null) {
            if (is_array($where)) {
                $this->CI->db->where($where);
            } else {
                $this->CI->db->where($where, false);
            }
        }
        $query = $this->CI->db->get($table);
        $row = $query->row();
        return $row->$select;
    }

    function get_data_detail($table, $fieldname_id, $value_id) {
        $this->CI->db->select('*');
        $this->CI->db->from($table);
        $this->db->where($fieldname_id, $value_id);
        return $this->db->get();
    }

    function delete_data($table_name, $fieldname_id, $value_id) {
        $this->db->where($fieldname_id, $value_id);
        $this->db->delete($table_name);
    }
    
    function update_status($table_name, $fieldname_id, $value_id, $fieldname_stat, $value) {
        $data = array($fieldname_stat => $value);
        $this->db->where($fieldname_id, $value_id);
        $this->db->update($table_name, $data);
    }

    function get_country_name($country_id) {
        $where = array('country_id' => $country_id);
        return self::get_one('country', 'country_name', $where);
    }

    function get_option_country() {
        $options[''] = '===== Pilih Negara =====';
        $this->CI->db->where('country_is_active', '1');
        $this->CI->db->order_by('country_name', 'asc');
        $query = $this->CI->db->get('country');
        foreach ($query->result() as $row) {
            $options[$row->country_id] = $row->country_name;
        }
        return $options;
    }
    
    function get_site_configuration() {
        $this->CI->db->query("SET time_zone = '+07:00'");
        
        $this->CI->db->select('configuration_name');
        $this->CI->db->select('configuration_value');
        $this->CI->db->from('configuration');
        $query = $this->CI->db->get();
        
        $site_configuration = array();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $site_configuration[$row->configuration_name] = $row->configuration_value;
            }
        }
        
        return $site_configuration;
    }

}