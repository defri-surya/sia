<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_master extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }
    
    public function show() {
        $this->template->content("setup/jurnal_master_list_view");
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
        $sort = isset($sortname_grid) ? $sortname_grid : 'jurnal_master_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'DESC';

        $res = $this->curl->get(URL_API . 'setup/jurnal_master/get_data', array(
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
            
            $arr_type = array('Memorial', 'Otomatis');

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->jurnal_master_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalEdit(' . $row->jurnal_master_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->jurnal_master_id,
                    'cell' => array(
                        'jurnal_master_title' => $row->jurnal_master_title,
                        'jurnal_master_type' => $arr_type[$row->jurnal_master_type],
                        'jurnal_master_last_update' => convert_datetime($row->jurnal_master_last_update, 'id'),
                        'detail' => $detail,
                        'edit' => $edit
                    ),
                );

                $json_data['rows'][] = $entry;
            }
        }
        echo json_encode($json_data);
    }
    
    public function get_data_coa($type = 'aktiva') {
        $arr_coa_type = array('aktiva', 'pasiva', 'pendapatan', 'biaya', 'nominal');
        
        $json_except = $this->input->get('except');
        $arr_except = json_decode($json_except);
        
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
                    "expanded" => true,
                    "isExcept" => in_array($row->coa_master_id, $arr_except)
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
        $res = $this->curl->post(URL_API . 'setup/jurnal_master/act_add', $this->input->post());
        echo $res;
    }
    
    public function act_update() {
        $res = $this->curl->put(URL_API . 'setup/jurnal_master/act_update', $this->input->post());
        echo $res;
    }
    
    public function act_delete() {
        $res = $this->curl->post(URL_API . 'setup/jurnal_master/act_delete', $this->input->post());
        echo $res;
    }
    
    public function export_data_jurnal() {
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

        $res = $this->curl->get(URL_API . 'setup/jurnal_master/get_data', array(
            "limit" => $limit,
            "page" => $page,
            "filter" => $filter,
            "sort" => $sort,
            "dir" => $dir,
        ));
        $response = json_decode($res);

        if ($response->status = 200) {
            $results = $response->data->results;
            $total_data = $response->data->pagination->total_data;

            $data = array();
            $data['title'] = 'Data Master Jurnal';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->export_excel($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }
    
    function export_excel($data = false) {
        if($data) {
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
                $arr_type_name = array('Memorial', 'Otomatis');
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
                                if($value == 'jurnal_master_type'){
                                    $data = $arr_type_name[$data = $row->$value];
                                }
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

}
