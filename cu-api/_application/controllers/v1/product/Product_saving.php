<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_saving extends Auth_Api_Controller {

    
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

        $results = $this->get_product_saving($start, $limit, $sort, $dir, $filter);
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
                    product_saving_id,
                    product_saving_code,
                    product_saving_name,
                    product_saving_name_alias,
                    product_saving_deposit_service_percent,
                    product_saving_deposit_service_method,
                    product_saving_deposit_service_min_balance,
                    product_saving_deposit_service_is_last_balance,
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
                WHERE product_saving_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Produk Simpanan.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Produk Simpanan.');
        }
    }

    public function act_add_post(){
        $this->form_validation->set_rules('code', '<b>Kode Produk</b>', 'required|is_unique[sys_product_saving.product_saving_code]');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');
        $this->form_validation->set_rules('principal_value', '<b>Simpanan Pokok</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('obligation_value', '<b>Simpanan Wajib</b>', 'is_natural_no_zero');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();

                $code = $this->post('code');
                $name = $this->post('name');
                $name_alias = $this->post('name_alias');
                $data['product_saving_code'] = $code;
                $data['product_saving_name'] = $name;
                $data['product_saving_name_alias'] = $name_alias;

                $deposit_service_percent = $this->post('deposit_service_percent');
                if (isset($deposit_service_percent)) {
                    $data['product_saving_deposit_service_percent'] = $deposit_service_percent;
                }

                $deposit_service_method = $this->post('deposit_service_method');
                if (isset($deposit_service_method)) {
                    $data['product_saving_deposit_service_method'] = $deposit_service_method;
                }

                $deposit_service_min_balance = $this->post('deposit_service_min_balance');
                if (isset($deposit_service_min_balance)) {
                    $data['product_saving_deposit_service_min_balance'] = $deposit_service_min_balance;
                }

                $initial_deposit_value = $this->post('initial_deposit_value');
                if (isset($initial_deposit_value)) {
                    $data['product_saving_initial_deposit_value'] = $initial_deposit_value;
                }

                $max_acc_deposit_per_month_value = $this->post('max_acc_deposit_per_month_value');
                if (isset($max_acc_deposit_per_month_value)) {
                    $data['product_saving_max_acc_deposit_per_month_value'] = $max_acc_deposit_per_month_value;
                }

                $min_acc_deposit_value = $this->post('min_acc_deposit_value');
                if (isset($min_acc_deposit_value)) {
                    $data['product_saving_min_acc_deposit_value'] = $min_acc_deposit_value;
                }

                $book_change_fee = $this->post('book_change_fee');
                if (isset($book_change_fee)) {
                    $data['product_saving_book_change_fee'] = $book_change_fee;
                }

                $book_lost_fee = $this->post('book_lost_fee');
                if (isset($book_lost_fee)) {
                    $data['product_saving_book_lost_fee'] = $book_lost_fee;
                }

                $open_adm_fee = $this->post('open_adm_fee');
                if (isset($open_adm_fee)) {
                    $data['product_saving_open_adm_fee'] = $open_adm_fee;
                }

                $closing_adm_fee = $this->post('closing_adm_fee');
                if (isset($closing_adm_fee)) {
                    $data['product_saving_closing_adm_fee'] = $closing_adm_fee;
                }

                $monthly_adm_fee = $this->post('monthly_adm_fee');
                if (isset($monthly_adm_fee)) {
                    $data['product_saving_monthly_adm_fee'] = $monthly_adm_fee;
                }

                $is_monthly_adm_fee = $this->post('is_monthly_adm_fee');
                if (isset($is_monthly_adm_fee)) {
                    $data['product_saving_is_monthly_adm_fee'] = $is_monthly_adm_fee;
                }

                $min_balance = $this->post('min_balance');
                if (isset($min_balance)) {
                    $data['product_saving_min_balance'] = $min_balance;
                }

                $is_loan_guarantee = $this->post('is_loan_guarantee');
                if (isset($is_loan_guarantee)) {
                    $data['product_saving_is_loan_guarantee'] = $is_loan_guarantee;
                }

                $is_withdrawal = $this->post('is_withdrawal');
                if (isset($is_withdrawal)) {
                    $data['product_saving_is_withdrawal'] = $is_withdrawal;
                }

                $is_withdrawal_represented = $this->post('is_withdrawal_represented');
                if (isset($is_withdrawal_represented)) {
                    $data['product_saving_is_withdrawal_represented'] = $is_withdrawal_represented;
                }

                $is_withdrawal_fee = $this->post('is_withdrawal_fee');
                if (isset($is_withdrawal_fee)) {
                    $data['product_saving_is_withdrawal_fee'] = $is_withdrawal_fee;
                }

                $withdraw_fee_percent = $this->post('withdraw_fee_percent');
                if (isset($withdraw_fee_percent)) {
                    $data['product_saving_withdraw_fee_percent'] = $withdraw_fee_percent;
                }

                $config_json = $this->post('config_json');
                if (!empty($config_json)) {
                    $json = '{"results": ' . $config_json . '}';
                    $data['product_saving_config_json'] = $json;
                } else {
                    $json = '{"results": [] }';
                    $data['product_saving_config_json'] = $json;
                }

                $is_period = $this->post('is_period');
                if (isset($is_period)) {
                    $data['product_saving_is_period'] = $is_period;
                }

                $min_period = $this->post('min_period');
                if (isset($min_period)) {
                    $data['product_saving_min_period'] = $min_period;
                }

                $max_period = $this->post('max_period');
                if (isset($max_period)) {
                    $data['product_saving_max_period'] = $max_period;
                }

                $is_insured = $this->post('is_insured');
                if (isset($is_insured)) {
                    $data['product_saving_is_insured'] = $is_insured;
                }

                $is_use_registration = $this->post('is_use_registration');
                if (isset($is_use_registration)) {
                    $data['product_saving_is_use_registration'] = $is_use_registration;
                }

                $is_under_age = $this->post('is_under_age');
                if (isset($is_under_age)) {
                    $data['product_saving_is_under_age'] = $is_under_age;
                }

                $this->db->insert('sys_product_saving', $data);

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
            'principal_value' => $this->put('principal_value'),
            'obligation_value' => $this->put('obligation_value')
        );
        $id = $this->put('id');

        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('code', '<b>Kode Produk</b>', 'required|unique[sys_product_saving.product_saving_code.product_saving_id.' . $id . ']');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');
        $this->form_validation->set_rules('principal_value', '<b>Simpanan Pokok</b>', 'is_natural_no_zero');
        $this->form_validation->set_rules('obligation_value', '<b>Simpanan Wajib</b>', 'is_natural_no_zero');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                $last_update = date('Y-m-d H:i:s');
                $data = array();

                $code = $this->put('code');
                $name = $this->put('name');
                $name_alias = $this->put('name_alias');
                $data['product_saving_code'] = $code;
                $data['product_saving_name'] = $name;
                $data['product_saving_name_alias'] = $name_alias;

                $deposit_service_percent = $this->put('deposit_service_percent');
                if (isset($deposit_service_percent)) {
                    $data['product_saving_deposit_service_percent'] = $deposit_service_percent;
                }

                $deposit_service_method = $this->put('deposit_service_method');
                if (isset($deposit_service_method)) {
                    $data['product_saving_deposit_service_method'] = $deposit_service_method;
                }

                $deposit_service_min_balance = $this->put('deposit_service_min_balance');
                if (isset($deposit_service_min_balance)) {
                    $data['product_saving_deposit_service_min_balance'] = $deposit_service_min_balance;
                }

                $initial_deposit_value = $this->put('initial_deposit_value');
                if (isset($initial_deposit_value)) {
                    $data['product_saving_initial_deposit_value'] = $initial_deposit_value;
                }

                $max_acc_deposit_per_month_value = $this->put('max_acc_deposit_per_month_value');
                if (isset($max_acc_deposit_per_month_value)) {
                    $data['product_saving_max_acc_deposit_per_month_value'] = $max_acc_deposit_per_month_value;
                }

                $min_acc_deposit_value = $this->put('min_acc_deposit_value');
                if (isset($min_acc_deposit_value)) {
                    $data['product_saving_min_acc_deposit_value'] = $min_acc_deposit_value;
                }

                $book_change_fee = $this->put('book_change_fee');
                if (isset($book_change_fee)) {
                    $data['product_saving_book_change_fee'] = $book_change_fee;
                }

                $book_lost_fee = $this->put('book_lost_fee');
                if (isset($book_lost_fee)) {
                    $data['product_saving_book_lost_fee'] = $book_lost_fee;
                }

                $open_adm_fee = $this->put('open_adm_fee');
                if (isset($open_adm_fee)) {
                    $data['product_saving_open_adm_fee'] = $open_adm_fee;
                }

                $closing_adm_fee = $this->put('closing_adm_fee');
                if (isset($closing_adm_fee)) {
                    $data['product_saving_closing_adm_fee'] = $closing_adm_fee;
                }

                $monthly_adm_fee = $this->put('monthly_adm_fee');
                if (isset($monthly_adm_fee)) {
                    $data['product_saving_monthly_adm_fee'] = $monthly_adm_fee;
                }

                $is_monthly_adm_fee = $this->put('is_monthly_adm_fee');
                if (isset($is_monthly_adm_fee)) {
                    $data['product_saving_is_monthly_adm_fee'] = $is_monthly_adm_fee;
                }

                $min_balance = $this->put('min_balance');
                if (isset($min_balance)) {
                    $data['product_saving_min_balance'] = $min_balance;
                }

                $is_loan_guarantee = $this->put('is_loan_guarantee');
                if (isset($is_loan_guarantee)) {
                    $data['product_saving_is_loan_guarantee'] = $is_loan_guarantee;
                }

                $is_withdrawal = $this->put('is_withdrawal');
                if (isset($is_withdrawal)) {
                    $data['product_saving_is_withdrawal'] = $is_withdrawal;
                }

                $is_withdrawal_represented = $this->put('is_withdrawal_represented');
                if (isset($is_withdrawal_represented)) {
                    $data['product_saving_is_withdrawal_represented'] = $is_withdrawal_represented;
                }

                $is_withdrawal_fee = $this->put('is_withdrawal_fee');
                if (isset($is_withdrawal_fee)) {
                    $data['product_saving_is_withdrawal_fee'] = $is_withdrawal_fee;
                }

                $withdraw_fee_percent = $this->put('withdraw_fee_percent');
                if (isset($withdraw_fee_percent)) {
                    $data['product_saving_withdraw_fee_percent'] = $withdraw_fee_percent;
                }

                $config_json = $this->put('config_json');
                if (!empty($config_json)) {
                    $json = '{"results": ' . $config_json . '}';
                    $data['product_saving_config_json'] = $json;
                }else{
                    $json = '{"results": [] }';
                    $data['product_saving_config_json'] = $json;
                }

                $is_period = $this->put('is_period');
                if (isset($is_period)) {
                    $data['product_saving_is_period'] = $is_period;
                }

                $min_period = $this->put('min_period');
                if (isset($min_period)) {
                    $data['product_saving_min_period'] = $min_period;
                }

                $max_period = $this->put('max_period');
                if (isset($max_period)) {
                    $data['product_saving_max_period'] = $max_period;
                }

                $is_insured = $this->put('is_insured');
                if (isset($is_insured)) {
                    $data['product_saving_is_insured'] = $is_insured;
                }

                $is_use_registration = $this->put('is_use_registration');
                if (isset($is_use_registration)) {
                    $data['product_saving_is_use_registration'] = $is_use_registration;
                }

                $is_under_age = $this->put('is_under_age');
                if (isset($is_under_age)) {
                    $data['product_saving_is_under_age'] = $is_under_age;
                }


                $this->db->where('product_saving_id', $id);
                $this->db->update('sys_product_saving', $data);

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

    public function act_delete_post(){
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                //hapus data
                $this->db->where('product_saving_id', $id);
                $this->db->delete('sys_product_saving');

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

    private function get_product_saving($start, $limit, $sort, $dir, $filter){
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'product_saving_id',
            'product_saving_code',
            'product_saving_name',
            'product_saving_name_alias',
            'product_saving_deposit_service_percent',
            'product_saving_deposit_service_method',
            'product_saving_deposit_service_min_balance',
            'product_saving_deposit_service_is_last_balance',
            'product_saving_initial_deposit_value',
            'product_saving_max_acc_deposit_per_month_value',
            'product_saving_min_acc_deposit_value',
            'product_saving_book_change_fee',
            'product_saving_book_lost_fee',
            'product_saving_open_adm_fee',
            'product_saving_closing_adm_fee',
            'product_saving_monthly_adm_fee',
            'product_saving_is_monthly_adm_fee',
            'product_saving_min_balance',
            'product_saving_is_loan_guarantee',
            'product_saving_is_withdrawal',
            'product_saving_is_withdrawal_represented',
            'product_saving_is_withdrawal_fee',
            'product_saving_config_json',
            'product_saving_withdraw_fee_percent',
            'product_saving_is_period',
            'product_saving_min_period',
            'product_saving_max_period',
            'product_saving_is_insured',
            'product_saving_is_use_registration',
            'product_saving_is_under_age',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'product_saving_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_product_saving
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_product_saving($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_product_saving($query_search = ''){
        $total = 0;

        $sql_total = "
            SELECT COUNT(product_saving_id) as total
            FROM sys_product_saving
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

/* End of file Product_saving.php */
