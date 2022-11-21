<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Submission extends Auth_Api_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_member_saldo_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {
            $arr_saving = array();
            $arr_loan = array();

            $sql_balance = "SELECT member_balance_principal, member_balance_obligation FROM sys_member_balance WHERE member_balance_member_id = {$id}";

            $data_balance = $this->db->query($sql_balance)->row();
            if (!empty($data_balance)) {
                $arr_saving[] = array(
                    'id' => 0,
                    'name' => 'Simpanan Pokok',
                    'alias' => 'Simpanan Pokok',
                    'code' => '01',
                    'balance' => (int)$data_balance->member_balance_principal,
                );
                $arr_saving[] = array(
                    'id' => 0,
                    'name' => 'Simpanan Wajib',
                    'alias' => 'Simpanan Wajib',
                    'code' => '02',
                    'balance' => (int)$data_balance->member_balance_obligation,
                );
            }

            $sql_saving = "SELECT member_product_saving_id, member_product_saving_account_number, member_product_saving_member_balance, member_product_saving_name,member_product_saving_name_alias FROM sys_member_product_saving WHERE member_product_saving_member_id = {$id}";

            $data_saving = $this->db->query($sql_saving)->result();

            foreach ($data_saving as $save) {
                $arr_saving[] = array(
                    'id' => $save->member_product_saving_id,
                    'name' => $save->member_product_saving_name,
                    'alias' => $save->member_product_saving_name_alias,
                    'code' => $save->member_product_saving_account_number,
                    'balance' => (int)$save->member_product_saving_member_balance,
                );
            }

            $sql_loan = "SELECT member_product_product_loan_name, member_product_product_loan_name_alias, member_product_code, member_product_plafon_balance, member_product_id FROM sys_member_product_loan WHERE member_product_member_id = {$id} AND member_product_plafon_balance > 0";

            $data_loan = $this->db->query($sql_loan)->result();

            foreach ($data_loan as $save) {
                $arr_loan[] = array(
                    'name' => $save->member_product_product_loan_name,
                    'alias' => $save->member_product_product_loan_name_alias,
                    'code' => $save->member_product_code,
                    'balance' => (int)$save->member_product_plafon_balance,
                );
            }

            $results = array(
                'saving' => $arr_saving,
                'loan' => $arr_loan
            );

            $this->createResponse(REST_Controller::HTTP_OK, $results);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Saldo Member.');
        }
    }

    public function get_data_get()
    {
        $limit = (int)$this->get('limit') <= 0 ? 10 : (int)$this->get('limit');
        $page = (int)$this->get('page') <= 0 ? 1 : (int)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_submission_product_loan($start, $limit, $sort, $dir, $filter);
        $total = (int)$results['count'];

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
                    submission_product_loan_id,
                    submission_product_loan_member_id,
                    submission_product_loan_product_loan_id,
                    submission_product_loan_product_loan_name,
                    submission_product_loan_plafon,
                    submission_product_loan_tenor,
                    submission_product_loan_interest_percent,
                    submission_product_loan_interest_type,
                    submission_product_loan_forfiet_percent,
                    submission_product_loan_collateral_type,
                    submission_product_loan_collateral_value,
                    submission_product_loan_collateral_description,
                    submission_product_loan_disbursement_date,
                    submission_product_loan_due_date,
                    submission_product_loan_note,
                    submission_product_loan_status,
                    submission_product_loan_approval_config_json,
                    submission_product_loan_approval_json,
                    submission_product_loan_input_datetime,
                    submission_product_loan_input_admin_username,
                    submission_product_loan_input_admin_name,
                    submission_product_loan_status_surveyor_datetime,
                    submission_product_loan_status_surveyor_admin_username,
                    submission_product_loan_status_surveyor_admin_name,
                    submission_product_loan_status_approved,
                    submission_product_loan_status_rejected_datetime,
                    submission_product_loan_status_rejected_admin_username,
                    submission_product_loan_status_rejected_admin_name,
                    submission_product_loan_survey_filename,
                    submission_product_loan_survey_path,
                    product_loan_code,
                    product_loan_name,
                    product_loan_name_alias,
                    member_code,
                    member_name,
                    member_identity_number,
                    member_identity_type,
                    member_gender,
                    member_birthdate,
                    member_birthplace,
                    member_status,
                    member_join_datetime,
                    member_registered_date,
                    member_is_diksar,
                    member_diksar_date,
                    member_nationality,
                    member_working_in,
                    member_entrance_fee_paid_off
                FROM sys_submission_product_loan
                JOIN sys_product_loan ON submission_product_loan_product_loan_id = product_loan_id
                JOIN sys_member ON submission_product_loan_member_id = member_id
                WHERE submission_product_loan_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());

            $sql_collateral = "SELECT
                collateral_id,
                collateral_member_id,
                collateral_taksasi_value,
                collateral_options,
                collateral_vehicle_type,
                collateral_vehicle_brand,
                collateral_created_year,
                collateral_nopol,
                collateral_nobpkb,
                collateral_norangka,
                collateral_nomesin,
                collateral_stnk_name,
                collateral_bpkb_name,
                collateral_sertifikat_name,
                collateral_nohm,
                collateral_area_size,
                collateral_atas_nama,
                collateral_location,
                collateral_measuring_number,
                collateral_deposito_type,
                collateral_deposito_name,
                collateral_deposito_address,
                collateral_deposito_account_number,
                collateral_deposito_due_date,
                collateral_deposito_value,
                collateral_note,
                collateral_input_admin_id,
                collateral_input_admin_name,
                collateral_input_admin_username,
                collateral_input_datetime
                FROM collateral
                WHERE collateral_submission_product_loan_id = {$id}
            ";
            $collateral = $this->db->query($sql_collateral)->result();


            $sql_collateral_saving = "SELECT
                collateral_saving_id,
                collateral_saving_member_product_saving_id,
                collateral_saving_member_id,
                collateral_saving_status,
                collateral_saving_start_value,
                collateral_saving_value,
                collateral_saving_block_start_date,
                collateral_saving_block_end_date,
                collateral_saving_block_admin_id,
                collateral_saving_block_datetime,
                collateral_saving_block_admin_name,
                collateral_saving_block_admin_username,
                collateral_saving_opened_datetime,
                collateral_saving_opened_admin_id,
                collateral_saving_opened_admin_name,
                collateral_saving_opened_admin_username,
                member_product_saving_name,
                member_product_saving_name_alias,
                member_product_saving_account_number,
                member_product_saving_member_balance
                FROM collateral_saving
                JOIN sys_member_product_saving ON collateral_saving_member_product_saving_id = member_product_saving_id
                WHERE collateral_saving_submission_product_loan_id = {$id}
            ";
            $collateral_saving = $this->db->query($sql_collateral_saving)->result();

            $data['collateral'] = $collateral;
            $data['collateral_saving'] = $collateral_saving;

            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Pengajuan Produk Pinjaman.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Pengajuan Produk Pinjaman.');
        }
    }


    public function get_detail_print_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    submission_product_loan_id,
                    submission_product_loan_member_id,
                    submission_product_loan_product_loan_id,
                    submission_product_loan_product_loan_name,
                    submission_product_loan_plafon,
                    submission_product_loan_tenor,
                    submission_product_loan_interest_percent,
                    submission_product_loan_interest_type,
                    submission_product_loan_forfiet_percent,
                    submission_product_loan_collateral_type,
                    submission_product_loan_collateral_value,
                    submission_product_loan_collateral_description,
                    submission_product_loan_disbursement_date,
                    submission_product_loan_due_date,
                    submission_product_loan_note,
                    submission_product_loan_status,
                    submission_product_loan_approval_config_json,
                    submission_product_loan_approval_json,
                    submission_product_loan_input_datetime,
                    submission_product_loan_input_admin_username,
                    submission_product_loan_input_admin_name,
                    submission_product_loan_status_surveyor_datetime,
                    submission_product_loan_status_surveyor_admin_username,
                    submission_product_loan_status_surveyor_admin_name,
                    submission_product_loan_status_approved,
                    submission_product_loan_status_rejected_datetime,
                    submission_product_loan_status_rejected_admin_username,
                    submission_product_loan_status_rejected_admin_name,
                    submission_product_loan_survey_filename,
                    submission_product_loan_survey_path,
                    product_loan_code,
                    product_loan_name,
                    product_loan_name_alias,
                    product_loan_forfeit_percent,
                    product_loan_interest_percent,
                    product_loan_interest_type,
                    product_loan_pinalty_fee_percent,
                    member_code,
                    member_name,
                    member_identity_number,
                    member_identity_type,
                    member_gender,
                    member_birthdate,
                    member_birthplace,
                    member_status,
                    member_join_datetime,
                    member_registered_date,
                    member_is_diksar,
                    member_diksar_date,
                    member_nationality,
                    member_working_in,
                    member_entrance_fee_paid_off,
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
                    member_is_married,
                    member_residence_status
                FROM sys_submission_product_loan
                JOIN sys_product_loan ON submission_product_loan_product_loan_id = product_loan_id
                JOIN sys_member ON submission_product_loan_member_id = member_id
                JOIN sys_member_address ON submission_product_loan_member_id = member_address_id
                JOIN sys_member_profile ON submission_product_loan_member_id = member_profile_id
                WHERE submission_product_loan_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Pengajuan Produk Pinjaman.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Pengajuan Produk Pinjaman.');
        }
    }

    public function act_add_post()
    {
        $set_data = array(
            'collateral_saving' => json_encode($this->post('collateral_saving')),
            'collateral' => json_encode($this->post('collateral')),
            'member_id' => $this->post('member_id'),
            'product_loan_id' => $this->post('product_loan_id'),
            'plafon' => $this->post('plafon'),
            'tenor' => $this->post('tenor'),
            'forfiet_percent' => $this->post('forfiet_percent'),
            'interest_percent' => $this->post('interest_percent'),
            'interest_type' => $this->post('interest_type'),
            'collateral_value' => $this->post('collateral_value'),
            'disbursement_date' => $this->post('disbursement_date'),
            'due_date' => $this->post('due_date'),
            'note' => $this->post('note'),
        );
        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('member_id', '<b>Data Member</b>', 'required|callback_member_check');
        $this->form_validation->set_rules('product_loan_id', '<b>Data Produk</b>', 'required');
        $this->form_validation->set_rules('plafon', '<b>Nominal Pinjaman</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('tenor', '<b>Tenor</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('forfiet_percent', '<b>Persen Denda</b>', 'required');
        $this->form_validation->set_rules('interest_percent', '<b>Persen Bunga</b>', 'required');
        $this->form_validation->set_rules('interest_type', '<b>Tipe Bunga</b>', 'required');
        $this->form_validation->set_rules('collateral_saving', '<b>Jaminan Simpanan</b>', 'callback_corateral_saving_check');
        $this->form_validation->set_rules('collateral', '<b>Jaminan Fisik</b>', 'callback_corateral_check');
        $this->form_validation->set_rules('collateral_value', '<b>Total Nilai Jaminan</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('disbursement_date', '<b>Tanggal Pencarian</b>', 'required');
        $this->form_validation->set_rules('due_date', '<b>Tanggal Jatuh Tempo</b>', 'required');
        $this->form_validation->set_rules('note', '<b>Catatan</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();

                $member_id = $this->post('member_id');
                $product_loan_id = $this->post('product_loan_id');
                $product_loan_name = $this->post('product_loan_name');
                $plafon = $this->post('plafon');
                $tenor = $this->post('tenor');
                $forfiet_percent = $this->post('forfiet_percent');
                $interest_percent = $this->post('interest_percent');
                $interest_type = $this->post('interest_type');
                $collateral_saving = $this->post('collateral_saving');
                $collateral = $this->post('collateral');
                $collateral_value = $this->post('collateral_value');
                $disbursement_date = $this->post('disbursement_date');
                $due_date = $this->post('due_date');
                $note = $this->post('note');
                $datetime = date('Y-m-d H:i:s');

                $data['submission_product_loan_member_id'] = $member_id;
                $data['submission_product_loan_product_loan_id'] = $product_loan_id;
                $data['submission_product_loan_product_loan_name'] = $product_loan_name;
                $data['submission_product_loan_plafon'] = $plafon;
                $data['submission_product_loan_tenor'] = $tenor;
                $data['submission_product_loan_forfiet_percent'] = $forfiet_percent;
                $data['submission_product_loan_interest_percent'] = $interest_percent;
                $data['submission_product_loan_interest_type'] = $interest_type;
                $data['submission_product_loan_collateral_value'] = $collateral_value;
                $data['submission_product_loan_disbursement_date'] = $disbursement_date;
                $data['submission_product_loan_due_date'] = $due_date;
                $data['submission_product_loan_note'] = $note;
                $data['submission_product_loan_status'] = 0;
                $data['submission_product_loan_input_datetime'] = $datetime;
                $data['submission_product_loan_input_admin_username'] = $this->get_user('user_auth_username');
                $data['submission_product_loan_input_admin_name'] = $this->get_user('user_auth_name');

                if (!$this->db->insert('sys_submission_product_loan', $data)) {
                    throw new Exception("Gagal Insert Pengajuan", 1);
                }
                $id_submission = $this->db->insert_id();


                if (!empty($collateral)) {
                    $arr_collateral = array();
                    foreach ($collateral as $coll) {
                        $arr_coll = array();
                        $arr_coll['collateral_submission_product_loan_id'] = $id_submission;
                        $arr_coll['collateral_member_product_loan_id'] = $product_loan_id;
                        $arr_coll['collateral_member_id'] = $member_id;
                        $arr_coll['collateral_taksasi_value'] = $collateral_value;
                        $arr_coll['collateral_options'] = $coll['type'];
                        $arr_coll['collateral_note'] = $coll['note'];
                        $arr_coll['collateral_input_admin_id'] = $this->get_user('user_auth_user_id');
                        $arr_coll['collateral_input_admin_name'] = $this->get_user('user_auth_name');
                        $arr_coll['collateral_input_admin_username'] = $this->get_user('user_auth_username');
                        $arr_coll['collateral_input_datetime'] = $datetime;

                        switch ($coll['type']) {
                            case 0: // tipe bpkb
                                $arr_coll['collateral_vehicle_type'] = $coll['vehicle_type'];
                                $arr_coll['collateral_vehicle_brand'] = $coll['vehicle_brand'];
                                $arr_coll['collateral_created_year'] = $coll['created_year'];
                                $arr_coll['collateral_nopol'] = $coll['nopol'];
                                $arr_coll['collateral_nobpkb'] = $coll['nobpkb'];
                                $arr_coll['collateral_norangka'] = $coll['norangka'];
                                $arr_coll['collateral_nomesin'] = $coll['nomesin'];
                                $arr_coll['collateral_stnk_name'] = $coll['stnk_name'];
                                $arr_coll['collateral_bpkb_name'] = $coll['bpkb_name'];

                                break;
                            case 1: // tipe sertifikat
                                $arr_coll['collateral_sertifikat_name'] = $coll['sertifikat_name'];
                                $arr_coll['collateral_nohm'] = $coll['nohm'];
                                $arr_coll['collateral_area_size'] = $coll['area_size'];
                                $arr_coll['collateral_atas_nama'] = $coll['atas_nama'];
                                $arr_coll['collateral_location'] = $coll['location'];
                                $arr_coll['collateral_measuring_number'] = $coll['measuring_number'];

                                break;
                            case 2: // tipe deposito
                                $arr_coll['collateral_deposito_type'] = $coll['deposito_type'];
                                $arr_coll['collateral_deposito_name'] = $coll['deposito_name'];
                                $arr_coll['collateral_deposito_address'] = $coll['deposito_address'];
                                $arr_coll['collateral_deposito_account_number'] = $coll['deposito_account_number'];
                                $arr_coll['collateral_deposito_due_date'] = $coll['deposito_due_date'];
                                $arr_coll['collateral_deposito_value'] = $coll['deposito_value'];
                                break;
                            case 3: // tipe lainnya

                                break;
                        }
                        $arr_collateral[] = $arr_coll;
                    }
                    if (!$this->db->insert_batch('collateral', $arr_collateral)) {
                        throw new Exception("Gagal Insert Collateral", 1);
                    }
                }

                if (!empty($collateral_saving)) {
                    $arr_collateral_saving = array();
                    foreach ($collateral_saving as $coll) {
                        $arr_coll = array();
                        $arr_coll['collateral_saving_submission_product_loan_id'] = $id_submission;
                        $arr_coll['collateral_saving_member_product_saving_id'] = $coll['id'];
                        $arr_coll['collateral_saving_member_id'] = $member_id;
                        $arr_coll['collateral_saving_status'] = 0;
                        $arr_coll['collateral_saving_start_value'] = $coll['collateral'];
                        $arr_coll['collateral_saving_value'] = $coll['collateral'];
                        $arr_coll['collateral_saving_block_start_date'] = $datetime;
                        $arr_coll['collateral_saving_block_end_date'] = date('Y-m-d H:i:s', strtotime("+{$tenor} months", strtotime($datetime)));
                        $arr_coll['collateral_saving_block_admin_id'] = $this->get_user('user_auth_user_id');
                        $arr_coll['collateral_saving_block_datetime'] = $datetime;
                        $arr_coll['collateral_saving_block_admin_name'] = $this->get_user('user_auth_name');
                        $arr_coll['collateral_saving_block_admin_username'] = $this->get_user('user_auth_username');

                        $arr_collateral_saving[] = $arr_coll;
                    }
                    if (!$this->db->insert_batch('collateral_saving', $arr_collateral_saving)) {
                        throw new Exception("Gagal Insert Collateral Saving", 1);
                    }
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

    public function act_upload_post()
    {
        $this->form_validation->set_rules('id', '<b>Data Pengajuan</b>', 'required');
        $this->form_validation->set_rules('filename', '<b>File</b>', 'required');
        $this->form_validation->set_rules('path', '<b>Path</b>', 'required');
        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            try {
                $data['submission_product_loan_survey_filename'] = $this->post('filename');
                $data['submission_product_loan_survey_path'] = $this->post('path');

                $this->db->where('submission_product_loan_id', $this->post('id'));
                if (!$this->db->update('sys_submission_product_loan', $data)) {
                    throw new Exception('Silahkan coba lagi.', 1);
                }
            } catch (Exception $ex) {
                $is_error = true;
            }
            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal upload file!. Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil upload file.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal upload file!. Silahkan coba lagi.');
            }
        }
    }

    public function member_check($str)
    {
        $is_error = false;
        $message = '';
        $sql_config = "SELECT IFNULL(json_extract(config_json, '$.results'), '[]') AS config_json FROM sys_config WHERE config_name = 'loan' ORDER BY config_id DESC LIMIT 1";

        $config = json_decode($this->db->query($sql_config)->row('config_json'));

        if (!empty($config)) {
            if ($config->loan->max_plafon > 0) {
                $sql_loan = "SELECT IFNULL(sum(member_product_plafon_balance),0) as loannow FROM sys_member_product_loan WHERE member_product_member_id = {$str}";
                $loan_member = $this->db->query($sql_loan)->row('loannow') + $this->post('plafon');
                if ($config->loan->max_plafon < $loan_member) {
                    $is_error = true;
                    $message = 'pinjaman melebihi maksimal plafon';
                }
            }

            if ($config->loan->max_loan_item > 0) {
                $sql_loan = "SELECT count(member_product_member_id) as loannow FROM sys_member_product_loan WHERE member_product_member_id = {$str} AND member_product_plafon_balance > 0";
                $loan_member = $this->db->query($sql_loan)->row('loannow') + 1;
                if ($config->loan->max_loan_item < $loan_member) {
                    $is_error = true;
                    $message = 'pinjaman melebihi maksimal jumlah pinjaman';
                }
            }
        } else {
            $is_error = false;
            $message = 'Configurasi Pinjaman belum tersedia';
        }

        if ($is_error) {
            $this->form_validation->set_message('member_check', '{field} ' . $message);
            return false;
        } else {
            return true;
        }
    }

    public function corateral_saving_check($str)
    {
        $arr_data = json_decode($str);
        $is_error = false;
        $message = '';

        if (!empty($arr_data)) {
            foreach ($arr_data as $row) {
                $sql_get = "SELECT member_product_saving_member_balance as balance, member_product_saving_name_alias as alias FROM sys_member_product_saving WHERE member_product_saving_id = {$row->id}";
                $saving = $this->db->query($sql_get)->row();
                if (empty($saving)) {
                    $is_error = true;
                    $message = 'Data Simpanan tidak ditemukan';
                } else {
                    if ($saving->balance < $row->collateral) {
                        $is_error = true;
                        $message = 'Saldo ' . $saving->alias . ' tidak mencukupi';
                    }
                }
            }
        }
        if ($is_error) {
            $this->form_validation->set_message('corateral_saving_check', '{field} ' . $message);
            return false;
        } else {
            return true;
        }
    }

    public function corateral_check($str)
    {
        $arr_fisik = json_decode($str);
        $arr_saving = $this->post('collateral_saving');

        $is_error = false;
        $message = '';

        if (empty($arr_fisik) && empty($arr_saving)) {
            $is_error = true;
            $message = 'tidak boleh kosong';
        } else {
            if (!empty($arr_fisik)) {
                foreach ($arr_fisik as $row) {
                    switch ($row->type) {
                        case 0: // tipe bpkb
                            if (!isset($row->note) || empty($row->note)) {
                                $is_error = true;
                                $message = '<b>Catatan</b> tidak boleh kosong';
                            }
                            if (!isset($row->bpkb_name) || empty($row->bpkb_name)) {
                                $is_error = true;
                                $message = '<b>Nama BPKB</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->stnk_name) || empty($row->stnk_name)) {
                                $is_error = true;
                                $message = '<b>Nama STNK</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->nomesin) || empty($row->nomesin)) {
                                $is_error = true;
                                $message = '<b>No. Mesin</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->norangka) || empty($row->norangka)) {
                                $is_error = true;
                                $message = '<b>No. Rangka</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->nobpkb) || empty($row->nobpkb)) {
                                $is_error = true;
                                $message = '<b>No. BPKB</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->nopol) || empty($row->nopol)) {
                                $is_error = true;
                                $message = '<b>No. Polisi</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->created_year) || empty($row->created_year)) {
                                $is_error = true;
                                $message = '<b>Tahun</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->vehicle_brand) || empty($row->vehicle_brand)) {
                                $is_error = true;
                                $message = '<b>Merek</b> kendaraan tidak boleh kosong';
                            }
                            if (!isset($row->vehicle_type) || empty($row->vehicle_type)) {
                                $is_error = true;
                                $message = '<b>Jenis</b> kendaraan tidak boleh kosong';
                            }
                            break;
                        case 1: // tipe sertifikat
                            if (!isset($row->note) || empty($row->note)) {
                                $is_error = true;
                                $message = '<b>Catatan</b> tidak boleh kosong';
                            }
                            if (!isset($row->measuring_number) || empty($row->measuring_number)) {
                                $is_error = true;
                                $message = '<b>No. Ukur</b> sertifikat tidak boleh kosong';
                            }
                            if (!isset($row->location) || empty($row->location)) {
                                $is_error = true;
                                $message = '<b>Lokasi Tanah/Bangunan</b> sertifikat tidak boleh kosong';
                            }
                            if (!isset($row->atas_nama) || empty($row->atas_nama)) {
                                $is_error = true;
                                $message = '<b>No. Hak Milik</b> sertifikat tidak boleh kosong';
                            }
                            if (!isset($row->area_size) || empty($row->area_size)) {
                                $is_error = true;
                                $message = '<b>Atas Nama</b> sertifikat tidak boleh kosong';
                            }
                            if (!isset($row->nohm) || empty($row->nohm)) {
                                $is_error = true;
                                $message = '<b>No. Hak Milik</b> sertifikat tidak boleh kosong';
                            }
                            if (!isset($row->sertifikat_name) || empty($row->sertifikat_name)) {
                                $is_error = true;
                                $message = '<b>Nama sertifikat</b> tidak boleh kosong';
                            }
                            break;
                        case 2: // tipe deposito
                            if (!isset($row->note) || empty($row->note)) {
                                $is_error = true;
                                $message = '<b>Catatan</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_value) || empty($row->deposito_value)) {
                                $is_error = true;
                                $message = '<b>Nominal Deposito</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_due_date) || empty($row->deposito_due_date)) {
                                $is_error = true;
                                $message = '<b>Tgl. Jatuh Tempo Deposito</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_account_number) || empty($row->deposito_account_number)) {
                                $is_error = true;
                                $message = '<b>No. Rekening Deposito</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_address) || empty($row->deposito_address)) {
                                $is_error = true;
                                $message = '<b>Alamat Deposito</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_name) || empty($row->deposito_name)) {
                                $is_error = true;
                                $message = '<b>Deposito Atas Nama</b> tidak boleh kosong';
                            }
                            if (!isset($row->deposito_type) || empty($row->deposito_type)) {
                                $is_error = true;
                                $message = '<b>Jenis Deposito</b> tidak boleh kosong';
                            }
                            break;
                        case 3: // tipe lainnya

                            break;
                    }
                }
            }
        }

        if ($is_error) {
            $this->form_validation->set_message('corateral_check', '{field} ' . $message);
            return false;
        } else {
            return true;
        }
    }

    public function act_approve_post()
    {
        $this->form_validation->set_rules('id', '<b>Data Pengajuan</b>', 'required');
        $this->form_validation->set_rules('plafon', '<b>Nominal Pinjaman</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('tenor', '<b>Tenor</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('forfiet_percent', '<b>Persen Denda</b>', 'required');
        $this->form_validation->set_rules('interest_percent', '<b>Persen Bunga</b>', 'required');
        $this->form_validation->set_rules('interest_type', '<b>Tipe Bunga</b>', 'required');
        $this->form_validation->set_rules('disbursement_date', '<b>Tanggal Pencarian</b>', 'required');
        $this->form_validation->set_rules('due_date', '<b>Tanggal Jatuh Tempo</b>', 'required');
        $this->form_validation->set_rules('forfiet_date', '<b>Tanggal Terkena Denda</b>', 'required');
        $this->form_validation->set_rules('is_daperma', '<b>Diikutkan daperma</b>', 'required');
        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            $message = 'Gagal melakukan approval! ';

            $this->db->trans_begin();

            try {
                $id = $this->post('id');
                $plafon = $this->post('plafon');
                $tenor = $this->post('tenor');
                $forfiet_percent = $this->post('forfiet_percent');
                $interest_percent = $this->post('interest_percent');
                $interest_type = $this->post('interest_type');
                $disbursement_date = $this->post('disbursement_date');
                $due_date = $this->post('due_date');
                $forfiet_date = $this->post('forfiet_date');
                $is_daperma = $this->post('is_daperma');
                $admin_id = $this->get_user('user_auth_user_id');

                $submission = $this->get_detail_submmision($id);

                if (!empty($submission)) {
                    $is_valid_admin = false;
                    $config = $this->common_model->get_config_general('loan')->approval;
                    foreach ($config as $val) {
                        if ($val->plafon_minimal == $val->plafon_maximal) {
                            if ($tenor > $val->plafon_minimal && in_array($admin_id, $val->administrator_id)) {
                                $is_valid_admin = true;
                            }
                        } else {
                            if ($val->plafon_minimal < $tenor && $tenor <= $val->plafon_maximal && in_array($admin_id, $val->administrator_id)) {
                                $is_valid_admin = true;
                            }
                        }
                    }

                    if (!$is_valid_admin) {
                        throw new Exception('Anda tidak berhak melakukan approval pengajuan ini.', 1);
                    }

                    $ins = array();

                    $ins['member_product_member_id'] = $submission->member_id;
                    $ins['member_product_product_loan_id'] = $submission->product_loan_id;
                    $ins['member_product_product_loan_name'] = $submission->product_loan_name;
                    $ins['member_product_product_loan_name_alias'] = $submission->product_loan_name_alias;
                    $ins['member_product_code'] = $this->common_model->generate_code('sys_member_product_loan', 'member_product_code', 'WHERE member_product_product_loan_id = ' . $submission->product_loan_id, 6);
                    $ins['member_product_plafon'] = $plafon;
                    $ins['member_product_plafon_balance'] = $plafon;
                    $ins['member_product_tenor'] = $tenor;
                    $ins['member_product_service_percent'] = 0;
                    $ins['member_product_service_loan_percent1'] = 0;
                    $ins['member_product_service_loan_percent2'] = 0;
                    $ins['member_product_forfeit_percent'] = $forfiet_percent;
                    $ins['member_product_interest_percent'] = $interest_percent;
                    $ins['member_product_interest_type'] = $interest_type;
                    $ins['member_product_collateral_type'] = '';
                    $ins['member_product_is_daperma'] = $is_daperma;
                    $ins['member_product_disbursement_date'] = $disbursement_date;
                    $ins['member_product_due_date'] = $due_date;
                    $ins['member_product_forfeit_date'] = $forfiet_date;

                    if (!$this->db->insert('sys_member_product_loan', $ins)) {
                        throw new Exception('Silahkan coba lagi. 1', 1);
                    }
                    $member_product_id = $this->db->insert_id();

                    $data = array();
                    $data['submission_product_loan_status'] = 2;
                    $arr_admin[] = array(
                        'admin_id' => $this->get_user('user_auth_user_id'),
                        'admin_name' => $this->get_user('user_auth_name'),
                        'admin_username' => $this->get_user('user_auth_username'),
                        'datetime' => date('Y-m-d H:i:s'),
                    );
                    $data['submission_product_loan_status_approved'] = '{"results": ' . json_encode($arr_admin) . '}';

                    $this->db->where('submission_product_loan_id', $id);
                    if (!$this->db->update('sys_submission_product_loan', $data)) {
                        throw new Exception('Silahkan coba lagi. 2', 1);
                    }

                    $data = array();
                    $data['collateral_saving_member_product_loan_id'] = $member_product_id;
                    $this->db->where('collateral_saving_submission_product_loan_id', $id);
                    if (!$this->db->update('collateral_saving', $data)) {
                        throw new Exception('Silahkan coba lagi. 3', 1);
                    }

                    $data = array();
                    $data['collateral_member_product_loan_id'] = $member_product_id;
                    $this->db->where('collateral_submission_product_loan_id', $id);
                    if (!$this->db->update('collateral', $data)) {
                        throw new Exception('Silahkan coba lagi. 4', 1);
                    }

                    if (!$this->generate_invoice_loan($member_product_id, (object)$ins)) {
                        throw new Exception('Invoice gagal digenerate', 1);
                    }

                    $member_detail = $this->common_model->get_member_name_code($submission->member_id);
                    if (!$this->common_model->insert_hutang_piutang('hutang', 'in', $plafon, $member_detail->member_name, $member_detail->member_code, $submission->member_id)) {
                        throw new Exception('Silahkan coba lagi. 5', 1);
                    }

                    $input_admin_name = $this->get_user('user_auth_name');
                    $input_admin_username = $this->get_user('user_auth_username');
                    $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                    $input_datetime = $datetime = date('Y-m-d H:i:s');
                    $trans_code = $this->common_model->generate_trans_code($disbursement_date);
                    $note_trans = strtoupper("Pencairan Pinjaman {$submission->product_loan_name} atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}");

                    $jurnal_id = $this->common_model->get_jurnal_open_loan($member_product_id, $input_admin_branch_id);

                    if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $plafon, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                        throw new Exception('Proses Gagal dilakukan. Konfigurasi Jurnal Tidak Ditemukan.' . $jurnal_id, 1);
                    }
                } else {
                    throw new Exception('Data Pengajuan Tidak ditemukan!', 1);
                }
            } catch (Exception $ex) {
                $is_error = true;
                $message = $ex->getMessage();
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan approval.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            }
        }
    }

    private function generate_invoice_loan($id, $data)
    {
        try {
            $arr_data = array();

            $principal = (int)($data->member_product_plafon / $data->member_product_tenor);
            $interest_percent = $data->member_product_interest_percent / 100;
            $interest = 0;

            for ($period = 0; $period < $data->member_product_tenor; $period++) {

                if ($data->member_product_interest_type == 0) {
                    // Flat / rata
                    $interest = (int)$data->member_product_plafon * $interest_percent;
                } else {
                    // Efektif / menurun
                    $interest = (int)($data->member_product_plafon - ($period * $principal)) * $interest_percent;
                }

                $due_date = date('Y-m-d', strtotime("+{$period} months", strtotime($data->member_product_due_date)));
                $forfeit_date = date('Y-m-d', strtotime("+{$period} months", strtotime($data->member_product_forfeit_date)));
                $date = date('Y-m-d', strtotime("-1 months", strtotime($due_date)));

                $arr_data[] = array(
                    'invoice_loan_member_id' => $data->member_product_member_id,
                    'invoice_loan_member_product_id' => $id,
                    'invoice_loan_product_id' => $data->member_product_product_loan_id,
                    'invoice_loan_number' => '0001',
                    'invoice_loan_trans_number' => '0001',
                    'invoice_loan_period' => $period + 1,
                    'invoice_loan_date' => $date,
                    'invoice_loan_due_date' => $due_date,
                    'invoice_loan_forfeit_date' => $forfeit_date,
                    'invoice_loan_total_value' => $principal + $interest,
                    'invoice_loan_interest_value' => $interest,
                    'invoice_loan_principal_value' => $principal,
                    'invoice_loan_total_paid' => 0,
                    'invoice_loan_interest_paid' => 0,
                    'invoice_loan_principal_paid' => 0,
                    'invoice_loan_kompensasi_paid' => 0,
                    'invoice_loan_discount_value' => 0,
                    'invoice_loan_forfeit_value' => 0,
                );
            }
            if (!$this->db->insert_batch('sys_invoice_loan', $arr_data)) {
                throw new Exception('Gagal Generate Invoice.', 1);
            }
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }

    private function get_detail_submmision($id)
    {
        $sql = "
                SELECT 
                    submission_product_loan_id as id,
                    submission_product_loan_member_id as member_id,
                    submission_product_loan_product_loan_id as product_loan_id,
                    submission_product_loan_product_loan_name as product_loan_name,
                    submission_product_loan_plafon as plafon,
                    submission_product_loan_tenor as tenor,
                    submission_product_loan_interest_percent as interest_percent,
                    submission_product_loan_interest_type as interest_type,
                    submission_product_loan_forfiet_percent as forfiet_percent,
                    submission_product_loan_collateral_type as collateral_type,
                    submission_product_loan_collateral_value as collateral_value,
                    submission_product_loan_collateral_description as collateral_description,
                    submission_product_loan_disbursement_date as disbursement_date,
                    submission_product_loan_due_date as due_date,
                    submission_product_loan_note as note,
                    submission_product_loan_status as status,
                    submission_product_loan_survey_filename as filename,
                    submission_product_loan_survey_path as path,
                    product_loan_code,
                    product_loan_name,
                    product_loan_name_alias
                FROM sys_submission_product_loan
                JOIN sys_product_loan ON submission_product_loan_product_loan_id = product_loan_id
                WHERE submission_product_loan_id = $id AND submission_product_loan_status = 1
            ";

        return $this->db->query($sql)->row();
    }

    public function act_reject_post()
    {
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                $data['submission_product_loan_status'] = 3;
                $data['submission_product_loan_status_rejected_datetime'] = date('Y-m-d H:i:s');
                $data['submission_product_loan_status_rejected_admin_username'] = $this->get_user('user_auth_username');
                $data['submission_product_loan_status_rejected_admin_name'] = $this->get_user('user_auth_name');

                $this->db->where('submission_product_loan_id', $id);
                $this->db->update('sys_submission_product_loan', $data);

                if ($this->db->affected_rows() < 0) {
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

            $str_success = ($success > 0) ? $success . ' data berhasil ditolak. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal ditolak.' : '';

            $message = $str_success . $str_failed;
            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal menolak data! Silahkan coba lagi.');
        }
    }

    public function act_survey_post()
    {
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {
                $is_error = false;
                $this->db->trans_begin();

                $data['submission_product_loan_status'] = 1;
                $data['submission_product_loan_status_surveyor_datetime'] = date('Y-m-d H:i:s');
                $data['submission_product_loan_status_surveyor_admin_username'] = $this->get_user('user_auth_username');
                $data['submission_product_loan_status_surveyor_admin_name'] = $this->get_user('user_auth_name');

                $this->db->where('submission_product_loan_id', $id);
                $this->db->update('sys_submission_product_loan', $data);

                if ($this->db->affected_rows() < 0) {
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

            $str_success = ($success > 0) ? $success . ' data berhasil disurvei. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal disurvei.' : '';

            $message = $str_success . $str_failed;
            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mensurvei data! Silahkan coba lagi.');
        }
    }

    private function get_submission_product_loan($start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'submission_product_loan_id',
            'submission_product_loan_member_id',
            'submission_product_loan_product_loan_id',
            'submission_product_loan_product_loan_name',
            'submission_product_loan_plafon',
            'submission_product_loan_tenor',
            'submission_product_loan_interest_percent',
            'submission_product_loan_interest_type',
            'submission_product_loan_forfiet_percent',
            'submission_product_loan_collateral_type',
            'submission_product_loan_collateral_value',
            'submission_product_loan_collateral_description',
            'submission_product_loan_disbursement_date',
            'submission_product_loan_due_date',
            'submission_product_loan_note',
            'submission_product_loan_status',
            'submission_product_loan_approval_config_json',
            'submission_product_loan_approval_json',
            'submission_product_loan_input_datetime',
            'submission_product_loan_input_admin_username',
            'submission_product_loan_input_admin_name',
            'submission_product_loan_status_surveyor_datetime',
            'submission_product_loan_status_surveyor_admin_username',
            'submission_product_loan_status_surveyor_admin_name',
            'submission_product_loan_status_approved',
            'submission_product_loan_status_rejected_datetime',
            'submission_product_loan_status_rejected_admin_username',
            'submission_product_loan_status_rejected_admin_name',
            'submission_product_loan_survey_filename',
            'submission_product_loan_survey_path',
            'product_loan_code',
            'product_loan_name',
            'product_loan_name_alias',
            'member_code',
            'member_name',
            'member_identity_number',
            'member_identity_type',
            'member_gender',
            'member_birthdate',
            'member_birthplace',
            'member_status',
            'member_join_datetime',
            'member_registered_date',
            'member_is_diksar',
            'member_diksar_date',
            'member_nationality',
            'member_working_in',
            'member_entrance_fee_paid_off'
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'submission_product_loan_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_submission_product_loan
            JOIN sys_product_loan ON submission_product_loan_product_loan_id = product_loan_id
            JOIN sys_member ON submission_product_loan_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_submission_product_loan($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_submission_product_loan($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(submission_product_loan_id) as total
            FROM sys_submission_product_loan
            JOIN sys_product_loan ON submission_product_loan_product_loan_id = product_loan_id
            JOIN sys_member ON submission_product_loan_member_id = member_id
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

/* End of file Submission.php */
