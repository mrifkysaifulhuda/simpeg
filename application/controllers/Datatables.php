<?php

    class Datatables extends CI_Controller
    {
        public function __construct()
        {  
            parent::__construct();
            $this->load->model('M_Datatables');
        }

        function view_data()
        {
            $tables = "artikel";
            $search = array('judul','kategori','penulis','tgl_posting');
            // jika memakai IS NULL pada where sql
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables($tables,$search,$isWhere);
        }

        function view_data_where()
        {
            $tables = "view_pegawai";
            $search = array('nama','nip');
            //$where  = array('kategori' => 'php');
            // jika memakai IS NULL pada where sql
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_where($tables,$search,$where,$isWhere);
        }

        function view_data_query()
        {
            $tables = "pegawai";
            $search = array('nama','nip');
           
           
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables($tables,$search,$isWhere);;
        }
    }
?>