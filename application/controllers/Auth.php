<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {  
	
	public function __construct(){    
		parent::__construct();  
		$this->load->helper('url_helper');  
		$this->load->model('user_model');  
        $this->load->model('pegawai_model');
	}

	public function index(){   
	   if($this->session->userdata('authenticated')){
	   	redirect('page/welcome');
	   }   
	  	redirect('Auth/login');
	}

	public function login(){

           $this->load->view('login');     
	}

	function submit(){
        $username=htmlspecialchars($this->input->post('username',TRUE),ENT_QUOTES);
        $password=htmlspecialchars($this->input->post('password',TRUE),ENT_QUOTES);
 
        $cek_user=$this->user_model->auth_user($username,$password);
 
        if(!empty($cek_user) > 0){ 
            $this->session->set_userdata('login',TRUE);
            $this->session->set_userdata('akses',1);
            $this->session->set_userdata('level',$cek_user['level']);
            
            redirect('pegawai');
 
        }

        $pegawai=$this->pegawai_model->auth_pegawai($username,$password);

        if(!empty($pegawai)){ 
        $this->session->set_userdata('login',TRUE);
        $this->session->set_userdata('user_role','user');
          $this->session->set_userdata('level',2);
        $this->session->set_userdata('id_pegawai',$pegawai['id_pegawai']);
      
        
        redirect('pegawai/'.$pegawai['id_pegawai']);

            

        }else{
            $url=base_url();
            $this->session->set_userdata('msg','Username Atau Password Salah');
            redirect($url);
        }

           

        
        
        
 
    }
 
    function logout(){
        $this->session->sess_destroy();
        $url=base_url('');
        redirect($url);
    }

}