<?php
class Surat_tugas extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('pegawai_model');
        $this->load->model('surat_tugas_model');
        $this->load->model('surat_tugas_wizard_model');
        $this->load->model('M_Datatables');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->session->set_userdata('menu','daftar_surat_tugas');
        if(!$this->session->userdata('login')){
            redirect('Auth/login');
        }
    }

	public function index()
    { 
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('tanggal_awal', 'tanggal_awal', 'required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['surat_tugas'] = $this->surat_tugas_model->get_list_surat_tugas_pegawai();

            $this->load->view('templates/header', $data);
            $this->load->view('surat_tugas/index', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $ids = $this->input->post('id_pegawai');
            foreach( $ids as $id){
                $tanggal_awal= date("Y-m-d", strtotime($this->input->post('tanggal_awal')));

                if($this->input->post('tanggal_akhir') == ""){
                    $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_awal')));
                }else{
                    $tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggal_akhir')));
                }
                $list_surat_tugas = $this->surat_tugas_model->check_surat_tugas_overlap($id, $tanggal_awal, $tanggal_akhir);

                if (count($list_surat_tugas) === 0) {
                    $this->surat_tugas_model->set_surat_tugas_by_id($id);
               }else{
                   $data["error_messages"] = $list_surat_tugas[0]["nama"]." Telah memiliki Surat Tugas Pada Tanggal Tersebut";
               }
            }
            
            $data['surat_tugas'] = $this->surat_tugas_model->get_list_surat_tugas_pegawai();

            if($this->input->post('salin_pegawai') == 'salin_pegawai'){
                $_SESSION['id_pegawai'] = $this->input->post('id_pegawai');
            }else{
                unset($_SESSION['id_pegawai']);
            }
            $this->load->view('templates/header', $data);
            $this->load->view('surat_tugas/index', $data);
            $this->load->view('templates/footer');
        }
    }

    function post_create()
    {

        $wizard_id = $this->input->post('wizard_id');
        if($wizard_id != ""){
            $id = $this->surat_tugas_wizard_model->update_surat_tugas();
            $redirect = '/surat_tugas/view_wizard/'.$wizard_id;
            redirect($redirect, 'refresh');
        }else{
            $id = $this->surat_tugas_wizard_model->set_surat_tugas();
            $redirect = '/surat_tugas/view_wizard/'.$id;
            redirect($redirect, 'refresh');
        }
       
    }

    function get_list_pegawai()
    {
        $q = $this->input->get('q');
        echo json_encode($this->pegawai_model->get_list_pegawai($q));
    }

    function get_pegawai($id)
    {
        header('Content-Type: application/json');
        echo json_encode($this->pegawai_model->get_pegawai($id));
    }

    function get_list_pegawai_by_id()
    {
        if(isset($_SESSION['id_pegawai'])){
            $id_pegawai = $this->pegawai_model->get_list_pegawai_by_id($_SESSION['id_pegawai']);
            unset($_SESSION['id_pegawai']);
            header('Content-Type: application/json');
            echo json_encode($id_pegawai);
        }else{
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    public function view_wizard($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['wizard'] = $this->surat_tugas_wizard_model->get_surat_tugas_pegawai($id);

        $id_pejabat_ttd = $data['wizard']["id_pejabat_ttd"];
        $pejabat_ttd = $this->pegawai_model->get_list_pegawai_by_id($id_pejabat_ttd);
        if(count($pejabat_ttd) > 0){
            $data["pejabat_ttd"] = json_decode(json_encode($pejabat_ttd[0]), true);
        }

        
        $this->load->view('templates/header');
        $this->load->view('surat_tugas/create', $data);
        $this->load->view('templates/footer');
    }

    public function save_content()
    {
        $id = $this->input->post('surat_tugas_wizard_id');
        $content = $this->input->post('content');
        $this->surat_tugas_wizard_model->update_surat_tugas_content($id, $content);

        header('Content-Type: application/json');
        echo json_encode($this->input->post('surat_tugas_wizard_id'));
    }

    public function view_pdf($id)
    {
        $this->load->library('pdf');
        $wizard = $this->surat_tugas_wizard_model->get_surat_tugas_pegawai($id);
        $filename = "Document_name";

        $data["html_content"] = $wizard["konten"];
        $html = $this->load->view('temp_surat_tugas', $data, true);

        $dompdf = new Dompdf\DOMPDF();
        $options = new Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf->setOptions($options);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }

    public function create()
    {
        if(!$this->session->userdata('login')){
            redirect('Auth/login');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pegawai[]', 'id_pegawai', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header');
            $this->load->view('surat_tugas/create');
            $this->load->view('templates/footer');
        }else{
            $wizard_id = $this->input->post('wizard_id');
            if($wizard_id != ""){
                $id = $this->surat_tugas_wizard_model->update_surat_tugas();
                $redirect = '/surat_tugas/view_wizard/'.$wizard_id;
                redirect($redirect, 'refresh');
            }else{
                $id = $this->surat_tugas_wizard_model->set_surat_tugas();
                $redirect = '/surat_tugas/view_wizard/'.$id;
                redirect($redirect, 'refresh');
            }

        }
    }

    function view_data_where()
    {
        $tables = "view_surat_tugas";
        $search = array('nama');
        $where =  [
            "tahun_tanggal_awal" => $_POST['tahun'],
            "bulan_tanggal_awal" => $_POST['bulan'],
        ];
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
       
        echo $this->M_Datatables->get_tables_where($tables,$search,$where,$isWhere);
    }


    function get_list_pegawai_by_surat_tugas_id($id)
    {
        $surat_tugas_wizard = $this->surat_tugas_wizard_model->get_surat_tugas_pegawai($id);
        $id_pegawai = unserialize($surat_tugas_wizard["id_pegawai"]);
        $pegawai = $this->pegawai_model->get_list_pegawai_by_id($id_pegawai);

        header('Content-Type: application/json');
        echo json_encode($pegawai);
        
    }


}