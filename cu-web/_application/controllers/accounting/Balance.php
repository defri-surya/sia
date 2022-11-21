<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Balance extends Backend_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->first_column = $this->cell_column = 'A';
        $this->cell_row = $this->first_row = 1;
        
        $this->arr_column_title = ['No. Rekening','Nama Akun','Saldo'];
        $this->arr_column_align = ['left','left','right'];
        
        $this->arr_column_name = ['title','coaName','balance'];
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("accounting/balance_view", $data);
        $this->template->show('template');
    }

    public function get_data() {
        
        $month = $this->input->get('month');

        $res = $this->curl->get(URL_API . 'accounting/neraca/get_data', array(
            "month" => date('Y-m', strtotime($month)) . '-01',
        ));
        $response = json_decode($res);

        $json_aktiva = array();
        $json_pasiva = array();
        $total_aktiva = 0;
        $total_pasiva = 0;

        if ($response->status == 200) {
            $results_aktiva = $response->data->results->aktiva;
            $results_pasiva = $response->data->results->pasiva;

            $total_aktiva = $response->data->results->total_aktiva;
            $total_pasiva = $response->data->results->total_pasiva;

            foreach ($results_aktiva as $row) {
                $data_row = array(
                    "key" => $row->id,
                    "parentId" => $row->parent_id,
                    "coaName" => $row->title,
                    "title" => $row->number,
                    "isPositive" => $row->is_positive,
                    "tag" => $row->tag,
                    "folder" => false,
                    "expanded" => true,
                    "balance" => $row->balance,
                );

                array_push($json_aktiva, $data_row);
            }
            
            foreach ($results_pasiva as $row) {
                $data_row = array(
                    "key" => $row->id,
                    "parentId" => $row->parent_id,
                    "coaName" => $row->title,
                    "title" => $row->number,
                    "isPositive" => $row->is_positive,
                    "tag" => $row->tag,
                    "folder" => false,
                    "expanded" => true,
                    "balance" => $row->balance,
                );

                array_push($json_pasiva, $data_row);
            }
        }
        
        $response = array(
            'status' => 200,
            'msg' => 'success',
            'data' => array(
                'aktiva' => count($json_aktiva) > 0 ? $this->array_nested_builder($json_aktiva) : $json_aktiva,
                'pasiva' => count($json_pasiva) > 0 ? $this->array_nested_builder($json_pasiva) : $json_pasiva,
                'total_aktiva' => $total_aktiva,
                'total_pasiva' => $total_pasiva,
            )
        );
        
        echo json_encode($response);
    }

    public function array_nested_builder(array $flat, $idField = 'key', $parentIdField = 'parentId', $childNodesField = 'children') {

        $indexed = array();

        foreach ($flat as $row) {
            if ($row[$idField] > 0) {
                $indexed[$row[$idField]] = $row;
                $indexed[$row[$idField]][$childNodesField] = array();
            }
        }

        $root = null;
        foreach ($indexed as $id => $row) {
            $indexed[$row[$parentIdField]][$childNodesField][$id] = & $indexed[$id];
            array_multisort($indexed[$row[$parentIdField]][$childNodesField], SORT_ASC);

            if (sizeof($indexed[$row[$parentIdField]][$childNodesField]) > 0) {
                $indexed[$row[$parentIdField]]['folder'] = true;
            }

            if (!$row[$parentIdField]) {
                $root = $id;
            }
        }

        return $indexed[0][$childNodesField];
    }
    
    public function export_data() {
        $month = $this->input->post('month');

        $res = $this->curl->get(URL_API . 'accounting/neraca/get_data', array(
            "month" => date('Y-m', strtotime($month)) . '-01',
        ));
        $response = json_decode($res);
        
        $json_aktiva = array();
        $json_pasiva = array();
        $total_aktiva = 0;
        $total_pasiva = 0;

        if ($response->status == 200) {
            $results_aktiva = $response->data->results->aktiva;
            $results_pasiva = $response->data->results->pasiva;

            $total_aktiva = $response->data->results->total_aktiva;
            $total_pasiva = $response->data->results->total_pasiva;

            foreach ($results_aktiva as $row) {
                $data_row = array(
                    "key" => $row->id,
                    "parentId" => $row->parent_id,
                    "coaName" => $row->title,
                    "title" => $row->number,
                    "isPositive" => $row->is_positive,
                    "tag" => $row->tag,
                    "folder" => false,
                    "expanded" => true,
                    "balance" => $row->balance,
                );

                array_push($json_aktiva, $data_row);
            }
            
            foreach ($results_pasiva as $row) {
                $data_row = array(
                    "key" => $row->id,
                    "parentId" => $row->parent_id,
                    "coaName" => $row->title,
                    "title" => $row->number,
                    "isPositive" => $row->is_positive,
                    "tag" => $row->tag,
                    "folder" => false,
                    "expanded" => true,
                    "balance" => $row->balance,
                );

                array_push($json_pasiva, $data_row);
            }
            
            $data = array(
                'aktiva' => count($json_aktiva) > 0 ? $this->array_nested_builder($json_aktiva) : $json_aktiva,
                'pasiva' => count($json_pasiva) > 0 ? $this->array_nested_builder($json_pasiva) : $json_pasiva,
                'total_aktiva' => $total_aktiva,
                'total_pasiva' => $total_pasiva,
            );
            
            $this->export_excel($data, $month);
        }else {
            echo '<script>alert("Gagal export data!\n' . $response->msg . '"); window.close();</script>';
        }
    }
    
    function export_excel($data_excel = false, $month) {
        if ($data_excel) {
            ini_set('memory_limit', -1);
            set_time_limit(0);
            $this->load->library('Excel');

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

            $title = 'LAPORAN NERACA PERIODE ' . convert_month(date('m', strtotime($month)), 'id') . ' ' . date('Y', strtotime($month));
            $filename = url_title($title) . '-' . date("YmdHis");

            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);

            //title
            $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(20);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getFont()->setSize(13);
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($title));
            $this->cell_row++;
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, 'Tanggal Export : ' . convert_datetime(date("Y-m-d H:i:s"), 'id'));
            $this->cell_row++;
            $this->cell_row++;

            $this->cell_column = $this->first_column;
            $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper('SELISIH:'));
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->cell_column++;
            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, abs ($data_excel['total_aktiva'] - $data_excel['total_pasiva']), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':G' . $this->cell_row);
            $this->cell_row++;
            
            $this->cell_column = $this->first_column;
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($title));
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':G' . $this->cell_row);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':G' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->cell_row++;
            
            $excel->getActiveSheet()->getStyle('A4:G5')->applyFromArray($arr_style_title);
            
            $this->cell_column = $this->first_column;
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper('AKTIVA'));
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':C' . $this->cell_row);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $excel->getActiveSheet()->setCellValue('E' . $this->cell_row, strtoupper('PASIVA'));
            $excel->getActiveSheet()->mergeCells('E' . $this->cell_row . ':G' . $this->cell_row);
            $excel->getActiveSheet()->getStyle('E' . $this->cell_row . ':G' . $this->cell_row)->applyFromArray($arr_style_title);
            $excel->getActiveSheet()->getStyle('E' . $this->cell_row . ':G' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->cell_row++;
            
            $this->cell_column = $this->first_column;
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper('SALDO:'));
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':B' . $this->cell_row);
            $excel->getActiveSheet()->setCellValueExplicit('C' . $this->cell_row, $data_excel['total_aktiva'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $excel->getActiveSheet()->getStyle('C' . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
            
            $excel->getActiveSheet()->setCellValue('E' . $this->cell_row, strtoupper('SALDO:'));
            $excel->getActiveSheet()->mergeCells('E' . $this->cell_row . ':F' . $this->cell_row);
            $excel->getActiveSheet()->getStyle('E' . $this->cell_row . ':F' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->setCellValueExplicit('G' . $this->cell_row, $data_excel['total_pasiva'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $excel->getActiveSheet()->getStyle('G' . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
            $excel->getActiveSheet()->getStyle('G' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->getStyle('E' . $this->cell_row . ':G' . $this->cell_row)->applyFromArray($arr_style_title);
            
            $excel->getActiveSheet()->getStyle('A4:G8')->getFont()->setBold(true)->setSize(11);
            
            $this->cell_row++;
            
            if (is_array($this->arr_column_title)) {
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                foreach ($this->arr_column_title as $id => $value) {
                    $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($value));
                    $this->cell_column++;
                }
                
                $this->cell_column = 'E';
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':G' . $this->cell_row)->applyFromArray($arr_style_title);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':G' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':G' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                foreach ($this->arr_column_title as $id => $value) {
                    $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($value));
                    $this->cell_column++;
                }
                $this->cell_row++;
            }
                
            $first_content_row = $this->cell_row;

            if (count($data_excel['aktiva']) > 0) {
                foreach ($data_excel['aktiva'] as $row) {

                    $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);

                    $this->cell_column = $this->first_column;
                    foreach ($this->arr_column_name as $id => $col) {
                        $data = $row[$col];
                        if($col != 'balance'){
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        }else{
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                        }
                        $this->cell_column++;
                    }
                    $this->cell_row++;
                    $this->write_excel_recursive($excel, $this->first_column, $row['children'], '        ');
                }
            }
            $last_content_row_aktiva = $this->cell_row;
            $last_content_row_aktiva--;
            
            if (count($data_excel['pasiva']) > 0) {
                
                $this->cell_row = $first_content_row;
                
                foreach ($data_excel['pasiva'] as $row) {

                    $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);

                    $this->cell_column = 'E';
                    foreach ($this->arr_column_name as $id => $col) {
                        $data = $row[$col];
                        
                        if($col != 'balance'){
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        }else{
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                        }
                        $this->cell_column++;
                    }
                    $this->cell_row++;
                    $this->write_excel_recursive($excel, 'E', $row['children'], '        ');
                }
            }
            
            $last_content_row_pasiva = $this->cell_row;
            $last_content_row_pasiva--;
            
            $excel->getActiveSheet()->getStyle($this->first_column . $first_content_row . ':C' . $last_content_row_aktiva)->applyFromArray($arr_style_content);
            $excel->getActiveSheet()->getStyle('C' . $first_content_row . ':C' . $last_content_row_aktiva)->getAlignment()->setHorizontal('right');
            $excel->getActiveSheet()->getStyle('E' . $first_content_row . ':G' . $last_content_row_pasiva)->applyFromArray($arr_style_content);
            $excel->getActiveSheet()->getStyle('G' . $first_content_row . ':G' . $last_content_row_pasiva)->getAlignment()->setHorizontal('right');

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . strtoupper($filename) . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }
    
    function write_excel_recursive($excel, $first_column, $arr, $indent = '', $width = 0) {
        if (is_array($arr)) {
            foreach ($arr as $value) {
                $this->cell_column = $first_column;
                $multiplier = 1;
                foreach ($this->arr_column_name as $id => $col) {
                    if ($col == 'title') {
                        $data = $indent . $value[$col];
                    } else {
                        $data = $value[$col];
                    }

                    $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                    $this->cell_column++;
                }
                $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17 * $multiplier);
                $this->cell_row++;

                if (is_array($value['children'])) {
                    $this->write_excel_recursive($excel, $first_column, $value['children'], $indent . '        ', $width + 4);
                }
            }
        }
    }

}
