<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    public function index()
    {
        $this->get_anggota();
    }


    private function get_anggota3month(){
        $date3month = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 3, date("d"), date("Y")));
        echo $date3month;
        $sql = "SELECT member_id, member_status, member_birthdate, member_nationality, member_is_diksar, member_entrance_fee_paid_off
            FROM sys_member
            WHERE member_registered_date <= $date3month AND member_status = 5
        ";
    }

    private function get_anggota6month(){
        $date6month = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 6, date("d"), date("Y")));
        echo $date6month;
        $sql = "SELECT member_id, member_status, member_birthdate, member_nationality, member_is_diksar, member_entrance_fee_paid_off
            FROM sys_member
            WHERE member_registered_date <= $date6month AND member_status = 4
        ";
    }

}

/* End of file Member.php */
