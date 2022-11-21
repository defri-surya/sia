<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends Auth_Api_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('name', '<b>Nama Pemohon</b>', 'required');
        $this->form_validation->set_rules('branch_id', '<b>Unit</b>', 'required');
        $this->form_validation->set_rules('identity_type', '<b>Identitas</b>', 'required');
        $this->form_validation->set_rules('identity_number', '<b>Identitas</b>', 'required');
        $this->form_validation->set_rules('birthplace', '<b>Tempat Lahir</b>', 'required');
        $this->form_validation->set_rules('birthdate', '<b>Tanggal Lahir</b>', 'required');
        $this->form_validation->set_rules('join_datetime', '<b>Tanggal Bergabung</b>', 'required');
        $this->form_validation->set_rules('mother_name', '<b>Ibu Kandung</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            $this->db->trans_begin();
            try {
                $branch_id = $this->get_user('user_auth_branch_id');
                if ($this->get_user('user_auth_type') != 'administrator_branch') {
                    $branch_id = $this->post('branch_id');
                }
                // $code = $this->post('code');
                $name = $this->post('name');
                // $account_number = $this->post('account_number');
                $nik_number = $this->post('nik_number');
                $saving_obligation = $this->post('saving_obligation');
                $referal_member_id = $this->post('referal_member_id');
                $identity_number = $this->post('identity_number');
                $identity_type = $this->post('identity_type');
                $gender = $this->post('gender');
                $birthdate = $this->post('birthdate');
                $birthplace = $this->post('birthplace');
                $address = $this->post('address');
                $province = $this->post('province');
                $city = $this->post('city');
                $subdistrict = $this->post('subdistrict');
                $kelurahan = $this->post('kelurahan');
                $rt_number = $this->post('rt_number');
                $rw_number = $this->post('rw_number');
                $zipcode = $this->post('zipcode');
                $address_domicile = $this->post('address_domicile');
                $domicile_province = $this->post('domicile_province');
                $domicile_city = $this->post('domicile_city');
                $domicile_subdistrict = $this->post('domicile_subdistrict');
                $domicile_kelurahan = $this->post('domicile_kelurahan');
                $domicile_rt_number = $this->post('domicile_rt_number');
                $domicile_rw_number = $this->post('domicile_rw_number');
                $domicile_zipcode = $this->post('domicile_zipcode');
                $phone_number = $this->post('phone_number');
                $mobilephone_number = $this->post('mobilephone_number');
                $job = $this->post('job');
                $job_detail = $this->post('job_detail');
                $working_in = $this->post('working_in');
                $average_income = $this->post('average_income');
                $last_education = $this->post('last_education');
                $religion = $this->post('religion');
                $is_married = $this->post('is_married');
                $husband_wife_name = $this->post('husband_wife_name');
                $child_name = $this->post('child_name');
                $mother_name = $this->post('mother_name');
                $status = 5;
                $is_registered_others_cu = $this->post('is_registered_others_cu');
                $others_cu_name = $this->post('others_cu_name');
                $heir_name = $this->post('heir_name');
                $heir_status = $this->post('heir_status');
                $signature_filename = $this->post('signature_filename');
                $signature_path = $this->post('signature_path');
                $photo_filename = $this->post('photo_filename');
                $photo_path = $this->post('photo_path');
                $identity_filename = $this->post('identity_filename');
                $identity_path = $this->post('identity_path');
                $join_datetime = $this->post('join_datetime');
                $input_datetime = date('Y-m-d H:i:s');
                $is_diksar = $this->post('is_diksar');
                $diksar_date = $this->post('diksar_date');
                $entrance_fee_due_date = date('Y-m-d', strtotime('+3 month', strtotime($join_datetime)));
                $nationality = $this->post('nationality');
                $ethnic_group = $this->post('ethnic_group');
                $residence_status = $this->post('residence_status');
                $blood_type = $this->post('blood_type');
                $shirt_size = $this->post('shirt_size');
                $input_admin_name = $this->get_user('user_auth_name');

                $member_age = 0;
                if (!empty($birthdate) && validate_date($birthdate)) {
                    $member_age = date("Y") - date("Y", strtotime($birthdate));
                }

                $data_member = array();
                $data_member['member_branch_id'] = $branch_id;
                $data_member['member_temp_code'] = $this->common_model->generate_code('sys_member', 'member_temp_code');
                $data_member['member_code'] = $this->common_model->generate_code('sys_member', 'member_temp_code');
                $data_member['member_name'] = $name;
                $data_member['member_identity_number'] = $identity_number == null ? '' : $identity_number;
                $data_member['member_identity_type'] = $identity_type == null ? '' : $identity_type;
                $data_member['member_gender'] = $gender == null ? '' : $gender;
                $data_member['member_birthdate'] = $birthdate == null ? '' : $birthdate;
                $data_member['member_birthplace'] = $birthplace == null ? '' : $birthplace;
                $data_member['member_working_in'] = $working_in == null ? 0 : $working_in;
                $data_member['member_status'] = 0;
                $data_member['member_join_datetime'] = $join_datetime == null ? '' : $join_datetime;
                $data_member['member_registered_date'] = $join_datetime == null ? '' : $join_datetime;
                $data_member['member_is_diksar'] = $is_diksar == null ? 0 : $is_diksar;
                $data_member['member_diksar_date'] = $diksar_date == null ? '' : $diksar_date;
                $data_member['member_entrance_fee_due_date'] = $entrance_fee_due_date == null ? '' : $entrance_fee_due_date;
                $data_member['member_nationality'] = $nationality == null ? 0 : $nationality;
                $data_member['member_working_in'] = $working_in == null ? 0 : $working_in;
                $data_member['member_input_admin_name'] = $input_admin_name;
                $data_member['member_input_datetime'] = $input_datetime;
                $data_member['member_nik_number'] = $nik_number;
                $data_member['member_saving_obligation'] = $saving_obligation;
                $data_member['member_referal_member_id'] = $referal_member_id;

                if (!$this->db->insert('sys_member', $data_member)) {
                    throw new Exception("Error Insert Member Data", 1);
                }

                $data_member['member_id'] = $this->db->insert_id();
                $data_member['member_age'] = $member_age;
                $data_member['option_product'] = $this->get_option_product_by_age($member_age);

                $data_address = array();
                $data_address['member_address_id'] = $data_member['member_id'];
                $data_address['member_address'] = $address == null ? '' : $address;
                $data_address['member_province'] = $province == null ? '' : $province;
                $data_address['member_city'] = $city == null ? '' : $city;
                $data_address['member_subdistrict'] = $subdistrict == null ? '' : $subdistrict;
                $data_address['member_kelurahan'] = $kelurahan == null ? '' : $kelurahan;
                $data_address['member_rt_number'] = $rt_number == null ? '' : $rt_number;
                $data_address['member_rw_number'] = $rw_number == null ? '' : $rw_number;
                $data_address['member_zipcode'] = $zipcode == null ? '' : $zipcode;
                $data_address['member_address_domicile'] = $address_domicile == null ? '' : $address_domicile;
                $data_address['member_domicile_province'] = $domicile_province == null ? '' : $domicile_province;
                $data_address['member_domicile_city'] = $domicile_city == null ? '' : $domicile_city;
                $data_address['member_domicile_subdistrict'] = $domicile_subdistrict == null ? '' : $domicile_subdistrict;
                $data_address['member_domicile_kelurahan'] = $domicile_kelurahan == null ? '' : $domicile_kelurahan;
                $data_address['member_domicile_rt_number'] = $domicile_rt_number == null ? '' : $domicile_rt_number;
                $data_address['member_domicile_rw_number'] = $domicile_rw_number == null ? '' : $domicile_rw_number;
                $data_address['member_domicile_zipcode'] = $domicile_zipcode == null ? '' : $domicile_zipcode;
                $data_address['member_phone_number'] = $phone_number == null ? '' : $phone_number;
                $data_address['member_mobilephone_number'] = $mobilephone_number == null ? '' : $mobilephone_number;
                if (!$this->db->insert('sys_member_address', $data_address)) {
                    throw new Exception("Error Insert Member Address Data", 1);
                }

                $data_profile = array();
                $data_profile['member_profile_id'] = $data_member['member_id'];
                $data_profile['member_job'] = $job == null ? '' : $job;
                $data_profile['member_job_detail'] = $job_detail == null ? '' : $job_detail;
                $data_profile['member_average_income'] = $average_income == null ? '' : $average_income;
                $data_profile['member_last_education'] = $last_education == null ? '' : $last_education;
                $data_profile['member_religion'] = $religion == null ? '' : $religion;
                $data_profile['member_is_married'] = $is_married == null ? '' : $is_married;
                $data_profile['member_husband_wife_name'] = $husband_wife_name == null ? '' : $husband_wife_name;
                $data_profile['member_child_name'] = $child_name == null ? '' : $child_name;
                $data_profile['member_mother_name'] = $mother_name == null ? '' : $mother_name;
                $data_profile['member_is_registered_others_cu'] = $is_registered_others_cu == null ? '' : $is_registered_others_cu;
                $data_profile['member_others_cu_name'] = $others_cu_name == null ? '' : $others_cu_name;
                $data_profile['member_heir_name'] = $heir_name == null ? '' : $heir_name;
                $data_profile['member_ethnic_group'] = $ethnic_group == null ? '' : $ethnic_group;
                $data_profile['member_residence_status'] = $residence_status == null ? '' : $residence_status;
                $data_profile['member_blood_type'] = $blood_type == null ? '' : $blood_type;
                $data_profile['member_shirt_size'] = $shirt_size == null ? '' : $shirt_size;
                $data_profile['member_heir_status'] = $heir_status == null ? '' : $heir_status;
                $data_profile['member_signature_filename'] = $signature_filename == null ? '' : $signature_filename;
                $data_profile['member_signature_path'] = $signature_path == null ? '' : $signature_path;
                $data_profile['member_photo_filename'] = $photo_filename == null ? '' : $photo_filename;
                $data_profile['member_photo_path'] = $photo_path == null ? '' : $photo_path;
                $data_profile['member_identity_filename'] = $identity_filename == null ? '' : $identity_filename;
                $data_profile['member_identity_path'] = $identity_path == null ? '' : $identity_path;
                if (!$this->db->insert('sys_member_profile', $data_profile)) {
                    throw new Exception("Error Insert Member Profile Data", 1);
                }

                if (!$this->db->insert('sys_member_balance', array('member_balance_member_id' => $data_member['member_id']))) {
                    throw new Exception("Error Insert Member Balance", 1);
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
                    $data = array(
                        'member' => $data_member,
                        'address' => $data_address,
                        'profile' => $data_profile,
                    );
                    $this->createResponse(REST_Controller::HTTP_OK, array_merge($data_member, array_merge($data_address, $data_profile)));
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.');
            }
        }
    }

    public function act_add_saving_post()
    {
        $this->form_validation->set_rules('member_id', '<b>Nama Anggota</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('product_saving_id', '<b>Nama Produk Simpanan</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('saving_priode', '<b>Jangka Waktu Simpanan</b>', 'callback_saving_priode_check[' . $this->post('product_saving_id') . ']');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();

                $member_id = $this->post('member_id');
                $product_saving_id = $this->post('product_saving_id');
                $detail_product = $this->get_detail_product($product_saving_id);
                $saving_priode = $this->post('saving_priode');
                $no_rekening = $this->common_model->generate_code('sys_member_product_saving', 'member_product_saving_account_number', 'WHERE member_product_saving_product_saving_id = ' . $product_saving_id, 6);
                $member_detail = $this->common_model->get_member_name_code($member_id);

                $data['member_product_saving_member_id'] = $member_id;
                if ($member_detail->member_code == 'N/A') {
                    $data['member_product_saving_member_code'] = $member_detail->member_temp_code;
                } else {
                    $data['member_product_saving_member_code'] = $member_detail->member_code;
                }
                $data['member_product_saving_member_name'] = $member_detail->member_name;
                $data['member_product_saving_account_number'] = $no_rekening;
                $data['member_product_saving_member_balance'] = 0;
                $data['member_product_saving_is_active'] = 0;
                $data['member_product_saving_period'] = $saving_priode == null ? 0 : $saving_priode;
                $data['member_product_saving_product_saving_id'] = $product_saving_id;
                $data['member_product_saving_name'] = $detail_product->product_saving_name;
                $data['member_product_saving_name_alias'] = $detail_product->product_saving_name_alias;

                $this->db->insert('sys_member_product_saving', $data);

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

    public function saving_priode_check($str, $params)
    {
        $str = (int) $str;
        $product_detail = $this->get_detail_product($params);
        if (!empty($product_detail)) {
            if ($product_detail->product_saving_is_period == 1) {
                if (!empty($str)) {
                    if (is_numeric($str)) {
                        if ($product_detail->product_saving_min_period <= $str) {
                            if ($product_detail->product_saving_max_period == 0) {
                                return true;
                            } else {
                                if ($product_detail->product_saving_max_period < $str) {
                                    $this->form_validation->set_message('saving_priode_check', '{field} lebih dari maksimal');
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        } else {
                            $this->form_validation->set_message('saving_priode_check', '{field} kurang dari minimal');
                            return false;
                        }
                    } else {
                        $this->form_validation->set_message('saving_priode_check', '{field} tidak harus angka');
                        return false;
                    }
                } else {
                    $this->form_validation->set_message('saving_priode_check', '{field} tidak boleh kosong');
                    return false;
                }
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('saving_priode_check', '{field} produk simpanan tidak ditemukan.');
            return false;
        }
    }

    private function get_option_product_by_age($age)
    {
        $where = "AND product_saving_is_under_age = 0";
        if ($age < 17) {
            $where = "AND product_saving_is_under_age = 1";
        }

        $sql_get = "SELECT product_saving_id, product_saving_name, product_saving_name_alias, product_saving_initial_deposit_value as min_deposit, product_saving_is_period FROM sys_product_saving WHERE product_saving_is_use_registration = 1 $where";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    private function get_detail_product($product_id)
    {

        $sql_get = "SELECT
            product_saving_id,
            product_saving_code,
            product_saving_name,
            product_saving_name_alias,
            product_saving_deposit_service_percent,
            product_saving_deposit_service_method,
            product_saving_deposit_service_min_balance,
            product_saving_initial_deposit_value,
            product_saving_max_acc_deposit_per_month_value,
            product_saving_min_acc_deposit_value,
            product_saving_book_change_fee,
            product_saving_book_lost_fee,
            product_saving_open_adm_fee,
            product_saving_closing_adm_fee,
            product_saving_monthly_adm_fee,
            product_saving_is_monthly_adm_fee,
            product_saving_min_balance,
            product_saving_is_loan_guarantee,
            product_saving_is_withdrawal,
            product_saving_is_withdrawal_represented,
            product_saving_is_withdrawal_fee,
            product_saving_config_json,
            product_saving_withdraw_fee_percent,
            product_saving_is_period,
            product_saving_min_period,
            product_saving_max_period,
            product_saving_is_insured,
            product_saving_is_use_registration,
            product_saving_is_under_age
            FROM sys_product_saving
            WHERE product_saving_id = {$product_id}
        ";

        return $this->db->query($sql_get)->row();
    }
}

/* End of file Registration.php */
