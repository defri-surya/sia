<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Entrance_fee extends Auth_Api_Controller
{


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
            config_entrance_fee_id,
            config_entrance_fee_type,
            config_entrance_fee_title,
            IFNULL(json_extract(config_entrance_fee_json, '$.results'), '[]') AS config_entrance_fee_json,
            config_entrance_fee_last_update
            FROM sys_config_entrance_fee
            ORDER BY config_entrance_fee_type ASC
        ";
        $query = $this->db->query($sql_get);

        $result = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['config_entrance_fee_json'] = json_decode($row['config_entrance_fee_json']);
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

        if (!empty($id) && is_numeric($id)) {

            $sql_get = "
                SELECT
                config_entrance_fee_id,
                config_entrance_fee_type,
                config_entrance_fee_title,
                IFNULL(json_extract(config_entrance_fee_json, '$.results'), '[]') AS config_entrance_fee_json,
                config_entrance_fee_last_update
                FROM sys_config_entrance_fee
                WHERE config_entrance_fee_id = $id
            ";

            $query = $this->db->query($sql_get);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $data['config_entrance_fee_json'] = json_decode($data['config_entrance_fee_json']);
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Uang Pangkal.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Uang Pangkal.');
        }
    }

    //NOT FOR USE
    /*
    public function act_add_post()
    {
        $this->form_validation->set_rules('config_entrance_fee_type', '<b>Tipe Anggota</b>', 'required|is_unique[sys_config_entrance_fee.config_entrance_fee_type]');
        $this->form_validation->set_rules('config_entrance_fee_principal', '<b>Simpanan Pokok</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('config_entrance_fee_obligation', '<b>Simpanan Wajib</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('config_entrance_fee_social', '<b>Biaya Solidaritas Kematian Anggota</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('config_entrance_fee_education', '<b>Biaya Pendidikan</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('config_entrance_fee_adm', '<b>Biaya Administrasi</b>', 'is_natural_no_zero');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();

                $config_entrance_fee_type = $this->post('config_entrance_fee_type');
                $data['config_entrance_fee_type'] = $config_entrance_fee_type;

                $config_entrance_fee_principal = $this->post('config_entrance_fee_principal');
                if (!empty($principal)) {
                    $data['config_entrance_fee_principal'] = $config_entrance_fee_principal;
                }

                $config_entrance_fee_obligation = $this->post('config_entrance_fee_obligation');
                if (!empty($obligation)) {
                    $data['config_entrance_fee_obligation'] = $config_entrance_fee_obligation;
                }

                $config_entrance_fee_social = $this->post('config_entrance_fee_social');
                if (!empty($social)) {
                    $data['config_entrance_fee_social'] = $config_entrance_fee_social;
                }

                $config_entrance_fee_education = $this->post('config_entrance_fee_education');
                if (!empty($education)) {
                    $data['config_entrance_fee_education'] = $config_entrance_fee_education;
                }
                $config_entrance_fee_adm = $this->post('config_entrance_fee_adm');
                if (!empty($adm)) {
                    $data['config_entrance_fee_adm'] = $config_entrance_fee_adm;
                }

                $data['config_entrance_fee_last_update'] = $last_update;

                $this->db->insert('sys_config_entrance_fee', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil tambah data.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.');
            }
        }
    }
    */

    public function act_update_put()
    {
        $set_data = array(
            'config_entrance_fee_json' => $this->put('config_entrance_fee_json')
        );
        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('config_entrance_fee_json', '<b>Uang Pangkal</b>', 'callback_entrance_check');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();
                $id = $this->put('id');

                $config_entrance_fee_json = $this->put('config_entrance_fee_json') == '' ? '[]' : $this->put('config_entrance_fee_json');

                $config_entrance_fee_json = '{"results": ' . $config_entrance_fee_json . '}';
                if (isset($config_entrance_fee_json)) {
                    $data['config_entrance_fee_json'] = $config_entrance_fee_json;
                }

                $data['config_entrance_fee_last_update'] = $last_update;

                $this->db->where('config_entrance_fee_id', $id);
                $this->db->update('sys_config_entrance_fee', $data);

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

    public function entrance_check($str)
    {
        $is_error = false;
        $msg = '';
        $arr_detail = (array)json_decode($str);

        if (!empty($arr_detail) && is_array($arr_detail)) {
            $field = '';
            foreach ($arr_detail as $key => $detail) {
                if (isset($detail->value) && isset($detail->title)) {
                    if (empty($detail->value) && !is_numeric($detail->value)) {
                        $is_error = true;
                        $field .= $detail->title . ', ';
                    }
                } else {
                    $is_error = true;
                    $msg = '{field} format salah.';
                    break;
                }
            }
            if (!empty($field)) {
                $msg = '{field} ' . rtrim(trim($field), ',') . ' tidak boleh kosong dan harus angka';
            }
        } else {
            $is_error = true;
            $msg = '{field} tidak boleh kosong.';
        }

        if ($is_error == true) {
            $this->form_validation->set_message('entrance_check', $msg);
            return false;
        } else {
            return true;
        }
    }
}

/* End of file Entrance_fee.php */
