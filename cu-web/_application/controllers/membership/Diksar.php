<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Diksar extends Backend_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->show();
    }

    public function show()
    {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("membership/diksar_list_view", $data);
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
        $member_is_diksar = $this->input->post('member_is_diksar', TRUE);

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        $res = $this->curl->get(URL_API . 'membership/diksar/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "diksar" => $member_is_diksar
        ));
        $response = json_decode($res);
        var_dump($response);
        die();

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
                        'member_temp_code' => $row->member_temp_code,
                        'member_name' => $row->member_name,
                        'member_identity_number' => $row->member_identity_number,
                        'member_identity_type' => IDENTITY_TYPE[$row->member_identity_type],
                        'member_gender' => GENDER[$row->member_gender],
                        'member_birthdate' => convert_date($row->member_birthdate, 'id'),
                        'member_status' => MEMBER_STATUS[$row->member_status],
                        'member_join_datetime' => convert_datetime($row->member_join_datetime),
                        'member_input_admin_name' => $row->member_input_admin_name,
                        'member_input_datetime' => convert_datetime($row->member_input_datetime, 'id'),
                        'member_diksar_date' => convert_date($row->member_diksar_date, 'id'),
                        'member_nationality' => NATIONALITY[$row->member_nationality],
                        'member_entrance_fee_paid_off' => ENTRANCE_FEE_PAID_OFF[$row->member_entrance_fee_paid_off],
                        'branch_name' => $row->branch_name,
                        'detail' => $detail,
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }

    function get_template_diksar()
    {
        $this->load->helper('download');
        force_download(_dir_download . 'template_format_upload_anggota_diksar.xls', NULL);
    }

    public function act_update_one()
    {
        $member_diksar_date = validate_date($_POST['date'], 'd/m/Y') ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : NULL;
        if ($member_diksar_date != NULL) {
            $_POST['date'] = $member_diksar_date;
            $res = $this->curl->put(URL_API . 'membership/diksar/act_update_one', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal proses data! Format tanggal salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }

    public function act_update_many()
    {
        $res = $this->curl->put(URL_API . 'membership/diksar/act_update_many', $this->input->post());
        echo $res;
    }

    public function act_upload()
    {
        $this->load->library('upload');
        if (isset($_FILES['excel']['size']) && $_FILES['excel']['size'] > 0) {

            if ($this->upload->fileUpload('excel', _dir_import, 'xls|xlsx')) {
                $upload = $this->upload->data();
                $filename = url_title($upload['raw_name']) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $filename);

                //php excel start here
                $this->load->library('Excel');
                $inputFileType = PHPExcel_IOFactory::identify($upload['file_path'] . $filename);
                if ($inputFileType != 'CSV') {
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objReader->setReadDataOnly(true);

                    $objPHPExcel = $objReader->load($upload['file_path'] . $filename);
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                    $arr_member_diksar = array();

                    for ($cell_row = 4; $cell_row <= $highestRow; ++$cell_row) {
                        try {
                            $member_code = $objWorksheet->getCellByColumnAndRow(0, $cell_row)->getValue();
                            $member_name = $objWorksheet->getCellByColumnAndRow(1, $cell_row)->getValue();
                            $member_diksar_date = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(2, $cell_row)->getValue()));
                            $status = 0; // tidak valid
                            if (!empty($member_code) && !empty($member_name) && !empty($member_diksar_date)) {
                                if (validate_date($member_diksar_date, 'Y-m-d')) {
                                    $status = 1; // valid
                                }
                                array_push($arr_member_diksar, array(
                                    'code' => $member_code,
                                    'name' => $member_name,
                                    'date' => $member_diksar_date,
                                    'status' => $status
                                ));
                            }
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }

                    if ($filename != '' && file_exists(_dir_import . $filename)) {
                        @unlink(_dir_import . $filename);
                    }

                    $arr_data = array(
                        'status' => 200,
                        'data' => json_encode($arr_member_diksar)
                    );
                } else {
                    $arr_data = array(
                        'status' => 400,
                        'msg' => 'Gagal upload file, tipe file tidak sesuai.'
                    );
                }
            } else {
                $arr_data = array(
                    'status' => 400,
                    'msg' => 'Gagal upload file, tipe file tidak sesuai.'
                );
            }
        } else {
            $arr_data = array(
                'status' => 400,
                'msg' => 'Gagal upload file, file tidak ditemukan'
            );
        }
        header("Content-type: application/json");
        echo json_encode($arr_data);
    }

    public function export_data_not_yet_diksar()
    {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'membership/diksar/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "diksar" => 0
        ));
        $response = json_decode($res);

        $arr_identity_type = array('KTP', 'SIM', 'KK', 'KIA/KTM', 'Passport', 'Lainnya');
        $arr_gender = array('Pria', 'Wanita');
        $arr_status = array('Anggota Koperasi', 'ALB Anak', 'ALB WNA', 'ALB Luar Negeri', 'ALB Khusus', 'Calon Anggota');;
        $arr_nationality = array('WNI', 'WNA');
        $arr_entrance_fee_paid_off = array('Belum Lunas', 'Lunas');

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;

            foreach ($results as $key => $value) {
                $results[$key]->member_identity_type = $arr_identity_type[$results[$key]->member_identity_type];
                $results[$key]->member_gender = $arr_gender[$results[$key]->member_gender];
                $results[$key]->member_status = $arr_status[$results[$key]->member_status];
                $results[$key]->member_nationality = $arr_nationality[$results[$key]->member_nationality];
                $results[$key]->member_entrance_fee_paid_off = $arr_entrance_fee_paid_off[$results[$key]->member_entrance_fee_paid_off];
            }

            $data = array();
            $data['title'] = 'Data Anggota Belum Diksar';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

    public function export_data_already_diksar()
    {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $total_data_grid = $this->input->post('total_data');

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'branch_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'membership/diksar/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
            "diksar" => 1
        ));
        $response = json_decode($res);

        $arr_identity_type = array('KTP', 'SIM', 'KK', 'KIA/KTM', 'Passport', 'Lainnya');
        $arr_gender = array('Pria', 'Wanita');
        $arr_status = array('Anggota Koperasi', 'ALB Anak', 'ALB WNA', 'ALB Luar Negeri', 'ALB Khusus', 'Calon Anggota');
        $arr_nationality = array('WNI', 'WNA');
        $arr_entrance_fee_paid_off = array('Belum Lunas', 'Lunas');

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;

            foreach ($results as $key => $value) {
                $results[$key]->member_identity_type = $arr_identity_type[$results[$key]->member_identity_type];
                $results[$key]->member_gender = $arr_gender[$results[$key]->member_gender];
                $results[$key]->member_status = $arr_status[$results[$key]->member_status];
                $results[$key]->member_nationality = $arr_nationality[$results[$key]->member_nationality];
                $results[$key]->member_entrance_fee_paid_off = $arr_entrance_fee_paid_off[$results[$key]->member_entrance_fee_paid_off];
            }

            $data = array();
            $data['title'] = 'Data Anggota Sudah Diksar';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }
}
