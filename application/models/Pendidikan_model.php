<?php
class Pendidikan_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_pendidikan($id)
		{
		       
		    

		        $query = $this->db->get_where('pendidikan', array('id_pegawai' => $id));
		        return $query->result_array();
		}

		
}