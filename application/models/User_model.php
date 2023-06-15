<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }


        function auth_user($username,$password){

        	$query = $this->db->get_where('user', array('username' => $username, 'password' => MD5($password)));
		    return $query->row_array();
	    }
}