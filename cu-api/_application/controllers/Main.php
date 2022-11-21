<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index() {
        // test
    }

    public function test_socket() {
        set_time_limit(0);
        $host = "127.0.0.1";
        $port = 25003;

        // create socket 
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

        // bind socket to port 
        $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
        while (true) {
            $execution_time = 0;
            $time_start = 0;
            $time_end = 0;
            
            // start listening for connections 
            $result = socket_listen($socket) or die("Could not set up socket listener\n");

            // accept incoming connections 
            // spawn another socket to handle communication 
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

            // read client input 
            $input = socket_read($spawn, 25003) or die("Could not read input\n");

            // clean up input string 
            $input = trim($input);

            $arr = json_decode($input);
            $time_start = microtime(true);
            $this->insert_netgrow($arr);
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);

            echo "Total Execution Time: " . $execution_time . " detik \n";
        }
        // close sockets 
        socket_close($spawn);
        socket_close($socket);
    }

    public function insert_netgrow($arr) {
        $this->load->database('test');
        for ($i = 1; $i <= 2000; $i++) {
            $input = array();
            $input['netgrow_mid'] = $arr->MID;
            $input['netgrow_name'] = $arr->name;
            $input['netgrow_position'] = $arr->position;

            $this->db->insert('netgrow', $input);
        }
    }

}
