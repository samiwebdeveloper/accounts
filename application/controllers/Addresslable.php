<?php

class Dest_Rate extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Dest_ratemodel');
    $this->load->model('Commonmodel');
	}
    
 
    public function index(){
    $this->load->view('module_customer/dest_rateView',$data);
    }
    
 }

?>