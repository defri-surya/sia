<?php

/**
 * Represent common functionality
 * @author Meychel Danius <dany.sambuari@gmail.com>
 * @since October, 6 2016
 */
class Common_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();
    }


    function get_member_id($member_code)
    {
        $member_id = "";

        $sql = "
            SELECT member_id 
            FROM sys_member 
            WHERE member_code = '" . $member_code . "'
        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $member_id = $row->member_id;
        }

        return $member_id;
    }

    function get_member_balance_by_type($id, $name)
    {
        $saldo = 0;

        $sql = "SELECT member_balance_$name as saldo FROM sys_member_balance WHERE member_balance_member_id = $id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $saldo = $query->row('saldo');
        }
        return $saldo;
    }

    function get_saving_balance($product_id, $member_id)
    {
        $saldo = 0;

        $sql = "SELECT member_product_saving_member_balance as saldo 
            FROM sys_member_product_saving 
            WHERE member_product_saving_member_id = $member_id
            AND member_product_saving_product_saving_id = $product_id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $saldo = $query->row('saldo');
        }
        return $saldo;
    }

    function get_dateime_by_date_transaction($date)
    {
        $now = date('Y-m-d');
        if ($date != $now) {
            $sql = "SELECT max(transaction_datetime) as trans_date FROM sys_transaction WHERE date(transaction_datetime) = '$date'";
            $datetime = $this->db->query($sql)->row('trans_date');

            if (!empty($datetime)) {
                return date('Y-m-d H:i:s', strtotime('+1 seconds', strtotime($datetime)));
            } else {
                return $date . ' 05:00:01';
            }
        } else {
            return date('Y-m-d H:i:s');
        }
    }

    function get_config_general($name)
    {
        $sql_config = "SELECT
                IFNULL(json_extract(config_json, '$.results'), '[]') AS config_json
                FROM sys_config
                WHERE config_name = '{$name}'
            ";
        $config = json_decode($this->db->query($sql_config)->row('config_json'));

        return $config;
    }

    function get_config_entrance_fee()
    {
        $sql_config = "SELECT
                IFNULL(json_extract(config_entrance_fee_json, '$.results'), '[]') AS config_entrance_fee_json
                FROM sys_config_entrance_fee
                WHERE config_entrance_fee_type = 0
            ";
        $config = json_decode($this->db->query($sql_config)->row('config_entrance_fee_json'));

        return $config;
    }

    function get_config_period()
    {
        $config = $this->get_config_entrance_fee();

        $arr_option = array();

        foreach ($config as $row) {
            if ($row->type == 'period') {
                $arr_option[] = array(
                    'title' => $row->title,
                    'name' => $row->name
                );
            }
        }

        return $arr_option;
    }

    function get_detail_entrance_fee($name)
    {
        $config = $this->get_config_entrance_fee();
        foreach ($config as $row) {
            if ($row->name == $name) {
                return $row;
            }
        }
        return '';
    }

    function get_config_period_with_balance($member_id)
    {
        $sql_get_balance = "SELECT * FROM sys_member_balance WHERE member_balance_member_id = '$member_id'";
        $config = $this->get_config_entrance_fee();

        $balance = $this->db->query($sql_get_balance)->row();

        $arr_option = array();
        $info = '';

        foreach ($config as $row) {
            if ($row->type == 'period') {
                $b_name = 'member_balance_' . $row->name;
                $member_balance = 0;
                if (!empty($balance)) {
                    $member_balance = $balance->$b_name;
                }
                $arr_option[] = array(
                    'title' => $row->title,
                    'name' => $row->name,
                    'period' => $row->period,
                    'value' => $row->value,
                    'balance' => $member_balance
                );
                if ($row->name == 'obligation') {
                    $sql_get = "SELECT max(balance_log_month_year) as 'date' FROM sys_member_balance_log WHERE balance_log_member_id = '$member_id' AND balance_log_name = 'obligation'";
                    $date_old = $this->db->query($sql_get)->row('date');
                    $date_now = date('Y-m-01');

                    $timeStart = strtotime($date_old);
                    $timeEnd = strtotime($date_now);
                    // Adding current month + all months in each passed year
                    $numMonths = (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
                    // Add/subtract month difference
                    $numMonths += date("m", $timeEnd) - date("m", $timeStart);

                    if ($numMonths > 0) {
                        $nilai = number_format(($numMonths * $row->value), 0, ',', '.');
                        $info = "Belum membayar {$row->title} sebanyak {$numMonths} periode senilai Rp. {$nilai}";
                    }
                }
            }
        }

        return array(
            'option' => $arr_option,
            'info' => $info
        );
    }

    function get_member_name_code($member_id)
    {
        $sql = "SELECT member_name, member_code, member_status, member_temp_code, member_registered_date FROM sys_member WHERE member_id = $member_id";
        return $this->db->query($sql)->row();
    }

    function get_member_code($user_id)
    {
        $member_code = "";

        $sql = "
            SELECT member_code FROM sys_member 
            WHERE member_id = $user_id
        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $member_code = $row->member_code;
        }

        return $member_code;
    }

    function generate_code($table_name = '', $fieldname = '', $extra = '', $digit = 5)
    {
        $sql = "
            SELECT
            IFNULL(LPAD(MAX(CAST(RIGHT(" . $fieldname . ", " . $digit . ") AS SIGNED) + 1), " . $digit . ", '0'), '" . sprintf('%0' . $digit . 'd', 1) . "') AS code 
            FROM " . $table_name . "
            " . $extra . "
          ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return '';
        }
    }

    function generate_trans_code($date, $prefix = '')
    {
        $sql = "
            SELECT
            IFNULL(LPAD(MAX(CAST(RIGHT(ledger_trans_number, 5) AS SIGNED) + 1), 5, '0'), '" . sprintf('%05d', 1) . "') AS code 
            FROM sys_ledger
            WHERE date(ledger_datetime) = '$date'
          ";
        $query = $this->db->query($sql);
        $codepref = $prefix . strtr($date, array('-' => '')) . '-';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $codepref . $row->code;
        } else {
            return $codepref . '00001';
        }
    }

    function get_jurnal_saving_product($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "simpanan_{$product_id}_cabang_$branch_id";
        } else {
            $name = "simpanan_{$product_id}";
        }
        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_withdrawal_saving_product($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "penarikan_simpanan_{$product_id}_cabang_$branch_id";
        } else {
            $name = "penarikan_simpanan_{$product_id}";
        }
        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_entrance_fee($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "uang_pangkal_{$product_id}_cabang_$branch_id";
        } else {
            $name = "uang_pangkal_{$product_id}";
        }

        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_open_loan($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "buka_pinjaman_{$product_id}_cabang_$branch_id";
        } else {
            $name = "buka_pinjaman_{$product_id}";
        }

        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_loan_principal($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "angsuran_pokok_{$product_id}_cabang_$branch_id";
        } else {
            $name = "angsuran_pokok_{$product_id}";
        }

        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_loan_interest($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "angsuran_bunga_{$product_id}_cabang_$branch_id";
        } else {
            $name = "angsuran_bunga_{$product_id}";
        }

        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function get_jurnal_loan_forfeit($product_id, $branch_id = 0)
    {
        if (USE_BRANCH_JURNAL) {
            $name = "angsuran_denda_{$product_id}_cabang_$branch_id";
        } else {
            $name = "angsuran_denda_{$product_id}";
        }

        $sql_get = "SELECT jurnal_config_jurnal_master_id as id FROM sys_jurnal_config WHERE jurnal_config_name = '$name'";
        $query = $this->db->query($sql_get);
        if ($query->num_rows() > 0) {
            return $query->row('id');
        } else {
            return 0;
        }
    }

    function insert_ladger($jurnal_master_id, $sys_no_trans, $note, $value, $datetime, $input_datetime, $admin_name, $admin_username)
    {
        $sql_detail = "SELECT jurnal_master_detail_coa_master_id as coa_master_id, 
            coa_master_type,
            jurnal_master_detail_debet as debet,
            jurnal_master_detail_kredit as kredit
            FROM sys_jurnal_master_detail 
            JOIN sys_coa_master ON jurnal_master_detail_coa_master_id = coa_master_id
            WHERE jurnal_master_detail_jurnal_master_id = $jurnal_master_id
        ";

        $arr_coa = $this->db->query($sql_detail)->result();

        $data_detail = array();

        foreach ($arr_coa as $row) {
            $detail = array(
                'ledger_coa_master_id' => $row->coa_master_id,
                'ledger_trans_number' => $sys_no_trans,
                'ledger_trans_number_manually' => 'otomatis',
                'ledger_note' => $note,
                'ledger_debet' => 0,
                'ledger_kredit' => 0,
                'ledger_datetime' => $datetime,
                'ledger_input_datetime' => $input_datetime,
                'ledger_input_admin_name' => $admin_name,
                'ledger_input_admin_username' => $admin_username,
            );
            if ($row->debet > 0) {
                $detail['ledger_debet'] = $value;
            }

            if ($row->kredit > 0) {
                $detail['ledger_kredit'] = $value;
            }

            $data_detail[] = $detail;
        }
        if (!empty($data_detail)) {
            if ($this->db->insert_batch('sys_ledger', $data_detail)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function update_member_status($member_id = 0)
    {
        $sql_get = " SELECT member_status, member_birthdate, member_nationality, member_is_diksar, member_entrance_fee_paid_off, member_working_in
        FROM sys_member WHERE member_id = $member_id AND member_status = 5";
        $row = $this->db->query($sql_get)->row();

        if (!empty($row)) {
            // WNA dan Anak tidak wajib diksar
            if ($row->member_entrance_fee_paid_off == 1) {
                $member_status = 0;
                if ($row->member_nationality == 1) {
                    $member_status = 2;
                } else {
                    $member_age = date("Y") - date("Y", strtotime($row->member_birthdate));
                    if ($member_age < 17) {
                        $member_status = 1;
                        if ($row->member_working_in == 1) {
                            $member_status = 3;
                        }
                    }
                }
                $member_code = $this->common_model->generate_code('sys_member', 'member_code');
                if ($member_status != 0) {
                    $this->db->set('member_join_datetime', date('Y-m-d H:i:s'));
                    $this->db->set('member_status', $member_status);
                    $this->db->set('member_code', $member_code);
                    $this->db->where('member_id', $member_id);
                    $this->db->update('sys_member');
                    if ($this->db->affected_rows() < 0) {
                        $this->db->set('member_product_saving_member_code', $member_code);
                        $this->db->where('member_product_saving_member_id', $member_id);
                        $this->db->update('sys_member_product_saving');
                        if ($this->db->affected_rows() < 0) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                } else {
                    if ($row->member_is_diksar == 1) {
                        if ($row->member_working_in == 1) {
                            $member_status = 3;
                        }
                        $this->db->set('member_join_datetime', date('Y-m-d H:i:s'));
                        $this->db->set('member_status', $member_status);
                        $this->db->set('member_code', $member_code);
                        $this->db->where('member_id', $member_id);
                        $this->db->update('sys_member');
                        if ($this->db->affected_rows() < 0) {
                            $this->db->set('member_product_saving_member_code', $member_code);
                            $this->db->where('member_product_saving_member_id', $member_id);
                            $this->db->update('sys_member_product_saving');
                            if ($this->db->affected_rows() < 0) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function insert_hutang_piutang($name = 'hutang', $type = 'in', $value, $member_name, $member_code, $member_id)
    {
        $date = date('Y-m-t');
        $datetime = ('Y-m-d H:i:s');
        $sql_check = "SELECT COUNT(rep_hutang_piutang_id) as total from rep_hutang_piutang WHERE rep_hutang_piutang_member_id = $member_id AND rep_hutang_piutang_month_year = $date";

        $is_update = $this->db->query($sql_check)->row('total');


        if ($is_update == 0) {
            $sql_last_data = "SELECT rep_hutang_piutang_piutang_value, rep_hutang_piutang_hutang_value from rep_hutang_piutang WHERE rep_hutang_piutang_member_id = $member_id ORDER BY rep_hutang_piutang_month_year DESC LIMIT 1";

            $last_data = $this->db->query($sql_last_data)->row();

            $data = array();
            $data['rep_hutang_piutang_member_id'] = $member_id;
            $data['rep_hutang_piutang_member_name'] = $member_name;
            $data['rep_hutang_piutang_member_code'] = $member_code;
            if ($name == 'hutang') {
                $hutang = empty($last_data) ? 0 : $last_data->rep_hutang_piutang_hutang_value;
                $piutang = empty($last_data) ? 0 : $last_data->rep_hutang_piutang_hutang_value;
                $data['rep_hutang_piutang_piutang_value'] = $hutang;
                if ($type == 'in') {
                    $data['rep_hutang_piutang_hutang_value'] = $piutang + $value;
                } else {
                    $data['rep_hutang_piutang_hutang_value'] = $piutang - $value;
                }
            } else {
                $hutang = empty($last_data) ? 0 : $last_data->rep_hutang_piutang_hutang_value;
                $piutang = empty($last_data) ? 0 : $last_data->rep_hutang_piutang_hutang_value;
                if ($type == 'in') {
                    $data['rep_hutang_piutang_piutang_value'] = $hutang + $value;
                } else {
                    $data['rep_hutang_piutang_piutang_value'] = $hutang + $value;
                }
                $data['rep_hutang_piutang_hutang_value'] = $piutang;
            }
            $data['rep_hutang_piutang_month_year'] = $date;
            $data['rep_hutang_piutang_last_updated'] = $datetime;
            $data['rep_hutang_piutang_kolektibilitas'] = '';
            if (!$this->db->insert('rep_hutang_piutang', $data)) {
                return false;
            }
        } else {
            $this->db->set('rep_hutang_piutang_last_updated', $datetime);
            $this->db->set('rep_hutang_piutang_kolektibilitas', '');
            if ($type == 'hutang') {
                if ($type == 'in') {
                    $this->db->set('rep_hutang_piutang_hutang_value', 'rep_hutang_piutang_hutang_value + ' . $value, false);
                } else {
                    $this->db->set('rep_hutang_piutang_hutang_value', 'rep_hutang_piutang_hutang_value - ' . $value, false);
                }
            } else {
                if ($type == 'in') {
                    $this->db->set('rep_hutang_piutang_piutang_value', 'rep_hutang_piutang_piutang_value + ' . $value, false);
                } else {
                    $this->db->set('rep_hutang_piutang_piutang_value', 'rep_hutang_piutang_piutang_value - ' . $value, false);
                }
            }
            $this->db->where('rep_hutang_piutang_month_year', $date);
            if (!$this->db->update('rep_hutang_piutang')) {
                return false;
            }
        }
        return true;
    }
}
