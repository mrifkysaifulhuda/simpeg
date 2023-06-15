<?php
class Cuti_pegawai_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->model('hari_libur_model');
        }

        public function get_cuti_pegawai($id = FALSE)
		{
		        if ($id === FALSE)
		        {
		                $query = $this->db->get('cuti_pegawai');
		                return $query->result_array();
		        }
		    

		        $query = $this->db->get_where('cuti_pegawai', array('id_pegawai' => $id));
		        return $query->result_array();
		}

		public function get_list_cuti_pegawai()
		{
		        $query = $this->db->order_by('id', 'desc')->get('view_cuti');
		        return $query->result_array();
		}


		public function get_list_cuti_pegawai_by_year_month($id, $year, $month)
		{	
		        $query = $this->db->where("(nakula_id = ".$id.") and (tahun_tanggal_awal <= ".$year.")\r\n" .
											"and (bulan_tanggal_awal <=".$month.") and (tahun_tanggal_akhir >= ".$year.")\r\n" .
											"and (bulan_tanggal_akhir >=".$month.")")->get('view_cuti');
		        return $query->result_array();
		}

		public function set_cuti_pegawai()
		{
			$lama = $this->get_weekdays(date("Y-m-d", strtotime($this->input->post('tanggal_awal'))),  date("Y-m-d", strtotime($this->input->post('tanggal_akhir'))));

		    $data = array(
		        'id_pegawai' => $this->input->post('id_pegawai'),
		        'tanggal_awal' => date("Y-m-d", strtotime($this->input->post('tanggal_awal'))),
		        'tanggal_akhir' =>date("Y-m-d", strtotime($this->input->post('tanggal_akhir'))),
		        'keterangan' => $this->input->post('keterangan'),
		        'status' => STATUS_CUTI_BARU,
		        'lama' => $lama,
				'jenis' => $this->input->post('jenis_cuti')
		    );

		    return $this->db->insert('cuti_pegawai', $data);
		}


		public function get_cuti_pegawai_by($id)
		{
		        if ($id === FALSE)
		        {
		                $query = $this->db->get('cuti_pegawai');
		                return $query->result_array();
		        }
		    

		        $query = $this->db->get_where('cuti_pegawai', array('id' => $id));
		        return $query->row_array();
		}


		public function update_cuti_pegawai($data)
		{
			
			$this->db->where('id', $data['id']);
			$this->db->update('cuti_pegawai', $data);
		}

		public function get_weekdays($st, $en){
            $start = new DateTime($st);
            $end = new DateTime($en);
            // otherwise the  end date is excluded (bug?)
            $end->modify('+1 day');

            $interval = $end->diff($start) ;

            // total days
            $days = $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

            // best stored as array, so you can add more than one
            $libur = $this->hari_libur_model->get_tanggal_libur();
            $holidays = array();
            foreach ($libur as $key => $value) {
            	array_push($holidays, $value['tanggal']);
            }
            

            foreach($period as $dt) {
                $curr = $dt->format('D');

                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }

                // (optional) for the updated question
                elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                    $days--;
                }
            }



            return $days; // 4
        }
}