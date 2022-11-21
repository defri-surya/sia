<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_loan extends Auth_Api_Controller {

    
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

        $results = $this->get_product_loan($start, $limit, $sort, $dir, $filter);
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
                    product_loan_id,
                    product_loan_code,
                    product_loan_name,
                    product_loan_name_alias,
                    product_loan_max_plafon,
                    product_loan_service_percent,
                    product_loan_service_loan_percent1,
                    product_loan_service_loan_percent2,
                    product_loan_forfeit_percent,
                    product_loan_interest_percent,
                    product_loan_interest_type,
                    product_loan_pinalty_fee_percent,
                    product_loan_collateral_type,
                    product_loan_is_daperma
                FROM sys_product_loan
                WHERE product_loan_id = $id
            ";

            $data = array_map("convertNullToString", $this->db->query($sql)->row_array());
            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Produk Pinjaman.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Produk Pinjaman.');
        }
    }

    public function act_add_post(){
        $this->form_validation->set_rules('code', '<b>Kode Produk</b>', 'required|is_unique[sys_product_loan.product_loan_code]');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');

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
                $data['product_loan_code'] = $code;
                $data['product_loan_name'] = $name;
                $data['product_loan_name_alias'] = $name_alias;

                $max_plafon = $this->post('max_plafon');
                if (!empty($max_plafon)) {
                    $data['product_loan_max_plafon'] = $max_plafon;
                }

                $service_percent = $this->post('service_percent');
                if (!empty($service_percent)) {
                    $data['product_loan_service_percent'] = $service_percent;
                }

                $service_loan_percent1 = $this->post('service_loan_percent1');
                if (!empty($service_loan_percent1)) {
                    $data['product_loan_service_loan_percent1'] = $service_loan_percent1;
                }

                $service_loan_percent2 = $this->post('service_loan_percent2');
                if (!empty($service_loan_percent2)) {
                    $data['product_loan_service_loan_percent2'] = $service_loan_percent2;
                }

                $forfeit_percent = $this->post('forfeit_percent');
                if (!empty($forfeit_percent)) {
                    $data['product_loan_forfeit_percent'] = $forfeit_percent;
                }

                $interest_percent = $this->post('interest_percent');
                if (!empty($interest_percent)) {
                    $data['product_loan_interest_percent'] = $interest_percent;
                }

                $interest_type = $this->post('interest_type');
                if (!empty($interest_type)) {
                    $data['product_loan_interest_type'] = $interest_type;
                }

                $pinalty_fee_percent = $this->post('pinalty_fee_percent');
                if (!empty($pinalty_fee_percent)) {
                    $data['product_loan_pinalty_fee_percent'] = $pinalty_fee_percent;
                }

                $collateral_type = $this->post('collateral_type');
                if (!empty($collateral_type)) {
                    $data['product_loan_collateral_type'] = $collateral_type;
                }

                $is_daperma = $this->post('is_daperma');
                if (!empty($is_daperma)) {
                    $data['product_loan_is_daperma'] = $is_daperma;
                }


                $this->db->insert('sys_product_loan', $data);

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
            'name' => $this->put('name')
        );
        $id = $this->put('id');

        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('code', '<b>Kode Produk</b>', 'required|unique[sys_product_loan.product_loan_code.product_loan_id.'.$id.']');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');

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
                $data['product_loan_code'] = $code;
                $data['product_loan_name'] = $name;
                $data['product_loan_name_alias'] = $name_alias;

                $max_plafon = $this->put('max_plafon');
                if (!empty($max_plafon)) {
                    $data['product_loan_max_plafon'] = $max_plafon;
                }

                $service_percent = $this->put('service_percent');
                if (!empty($service_percent)) {
                    $data['product_loan_service_percent'] = $service_percent;
                }

                $service_loan_percent1 = $this->put('service_loan_percent1');
                if (!empty($service_loan_percent1)) {
                    $data['product_loan_service_loan_percent1'] = $service_loan_percent1;
                }

                $service_loan_percent2 = $this->put('service_loan_percent2');
                if (!empty($service_loan_percent2)) {
                    $data['product_loan_service_loan_percent2'] = $service_loan_percent2;
                }

                $forfeit_percent = $this->put('forfeit_percent');
                if (!empty($forfeit_percent)) {
                    $data['product_loan_forfeit_percent'] = $forfeit_percent;
                }

                $interest_percent = $this->put('interest_percent');
                if (!empty($interest_percent)) {
                    $data['product_loan_interest_percent'] = $interest_percent;
                }

                $interest_type = $this->put('interest_type');
                if (!empty($interest_type)) {
                    $data['product_loan_interest_type'] = $interest_type;
                }

                $pinalty_fee_percent = $this->put('pinalty_fee_percent');
                if (!empty($pinalty_fee_percent)) {
                    $data['product_loan_pinalty_fee_percent'] = $pinalty_fee_percent;
                }

                $collateral_type = $this->put('collateral_type');
                if (!empty($collateral_type)) {
                    $data['product_loan_collateral_type'] = $collateral_type;
                }

                $is_daperma = $this->put('is_daperma');
                if (!empty($is_daperma)) {
                    $data['product_loan_is_daperma'] = $is_daperma;
                }


                $this->db->where('product_loan_id', $id);
                $this->db->update('sys_product_loan', $data);

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
                $this->db->where('product_loan_id', $id);
                $this->db->delete('sys_product_loan');

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

    private function get_product_loan($start, $limit, $sort, $dir, $filter){
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'product_loan_id',
            'product_loan_code',
            'product_loan_name',
            'product_loan_name_alias',
            'product_loan_max_plafon',
            'product_loan_service_percent',
            'product_loan_service_loan_percent1',
            'product_loan_service_loan_percent2',
            'product_loan_forfeit_percent',
            'product_loan_interest_percent',
            'product_loan_interest_type',
            'product_loan_pinalty_fee_percent',
            'product_loan_collateral_type',
            'product_loan_is_daperma',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'product_loan_id';
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_product_loan
            WHERE 0=0
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_product_loan($query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_product_loan($query_search = ''){
        $total = 0;

        $sql_total = "
            SELECT COUNT(product_loan_id) as total
            FROM sys_product_loan
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

/* End of file Product_loan.php */
