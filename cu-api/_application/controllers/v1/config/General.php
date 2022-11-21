<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Auth_Api_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        
    }

    public function get_data_get()
    {

        $sql_get = "
            SELECT
            config_id,
            config_name,
            IFNULL(json_extract(config_json, '$.results'), '[]') AS config_json,
            config_last_update_datetime
            FROM sys_config
            ORDER BY config_id ASC
        ";
        $query = $this->db->query($sql_get);

        $result = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['config_json'] = json_decode($row['config_json']);
                $result[] = array_map("convertNullToString", $row);
            }
        }

        $data = array(
            'results' => $result
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function get_detail_get()
    {
        $id = $this->get('id');

        if (!empty($id)) {

            $sql_get = "
                SELECT
                config_id,
                config_name,
                IFNULL(json_extract(config_json, '$.results'), '[]') AS config_json,
                config_last_update_datetime
                FROM sys_config
                WHERE config_id = '{$id}'
            ";
            $query = $this->db->query($sql_get);

            $result = array();

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $data['config_json'] = json_decode($data['config_json']);
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            }else{
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config.');
            }
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config.');
        }
    }

    public function get_detail_byname_get()
    {
        $name = $this->get('name');

        if (!empty($name)) {

            $sql_get = "
                SELECT
                config_id,
                config_name,
                IFNULL(json_extract(config_json, '$.results'), '[]') AS config_json,
                config_last_update_datetime
                FROM sys_config
                WHERE config_name = '{$name}'
            ";
            $query = $this->db->query($sql_get);

            $result = array();

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $data['config_json'] = json_decode($data['config_json']);
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            }else{
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config.');
            }
        }else{
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config.');
        }
    }

    public function act_update_put()
    {
        $set_data = array(
            'json' => $this->put('json'),
            'name' => $this->put('name')
        );
        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('json', '<b>Configurasi</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Konfigurasi</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();
                $id = $this->put('id');

                $json = $this->put('json') == '' ? '[]' : $this->put('json');

                $json = '{"results": ' . $json . '}';
                if (isset($json)) {
                    $data['config_json'] = $json;
                }

                $data['config_last_update_datetime'] = $last_update;
                $data['config_name'] = $this->put('name');

                $this->db->where('config_id', $id);
                $this->db->update('sys_config', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil ubah data.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
            }
        }
    }

}

/* End of file General.php */
