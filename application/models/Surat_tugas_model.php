<?php
class Surat_tugas_model extends CI_Model {
	    public function __construct()
        {
                $this->load->database();
        }

        public function get_surat_tugas_pegawai($id = FALSE)
		{
		        if ($id === FALSE)
		        {
		                $query = $this->db->get('surat_tugas');
		                return $query->result_array();
		        }
		    

		        $query = $this->db->get_where('surat_tugas', array('id_pegawai' => $id));
		        return $query->result_array();
		}

		public function delete_surat_tugas($id)
		{
			return $this->db->delete('surat_tugas', array('id' => $id));
		}

		public function get_surat_tugas($id)
		{
		        $query = $this->db->get_where('surat_tugas', array('id' => $id));
		        return $query->row_array();
		}

		public function get_list_surat_tugas_pegawai_by_year_month($id, $year, $month)
		{	
		        $query = $this->db->where("(nakula_id = ".$id.") and (tahun_tanggal_awal <= ".$year.")\r\n" .
											"and (bulan_tanggal_awal <=".$month.") and (tahun_tanggal_akhir >= ".$year.")\r\n" .
											"and (bulan_tanggal_akhir >=".$month.")")->get('view_surat_tugas');
		        return $query->result_array();
		}

		public function check_surat_tugas_overlap($id_pegawai, $start, $end)
		{	
			
		        $query = $this->db->where("(id_pegawai = ".$id_pegawai.") \r\n".
											"and ('".$start."' <=tanggal_akhir) and ('".$end."' >= tanggal_awal)")->get('view_surat_tugas');
		        return $query->result_array();
		}
		

		public function set_surat_tugas()
		{
			if($this->input->post('tanggal_akhir') == ""){
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
			}else{
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
			}
			$data = array(
				'id_pegawai' => $this->input->post('id_pegawai'),
				'tanggal_awal' => date("Y-m-d", strtotime($this->input->post('tanggal_awal'))),
				'tanggal_akhir' =>$tanggal_akhir,
				'keterangan' => $this->input->post('keterangan')
			);

		    return $this->db->insert('surat_tugas', $data);
		}

		public function set_surat_tugas_by_id($id)
		{
			if($this->input->post('tanggal_akhir') == ""){
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
			}else{
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
			}
			
			$data = array(
				'id_pegawai' => $id,
				'tanggal_awal' => date("Y-m-d", strtotime($this->input->post('tanggal_awal'))),
				'tanggal_akhir' => $tanggal_akhir,
				'keterangan' => $this->input->post('keterangan')
			);

		    return $this->db->insert('surat_tugas', $data);
		}

		public function get_list_surat_tugas_pegawai()
		{
		    $query = $this->db->order_by('nama asc, tanggal_awal asc')->get('view_surat_tugas');
		    return $query->result_array();
		}
}