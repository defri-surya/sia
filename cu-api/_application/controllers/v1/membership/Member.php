<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Auth_Api_Controller {

    
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
        $is_export = (integer)$this->get('export');
        if ($is_export != 0 && $is_export != 1) {
            $is_export = 0;
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_member($start, $limit, $sort, $dir, $filter, $is_export);
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

    public function get_detail_get(){
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    member_id,
                    member_branch_id,
                    member_code,
                    member_temp_code,
                    member_name,
                    member_identity_number,
                    member_identity_type,
                    member_gender,
                    member_birthdate,
                    member_birthplace,
                    member_status,
                    member_join_datetime,
                    member_registered_date,
                    member_input_admin_name,
                    member_input_datetime,
                    member_is_diksar,
                    member_diksar_date,
                    member_nationality,
                    member_working_in,
                    member_entrance_fee_paid_off,
                    member_entrance_fee_due_date,
                    member_referal_member_id,
                    member_is_pic,
                    member_pic_area,
                    member_pic_member_id,
                    member_saving_obligation,
                    member_address,
                    member_province,
                    member_city,
                    member_subdistrict,
                    member_kelurahan,
                    member_rt_number,
                    member_rw_number,
                    member_zipcode,
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
                    member_job,
                    member_job_detail,
                    member_average_income,
                    member_last_education,
                    member_religion,
                    member_ethnic_group,
                    member_is_married,
                    member_husband_wife_name,
                    member_child_name,
                    member_mother_name,
                    member_is_registered_others_cu,
                    member_others_cu_name,
                    member_heir_name,
                    member_heir_status,
                    member_signature_filename,
                    member_signature_path,
                    member_photo_filename,
                    member_photo_path,
                    member_identity_filename,
                    member_identity_path,
                    member_school_name,
                    member_class_at_school,
                    member_school_address,
                    member_father_name,
                    member_family_address,
                    member_family_phone_number,
                    member_number_of_siblings,
                    member_residence_status,
                    member_blood_type,
                    member_shirt_size,
                    branch_id,
                    branch_code,
                    branch_name,
                    branch_address,
                    branch_province_name,
                    branch_city_name,
                    branch_subdistrict_name,
                    branch_village_name,
                    branch_zip_code
                FROM sys_member
                JOIN sys_member_address ON member_id = member_address_id
                JOIN sys_member_profile ON member_id = member_profile_id
                JOIN sys_branch ON branch_id = member_branch_id
                WHERE member_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data Anggota.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data Anggota.');
        }
    }

    public function act_update_put(){
        $set_data = array(
            'member_id' => $this->put('member_id'),
            'name' => $this->put('name'),
        );

        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('member_id', '<b>ID Anggota</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Anggota</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();
            
            try {
                
                $id = $this->put('member_id');

                $data_member = array();

                $name = $this->put('name');
                $data_member['member_name'] = $name;
                
                $identity_number = $this->put('identity_number');
                if(!empty($identity_number)){
                    $data_member['member_identity_number'] = $identity_number;
                }

                $identity_type = $this->put('identity_type');
                if(isset($identity_type)){
                    $data_member['member_identity_type'] = $identity_type;
                }

                $gender = $this->put('gender');
                if(isset($gender)){
                    $data_member['member_gender'] = $gender;
                }

                $birthdate = $this->put('birthdate');
                if(!empty($birthdate)){
                    $data_member['member_birthdate'] = $birthdate;
                }

                $birthplace = $this->put('birthplace');
                if(!empty($birthplace)){
                    $data_member['member_birthplace'] = $birthplace;
                }

                $status = $this->put('status');
                if(isset($status)){
                    $data_member['member_status'] = $status;
                }

                $join_datetime = $this->put('join_datetime');
                if(!empty($join_datetime)){
                    $data_member['member_join_datetime'] = $join_datetime;
                }

                $nationality = $this->put('nationality');
                if(isset($nationality)){
                    $data_member['member_nationality'] = $nationality;
                }

                $working_in = $this->put('working_in');
                if(isset($working_in)){
                    $data_member['member_working_in'] = $working_in;
                }

                $this->db->where('member_id', $id);
                $this->db->update('sys_member', $data_member);

                if ($this->db->affected_rows() < 0) {
                    throw new Exception("Error Update Member Data", 1);
                }

                $data_address = array();
                $address = $this->put('address');
                if (!empty($address)) {
                    $data_address['member_address'] = $address;
                }

                $province = $this->put('province');
                if (!empty($province)) {
                    $data_address['member_province'] = $province;
                }

                $city = $this->put('city');
                if (!empty($city)) {
                    $data_address['member_city'] = $city;
                }

                $subdistrict = $this->put('subdistrict');
                if (!empty($subdistrict)) {
                    $data_address['member_subdistrict'] = $subdistrict;
                }

                $kelurahan = $this->put('kelurahan');
                if (!empty($kelurahan)) {
                    $data_address['member_kelurahan'] = $kelurahan;
                }

                $rt_number = $this->put('rt_number');
                if (!empty($rt_number)) {
                    $data_address['member_rt_number'] = $rt_number;
                }

                $rw_number = $this->put('rw_number');
                if (!empty($rw_number)) {
                    $data_address['member_rw_number'] = $rw_number;
                }

                $zipcode = $this->put('zipcode');
                if (!empty($zipcode)) {
                    $data_address['member_zipcode'] = $zipcode;
                }

                $address_domicile = $this->put('address_domicile');
                if (!empty($address)) {
                    $data_address['member_address_domicile'] = $address_domicile;
                }

                $domicile_province = $this->put('domicile_province');
                if (!empty($domicile_province)) {
                    $data_address['member_domicile_province'] = $domicile_province;
                }

                $domicile_city = $this->put('domicile_city');
                if (!empty($domicile_city)) {
                    $data_address['member_domicile_city'] = $domicile_city;
                }

                $domicile_subdistrict = $this->put('domicile_subdistrict');
                if (!empty($domicile_subdistrict)) {
                    $data_address['member_domicile_subdistrict'] = $domicile_subdistrict;
                }

                $domicile_kelurahan = $this->put('domicile_kelurahan');
                if (!empty($domicile_kelurahan)) {
                    $data_address['member_domicile_kelurahan'] = $domicile_kelurahan;
                }

                $domicile_rt_number = $this->put('domicile_rt_number');
                if (!empty($domicile_rt_number)) {
                    $data_address['member_domicile_rt_number'] = $domicile_rt_number;
                }

                $domicile_rw_number = $this->put('domicile_rw_number');
                if (!empty($domicile_rw_number)) {
                    $data_address['member_domicile_rw_number'] = $domicile_rw_number;
                }

                $domicile_zipcode = $this->put('domicile_zipcode');
                if (!empty($domicile_zipcode)) {
                    $data_address['member_domicile_zipcode'] = $domicile_zipcode;
                }
                
                $phone_number = $this->put('phone_number');
                if (!empty($phone_number)) {
                    $data_address['member_phone_number'] = $phone_number;
                }

                $mobilephone_number = $this->put('mobilephone_number');
                if (!empty($mobilephone_number)) {
                    $data_address['member_mobilephone_number'] = $mobilephone_number;
                }

                if(!empty($data_address)){
                    $this->db->where('member_address_id', $id);
                    $this->db->update('sys_member_address', $data_address);
    
                    if ($this->db->affected_rows() < 0) {
                        throw new Exception("Error Update Member Address Data", 1);
                    }
                }

                $data_profile = array();
                $job = $this->put('job');
                if (!empty($job)) {
                    $data_profile['member_job'] = $job;
                }
                
                $job_detail = $this->put('job_detail');
                if (!empty($job_detail)) {
                    $data_profile['member_job_detail'] = $job_detail;
                }
                
                $average_income = $this->put('average_income');
                if (isset($average_income)) {
                    $data_profile['member_average_income'] = $average_income;
                }

                $last_education = $this->put('last_education');
                if (isset($last_education)) {
                    $data_profile['member_last_education'] = $last_education;
                }

                $religion = $this->put('religion');
                if (isset($religion)) {
                    $data_profile['member_religion'] = $religion;
                }

                $ethnic_group = $this->put('ethnic_group');
                if (!empty($ethnic_group)) {
                    $data_profile['member_ethnic_group'] = $ethnic_group;
                }

                $is_married = $this->put('is_married');
                if (isset($is_married)) {
                    $data_profile['member_is_married'] = $is_married;
                }

                $husband_wife_name = $this->put('husband_wife_name');
                if (!empty($husband_wife_name)) {
                    $data_profile['member_husband_wife_name'] = $husband_wife_name;
                }

                $child_name = $this->put('child_name');
                if (!empty($child_name)) {
                    $data_profile['member_child_name'] = $child_name;
                }

                $mother_name = $this->put('mother_name');
                if (!empty($mother_name)) {
                    $data_profile['member_mother_name'] = $mother_name;
                }

                $is_registered_others_cu = $this->put('is_registered_others_cu');
                if (isset($is_registered_others_cu)) {
                    $data_profile['member_is_registered_others_cu'] = $is_registered_others_cu;
                }

                $others_cu_name = $this->put('others_cu_name');
                if (!empty($others_cu_name)) {
                    $data_profile['member_others_cu_name'] = $others_cu_name;
                }

                $heir_name = $this->put('heir_name');
                if (!empty($heir_name)) {
                    $data_profile['member_heir_name'] = $heir_name;
                }

                $heir_status = $this->put('heir_status');
                if (!empty($heir_status)) {
                    $data_profile['member_heir_status'] = $heir_status;
                }

                $signature_filename = $this->put('signature_filename');
                if (!empty($signature_filename)) {
                    $data_profile['member_signature_filename'] = $signature_filename;
                }

                $signature_path = $this->put('signature_path');
                if (!empty($signature_path)) {
                    $data_profile['member_signature_path'] = $signature_path;
                }

                $photo_filename = $this->put('photo_filename');
                if (!empty($photo_filename)) {
                    $data_profile['member_photo_filename'] = $photo_filename;
                }

                $photo_path = $this->put('photo_path');
                if (!empty($photo_path)) {
                    $data_profile['member_photo_path'] = $photo_path;
                }

                $identity_filename = $this->put('identity_filename');
                if (!empty($identity_filename)) {
                    $data_profile['member_identity_filename'] = $identity_filename;
                }

                $identity_path = $this->put('identity_path');
                if (!empty($identity_path)) {
                    $data_profile['member_identity_path'] = $identity_path;
                }

                $school_name = $this->put('school_name');
                if (!empty($school_name)) {
                    $data_profile['member_school_name'] = $school_name;
                }

                $class_at_school = $this->put('class_at_school');
                if (!empty($class_at_school)) {
                    $data_profile['member_class_at_school'] = $class_at_school;
                }

                $school_address = $this->put('school_address');
                if (!empty($school_address)) {
                    $data_profile['member_school_address'] = $school_address;
                }

                $father_name = $this->put('father_name');
                if (!empty($father_name)) {
                    $data_profile['member_father_name'] = $father_name;
                }

                $family_address = $this->put('family_address');
                if (!empty($family_address)) {
                    $data_profile['member_family_address'] = $family_address;
                }

                $family_phone_number = $this->put('family_phone_number');
                if (!empty($family_phone_number)) {
                    $data_profile['member_family_phone_number'] = $family_phone_number;
                }

                $number_of_siblings = $this->put('number_of_siblings');
                if (!empty($number_of_siblings)) {
                    $data_profile['member_number_of_siblings'] = $number_of_siblings;
                }

                $residence_status = $this->put('residence_status');
                if (isset($residence_status)) {
                    $data_profile['member_residence_status'] = $residence_status;
                }

                $blood_type = $this->put('blood_type');
                if (isset($blood_type)) {
                    $data_profile['member_blood_type'] = $blood_type;
                }

                $shirt_size = $this->put('shirt_size');
                if (isset($shirt_size)) {
                    $data_profile['member_shirt_size'] = $shirt_size;
                }

                if(!empty($data_profile)){
                    $this->db->where('member_profile_id', $id);
                    $this->db->update('sys_member_profile', $data_profile);
    
                    if ($this->db->affected_rows() < 0) {
                        throw new Exception("Error Update Member Profile Data", 1);
                    }
                }

                $this->common_model->update_member_status($id);

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

    public function act_delete_post(){
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                //hapus data
                $this->db->where('member_id', $id);
                $this->db->delete('sys_member');

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

    private function get_member($start, $limit, $sort, $dir, $filter, $is_export){
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_id',
            'member_branch_id',
            'member_code',
            'member_temp_code',
            'member_name',
            'member_identity_number',
            'member_identity_type',
            'member_gender',
            'member_birthdate',
            'member_birthplace',
            'member_status',
            'member_join_datetime',
            'member_registered_date',
            'member_input_admin_name',
            'member_input_datetime',
            'member_is_diksar',
            'member_diksar_date',
            'member_nationality',
            'member_working_in',
            'member_entrance_fee_paid_off',
            'member_entrance_fee_due_date',
            'member_referal_member_id',
            'member_is_pic',
            'member_pic_area',
            'member_pic_member_id',
            'member_saving_obligation',
            'member_nik_number',
            'member_address',
            'member_province',
            'member_city',
            'member_subdistrict',
            'member_kelurahan',
            'member_rt_number',
            'member_rw_number',
            'member_zipcode',
            'member_address_domicile',
            'member_domicile_province',
            'member_domicile_city',
            'member_domicile_subdistrict',
            'member_domicile_kelurahan',
            'member_domicile_rt_number',
            'member_domicile_rw_number',
            'member_domicile_zipcode',
            'member_phone_number',
            'member_mobilephone_number',
            'member_job',
            'member_job_detail',
            'member_average_income',
            'member_last_education',
            'member_religion',
            'member_ethnic_group',
            'member_is_married',
            'member_husband_wife_name',
            'member_child_name',
            'member_mother_name',
            'member_is_registered_others_cu',
            'member_others_cu_name',
            'member_heir_name',
            'member_heir_status',
            'member_signature_filename',
            'member_signature_path',
            'member_photo_filename',
            'member_photo_path',
            'member_identity_filename',
            'member_identity_path',
            'member_school_name',
            'member_class_at_school',
            'member_school_address',
            'member_father_name',
            'member_family_address',
            'member_family_phone_number',
            'member_number_of_siblings',
            'member_residence_status',
            'member_blood_type',
            'member_shirt_size',
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

        $sql_limit = "LIMIT $start, $limit";
        if($is_export == 1){
            $sql_limit = '';
        }

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member
            JOIN sys_member_address ON member_id = member_address_id
            JOIN sys_member_profile ON member_id = member_profile_id
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            $sql_limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member($query_search = ''){
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_id) as total
            FROM sys_member
            JOIN sys_member_address ON member_id = member_address_id
            JOIN sys_member_profile ON member_id = member_profile_id
            JOIN sys_branch ON branch_id = member_branch_id
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

/* End of file Member.php */
