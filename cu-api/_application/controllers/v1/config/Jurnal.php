<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal extends Auth_Api_Controller {

    
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

        $results = $this->get_jurnal_config($start, $limit, $sort, $dir, $filter);
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
    
    public function get_data_jurnal_master_get()
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
    
    public function get_data_jurnal_master_detail_get()
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

        $results = $this->get_jurnal_master_detail($start, $limit, $sort, $dir, $filter);
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
                    jurnal_config_id,
                    jurnal_config_jurnal_master_id,
                    jurnal_config_name,
                    jurnal_config_title
                FROM sys_jurnal_config
                WHERE jurnal_config_id = $id
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config Jurnal.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Config Jurnal.');
        }
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('jurnal_master_id', '<b>Jurnal Master</b>', 'required');
        $this->form_validation->set_rules('title', '<b>Judul Jurnal</b>', 'required|max_length[50]');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $title = $this->post('title');
                $jurnal_config_jurnal_master_id = $this->post('jurnal_master_id');
                $jurnal_config_name = str_replace(' ', '_', strtolower($title));
                $jurnal_config_title = $title;

                $data = array();
                $data['jurnal_config_jurnal_master_id'] = $jurnal_config_jurnal_master_id;
                $data['jurnal_config_name'] = $jurnal_config_name;
                $data['jurnal_config_title'] = $jurnal_config_title;

                if (!$this->db->insert('sys_jurnal_config', $data)) {
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
            'name' => $this->put('name'),
            'title' => $this->put('title'),
            'jurnal_master_id' => $this->put('jurnal_master_id')
        );

        $this->form_validation->set_data($set_data);

        $this->form_validation->set_rules('jurnal_master_id', '<b>Jurnal Master</b>', 'required');
        $this->form_validation->set_rules('title', '<b>Judul Jurnal</b>', 'required|max_length[50]');

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $title = $this->put('title');
                $jurnal_config_id = $this->put('id');
                $jurnal_config_jurnal_master_id = $this->put('jurnal_master_id');
                $jurnal_config_name = str_replace(' ', '_', strtolower($title));
                $jurnal_config_title = $title;

                $data = array();
                $data['jurnal_config_jurnal_master_id'] = $jurnal_config_jurnal_master_id;
                $data['jurnal_config_name'] = $jurnal_config_name;
                $data['jurnal_config_title'] = $jurnal_config_title;
                $this->db->where('jurnal_config_id', $jurnal_config_id);
                $this->db->update('sys_jurnal_config', $data);

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
                $this->db->where('jurnal_config_id', $id);
                $this->db->delete('sys_jurnal_config');

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

    private function get_jurnal_config($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'jurnal_config_id',
            'jurnal_config_jurnal_master_id',
            'jurnal_config_name',
            'jurnal_config_title',
            'jurnal_master_title',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'jurnal_config_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_jurnal_config
            JOIN sys_jurnal_master ON jurnal_config_jurnal_master_id = jurnal_master_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_jurnal_config($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_jurnal_config($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(jurnal_config_id) as total
            FROM sys_jurnal_config
            JOIN sys_jurnal_master ON jurnal_config_jurnal_master_id = jurnal_master_id
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
    
    private function get_jurnal_master_detail($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'jurnal_master_detail_id',
            'jurnal_master_detail_jurnal_master_id',
            'jurnal_master_detail_note',
            'jurnal_master_detail_debet',
            'jurnal_master_detail_kredit',
            'coa_master_id',
            'coa_master_title',
            'coa_master_number'
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'jurnal_master_detail_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_jurnal_master_detail
            JOIN sys_coa_master ON jurnal_master_detail_coa_master_id = coa_master_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_jurnal_master_detail($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $row['jurnal_master_detail_kredit'] = round($row['jurnal_master_detail_kredit']);
                $row['jurnal_master_detail_debet'] = round($row['jurnal_master_detail_debet']);
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }
    
    private function count_jurnal_master_detail($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(jurnal_master_detail_id) as total
            FROM sys_jurnal_master_detail
            JOIN sys_coa_master ON jurnal_master_detail_coa_master_id = coa_master_id
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

}

/* End of file Jurnal.php */
