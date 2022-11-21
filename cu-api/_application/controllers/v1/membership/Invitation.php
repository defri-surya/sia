<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invitation extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function get_data_get(){
        $limit = (int) $this->get('limit') <= 0 ? 10 : (int) $this->get('limit');
        $page = (int) $this->get('page') <= 0 ? 1 : (int) $this->get('page');
        $filter = (array) $this->get('filter');
        $sort = (string) $this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'DESC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_invitation($start, $limit, $sort, $dir, $filter);
        $total = (int) $results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function get_detail_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    invitation_id,
                    invitation_subject,
                    invitation_code,
                    invitation_event,
                    invitation_datetime,
                    invitation_location,
                    invitation_note,
                    invitation_status,
                    invitation_participants,
                    invitation_participants_attend,
                    invitation_input_datetime,
                    invitation_update_datetime,
                    invitation_administrator_name,
                    invitation_administrator_username
                FROM sys_invitation
                WHERE invitation_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            if (!empty($data)) {
                $data['detail'] = array();
                $sql_get = "SELECT 
                    invitation_detail_id,
                    invitation_detail_invitation_id,
                    invitation_detail_member_id,
                    invitation_detail_status,
                    member_code,
                    member_temp_code,
                    member_name,
                    member_identity_number,
                    member_identity_type,
                    member_address_domicile,
                    member_domicile_province,
                    member_domicile_city,
                    member_domicile_subdistrict,
                    member_domicile_kelurahan,
                    member_domicile_rt_number,
                    member_domicile_rw_number,
                    member_domicile_zipcode,
                    member_phone_number,
                    member_mobilephone_number,
                    member_address,
                    member_province,
                    member_city,
                    member_subdistrict,
                    member_kelurahan,
                    member_rt_number,
                    member_rw_number,
                    member_zipcode
                    FROM sys_invitation_detail
                    JOIN sys_member ON invitation_detail_member_id = member_id
                    JOIN sys_member_address ON invitation_detail_member_id = member_address_id
                    WHERE invitation_detail_invitation_id = $id
                ";
                $result = $this->db->query($sql_get);
                if ($result->num_rows() > 0) {
                    foreach ($result->result_array() as $row) {
                        $data['detail'][] = array_map("convertNullToString", $row);
                    }
                }
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data Detail Undangan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data Detail Undangan.');
        }
    }

    public function act_add_post(){
        $this->form_validation->set_rules('subject', '<b>Prihal</b>', 'required');
        $this->form_validation->set_rules('code', '<b>No Surat</b>', 'required');
        $this->form_validation->set_rules('event', '<b>Nama Acara</b>', 'required');
        $this->form_validation->set_rules('datetime', '<b>Tanggal Acara</b>', 'required');
        $this->form_validation->set_rules('location', '<b>Lokasi Acara</b>', 'required');
        $this->form_validation->set_rules('note', '<b>Catatan</b>', 'required');
        $this->form_validation->set_rules('member', '<b>Data Member</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {
                $subject = $this->post('subject');
                $code = $this->post('code');
                $event = $this->post('event');
                $datetime = $this->post('datetime');
                $location = $this->post('location');
                $note = $this->post('note');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');


                $member = array_unique(json_decode($this->post('member')));

                $arr_data = array();
                $arr_data['invitation_subject'] = $subject;
                $arr_data['invitation_code'] = $code;
                $arr_data['invitation_event'] = $event;
                $arr_data['invitation_datetime'] = $datetime;
                $arr_data['invitation_location'] = $location;
                $arr_data['invitation_note'] = $note;
                $arr_data['invitation_participants'] = count($member);
                $arr_data['invitation_participants_attend'] = 0;
                $arr_data['invitation_input_datetime'] = date('Y-m-d H:i:s');
                $arr_data['invitation_update_datetime'] = date('Y-m-d H:i:s');
                $arr_data['invitation_administrator_name'] = $input_admin_name;
                $arr_data['invitation_administrator_username'] = $input_admin_username;

                if(!$this->db->insert('sys_invitation', $arr_data)){
                    throw new Exception("Error Processing Insert Invitation", 1);
                }

                $id = $this->db->insert_id();

                $arr_detail = array();
                foreach ($member as $val) {
                    $arr_detail[] = array(
                        'invitation_detail_invitation_id' => $id,
                        'invitation_detail_member_id' => $val,
                    );
                }

                if(empty($arr_detail)){
                    throw new Exception("Error Processing Generate Member", 1);
                }

                if(!$this->db->insert_batch('sys_invitation_detail', $arr_detail)){
                    throw new Exception("Error Processing Insert Invitation Detail", 1);
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

    public function act_presensi_post()
    {
        $this->form_validation->set_rules('id', '<b>Acara</b>', 'required');
        $this->form_validation->set_rules('member', '<b>Data Member</b>', 'required');
        $this->form_validation->set_rules('event', '<b>Nama Acara</b>', 'required');
        $this->form_validation->set_rules('date', '<b>Tanggal Acara</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {
                $id = $this->post('id');
                $date = $this->post('date');
                $event = $this->post('event');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');

                $member = json_decode($this->post('member'));

                $attend = 0;

                foreach ($member as $val) {
                    $this->db->set('invitation_detail_status', $val->attend);
                    $this->db->where('invitation_detail_invitation_id', $id);
                    $this->db->where('invitation_detail_member_id', $val->id);
                    if(!$this->db->update('sys_invitation_detail')){
                        throw new Exception("Error Processing Update Invitation Detail", 1);
                    }
                    if($val->attend == 1){
                        $attend++;
                        if($event == 'diksar'){
                            $this->db->set('member_is_diksar', 1);
                            $this->db->set('member_diksar_date', $date);
                            $this->db->where('member_id', $val->id);
                            if (!$this->db->update('sys_member')) {
                                throw new Exception("Error Processing Update Member", 1);
                            }
                            $this->common_model->update_member_status($val->id);
                        }
                    }
                    if($val->attend == 2){
                        $attend++;
                    }
                }

                $this->db->set('invitation_status', 1);
                $this->db->set('invitation_participants_attend', $attend);
                $this->db->set('invitation_update_datetime', date('Y-m-d H:i:s'));
                $this->db->set('invitation_administrator_name', $input_admin_name);
                $this->db->set('invitation_administrator_username', $input_admin_username);
                $this->db->where('invitation_id', $id);
                if (!$this->db->update('sys_invitation')) {
                    throw new Exception("Error Processing Update Invitation", 1);
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

    private function get_invitation($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'invitation_id',
            'invitation_subject',
            'invitation_code',
            'invitation_event',
            'invitation_datetime',
            'invitation_location',
            'invitation_note',
            'invitation_status',
            'invitation_participants',
            'invitation_participants_attend',
            'invitation_input_datetime',
            'invitation_update_datetime',
            'invitation_administrator_name',
            'invitation_administrator_username',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'invitation_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_invitation
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_invitation($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_invitation($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(invitation_id) as total
            FROM sys_invitation
            WHERE 0=0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }
    
    

}

/* End of file Invitation.php */
