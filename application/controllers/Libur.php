<?php
class Libur extends CI_Controller {

	public function __construct()
        {
            parent::__construct();
            
            $this->load->model('hari_libur_model');
            $this->load->helper('url_helper');
            $this->load->library('session');
            $this->session->set_userdata('menu','hari_libur');
            $this->session->set_userdata('menu','libur');
        }

	  public function index()
        { 
                
                if(!$this->session->userdata('login')){
                    redirect('Auth/login');
                }
        	
                $data['libur'] = $this->hari_libur_model->get_hari_libur();
                
                $this->load->helper('form');
                $this->load->library('form_validation');
                
                $this->load->view('templates/header', $data);
                $this->load->view('libur/index', $data);
                $this->load->view('templates/footer');
        }


        public function tambah()
        {
             $this->hari_libur_model->set_hari_libur();

             redirect('libur');
        }

}