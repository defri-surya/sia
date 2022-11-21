<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coa_master extends Backend_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->first_column = $this->cell_column = 'A';
        $this->cell_row = $this->first_row = 1;

        $this->arr_column_max_width = array();

        $this->arr_column_title = ['No. Rekening','Nama Akun'];
        $this->arr_column_align = ['left','left'];
            
        $this->arr_column_name = ['title','coaName'];
    }

    public function index() {
        $this->show();
    }

    public function show() {
        
        $data['list_branch'] = $this->common_model->get_list_branch();
        
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;
        
        $this->template->content("setup/coa_master_list_view", $data);
        $this->template->show('template');
    }

    public function get_data($type = 'aktiva') {
        $arr_coa_type = array('aktiva', 'pasiva', 'pendapatan', 'biaya', 'nominal');
        
        if (!in_array($type, $arr_coa_type)) {
            $type = 'aktiva';
        }

        $arr_filter[] = array(
            "type" => "string",
            "field" => "coa_master_type",
            "value" => $type,
            "comparison" => "="
            );

        $res = $this->curl->get(URL_API . 'setup/coa_master/get_data', array(
            "limit" => 1000,
            "page" => 1,
            "filter" => $arr_filter,
            "sort" => "coa_master_id",
            "dir" => "ASC",
        ));
        $response = json_decode($res);

        $json_cat = array();
        if ($response->status == 200) {
            $results = $response->data->results;
            foreach ($results as $row) {
                $data_row = array(
                    "key" => $row->coa_master_id,
                    "parentId" => $row->coa_master_parent_id,
                    "coaName" => $row->coa_master_title,
                    "title" => $row->coa_master_number,
                    "alias" => $row->coa_master_title_alias,
                    "isPositive" => $row->coa_master_is_positive,
                    "coaType" => $row->coa_master_type,
                    "tag" => $row->coa_master_tag,
                    "folder" => false,
                    "expanded" => true
                );

                array_push($json_cat, $data_row);
            }
        }

        if (sizeof($json_cat) == 0) {
            echo json_encode($json_cat);
        } else {
            echo json_encode($this->array_nested_builder($json_cat));
        }
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
    
    public function act_add() {
        $res = $this->curl->post(URL_API . 'setup/coa_master/act_add', $this->input->post());
        echo $res;
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'setup/coa_master/act_update', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'setup/coa_master/act_delete', $this->input->post());
        echo $res;
    }
    
    function export_data_coa($type = 'aktiva') {
        $arr_coa_type = array('aktiva', 'pasiva', 'pendapatan', 'biaya', 'nominal');
        
        if (!in_array($type, $arr_coa_type)) {
            $type = 'aktiva';
        }

        $arr_filter[] = array(
            "type" => "string",
            "field" => "coa_master_type",
            "value" => $type,
            "comparison" => "="
            );

        $res = $this->curl->get(URL_API . 'setup/coa_master/get_data', array(
            "limit" => 100,
            "page" => 1,
            "filter" => $arr_filter,
            "sort" => "coa_master_id",
            "dir" => "ASC",
        ));
        $response = json_decode($res);

        $json_cat = array();
        if ($response->status == 200) {
            $results = $response->data->results;
            foreach ($results as $row) {
                $data_row = array(
                    "key" => $row->coa_master_id,
                    "parentId" => $row->coa_master_parent_id,
                    "coaName" => $row->coa_master_title,
                    "title" => $row->coa_master_number,
                    "alias" => $row->coa_master_title_alias,
                    "isPositive" => $row->coa_master_is_positive,
                    "coaType" => $row->coa_master_type,
                    "tag" => $row->coa_master_tag,
                    "folder" => false,
                    "expanded" => true
                );

                array_push($json_cat, $data_row);
            }
        }

        if (sizeof($json_cat) == 0) {
            $data_excel = $json_cat;
        } else {
            $data_excel = $this->array_nested_builder($json_cat);
        }

        $this->export_excel($data_excel, $type);
    }
    
    function export_excel($data_excel = false, $type) {
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

            $title = 'Data Master COA ' . $type;
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

            //cari jumlah kolom
            $total_column = 0;
            $last_column = $this->first_column;
            foreach ($this->arr_column_title as $id => $val) {
                $total_column++;
                if ($total_column > 1) {
                    $last_column++;
                }
            }

            if (is_array($this->arr_column_title)) {
                $this->cell_column = $this->first_column;
                $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(20);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':' . $last_column . $this->cell_row)->applyFromArray($arr_style_title);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':' . $last_column . $this->cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($this->cell_column . $this->cell_row . ':' . $last_column . $this->cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                foreach ($this->arr_column_title as $id => $value) {
                    $this->arr_column_max_width[$id] = ceil(1.5 * strlen($value) + 0.6);
                    $excel->getActiveSheet()->getColumnDimension($this->cell_column)->setWidth($this->arr_column_max_width[$id]);
                    $excel->getActiveSheet()->setCellValue($this->cell_column . $this->cell_row, strtoupper($value));
                    $this->cell_column++;
                }
                $this->cell_row++;
            }
            $first_content_row = $this->cell_row;

            if (count($data_excel) > 0) {
                foreach ($data_excel as $row) {

                    $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17);

                    $this->cell_column = $this->first_column;
                    foreach ($this->arr_column_name as $id => $col) {
                        $data = $row[$col];
                        $column_width = ceil(strlen($data));
                        if ($column_width > $this->arr_column_max_width[$id]) {
                            $this->arr_column_max_width[$id] = $column_width;
                        }
                        $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        $this->cell_column++;
                    }
                    $this->cell_row++;
                    $this->write_excel_recursive($excel, $row['children'], '        ');
                }
            }
            $last_content_row = $this->cell_row;
            $last_content_row--;

            $this->cell_column = $this->first_column;
            foreach ($this->arr_column_title as $id => $value) {
                $excel->getActiveSheet()->getStyle($this->cell_column . $first_content_row . ':' . $this->cell_column . $last_content_row)->getAlignment()->setHorizontal($this->arr_column_align[$id]);
                $excel->getActiveSheet()->getStyle($this->cell_column . $first_content_row . ':' . $this->cell_column . $last_content_row)->applyFromArray($arr_style_content);
                if ($this->arr_column_name[$id] == 'title') {
                    $column_width = $this->arr_column_max_width[$id];
                } else {
                    $column_width = ($this->arr_column_max_width[$id] > 50) ? 50 : $this->arr_column_max_width[$id]; //max_width = 50
                }

                $excel->getActiveSheet()->getColumnDimension($this->cell_column)->setWidth($column_width);

                $this->cell_column++;
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }

    function write_excel_recursive($excel, $arr, $indent = '', $width = 0) {
        if (is_array($arr)) {
            foreach ($arr as $value) {
                $this->cell_column = $this->first_column;
                $multiplier = 1;
                foreach ($this->arr_column_name as $id => $col) {
                    if ($col == 'title') {
                        $data = $indent . $value[$col];
                        $column_width = ceil(strlen($data) - $width);
                    } else {
                        $data = $value[$col];
                        $column_width = ceil(strlen($data));
                    }

                    if ($column_width > $this->arr_column_max_width[$id]) {
                        $this->arr_column_max_width[$id] = $column_width;
                    }
                    $excel->getActiveSheet()->setCellValueExplicit($this->cell_column . $this->cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                    if ($col == 'description') {
                        if ($column_width > 50) {
                            $multiplier = ceil($column_width / 50);
                        }
                    }
                    $this->cell_column++;
                }
                $excel->getActiveSheet()->getRowDimension($this->cell_row)->setRowHeight(17 * $multiplier);
                $this->cell_row++;

                if (is_array($value['children'])) {
                    $this->write_excel_recursive($excel, $value['children'], $indent . '        ', $width + 4);
                }
            }
        }
    }
}
