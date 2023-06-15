<?php
class Cuti extends CI_Controller {

	public function __construct()
        {
            parent::__construct();
            $this->load->model('pegawai_model');
            $this->load->model('cuti_pegawai_model');
            $this->load->helper('url_helper');
            $this->load->library('session');
            $this->session->set_userdata('menu','daftar_cuti');
        }

	  public function index()
        { 
                
                if(!$this->session->userdata('login')){
                    redirect('Auth/login');
                }
        	
                $data['cuti'] = $this->cuti_pegawai_model->get_list_cuti_pegawai();
                $data['title'] = 'News archive';
                
                $this->load->view('templates/header', $data);
                $this->load->view('cuti/index', $data);
                $this->load->view('templates/footer');
        }

}