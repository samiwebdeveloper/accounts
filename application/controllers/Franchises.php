<?php

class  Franchises extends CI_Controller {

 	function __construct() {
     parent::__construct();
     date_default_timezone_set('Asia/Karachi');
     
     }


    public function index()
    {
        $enddate=date('Y-m-d');
        $startdate=date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
        $data['startdate']=$startdate;
        $data['enddate']=$enddate;
       
        $this->load->view('module_Franchise/fp.php',$data);	
    }
    
    public function v2()
    {
        $enddate=date('Y-m-d');
        $startdate=date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
        $data['startdate']=$startdate;
        $data['enddate']=$enddate;
       
        $this->load->view('module_Franchise/fp2.php',$data);	
    }
	
    
}