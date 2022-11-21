<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Entrance_fee extends Auth_Api_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
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
        $paid = $this->get('paid');
        if ($paid != '0' && $paid != '1') {
            $paid = '0';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_member($paid, $start, $limit, $sort, $dir, $filter);
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

    public function get_log_by_member_get()
    {
        $member_id = $this->get('member_id');
        if (!empty($member_id) && is_numeric($member_id)) {
            $sql_get = "SELECT 
                entrance_fee_id,
                entrance_fee_member_id,
                entrance_fee_name,
                entrance_fee_value,
                entrance_fee_note,
                entrance_fee_datetime,
                entrance_fee_administrator_username,
                entrance_fee_administrator_name
                FROM sys_trans_entrance_fee
                WHERE entrance_fee_member_id = $member_id
            ";
            $result = $this->db->query($sql_get);
            $result_arr = array();
            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    $result_arr[] = array_map("convertNullToString", $row);
                }
            }
            $data = array(
                'results' => $result_arr
            );
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data.');
        }
    }

    public function get_data_by_member_get()
    {
        $member_id = $this->get('member_id');
        if (!empty($member_id) && is_numeric($member_id)) {
            $config = $this->common_model->get_config_entrance_fee();

            $arr_data = array();
            foreach ($config as $row) {
                $sql_get_value = "SELECT ifnull(sum(entrance_fee_value),0) as val FROM sys_trans_entrance_fee WHERE entrance_fee_name = '{$row->name}' AND entrance_fee_member_id = {$member_id}";
                $sql_get_value = "SELECT ifnull(sum(entrance_fee_value),0) as val FROM sys_trans_entrance_fee WHERE entrance_fee_name = '{$row->name}' AND entrance_fee_member_id = $member_id";

                $paid = $this->db->query($sql_get_value)->row('val');

                $unpaid = $row->value - $paid;

                $row->paid = $paid * 1;
                $row->unpaid = $unpaid;
                $arr_data[] = $row;
            }

            $this->createResponse(REST_Controller::HTTP_OK, $arr_data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan data.');
        }
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('member_id', '<b>Anggota</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Uang Pangkal</b>', 'required');

        $str_check_value = $this->post('name') . '::' . $this->input->post('member_id');
        $this->form_validation->set_rules('value', '<b>Nilai Uang Pangkal</b>', 'required|callback_value_check[' . $str_check_value . ']');
        $this->form_validation->set_rules('date', '<b>Tanggal Pembayaran</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;
            $this->db->trans_begin();
            try {
                $value = $this->post('value');
                if ($value > 0) {
                    $member_id = $this->post('member_id');
                    $name = $this->post('name');
                    $note = $this->post('note');
                    $date = $this->post('date');
                    $input_admin_name = $this->get_user('user_auth_name');
                    $input_admin_username = $this->get_user('user_auth_username');
                    $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                    $input_datetime = $datetime = date('Y-m-d H:i:s');
                    $now = date('Y-m-d');
                    if ($date != $now) {
                        $datetime = $this->common_model->get_dateime_by_date_transaction($date);
                    }

                    $member_detail = $this->common_model->get_member_name_code($member_id);

                    $data = array();
                    $data['entrance_fee_member_id'] = $member_id;
                    $data['entrance_fee_name'] = $name;
                    $data['entrance_fee_value'] = $value;
                    $data['entrance_fee_note'] = $note;
                    $data['entrance_fee_datetime'] = $input_datetime;
                    $data['entrance_fee_administrator_username'] = $input_admin_username;
                    $data['entrance_fee_administrator_name'] = $input_admin_name;

                    $this->db->insert('sys_trans_entrance_fee', $data);
                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }

                    $balance_log_id = 0;
                    $detail_config = $this->common_model->get_detail_entrance_fee($name);

                    if ($name == 'principal' || $name == 'obligation' || $name == 'social') {
                        $month_year = '';
                        if ($detail_config->type == 'period') {
                            if ($detail_config->period == 'monthly') {
                                $month_year = date("Y-m-01", strtotime($member_detail->member_registered_date));
                            }
                            if ($detail_config->period == 'annually') {
                                $month_year = date("Y-01-01", strtotime($member_detail->member_registered_date));
                            }
                        }
                        $balance_now = $this->common_model->get_member_balance_by_type($member_id, $name);
                        $last_balance = $balance_now + $value;
                        $balance_log = array();
                        $balance_log['balance_log_member_id'] = $member_id;
                        $balance_log['balance_log_name'] = $name;
                        $balance_log['balance_log_debet'] = $value;
                        $balance_log['balance_log_datetime'] = $datetime;
                        $balance_log['balance_log_last_balance'] = $last_balance;
                        $balance_log['balance_log_input_datetime'] = $input_datetime;
                        $balance_log['balance_log_month_year'] = $month_year;
                        $balance_log['balance_log_administrator_name'] = $input_admin_name;
                        $balance_log['balance_log_administrator_username'] = $input_admin_username;
                        $balance_log['balance_log_administrator_id'] = $this->get_user('user_auth_user_id');
                        $this->db->insert('sys_member_balance_log', $balance_log);
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }
                        $balance_log_id = $this->db->insert_id();

                        $this->db->set('member_balance_' . $name, 'member_balance_' . $name . ' + ' . $value, false);
                        $this->db->where('member_balance_member_id', $member_id);
                        $this->db->update('sys_member_balance');
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }
                    }

                    $note_trans = strtoupper("Pembayaran {$detail_config->title} atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}");
                    $trans_code = $this->common_model->generate_trans_code($date);

                    $trans = array();
                    $trans['transaction_branch_id'] = $input_admin_branch_id;
                    $trans['transaction_member_id'] = $member_id;
                    $trans['transaction_code'] = $trans_code;
                    $trans['transaction_balance_log_id'] = $balance_log_id;
                    $trans['transaction_debet'] = $value;
                    $trans['transaction_note'] = $note_trans;
                    $trans['transaction_datetime'] = $datetime;
                    $trans['transaction_input_datetime'] = $input_datetime;
                    $trans['transaction_administrator_id'] = $this->get_user('user_auth_user_id');
                    $trans['transaction_administrator_name'] = $input_admin_name;
                    $trans['transaction_administrator_username'] = $input_admin_username;
                    $this->db->insert('sys_transaction', $trans);
                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }

                    $jurnal_id = $this->common_model->get_jurnal_saving_product($name, $input_admin_branch_id);

                    if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $value, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                        $is_error = true;
                    }

                    $config = $this->common_model->get_config_entrance_fee();

                    $count_lunas = 0;
                    foreach ($config as $row) {
                        $sql_get_value = "SELECT ifnull(sum(entrance_fee_value),0) as val FROM sys_trans_entrance_fee WHERE entrance_fee_name = '{$row->name}' AND entrance_fee_member_id = $member_id";

                        $val = $this->db->query($sql_get_value)->row('val');

                        if ($val == $row->value) {
                            $count_lunas++;
                        }
                    }

                    if ($count_lunas == count($config)) {

                        $this->db->set('member_entrance_fee_paid_off', 1);
                        $this->db->where('member_id', $member_id);
                        $this->db->update('sys_member');
                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        } else {
                            $this->common_model->update_member_status($member_id);
                        }
                    }
                } else {
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

    private function get_config_title($name)
    {
        $config = $this->common_model->get_config_entrance_fee();

        foreach ($config as $row) {
            if ($row->name == $name) {
                return $row->title;
            }
        }
        return '';
    }

    public function value_check($str, $params = '')
    {
        $param = explode('::', $params);
        if (count($param) == 2) {
            $name = $param[0];
            $member_id = $param[1];

            $config = $this->common_model->get_config_entrance_fee();

            foreach ($config as $row) {
                if ($row->name == $name) {
                    $sql_get_value = "SELECT ifnull(sum(entrance_fee_value),0) as val FROM sys_trans_entrance_fee WHERE entrance_fee_name = '{$name}' AND entrance_fee_member_id = {$member_id}";

                    $val = $this->db->query($sql_get_value)->row('val');

                    if (($val + $str) > $row->value) {
                        $this->form_validation->set_message('value_check', '{field} melebihi nilai yang ditentukan.');
                        return false;
                    } else {
                        return true;
                    }
                }
            }
            $this->form_validation->set_message('value_check', '{field} tidak diinput dengan benar.');
            return false;
        } else {
            $this->form_validation->set_message('value_check', '{field} tidak diinput dengan benar.');
            return false;
        }
    }

    private function get_member($paid, $start, $limit, $sort, $dir, $filter)
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
            'member_registered_date',
            'member_input_admin_name',
            'member_input_datetime',
            'member_is_diksar',
            'member_diksar_date',
            'member_nationality',
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
            member_entrance_fee_paid_off
            FROM sys_member
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE member_entrance_fee_paid_off = $paid
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member($paid, $query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member($paid, $query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_id) as total
            FROM sys_member
            JOIN sys_branch ON branch_id = member_branch_id
            WHERE member_entrance_fee_paid_off = $paid
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

/* End of file Entrance_fee.php */
