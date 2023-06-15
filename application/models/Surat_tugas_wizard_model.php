<?php
class Surat_tugas_wizard_model extends CI_Model {
    public function __construct()
    {
            $this->load->database();
    }

    public function get_surat_tugas_pegawai($id = FALSE)
    {
            if ($id === FALSE)
            {
                    $query = $this->db->get('surat_tugas_wizard');
                    return $query->result_array();
            }
        

            $query = $this->db->get_where('surat_tugas_wizard', array('surat_tugas_wizard_id' => $id));
            return $query->row_array();
    }

    public function set_surat_tugas()
		{
			if($this->input->post('tanggal_akhir') == ""){
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
			}else{
				$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
			}
			$data = array(
				'id_pegawai' => serialize($this->input->post('id_pegawai')),
				'tanggal_awal' => date("Y-m-d", strtotime($this->input->post('tanggal_awal'))),
				'tanggal_akhir' =>$tanggal_akhir,
				'id_pejabat_ttd' => $this->input->post('id_pejabat_ttd'),
                                'konten' => $this->input->post('editorHiddenArea'),
                                'judul' => $this->input->post('judul')
			);
            $this->db->insert('surat_tugas_wizard', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;

		}

        public function update_surat_tugas(){
                if($this->input->post('tanggal_akhir') == ""){
                        $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
                }else{
                        $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
                }
                $this->db->set('konten', $this->input->post('editorHiddenArea'));
                $this->db->set('id_pegawai', serialize($this->input->post('id_pegawai')));
                $this->db->set('tanggal_awal', date("Y-m-d", strtotime($this->input->post('tanggal_awal'))));
                $this->db->set('tanggal_akhir', $tanggal_akhir);
                $this->db->set('id_pejabat_ttd', $this->input->post('id_pejabat_ttd'));
                $this->db->set('judul', $this->input->post('judul'));
                $this->db->where('surat_tugas_wizard_id', $this->input->post('wizard_id'));
                return $this->db->update('surat_tugas_wizard');

        }

        public function update_surat_tugas_content($id, $content)
        {
                $this->db->set('konten', $content);
                $this->db->where('surat_tugas_wizard_id', $id);
                return $this->db->update('surat_tugas_wizard');
        }


}