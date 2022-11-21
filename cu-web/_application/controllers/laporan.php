<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Laporan extends CI_Controller {
    public function __construct()
        {   
            parent::__construct();
            $this->load->library('Pdf');
        }
    public function undangan()
        {
            $data['nama']=$this->cetak_banyak();
            $this->load->view('undangan/undangan', $data);
        }
        public function absensi()
        {
            $data['nama'] = $this->cetak_banyak();
            $this->load->view('undangan/absensi', $data);
        }   

    public function cetak_banyak(){
              $data=array(
                          array('name'=> 'andi'),
                          array('name'=> 'joni'),
                          array('name'=> 'awak'),
                          array('name'=> 'entah'),
                          array('name'=> 'dateg'),
                          array('name'=> 'paja')
                    );
              $data=json_encode($data);
              $data=json_decode($data);
        return($data);
        }

}