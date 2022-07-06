<?php

class Pickup extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Pickupmodel');
    }


	public function index(){
	$data['sub_nav_active']="Manage";
	$data['nav_active']="Pickup";	
	$data['event_name']="Request";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['pickup_request_data']=$this->Pickupmodel->Get_Pickup_Data_By_Date_Range($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_pickup/pickupView',$data);	
	}
	
	public function date_range(){
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['pickup_request_data']=$this->Pickupmodel->Get_Pickup_Data_By_Date_Range($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_pickup/pickupView',$data);	
	}
	
	
	public function create_pickup_sheet_view(){
	$data['pickup_data']=$this->Pickupmodel->Get_Newly_Enter_Pickup_Request($_SESSION['user_id']);    
	$data['customer_data']=$this->Commonmodel->Get_record_by_condition('saimtech_customer', 'is_enable', 1);   
	$this->load->view('module_pickup/pickupcreateView',$data);    
	}
	
	public function add_pickup_request(){
	$date=date('Y-m-d');
	$customer=$this->input->post('customer');
    $remark=$this->input->post('remark');
    $address=$this->input->post('address');
    $time=$this->input->post('time');
    if($customer!="" && $address!="" && $time!=""){
    $data = array(
    'customer_id'           =>$customer,
    'pickup_time'           =>$time,
    'pickup_date'           =>date('Y-m-d'),
    'pickup_address'        =>$address,
    'pickup_remark'         =>$remark,
    'origin_id'             =>$_SESSION['origin_id'],
    'created_by'            =>$_SESSION['user_id'],
    'created_date'          =>date('Y-m-d H:i:s'), 
    'modify_by'             =>0,
    'modify_date'           =>'0000-00-00 00:00:00');
    $pickup_id=$this->Commonmodel->Insert_record('saimtech_pickup_request', $data);	
    }
    $this->redraw_table();
	}
	
	public function remove($id){
	if($id!=""){
	$id=$this->Commonmodel->Delete_record('saimtech_pickup_request', 'pickup_request_id', $id);    
	$this->redraw_table();
	}    
	}
	
	public function redraw_table(){
	$pickup_data=$this->Pickupmodel->Get_Newly_Enter_Pickup_Request($_SESSION['user_id']);
	if(!empty($pickup_data)){$i=0;   
    foreach($pickup_data as $rows){
    $i=$i+1;    
  //  INSERT INTO `saimtech_pickup_request`(`pickup_request_id`, `customer_id`, `pickup_time`, `pickup_date`, `pickup_address`, `pickup_remark`, `origin_id`, `created_by`, `created_date`, `modify_by`, `modify_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11])
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->customer_name."</td>");
    echo("<td>".$rows->pickup_time." - ".$rows->pickup_date."</td>");
    echo("<td>".$rows->pickup_address."</td>");
    echo("<td>".$rows->pickup_remark."</td>");
    echo("<td><button class='btn btn-danger btn-xs' onclick='remove(".$rows->pickup_request_id.")'>Remove</button></td>");  
    echo("</tr>"); }}  
	}


}