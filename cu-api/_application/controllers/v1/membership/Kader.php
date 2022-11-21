<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kader extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_detail_kader(){
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {
            $sql_get_member_detail = "SELECT
                member_id,
                member_code,
                member_temp_code,
                member_name,
                FROM sys_member
                WHERE member_id = '$id'
            ";
            $detail_member = $this->db->query($sql_get_member_detail)->row();
            if (!empty($detail_member)) {
                $sql_get = "SELECT
                    member_id,
                    member_code,
                    member_temp_code,
                    member_name
                    FROM sys_member
                    WHERE member_pic_member_id = {$detail_member->member_id}
                ";
                $arr_data = $this->db->query($sql_get)->result();

                $res = array(
                    'kader' => $detail_member,
                    'member' => $arr_data
                );

                $this->createResponse(REST_Controller::HTTP_OK, $res);

            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data tidak ditemukan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Kader.');
        }
    }
    
    public function act_add_post()
    {
        $this->form_validation->set_rules('member_id', '<b>Nama Kader</b>', 'required');
        $this->form_validation->set_rules('area', '<b>Area Kader</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            $this->db->trans_begin();
            try { 
                $member_id = $this->post('member_id');
                $area = $this->post('area');
                $arr_member = json_decode($this->post('arr_member'));

                $update = array();
                $update['member_is_pic'] = 1;
                $update['member_pic_area'] = $area;
                $this->db->where('member_id', $member_id);
                if(!$this->db->update('sys_member', $update)){
                    throw new Exception("Error Processing Request", 1);
                }

                $update = array();
                $update['member_pic_member_id'] = 0;
                $this->db->where('member_pic_member_id', $member_id);
                if (!$this->db->update('sys_member', $update)) {
                    throw new Exception("Error Processing Request", 1);
                }

                foreach ($arr_member as $val) {
                    $update = array();
                    $update['member_pic_member_id'] = $member_id;
                    $this->db->where('member_id', $val);
                    if (!$this->db->update('sys_member', $update)) {
                        throw new Exception("Error Processing Request", 1);
                    }
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal simpan data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Data berhasil di simpan!');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal simpan data! Silahkan coba lagi.');
            }
        }
    }


    public function act_delete_post()
    {
        $this->form_validation->set_rules('member_id', '<b>Nama Kader</b>', 'required');
        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            $this->db->trans_begin();
            try {
                $member_id = $this->post('member_id');

                $update = array();
                $update['member_is_pic'] = 0;
                $update['member_pic_area'] = '';
                $this->db->where('member_id', $member_id);
                if (!$this->db->update('sys_member', $update)) {
                    throw new Exception("Error Processing Request", 1);
                }

                $update = array();
                $update['member_pic_member_id'] = 0;
                $this->db->where('member_pic_member_id', $member_id);
                if (!$this->db->update('sys_member', $update)) {
                    throw new Exception("Error Processing Request", 1);
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal simpan data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Data berhasil di simpan!');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal simpan data! Silahkan coba lagi.');
            }
        }
    }

}

/* End of file Kader.php */
