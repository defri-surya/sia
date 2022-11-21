<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends Auth_Api_Controller
{

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
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');

        $start = ($page - 1) * $limit;

        $results = $this->get_lhk($start_date, $end_date, $start, $limit, $sort, $dir, $filter);
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

    public function get_member_balance_log_get()
    {
        $limit = (int)$this->get('limit') <= 0 ? 10 : (int)$this->get('limit');
        $page = (int)$this->get('page') <= 0 ? 1 : (int)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'DESC';
        }
        $member_id = $this->get('member_id');
        $config_name = $this->get('config_name');

        $start = ($page - 1) * $limit;

        $results = $this->get_member_balance_log($member_id, $config_name, $start, $limit, $sort, $dir, $filter);
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


    public function get_member_saving_log_get()
    {
        $limit = (int)$this->get('limit') <= 0 ? 10 : (int)$this->get('limit');
        $page = (int)$this->get('page') <= 0 ? 1 : (int)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'DESC';
        }
        $member_id = $this->get('member_id');
        $saving_id = $this->get('saving_id');

        $start = ($page - 1) * $limit;

        $results = $this->get_member_saving_log($member_id, $saving_id, $start, $limit, $sort, $dir, $filter);
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

    public function get_option_payment_get()
    {
        $member_id = (string)$this->get('member_code');

        if (!empty($member_id)) {
            $sql_get_member_detail = "SELECT
                member_id,
                member_code,
                member_temp_code,
                member_name,
                branch_name
                FROM sys_member 
                JOIN sys_branch ON branch_id = member_branch_id
                WHERE member_id = '$member_id'
            ";
            $detail_member = $this->db->query($sql_get_member_detail)->row();

            if (!empty($detail_member)) {
                $sql_get_saving = "SELECT 
                    member_product_saving_id as saving_id,
                    member_product_saving_product_saving_id as id, 
                    product_saving_name as 'name', 
                    member_product_saving_member_balance as balance, 
                    member_product_saving_account_number as account_number, 
                    member_product_saving_is_active as is_active, 
                    product_saving_name_alias as name_alias, 
                    product_saving_initial_deposit_value as min_initial, 
                    product_saving_min_acc_deposit_value as min_deposit,
                    CONCAT(product_saving_name_alias, ' - ', member_product_saving_account_number) as 'label'
                    FROM sys_member_product_saving
                    JOIN sys_product_saving ON product_saving_id = member_product_saving_product_saving_id
                    WHERE member_product_saving_member_id = '{$member_id}'
                ";
                $arr_saving_option = $this->db->query($sql_get_saving)->result();

                $arr_option = $this->common_model->get_config_period_with_balance($member_id);

                $arr_option['option'][] = array(
                    'title' => 'Simpanan',
                    'name' => 'saving',
                    'option' => $arr_saving_option
                );

                $data = array(
                    'detail_member' => $detail_member,
                    'option_payment' => $arr_option['option'],
                    'info' => $arr_option['info']
                );

                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Data tidak ditemukan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan pilihan pembayaran.');
        }
    }

    public function act_add_premium_post()
    {
        $this->form_validation->set_rules('member_id', '<b>Nama Anggota</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('name', '<b>Jenis Simpanan</b>', 'required|callback_name_check');
        $this->form_validation->set_rules('period', '<b>Jumlah Periode</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('date', '<b>Tanggal Pembayaran</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            $str_msg = "";

            try {

                $member_id = $this->post('member_id');
                $name = $this->post('name');
                $period = $this->post('period');
                $date = $this->post('date');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');
                $input_admin_id = $this->get_user('user_auth_user_id');
                $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                $input_datetime = $datetime = date('Y-m-d H:i:s');
                $now = date('Y-m-d');
                if ($date != $now) {
                    $datetime = $this->common_model->get_dateime_by_date_transaction($date);
                }

                $member_detail = $this->common_model->get_member_name_code($member_id);

                $sql_get_date = "SELECT balance_log_month_year 
                    FROM sys_member_balance_log 
                    WHERE balance_log_member_id = $member_id
                    AND balance_log_name = '$name'
                    ORDER BY balance_log_datetime DESC
                    LIMIT 1";
                $year_month = $this->db->query($sql_get_date)->row('balance_log_month_year');

                $nominal_saving = 0;
                $last_balance = 0;
                $detail_config = $this->common_model->get_detail_entrance_fee($name);

                for ($i = 1; $i <= $period; $i++) {
                    $month_year = '';
                    if ($detail_config->period == 'monthly') {
                        $month_year = date("Y-m-01", strtotime("+$i month", strtotime($year_month)));
                    }
                    if ($detail_config->period == 'annually') {
                        $month_year = date("Y-01-01", strtotime("+$i year", strtotime($year_month)));
                    }
                    $nominal_saving += $detail_config->value;

                    $balance_now = $this->common_model->get_member_balance_by_type($member_id, $name);
                    $last_balance = $balance_now + $nominal_saving;


                    $balance_log = array();
                    $balance_log['balance_log_member_id'] = $member_id;
                    $balance_log['balance_log_name'] = $name;
                    $balance_log['balance_log_debet'] = $detail_config->value;
                    $balance_log['balance_log_datetime'] = $datetime;
                    $balance_log['balance_log_last_balance'] = $last_balance;
                    $balance_log['balance_log_input_datetime'] = $input_datetime;
                    $balance_log['balance_log_month_year'] = $month_year;
                    $balance_log['balance_log_administrator_name'] = $input_admin_name;
                    $balance_log['balance_log_administrator_username'] = $input_admin_username;
                    $balance_log['balance_log_administrator_id'] = $input_admin_id;
                    if (!$this->db->insert('sys_member_balance_log', $balance_log)) {
                        $is_error = true;
                    }
                }

                $this->db->set('member_balance_' . $name, 'member_balance_' . $name . ' + ' . $nominal_saving, false);
                $this->db->where('member_balance_member_id', $member_id);
                $this->db->update('sys_member_balance');
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }
                $str_msg = $detail_config->title . ' sejumlah ' . $period . ' periode atas nama ' . $member_detail->member_name . '.';

                $note_trans = strtoupper("Pembayaran {$detail_config->title} sejumlah {$period} periode atas nama {$member_detail->member_name}, nomor anggota {$member_detail->member_code}");
                $trans_code = $this->common_model->generate_trans_code($date);
                $trans = array();
                $trans['transaction_branch_id'] = $input_admin_branch_id;
                $trans['transaction_member_id'] = $member_id;
                $trans['transaction_code'] = $trans_code;
                $trans['transaction_debet'] = $nominal_saving;
                $trans['transaction_note'] = $note_trans;
                $trans['transaction_datetime'] = $datetime;
                $trans['transaction_input_datetime'] = $input_datetime;
                $trans['transaction_administrator_id'] = $input_admin_id;
                $trans['transaction_administrator_name'] = $input_admin_name;
                $trans['transaction_administrator_username'] = $input_admin_username;
                $this->db->insert('sys_transaction', $trans);
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if (!$this->common_model->insert_hutang_piutang('piutang', 'in', $nominal_saving, $member_detail->member_name, $member_detail->member_code, $member_id)) {
                    $is_error = true;
                }

                $jurnal_id = $this->common_model->get_jurnal_saving_product($name, $input_admin_branch_id);

                if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $nominal_saving, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan pembayaran ' . $str_msg);
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran! Silahkan coba lagi.');
            }
        }
    }

    public function act_add_saving_post()
    {
        $this->form_validation->set_rules('saving_id', '<b>Produk Simpanan</b>', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('nominal_saving', '<b>Jumlah Setoran</b>', 'required|callback_min_deposit_check[' . $this->post('saving_id') . ']');
        $this->form_validation->set_rules('date', '<b>Tanggal Pembayaran</b>', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();
            $str_msg = "";

            try {

                $saving_id = $this->post('saving_id');
                $nominal_saving = $this->post('nominal_saving');
                $note = $this->post('note');
                $date = $this->post('date');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');
                $input_admin_id = $this->get_user('user_auth_user_id');
                $input_admin_branch_id = $this->get_user('user_auth_branch_id');
                $input_datetime = $datetime = date('Y-m-d H:i:s');
                $now = date('Y-m-d');
                if ($date != $now) {
                    $datetime = $this->common_model->get_dateime_by_date_transaction($date);
                }

                $member_product = $this->get_detail_saving($saving_id);
                $str_msg = $member_product->product_name_alias . ' atas nama ' . $member_product->member_name . '.';

                $last_balance = $member_product->saldo + $nominal_saving;

                $mb_log = array();
                $mb_log['member_product_saving_log_member_product_saving_id'] = $member_product->id;
                $mb_log['member_product_saving_log_member_id'] = $member_product->member_id;
                $mb_log['member_product_saving_log_code'] = $member_product->id . '/' . strtotime($input_datetime); // sementara tak kaya giniin om
                $mb_log['member_product_saving_log_debet'] = $nominal_saving;
                $mb_log['member_product_saving_log_last_balance'] = $last_balance;
                $mb_log['member_product_saving_log_note'] = $note;
                $mb_log['member_product_saving_log_datetime'] = $datetime;
                $mb_log['member_product_saving_log_input_datetime'] = $input_datetime;
                $mb_log['member_product_saving_log_input_admin_name'] = $input_admin_name;
                $mb_log['member_product_saving_log_input_admin_username'] = $input_admin_username;
                $mb_log['member_product_saving_log_input_admin_id'] = $input_admin_id;
                $this->db->insert('sys_member_product_saving_log', $mb_log);
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                $this->db->set('member_product_saving_member_balance', 'member_product_saving_member_balance  + ' . $nominal_saving, false);
                $this->db->set('member_product_saving_is_active', '1');
                $this->db->where('member_product_saving_id', $member_product->id);
                $this->db->update('sys_member_product_saving');
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                $note_trans = strtoupper("Setoran {$member_product->product_name_alias} ({$member_product->product_name}) atas nama {$member_product->member_name}, nomor anggota {$member_product->member_code}, nomor rekening {$member_product->account_number}");
                $trans_code = $this->common_model->generate_trans_code($date);
                $trans = array();
                $trans['transaction_branch_id'] = $input_admin_branch_id;
                $trans['transaction_member_id'] = $member_product->member_id;
                $trans['transaction_code'] = $trans_code;
                $trans['transaction_product_saving_id'] = $member_product->product_id;
                $trans['transaction_debet'] = $nominal_saving;
                $trans['transaction_note'] = $note_trans;
                $trans['transaction_datetime'] = $datetime;
                $trans['transaction_input_datetime'] = $input_datetime;
                $trans['transaction_administrator_id'] = $input_admin_id;
                $trans['transaction_administrator_name'] = $input_admin_name;
                $trans['transaction_administrator_username'] = $input_admin_username;
                $this->db->insert('sys_transaction', $trans);
                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if (!$this->common_model->insert_hutang_piutang('piutang', 'in', $nominal_saving, $member_product->member_name, $member_product->member_code, $member_product->member_id)) {
                    $is_error = true;
                }

                $jurnal_id = $this->common_model->get_jurnal_saving_product($member_product->product_id, $input_admin_branch_id);

                if (!$this->common_model->insert_ladger($jurnal_id, $trans_code, $note_trans, $nominal_saving, $datetime, $input_datetime, $input_admin_name, $input_admin_username)) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil melakukan pembayaran ' . $str_msg);
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal melakukan pembayaran! Silahkan coba lagi.');
            }
        }
    }

    public function name_check($str)
    {

        $is_true = false;
        $config = $this->common_model->get_config_entrance_fee();
        foreach ($config as $row) {
            if ($row->name == $str) {
                $is_true = true;
                break;
            }
        }

        if ($is_true) {
            return true;
        } else {
            $this->form_validation->set_message('name_check', '{field} tidak terdaftar.');
            return false;
        }
    }

    public function min_deposit_check($str, $params)
    {
        if (!empty($str)) {
            if (is_numeric($str)) {
                $saving_id = $params;
                $sql_get = "SELECT 
                    product_saving_min_acc_deposit_value as nominal, 
                    product_saving_initial_deposit_value as initial 
                    FROM sys_product_saving 
                    JOIN sys_member_product_saving ON member_product_saving_product_saving_id = product_saving_id
                    WHERE member_product_saving_id = $saving_id
                ";
                $query = $this->db->query($sql_get);
                $sql_get_member = "SELECT 
                    member_product_saving_is_active as active, 
                    member_product_saving_member_balance as balance 
                    FROM sys_member_product_saving 
                    WHERE member_product_saving_id = $saving_id
                ";
                $query_member = $this->db->query($sql_get_member);
                if ($query->num_rows() > 0 && $query_member->num_rows() > 0) {
                    $nominal = $query->row('nominal');
                    $initial = $query->row('initial');
                    $active = $query_member->row('active');
                    $balance = $query_member->row('balance');

                    if ($active == 0 || $balance == 0) {
                        if ($str < $initial) {
                            $this->form_validation->set_message('min_deposit_check', '{field} kurang dari minimal setoran awal. Minimal setoran awal adalah ' . number_format($initial, 0, ',', '.'));
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        if ($str < $nominal) {
                            $this->form_validation->set_message('min_deposit_check', '{field} kurang dari minimal setoran. Minimal setoran adalah ' . number_format($nominal, 0, ',', '.'));
                            return false;
                        } else {
                            return true;
                        }
                    }
                } else {
                    $this->form_validation->set_message('min_deposit_check', '{field} simpanan tidak ditemukan.');
                    return false;
                }
            } else {
                $this->form_validation->set_message('min_deposit_check', '{field} harus angka.');
                return false;
            }
        } else {
            $this->form_validation->set_message('min_deposit_check', '{field} tidak boleh kosong.');
            return false;
        }
    }

    private function get_lhk($start_date, $end_date, $start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'transaction_id',
            'transaction_member_id',
            'member_name',
            'member_code',
            'member_temp_code',
            'transaction_product_saving_id',
            'transaction_product_loan_id',
            'transaction_balance_log_id',
            'transaction_debet',
            'transaction_kredit',
            'transaction_note',
            'transaction_input_datetime',
            'transaction_datetime',
            'transaction_administrator_id',
            'transaction_administrator_name',
            'transaction_administrator_username',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (validate_date($start_date) && validate_date($end_date)) {
            $query_search .= " AND DATE(transaction_datetime) BETWEEN '{$start_date}' AND '{$end_date}'";
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'transaction_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_transaction
            JOIN sys_member ON transaction_member_id = member_id
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_lhk($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_lhk($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_id) as total
            FROM sys_transaction
            JOIN sys_member ON transaction_member_id = member_id
            WHERE 0=0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    private function get_detail_saving($saving_id)
    {
        $sql_get_saving = "SELECT 
            member_id,
            member_product_saving_id as id,
            member_product_saving_name as product_name,
            member_product_saving_name_alias as product_name_alias,
            member_product_saving_product_saving_id as product_id,
            member_product_saving_member_code as member_code,
            member_product_saving_account_number as account_number,
            member_product_saving_member_balance as saldo,
            member_name
            FROM sys_member_product_saving 
            JOIN sys_member ON member_id = member_product_saving_member_id
            WHERE member_product_saving_id = $saving_id
        ";
        return $this->db->query($sql_get_saving)->row();
    }

    private function get_member_balance_log($member_id, $config_name, $start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'balance_log_id',
            'balance_log_member_id',
            'balance_log_name',
            'balance_log_debet',
            'balance_log_kedit',
            'balance_log_last_balance',
            'balance_log_month_year',
            'balance_log_datetime',
            'balance_log_input_datetime',
            'balance_log_administrator_name',
            'balance_log_administrator_username',
            'balance_log_administrator_id',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        $query_search .= " AND balance_log_member_id = $member_id AND balance_log_name = '$config_name'";

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'balance_log_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member_balance_log
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member_balance_log($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member_balance_log($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(balance_log_id) as total
            FROM sys_member_balance_log
            WHERE 0=0
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

    private function get_member_saving_log($member_id, $saving_id, $start, $limit, $sort, $dir, $filter)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'member_product_saving_log_id',
            'member_product_saving_log_code',
            'member_product_saving_log_debet',
            'member_product_saving_log_kredit',
            'member_product_saving_log_last_balance',
            'member_product_saving_log_note',
            'member_product_saving_log_datetime',
            'member_product_saving_log_input_datetime',
            'member_product_saving_log_input_admin_name',
            'member_product_saving_log_input_admin_username',
            'member_product_saving_log_input_admin_id',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        $query_search .= " AND member_product_saving_log_member_id = $member_id AND member_product_saving_log_member_product_saving_id = $saving_id";

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'member_product_saving_log_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_member_product_saving_log
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_member_saving_log($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_member_saving_log($query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(member_product_saving_log_id) as total
            FROM sys_member_product_saving_log
            WHERE 0=0
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

/* End of file Payment.php */
