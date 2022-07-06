<?php

class Delivery extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Ccommonmodel');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	//echo($_SESSION['origin_id']);	
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Delivery";	
	$data['event_name']="Delivery";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	if($_SESSION['user_power']!="TP"){
	$data['delivery_sheets']=$this->Deliverymodel->Get_Delivery_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	} else {
	$data['delivery_sheets']=$this->Deliverymodel->Get_Delivery_Sheets_By_User($_SESSION['user_id'],$startdate,$enddate);
	}
	$this->load->view('module_delivery1/deliveryView',$data);	
	}
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Delivery";	
	$data['event_name']="Delivery";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	if($_SESSION['user_power']!="TP"){
	$delivery_sheets=$this->Deliverymodel->Get_Delivery_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$delivery_sheet_archive=$this->Deliverymodel->Get_Delivery_Sheets_By_Origin_Archive($_SESSION['origin_id'],$startdate,$enddate);
	} else {
	$delivery_sheets=$this->Deliverymodel->Get_Delivery_Sheets_By_User($_SESSION['user_id'],$startdate,$enddate);
	$delivery_sheet_archive=$this->Deliverymodel->Get_Delivery_Sheets_By_User_Archive($_SESSION['user_id'],$startdate,$enddate);	    
    }	    
	$data['delivery_sheets']=array_merge($delivery_sheets,$delivery_sheet_archive);
	$this->load->view('module_delivery1/deliveryView',$data);	
	}
	
	
	public function create_delivery_sheet_view(){
	$data['delivery_sheet_code']="";
	$data['delivery_sheet_data']="";
	$data['delivery_rider_id'] 	="";
	$data['delivery_rider_code']="";
	$data['delivery_rider_name']="";
	$data['delivery_route_id'] 	="";
	$data['delivery_route_code']="";
	$data['delivery_route_name']="";
	$origin_id=$_SESSION['origin_id'];
	$delivery_id=0;
	$data['rider_data']=$this->Commonmodel->Get_record_by_triple_condition_non('saimtech_rider', 'agent_id', 0, 'is_enable', 1, 'rider_origin_id',$_SESSION['origin_id']);	
	$data['route_data']=$this->Commonmodel->Get_record_by_triple_condition_non('saimtech_route', 'agent_id', 0, 'is_enable', 1, 'route_origin',$_SESSION['origin_id']);	
	$check=$this->Deliverymodel->Get_Incomplete_Delivery_Sheet_Count($_SESSION['user_id']);	
	if($check>0){
	$sheet_detail=$this->Deliverymodel->Get_Incomplete_Delivery_Sheet($_SESSION['user_id']);	
	$data['delivery_sheet_code']=$sheet_detail[0]['sheetcode'];
	$data['delivery_rider_id']=$sheet_detail[0]['riderid'];
	$data['delivery_rider_code']=$sheet_detail[0]['rider_code'];
	$data['delivery_rider_name']=$sheet_detail[0]['rider_name'];
	$data['delivery_route_id']=$sheet_detail[0]['routeid'];
	$data['delivery_route_code']=$sheet_detail[0]['route_code'];
	$data['delivery_route_name']=$sheet_detail[0]['route_name'];
	
	$data['delivery_sheet_data']=$this->Deliverymodel->Get_Delivery_Sheet_By_Code($sheet_detail[0]['sheetcode']);
	} else {
	$data['delivery_sheet_code']=$this->get_delivery_sheet_code();
	$data['delivery_sheet_data']="";
	}	
	$this->load->view('module_delivery1/deliverycreateView',$data);	
	}

	public function delivery_process(){
	$cn 				= $this->input->post('cn');
	$date 				= date('Y-m-d H:i:s');
	$rider 				= $this->input->post('rider');
	$route 				= $this->input->post('route');
	$delivery_sheet_code= $this->input->post('delivery_sheet_code');
	$origin 			= $_SESSION['origin_id'];
	$order_status		= "";
	$ip 				= $this->get_client_ip();
	$order_weight		= "";
	$order_name			= "";
	$order_phone		= "";
	$order_address		= "";
	$order_cod			= "";
	$is_final			= "";
	$delivery_attempt	= "";
	$destination_city	= "";
	$destination_reporting= "";
	$origin_city		= "";
	$is_debagging		= "";
	$order_id 			= "";
    $cn_check 			= $this->Deliverymodel->Check_CN($cn);
    $sheet_check 		= $this->Deliverymodel->Check_Delivery_Sheet_Code($delivery_sheet_code);
	//-----------------------------------------
	if($cn_check>0){	
	 if($cn!="" && $date!="" && $rider!="" && $delivery_sheet_code!="" && $origin!="" && $route!=""){
	    $rider_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_rider', 'rider_id', $rider); 
		$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
		//$sheet_check=$this->Arrivalmodel->Check_Arrival_Sheet_Code($arrival_sheet_code);
		$order_status		    = $order_detail[0]['order_status'];
		$cn		                = $order_detail[0]['order_code'];
		$order_weight		    = $order_detail[0]['weight'];
		$order_name			    = $order_detail[0]['consignee_name'];
		$order_phone		    = $order_detail[0]['consignee_mobile'];
		$order_address		    = $order_detail[0]['consignee_address'];
		$order_cod			    = $order_detail[0]['cod_amount'];
		$is_final			    = $order_detail[0]['is_final'];
		$delivery_attempt	    = $order_detail[0]['delivery_attempt'];
		$destination_city	    = $order_detail[0]['destination_city'];
		$destination_reporting	= $order_detail[0]['destination_reporting'];
		$origin_city		    = $order_detail[0]['origin_city'];
		$is_debagging		    = $order_detail[0]['is_debagging'];
		$order_id 			    = $order_detail[0]['order_id'];
		//------------------------------------
		
		if($order_status=="Arrival" && 	$_SESSION['reporting_orign_id']==$destination_reporting){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'On Route',
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> $delivery_sheet_code,
		 'delivery_attempt'		=> (($delivery_attempt)+1),
		 'modify_by'		    => $_SESSION['user_id'],
	     'modify_date'		    => date('Y-m-d H:i:s')
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name']; 
		 $order_message="Shipment Has On Route For Delivery ".$delivery_sheet_code." (".$rider_data[0]['rider_code']."-".$rider_data[0]['rider_name'].")";
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'On Route', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 //Insert into Delivery_List
		 if($sheet_check<1){
		 $data = array(
		 'rider_id'  				=> $rider, 
		 'route_id' 				=> $route, 
		 'delivery_code'  			=> $delivery_sheet_code,
		 'delivery_origin' 			=> $origin, 
		 'delivery_date'  			=> $date, 
		 'is_delivery_complete'  	=> 0, 
		 'ip' 						=> $ip,
		 'delivery_created_by' 		=> $_SESSION['user_id']
		 );	
		 $delivery_list_id=$this->Commonmodel->Insert_record('saimtech_delivery_list', $data);
		 } else {
		 $delivery_data=$this->Deliverymodel->Get_Delivery_Status_By_Code($delivery_sheet_code);	
		 $delivery_list_id=$delivery_data[0]['delivery_list_id'];
		 }
		 //Insert into Delivery_Detail
		 $data = array(
		 'delivery_list_id'			=> $delivery_list_id, 
		 'order_code'				=> $cn, 
		 'order_detail_id'			=> $detail_id, 
		 'name' 					=> $order_name, 
		 'phone' 					=> $order_phone,
		 'address' 					=> $order_address,
		 'cod' 						=> $order_cod,
		 'weight' 					=> $order_weight, 
		 'delivery_date' 			=> $date, 
		 'is_delivery2' 			=> 0,
		 'delivery2_created_by' 	=> 0,
		 'delivery2_date' 			=> "0000-00-00 00:00:00", 
		 'delivery2_status'			=> "", 
		 'delivery2_remark'			=> "", 
		 'is_rr' 					=> 0, 
		 'rr_date' 					=> "0000-00-00 00:00:00", 
		 'rr_created_by' 			=> 0
		 );
		 $delivery_detail_id=$this->Commonmodel->Insert_record('saimtech_delivery_detail', $data);
		 $this->db->trans_complete();					
		
		} else if(($order_status=="Transit" || $order_status=="Arrival" || $order_status=="DE Manifest" || $order_status=="Return"  || $order_status=="Short Received" || $order_status=="Refused") && $is_final==0){
		 
		
	 
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'On Route',
		 'delivery_rider_id'    => $rider,
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> $delivery_sheet_code,
		 'delivery_attempt'		=> (($delivery_attempt)+1)	
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		//Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name']; 
		 $order_message='Shipment Has On Route For Delivery '. $delivery_sheet_code.'  ('.$rider_data[0]['rider_code'].'-'.$rider_data[0]['rider_name'].')';
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'On Route', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 //Insert into Delivery_List
		 if($sheet_check<1){
		 $data = array(
		 'rider_id'  				=> $rider, 
		 'route_id' 				=> $route, 
		 'delivery_code'  			=> $delivery_sheet_code,
		 'delivery_origin' 			=> $origin, 
		 'delivery_date'  			=> $date, 
		 'is_delivery_complete'  	=> 0, 
		 'ip' 						=> $ip,
		 'delivery_created_by' 		=> $_SESSION['user_id']
		 );	
		 $delivery_list_id=$this->Commonmodel->Insert_record('saimtech_delivery_list', $data);
		 } else {
		 $delivery_data=$this->Deliverymodel->Get_Delivery_Status_By_Code($delivery_sheet_code);	
		 $delivery_list_id=$delivery_data[0]['delivery_list_id'];
		 }
		 //Insert into Delivery_Detail
		 $data = array(
		 'delivery_list_id'			=> $delivery_list_id, 
		 'order_code'				=> $cn,
		 'order_detail_id'			=> $detail_id,  
		 'name' 					=> $order_name, 
		 'phone' 					=> $order_phone,
		 'address' 					=> $order_address,
		 'cod' 						=> $order_cod,
		 'weight' 					=> $order_weight, 
		 'delivery_date' 			=> $date, 
		 'is_delivery2' 			=> 0,
		 'delivery2_created_by' 	=> 0,
		 'delivery2_date' 			=> "0000-00-00 00:00:00", 
		 'delivery2_status'			=> "", 
		 'delivery2_remark'			=> "", 
		 'is_rr' 					=> 0, 
		 'rr_date' 					=> "0000-00-00 00:00:00", 
		 'rr_created_by' 			=> 0
		 );
		 $delivery_detail_id=$this->Commonmodel->Insert_record('saimtech_delivery_detail', $data);
		 $this->db->trans_complete();				
		
		} else if($order_status=="CN" || $order_status=="EBA" || $order_status=="MR" || $order_status=="PI" || $order_status=="Refused" || $order_status=="CNA" || $order_status=="NSC"  || $order_status=="NCI" || $order_status=="SFC" || $order_status=="NSA" || $order_status=="OSA" || $order_status=="ICA" || $order_status=="HIO" || $order_status=="UL" || $order_status=="MR" || $order_status=="SD" || $order_status=="HFC" || $order_status=="CA"){
		$this->db->trans_start();
		//Update Order
		 $data = array(
		 'order_status' 		=>'On Route',
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> $delivery_sheet_code,
		 'delivery_attempt'		=> (($delivery_attempt)+1)	
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name']; 
		 $order_message='Shipment Has On Route For Delivery'. $delivery_sheet_code.'  ('.$rider_data[0]['rider_code'].'-'.$rider_data[0]['rider_name'].')';
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'On Route', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 //Insert into Delivery_List
		 if($sheet_check<1){
		 $data = array(
		 'rider_id'  				=> $rider, 
		 'route_id' 				=> $route, 
		 'delivery_code'  			=> $delivery_sheet_code,
		 'delivery_origin' 			=> $origin, 
		 'delivery_date'  			=> $date, 
		 'is_delivery_complete'  	=> 0, 
		 'ip' 						=> $ip,
		 'delivery_created_by' 		=> $_SESSION['user_id']
		 );	
		 $delivery_list_id=$this->Commonmodel->Insert_record('saimtech_delivery_list', $data);
		 } else {
		 $delivery_data=$this->Deliverymodel->Get_Delivery_Status_By_Code($delivery_sheet_code);	
		 $delivery_list_id=$delivery_data[0]['delivery_list_id'];
		 }
		 //Insert into Delivery_Detail
		 $data = array(
		 'delivery_list_id'			=> $delivery_list_id, 
		 'order_code'				=> $cn, 
		 'order_detail_id'			=> $detail_id, 
		 'name' 					=> $order_name, 
		 'phone' 					=> $order_phone,
		 'address' 					=> $order_address,
		 'cod' 						=> $order_cod,
		 'weight' 					=> $order_weight, 
		 'delivery_date' 			=> $date, 
		 'is_delivery2' 			=> 0,
		 'delivery2_created_by' 	=> 0,
		 'delivery2_date' 			=> "0000-00-00 00:00:00", 
		 'delivery2_status'			=> "", 
		 'delivery2_remark'			=> "", 
		 'is_rr' 					=> 0, 
		 'rr_date' 					=> "0000-00-00 00:00:00", 
		 'rr_created_by' 			=> 0
		 );
		 $delivery_detail_id=$this->Commonmodel->Insert_record('saimtech_delivery_detail', $data);				
		 $this->db->trans_complete();	
		
		} else {
		echo("<tr><td><p class='alert alert-danger'>This CN is Not Eligible For Delivery Phase 1 (ON- Route)</p></td><td></td><td></td><td></td></tr>");}
		//------------------------------------	
		
	 } else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td></tr>");}
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Found :(</p></td><td></td><td></td><td></td></tr>");	} 
	$this->redraw_table($delivery_sheet_code);
	//-----------------------------------------
	}

	public function get_delivery_sheet_code(){
	$code=$this->Deliverymodel->Get_Last_Delivery_Sheet_Code();
	$prefix="DD".date('y');
		 if(strlen($code)==1){ $precode=$prefix."0000000".$code;} 
	else if(strlen($code)==2){ $precode=$prefix."000000".$code;} 
	else if(strlen($code)==3){ $precode=$prefix."00000".$code;} 
	else if(strlen($code)==4){ $precode=$prefix."0000".$code;} 
	else if(strlen($code)==5){ $precode=$prefix."000".$code;}
	else if(strlen($code)==6){ $precode=$prefix."00".$code;} 
	else if(strlen($code)==7){ $precode=$prefix."0".$code;} 
	else if(strlen($code)==8){ $precode=$prefix.$code;}
	return $precode;
	}


	public function redraw_table($code){
	$delivery_sheet_data=$this->Deliverymodel->Get_Delivery_Sheet_By_Code($code);
	if(!empty($delivery_sheet_data)){
    foreach($delivery_sheet_data as $rows){
    echo("<tr>");
    echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
    echo("<td>".$rows->cn."</td>");
    echo("<td>".$rows->manual."</td>");
    echo("<td>".$rows->name."</td>");
    echo("<td>".$rows->phone."</td>");
    echo("<td>".$rows->address."</td>");
    echo("<td>".$rows->cod."</td>");
    echo("<td>".$rows->weight."</td>");
    echo("<td>".$rows->date."</td>");
    echo("<td>".$rows->Sheet."</td>");
    echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->cn.")'>Remove</button></td>");
    echo("</tr>"); }}  
	}
	
	public function Get_Delivery_Sheet_By_Code_Nums(){
	$code= $this->input->post('delivery_sheet_code');    
	echo $delivery_sheet_num=$this->Deliverymodel->Get_Delivery_Sheet_By_Code_Nums($code);
	}


	public function set_barcode($code){
    $targetDir = FCPATH."assets/barcode/sheet/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }

    public function remove_cn(){
    $cn=$this->input->post('cn');
    $code="";
    $order_id="";
    if($cn!=""){
    $this->db->trans_start();	
    $order_data=$this->Deliverymodel->Get_Order_Detail_By_CN($cn);
    if(!empty($order_data)){
   	$code=$order_data[0]['on_route_id'];
    $order_id=$order_data[0]['order_id'];
    $is_debagging=$order_data[0]['is_debagging'];
    $delivery_attempt=$order_data[0]['delivery_attempt'];
    $new_order_status="";
    $delivery_detail_data=$this->Deliverymodel->Get_Order_Tracking_ID_By_CN($cn);
	$order_detail_id=$delivery_detail_data[0]['order_detail_id'];   
    if($is_debagging=="1"){
    $new_order_status="De Bagging";	
    } else {
    $new_order_status="Arrival";		
    }
    $this->Commonmodel->Delete_record('saimtech_delivery_detail', 'order_code', $cn);
 	$data =array(
 	'is_on_route' 			=> 0,
 	'on_route_id' 			=> 0,
 	'on_route_date' 		=> '0000-00-00 00:00:00',
 	'order_status' 			=> $new_order_status,
 	'delivery_attempt'		=> (($delivery_attempt)-1)
 	);
 	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
 	$this->Commonmodel->Delete_record('saimtech_order_tracking', 'order_tracking_id', $order_detail_id);
    }	
    $this->db->trans_complete();
    }
	$this->redraw_table($code);
    }


   
    
    public function complete_sheet($sheet_code){
    // Create Delivery Sheet Barcode
    $this->set_barcode($sheet_code);
    // Create Delivery Sheet Barcode -End
    $this->db->trans_start();	
    $data =array('is_delivery_complete' => 1);
 	$this->Commonmodel->Update_record('saimtech_delivery_list', 'delivery_code', $sheet_code, $data);
 	$this->db->trans_complete();
    redirect('Delivery');	
    }


	public function print_delivery_sheet($sheet_code){
	$sheet_data=$this->Deliverymodel->Get_Delivery_Print_Sheet_By_Code($sheet_code);
	$sheet_archive_data=$this->Deliverymodel->Get_Delivery_Print_Sheet_By_Code_Archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheet_archive_data);
	$this->load->view('module_delivery1/printdeliveryView',$data);
	}

	public function view_delivery_sheet($sheet_code){
	//$sheet_data=$this->Deliverymodel->Get_Delivery_Print_Sheet_By_Code($sheet_code);
	//$sheet_archive_data=$this->Deliverymodel->Get_Delivery_Print_Sheet_By_Code_Archive($sheet_code);
	//$sheet_archive_data="";
//	$data['sheet_data']=array_merge($sheet_data,$sheet_archive_data);
	$data['sheet_data']=$this->Deliverymodel->Get_Delivery_Print_Sheet_By_Code($sheet_code);
	
	$this->load->view('module_delivery1/deliverypreviewView',$data);
	}

	public function get_client_ip() {
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

	
	public function boost_up_delivery(){
	$this->Deliverymodel->Run_Boost_Up();
    echo("<p class='alert alert-info'>System Boost Up Delivery Module, DE Delivery Module </p>");
	}
	
	public function cp(){
   	$this->Deliverymodel->Run_Boost_Up();
    echo("<center><p class='alert alert-success'>Delivery Archived successfully... Now Enjoy the System Speed.</p></center>");    
    }
	

}
