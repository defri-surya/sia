<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    
    public function get_data_get()
    {
        $sql_get = "
            SELECT
                company_id,
                company_title,
                company_address,
                company_province_name,
                company_city_name,
                company_subdistrict_name,
                company_village_name,
                company_zip_code,
                IFNULL(json_extract(company_phone_fax, '$.results'), '[]') AS company_phone_fax,
                IFNULL(json_extract(company_contact_person, '$.results'), '[]') AS company_contact_person
            FROM sys_company
        ";
        $query = $this->db->query($sql_get)->row_array();

        $query['company_phone_fax'] = json_decode($query['company_phone_fax']);
        $query['company_contact_person'] = json_decode($query['company_contact_person']);

        $data = array(
            "results" => array_map("convertNullToString", $query)
        );

        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function act_update_put(){
        $set_data = array(
            'title' => $this->put('title'),
            'address' => $this->put('address'),
            'zip_code' => $this->put('zip_code'),
            'city' => $this->put('city'),
            'subdistrict' => $this->put('subdistrict'),
            'village' => $this->put('village'),
        );

        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('title', '<b>Nama CU</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('address', '<b>Alamat CU</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('zip_code', '<b>Kode Pos</b>', 'numeric');

        if (!empty($this->put('province'))) {
            $this->form_validation->set_rules('city', '<b>Kota/Kabupaten</b>', 'required');
            $this->form_validation->set_rules('subdistrict', '<b>Kecamatan</b>', 'required');
            $this->form_validation->set_rules('village', '<b>Kelurahan</b>', 'required');
        }

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = FALSE;

            $this->db->trans_begin();

            try {
                $company_id = 1;
                $company_title = $this->put('title');
                $company_address = $this->put('address');
                $company_province_name = $this->put('province');
                $company_city_name = $this->put('city');
                $company_subdistrict_name = $this->put('subdistrict');
                $company_village_name = $this->put('village');
                $company_zip_code = $this->put('zip_code');
                $company_phone_fax = $this->put('phone_fax') == '' ? '[]' : $this->put('phone_fax');
                $company_contact_person = $this->put('contact_person') == '' ? '[]' : $this->put('contact_person');

                $company_phone_fax = '{"results": ' . $company_phone_fax . '}';
                $company_contact_person = '{"results": ' . $company_contact_person . '}';

                $data = array();
                $data['company_title'] = $company_title;
                $data['company_address'] = $company_address;
                $data['company_province_name'] = $company_province_name;
                $data['company_city_name'] = $company_city_name;
                $data['company_subdistrict_name'] = $company_subdistrict_name;
                $data['company_village_name'] = $company_village_name;
                $data['company_zip_code'] = $company_zip_code;
                $data['company_phone_fax'] = $company_phone_fax;
                $data['company_contact_person'] = $company_contact_person;

                $this->db->where('company_id', $company_id);
                $this->db->update('sys_company', $data);

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

/* End of file Company.php */
