<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Coa_master extends Auth_Api_Controller
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

        $results = $this->get_coa_master($start, $limit, $sort, $dir, $filter);
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
                    coa_master_id,
                    coa_master_parent_id,
                    coa_master_number,
                    coa_master_title,
                    coa_master_title_alias,
                    coa_master_is_positive,
                    coa_master_type,
                    coa_master_tag
                FROM sys_coa_master
                WHERE coa_master_id = $id
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Coa Master.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Coa Master.');
        }
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('number', '<b>No. Rekening</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('title', '<b>Nama Akun</b>', 'required|max_length[100]');
        $this->form_validation->set_rules('is_positive', '<b>Positive</b>', 'callback_is_positive_check');
        $this->form_validation->set_rules('type', '<b>Tipe</b>', 'required|callback_type_check');


        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $coa_master_parent_id = $this->post('parent_id') == '' ? '0' : $this->post('parent_id');
                $coa_master_number = $this->post('number');
                $coa_master_title = $this->post('title');
                $coa_master_title_alias = $this->post('title_alias');
                $coa_master_is_positive = $this->post('is_positive');
                $coa_master_type = $this->post('type');
                $coa_master_tag = $this->post('tag');

                $data = array();
                $data['coa_master_parent_id'] = $coa_master_parent_id;
                $data['coa_master_number'] = $coa_master_number;
                $data['coa_master_title'] = $coa_master_title;
                $data['coa_master_title_alias'] = $coa_master_title_alias;
                $data['coa_master_is_positive'] = $coa_master_is_positive;
                $data['coa_master_type'] = $coa_master_type;
                $data['coa_master_tag'] = $coa_master_tag;

                $this->db->insert('sys_coa_master', $data);

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

    public function act_update_put()
    {
        $set_data = array(
            'number' => $this->put('number'),
            'title' => $this->put('title'),
            'is_positive' => $this->put('is_positive'),
            'type' => $this->put('type'),
        );

        $this->form_validation->set_data($set_data);

        $this->form_validation->set_rules('number', '<b>No. Rekening</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('title', '<b>Nama Akun</b>', 'required|max_length[100]');
        $this->form_validation->set_rules('is_positive', '<b>Positive</b>', 'callback_is_positive_check');
        $this->form_validation->set_rules('type', '<b>Tipe</b>', 'required|callback_type_check');

        if (!empty($this->put('province'))) {
            $this->form_validation->set_rules('city', '<b>Kota/Kabupaten</b>', 'required');
            $this->form_validation->set_rules('subdistrict', '<b>Kecamatan</b>', 'required');
        }

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $coa_master_id = $this->put('id');
                $coa_master_parent_id = $this->put('parent_id') == '' ? '0' : $this->put('parent_id');
                $coa_master_number = $this->put('number');
                $coa_master_title = $this->put('title');
                $coa_master_title_alias = $this->put('title_alias');
                $coa_master_is_positive = $this->put('is_positive');
                $coa_master_type = $this->put('type');
                $coa_master_tag = $this->put('tag');

                $data = array();
                $data['coa_master_parent_id'] = $coa_master_parent_id;
                $data['coa_master_number'] = $coa_master_number;
                $data['coa_master_title'] = $coa_master_title;
                $data['coa_master_title_alias'] = $coa_master_title_alias;
                $data['coa_master_is_positive'] = $coa_master_is_positive;
                $data['coa_master_type'] = $coa_master_type;
                $data['coa_master_tag'] = $coa_master_tag;

                $this->db->where('coa_master_id', $coa_master_id);
                $this->db->update('sys_coa_master', $data);

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

    public function act_delete_post()
    {
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                //hapus data
                $this->db->where('coa_master_id', $id);
                $this->db->delete('sys_coa_master');

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

    private function get_coa_master($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'coa_master_id',
            'coa_master_parent_id',
            'coa_master_number',
            'coa_master_title',
            'coa_master_title_alias',
            'coa_master_is_positive',
            'coa_master_type',
            'coa_master_tag',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'coa_master_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_coa_master
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_coa_master($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_coa_master($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(coa_master_id) as total
            FROM sys_coa_master
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

    public function is_positive_check($str){
        $this->form_validation->set_message('is_positive_check', '{field} hanya boleh 0 atau 1.');
        if($str != '1' && $str != '0'){
            return false;
        }
        return true;
    }

    public function type_check($str){
        $arr_type = array('aktiva', 'pasiva', 'pendapatan', 'biaya', 'nominal');
        $pesan = '{field} hanya boleh ' . implode(', ',$arr_type) . '.';
        $this->form_validation->set_message('type_check', $pesan);
        if(!in_array($str, $arr_type)){
            return false;
        }
        return true;
    }
}

/* End of file Coa_master.php */
