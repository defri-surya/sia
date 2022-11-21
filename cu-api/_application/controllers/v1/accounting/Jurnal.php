<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get(){
        $limit = (int) $this->get('limit') <= 0 ? 100 : (int) $this->get('limit');
        $search_by = (string) $this->get( 'search_by');
        $search_value = (string) $this->get( 'search_value');

        $results = $this->get_jurnal($limit, $search_by, $search_value);

        $data = array(
            'results' => $results,
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);

    }
    

    public function act_add_memorial_post()
    {
        $this->form_validation->set_rules('date', '<b>Tanggal</b>', 'required|max_length[100]');
        $this->form_validation->set_rules('arr_coa', '<b>COA</b>', 'callback_coa_master_check');


        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();
            $datetime = date('Y-m-d H:i:s');

            try {
                $date = $this->post('date');

                $code = $this->common_model->generate_trans_code($date);

                $datetime = $date . date(' H:i:s');
                $input_datetime = date('Y-m-d H:i:s');
                $input_admin_name = $this->get_user('user_auth_name');
                $input_admin_username = $this->get_user('user_auth_username');

                $data_detail = array();
                $arr_detail = json_decode($this->post('arr_coa'));

                foreach ($arr_detail as $key => $detail) {
                    $data_detail[] = array(
                        'ledger_coa_master_id' => $detail->coa_master_id,
                        'ledger_trans_number' => $code,
                        'ledger_trans_number_manually' => $detail->manual_code,
                        'ledger_note' => $detail->note,
                        'ledger_debet' => $detail->debet,
                        'ledger_kredit' => $detail->kredit,
                        'ledger_datetime' => $datetime,
                        'ledger_input_datetime' => $input_datetime,
                        'ledger_input_admin_name' => $input_admin_name,
                        'ledger_input_admin_username' => $input_admin_username,
                    );
                }

                if (!$this->db->insert_batch('sys_ledger', $data_detail)) {
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

    public function coa_master_check($str)
    {
        $is_error = false;
        $msg = '';
        $arr_detail = (array) json_decode($str);

        if (!empty($arr_detail)) {
            $debet = 0;
            $kredit = 0;
            $coa_master_id = 0;
            foreach ($arr_detail as $key => $detail) {
                if(isset($detail->coa_master_id) && isset($detail->kredit) && isset($detail->debet) && isset($detail->manual_code) && isset($detail->note)){
                    if (empty($detail->coa_master_id)) {
                        $is_error = true;
                        $msg = '{field} tidak boleh kosong.';
                    } else {
                        if ($coa_master_id == $detail->coa_master_id) {
                            $is_error = true;
                            $msg = '{field} tidak boleh sama.';
                        }
                    }
                    if (!is_numeric($detail->kredit)) {
                        $is_error = true;
                        $msg = '{field} kredit harus angka.';
                    }
                    if (!is_numeric($detail->debet)) {
                        $is_error = true;
                        $msg = '{field} debet harus angka.';
                    }
                    $coa_master_id = $detail->coa_master_id;
                    $debet = $debet + $detail->debet;
                    $kredit = $kredit + $detail->kredit;
                }else{
                    $is_error = true;
                    $msg = '{field} format tidak sesuai.';
                }
            }
            if ($kredit != $debet) {
                $is_error = true;
                $msg = '{field} total debet dan kredit harus sama.';
            }
        } else {
            $is_error = true;
            $msg = 'List {field} tidak boleh kosong.';
        }

        if ($is_error == true) {
            $this->form_validation->set_message('coa_master_check', $msg);
            return false;
        } else {
            return true;
        }
    }

    private function get_jurnal( $limit, $search_by, $search_value){

        $where = "";

        if( $search_value != '' && ($search_by == 'ledger_trans_number' || $search_by == 'ledger_coa_master_id' || $search_by == 'ledger_trans_number_manually' || $search_by == 'ledger_datetime' || $search_by == 'ledger_note' || $search_by == 'coa_master_number' || $search_by == 'coa_master_title')){
            if( $search_by == 'ledger_datetime'){
                $where = "WHERE DATE(ledger_datetime) = '$search_value'";
            }else{
                $where = "WHERE $search_by = '$search_value'";
            }
        }

        $arr_trans_num = array();
        $sql_sub = "SELECT ledger_trans_number 
            FROM sys_ledger 
            JOIN sys_coa_master ON ledger_coa_master_id = coa_master_id
            $where
            GROUP BY ledger_trans_number
            ORDER BY ledger_input_datetime DESC
            LIMIT $limit
        ";

        $trans_num = $this->db->query($sql_sub);
        foreach($trans_num->result() as $row){
            $arr_trans_num[] = "'{$row->ledger_trans_number}'";
        }

        $str_trans_num = implode(',', $arr_trans_num);

        if(!empty($arr_trans_num)){
            $sql_main = "SELECT
                ledger_id,
                ledger_coa_master_id,
                ledger_trans_number,
                ledger_trans_number_manually,
                ledger_note,
                ledger_debet,
                ledger_kredit,
                ledger_datetime,
                ledger_input_datetime,
                coa_master_number,
                coa_master_title
                from sys_ledger
                JOIN sys_coa_master ON ledger_coa_master_id = coa_master_id
                WHERE ledger_trans_number IN ($str_trans_num)
                -- GROUP BY ledger_trans_number
                ORDER BY ledger_datetime DESC, ledger_trans_number DESC, ledger_debet DESC;
            ";

            // echo $sql_main;

            $jurnal = $this->db->query($sql_main);

            $result = array();

            $debet = 0;
            $kredit = 0;
            $trans_num = '';

            $temp_res = array();

            foreach ($jurnal->result_array() as $row) {
                $row['ledger_debet'] = (int) $row['ledger_debet'];
                $row['ledger_kredit'] = (int) $row['ledger_kredit'];
                if ($trans_num != '') {
                    if ($trans_num != $row['ledger_trans_number']) {
                        $result[] = array(
                            'data' => $temp_res,
                            'total' => array(
                                'debet' => $debet,
                                'kredit' => $kredit,
                            )
                        );
                        $debet = 0;
                        $kredit = 0;
                        $temp_res = array();
                    }
                }
                $temp_res[] = array_map("convertNullToString", $row);
                $debet = $debet + $row['ledger_debet'];
                $kredit = $kredit + $row['ledger_kredit'];
                $trans_num = $row['ledger_trans_number'];
            }
            $result[] = array(
                'data' => $temp_res,
                'total' => array(
                    'debet' => $debet,
                    'kredit' => $kredit,
                )
            );

            return $result;
        }else{
            return array();
        }

        
    }

}

/* End of file Jurnal.php */
