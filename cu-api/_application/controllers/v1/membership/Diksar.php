<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Diksar extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get(){
        $limit = (integer)$this->get('limit') <= 0 ? 10 : (integer)$this->get('limit');
        $page = (integer)$this->get('page') <= 0 ? 1 : (integer)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }
        $diksar = $this->get('diksar');
        if ($diksar != '0' && $diksar != '1') {
            $diksar = '0';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_member($diksar, $start, $limit, $sort, $dir, $filter);
        $total = (integer)$results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function act_update_one_put(){
        $set_data = array(
            'member_id' => $this->put('member_id'),
            'date' => $this->put('date'),
        );

        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('member_id', '<b>Nama Anggota</b>', 'required');
        $this->form_validation->set_rules('date', '<b>Tanggal Diksar</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {
                $now = date('Y-m-d');
                if(validate_date($this->put('date')) && $this->put('date') <= $now){
                    $id = $this->put('member_id');
                    $data['member_is_diksar'] = 1;
                    $data['member_diksar_date'] = $this->put('date');
    
                    $this->db->where('member_id', $id);
                    $this->db->update('sys_member', $data);
    
                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }
    
                    $this->common_model->update_member_status($id);
                }else{
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

    /**
     * contoh item
     * [
     *  {
     *      "code": "988374",
     *      "date": "2019-03-02"
     *  },{...},{...}
     * ]
     */
    public function act_update_many_put(){
        $arr_item = json_decode($this->put('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            $arr_failed = array();
            $now = date('Y-m-d');
            foreach ($arr_item as $index => $row) {
                $id = $this->common_model->get_member_id($row->code);
                if(validate_date($row->date) && !empty($id) && $row->date <= $now){
                    $is_error = false;
                    $this->db->trans_begin();

                    $data['member_is_diksar'] = 1;
                    $data['member_diksar_date'] = $row->date;

                    $this->db->where('member_id', $id);
                    $this->db->update('sys_member', $data);

                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }

                    $this->common_model->update_member_status($id);

                    if (!$is_error) {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                            array_push($arr_failed, $index);
                        } else {
                            $this->db->trans_commit();
                            $success++;
                        }
                    } else {
                        $this->db->trans_rollback();
                        $failed++;
                        array_push($arr_failed, $index);
                    }
                }else{
                    $failed++;
                    array_push($arr_failed, $index);
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil diubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal diubah.' : '';

            $message = $str_success . $str_failed;
            if ($failed > 0) {
                $respon = array(
                    "data" => $arr_failed,
                    "message" => $message
                );
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $respon);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
        }
    }

    private function get_member($diksar, $start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_id',
            'member_code',
            'member_temp_code',
            'member_name',
            'member_identity_number',
            'member_identity_type',
            'member_gender',
            'member_birthdate',
            'member_status',
            'member_join_datetime',
            'member_input_admin_name',
            'member_input_datetime',
            'member_diksar_date',
            'member_nationality',
            'member_entrance_fee_paid_off',
            'branch_id',
            'branch_code',
            'branch_name',
            'branch_address',
            'branch_province_name',
            'branch_city_name',
            'branch_subdistrict_name',
            'branch_village_name',
            'branch_zip_code',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'member_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search,
            member_is_diksar
            FROM sys_member
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE member_is_diksar = $diksar
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member($diksar, $query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member($diksar, $query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_id) as total
            FROM sys_member
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE member_is_diksar = $diksar
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

/* End of file Diksar.php */
