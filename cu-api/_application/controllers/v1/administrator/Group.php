<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Group extends Auth_Api_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function index()
    {
    }

    public function get_data_get()
    {
        $limit = (int)$this->get('limit') <= 0 ? 10 : (int)$this->get('limit');
        $page = (int)$this->get('page') <= 0 ? 1 : (int)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;
        $this->load->model('v1/administrator/group_model');
        $results = $this->group_model->get_group($start, $limit, $sort, $dir, $filter, $this->get_user('user_auth_type'));
        $total = (int)$results['count'];

        # -- pagination -- #
        $pagination = page_generate($total, $page, $limit);
        # -- pagination -- #

        $data = array(
            'results' => $results['data'],
            'pagination' => $pagination
        );
        $this->createResponse(REST_Controller::HTTP_OK, $data);
    }

    public function get_detail_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $this->load->model('v1/administrator/group_model');

            $data = array();

            $arr_checked_menu = array();
            $privilege = $this->group_model->get_group_list_privilege($id);
            if (!empty($privilege)) {
                foreach ($privilege as $row_privilege) {
                    $arr_checked_menu[] = array(
                        'id' => $row_privilege->administrator_menu_id,
                        'act' => json_decode($row_privilege->results)
                    );
                }
            }


            $group = $this->group_model->get_group_detail($id, $this->get_user('user_auth_type'));

            if (!empty($group)) {
                $data['arr_checked_menu'] = $arr_checked_menu;
                $data['data'] = $group;
            }

            if (!empty($data)) {
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Menu.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Menu.');
        }
    }

    public function get_menu_get()
    {

        $this->load->model('v1/administrator/group_model');
        $arr_menu_privilege = array();
        if ($this->get_user('user_auth_type') == 'superuser') {
            $query_menu = $this->group_model->get_superuser_menu();
        } else {
            $query_menu = $this->group_model->get_administrator_menu($this->get_user('user_auth_group_id'));
        }

        if ($query_menu->num_rows() > 0) {
            foreach ($query_menu->result() as $row_menu) {
                $arr_menu_privilege[$row_menu->administrator_menu_par_id][$row_menu->administrator_menu_order_by] = $row_menu;
            }
        }

        $result['results'] = $arr_menu_privilege;

        $this->createResponse(REST_Controller::HTTP_OK, $result);
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('title', '<b>Nama Grup</b>', 'required|max_length[20]');

        if ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') {
            $this->form_validation->set_rules('type', '<b>Tipe Grup</b>', 'required');

            if ($this->post('type') == 'administrator_branch') {
                $this->form_validation->set_rules('branch', '<b>Nama Unit</b>', 'required');
            }
        }

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $administrator_group_branch_id = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->post('branch') : $_SESSION['administrator_group_branch_id'];
            $administrator_group_type = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->post('type') : 'administrator_branch';

            $is_error = false;

            $this->db->trans_begin();

            try {

                $administrator_group_title = $this->post('title');
                $administrator_group_company_id = 1;

                $menu = $this->post('menu');
                $action = $this->post('action');

                $data = array();
                $data['administrator_group_company_id'] = $administrator_group_company_id;
                $data['administrator_group_branch_id'] = $administrator_group_branch_id;
                $data['administrator_group_type'] = $administrator_group_type;
                $data['administrator_group_title'] = $administrator_group_title;
                $data['administrator_group_is_active'] = 1;

                $administrator_group_id = 0;
                if (!$this->db->insert('sys_administrator_group', $data)) {
                    $is_error = true;
                } else {
                    $administrator_group_id = $this->db->insert_id();
                }

                //add privilege
                if (isset($menu) && $administrator_group_id != 0) {
                    foreach ($menu as $menu_id) {
                        $arr_action = array('show');
                        if (isset($action[$menu_id])) {
                            foreach ($action[$menu_id] as $action_name) {
                                array_push($arr_action, $action_name);
                            }
                        }
                        $data = array();
                        $data['administrator_privilege_administrator_group_id'] = $administrator_group_id;
                        $data['administrator_privilege_administrator_menu_id'] = $menu_id;
                        $data['administrator_privilege_action'] = '{"results": ' . json_encode($arr_action) . '}';
                        $this->db->insert('sys_administrator_privilege', $data);

                        if ($this->db->affected_rows() < 0) {
                            $is_error = true;
                        }
                    }
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil tambah data.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal tambah data! Silahkan coba lagi.');
            }
        }
    }

    public function act_update_put()
    {
        $set_data = array(
            'type' => $this->put('type'),
            'title' => $this->put('title'),
            'branch' => $this->put('branch')
        );
        $this->form_validation->set_data($set_data);
        $this->form_validation->set_rules('title', '<b>Nama Grup</b>', 'required|max_length[20]');

        if ($this->put('administrator_group_id') != $this->get_user('user_auth_group_id')) {
            if ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') {
                $this->form_validation->set_rules('type', '<b>Tipe Grup</b>', 'required');

                if ($this->put('type') == 'administrator_branch') {
                    $this->form_validation->set_rules('branch', '<b>Nama Unit</b>', 'required');
                }
            }
        }

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $administrator_group_branch_id = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->put('branch') : $_SESSION['administrator_group_branch_id'];
            $administrator_group_type = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->put('type') : 'administrator_branch';

            $is_error = false;

            $this->db->trans_begin();

            try {

                $administrator_group_id = $this->put('administrator_group_id');
                $administrator_group_title = $this->put('title');

                $data = array();
                if ($administrator_group_id != $this->get_user('user_auth_group_id')) {
                    $administrator_group_company_id = 1;
                    $administrator_group_branch_id = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->put('branch') : $this->get_user('user_auth_branch_id');
                    $administrator_group_type = ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') ? $this->put('type') : 'administrator_branch';

                    $menu = $this->put('menu');
                    $action = $this->put('action');

                    $data['administrator_group_company_id'] = $administrator_group_company_id;
                    $data['administrator_group_branch_id'] = $administrator_group_branch_id;
                    if ($this->get_user('user_auth_type') == 'superuser' || $this->get_user('user_auth_type') == 'administrator_company') {
                        $data['administrator_group_type'] = $administrator_group_type;
                    }
                }

                $data['administrator_group_title'] = $administrator_group_title;

                $this->db->where('administrator_group_id', $administrator_group_id);
                $this->db->update('sys_administrator_group', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
                }

                if ($administrator_group_id != $this->get_user('user_auth_group_id')) {
                    //delete privilege
                    $this->db->delete('sys_administrator_privilege', array('administrator_privilege_administrator_group_id' => $administrator_group_id));

                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }

                    //add privilege
                    if (isset($menu)) {
                        foreach ($menu as $menu_id) {
                            $arr_action = array('show');
                            if (isset($action[$menu_id])) {
                                foreach ($action[$menu_id] as $action_name) {
                                    array_push($arr_action, $action_name);
                                }
                            }
                            $data = array();
                            $data['administrator_privilege_administrator_group_id'] = $administrator_group_id;
                            $data['administrator_privilege_administrator_menu_id'] = $menu_id;
                            $data['administrator_privilege_action'] = '{"results": ' . json_encode($arr_action) . '}';
                            $this->db->insert('sys_administrator_privilege', $data);

                            if ($this->db->affected_rows() < 0) {
                                $is_error = true;
                            }
                        }
                    }
                }
            } catch (Exception $ex) {
                $is_error = true;
            }

            if (!$is_error) {
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
                } else {
                    $this->db->trans_commit();
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil ubah data.');
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
            }
        }
    }

    public function act_delete_post()
    {
        $arr_item = json_decode($this->post('item'));
        if (is_array($arr_item)) {
            $success = $failed = 0;
            $str_my_group = "";
            foreach ($arr_item as $id) {

                if ($this->get_user('user_auth_group_id') != $id) {
                    $is_error = false;
                    $this->db->trans_begin();

                    //hapus privilege
                    $this->db->where('administrator_privilege_administrator_group_id', $id);
                    $this->db->delete('sys_administrator_privilege');

                    if ($this->db->affected_rows() < 0) {
                        $is_error = true;
                    }

                    //hapus data
                    $this->db->where('administrator_group_id', $id);
                    $this->db->delete('sys_administrator_group');

                    if ($this->db->affected_rows() < 0) {
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
                } else {
                    $str_my_group = ' Tidak dapat menghapus grup yang sedang digunakan.';
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dihapus. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dihapus.' . $str_my_group : ' ';

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
            $str_my_group = "";
            foreach ($arr_item as $id) {

                if ($this->get_user('user_auth_group_id') != $id) {

                    $is_error = false;
                    $is_change = true;

                    $this->db->trans_begin();

                    $data = array();
                    $data['administrator_group_is_active'] = '1';
                    $this->db->where('administrator_group_id', $id);
                    $this->db->update('sys_administrator_group', $data);

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
                } else {
                    $str_my_group = ' Tidak dapat mengaktifkan grup yang sedang digunakan.';
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil diaktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal diaktifkan.' . $str_my_group : '';

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
            $str_my_group = "";
            foreach ($arr_item as $id) {
                if ($this->get_user('user_auth_group_id') != $id) {
                    $is_error = false;
                    $is_change = true;

                    $this->db->trans_begin();

                    $data = array();
                    $data['administrator_group_is_active'] = '0';
                    $this->db->where('administrator_group_id', $id);
                    $this->db->update('sys_administrator_group', $data);

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
                } else {
                    $str_my_group = ' Tidak dapat menon-aktifkan grup yang sedang digunakan.';
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dinon-aktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dinon-aktifkan.' . $str_my_group : '';

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
}

/* End of file Group.php */
