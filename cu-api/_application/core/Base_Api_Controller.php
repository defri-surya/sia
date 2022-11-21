<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Base Class for API Controller
 * @author Yuana <andhikayuana@gmail.com>
 * @since October, 4 2016
 */
class Base_Api_Controller extends REST_Controller {

    /**
     *  load Consts class, checkToken here
     */
    public function __construct() {

        parent::__construct();
        $this->load->model('consts');
        
    }

    /**
     * [createResponse]
     * @param  [type] $status [description]
     * @param  array  $data   [description]
     * @return [type]         [description]
     */
    public function createResponse($status = REST_Controller::HTTP_OK, $data = array()) {
        $this->set_response(array(
            'status' => $status,
            'msg' => Consts::$msgByCode[$status],
            'data' => $data
                ), $status);
    }

    /**
     * [unauthorized description]
     * @return [type] [description]
     */
    public function unauthorized() {

        header("Content-Type: application/json");
        header("HTTP/1.1 401 Unauthorized");
        header("WWW-Authenticate: Bearer realm=\"app\"");

        echo json_encode(array(
            "status" => REST_Controller::HTTP_UNAUTHORIZED,
            "msg" => Consts::$msgByCode[REST_Controller::HTTP_UNAUTHORIZED],
        ));

        exit;
    }

    public function error($httpCode, $msg = "Error", $data = array()) {

        header("Content-Type: application/json");
        header("HTTP/1.1 " . $httpCode . " " . Consts::$msgByCode[$httpCode]);

        if(empty($data)){
            echo json_encode(array(
                "status" => $httpCode,
                "msg" => $msg
            ));
        }else{
            echo json_encode(array(
                "status" => $httpCode,
                "msg" => $msg,
                "data" => $data,
            ));
        }

        exit;
    }

