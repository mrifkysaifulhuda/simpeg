<?php
class Hari_libur_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_hari_libur()
		{
 			$query = $this->db->get('hari_libur');
		    return $query->result_array();
		}

		public function get_tanggal_libur()
		{
 			$query = $this->db->select('tanggal')->get('hari_libur');
		    return $query->result_array();
		}

		public function set_hari_libur()
		{
		    $data = array(
		        'tanggal' => date("Y-m-d", strtotime($this->input->post('tanggal'))),
		        'keterangan' => $this->input->post('keterangan')
		    );
		    return $this->db->insert('hari_libur', $data);
		}
}