<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $this->template->content("setup/company_list_view");
        $this->template->show('template');
    }

    public function get_data() {
        $res = $this->curl->get(URL_API . 'setup/company/get_data');
        $response = json_decode($res);
        
        $json_data = array();

        if ($response->status == 200) {
            $row = $response->data->results;

            header("Content-type: application/json");
            $json_data = array('page' => 1, 'total' => 1, 'rows' => array());

            $detail = '<a href="javascript:;" onclick="company.openModalDetail(' . $row->company_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
            $edit = '<a href="javascript:;" onclick="actionUpdate.openModalUpdate(' . $row->company_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

            $entry = array('id' => $row->company_id,
                'cell' => array(
                    'company_title' => $row->company_title,
                    'company_address' => $row->company_address,
                    'company_province_name' => $row->company_province_name,
                    'company_city_name' => $row->company_city_name,
                    'company_subdistrict_name' => $row->company_subdistrict_name,
                    'company_village_name' => $row->company_village_name,
                    'company_zip_code' => $row->company_zip_code,
                    'detail' => $detail,
                    'edit' => $edit
                ),
            );

            $phonefax = $row->company_phone_fax;
            $contactperson = $row->company_contact_person;

            $str_phone_fax = '';
            $str_contact_person = '';

            if (isset($phonefax[0])) {
                $str_phone_fax = '
                    <ul style="padding-left: 20px;">
                        <li><strong>Fax</strong> : ' . $phonefax[0]->fax . '</li>
                        <li><strong>Telepon</strong> : ' . $phonefax[0]->phone . '</li>
                        <li><strong>HP</strong> : ' . $phonefax[0]->mobile_phone . '</li>
                    </ul>
                ';
            }

            if (isset($contactperson[0])) {
                $str_contact_person = '
                    <ul style="padding-left: 20px;">
                        <li><strong>Nama</strong> : ' . $contactperson[0]->name . '</li>
                        <li><strong>Alamat</strong> : ' . $contactperson[0]->address . '</li>
                        <li><strong>Telepon</strong> : ' . $contactperson[0]->phone . '</li>
                    </ul>
                ';
            }

            $entry['cell']['phone_fax'] = $str_phone_fax;
            $entry['cell']['contact_person'] = $str_contact_person;

            $json_data['rows'][] = $entry;
            
        }
        echo json_encode($json_data);
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'setup/company/act_update', $this->input->post());
        echo $res;
    }

}
