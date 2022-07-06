<?php

class Demanifest extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	$this->load->view('module_transit/demanifestView');	
	}
	
	public function manifest_summary(){
	$manifest 				= $this->input->post('manifest');    
	$result                 = 0;
	$result1                = 0;
	if($manifest!=""){
	$result                 =$this->Commonmodel->Manifest_Summary($manifest); 
	$result1                =$this->Commonmodel->Manifest_Unload_Summary($manifest);
	$result                 =$result1."/".$result;
	}
	echo $result;    
	}
	
	
	public function manifest_table($manifest){
	if($manifest!=""){	
	$cn_data=$this->Commonmodel->Manifest_Detail($manifest); 
	if(!empty($cn_data)){
	$i=0;    
	foreach($cn_data as $rows){
	$i=$i+1;    
	echo("<tr>");
	echo("<td>".$i."</td>");
	echo("<td>".$rows->transit_cn."</td>");
	echo("<td>".$rows->manual_cn."</td>");
	echo("<td>".$rows->unload_date."</td>");
	echo("<td>".$rows->Tdate."</td>");
	echo("</tr>");    
	}    
	}
	}
	}
	
	public function manifest_process(){
	$manifest 			= $this->input->post('manifest');
	$cn 				= $this->input->post('cn');
	$user_id            = $_SESSION['user_id'];
	$origin_id          = $_SESSION['origin_id'];
	$ip                 = $this->get_client_ip();
	$check_mani         = 0;
	if($manifest!="" && $cn!="" && $user_id!="" && $origin_id!=""){
	$check_mani=$this->Commonmodel->Manifest_check($manifest,$cn);
	if($check_mani>0){
    $order_data=$this->Commonmodel->Order_Code_AND_Anaul($cn);    
	if(!empty($order_data)){
	$this->db->trans_start();	    
	$is_final=$order_data[0]['is_final'];
	$order_status   =      $order_data[0]['order_status'];
	$order_id       =      $order_data[0]['order_id'];
	$order_code     =      $order_data[0]['order_code'];
	$is_final       =      $order_data[0]['is_final'];
	if($is_final==0){
	$data = array(
	'order_status' 			=>'DE Manifest',
	'is_unloading'   	    => 1,
	'unloading_id'          => $manifest,
	'modify_date'   		=> date('Y-m-d H:i:s'),
	'modify_by'             => $_SESSION['user_id']
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $order_code, $data);
	$id=$this->Commonmodel->Get_Transit_Detail_ID_By_CN_And_Transit($order_code,$manifest);
	$data = array(
	'is_unload' 		=> '1',
	'unload_date' 		=> date('Y-m-d H:i:s'),
	'unload_origin' 	=> $_SESSION['origin_id'],
	'modify_by'         => $_SESSION['user_id']);
	$this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_detail_id', $id, $data);	
    $city_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_id', $_SESSION['origin_id']);
	$origin_name=$city_data[0]['city_name']; 
	$data = array(
	'order_id' 				=> $order_id, 
	'order_event' 		 	=> 'DE Manifest', 
	'order_location' 	 	=> $_SESSION['origin_id'], 
	'order_location_name'	=> $origin_name, 
	'order_message' 	 	=> "Shipment Received At Station", 
	'order_ip'			 	=> $ip,
	'order_event_date'	 	=> date('Y-m-d H:i:s'),
	'created_by' 		 	=> $_SESSION['user_id'],  
	'created_date' 			=> date('Y-m-d H:i:s') );	
	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);	
	$this->db->trans_complete();
	} else {echo("<p class='alert alert-danger'>This CN is Not Eligiable For De Manifesting.</p>");}
	} else {echo("<p class='alert alert-danger'>This CN is not found.</p>");}
	} else {echo("<p class='alert alert-danger'>This CN is Not Eligiable For De Manifesting.</p>");}
	} else {echo("<p class='alert alert-danger'>Something Went Wrong.</p>");}    
	$this->manifest_table($manifest);
	}

	

	public function get_client_ip(){
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    }
	
}
