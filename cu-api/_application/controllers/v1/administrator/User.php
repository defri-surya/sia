<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Auth_Api_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_data_get()
    {
        $limit = (integer)$this->get('limit') <= 0 ? 10 : (integer)$this->get('limit');
        $page = (integer)$this->get('page') <= 0 ? 1 : (integer)$this->get('page');
        $filter = (array)$this->get('filter');
        $sort = (string)$this->get('sort');
        $dir = strtoupper($this->get('dir'));
        if ($dir != 'ASC' && $dir != 'DESC') {
            $dir = 'ASC';
        }

        $start = ($page - 1) * $limit;

        $results = $this->get_administrator($start, $limit, $sort, $dir, $filter);
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

    public function get_detail_get()
    {
        $id = $this->get('id');

        if (!empty($id) && is_numeric($id)) {

            $sql = "
                SELECT 
                    administrator_id,
                    administrator_username,
                    administrator_name,
                    administrator_email,
                    administrator_mobilephone,
                    administrator_image,
                    administrator_image_path,
                    administrator_is_active,
                    administrator_last_login,
                    administrator_group_id,
                    administrator_group_company_id,
                    administrator_group_branch_id,
                    administrator_group_title,
                    administrator_group_type,
                    administrator_group_is_active
                FROM sys_administrator
                INNER JOIN sys_administrator_group ON administrator_group_id = administrator_administrator_group_id
                WHERE administrator_id = " . $id . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $data = array_map("convertNullToString", $query->row_array());
                $this->createResponse(REST_Controller::HTTP_OK, $data);
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Admin.');
            }
        } else {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal mendapatkan detail Admin.');
        }
    }

    public function act_add_post()
    {
        $this->form_validation->set_rules('administrator_group_id', '<b>Grup</b>', 'required');
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required|min_length[6]|max_length[15]|unique[sys_administrator.administrator_username]');
        $this->form_validation->set_rules('password', '<b>Password</b>', 'required|min_length[6]|max_length[12]|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama User</b>', 'required');
        $this->form_validation->set_rules('email', '<b>Email</b>', 'valid_email');
        $this->form_validation->set_rules('mobilephone', '<b>Nomor Handphone</b>', 'required|numeric');

        if ($this->form_validation->run($this) == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                
                $error_upload_msg = $this->post('error_upload_msg');
                        
                $administrator_group_id = $this->post('administrator_group_id');
                $administrator_username = $this->post('username');
                $administrator_password = $this->post('password');
                $administrator_name = $this->post('name');
                $administrator_email = $this->post('email');
                $administrator_mobilephone = $this->post('mobilephone');
                $administrator_image = $this->post('image');
                $administrator_image_path = $this->post('image_path');

                $data = array();
                $data['administrator_administrator_group_id'] = $administrator_group_id;
                $data['administrator_username'] = $administrator_username;
                $data['administrator_password'] = password_hash($administrator_password, PASSWORD_DEFAULT);
                $data['administrator_name'] = $administrator_name;
                $data['administrator_email'] = $administrator_email;
                $data['administrator_mobilephone'] = $administrator_mobilephone;
                $data['administrator_is_active'] = 1;
                $data['administrator_image'] = $administrator_image;
                $data['administrator_image_path'] = $administrator_image_path;

                $this->db->insert('sys_administrator', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
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
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil tambah data. ' . $error_upload_msg);
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
            'administrator_group_id' => $this->put('administrator_group_id'),
            'name' => $this->put('name'),
            'username' => $this->put('username'),
            'email' => $this->put('email'),
            'mobilephone' => $this->put('mobilephone')
        );

        $this->form_validation->set_data($set_data);

        if ($this->get_user('user_auth_group_id') != $this->put('id')) {
            $this->form_validation->set_rules('administrator_group_id', '<b>Grup</b>', 'required');
        }
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required|min_length[6]|max_length[15]|unique[sys_administrator.administrator_username.administrator_id.' . $this->put('id') . ']');
        $this->form_validation->set_rules('name', '<b>Nama User</b>', 'required');
        $this->form_validation->set_rules('email', '<b>Email</b>', 'valid_email');
        $this->form_validation->set_rules('mobilephone', '<b>Nomor Handphone</b>', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {

            $is_error = false;

            $this->db->trans_begin();

            try {
                
                $error_upload_msg = $this->post('error_upload_msg');
                
                $administrator_id = $this->put('id');
                $administrator_group_id = $this->put('administrator_group_id');
                $administrator_username = $this->put('username');
                $administrator_name = $this->put('name');
                $administrator_email = $this->put('email');
                $administrator_mobilephone = $this->put('mobilephone');
                $administrator_image = $this->put('image');
                $administrator_image_path = $this->put('image_path');

                $data = array();
                if ($this->get_user('user_auth_group_id') != $this->put('id')) {
                    $data['administrator_administrator_group_id'] = $administrator_group_id;
                }

                $data['administrator_username'] = $administrator_username;
                $data['administrator_name'] = $administrator_name;
                $data['administrator_email'] = $administrator_email;
                $data['administrator_mobilephone'] = $administrator_mobilephone;
                $data['administrator_image'] = $administrator_image;
                $data['administrator_image_path'] = $administrator_image_path;

                $this->db->where('administrator_id', $administrator_id);
                $this->db->update('sys_administrator', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = true;
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
                    $this->createResponse(REST_Controller::HTTP_OK, 'Berhasil ubah data. ' . $error_upload_msg);
                }
            } else {
                $this->db->trans_rollback();
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal ubah data! Silahkan coba lagi.');
            }
        }
    }
    
    public function act_update_password_put()
    {
        $set_data = array(
            'id' => $this->put('id'),
            'password' => $this->put('password'),
            'password_conf' => $this->put('password_conf'),
        );
        
        $this->form_validation->set_data($set_data);
        
        $this->form_validation->set_rules('id', '<b>User</b>', 'required');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|min_length[6]|max_length[12]|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');
        
        if ($this->form_validation->run() == false) {
            $this->error(REST_Controller::HTTP_BAD_REQUEST, validation_errors());
        } else {
            $is_error = false;

            $this->db->trans_begin();

            try {
                
                $administrator_id = $this->put('id');
                $administrator_password = $this->put('password');

                $data = array();
                $pass_hash = password_hash($administrator_password, PASSWORD_DEFAULT);
                $data['administrator_password'] = $pass_hash;

                $this->db->where('administrator_id', $administrator_id);
                $this->db->update('sys_administrator', $data);

                if ($this->db->affected_rows() < 0) {
                    $is_error = TRUE;
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
        if ($this->get_user('user_auth_type') == 'superuser') {

            $arr_item = json_decode($this->post('item'));
            if (is_array($arr_item)) {
                $success = $failed = 0;
                $str_my = "";
                foreach ($arr_item as $id) {
                    if ($this->get_user('user_auth_group_id') != $id) {
                        $is_error = false;
                        $this->db->trans_begin();

                        //hapus data
                        $this->db->where('administrator_id', $id);
                        $this->db->delete('sys_administrator');

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
                    }else{
                        $str_my = " Tidak dapat menghapus user yang sedang digunakan.";
                        $failed++;
                    }
                }

                $str_success = ($success > 0) ? $success . ' data berhasil dihapus. ' : '';
                $str_failed = ($failed > 0) ? $failed . ' data gagal dihapus.' . $str_my : '';

                $message = $str_success . $str_failed;
                if ($failed > 0) {
                    $this->error(REST_Controller::HTTP_BAD_REQUEST, $message);
                } else {
                    $this->createResponse(REST_Controller::HTTP_OK, $message);
                }
            } else {
                $this->error(REST_Controller::HTTP_BAD_REQUEST, 'Gagal hapus data! Silahkan coba lagi.');
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
            $str_my = "";
            foreach ($arr_item as $id) {
                if ($this->get_user('user_auth_group_id') != $id) {
                    $is_error = false;
                    $is_change = true;

                    $this->db->trans_begin();

                    $data = array();
                    $data['administrator_is_active'] = '1';
                    $this->db->where('administrator_id', $id);
                    $this->db->update('sys_administrator', $data);

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
                }else{
                    $str_my = " Tidak dapat mengaktifkan user yang sedang digunakan.";
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil diaktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal diaktifkan.' . $str_my : '';

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
            $str_my = "";
            foreach ($arr_item as $id) {
                if ($this->get_user('user_auth_group_id') != $id) {
                    $is_error = false;
                    $is_change = true;

                    $this->db->trans_begin();

                    $data = array();
                    $data['administrator_is_active'] = '0';
                    $this->db->where('administrator_id', $id);
                    $this->db->update('sys_administrator', $data);

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
                }else{
                    $str_my = " Tidak dapat menon-aktifkan user yang sedang digunakan.";
                    $failed++;
                }
            }

            $str_success = ($success > 0) ? $success . ' data berhasil dinon-aktifkan. ' : '';
            $str_no_change = ($no_change > 0) ? $no_change . ' data tidak berubah. ' : '';
            $str_failed = ($failed > 0) ? $failed . ' data gagal dinon-aktifkan.' . $str_my : '';

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

    private function get_administrator($start, $limit, $sort, $dir, $filter = null)
    {
        $query_search = '';
        $result_arr = array();

        $arr_field_search = array(
            'administrator_id',
            'administrator_username',
            'administrator_name',
            'administrator_email',
            'administrator_mobilephone',
            'administrator_image',
            'administrator_image_path',
            'administrator_is_active',
            'administrator_last_login',
            'administrator_group_id',
            'administrator_group_company_id',
            'administrator_group_branch_id',
            'administrator_group_title',
            'administrator_group_type',
            'administrator_group_is_active',
        );

        if (is_array($filter)) {
            $query_search = search_input($filter, $arr_field_search);
        }

        if (!in_array($sort, $arr_field_search)) {
            $sort = 'administrator_id';
        }

        $where_detail = '0=0';
        if ($this->get_user('user_auth_type') != 'superuser') {
            $where_detail = " administrator_group_type != 'superuser'";
        }

        $str_field_search = empty($arr_field_search) ? '*' : implode(',', $arr_field_search);

        $sql_get = "
            SELECT
            $str_field_search
            FROM sys_administrator
            INNER JOIN sys_administrator_group ON administrator_group_id = administrator_administrator_group_id
            WHERE $where_detail
            $query_search
            ORDER BY $sort $dir
            LIMIT $start, $limit
        ";
        $result = $this->db->query($sql_get);

        $result_arr['count'] = $this->count_administrator($where_detail, $query_search);

        $result_arr['data'] = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $result_arr['data'][] = array_map("convertNullToString", $row);
            }
        }
        return $result_arr;
    }

    private function count_administrator($where_detail, $query_search = '')
    {
        $total = 0;

        $sql_total = "
            SELECT COUNT(administrator_id) as total
            FROM sys_administrator
            INNER JOIN sys_administrator_group ON administrator_group_id = administrator_administrator_group_id
            WHERE $where_detail
            $query_search
        ";

        $query_total = $this->db->query($sql_total);

        if ($query_total->num_rows() > 0) {
            $row_total = $query_total->row();
            $total = $row_total->total;
        }
        return $total;
    }

}

/* End of file User.php */