    /**
     * [getToken description]
     * @return [type] [description]
     */
    public function getHeaderToken() {

        $pattern = "/(^|&)(?P<token>[a-z0-9]+\\+[a-z0-9]+)/";

        $token = $this->input->get_request_header(Consts::ARG_TOKEN);

        if (preg_match($pattern, $token, $result)) {

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * [getUser]
     * @return [int] [user]
     */
    public function getUser() {

        $token = $this->getHeaderToken();

        if (!$token)
            $this->unauthorized();

        $user = $this->getTokenUser($token);

        if (empty($user)) {
            
            $this->unauthorized();
        } else {
            $userId = $user['user_auth_user_id'];
            $expiredTime = $user['user_auth_expired_datetime'];
            $expired = $this->checkTokenExpired($userId, $expiredTime);
            
            if ($expired) {
                $this->error(REST_Controller::HTTP_UNAUTHORIZED, "Token Expired");
            }
            // else{
            //     $type = $user['user_auth_type'];
            //     $group_id = $user['user_auth_group_id'];
            //     if(!$this->privilege_user($group_id, $type)){
            //         $this->error(REST_Controller::HTTP_FORBIDDEN, "Not Allowed Access");
            //     }
            // }
        }
            
        return $user;
    }
    
    public function getTokenUser($token) {

        $userArr = array();

        $sql = "
            SELECT 
            user_auth_user_id,
            user_auth_group_id,
            user_auth_branch_id,
            user_auth_type,
            user_auth_name,
            user_auth_username,
            user_auth_expired_datetime,
            user_auth_token
            FROM user_auth
            WHERE user_auth_token = '" . $token . "'
        ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $userArr = $query->row_array();
        }

        return $userArr;
    }

    /**
     * [generateToken description]
     * @param  [type] $userEmail [description]
     * @param  [type] $userIp    [description]
     * @return [type]            [description]
     */
    public function generateToken($userEmail, $userIp) {
        return sha1($userEmail . microtime()) . '+' . sha1(Consts::APP_NAME . microtime() . $userIp);
    }
    
    /**
     * [checkTokenExpired description]
     * @param  [type] $expiredTime [description]
     * @return [type]            [description]
     */
    private function checkTokenExpired($userId, $expiredTime) {

        $now = time();
        if ($now > $expiredTime) {
            
            $this->db->where('user_auth_user_id', $userId);
            $this->db->delete('user_auth');
            
            return true;
        } else {
            
            $extraTime = strtotime(TOKEN_TIMEOUT, $expiredTime);
            
            $update = array(
                'user_auth_expired_datetime' => $extraTime
            );
            
            $this->db->where('user_auth_user_id', $userId);
            $this->db->update('user_auth', $update);
            
            return false;
        }
    }


    function privilege_user($group_id, $group_type)
    {

        $actor = '';
        $controller = '';
        $action = '';
        $action_split = '';
        $uri_string = rtrim(uri_string(), "/");
        $arr_uri = explode('/', $uri_string);

        if (isset($arr_uri[1])) {
            $actor = $arr_uri[1];
        }
        if (isset($arr_uri[2])) {
            $controller = $arr_uri[2];
        }
        // cek apabila url ada action nya
        if (isset($arr_uri[3])) {
            $action = $arr_uri[3];

            // cek action berawalan act_
            if (startsWith($arr_uri[3], 'act_')) {
                $action_split = explode('_', $arr_uri[3]);
            }
        }

        $arr_uri_string_true = array(
            'profile',
            'profile/systems',
            'profile/systems/profile',
            'profile/systems/act_profile',
            'profile/systems/password',
            'dashboard/dashboard1',
        );

        $is_true = false;
        if ($group_type == 'superuser') {
            $is_true = true;
        } else {
            foreach ($arr_uri_string_true as $uri_string_true) {
                if (preg_match('/' . str_replace('/', '\/', rtrim($uri_string_true, "/")) . '$/', $uri_string)) {
                    $is_true = true;
                }
            }

            if (!$is_true) {
                $sql_administrator_privilege = "
                    SELECT sys_administrator_privilege.*, administrator_menu_id, administrator_menu_link, 
                    json_extract(administrator_privilege_action, '$.results') AS results 
                    FROM sys_administrator_privilege 
                    LEFT JOIN sys_administrator_menu ON administrator_menu_id = administrator_privilege_administrator_menu_id 
                    WHERE administrator_privilege_administrator_group_id = '" . $group_id . "' 
                ";
                $query_administrator_privilege = $this->CI->db->query($sql_administrator_privilege);
                if ($query_administrator_privilege->num_rows() > 0) {
                    $arr_menu[0] = array(
                        'menu_link' => 'backend/dashboard/show',
                        'action_name' => array('show'),
                    );
                    foreach ($query_administrator_privilege->result() as $row_administrator_privilege) {
                        if ($row_administrator_privilege->administrator_menu_link != '#') {
                            $arr_menu[$row_administrator_privilege->administrator_menu_id] = array(
                                'menu_link' => $row_administrator_privilege->administrator_menu_link,
                                'action_name' => (!empty($row_administrator_privilege->results) ? json_decode($row_administrator_privilege->results, true) : array()),
                            );
                        }
                    }
                }

                foreach ($arr_menu as $menu_id => $menu) {

                    $url_link = $actor . '/' . $controller;

                    if (strtolower($url_link) . '/show' == strtolower($menu['menu_link'])) {
                        // cek jika url ada tambahan action, kecuali action show atau berawalan get_ atau export_
                        if ($action == 'show' || startsWith($action, 'get_') || startsWith($action, 'export_')) {
                            $is_true = true;
                            break;
                        } else if (startsWith($action, 'act_')) { // cek apakah action berbentuk array hasil explode act_
                            if (isset($action_split)) {
                                // cek jika index array action name url ada di index array action name privilege
                                $menu['action_name'] = array_flip($menu['action_name']);
                                if (!empty($menu['action_name']) && isset($menu['action_name'][$action_split[1]])) {
                                    $is_true = true;
                                    break;
                                } else {
                                    $is_true = false;
                                }
                            }
                        } else {
                            $is_true = false;
                        }
                    } else {
                        $is_true = false;
                    }
                }
            }
        }
        return $is_true;
    }

}
