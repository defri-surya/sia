<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Function_lib {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function set_number_format($number, $is_int = true) {
        if (is_numeric($number) && floor($number) != $number && $is_int == false) {
            return number_format($number, 2, ',', '.');
        } else {
            return number_format($number, 0, ',', '.');
        }
    }

    function generate_number($length) {
        $pin_str = "1234567809";
        for ($i = 0; $i < strlen($pin_str); $i++) {
            $pin_chars[$i] = $pin_str[$i];
        }
        // randomize the chars
        srand((float) microtime() * 1000000);
        shuffle($pin_chars);
        $pin = "";
        for ($i = 0; $i < 20; $i++) {
            $char_num = rand(1, count($pin_chars));
            $pin .= $pin_chars[$char_num - 1];
        }
        $pin = substr($pin, 0, $length);

        return $pin;
    }

    function generate_alpha_number($length) {
        $charset = 'ABCDEFGHKLMNPRSTUVWYZ23456789';
        $code = '';

        for ($i = 1, $cslen = strlen($charset); $i <= $length; ++$i) {
            $code .= $charset{rand(0, $cslen - 1)};
        }
        return $code;
    }

    function multidimensional_array_sort(&$array, $key, $sort = 'asc') {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }

        if ($sort == 'desc') {
            arsort($sorter);
        } else {
            asort($sorter);
        }

        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }

        return $ret;
    }

    function get_identity_type_options() {
        $options = array();
        $options[null] = 'Jenis Identitas';
        $options['ktp'] = 'KTP';
        $options['sim'] = 'SIM';
        $options['paspor'] = 'Paspor';

        return $options;
    }

    function get_sex_options() {
        $options = array();
        $options['male'] = 'Pria';
        $options['female'] = 'Wanita';

        return $options;
    }

    
    public function get_array_filter($querys_grid) {
        $arr_filter = array();
        
        if (isset($querys_grid) && $querys_grid != false && $querys_grid != '') {
            $querys = json_decode($querys_grid);
            foreach ($querys as $query) {
                if ($query->filter_type == 'querys_text') {
                    $comparison = substr($query->filter_value, 0, 1);
                    $value = substr($query->filter_value, 1, strlen($query->filter_value));
                    $arr_allowed = array('=', '<', '>');
                    if (!in_array($comparison, $arr_allowed)) {
                        $comparison = '<>';
                        $value = $query->filter_value;
                    }
                    array_push($arr_filter, array(
                        "type" => "string",
                        "field" => $query->filter_field,
                        "value" => $value,
                        "comparison" => $comparison
                    ));
                } else if ($query->filter_type == 'querys_num_start') {
                    array_push($arr_filter, array(
                        "type" => "numeric",
                        "field" => $query->filter_field,
                        "value" => $query->filter_value,
                        "comparison" => ">="
                    ));
                } else if ($query->filter_type == 'querys_num_end') {
                    array_push($arr_filter, array(
                        "type" => "numeric",
                        "field" => $query->filter_field,
                        "value" => $query->filter_value,
                        "comparison" => "<="
                    ));
                } else if ($query->filter_type == 'querys_option') {
                    array_push($arr_filter, array(
                        "type" => "list",
                        "field" => $query->filter_field,
                        "value" => $query->filter_value,
                        "comparison" => "="
                    ));
                } else if ($query->filter_type == 'querys_date') {
                    $dates = explode('s/d', $query->filter_value);
                    $start_date = trim($dates[0]);
                    $end_date = trim($dates[1]);
                    array_push($arr_filter, array(
                        "type" => "date",
                        "field" => $query->filter_field,
                        "value" => $start_date . "::" .$end_date,
                        "comparison" => "bet"
                    ));
                }
            }
        }
        return $arr_filter;
    }

    function where_filter() {
        $filters = $this->CI->input->post('filters');
        $search = $this->CI->input->post('_search');

        $where = "WHERE 0 = 0 ";

        if (($search == true) && ($filters != "")) {


            $filters = json_decode($filters);
            $whereArray = array();
            $rules = $filters->rules;
            $groupOperation = $filters->groupOp;
            $fieldOperationCompare = '';
            foreach ($rules as $rule) {

                $fieldName = $rule->field;
                $fieldData = $rule->data;
                switch ($rule->op) {
                    case "eq":
                        $fieldOperation = " = '" . $fieldData . "'";
                        break;
                    case "ne":
                        $fieldOperation = " != '" . $fieldData . "'";
                        break;
                    case "lt":
                        $fieldOperation = " < '" . $fieldData . "'";
                        break;
                    case "gt":
                        $fieldOperation = " > '" . $fieldData . "'";
                        break;
                    case "le":
                        $fieldOperation = " <= '" . $fieldData . "'";
                        break;
                    case "ge":
                        $fieldOperation = " >= '" . $fieldData . "'";
                        break;
                    case "nu":
                        $fieldOperation = " = ''";
                        break;
                    case "nn":
                        $fieldOperation = " != ''";
                        break;
                    case "in":
                        $fieldOperation = " IN (" . $fieldData . ")";
                        break;
                    case "ni":
                        $fieldOperation = " NOT IN '" . $fieldData . "'";
                        break;
                    case "bw":
                        $fieldOperation = " LIKE '" . $fieldData . "%'";
                        break;
                    case "bn":
                        $fieldOperation = " NOT LIKE '" . $fieldData . "%'";
                        break;
                    case "ew":
                        $fieldOperation = " LIKE '%" . $fieldData . "'";
                        break;
                    case "en":
                        $fieldOperation = " NOT LIKE '%" . $fieldData . "'";
                        break;
                    case "cn":
                        $fieldOperation = " LIKE '%" . $fieldData . "%'";
                        break;
                    case "nc":
                        $fieldOperation = " NOT LIKE '%" . $fieldData . "%'";
                        break;
                    default:
                        $fieldOperation = "";
                        break;
                }
                if ($fieldOperation != "")
                    $whereArray[] = $fieldName . $fieldOperation;
            }
            if (count($whereArray) > 0) {
                $where .= " AND ".join(" " . $groupOperation . " ", $whereArray);
            }
        }

        return $where;
    }
    
     function export_excel_standard($data = false) {
        if($data) {
            //$this->output->enable_profiler(TRUE);
            ini_set('memory_limit', -1);
            set_time_limit(0);
            $this->CI->load->library('Excel');
            
            // Initiate cache
            $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            $cacheSettings = array('memoryCacheSize' => '32MB');
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            
            $arr_style_title = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EEEEEE')
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );
            
            $arr_style_content = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
                ),
            );
            
            extract($data);
            $filename = url_title($title) . '-' . date("YmdHis");
            $arr_column_name = json_decode($column['name']);
            $arr_column_show = json_decode($column['show']);
            $arr_column_align = json_decode($column['align']);
            $arr_column_title = json_decode($column['title']);
            $arr_column_max_width = array();
        
            //menyisipkan sort number
            array_unshift($arr_column_name, "sort");
            array_unshift($arr_column_show, true);
            array_unshift($arr_column_align, "center");
            array_unshift($arr_column_title, "No");

            $first_column = $cell_column = 'A';
            $cell_row = $first_row = 1;
            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);

            //title
            $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(13);
            $excel->getActiveSheet()->setCellValue($cell_column . $cell_row, strtoupper($title));
            $cell_row++;
            $excel->getActiveSheet()->setCellValue($cell_column . $cell_row, 'Tanggal Export : ' . convert_datetime(date("Y-m-d H:i:s"), 'id'));
            $cell_row++;
            $cell_row++;
        
            //cari jumlah kolom
            $total_column = 0;
            $last_column = $first_column;
            foreach($arr_column_show as $id => $is_show) {
                if($is_show == true) {
                    $total_column++;
                    if($total_column > 1) {
                        $last_column++;
                    }
                }
            }

            if(is_array($arr_column_title)) {
                $cell_column = $first_column;
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row . ':' . $last_column . $cell_row)->applyFromArray($arr_style_title);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row . ':' . $last_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row . ':' . $last_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                foreach($arr_column_title as $id => $value) {
                    if($arr_column_show[$id] == true) {
                        $arr_column_max_width[$id] = ceil(1.5 * strlen($value) + 0.6);
                        $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth($arr_column_max_width[$id]);
                        $excel->getActiveSheet()->setCellValue($cell_column . $cell_row, strtoupper($value));
                        $cell_column++;
                    }
                }
                $cell_row++;
            }
            $first_content_row = $cell_row;

            if(count($results) > 0) {
                $sort = 1;
                foreach ($results as $row) {
                    $row->sort = $sort;
                    $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(17);
                    
                    $cell_column = $first_column;
                    foreach($arr_column_name as $id => $value) {
                        if($arr_column_show[$id] == true) {
                            if(!isset($row->$value)) {
                                $data = '';
                            } else {
                                $data = $row->$value;
                            }
                                    
                            $column_width = ceil(strlen(trim($data)));
                            if($column_width > $arr_column_max_width[$id]) {
                                $arr_column_max_width[$id] = $column_width;
                            }
                                    
                            if(is_nominal($data)) {
                                $excel->getActiveSheet()->setCellValueExplicit($cell_column . $cell_row, $data, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode("#,##0");
                            } else {
                                $excel->getActiveSheet()->setCellValueExplicit($cell_column . $cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                            $cell_column++;
                        }
                    }
                    $cell_row++;
                    $sort++;
                }
            }
            $last_content_row = $cell_row;
            $last_content_row--;
        
            $cell_column = $first_column;
            foreach($arr_column_title as $id => $value) {
                if($arr_column_show[$id] == true) {
                    $excel->getActiveSheet()->getStyle($cell_column . $first_content_row . ':' . $cell_column . $last_content_row)->getAlignment()->setHorizontal($arr_column_align[$id]);
                    $excel->getActiveSheet()->getStyle($cell_column . $first_content_row . ':' . $cell_column . $last_content_row)->applyFromArray($arr_style_content);
                    $column_width = ($arr_column_max_width[$id] > 50) ? 50 : $arr_column_max_width[$id]; //max_width = 50
                    $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth($column_width);

                    $cell_column++;
                }
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }


    function export_excel_standard_old($data = false) {
        if ($data) {
            $this->CI->load->library('Excel');

            // Initiate cache
            $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            $cacheSettings = array('memoryCacheSize' => '32MB');
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

            $arr_style_title = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EEEEEE')
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );

            $arr_style_content = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );

            extract($data);
            $filename = url_title($title) . '-' . date("YmdHis");
            $arr_column_name = json_decode($column['name']);
            $arr_column_align = json_decode($column['align']);
            $arr_column_title = json_decode($column['title']);

            $first_column = $cell_column = 'A';
            $cell_row = $first_row = 1;
            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);

            //title
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(13);
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($title));
            $cell_row++;
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, 'Export Date : ' . convert_datetime(date("Y-m-d H:i:s"), 'en'));
            $cell_row++;
            $cell_row++;

            if (is_array($arr_column_title)) {
                $cell_column = $first_column;
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                foreach ($arr_column_title as $id => $value) {
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                    $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth(ceil(1.5 * strlen($value) + 0.6));

                    $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($value));
                    $cell_column++;
                }
                $cell_row++;
            }

            if ($query->num_rows() > 0) {
                $row_data = '';
                foreach ($query->result() as $row) {
                    $cell_column = $first_column;
                    $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(17);
                    foreach ($arr_column_name as $id => $value) {
                        if (!isset($row->$value)) {
                            $row_data = '';
                        } else {
                            if (isset($field_custom) && isset($field_custom[$value])) {
                                foreach($field_custom as $index => $row_custom) {
                                    if ($row_custom == $value) {
                                        if (isset($field_value[$index][$row->$value])) {
                                            $row_data = $field_value[$index][$row->$value];
                                        }
                                    }
                                }
                            } else {
                                $row_data = $row->$value;
                            }
                        }
//                        echo '<pre>';
//                        print_r($data);
//                        echo '</pre>';
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal($arr_column_align[$id]);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                        $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row_data, PHPExcel_Cell_DataType::TYPE_STRING);
                        $cell_column++;
                    }
                    $cell_row++;
                }
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }

    function get_week_date_range($date, $weekly_start_day = 0) {
        $arr_days = array(
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday'
        );
        $str_date = strtotime($date);
        $str_start_date = (date('w', $str_date) == $weekly_start_day) ? $str_date : strtotime('last ' . $arr_days[$weekly_start_day], $str_date);
        $start_date = date("Y-m-d", $str_start_date);
        $end_date = date("Y-m-d", mktime(0, 0, 0, date("n", strtotime($start_date)), date("j", strtotime($start_date)) + 6, date("Y", strtotime($start_date))));

        return array($start_date, $end_date);
    }

    /*
     * =============================API ZenSiva=================================
     */

    public function send_sms($message, $telepon, $network_id = '', $type = 'single') {

        $telepon = preg_replace("/^0/", "62", trim($telepon));
        $userkey = ""; // userkey lihat di zenziva
        $passkey = ""; // set passkey di zenziva
        $url = "https://reguler.zenziva.net/apps/smsapi.php";


        $curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, $url);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey=' . $userkey . '&passkey=' . $passkey . '&nohp=' . $telepon . '&pesan=' . urlencode($message));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);

        curl_setopt($curlHandle, CURLOPT_POST, 1);

        $response = curl_exec($curlHandle);
        $xml_string = <<<XML
$response
XML;

        curl_close($curlHandle);

        $sXML = simplexml_load_string($xml_string);
        if (!empty($sXML)) {
            if ($sXML->message[0]->text == 'Success') {
                $this->insert_sms($message, $telepon, $network_id, $type);
                return TRUE;
            } else
                return FALSE;
        } else
            return FALSE;
    }

    

    function sendTelegramMessage($messaggio) {
       $token = "";
       $chatIDDef = ""; //

       $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatIDDef;
       $url = $url . "&text=" . urlencode($messaggio);
       $ch = curl_init();
       $optArray = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true
       );
       curl_setopt_array($ch, $optArray);
       $result = curl_exec($ch);
       curl_close($ch);
   }

}
