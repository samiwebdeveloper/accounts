<?php

class Pendingpickup extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Qsrmodel');
    }


	public function index(){
	$data['pendingpickup_data']=$this->Qsrmodel->Get_Pending_Pickups($_SESSION['origin_id']);
	$this->load->view('pendingpickupView',$data);	
	}
	

   
    

}
