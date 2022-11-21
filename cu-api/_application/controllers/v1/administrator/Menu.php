<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        
    }

    public function get_ref_action_get(){
        $this->load->model('v1/administrator/menu_model');
        $data = $this->menu_model->get_ref_action();
        if (!empty($data)) {
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan referensi aksi Menu.');
        }
    }

    public function get_option_parent_get()
    {
        $this->load->model('v1/administrator/menu_model');
        $data = $this->menu_model->get_option_parent();
        if (!empty($data)) {
            $this->createResponse(REST_Controller::HTTP_OK, $data);
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan pilihan Menu utama.');
        }
    }

    public function get_data_get(){
        $par_id = (integer)$this->get('par_id') <= 0 ? 0 : (integer)$this->get('par_id');
        $limit = (integer)$this->get('limit') <= 0 ? 10 : (integer)$this->get('limit');
        $page = (integer)$this->get('page') <= 0 ? 1 : (integer)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $this->load->model('v1/administrator/menu_model');
        $results = $this->menu_model->get_menu($par_id, $start, $limit, $sort, $dir, $filter);
        $total = (integer)$results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function get_detail_get(){
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    administrator_menu_id,
                    administrator_menu_title,
                    administrator_menu_description,
                    administrator_menu_link,
                    administrator_menu_icon,
                    administrator_menu_class,
                    administrator_menu_order_by,
                    administrator_menu_is_active,
                    administrator_menu_par_id,
                    IFNULL(json_extract(administrator_menu_action, '$.results'), '[]') AS administrator_menu_action
                FROM sys_administrator_menu
                WHERE administrator_menu_id = $id
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Menu.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Menu.');
        }
    }

    public function act_add_post(){
        $this->form_validation->set_rules('title', '<b>Menu Title</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('link', '<b>Menu Link</b>', 'required|max_length[255]');
        $this->form_validation->set_rules('class', '<b>Icon Class</b>', 'max_length[50]');

        if ($this->post('par_id') > 0) {
            $this->form_validation->set_rules('parent', '<b>Menu Parent</b>', 'required');
        }
        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {

                $action = $this->post('action');

                $administrator_menu_par_id = ($this->post('par_id') > 0) ? $this->post('parent') : $this->post('par_id');
                $administrator_menu_title = $this->post('title');
                $administrator_menu_description = $this->post('description');
                $administrator_menu_link = $this->post('link');
                $administrator_menu_class = $this->post('class');
                $administrator_menu_order_by = $this->common_function->get_max('sys_administrator_menu', 'administrator_menu_order_by', array('administrator_menu_par_id' => $administrator_menu_par_id)) + 1;

                $administrator_menu_action = '{"name": "show","title": "Show Data"}';
                if (isset($action)) {
                    foreach ($action as $value) {
                        $administrator_menu_action .= ',' . $value;
                    }
                }

                $title = ($administrator_menu_par_id == 0) ? 'menu' : 'sub menu';

                $data = array();
                $data['administrator_menu_par_id'] = $administrator_menu_par_id;
                $data['administrator_menu_title'] = $administrator_menu_title;
                $data['administrator_menu_description'] = $administrator_menu_description;
                $data['administrator_menu_link'] = $administrator_menu_link;
                $data['administrator_menu_class'] = $administrator_menu_class;
                $data['administrator_menu_action'] = '{"results":[' . $administrator_menu_action . ']}';
                $data['administrator_menu_order_by'] = $administrator_menu_order_by;

                $this->db->insert('sys_administrator_menu', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data ' . $title . '! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil tambah data ' . $title . '.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data ' . $title . '! Silahkan coba lagi.');
            }
        }

    }

    public function act_update_put(){
        $set_data = array(
            'link' => $this->put('link'),
            'title' => $this->put('title'),
            'class' => $this->put('class'),
            'parent' => $this->put('parent')
        );
        $this->form_validation->set_data($set_data);

        $this->form_validation->set_rules('title', '<b>Menu Title</b>', 'required|max_length[50]');
        $this->form_validation->set_rules('link', '<b>Menu Link</b>', 'required|max_length[255]');
        $this->form_validation->set_rules('class', '<b>Icon Class</b>', 'max_length[50]');

        if ($this->put('par_id') > 0) {
            $this->form_validation->set_rules('parent', '<b>Menu Parent</b>', 'required');
        }


        if ($this->form_validation->run($this) == false) {

            $response = array(
                'status' => 400,
                'msg' => validation_errors()
            );
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {

                $action = $this->put('action');

                $administrator_menu_id = $this->put('id');
                $administrator_menu_par_id = ($this->put('par_id') > 0) ? $this->put('parent') : $this->put('par_id');
                $administrator_menu_title = $this->put('title');
                $administrator_menu_description = $this->put('description');
                $administrator_menu_link = $this->put('link');
                $administrator_menu_class = $this->put('class');

                $administrator_menu_action = '{"name": "show","title": "Show Data"}';
                if (isset($action)) {
                    foreach ($action as $value) {
                        $administrator_menu_action .= ',' . $value;
                    }
                }

                $title = ($administrator_menu_par_id == 0) ? 'menu' : 'sub menu';

                $data = array();
                $data['administrator_menu_par_id'] = $administrator_menu_par_id;
                $data['administrator_menu_title'] = $administrator_menu_title;
                $data['administrator_menu_description'] = $administrator_menu_description;
                $data['administrator_menu_link'] = $administrator_menu_link;
                $data['administrator_menu_class'] = $administrator_menu_class;
                if ($this->put('par_id') != $this->put('parent') && $this->put('par_id') > 0) {
                    $administrator_menu_order_by = $this->common_function->get_max('sys_administrator_menu', 'administrator_menu_order_by', array('administrator_menu_par_id' => $administrator_menu_par_id)) + 1;
                    $data['administrator_menu_order_by'] = $administrator_menu_order_by;
                }
                $data['administrator_menu_action'] = '{"results":[' . $administrator_menu_action . ']}';

                $this->db->where('administrator_menu_id', $administrator_menu_id);
                $this->db->update('sys_administrator_menu', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data ' . $title . '! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil ubah data ' . $title . '.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data ' . $title . '! Silahkan coba lagi.');
            }
        }
    }

    public function act_delete_post(){
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $this->db->trans_begin();

                //hapus data
                $this->db->where('administrator_menu_id', $id);
                $this->db->delete('sys_administrator_menu');

                if ($this->db->affected_rows() < 1) {
                    $is_error = true;
                }

                if (!$is_error) {
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        $failed++;
                    } else {
                        $this->db->trans_commit();
                        $success++;
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dihapus. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dihapus.' : '';

            $message = $str_success . $str_failed;
            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal hapus data! Silahkan coba lagi.');
        }
    }

    public function act_activate_put()
    {
        $arr_item = json_decode($this->put('item'));
        if (is_array($arr_item)) {
            $success = $failed = $no_change = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $is_change = true;

                $this->db->trans_begin();

                $data = array();
                $data['administrator_menu_is_active'] = '1';
                $this->db->where('administrator_menu_id', $id);
                $this->db->update('sys_administrator_menu', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if ($this->db->affected_rows() == 0) {
                    $is_change = false;
                }

                if (!$is_error) {
                    if ($is_change) {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $success++;
                        }
                    } else {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $no_change++;
                        }
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil diaktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal diaktifkan.' : '';

            $message = $str_success . $str_no_change . $str_failed;
            
            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal aktifkan data! Silahkan coba lagi.');
        }
    }

    public function act_deactivate_put()
    {
        $arr_item = json_decode($this->put('item'));
        if (is_array($arr_item)) {
            $success = $failed = $no_change = 0;
            foreach ($arr_item as $id) {

                $is_error = false;
                $is_change = true;

                $this->db->trans_begin();

                $data = array();
                $data['administrator_menu_is_active'] = '0';
                $this->db->where('administrator_menu_id', $id);
                $this->db->update('sys_administrator_menu', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if ($this->db->affected_rows() == 0) {
                    $is_change = false;
                }

                if (!$is_error) {
                    if ($is_change) {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $success++;
                        }
                    } else {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $no_change++;
                        }
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dinon-aktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dinon-aktifkan.' : '';

            $message = $str_success . $str_no_change . $str_failed;

            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal aktifkan data! Silahkan coba lagi.');
        }
    }

    public function act_update_up_put(){
        $arr_item = json_decode($this->put('item'));
        if (is_array($arr_item)) {
            $success = $failed = $over = 0;
            foreach ($arr_item as $id) {
                $this->load->model('v1/administrator/menu_model');

                $this->db->trans_begin();
                $up = $this->menu_model->update_menu_order_by($id, 'up');

                if (!$up['is_error']) {
                    if (!$up['is_over']) {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $success++;
                        }
                    } else {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_rollback();
                            $over++;
                        }
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data telah dipindah ke atas. ' : '';
            $str_over = ($over > 0) ? $over . ' data tidak berpindah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dipindah ke atas.' : '';
            $message = $str_success . $str_over . $str_failed;

            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal aktifkan data! Silahkan coba lagi.');
        }
    }

    public function act_update_down_put()
    {
        $arr_item = json_decode($this->put('item'));
        if (is_array($arr_item)) {
            $success = $failed = $over = 0;
            foreach ($arr_item as $id) {
                $this->load->model('v1/administrator/menu_model');

                $this->db->trans_begin();
                $up = $this->menu_model->update_menu_order_by($id, 'down');

                if (!$up['is_error']) {
                    if (!$up['is_over']) {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_commit();
                            $success++;
                        }
                    } else {
                        if ($this->db->trans_status() === false) {
                            $this->db->trans_rollback();
                            $failed++;
                        } else {
                            $this->db->trans_rollback();
                            $over++;
                        }
                    }
                } else {
                    $this->db->trans_rollback();
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data telah dipindah ke bawah. ' : '';
            $str_over = ($over > 0) ? $over . ' data tidak berpindah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dipindah ke bawah.' : '';
            $message = $str_success . $str_over . $str_failed;

            if ($failed > 0) {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
            } else {
                $this->createResponse(REST_Controller::HTTP_OK, $message);
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal aktifkan data! Silahkan coba lagi.');
        }
    }
}

/* End of file Menu.php */
