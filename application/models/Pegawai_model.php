<?php
class Pegawai_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_pegawai($id = FALSE)
		{
		        if ($id === FALSE)
		        {
					$query = $this->db->get('pegawai');
					return $query->result_array();
		        }
		        $query = $this->db->get_where('pegawai', array('id_pegawai' => $id));
		        return $query->row_array();
		}

		public function set_pegawai()
		{

		    $data = array(
		        'nama' => $this->input->post('nama'),
		        'tanggal_lahir' => $this->input->post('tanggal_lahir')
		    );

		    return $this->db->insert('pegawai', $data);
		}

		function auth_pegawai($username,$password){

        	$query = $this->db->get_where('pegawai', array('username' => $username, 'password' => $password));
		    return $query->row_array();
	    }

		function get_list_pegawai($str)
		{
			$this->db->select("id_pegawai as id, concat(nama,' - ',nip) as text");

			$query = $this->db->where("(`nama` LIKE '%".$str."%' ESCAPE '!' OR `nip` LIKE '%".$str."%' ESCAPE '!') AND `nakula_id` is not ")->get('pegawai');

			return $query->result();
		}

		function get_list_pegawai_by_id($id_pegawai)
		{
			$this->db->select("id_pegawai as id, concat(nama,' - ',nip) as text");

			$query = $this->db->where_in("id_pegawai", $id_pegawai)->get('pegawai');

			return $query->result();
		}
}