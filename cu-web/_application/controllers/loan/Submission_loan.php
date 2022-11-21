<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Submission_loan extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $arr_list_product_loan = array();
        $res = $this->curl->get(URL_API . 'option/product_loan');
        $response = json_decode($res);
        if ($response->status == 200) {
            $arr_list_product_loan = $response->data->results;
        }
        
        $data['arr_list_product_loan'] = $arr_list_product_loan;
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $this->template->content("loan/submission_loan_list_view", $data);
        $this->template->show('template');
    }

    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';
        
         array_push($filter, array(
            "type" => "list",
            "field" => "submission_product_loan_status",
            "value" => "0::1",
            "comparison" => "bet"
        ));
        
        $res = $this->curl->get(URL_API . 'loan/submission/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = array();

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );

            $arr_submission_product_loan_status = array('<span class="label label-default">menunggu</span>', '<span class="label label-info">disurvey</span>', '<span class="label label-success">disetujui</span>', '<span class="label label-danger">ditolak</span>');

            foreach ($results as $row) {
                
                $action = '<a href="javascript:;" onclick="printSubmission(\''. site_url('loan/submission_loan/act_print/' . $row->submission_product_loan_id) . '\')"><img src="' . base_url(_dir_icon . 'printer.png') . '" border="0" alt="Cetak/Survey" title="Cetak/Survey"/></a>';

                $entry = array('id' => $row->submission_product_loan_id,
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_name' => $row->member_name,
                        'product_loan_name' => $row->product_loan_name,
                        'product_loan_name_alias' => $row->product_loan_name_alias,
                        'submission_product_loan_plafon' => number_format($row->submission_product_loan_plafon, 0, ',', '.'),
                        'submission_product_loan_tenor' => number_format($row->submission_product_loan_tenor, 0, ',', '.'),
                        'submission_product_loan_interest_percent' => number_format($row->submission_product_loan_interest_percent, 2, ',', '.'),
                        'submission_product_loan_collateral_type' => $row->submission_product_loan_collateral_type,
                        'submission_product_loan_collateral_value' => number_format($row->submission_product_loan_collateral_value, 0, ',', '.'),
                        'submission_product_loan_collateral_description' => $row->submission_product_loan_collateral_description,
                        'submission_product_loan_disbursement_date' => convert_date($row->submission_product_loan_disbursement_date, 'id'),
                        'submission_product_loan_due_date' => convert_date($row->submission_product_loan_due_date, 'id'),
                        'submission_product_loan_note' => $row->submission_product_loan_note,
                        'submission_product_loan_status' => $arr_submission_product_loan_status[$row->submission_product_loan_status],
                        'submission_product_loan_input_datetime' => convert_datetime($row->submission_product_loan_input_datetime, 'id'),
                        'submission_product_loan_input_admin_username' => $row->submission_product_loan_input_admin_username,
                        'submission_product_loan_input_admin_name' => $row->submission_product_loan_input_admin_name,
                        'submission_product_loan_status_surveyor_datetime' => convert_datetime($row->submission_product_loan_status_surveyor_datetime, 'id'),
                        'submission_product_loan_status_surveyor_admin_username' => $row->submission_product_loan_status_surveyor_admin_username,
                        'submission_product_loan_status_surveyor_admin_name' => $row->submission_product_loan_status_surveyor_admin_name,
                        'submission_product_loan_status_approved' => $row->submission_product_loan_status_approved,
                        'submission_product_loan_status_rejected_datetime' => convert_datetime($row->submission_product_loan_status_rejected_datetime, 'id'),
                        'submission_product_loan_status_rejected_admin_username' => $row->submission_product_loan_status_rejected_admin_username,
                        'submission_product_loan_status_rejected_admin_name' => $row->submission_product_loan_status_rejected_admin_name,
                        'action' => $action,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function get_data_member() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        
        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_status",
            "value" => "0",
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        $json_data = $response;

        if ($response->status == 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;
            $current = $response->data->pagination->current;

            header("Content-type: application/json");

            $json_data = array(
                'page' => $current,
                'total' => $total_data,
                'offset' => "({$page} - 1) * {$limit}",
                'rows' => array()
            );
                
            $countIndex = 1;
            foreach ($results as $row) {
                $entry = array('id' => $row->member_id, 'additionalClass' => 'control-row',
                    'additionalAttr' => array(
                        'name' => 'tabindex',
                        'value' => $countIndex
                        ),
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_name' => $row->member_name,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_birthplace' => $row->member_birthplace,
                        'member_address' => $row->member_address,
                        'member_province' => $row->member_province,
                        'member_city' => $row->member_city,
                        'member_subdistrict' => $row->member_subdistrict,
                        'member_kelurahan' => $row->member_kelurahan,
                        'member_rt_number' => $row->member_rt_number,
                        'member_rw_number' => $row->member_rw_number,
                        'member_zipcode' => $row->member_zipcode,
                        'member_address_domicile' => $row->member_address_domicile,
                        'member_domicile_province' => $row->member_domicile_province,
                        'member_domicile_city' => $row->member_domicile_city,
                        'member_domicile_subdistrict' => $row->member_domicile_subdistrict,
                        'member_domicile_kelurahan' => $row->member_domicile_kelurahan,
                        'member_domicile_rt_number' => $row->member_domicile_rt_number,
                        'member_domicile_rw_number' => $row->member_domicile_rw_number,
                        'member_domicile_zipcode' => $row->member_domicile_zipcode,
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_average_income' => AVERAGE_INCOME[$row->member_average_income],
                        'member_last_education' => LAST_EDUCATION[$row->member_last_education],
                        'member_religion' => RELIGION[$row->member_religion],
                        'member_is_married' => IS_MARRIED[$row->member_is_married],
                        'member_husband_wife_name' => $row->member_husband_wife_name,
                        'member_child_name' => $row->member_child_name,
                        'member_mother_name' => $row->member_mother_name,
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_is_registered_others_cu' => $row->member_is_registered_others_cu,
                        'member_others_cu_name' => $row->member_others_cu_name,
                        'member_heir_name' => $row->member_heir_name,
                        'member_heir_status' => $row->member_heir_status,
                        'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'branch_name' => $row->branch_name,
                    ),
                );

                $json_data['rows'][] = $entry;
                $countIndex++;
            }
        }
        echo json_encode($json_data);
    }
    
    function act_add() {
        $arr_collateral_saving = $this->input->post('collateral_saving');
        $arr_collateral = $this->input->post('collateral');
        
        if(isset($arr_collateral_saving)){
            for($i = 0; $i < count($arr_collateral_saving); $i++){
                $arr_collateral_saving[$i]['collateral'] = convert_format_rp($arr_collateral_saving[$i]['collateral']);
            }
            $_POST['collateral_saving'] = $arr_collateral_saving;
        }
        
        if(isset($arr_collateral)){
            for($i = 0; $i < count($arr_collateral); $i++){
                switch ($arr_collateral[$i]['type']) {
                    case '0':
                        $arr_collateral[$i]['created_year'] = validate_date($arr_collateral[$i]['created_year'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $arr_collateral[$i]['created_year']))) : NULL;
                        break;
                    case '2':
                        $arr_collateral[$i]['deposito_due_date'] = validate_date($arr_collateral[$i]['deposito_due_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $arr_collateral[$i]['deposito_due_date']))) : NULL;
                        $arr_collateral[$i]['deposito_value'] = convert_format_rp($arr_collateral[$i]['deposito_value']);
                        break;
                }
            }
            $_POST['collateral'] = $arr_collateral;
        }
        
        $disbursement_date = validate_date($_POST['disbursement_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['disbursement_date']))) : NULL;
        $due_date = validate_date($_POST['due_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['due_date']))) : NULL;
        if ($disbursement_date != NULL && $due_date != NULL) {
            $_POST['disbursement_date'] = $disbursement_date;
            $_POST['due_date'] = $due_date;
            $res = $this->curl->post(URL_API . 'loan/submission/act_add', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal proses data! Format tanggal pencairan atau jatuh tempo salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }
    
    public function act_upload() {
        $this->load->library('upload');
        $this->load->library('image_lib');
        
        /* start upload form survey */
        $is_error_upload = FALSE;
        $str_msg_error = '';
        $file_name = '';
        $path = '';
        if (!empty($_FILES['survey']['tmp_name'])) {
            if ($this->upload->fileUpload('survey', 'assets/file_survey/', 'jpg|jpeg|pdf|png', 2048)) {
                $upload = $this->upload->data();
                $filename = 'form-survey-' . $_POST['id'] . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $filename);
                $file_name = $filename;
                $path = 'assets/file_survey/';
                
                $_POST['filename'] = $file_name;
                $_POST['path'] = $path;
            } else {
                $is_error_upload = TRUE;
                $str_msg_error = $this->upload->display_errors();
            }
        }else{
            $is_error_upload = TRUE;
            $str_msg_error = 'Anda belum memilih file.';
        }
        /* end upload form survey */
        
        if($is_error_upload){
            $res = array(
                'status' => 400,
                'msg' => $str_msg_error
            );
            echo json_encode($res);
        }else{
            $res = $this->curl->post(URL_API . 'loan/submission/act_upload', $this->input->post());
            echo $res;
        }
    }
    
    public function act_print($id) {
        if (!empty($id) && is_numeric($id)) {
            $_POST['item'] = json_encode(array($id));
            $res = $this->curl->post(URL_API . 'loan/submission/act_survey', $this->input->post());
            $response = json_decode($res);

            if ($response->status == 200) {
                $_POST['id'] = $id;
                $res = $this->curl->get(URL_API . 'loan/submission/get_detail_print', $this->input->post());
                $response = json_decode($res);

                if ($response->status == 200) {
                    $detail = $response->data;

                    $data = array();
                    $data['detail'] = $detail;
                    
                    $html = $this->load->view('loan/submission_loan_pdf_view', $data, true);

                    /* TCPDF START */
                    $this->load->library('Pdf');
                    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->SetCreator(PDF_CREATOR);
                    $pdf->SetAuthor($_SESSION['administrator_username'] . '(' . $_SESSION['administrator_name'] . ')');
                    $pdf->SetTitle("Pengajuan Pinjaman Anggota Atas Nama " . $detail->member_name . " (" . $detail->member_code . ")");
                    $pdf->SetSubject("Pengajuan Pinjaman Anggota Atas Nama " . $detail->member_name . " (" . $detail->member_code . ")");

                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(true);

                    $pdf->AddPage();

                    $pdf->SetFont("times", "", 11);
                    $pdf->writeHTML($html, true, false, false, false, '');

                    $pdf->lastPage();

                    $pdf->Output("Pengajuan_Pinjaman_Anggota_Atas_Nama_" . $detail->member_name . "_(" . $detail->member_code . ")" . "_" . date("YmdHis") . ".pdf", "I");
                    /* TCPDF END */
                } else {
                    echo '
                        <script>
                            alert("Gagal mencetak data!");
                            close();
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Gagal mencetak data!");
                        close();
                    </script>
                    ';
            }
        } else {
            show_404();
        }
    }

}
