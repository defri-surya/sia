<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_loan extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("loan/approval_loan_list_view", $data);
        $this->template->show('template');
    }

    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');

        $arr_status = array('submission' => '0::1', 'approved' => '2', 'rejected' => '3');
        $status = $this->input->post('status');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'product_saving_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

//        if(!in_array($status, $arr_status)){
//            $status = 'submission';
//        }

        array_push($filter, array(
            "type" => "list",
            "field" => "submission_product_loan_status",
            "value" => $arr_status[$status],
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

            $arr_submission_product_loan_status = array('<span class="label label-default">menunggu</span>', '<span class="label label-info">disurvey</span>', '<span class="label label-success">disetujui</span>', '<span class="label label-danger">ditolak</span>');

            foreach ($results as $row) {
                
                $download = '<img src="' . base_url(_dir_icon . 'downloads.png') . '" border="0" class="no-file" alt="No File" title="No File">';
                if(!empty($row->submission_product_loan_survey_filename)){
                    $download = '<a href="javascript:;" onclick="downloadFileSurvey(\'' . $row->submission_product_loan_survey_filename . '\')"><img src="' . base_url(_dir_icon . 'downloads.png') . '" border="0" alt="File Ready" title="File Ready"></a>';
                }

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
                        'download' => $download,
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function act_approve() {
        $disbursement_date = validate_date($_POST['disbursement_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['disbursement_date']))) : NULL;
        $due_date = validate_date($_POST['due_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['due_date']))) : NULL;
        $forfiet_date = validate_date($_POST['forfiet_date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['forfiet_date']))) : NULL;
        if ($disbursement_date != NULL && $due_date != NULL && $forfiet_date != NULL) {
            $_POST['disbursement_date'] = $disbursement_date;
            $_POST['due_date'] = $due_date;
            $_POST['forfiet_date'] = $forfiet_date;
            $res = $this->curl->post(URL_API . 'loan/submission/act_approve', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal proses data! Format tanggal pencairan atau jatuh tempo salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function act_reject() {
        $res = $this->curl->post(URL_API . 'loan/submission/act_reject', $this->input->post());
        echo $res;
    }
    
    function get_file($filename) {
        $this->load->helper('download');
        force_download('assets/file_survey/' . $filename, NULL);
    }
}
