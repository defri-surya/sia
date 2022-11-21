<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invitation extends Backend_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $data['is_superuser'] = $this->is_superuser;
        $data['user_group'] = $this->user_group;

        $this->template->content("membership/invitation_list_view", $data);
        $this->template->show('template');
    }

    public function get_data() {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $invitation_event = $this->input->post('invitation_event', TRUE);

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'invitation_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        array_push($filter, array(
            "type" => "string",
            "field" => "invitation_event",
            "value" => $invitation_event,
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/invitation/get_data', array(
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

            foreach ($results as $row) {
                $detail = '<a href="javascript:;" onclick="openModalDetail(' . $row->invitation_id . ')"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Detail" title="Detail" /></a>';
                $edit = '<a href="javascript:;" onclick="openModalUpdate(' . $row->invitation_id . ')"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>';

                $entry = array('id' => $row->invitation_id,
                    'cell' => array(
                        'invitation_datetime' => convert_datetime($row->invitation_datetime, 'id'),
                        'invitation_code' => $row->invitation_code,
                        'invitation_subject' => $row->invitation_subject,
                        'invitation_location' => $row->invitation_location,
                        'invitation_note' => $row->invitation_note,
                        'invitation_status' => $row->invitation_status == 0 ? '<span class="label label-danger">Belum Terlaksana</span>' : '<span class="label label-success">Sudah Terlaksana</span>',
                        'invitation_input_datetime' => convert_datetime($row->invitation_input_datetime, 'id'),
                        'invitation_update_datetime' => convert_datetime($row->invitation_update_datetime, 'id'),
                        'invitation_administrator_name' => $row->invitation_administrator_name,
                        'invitation_administrator_username' => $row->invitation_administrator_username,
                        'detail' => $detail,
                        'edit' => $edit
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
        $except_member = json_decode($this->input->post('except_member'));

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'member_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';

        array_push($filter, array(
            "type" => "numeric",
            "field" => "member_is_diksar",
            "value" => "0",
            "comparison" => "="
        ));

        if (count($except_member) > 0) {
            array_push($filter, array(
                "type" => "list",
                "field" => "member_id",
                "value" => count($except_member) == 1 ? implode("::", $except_member) . "::" : implode('::', $except_member),
                "comparison" => "no"
            ));
        }

        $res = $this->curl->get(URL_API . 'membership/member/get_data', array(
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

            $countIndex = 1;
            foreach ($results as $row) {

                $data_id = array(
                    'id' => $row->member_id,
                    'code' => $row->member_code,
                    'temp_code' => $row->member_temp_code,
                    'name' => $row->member_name
                );

                $entry = array('id' => json_encode($data_id),
                    'cell' => array(
                        'member_code' => $row->member_code,
                        'member_temp_code' => $row->member_temp_code,
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

    function act_add_diksar() {
        $datetime = validate_date($_POST['datetime'], 'd/m/Y H:i') ? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['datetime']))) : NULL;
        if ($datetime != NULL) {
            $_POST['datetime'] = $datetime;
            $_POST['event'] = 'diksar';
            $res = $this->curl->post(URL_API . 'membership/invitation/act_add', $this->input->post());
            echo $res;
        } else {
            $res = array(
                'status' => 400,
                'msg' => 'Gagal tambah data! Format Waktu salah. Silahkan coba lagi.'
            );
            echo json_encode($res);
        }
    }
    
    function act_add_absen() {
        $_POST['member'] = json_encode($_POST['member']);
        $_POST['event'] = 'diksar';
        $res = $this->curl->post(URL_API . 'membership/invitation/act_presensi', $this->input->post());
        echo $res;
    }

    function act_print($id) {
        if (!empty($id) && is_numeric($id)) {

            $res = $this->curl->get(URL_API . 'membership/invitation/get_detail', array('id' => $id));
            $response = json_decode($res);

            if ($response->status == 200) {
                $info = $response->data;
                $detail = $response->data->detail;

                $this->load->library('Pdf');

                $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetTitle('Undangan Diksar');
                $pdf->SetHeaderMargin(35);
                $pdf->SetTopMargin(0);
                $pdf->setFooterMargin(0);
                $pdf->setFontSize(11);
                $pdf->SetAutoPageBreak(true);
                $pdf->SetAuthor('Author');
                $pdf->SetDisplayMode('real', 'default');
                $pdf->AddPage();

                $html = '';
                $table = '';
                $i = 1;
                foreach ($detail as $row) {
                    $str_rt = empty($row->member_domicile_rt_number) ? '' : ' RT.' . $row->member_domicile_rt_number;
                    $str_rw = empty($row->member_domicile_rw_number) ? '' : ' RW.' . $row->member_domicile_rw_number;
                    $str_kelurahan = empty($row->member_domicile_kelurahan) ? '' : ' ' . $row->member_domicile_kelurahan;
                    $str_subdistrict = empty($row->member_domicile_subdistrict) ? '' : ' ' . $row->member_domicile_subdistrict;
                    $str_city = empty($row->member_domicile_city) ? '' : ' ' . $row->member_domicile_city;
                    $str_province = empty($row->member_domicile_province) ? '' : ' ' . $row->member_domicile_province;
                    
                    $table .= '
                        <tr bgcolor="#ffffff">
                            <th width="5%" align="center">' . $i . '</th>
                            <th width="30%">' . $row->member_name . '</th>
                            <th width="40%">' . $row->member_address_domicile . $str_rt . $str_rw . $str_kelurahan . $str_subdistrict . $str_city . $str_province . '</th>
                            <th width="20%"></th>
                        </tr>
                    ';
                    $i++;
                }
                $html .= '
                    <div style="page-break-after:always">
                        <div style="display:block; text-align:center;">
                            <h1><u>KOPDIT KOSAYU</u></h1>
                            Alamat : Jl. Candi Kalasan No. 3
                            <br>Malang Jawa Timur 65125 Tlp. (0341) 491567 Fax. (0341) 418957 info@kopditkosayu.co.id
                            <br>Badan Hukum : 7004 / BH / II / 91 Tgl 29 April 1991
                        </div>
                        <br>
                        <br>
                        <table cellspacing="2" bgcolor="#666666" cellpadding="5">
                            <tr bgcolor="#ffffff">
                                <th width="5%" align="center">No</th>
                                <th width="30%" align="center">Nama </th>
                                <th width="40%" align="center">Alamat</th>
                                <th width="20%" align="center">Tanda Tangan</th>
                            </tr>
                            ' . $table . '
                        </table>
                    </div>
                ';
                
                $hal = 0;
                foreach ($detail as $row) {
                    $hal++;
                    $style = '';
                    if ($hal < count($detail)) {
                        $style = 'page-break-after:always';
                    }

                    $str_rt = empty($row->member_domicile_rt_number) ? '' : ' RT.' . $row->member_domicile_rt_number;
                    $str_rw = empty($row->member_domicile_rw_number) ? '' : ' RW.' . $row->member_domicile_rw_number;
                    $str_kelurahan = empty($row->member_domicile_kelurahan) ? '' : ' ' . $row->member_domicile_kelurahan;
                    $str_subdistrict = empty($row->member_domicile_subdistrict) ? '' : ' ' . $row->member_domicile_subdistrict;
                    $str_city = empty($row->member_domicile_city) ? '' : ' ' . $row->member_domicile_city;
                    $str_province = empty($row->member_domicile_province) ? '' : ' ' . $row->member_domicile_province;

                    $html .= '
                        <div style="' . $style . '">
                            <div style="display:block; text-align:center;">
                                <h1><u>KOPDIT KOSAYU</u></h1>
                                Alamat : Jl. Candi Kalasan No. 3
                                <br>Malang Jawa Timur 65125 Tlp. (0341) 491567 Fax. (0341) 418957 info@kopditkosayu.co.id
                                <br>Badan Hukum : 7004 / BH / II / 91 Tgl 29 April 1991
                            </div> 

                            <br>
                            <h4>Nomor : ' . $info->invitation_code . '
                            <br>Hal   : Undangan Pendidikan Dasar
                            <br>Lampiran : -
                            <br>
                            <br>
                            <br>Kepada Yth.
                            <br>Sdr/i. ' . $row->member_name . '
                            <br>' . $row->member_temp_code . '
                            <br>' . $row->member_address_domicile . $str_rt . $str_rw . $str_kelurahan . $str_subdistrict . $str_city . $str_province . ' </h4>

                            <p>Dengan Hormat,
                            <br>Dengan ini kami mengundang Bpk/Ibu/Sdr/I penabung aktif, untuk menghadiri Pendidikan Dasar Calon Anggota KOPDIT KOSAYU yang akan diadakan pada Tanggal:

                            <br>

                            <br> Hari   : ' . indonesian_date($info->invitation_datetime, 'l, j F Y') . '
                            <br> Jam    : ' . indonesian_date($info->invitation_datetime, 'H.i') . ' WIB
                            <br> Tempat : ' . $info->invitation_location . '
                            <br> Acara  : ' . $info->invitation_subject . '
                            <br> Note   : ' . $info->invitation_note . '
                            <br> 

                            <br>mengingat penting dan manfaatnya acara ini, kami mohon dengan sangat kehadiran Bpk/Ibu/Sdr/i dalam acara Tersebut. Atas Perhatianya dan kerjasamanya yang baik, kami ucapkan terima kasih.</P>

                            <div style="display:block; text-align:right;">
                                  <p>KOPDIT KOSAYU
                                  <br>Malang, ' . convert_date(date('Y-m-d'), 'id') . '</p>
                                  <br>
                                  <br>
                                  <p>Pelaksana</p>
                            </div>

                            <p>catatan:<br> -Keterlambatan Maksimal 15 Menit, lebih dari itu di ikut sertakan pada diksar berikutnya</p> 
                        </div>
                    ';
                }
                $pdf->writeHTML($html, true, false, true, false, '');
                $pdf->Output('Undangan Diksar.pdf', 'I');
            } else {
                echo '
                        <script>
                            alert("Gagal mencetak data!\nData tidak ditemukan.");
                            close();
                        </script>
                    ';
            }
        } else {
            show_404();
        }
    }

    public function export_data($type = 'diksar') {
        //Get variable from flexigrid
        $page_grid = $this->input->post('page', TRUE);
        $rp_grid = $this->input->post('rp', TRUE);
        $sortname_grid = $this->input->post('sortname', TRUE);
        $sortorder_grid = $this->input->post('sortorder', TRUE);
        $querys_grid = $this->input->post('querys');
        $invitation_event = $type;

        //Set default value
        $limit = isset($rp_grid) ? $rp_grid : 10;
        $page = isset($page_grid) ? $page_grid : 1;
        $filter = $this->function_lib->get_array_filter($querys_grid);
        $sort = isset($sortname_grid) ? $sortname_grid : 'invitation_id';
        $dir = isset($sortorder_grid) ? $sortorder_grid : 'ASC';
        
        array_push($filter, array(
            "type" => "string",
            "field" => "invitation_event",
            "value" => $invitation_event,
            "comparison" => "="
        ));

        $res = $this->curl->get(URL_API . 'membership/invitation/get_data', array(
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
                $results[$key]->invitation_status = $value->invitation_status == 0 ? 'Belum Terlaksana' : 'Sudah Terlaksana';
                $results[$key]->invitation_datetime = convert_datetime($value->invitation_datetime, 'id');
            }

            $data = array();
            $data['title'] = 'Data Undangan Diksar';
            $data['results'] = $results;
            $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();

            $this->function_lib->export_excel_standard($data);
        } else {
            echo "alert('Gagal export data!')";
        }
    }

}
