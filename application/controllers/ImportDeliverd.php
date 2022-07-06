<?php
class ImportDeliverd extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonnewmodel');
    }


    public function index(){
    $this->load->view('importdeliverdView');		
    }



}