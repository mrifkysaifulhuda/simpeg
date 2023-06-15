<?php

class Api extends CI_Controller {

    public function __construct()
        {
            parent::__construct();
            $this->load->model('cuti_pegawai_model');
            $this->load->model('surat_tugas_model');
           
            
        }

    public function signin() {

        $id = 374;
        $year = 2022;
        $month = 7;

        $response = $this->cuti_pegawai_model->get_list_cuti_pegawai_by_year_month($id, $year, $month);    

        $start_date = date("Y-m-d",mktime(0,0,0,$month,1,$year));
        $hari_cuti = array();

        foreach($response as $cuti){
            $days = $this->get_leave_days($cuti['tanggal_awal'],$cuti['tanggal_akhir'],  $start_date);
            $hari_cuti = array_merge($hari_cuti, $days);
        }
        var_dump($hari_cuti);

        die();
    
        header('Content-Type: application/json');
        echo json_encode( $arr );
    }

    public function get_days_cuti_and_surat_tugas(){

        $key = $this->getKey();
        $auth = $this->input->post('Authorization');

        if($key != $auth){
            header('Content-Type:application/json');
            echo json_encode("Unauthorized");
        } else{
            $id = $this->input->post('id');
            $year = $this->input->post('tahun');
            $month = $this->input->post('bulan');
    
            $response = $this->cuti_pegawai_model->get_list_cuti_pegawai_by_year_month($id, $year, $month);    
    
            $start_date = date("Y-m-d",mktime(0,0,0,$month,1,$year));
           
            $off_days = [
                "cuti" => array(),
                "surat_tugas" => array(),
            ];



            foreach($response as $cuti){
                $days = $this->get_leave_days($cuti['tanggal_awal'],$cuti['tanggal_akhir'],  $start_date);
                $off_days['cuti'] = array_merge($off_days['cuti'], $days);
            }

            $surat_tugas = $this->surat_tugas_model->get_list_surat_tugas_pegawai_by_year_month($id, $year, $month);


            foreach($surat_tugas as $st){
                $days = $this->get_leave_days($st['tanggal_awal'],$st['tanggal_akhir'], $start_date);
                $off_days['surat_tugas'] = array_merge($off_days['surat_tugas'], $days);
            }
    
            header('Content-Type:application/json');
            echo json_encode($off_days);
        }
    }

    private function get_leave_days($awal, $akhir, $date)
    {
        if($awal < $date){
            $start = $date;
        }else{
            $start = $awal;
        }
        
        $d = new DateTime($date); 
        $end_month =  $d->format('Y-m-t');

        if($akhir > $end_month){
            $end =  $end_month;
        }else{
            $end = $akhir;
        }
       
        $result = array();
        $end_plus_one = new DateTime($end);

        $period = new DatePeriod(
            new DateTime($start),
            new DateInterval('P1D'),
            $end_plus_one->modify('+1 day')
       );

       foreach ($period as $key => $value) {

        $curr = $value->format('D');

                // substract if Saturday or Sunday
        if ($curr != 'Sat' && $curr != 'Sun') {
            array_push($result,$value->format('Y-m-d'));
        }

       
        //       
        }

        return $result;

    }


    private function getKey()
    {
        return "my_application_secret";
    }


}