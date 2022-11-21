<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Income_statement extends Backend_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->first_column = $this->cell_column = 'A';
        $this->cell_row = $this->first_row = 1;
    }

    public function index() {
         $this->show();
    }
    
    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("accounting/income_statement_view", $data);
        $this->template->show('template');
    }
    
    public function get_data() {
        
        $month = $this->input->get('month');

        $res = $this->curl->get(URL_API . 'accounting/labarugi/get_data', array(
            "month" => date('Y-m', strtotime($month)) . '-01',
        ));
        
        echo $res;
    }
    
    public function export_data() {
        $month = $this->input->post('month');

        $res = $this->curl->get(URL_API . 'accounting/labarugi/get_data', array(
            "month" => date('Y-m', strtotime($month)) . '-01',
        ));
        
        $response = json_decode($res);
        
        if ($response->status == 200) {
            $data = array(
                'pendapatan' => $response->data->results->pendapatan,
                'biaya' => $response->data->results->biaya,
                'total_pendapatan' => $response->data->results->total_pendapatan,
                'total_biaya' => $response->data->results->total_biaya,
                'total_laba_rugi' => $response->data->results->total_laba_rugi
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

            $title = 'LAPORAN LABA RUGI PERIODE ' . convert_month(date('m', strtotime($month)), 'id') . ' ' . date('Y', strtotime($month));
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
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, 'TOTAL LABA RUGI');
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':B' . $this->cell_row);
            $this->cell_column++;
            $this->cell_column++;
            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data_excel['total_laba_rugi'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->cell_row++;
            
            $this->cell_row++;
            
            $arr_column_title = array('No. Rekening', 'Nama Rekening', 'Jumlah');
            $arr_column_name = array('number', 'title', 'balance');
            
            if (is_array($arr_column_title)) {
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                foreach ($arr_column_title as $id => $value) {
                    $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($value));
                    $this->cell_column++;
                }
                
                $this->cell_row++;
            }
                
            $first_content_row_pendapatan = $this->cell_row;

            if (count($data_excel['pendapatan']) > 0) {
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, 'Pendapatan', PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':C' . $this->cell_row);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(12);
                $this->cell_row++;
                
                foreach ($data_excel['pendapatan'] as $row) {

                    $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);
                    
                    $this->cell_column = $this->first_column;
                    foreach ($arr_column_name as $id => $col) {
                        $data = $row->$col;
                        if($col != 'balance'){
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        }else{
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                        }
                        $this->cell_column++;
                    }
                    $this->cell_row++;
                }
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, 'Total Pendapatan', PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':B' . $this->cell_row);
                $excel->getActiveSheet()->setCellValueExplicit('C' . $this->cell_row, $data_excel['total_pendapatan'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $excel->getActiveSheet()->getStyle('C' . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $this->cell_row++;
            }
            $last_content_row_pendapatan = $this->cell_row;
            $last_content_row_pendapatan--;
            
            $this->cell_row++;
            
            $first_content_row_biaya = $this->cell_row;
            
            if (count($data_excel['biaya']) > 0) {
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, 'Biaya', PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':C' . $this->cell_row);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(12);
                
                $this->cell_row++;
                foreach ($data_excel['biaya'] as $row) {

                    $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);
                    
                    $this->cell_column = $this->first_column;
                    foreach ($arr_column_name as $id => $col) {
                        $data = $row->$col;
                        if($col != 'balance'){
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        }else{
                            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                        }
                        $this->cell_column++;
                    }
                    $this->cell_row++;
                }
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, 'Total Biaya', PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':B' . $this->cell_row);
                $excel->getActiveSheet()->setCellValueExplicit('C' . $this->cell_row, $data_excel['total_biaya'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $excel->getActiveSheet()->getStyle('C' . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $this->cell_row++;
            }
            
            $last_content_row_biaya = $this->cell_row;
            $last_content_row_biaya--;
            
            $this->cell_row++;
            
            $this->cell_column = $this->first_column;
            $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->applyFromArray($arr_style_title);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':C' . $this->cell_row)->getFont()->setBold(true)->setSize(11);
            $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, 'TOTAL LABA RUGI');
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()->mergeCells($this->cell_column . $this->cell_row . ':B' . $this->cell_row);
            $this->cell_column++;
            $this->cell_column++;
            $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data_excel['total_laba_rugi'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getNumberFormat()->setFormatCode("#,##0");
            $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $excel->getActiveSheet()->getStyle($this->first_column . $first_content_row_pendapatan . ':C' . $last_content_row_pendapatan)->applyFromArray($arr_style_content);
            $excel->getActiveSheet()->getStyle('C' . $first_content_row_pendapatan . ':C' . $last_content_row_pendapatan)->getAlignment()->setHorizontal('right');
            $excel->getActiveSheet()->getStyle($this->first_column . $first_content_row_biaya . ':C' . $last_content_row_biaya)->applyFromArray($arr_style_content);
            $excel->getActiveSheet()->getStyle('C' . $first_content_row_biaya . ':C' . $last_content_row_biaya)->getAlignment()->setHorizontal('right');

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . strtoupper($filename) . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }

}
