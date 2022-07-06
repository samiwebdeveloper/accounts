<?php

class Direct extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	if($_SESSION['user_power']==CS || $_SESSION['user_power']==SE){     
	$data['rider_data']=$this->Commonmodel->Get_all_record('saimtech_rider');
	
	$this->load->view('module_delivery1/directstatusView',$data);	
	} else {
	echo("<center><h1>Access Denied.........<BR>Name : ".$_SESSION['user_name']." <BR>IP : ".$this->get_client_ip(). "</h1></center>");    
    }
	}
	
	
	public function cs_index(){
	$data['rider_data']=$this->Commonmodel->Get_all_record('saimtech_rider');
	$this->load->view('module_delivery1/csdeliveryView',$data);	
	}
	
	public function cs_dd(){
	if($_SESSION['user_power']=='CS' || $_SESSION['user_id']==7 ){     
	$data['rider_data']=$this->Commonmodel->Get_all_record('saimtech_rider');
	$data['ip']=$this->get_client_ip();
	$this->load->view('module_delivery1/csdirectdeliveryView',$data);	
	} else {
	echo("<center><h1>Access Denied.........<BR>Name : ".$_SESSION['user_name']." <BR>IP : ".$this->get_client_ip(). "</h1></center>");     
	}
	}
	
	
	public function support(){
	$data['cn_data']=$this->Commonmodel->Get_Today_Deliverd_Cn();	
	$this->load->view('module_delivery1/oprdirectdeliveryView',$data);	
	}
	
	
	public function support_process(){
	$cn 				= $this->input->post('cn');
	$order_status		= $this->input->post('order_status');
	$ip 				= $this->get_client_ip();
	//-----------------------------------------
	 if($cn!="" && $order_status!="" ){
		$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
		$order_id 			    = $order_detail[0]['order_id'];
		$is_final 			    = $order_detail[0]['is_final'];
		$is_invoice 			= $order_detail[0]['is_invoice'];
		
		//------------------------------------
		
		if($is_invoice!=1){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=> $order_status,
		 'order_deliver_date'   => '0000-00-00 00:00:00',
	     'order_result_date'    => date('Y-m-d H:i:s'),
	     'is_final'				=> 0,	
		 'modify_by'		    => $_SESSION['user_id'],
	     'modify_date'		    => date('Y-m-d H:i:s')
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 $this->Commonmodel->Remove_tracking_event($_SESSION['user_id'],date('Y-m-d'),$order_id);
		 $this->db->trans_complete();
		 echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		 //--------------------------------------------------------------------------
		 }
		 //else if($is_on_route==1 && $is_final==0){
		 //echo("<p class='alert alert-danger'>Please try this through Phase 2 Module..... :(</p>");
		 //}
	     } else {
	    echo("<p class='alert alert-danger'>Something Went Wrong Please Try Again..... :(</p>");}
	    //-----------------------------------------
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
    
    public function direct_process(){
	$cn 				= $this->input->post('cn');
	$date 				= $this->input->post('delivery_date');
	$origin 			= $_SESSION['origin_id'];
	$order_status		= $this->input->post('order_status');
	$ip 				= $this->get_client_ip();
	//-----------------------------------------
	 if($cn!="" && $date!=""   && $origin!=""){
		$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
	   //echo "<pre>";print_r($order_detail); exit;
		$order_id 			    = $order_detail[0]['order_id'];
		$order_code 			= $order_detail[0]['order_code'];
		$is_final 			    = $order_detail[0]['is_final'];
		$order_date             = $order_detail[0]['order_date'];
		 $order_date =date_create(	$order_date );
        $order_date =date_format($order_date,"Y-m-d");
        $delivery_date =date_create($date);
        $delivery_date =date_format($delivery_date,"Y-m-d");
		} 
		if($order_date < $delivery_date){
		if(($order_status=="Refused" || $order_status=="CNA" || $order_status=="NSA" || $order_status=="OSA" || $order_status=="ICA" || $order_status=="HIO"  || $order_status=="Return") &&  $is_final!=1 && $is_invoice!=1 ){
		$this->db->trans_start();
		//Update Order
		 $data = array(
		 'order_status' 		 => $order_status,
		 'order_result_date'     => $date);
		 $this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name'];
	     $order_message='';
		 if($order_status=='HIO'){
		 $order_message='Shipment hold in operation ITIF';    
		 } else if($order_status=='NSA'){
		 $order_message='None Service Area ITIF';    
		 } else if($order_status=='OSA'){
		 $order_message='Out Of Service Area ITIF';    
		 } else if($order_status=='CNA'){
		 $order_message='Consignee Not Available ITIF';    
		 } else if($order_status=='ICA'){
		 $order_message='Incomplete Address ITIF';    
		 } else if($order_status=='Refused'){
		 $order_message='Shipment Refused By Consignee ITIF';    
		 } else if($order_status=='Return'){
		 $order_message='Shipment Return ITIF';    
		 }
		 
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> $order_status, 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $this->db->trans_complete();	
		echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		} else {
		echo("<p class='alert alert-danger'>This CN is Not Eligible For IT Controller</p>");}
		//------------------------------------	
        }else {
		echo("<p class='alert alert-danger'>Please Enter a Valid Date");}
	     } 
	     

	   
	    //-----------------------------------------
	    
	    public function cs_direct_process(){
	$cn 				= $this->input->post('cn');
	$date 				= $this->input->post('delivery_date');
	$rider 				= $this->input->post('rider');
	$receive_by 		= $this->input->post('receive_by');
	$origin 			= $_SESSION['origin_id'];
	$order_status		= $this->input->post('order_status');
	$ip 				= $this->get_client_ip();
	//-----------------------------------------
	 if($cn!="" && $date!="" && $rider!=""  && $origin!="" && $receive_by){
		$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
		$order_id 			    = $order_detail[0]['order_id'];
		$order_code 			= $order_detail[0]['order_code'];
		$is_final 			    = $order_detail[0]['is_final'];
		$is_invoice 			= $order_detail[0]['is_invoice'];
		$is_loading 			= $order_detail[0]['loading_id'];
		$order_date             = $order_detail[0]['order_date'];
	    $order_date =date_create(	$order_date );
        $order_date =date_format($order_date,"Y-m-d");
        $delivery_date =date_create($date);
        $delivery_date =date_format($delivery_date,"Y-m-d");
		//------------------------------------
		if($order_date < $delivery_date){
		if($order_status=="Deliverd" && $is_final!=1 && $order_status!="Arrival" ){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'Deliverd',
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> 'CSDD'.date('Y')."0000NA",
		 'order_deliver_date'   => $date,
	     'order_result_date'    => date('Y-m-d H:i:s'),
	     'order_rr_date'   		=> $date,
	     'shipment_received_by'	=> $receive_by,
	     'delivery_rider_id'    => $rider,
	     'is_final'				=> 1,	
		 'modify_by'		    => $_SESSION['user_id'],
	     'modify_date'		    => date('Y-m-d H:i:s')
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id , $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name']; 
		 $order_message='Shipment has been Delivered CSIF ('.$receive_by.')';
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'Deliverd', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> date('Y-m-d H:i:s') );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $data = array(
		 'is_delivery2' => 1 );
		 $this->Commonmodel->Update_record('saimtech_delivery_detail','order_code', $order_code, $data);
		 $this->db->trans_complete();
		 if($loading_id!=""){
		 $data = array('is_unload' => 1);
		 $this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_cn', $order_code, $data);
		 //$tdetail_id=$this->Commonmodel->Insert_record('saimtech_transit_detail', $data);
		 }
		 echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		 //--------------------------------------------------------------------------
		   
		}else if($order_status=="RTS" && $is_final!=1 && $order_status!="Arrival" ){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'RTS',
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> 'CSDD'.date('Y')."0000NA",
		 'order_deliver_date'   => $date,
	     'order_result_date'    => date('Y-m-d H:i:s'),
	     'order_rr_date'   		=> $date,
	     'shipment_received_by'	=> $receive_by,
	     'delivery_rider_id'    => $rider,
	     'is_final'				=> 1,	
		 'modify_by'		    => $_SESSION['user_id'],
	     'modify_date'		    => date('Y-m-d H:i:s')
		 );
		 $this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id , $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name']; 
		 $order_message='Shipment has been RTS CSIF ('.$receive_by.')';
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'RTS', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> date('Y-m-d H:i:s') );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $data = array(
		 'is_delivery2' => 1 );
		 $this->Commonmodel->Update_record('saimtech_delivery_detail','order_code', $order_code, $data);
		 $this->db->trans_complete();
		 if($loading_id!=""){
		 $data = array('is_unload' => 1);
		 $this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_cn', $order_code, $data);
		 //$tdetail_id=$this->Commonmodel->Insert_record('saimtech_transit_detail', $data);
		 }
		 echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		 //--------------------------------------------------------------------------
		   
		}
		else if($order_status=="De Manifest" && $is_final!=1){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'De Masnifest',
		 'is_unloading'			=> 1);
		$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		$this->db->trans_complete();
		echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		//--------------------------------------------------------------------------    
		} else if($order_status=="REFWD" && $is_final!=1 ){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'Arrival',
		 'is_debagging'			=> 0,
		 'is_loading'			=> 0,
		 'is_unloading'			=> 0,
		 'is_bagging'			=> 0,
		 'is_redebagging'		=> 0,
		 'is_reloading'			=> 0,
		 'is_reunloading'		=> 0,
		 'is_rebagging'			=> 0
		 );
		$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		$data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> 'REFWD', 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> 'IT TEAM', 
		 'order_message' 	 	=> "Re Forwarding ", 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		$this->db->trans_complete();
		echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		//--------------------------------------------------------------------------    
		    
		} else if($order_status=="Return De Bagging" && $is_final!=1 ){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		    =>'Return De Bagging',
		 'is_redebagging'			=> 1);
		$this->db->trans_complete();
		echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		//--------------------------------------------------------------------------  
		$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		} else if(($order_status=="Refused" || $order_status=="CNA" || $order_status=="NSA" || $order_status=="OSA" || $order_status=="ICA" || $order_status=="HIO"  || $order_status=="Return") &&  $is_final!=1 && $is_invoice!=1 ){
		$this->db->trans_start();
		//Update Order
		 $data = array(
		 'order_status' 		 => $order_status,
		 'order_result_date'     => $date);
		 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 //Insert into Order Detail
		 $city_data=$this->Deliverymodel->Get_City_Detail_By_id($origin);
		 $origin_name=$city_data[0]['city_name'];
	     $order_message='';
		 if($order_status=='HIO'){
		 $order_message='Shipment hold in operation CSIF';    
		 } else if($order_status=='NSA'){
		 $order_message='None Service Area CSIF';    
		 } else if($order_status=='OSA'){
		 $order_message='Out Of Service Area CSIF';    
		 } else if($order_status=='CNA'){
		 $order_message='Consignee Not Available CSIF';    
		 } else if($order_status=='ICA'){
		 $order_message='Incomplete Address CSIF';    
		 } else if($order_status=='Refused'){
		 $order_message='Shipment Refused By Consignee CSIF';    
		 } else if($order_status=='Return'){
		 $order_message='Shipment Return CSIF';    
		 }
		 
		 $data = array(
		 'order_id' 			=> $order_id, 
		 'order_event' 		 	=> $order_status, 
		 'order_location' 	 	=> $origin, 
		 'order_location_name'	=> $origin_name, 
		 'order_message' 	 	=> $order_message, 
		 'order_ip'			 	=> $ip,
		 'order_event_date'	 	=> $date,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> $date );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $this->db->trans_complete();	
		echo("<p class='alert alert-success'>".$cn." status is successfully updated ".$order_status."</p>");
		} else {
		echo("<p class='alert alert-danger'>This CN is Not Eligible For IT Controller</p>");}
		}else {
		echo("<p class='alert alert-danger'>Please Enter a Valid Date");}
		//------------------------------------	
		
	     } else {
	    echo("<p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p>");}
	    //----------------------------------------- }
    
	
	
}
public function osa(){
        if($_SESSION['user_power']=='SE' || $_SESSION['user_power']=='CS' ){         
        $data['detail']=$this->Deliverymodel->Get_Thirty_Days_OSA();  
	    $this->load->view('module_delivery1/osamoduleView',$data);  
        } else {
        echo("<center><h1>Access Denied.........<BR>Name : ".$_SESSION['user_name']." <BR>IP : ".$this->get_client_ip(). "</h1></center>");}
        }
        
    public function shc(){
      if($_SESSION['user_power']=='CS' || $_SESSION['user_id']==7 ){         
      $data['ip']=$this->get_client_ip();
      $this->load->view('module_delivery1/shcmoduleView');  
      } else {
      echo("<center><h1>Access Denied.........<BR>Name : ".$_SESSION['user_name']." <BR>IP : ".$this->get_client_ip(). "</h1></center>");}
        }    
	
	public function osa_delete($id){
// 	echo $id;exit();    
	$this->Commonmodel->Delete_record('saimtech_osa',   'osa_id',    $id);
	$this->Commonmodel->Delete_record('saimtech_alert', 'delete_id', $id);
	redirect('Direct/osa');
	}
	
	public function redraw_os_table(){
	$detail=$this->Deliverymodel->Get_Thirty_Days_OSA();  
	if(!empty($detail)){
	foreach($detail as $rows){
   echo("<tr>");
	echo("<td>".$rows->order_code."</td>");
	echo("<td>".$rows->osa_amount."</td>");
	echo("<td>".$rows->special_delivery."</td>");
	if($rows->refused==0 && $rows->post==0){
	echo("<td>Pending</td>");
	} else if($rows->refused==1 && $rows->post==1){
	echo("<td>Shipper Rejected</td>");
	} else if($rows->post==1 && $rows->refused==0){
	echo("<td>Shipper Aproved</td>");
	}
	if($rows->post==0 && $_SESSION['user_power']=='SE' || $_SESSION['user_id']==2){
	echo("<td><a href='".base_url()."Direct/osa_delete/".$rows->osa_id."' onclick='return checkDelete()' class='btn btn-danger btn-xs'>Remove</a>&nbsp;&nbsp;<a href='".base_url()."Direct/osa_aproved/".$rows->osa_id."/".$rows->order_code."/".$rows->customer_id."/".$rows->total_amount."' class='btn btn-success btn-xs'>Aproved On Call</a></td>");    
	} else {
	echo("<td><code>No Rights</code></td>");
	}
	echo("</tr>");
	}    
	}
	    
	}
	
	public function osa_aproved($id,$cn,$customer_id,$total_amount){
	if($id!="" && $id!=0){
    //-------------------------------------------------------------------------
	$data = array(
    'post'          =>1, 
    'approve_by'    =>$_SESSION['user_id'], 
    'approve_date'  =>date('Y-m-d H:i:s'));
	$this->Commonmodel->Update_record('saimtech_osa', 'osa_id', $id, $data); 
	//-------------------------------------------------------------------------
	$data = array(
	 'alert_name'       =>'OSA/SD Confirmed', 
	 'alert_narration'  =>$cn.' Out of service area/Special Delivery charges applied (aproved on call)', 
	 'customer_id'      =>$customer_id, 
	 'delete_id'        =>$id, 
	 'created_date'     =>date('Y-m-d H:i:s'), 
	 'created_by'       =>$_SESSION['user_id'] );
	$this->Commonmodel->Insert_record('saimtech_alert', $data);
	//-------------------------------------------------------------------------
	$data = array('order_osa_sd_total' =>$total_amount);
 	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data); 
	 }
	 	redirect('Direct/osa');
	}
	
	public function osa_process(){

	$cn 				= $this->input->post('cn');
	$date 				= date('Y-m-d h:i:s');
	$osa 				= $this->input->post('osa');
	$sdelivery 			= $this->input->post('sdelivery');
	if ($osa!="" && $sdelivery!=""){
	 $total_amount       = $osa + 	$sdelivery;   
	}
	elseif($osa==""){
	    $osa =0;
	}
	else{
	   $sdelivery = 0; 
	}
	$total_amount       = $osa + 	$sdelivery;
	$origin 			= $_SESSION['origin_id'];
	$ip 				= $this->get_client_ip();
	//-----------------------------------------
	if($cn!="" && $date!="" && ($osa!="" || $sdelivery!="")  && $origin!="" ){
	$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
	$order_id 			    = $order_detail[0]['order_id'];
	$is_final 			    = $order_detail[0]['is_final'];
	$is_invoice 			= $order_detail[0]['is_invoice'];
	$customer_id 			= $order_detail[0]['customer_id'];
	$status 			    = $order_detail[0]['order_status'];
	//------------------------------------
	if($status!="LOST" && $status!="Cancelled"  && $is_invoice!=1){
	$this->db->trans_start();	
	$data = array(
	'order_code'            =>$cn, 
	'osa_amount'            =>$osa,
	'special_delivery'      =>$sdelivery,
	'total_amount'          =>$total_amount,
	'refused'               =>0, 
	'customer_id'           =>$customer_id, 
	'post'                  =>0, 
	'created_by'            =>$_SESSION['user_id'], 
	'created_date'          =>date('Y-m-d H:i:s'), 
	'approve_by'            =>0, 
	'approve_date'          =>'0000-00-00 00:00:00');
	$detail_id=$this->Commonmodel->Insert_record('saimtech_osa', $data);
	$data = array(
	 'alert_name'       =>'OSA/SD Pending Request', 
	 'alert_narration'  =>'Out of service area/Special Delivery charges will be PKR'.$total_amount.'/- against shipment# '.$cn, 
	 'customer_id'      =>$customer_id, 
	 'delete_id'        =>$detail_id, 
	 'created_date'     =>date('Y-m-d H:i:s'), 
	 'created_by'       =>$_SESSION['user_id'] );
	$this->Commonmodel->Insert_record('saimtech_alert', $data);
	$this->db->trans_complete();
	echo("<tr><td colspan='5'><p class='alert alert-success'>".$cn." OSA/SD Total Amount: ".$total_amount."/- rupess request is successfully Created </p></td></tr>");
	$this->redraw_os_table();
	 //--------------------------------------------------------------------------
	} else {
	echo("<p class='alert alert-danger'>This CN is Not Eligible For OSA</p>");}
	//------------------------------------	
	} else {
	echo("<p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p>");}
	//-----------------------------------------
	}   
}