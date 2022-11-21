<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function migration() {
        $this->template->content("tools/migration_view");
        $this->template->show('template');
    }

    public function act_migration() {
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

                    $arr_member = array();
                    
                    for ($cell_row = 4; $cell_row <= $highestRow; ++$cell_row) {
                        try {
                            $member_id = $objWorksheet->getCellByColumnAndRow(0, $cell_row)->getValue();
                            $member_name = $objWorksheet->getCellByColumnAndRow(1, $cell_row)->getValue();
                            $member_gender = $objWorksheet->getCellByColumnAndRow(2, $cell_row)->getValue();
                            $member_branch = $objWorksheet->getCellByColumnAndRow(3, $cell_row)->getValue();
                            $member_is_married = $objWorksheet->getCellByColumnAndRow(4, $cell_row)->getValue();
                            $member_religion = $objWorksheet->getCellByColumnAndRow(5, $cell_row)->getValue();
                            $member_birthdate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(6, $cell_row)->getValue()));
                            $member_birthplace = $objWorksheet->getCellByColumnAndRow(7, $cell_row)->getValue();
                            $member_last_education = $objWorksheet->getCellByColumnAndRow(8, $cell_row)->getValue();
                            $member_join_datetime = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(9, $cell_row)->getValue())) . " " . date("H:i:s");
                            $member_mobilephone_number = $objWorksheet->getCellByColumnAndRow(10, $cell_row)->getValue();
                            $member_identity_number = $objWorksheet->getCellByColumnAndRow(11, $cell_row)->getValue();
                            $member_job = $objWorksheet->getCellByColumnAndRow(12, $cell_row)->getValue();
                            $member_address_domicile = $objWorksheet->getCellByColumnAndRow(13, $cell_row)->getValue();
                            $member_kelurahan = $objWorksheet->getCellByColumnAndRow(14, $cell_row)->getValue();
                            $member_subdistrict = $objWorksheet->getCellByColumnAndRow(15, $cell_row)->getValue();
                            $member_city = $objWorksheet->getCellByColumnAndRow(16, $cell_row)->getValue();
                            $member_province = $objWorksheet->getCellByColumnAndRow(17, $cell_row)->getValue();
                            $member_heir_name = $objWorksheet->getCellByColumnAndRow(18, $cell_row)->getValue();
                            $member_mother_name = $objWorksheet->getCellByColumnAndRow(19, $cell_row)->getValue();

                            $arr_gender = array('L' => 0, 'P' => 1);
                            $arr_is_married = array('Belum Menikah' => 0, 'Menikah' => 1);
                            $arr_religion = array('ISLAM' => 0, 'KRISTEN' => 1, 'KATOLIK' => 2, 'HINDU' => 3, 'BUDHA' => 4, 'KONG HU CU' => 5, 'ALIRAN KEPERCAYAAN' => 6, 'LAINNYA' => 7);

                            $last_education = 0;
                            if (!empty($member_last_education)) {
                                if (strpos($member_last_education, "S1") !== false) {
                                    $last_education = 5;
                                }else if(strpos($member_last_education, "S2") !== false){
                                    $last_education = 6;
                                }else if(strpos($member_last_education, "S3") !== false){
                                    $last_education = 7;
                                }else if(strpos($member_last_education, "D1") !== false || strpos($member_last_education, "D2") !== false || strpos($member_last_education, "D3") !== false){
                                    $last_education = 4;
                                }else if(strpos($member_last_education, "SLTA") !== false){
                                    $last_education = 3;
                                }else if(strpos($member_last_education, "SLTP") !== false){
                                    $last_education = 2;
                                }else if(strpos($member_last_education, "SD") !== false){
                                    $last_education = 1;
                                }
                            }
                            
                            $city = $member_city;
                            if(!empty($city)){
                                if(strpos($member_city, "Kota") === false){
                                    $city = "Kabupaten " . $member_city;
                                }
                            }
                            
                            $heir_status = "";
                            if(!empty($member_heir_name)){
                                if(strpos($member_heir_name, "(an") !== false){
                                    $heir_status = "Anak";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(an"));
                                }else if(strpos($member_heir_name, "(ib") !== false){
                                    $heir_status = "Ibu";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(ib"));
                                }else if(strpos($member_heir_name, "(ay") !== false){
                                    $heir_status = "Ayah";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(ay"));
                                }else if(strpos($member_heir_name, "(is") !== false){
                                    $heir_status = "Istri";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(is"));
                                }else if(strpos($member_heir_name, "(ka") !== false){
                                    $heir_status = "Kakak";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(ka"));
                                }else if(strpos($member_heir_name, "(ad") !== false){
                                    $heir_status = "Adik";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(ad"));
                                }else if(strpos($member_heir_name, "(su") !== false){
                                    $heir_status = "Suami";
                                    $member_heir_name = substr($member_heir_name, 0, strpos($member_heir_name, "(su"));
                                }
                            }

                            array_push($arr_member, array(
                                'member_code' => str_pad($member_id, 5, "0", STR_PAD_LEFT),
                                'member_name' => $member_name != NULL ? $member_name : '',
                                'member_gender' => $member_gender != NULL ? $arr_gender[$member_gender] : '',
                                'member_branch_id' => $member_branch != NULL ? $member_branch : '',
                                'member_is_married' => $member_is_married != NULL ? $arr_is_married[$member_is_married] : '',
                                'member_religion' => $member_religion != NULL ? $arr_religion[$member_religion] : '',
                                'member_birthdate' => $member_birthdate != NULL ? $member_birthdate : NULL,
                                'member_birthplace' => $member_birthplace != NULL ? $member_birthplace : '',
                                'member_last_education' => $last_education,
                                'member_join_datetime' => $member_join_datetime != NULL ? $member_join_datetime : NULL,
                                'member_registered_date' => $member_join_datetime != NULL ? $member_join_datetime : NULL,
                                'member_mobilephone_number' => $member_mobilephone_number != NULL ? $member_mobilephone_number : '',
                                'member_identity_number' => $member_identity_number != NULL ? $member_identity_number : '',
                                'member_job' => $member_job != NULL ? $member_job : '',
                                'member_address' => $member_address_domicile != NULL ? $member_address_domicile : '',
                                'member_address_domicile' => $member_address_domicile != NULL ? $member_address_domicile : '',
                                'member_kelurahan' => $member_kelurahan != NULL ? strtoupper($member_kelurahan) : '',
                                'member_subdistrict' => $member_subdistrict != NULL ? strtoupper($member_subdistrict) : '',
                                'member_city' => $city != NULL ? strtoupper($city) : '',
                                'member_province' => $member_province != NULL ? strtoupper($member_province) : '',
                                'member_heir_name' => $member_heir_name != NULL ? $member_heir_name : '',
                                'member_heir_status' => $heir_status,
                                'member_mother_name' => $member_mother_name != NULL ? $member_mother_name : '',
                            ));
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }

                    if ($filename != '' && file_exists(_dir_import . $filename)) {
                        @unlink(_dir_import . $filename);
                    }

                    $res = $this->curl->post(URL_API . 'tools/migration', array(
                        'json_data' => json_encode($arr_member)
                    ));
                    $arr_data = $res;
                } else {
                    $arr_data = array(
                        'status' => 400,
                        'message' => 'Gagal upload file, tipe file tidak sesuai.'
                    );
                }
            } else {
                $arr_data = array(
                    'status' => 400,
                    'message' => 'Gagal upload file, tipe file tidak sesuai.'
                );
            }
        } else {
            $arr_data = array(
                'status' => 400,
                'message' => 'Gagal upload file, file tidak ditemukan'
            );
        }
        header("Content-type: application/json");
        echo json_encode($arr_data);
    }
    
    public function inject_saldo() {
        $this->template->content("tools/inject_saldo_view");
        $this->template->show('template');
    }
    
    public function act_inject_saldo() {
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

                    $arr_saldo = array();
                    
                    for ($cell_row = 3; $cell_row <= $highestRow; ++$cell_row) {
                        try {
                            $member_id = $objWorksheet->getCellByColumnAndRow(0, $cell_row)->getValue();
                            $member_sp = $objWorksheet->getCellByColumnAndRow(2, $cell_row)->getValue();
                            $member_sw = $objWorksheet->getCellByColumnAndRow(3, $cell_row)->getValue();
                            
                            $period = 0;
                            if($member_sw > 0){
                                $period = (int) $member_sw / 5000;
                            }

                            array_push($arr_saldo, array(
                                'member_code' => str_pad($member_id, 5, "0", STR_PAD_LEFT),
                                'nominal' => !empty($member_sp) ? (int) $member_sp : 0,
                                'period' => $period,
                            ));
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }

                    if ($filename != '' && file_exists(_dir_import . $filename)) {
                        @unlink(_dir_import . $filename);
                    }
                    
                    $res = $this->curl->post(URL_API . 'tools/entrance_fee', array(
                        'json_data' => json_encode($arr_saldo)
                    ));
                    $arr_data = $res;
                } else {
                    $arr_data = array(
                        'status' => 400,
                        'message' => 'Gagal upload file, tipe file tidak sesuai.'
                    );
                }
            } else {
                $arr_data = array(
                    'status' => 400,
                    'message' => 'Gagal upload file, tipe file tidak sesuai.'
                );
            }
        } else {
            $arr_data = array(
                'status' => 400,
                'message' => 'Gagal upload file, file tidak ditemukan'
            );
        }
        header("Content-type: application/json");
        echo json_encode($arr_data);
    }
    
    public function inject_saldo_saving() {
        $this->template->content("tools/inject_saldo_saving_view");
        $this->template->show('template');
    }
    
    public function act_inject_saldo_saving() {
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

                    $arr_saldo = array();
                    
                    for ($cell_row = 5; $cell_row <= $highestRow - 1; ++$cell_row) {
                        try {
                            $member_account_number = $objWorksheet->getCellByColumnAndRow(0, $cell_row)->getValue();
                            $member_name = $objWorksheet->getCellByColumnAndRow(1, $cell_row)->getValue();
                            $member_saldo = $objWorksheet->getCellByColumnAndRow(7, $cell_row)->getValue();
                            
                            array_push($arr_saldo, array(
                                'member_name' => addslashes($member_name),
                                'saldo' => $member_saldo,
                            ));
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }

                    if ($filename != '' && file_exists(_dir_import . $filename)) {
                        @unlink(_dir_import . $filename);
                    }
                    
                    $res = $this->curl->post(URL_API . 'tools/inject_sipari', array(
                        'json_data' => json_encode($arr_saldo)
                    ));
                    $arr_data = $res;
                } else {
                    $arr_data = array(
                        'status' => 400,
                        'message' => 'Gagal upload file, tipe file tidak sesuai.'
                    );
                }
            } else {
                $arr_data = array(
                    'status' => 400,
                    'message' => 'Gagal upload file, tipe file tidak sesuai.'
                );
            }
        } else {
            $arr_data = array(
                'status' => 400,
                'message' => 'Gagal upload file, file tidak ditemukan'
            );
        }
        header("Content-type: application/json");
        echo json_encode($arr_data);
    }

}
