<?php
class Pegawai extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            $this->load->model('pegawai_model');
            $this->load->model('cuti_pegawai_model');
            $this->load->model('surat_tugas_model');
            $this->load->helper('url_helper');
            $this->load->library('session');
            $this->session->set_userdata('menu','dashboard');
        }

         public function index()
        { 
                if(!$this->session->userdata('login')){
                    redirect('Auth/login');
                }
        	
                $data['pegawai'] = $this->pegawai_model->get_pegawai();
                $data['title'] = 'News archive';
              
                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($id = NULL)
        {
                $data['pegawai_item'] = $this->pegawai_model->get_pegawai($id);

                if (empty($data['pegawai_item']))
                {
                        show_404();
                }

                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/view', $data);
                $this->load->view('templates/footer');
        }

         public function cuti($id = NULL)
        {
            if (empty($id))
            {
                show_404();
            }

            $data['in_valid'] = false;

            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Masukkan Cuti';
            $data['pegawai_item'] = $this->pegawai_model->get_pegawai($id);
            $data['cuti_pegawai'] = $this->cuti_pegawai_model->get_cuti_pegawai($id);

             $total_cuti = 0;
             $total_cuti_tahun_lalu = 0;
                foreach ($data['cuti_pegawai'] as $key => $value) {
                    if($value['status'] == STATUS_CUTI_DISETUJUI && $value['jenis'] == JENIS_CUTI_TAHUNAN){
                        $awal  = new DateTime($value["tanggal_awal"]);
                        $tahun_ini = date("Y");
                        $tahun = $awal->format("Y");
                        if($tahun_ini == $tahun ){
                             $total_cuti = $total_cuti + $value['lama'];
                        }
                        if((int)$tahun_ini - 1 == (int)$tahun ){
                             $total_cuti_tahun_lalu = $total_cuti_tahun_lalu + $value['lama'];
                        }
                    }   
                }

            $data['total_cuti'] = $total_cuti; 
            $data['total_cuti_tahun_lalu'] = $total_cuti_tahun_lalu; 
            $this->form_validation->set_rules('tanggal_awal', 'tanggal_awal', 'required');
            $this->form_validation->set_rules('tanggal_akhir', 'tanggal_akhir', 'required');
            $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/cuti', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $total_cuti = 0;
               
                $total_cuti = 0;
                $total_cuti_tahun_lalu = 0;
                foreach ($data['cuti_pegawai'] as $key => $value) {
                    if($value['status'] == STATUS_CUTI_DISETUJUI  && $value['jenis'] == JENIS_CUTI_TAHUNAN){
                        $awal  = new DateTime($value["tanggal_awal"]);
                        $tahun_ini = date("Y");
                        $tahun = $awal->format("Y");
                        if($tahun_ini == $tahun ){
                             $total_cuti = $total_cuti + $value['lama'];
                        }
                        if((int)$tahun_ini - 1 == (int)$tahun ){
                             $total_cuti_tahun_lalu = $total_cuti_tahun_lalu + $value['lama'];
                        }
                    }   
                }

                $lama = $this->cuti_pegawai_model->get_weekdays($this->input->post('tanggal_awal'), $this->input->post('tanggal_akhir'));

                if($total_cuti + $lama > 12 && $this->input->post('jenis_cuti') == "Cuti Tahunan"){
                    $data['in_valid'] = true;
                }else{
                     $this->cuti_pegawai_model->set_cuti_pegawai();
                 }
                $data['cuti_pegawai'] = $this->cuti_pegawai_model->get_cuti_pegawai($id);
                $data['total_cuti'] = $total_cuti; 
                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/cuti', $data);
                $this->load->view('templates/footer');

            }
        }

        public function surat_tugas($id = NULL)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            if (empty($id))
            {
                show_404();
            }

            $data['in_valid'] = false;
            $data['pegawai_item'] = $this->pegawai_model->get_pegawai($id);
            $data['surat_tugas_pegawai'] = $this->surat_tugas_model->get_surat_tugas_pegawai($id);

            $this->form_validation->set_rules('tanggal_awal', 'tanggal_awal', 'required');
          
            $this->form_validation->set_rules('keterangan', 'keterangan', 'required');


            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/surat_tugas', $data);  
                $this->load->view('templates/footer'); 
            }
            else
            {
                
                $tanggal_awal= date("Y-m-d", strtotime($this->input->post('tanggal_awal')));

                if($this->input->post('tanggal_akhir') == ""){
                    $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
                }else{
                    $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
                }
                $list_surat_tugas = $this->surat_tugas_model->check_surat_tugas_overlap($id, $tanggal_awal, $tanggal_akhir);

                if (count($list_surat_tugas) === 0) {
                    $this->surat_tugas_model->set_surat_tugas();
               }else{
                   $data["error_messages"] = $list_surat_tugas[0]["nama"]." Telah memiliki Surat Tugas Pada Tanggal Tersebut";
               }

                
                $data['surat_tugas_pegawai'] = $this->surat_tugas_model->get_surat_tugas_pegawai($id);
                $this->load->view('templates/header', $data);
                $this->load->view('pegawai/surat_tugas', $data);  
                $this->load->view('templates/footer'); 
             }
        }

        public function hapus_surat_tugas($id)
        {
            $surat_tugas = $this->surat_tugas_model->get_surat_tugas($id);
            $this->surat_tugas_model->delete_surat_tugas($id);
            redirect('pegawai/surat_tugas/'.$surat_tugas['id_pegawai']);
        }

        public function setujui($id)
        {
            $cuti_pegawai =  $this->cuti_pegawai_model->get_cuti_pegawai_by($id);
            $cuti_pegawai['status'] = STATUS_CUTI_DISETUJUI;
            $this->cuti_pegawai_model->update_cuti_pegawai($cuti_pegawai);
            redirect('pegawai/cuti/'.$cuti_pegawai['id_pegawai']);
        }

         public function tolak($id)
        {
            $cuti_pegawai =  $this->cuti_pegawai_model->get_cuti_pegawai_by($id);
            $cuti_pegawai['status'] = STATUS_CUTI_DITOLAK;
            $this->cuti_pegawai_model->update_cuti_pegawai($cuti_pegawai);
            redirect('pegawai/cuti/'.$cuti_pegawai['id_pegawai']);
        }


        public function laporan_pdf($id){
            
            $id = $this->input->post('cuti_id');
            $tembusan = explode(';',$this->input->post('tembusan_surat'));
            $tb = array();
            array_push($tb, "Rektor (sebagai laporan)");
            foreach ($tembusan as $key => $value) {
                array_push($tb, $value);
            }

            array_push($tb, "Koordinator Kepegawaian");
           
            $data['cuti'] =  $this->cuti_pegawai_model->get_cuti_pegawai_by($id);
            $data['pegawai'] = $this->pegawai_model->get_pegawai($data['cuti']['id_pegawai']);
            $data['tembusan'] = $tb;
            $data['penandatangan'] = $this->input->post('penandatangan');
            
            $this->load->library('pdf');
            $options = new Dompdf\Options();
            $options->setIsRemoteEnabled(true);

            $this->pdf->setOptions($options);
            $this->pdf->setPaper('A4', 'potrait');
            $this->pdf->filename = "surat_cuti.pdf";
            $this->pdf->load_view('laporan_pdf', $data);

        }


}