<?php

class Accounts extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Accountmodel');
    $this->load->model('Commonmodel');
	}
    
    
    public function index(){
    $data['start_date']="";
    $data['city']="";
    $data['expense_data']="";
    $data['cpay_data']="";
    $data['deposit_data']="";
    $data['actual_cod']="";
    $data['archive_actual_cod']="";
    $this->load->view('module_accounts/accountsView',$data);      
    }
    
    
    public function account_submit(){
    $start_date=$this->input->post('start_date');
    $city=$this->input->post('city');
    if($start_date!="" && $city!=""){
    $data['start_date']=$start_date;  
    $data['city']=$city;
    $data['expense_data']=      $this->Accountmodel->Get_Expense_By_Date($start_date,$city);
    $data['cpay_data']=         $this->Accountmodel->Get_Cpay_By_Date($start_date,$city);
    $data['deposit_data']=      $this->Accountmodel->Get_Deposit_By_Date($start_date,$city);
    $data['actual_cod']=        $this->Accountmodel->Get_COD_By_Date($start_date,$city);
    $data['archive_actual_cod']=$this->Accountmodel->Get_COD_By_Date_Archive($start_date,$city);
    $this->load->view('module_accounts/accountsView',$data);
    } else {
    $data['start_date']=$start_date;  
    $data['city']=$city;    
    $data['start_date']="";  
    $data['expense_data']="";
    $data['cpay_data']="";
    $data['deposit_data']="";
    $data['actual_cod']="";
    $this->load->view('module_accounts/accountsView',$data);}
    }
    
    
 }

?>