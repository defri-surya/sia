<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends Auth_Api_Controller {

    
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

        $start = ($page - 1) * $limit;

        $results = $this->get_branch($start, $limit, $sort, $dir, $filter);
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
                    branch_id,
                    branch_code,
                    branch_name,
                    branch_address,
                    branch_province_name,
                    branch_city_name,
                    branch_subdistrict_name,
                    branch_village_name,
                    branch_zip_code,
                    company_id,
                    company_title,
                    company_address,
                    company_province_name,
                    company_city_name,
                    company_subdistrict_name,
                    company_zip_code,
                    company_phone_fax,
                    IFNULL(json_extract(company_phone_fax, '$.results'), '[]') AS company_phone_fax,
                    IFNULL(json_extract(company_contact_person, '$.results'), '[]') AS company_contact_person,
                    IFNULL(json_extract(branch_phone_fax, '$.results'), '[]') AS branch_phone_fax,
                    IFNULL(json_extract(branch_contact_person, '$.results'), '[]') AS branch_contact_person
                FROM sys_branch
                JOIN sys_company ON company_id = branch_company_id
                WHERE branch_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            $data['company_phone_fax'] = json_decode($data['company_phone_fax']);
            $data['company_contact_person'] = json_decode($data['company_contact_person']);
            $data['branch_phone_fax'] = json_decode($data['branch_phone_fax']);
            $data['branch_contact_person'] = json_decode($data['branch_contact_person']);
            if(!empty($data)){
                $this->createResponse(REST_Controller::HTTP_OK,  $data);
            }else{
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Unit.');    
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Unit.');
        }
    }

    public function act_add_post(){
        $this->form_validation->set_rules('code', '<b>Kode Cabang</b>', 'required|max_length[5]|callback_code_check');
        $this->form_validation->set_rules('name', '<b>Nama Cabang</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('address', '<b>Alamat Cabang</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('zip_code', '<b>Kode Pos</b>', 'numeric');

        if (!empty($this->post('province'))) {
            $this->form_validation->set_rules('city', '<b>Kota/Kabupaten</b>', 'required');
            $this->form_validation->set_rules('subdistrict', '<b>Kecamatan</b>', 'required');
            $this->form_validation->set_rules('village', '<b>Kelurahan</b>', 'required');
        }

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $branch_company_id = 1;

                $branch_code = $this->post('code');
                $branch_name = $this->post('name');
                $branch_address = $this->post('address');
                $branch_province_name = $this->post('province');
                $branch_city_name = $this->post('city');
                $branch_subdistrict_name = $this->post('subdistrict');
                $branch_village_name = $this->post('village');
                $branch_zip_code = $this->post('zip_code');
                $branch_phone_fax = $this->post('phone_fax') == '' ? '[]' : $this->post('phone_fax');
                $branch_contact_person = $this->post('contact_person') == '' ? '[]' : $this->post('contact_person');

                $branch_phone_fax = '{"results": ' . $branch_phone_fax . '}';
                $branch_contact_person = '{"results": ' . $branch_contact_person . '}';

                $data = array();
                $data['branch_company_id'] = $branch_company_id;
                $data['branch_code'] = $branch_code;
                $data['branch_name'] = $branch_name;
                $data['branch_address'] = $branch_address;
                $data['branch_province_name'] = $branch_province_name;
                $data['branch_city_name'] = $branch_city_name;
                $data['branch_subdistrict_name'] = $branch_subdistrict_name;
                $data['branch_village_name'] = $branch_village_name;
                $data['branch_zip_code'] = $branch_zip_code;
                $data['branch_phone_fax'] = $branch_phone_fax;
                $data['branch_contact_person'] = $branch_contact_person;

                $this->db->insert('sys_branch', $data);

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

    public function act_update_put(){
        $set_data = array(
            'code' => $this->put('code'),
            'name' => $this->put('name'),
            'address' => $this->put('address'),
            'zip_code' => $this->put('zip_code'),
            'city' => $this->put('city'),
            'subdistrict' => $this->put('subdistrict'),
            'village' => $this->put('village'),
        );

        $this->form_validation->set_data($set_data);
        
        $branch_id = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->put('id') : $this->get_user('user_auth_branch_id');

        $this->form_validation->set_rules('code', '<b>Kode Cabang</b>', 'required|max_length[5]|callback_code_check[' . $branch_id . ']');
        $this->form_validation->set_rules('name', '<b>Nama Cabang</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('address', '<b>Alamat Cabang</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('zip_code', '<b>Kode Pos</b>', 'numeric');

        if (!empty($this->put('province'))) {
            $this->form_validation->set_rules('city', '<b>Kota/Kabupaten</b>', 'required');
            $this->form_validation->set_rules('subdistrict', '<b>Kecamatan</b>', 'required');
            $this->form_validation->set_rules('village', '<b>Kelurahan</b>', 'required');
        }

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {

                $branch_code = $this->put('code');
                $branch_name = $this->put('name');
                $branch_address = $this->put('address');
                $branch_province_name = $this->put('province');
                $branch_city_name = $this->put('city');
                $branch_subdistrict_name = $this->put('subdistrict');
                $branch_village_name = $this->put('village');
                $branch_zip_code = $this->put('zip_code');
                $branch_phone_fax = $this->put('phone_fax') == '' ? '[]' : $this->put('phone_fax');
                $branch_contact_person = $this->put('contact_person') == '' ? '[]' : $this->put('contact_person');

                $branch_phone_fax = '{"results": ' . $branch_phone_fax . '}';
                $branch_contact_person = '{"results": ' . $branch_contact_person . '}';

                $data = array();
                $data['branch_code'] = $branch_code;
                $data['branch_name'] = $branch_name;
                $data['branch_address'] = $branch_address;
                $data['branch_province_name'] = $branch_province_name;
                $data['branch_city_name'] = $branch_city_name;
                $data['branch_subdistrict_name'] = $branch_subdistrict_name;
                $data['branch_village_name'] = $branch_village_name;
                $data['branch_zip_code'] = $branch_zip_code;
                $data['branch_phone_fax'] = $branch_phone_fax;
                $data['branch_contact_person'] = $branch_contact_person;

                $this->db->where('branch_id', $branch_id);
                $this->db->update('sys_branch', $data);

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
        if ($this->get_user('user_auth_type') == 'superuser') {

            $arr_item = json_decode($this->post('item'));
            if (is_array($arr_item)) {
                $success = $failed = 0;
                foreach ($arr_item as $id) {

                    $is_error = false;
                    $this->db->trans_begin();

                    //hapus data
                    $this->db->where('branch_id', $id);
                    $this->db->delete('sys_branch');

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
                if($failed > 0){
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
                }else{
                    $this->createResponse(REST_Controller::HTTP_OK, $message);
                }
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal hapus data! Silahkan coba lagi.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal hapus data! Silahkan coba lagi.');
        }
    }

    public function code_check($str, $params = '')
    {

        if ($params != '') {
            $sql = "
                SELECT COUNT(*) AS rows_count 
                FROM sys_branch 
                WHERE branch_code = '" . $str . "' 
                AND branch_id != '" . $params . "'
            ";
        } else {
            $sql = "
                SELECT COUNT(*) AS rows_count 
                FROM sys_branch 
                WHERE branch_code = '" . $str . "'
            ";
        }
        $this->form_validation->set_message('code_check', '{field} sudah digunakan.');
        $query = $this->db->query($sql);
        $row = $query->row();
        return ($row->rows_count > 0) ? false : true;
    }


    private function get_branch($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'branch_id',
            'branch_code',
            'branch_name',
            'branch_address',
            'branch_province_name',
            'branch_city_name',
            'branch_subdistrict_name',
            'branch_village_name',
            'branch_zip_code',
            'company_id',
            'company_title',
            'company_address',
            'company_province_name',
            'company_city_name',
            'company_subdistrict_name',
            'company_village_name',
            'company_zip_code',
            'company_phone_fax',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'branch_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search,
            IFNULL(json_extract(company_phone_fax, '$.results'), '[]') AS company_phone_fax,
            IFNULL(json_extract(company_contact_person, '$.results'), '[]') AS company_contact_person,
            IFNULL(json_extract(branch_phone_fax, '$.results'), '[]') AS branch_phone_fax,
            IFNULL(json_extract(branch_contact_person, '$.results'), '[]') AS branch_contact_person
            FROM sys_branch
            JOIN sys_company ON company_id = branch_company_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_branch($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $row['company_phone_fax'] = json_decode($row['company_phone_fax']);
                $row['company_contact_person'] = json_decode($row['company_contact_person']);
                $row['branch_phone_fax'] = json_decode($row['branch_phone_fax']);
                $row['branch_contact_person'] = json_decode($row['branch_contact_person']);
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_branch($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(branch_id) as total
            FROM sys_branch
            JOIN sys_company ON company_id = branch_company_id
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

/* End of file Branch.php */
