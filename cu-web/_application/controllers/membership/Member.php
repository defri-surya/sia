<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Member extends Backend_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->show();
    }

    public function tes()
    {
        $res = $this->curl->get(URL_API . 'membership/entrance_fee/get_data_by_member', array('member_id' => 1));
        echo '<pre>';
        print_r(json_decode($res));
        die;
    }

    public function show()
    {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("membership/member_list_view", $data);
        $this->template->show('template');
    }

    public function get_data()
    {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $member_status = $this->input->post('member_status');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        if ($member_status == "member") {
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "0",
                "comparison" => "="
            ));
        } else if ($member_status == "alb") {
            array_push($filter, array(
                "type" => "list",
                "field" => "member_status",
                "value" => "1::3",
                "comparison" => "bet"
            ));
        } else {
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "4",
                "comparison" => "="
            ));
        }

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir
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

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->member_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalEdit(' . $row->member_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array(
                    'id' => $row->member_id,
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
                        'member_nationality' => NATIONALITY[$row->member_nationality],
                        'member_phone_number' => $row->member_phone_number,
                        'member_mobilephone_number' => $row->member_mobilephone_number,
                        'member_job' => $row->member_job,
                        'member_job_detail' => $row->member_job_detail,
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
                        'member_working_in' => WORKING_IN[$row->member_working_in],
                        'member_ethnic_group' => $row->member_ethnic_group,
                        'member_residence_status' => RESIDENCE_STATUS[$row->member_residence_status],
                        'member_blood_type' => BLOOD_TYPE[$row->member_blood_type],
                        'member_shirt_size' => SHIRT_SIZE[$row->member_shirt_size],
                        'member_entrance_fee_paid_off' => ENTRANCE_FEE_PAID_OFF[$row->member_entrance_fee_paid_off],
                        'member_is_diksar' => IS_DIKSAR[$row->member_is_diksar],
                        'detail' => $detail,
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    public function act_update()
    {
        $member_birthdate = validate_date($_POST['birthdate'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['birthdate']))) : NULL;
        //        $member_join_datetime = validate_date($_POST['join_datetime'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['join_datetime']))) : NULL;

        $arr_member_child_name = $_POST['child_name'];
        if (!empty($arr_member_child_name)) {
            $_POST['child_name'] = implode("#", $arr_member_child_name);
        } else {
            $_POST['child_name'] = '';
        }

        $arr_member_heir_name = $_POST['heir_name'];
        if (!empty($arr_member_heir_name)) {
            $_POST['heir_name'] = implode("#", $arr_member_heir_name);
        } else {
            $_POST['heir_name'] = '';
        }

        $arr_member_heir_status = $_POST['heir_status'];
        if (!empty($arr_member_heir_status)) {
            $_POST['heir_status'] = implode("#", $arr_member_heir_status);
        } else {
            $_POST['heir_status'] = '';
        }

        //        if ($member_birthdate != NULL && $member_join_datetime != NULL) {
        if ($member_birthdate != NULL) {
            //            $_POST['join_datetime'] = $member_join_datetime . ' ' . date('H:i:s');
            $_POST['birthdate'] = $member_birthdate;

            $this->load->library('upload');
            $this->load->library('image_lib');

            $arr_error_msg = array();


            /* start upload photo */
            $is_error_upload = FALSE;
            $file_name = '';
            $path = '';
            if (!empty($_FILES['img_photo']['tmp_name'])) {
                if ($this->upload->fileUpload('img_photo', 'assets/images/member/member_photo/', 'jpg|jpeg|gif|png', 1024)) {
                    $upload = $this->upload->data();
                    $size = getimagesize($upload['full_path']);
                    $width = $size[0];
                    $height = $size[1];
                    if ($width != 250 || $height != 250) {
                        $this->image_lib->resizeImage($upload['full_path'], 250, 250);
                        $this->image_lib->cropCenterImage($upload['full_path'], 250, 250);
                    }
                    $image_filename = url_title($this->input->post('name')) . '-photo-' . date("YmdHis") . strtolower($upload['file_ext']);
                    rename($upload['full_path'], $upload['file_path'] . $image_filename);
                    $file_name = $image_filename;
                    $path = 'assets/images/member/member_photo/';
                } else {
                    $is_error_upload = TRUE;
                }
            }
            if ($is_error_upload) {
                array_push($arr_error_msg, $this->upload->display_errors());
            }
            $_POST['photo_filename'] = $file_name;
            $_POST['photo_path'] = $path;
            /* end upload photo */

            /* start upload id */
            $is_error_upload = FALSE;
            $file_name = '';
            $path = '';
            if (!empty($_FILES['img_id']['tmp_name'])) {
                if ($this->upload->fileUpload('img_id', 'assets/images/member/member_id/', 'jpg|jpeg|gif|png', 1024)) {
                    $upload = $this->upload->data();
                    $size = getimagesize($upload['full_path']);
                    $width = $size[0];
                    $height = $size[1];
                    if ($width != 250 || $height != 250) {
                        $this->image_lib->resizeImage($upload['full_path'], 250, 250);
                        $this->image_lib->cropCenterImage($upload['full_path'], 250, 250);
                    }
                    $image_filename = url_title($this->input->post('name')) . '-id-' . date("YmdHis") . strtolower($upload['file_ext']);
                    rename($upload['full_path'], $upload['file_path'] . $image_filename);
                    $file_name = $image_filename;
                    $path = 'assets/images/member/member_id/';
                } else {
                    $is_error_upload = TRUE;
                }
            }
            if ($is_error_upload) {
                array_push($arr_error_msg, $this->upload->display_errors());
            }
            $_POST['identity_filename'] = $file_name;
            $_POST['identity_path'] = $path;
            /* end upload id */

            /* start upload signature */
            $is_error_upload = FALSE;
            $file_name = '';
            $path = '';
            if (!empty($_FILES['img_signature']['tmp_name'])) {
                if ($this->upload->fileUpload('img_signature', 'assets/images/member/member_signature/', 'jpg|jpeg|gif|png', 1024)) {
                    $upload = $this->upload->data();
                    $size = getimagesize($upload['full_path']);
                    $width = $size[0];
                    $height = $size[1];
                    if ($width != 250 || $height != 250) {
                        $this->image_lib->resizeImage($upload['full_path'], 250, 250);
                        $this->image_lib->cropCenterImage($upload['full_path'], 250, 250);
                    }
                    $image_filename = url_title($this->input->post('name')) . '-signature-' . date("YmdHis") . strtolower($upload['file_ext']);
                    rename($upload['full_path'], $upload['file_path'] . $image_filename);
                    $file_name = $image_filename;
                    $path = 'assets/images/member/member_signature/';
                } else {
                    $is_error_upload = TRUE;
                }
            }
            if ($is_error_upload) {
                array_push($arr_error_msg, $this->upload->display_errors());
            }
            $_POST['signature_filename'] = $file_name;
            $_POST['signature_path'] = $path;
            /* end upload signature */

            $res = $this->curl->put(URL_API . 'membership/member/act_update', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function export_data_member()
    {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');
        $member_status = $this->input->post('member_status');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        if ($member_status == "member") {
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "0",
                "comparison" => "="
            ));
        } else if ($member_status == "alb") {
            array_push($filter, array(
                "type" => "list",
                "field" => "member_status",
                "value" => "1::3",
                "comparison" => "bet"
            ));
        } else {
            array_push($filter, array(
                "type" => "numeric",
                "field" => "member_status",
                "value" => "4",
                "comparison" => "="
            ));
        }

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "export" => 1,
        ));
        $response = json_decode($res);

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;

            foreach ($results as $key => $value) {
                $results[$key]->member_identity_type = IDENTITY_TYPE[$results[$key]->member_identity_type];
                $results[$key]->member_gender = GENDER[$results[$key]->member_gender];
                $results[$key]->member_average_income = AVERAGE_INCOME[$results[$key]->member_average_income];
                $results[$key]->member_last_education = LAST_EDUCATION[$results[$key]->member_last_education];
                $results[$key]->member_religion = RELIGION[$results[$key]->member_religion];
                $results[$key]->member_is_married = IS_MARRIED[$results[$key]->member_is_married];
                $results[$key]->member_status = MEMBER_STATUS_TEXT[$results[$key]->member_status];
                $results[$key]->member_working_in = WORKING_IN[$results[$key]->member_working_in];
                $results[$key]->member_residence_status = RESIDENCE_STATUS[$results[$key]->member_residence_status];
                $results[$key]->member_blood_type = BLOOD_TYPE[$results[$key]->member_blood_type];
                $results[$key]->member_shirt_size = SHIRT_SIZE[$results[$key]->member_shirt_size];
            }

            $data = array();
            $data['title'] = 'Data Anggota';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }
}
