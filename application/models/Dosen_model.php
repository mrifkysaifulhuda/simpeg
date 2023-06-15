<?php
class Dosen_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_dosen($id = FALSE)
		{
		        if ($id === FALSE)
		        {
		                $query = $this->db->get('dosen');
		                return $query->result_array();
		        }
		    

		        $query = $this->db->get_where('dosen', array('id' => $id));
		        return $query->row_array();
		}

		public function set_pegawai()
		{

		    $data = array(
		        'nama' => $this->input->post('nama'),
		        'tanggal_lahir' => $this->input->post('tanggal_lahir')
		    );

		    return $this->db->insert('dosen', $data);
		}
}