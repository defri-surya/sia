<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_master extends Auth_Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get()
    {
        $limit = (integer)$this->get('limit') <= 0 ? 10 : (integer)$this->get('limit');
        $page = (integer)$this->get('page') <= 0 ? 1 : (integer)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_jurnal_master($start, $limit, $sort, $dir, $filter);
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

    public function get_detail_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    jurnal_master_id,
                    jurnal_master_title,
                    jurnal_master_type,
                    jurnal_master_last_update
                FROM sys_jurnal_master
                WHERE jurnal_master_id = $id
            ";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());

                $sql_detail = "
                    SELECT 
                        jurnal_master_detail_id,
                        jurnal_master_detail_jurnal_master_id,
                        jurnal_master_detail_coa_master_id,
                        jurnal_master_detail_note,
                        jurnal_master_detail_debet,
                        jurnal_master_detail_kredit,
                        coa_master_id,
                        coa_master_parent_id,
                        coa_master_number,
                        coa_master_title,
                        coa_master_title_alias,
                        coa_master_is_positive,
                        coa_master_type,
                        coa_master_tag
                    FROM sys_jurnal_master_detail
                    JOIN sys_coa_master ON jurnal_master_detail_coa_master_id = coa_master_id
                    WHERE jurnal_master_detail_jurnal_master_id = $id
                ";
                $result = $this->db->query($sql_detail);
                $detail = array();
                if ($result->num_rows() > 0) {
                    foreach ($result->result_array() as $row) {
                        $row['jurnal_master_detail_kredit'] = round($row['jurnal_master_detail_kredit']);
                        $row['jurnal_master_detail_debet'] = round($row['jurnal_master_detail_debet']);
                        $detail[] = array_map("convertNullToString", $row);
                    }
                }

                $data['detail'] = $detail;
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Jurnal Master.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Jurnal Master.');
        }
    }


    public function act_add_post()
    {
        $this->form_validation->set_rules('title', '<b>Nama Jurnal</b>', 'required|max_length[100]');
        $this->form_validation->set_rules('type', '<b>Tipe Jurnal</b>', 'required|callback_type_check');
        $this->form_validation->set_rules('arr_coa', '<b>Master COA</b>', 'callback_coa_master_check');


        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();
            $datetime = date('Y-m-d H:i:s');

            try {
                $jurnal_master_title = $this->post('title');
                $jurnal_master_type = $this->post('type');

                $data = array();
                $data['jurnal_master_title'] = $jurnal_master_title;
                $data['jurnal_master_type'] = $jurnal_master_type;
                $data['jurnal_master_last_update'] = $datetime;

                if (!$this->db->insert('sys_jurnal_master', $data)) {
                    $is_error = true;
                }
                $jurnal_master_id = $this->db->insert_id();
                
                $data_detail = array();
                $arr_detail = json_decode($this->post('arr_coa'));

                foreach ($arr_detail as $key => $detail) {
                    $data_detail[] = array(
                        'jurnal_master_detail_jurnal_master_id' => $jurnal_master_id,
                        'jurnal_master_detail_coa_master_id' => $detail->coa_master_id,
                        'jurnal_master_detail_note' => $detail->note,
                        'jurnal_master_detail_debet' => $detail->debet,
                        'jurnal_master_detail_kredit' => $detail->kredit,
                    );
                }

                if (!$this->db->insert_batch('sys_jurnal_master_detail', $data_detail)) {
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

    public function act_update_put()
    {
        $set_data = array(
            'title' => $this->put('title'),
            'arr_coa' => $this->put('arr_coa'),
            'type' => $this->put('type'),
        );

        $this->form_validation->set_data($set_data);

        $this->form_validation->set_rules('title', '<b>Nama Jurnal</b>', 'required|max_length[100]');
        $this->form_validation->set_rules('type', '<b>Tipe Jurnal</b>', 'required|callback_type_check');
        $this->form_validation->set_rules('arr_coa', '<b>Master COA</b>', 'callback_coa_master_check');

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();
            $datetime = date('Y-m-d H:i:s');

            try {
                $jurnal_master_id = $this->put('id');
                $jurnal_master_title = $this->put('title');
                $jurnal_master_type = $this->put('type');

                $data = array();
                $data['jurnal_master_title'] = $jurnal_master_title;
                $data['jurnal_master_type'] = $jurnal_master_type;
                $data['jurnal_master_last_update'] = $datetime;

                $this->db->where('jurnal_master_id', $jurnal_master_id);
                $this->db->update('sys_jurnal_master', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                $data_detail = array();
                $arr_detail = json_decode($this->put('arr_coa'));

                foreach ($arr_detail as $key => $detail) {
                    $data_detail[] = array(
                        'jurnal_master_detail_jurnal_master_id' => $jurnal_master_id,
                        'jurnal_master_detail_coa_master_id' => $detail->coa_master_id,
                        'jurnal_master_detail_note' => $detail->note,
                        'jurnal_master_detail_debet' => $detail->debet,
                        'jurnal_master_detail_kredit' => $detail->kredit,
                    );
                }

                $this->db->where('jurnal_master_detail_jurnal_master_id', $jurnal_master_id);
                if(!$this->db->delete('sys_jurnal_master_detail')){
                    $is_error = true;
                }

                if (!$this->db->insert_batch('sys_jurnal_master_detail', $data_detail)) {
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

    public function act_delete_post()
    {
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                //hapus data
                $this->db->where('jurnal_master_id', $id);
                $this->db->delete('sys_jurnal_master');

                if ($this->db->affected_rows() < 1) {
                    $is_error = true;
                }

                //hapus data
                $this->db->where('jurnal_master_detail_jurnal_master_id', $id);
                $this->db->delete('sys_jurnal_master_detail');

                if ($this->db->affected_rows() < 1) {
                    $is_error = true;
                }

                if (!$is_error) {
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        $failed++;
                    } else {
                        $this->db->trans_commit();
                        $success++;
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dihapus. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dihapus.' : '';

            $message = $str_success . $str_failed;
            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal hapus data! Silahkan coba lagi.');
        }
    }

    private function get_jurnal_master($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'jurnal_master_id',
            'jurnal_master_title',
            'jurnal_master_type',
            'jurnal_master_last_update'
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'jurnal_master_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_jurnal_master
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_jurnal_master($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_jurnal_master($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(jurnal_master_id) as total
            FROM sys_jurnal_master
            WHERE 0 = 0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    public function type_check($str)
    {
        $this->form_validation->set_message('type_check', '{field} hanya boleh 0 atau 1.');
        if ($str != '1' && $str != '0') {
            return false;
        }
        return true;
    }

    public function coa_master_check($str)
    {
        $is_error = false;
        $msg = '';
        $arr_detail = (array) json_decode($str);

        if(!empty($arr_detail)){
            $debet = 0;
            $kredit = 0;
            $coa_master_id = 0;
            foreach ($arr_detail as $key => $detail) {
                if(empty($detail->coa_master_id)){
                    $is_error = true;
                    $msg = '{field} tidak boleh kosong.';
                }else{
                    if($coa_master_id == $detail->coa_master_id){
                        $is_error = true;
                        $msg = '{field} tidak boleh sama.'; 
                    }
                }
                if(!is_numeric($detail->kredit)){
                    $is_error = true;
                    $msg = '{field} kredit harus angka.';
                }
                if(!is_numeric($detail->debet)){
                    $is_error = true;
                    $msg = '{field} debet harus angka.';
                }
                $coa_master_id = $detail->coa_master_id;
                $debet = $debet + $detail->debet;
                $kredit = $kredit + $detail->kredit;
            }
            if($kredit != $debet){
                $is_error = true;
                $msg = '{field} total debet dan kredit harus sama.';
            }
        }else {
            $is_error = true;
            $msg = 'List {field} tidak boleh kosong.';
        }

        if($is_error == true){
            $this->form_validation->set_message('coa_master_check', $msg);
            return false;
        }else{
            return true;
        }
    }
}

/* End of file Jurnal_master.php */
