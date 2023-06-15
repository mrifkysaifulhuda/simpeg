<?php
class Dosen extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            $this->load->model('dosen_model');
            $this->load->model('pendidikan_model');
            $this->load->helper('url_helper');
            $this->load->library('session');
        }

        public function index()
        { 
                if(!$this->session->userdata('login')){
                    redirect('Auth/login');
                }
        	
                $data['dosen'] = $this->dosen_model->get_dosen();
                $data['title'] = 'News archive';
              
                $this->load->view('templates/header', $data);
                $this->load->view('dosen/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($id = NULL)
        {
                $data['dosen'] = $this->dosen_model->get_dosen($id);

                if (empty($data['dosen']))
                {
                        show_404();
                }

                $this->load->view('templates/header', $data);
                $this->load->view('dosen/view', $data);
                $this->load->view('templates/footer');
        }

         public function pendidikan($id = NULL)
        {

            if (empty($id))
            {
                show_404();
            }

            $data['dosen'] = $this->dosen_model->get_dosen($id);
            $data['pendidikan'] = $this->pendidikan_model->get_pendidikan($id);
          
              
            $this->load->view('templates/header', $data);
            $this->load->view('dosen/pendidikan', $data);
            $this->load->view('templates/footer');

            
        }

}