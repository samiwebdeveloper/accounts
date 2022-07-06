<?php

class Arrival extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Arrivalmodel');
    $this->load->model('Bookingmodel');
    }


	public function index(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Arrival";	
	$data['event_name']="Arrival";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['arrival_sheets']=$this->Arrivalmodel->Get_Arrival_Sheets_By_Origin_Range($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_arrival/arrivalView',$data);	
	}
	
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Arrival";	
	$data['event_name']="Arrival";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$arrival_sheets=$this->Arrivalmodel->Get_Arrival_Sheets_By_Origin_Range($_SESSION['origin_id'],$startdate,$enddate);
	$arrival_sheets_archive=$this->Arrivalmodel->Get_Arrival_Sheets_By_Origin_Range_Archive($_SESSION['origin_id'],$startdate,$enddate);
	$data['arrival_sheets']=array_merge($arrival_sheets,$arrival_sheets_archive);
	$this->load->view('module_arrival/arrivalView',$data);	
	}
	
	public function history(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Arrival";	
	$data['event_name']="Arrival";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-7 day', strtotime($enddate)));
	$data['arrival_sheets']=$this->Arrivalmodel->Get_Arrival_Sheets_By_Origin_Range($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_arrival/arrivalrangeView',$data);	
	}
	
	public function create_arrival_sheet_view(){
	$user_id=1;
	$data['arrival_sheet_code']="";
	$data['arrival_sheet_data']="";
	$arrival_id=0;
	$data['rider_data']=$this->Commonmodel->Get_record_by_condition('saimtech_rider', 'rider_origin_id', $_SESSION['origin_id']);	
	$check=$this->Arrivalmodel->Get_Incomplete_Arrival_Sheet_Count($_SESSION['user_id']);	
	if($check>0){
	$sheet_detail=$this->Arrivalmodel->Get_Incomplete_Arrival_Sheet($_SESSION['user_id']);	
	$data['arrival_sheet_code']=$sheet_detail[0]['sheetcode'];
	$data['arrival_sheet_data']=$this->Arrivalmodel->Get_Arrival_Sheet_By_code($sheet_detail[0]['sheetcode']);
	} else {
	$data['arrival_sheet_code']=$this->get_arrival_sheet_code();
	$data['arrival_sheet_data']="";
	}	
	$this->load->view('module_arrival/arrivalcreateView',$data);	
	}

	public function arrival_process(){
	$cn=$this->input->post('cn');
	$date=date('Y-m-d H:i:s');
	$rider=$this->input->post('rider');
	$arrival_sheet_code=$this->input->post('arrival_sheet_code');
	$origin=$_SESSION['origin_id'];
	$order_status="";
	$order_detail="";
	$sheet_check="";
	$order_status="";
	$order_id="";
	$arrival_id=0;
	$order_weight="";
	$order_pieces="";
    $cn_check=$this->Arrivalmodel->Check_CN($cn);
	//-----------------------------------------
	if($cn_check>0){	
	 if($cn!="" && $date!="" && $rider!="" && $arrival_sheet_code!="" && $origin!=""){
		$this->db->trans_start();
		$order_detail=$this->Arrivalmodel->Get_Order_By_Code($cn);
		$sheet_check=$this->Arrivalmodel->Check_Arrival_Sheet_Code($arrival_sheet_code);
		$order_status	= $order_detail[0]['order_status'];
		$order_code	    = $order_detail[0]['order_code'];
		$order_weight	= $order_detail[0]['weight'];
		$order_pieces	= $order_detail[0]['pieces'];
		$is_final		= $order_detail[0]['is_final'];
		$is_arrival		= $order_detail[0]['is_arrival'];
		$order_id 		= $order_detail[0]['order_id'];
		//------------------------------------
		if(($order_status=="Booking" || $order_status=="Order") && $is_final==0 && $is_arrival==0){
		 	//------------------------------------
		 	if($sheet_check<1){
		 	$data = array(
		 	'arrival_sheet_code' => $arrival_sheet_code, 
		 	'arrival_date' 		 => date('Y-m-d'), 
		 	'arrival_origin' 	 => $origin, 
		 	'rider_id' 			 => $rider, 
		 	'is_complete' 		 => '0', 
		 	'ip_address' 		 => $_SERVER['REMOTE_ADDR'], 
		 	'created_by' 		 => $_SESSION['user_id'], 
		 	'created_date' 		 =>	$date, 
		 	'modify_by'			 =>	'0', 
		 	'modify_date'		 => '0000-00-00 00:00:00'
		 	);	
		 	$arrival_id=$this->Commonmodel->Insert_record('saimtech_arrival_list', $data);
		 	} else {
		 	$arrival_data=$this->Arrivalmodel->Get_Arrival_Status_By_Code($arrival_sheet_code);	
		 	$arrival_id=$arrival_data[0]['arrival_id'];
		 	}
		 	//------------------------------------	
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=>'Arrival',
		 	'order_arrival_date'=>$date,
		 	'is_arrival'		=>1,
		 	'arrival_id'		=>$arrival_sheet_code,
		 	'pickup_rider_id'   =>$rider,
		 	'modify_by'		    =>$_SESSION['user_id'],
		 	'modify_date'		=>$date	
		 	);
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id , $data);
		 	//Insert into Order Detail
		 	$city_data=$this->Arrivalmodel->Get_City_Detail_By_id($origin);
		 	$origin_name=$city_data[0]['city_name']; 
		 	$order_message='Shipment Has Arrived at Origin Hub';
		 	$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'Arrival', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> $origin_name, 
		 	'order_message' 	 => 'Shipment Has Arrived at Origin Hub', 
		 	'order_ip'			 =>	$_SERVER['REMOTE_ADDR'],
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	
		 	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 	//Insert into arrival detail
		 	$data = array(
		 	'arrival_id' 		 => $arrival_id, 
		 	'order_code' 		 => $order_code, 
		 	'weight' 		 	 => $order_weight, 
		 	'new_weight' 		 => 0,
		 	'pieces' 		 	 => $order_pieces, 
		 	'new_pieces' 		 => 0, 
		 	'order_detail_id' 	 => $detail_id, 
		 	'arrival_date'		 => date('Y-m-d'), 
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );
		 	$arrival_detail_id=$this->Commonmodel->Insert_record('saimtech_arrival_detail', $data);	
		 	$this->db->trans_complete();
		} else {
		echo("<tr><td><p class='alert alert-danger'>This CN is Not Eligible For Arrival</p></td><td></td><td></td><td></td></tr>");	
		}
		//------------------------------------	
		
	 } else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td></tr>");		
	 }
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is not found in system :(</p></td><td></td><td></td><td></td></tr>");
    /*$origin=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_id', $_SESSION['origin_id']);
	$o_city=$origin[0]['city_id'];	
	$o_city_name=$origin[0]['city_name'];
	$o_city_code=$origin[0]['city_code'];
	$o_city_zone=$origin[0]['city_zone'];
	$o_city_reporting=$origin[0]['reporting_city'];
	//==============Get Origin City ID & Name=====================	
	$order_code=$this->get_order_code($o_city_code);
	$ip= $_SERVER['REMOTE_ADDR'];
	$this->set_barcode_cn($order_code);	
	$data = array(
	'customer_id'					=> 	'16',
	'manual_cn'                     =>  $cn,
	'cod_amount'					=> 	'0',
	'order_date'					=> 	date('Y-m-d H:i:s'),
	'order_code'					=> 	$order_code,
	'customer_reference_no'			=> 	'#10001',
	'order_booking_date'			=> 	date('Y-m-d H:i:s'),
	'order_arrival_date'			=> 	date('Y-m-d H:i:s'),
	'order_deliver_date'			=> 	'0000-00-00 00:00:00',
	'order_rr_date'					=> 	'0000-00-00 00:00:00',
	'order_cr_date'					=> 	'0000-00-00 00:00:00',
	'order_status'					=> 	'Arrival',
	'destination_city'				=> 	'219',
	'destination_zone'				=> 	'Z',
	'destination_city_name'			=> 	'Unknown',
	'origin_city'					=> 	$o_city,
	'origin_zone'					=> 	$o_city_zone,
	'origin_city_name'				=> 	$o_city_name,
	'order_rate_type'				=> 	'SZ',
	'order_service_type'			=> 	'1',
	'order_receive_from'			=> 	'AB',
	'weight'						=>	'1',
	'pieces'						=>	'1',
	'consignee_name'				=>	"NA",
	'consignee_email'				=>	"NA",
	'consignee_address'				=>	"NA",
	'consignee_mobile'				=>	"NA",
	'shipper_name'				    =>	"NA",
	'shipper_email'				    =>	"NA",
	'shipper_address'				=>	"NA",
	'shipper_phone'				    =>	"NA",
	'product_detail'				=>	"NA",
	'order_remark'					=>	"Pending Entry",
	'order_rate'					=>	'0',
	'order_add_rate'				=>	'0',
	'order_gst'						=>	'0',
	'order_sc'						=>	'0',
	'order_sp_handling_rate'		=>	'0',
	'order_cash_handling_rate'		=>  '0',
	'order_fuel'					=>	'0',
	'order_flyer_rate'				=>	'0',
	'order_pay_mode'                =>  "Account",
	'order_packing_type'            =>  "Carton",
	'order_total_amount_with_flyer' =>  '0',
	'order_total_amount'            =>  '0', 
	'delivery_rider_id'				=>	'0',
	'order_cr'						=>	'N',
	'order_receive_amount'			=> 	'0',
	'origin_reporting'              =>  $_SESSION['origin_id'],
	'destination_reporting'         =>  '0', 
	'is_arrival'		            =>  '1',
	'arrival_id'		            =>  $arrival_sheet_code,
	'pickup_rider_id'               =>  $rider,
	'rate_id'						=>	'0',
	'created_by'					=>	$_SESSION['user_id'],
	'created_date'					=>	date('Y-m-d H:i:s')
	);
	$insert_id=$this->Commonmodel->Insert_record('saimtech_order', $data);
	$status_msg="Your Order Has Been Generated.";
	$status_msg1="Your Shipment has been Booked.";
	$detail_id=$this->insert_tracking_detail($insert_id,'Order',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,'16',date('Y-m-d H:i:s'));
	$detail_id=$this->insert_tracking_detail($insert_id,'Booking',$o_city,$o_city_name,$status_msg1,date('Y-m-d H:i:s', strtotime("+1 min")),$ip,'16',date('Y-m-d H:i:s'));
	if($cn!="" && $date!="" && $rider!="" && $arrival_sheet_code!="" && $origin!=""){
		$this->db->trans_start();
		$order_detail=$this->Arrivalmodel->Get_Order_By_Code($cn);
		$sheet_check=$this->Arrivalmodel->Check_Arrival_Sheet_Code($arrival_sheet_code);
		$order_status	= $order_detail[0]['order_status'];
		$recheck_weight	= $order_detail[0]['recheck_weight'];
		$order_code	    = $order_detail[0]['order_code'];
		$order_weight	= $order_detail[0]['weight'];
		$order_pieces	= $order_detail[0]['pieces'];
		$is_final		= $order_detail[0]['is_final'];
		$is_arrival		= $order_detail[0]['is_arrival'];
		$order_id 		= $order_detail[0]['order_id'];
		if($sheet_check<1){
		$data = array(
		'arrival_sheet_code' => $arrival_sheet_code, 
		'arrival_date' 		 => date('Y-m-d'), 
		'arrival_origin' 	 => $o_city, 
		'rider_id' 			 => $rider, 
		'is_complete' 		 => '0', 
		'ip_address' 		 => $_SERVER['REMOTE_ADDR'], 
		'created_by' 		 => $_SESSION['user_id'], 
		'created_date' 		 =>	date('Y-m-d H:i:s'), 
		'modify_by'			 =>	'0', 
		'modify_date'		 => '0000-00-00 00:00:00');	
		 $arrival_id=$this->Commonmodel->Insert_record('saimtech_arrival_list', $data);
		 } else {
		 $arrival_data=$this->Arrivalmodel->Get_Arrival_Status_By_Code($arrival_sheet_code);	
		 $arrival_id=$arrival_data[0]['arrival_id'];
		 }
		 $origin_name=$_SESSION['origin_name']; 
		 $order_message='Shipment Has Arrived at Origin Hub';
		 $data = array(
		 'order_id' 		 => $order_id, 
		 'order_event' 		 => 'Arrival', 
		 'order_location' 	 => $o_city, 
		 'order_location_name'=> $o_city_name, 
		 'order_message' 	 => 'Shipment Has Arrived at Origin Hub', 
		 'order_ip'			 =>	$_SERVER['REMOTE_ADDR'],
		 'order_event_date'	 =>	date('Y-m-d H:i:s', strtotime("+2 min")),
		 'created_by' 		 => $_SESSION['user_id'],  
		 'created_date' 		 => date('Y-m-d H:i:s', strtotime("+2 min")));	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $data = array(
		 'arrival_id' 		 => $arrival_id, 
		 'order_code' 		 => $order_code, 
		 'recheck_weight'    => $recheck_weight,
		 'weight' 		 	 => $order_weight, 
		 'new_weight' 		 => 0,
		 'pieces' 		 	 => $order_pieces, 
		 'new_pieces' 		 => 0, 
		 'order_detail_id' 	 => $detail_id, 
		 'arrival_date'		 => date('Y-m-d'), 
		 'created_by' 		 => $_SESSION['user_id'],  
		 'created_date' 	 =>	$date );
		  $arrival_detail_id=$this->Commonmodel->Insert_record('saimtech_arrival_detail', $data);	
		  $this->db->trans_complete();*/
		 //------------------------------------	
	//}
	    
	    
	} 
	$this->redraw_table($arrival_sheet_code);
	//-----------------------------------------
	}

	public function get_arrival_sheet_code(){
	$code=$this->Arrivalmodel->Get_Last_Arrival_Sheet_Code();
	$prefix="AR".date('y');
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


    
	public function get_order_code($city_code){
	$code=$this->Bookingmodel->Get_Last_Order();
	if(strlen($city_code)==2){ $prefix="1".$city_code."0".date('y');} 
	else if(strlen($city_code)==3){ $prefix="1".$city_code.date('y');}
	if(strlen($code)==1){ $precode=$prefix."00000".$code;} 
	else if(strlen($code)==2){ $precode=$prefix."0000".$code;} 
	else if(strlen($code)==3){ $precode=$prefix."000".$code;} 
	else if(strlen($code)==4){ $precode=$prefix."00".$code;} 
	else if(strlen($code)==5){ $precode=$prefix."0".$code;} 
	else if(strlen($code)==6){ $precode=$prefix.$code;}
	return $precode;
	}

	public function redraw_table($code){
	$arrival_sheet_data=$this->Arrivalmodel->Get_Arrival_Sheet_By_code($code);
	if(!empty($arrival_sheet_data)){
    foreach($arrival_sheet_data as $rows){
    if($rows->recheck_weight=="Yes"){
    echo("<tr class='bg-red text-white'>");    
    } else { echo("<tr'>");}
    echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
    echo("<td>".$rows->cn."</td>");
    echo("<td>".$rows->manual."</td>");
    if($rows->new_weight!=0){
    echo("<td><input type=number value='".$rows->new_weight."'  name='weight-".$rows->d_id."' id='weight-".$rows->d_id."' onblur='update_weight(".$rows->d_id.")'></td>"); } 
    else { echo("<td><input type=number value='".$rows->weight."'  name='weight-".$rows->d_id."' id='weight-".$rows->d_id."' onblur='update_weight(".$rows->d_id.")'></td>");}
    if($rows->new_pieces!=0){
    echo("<td><input type=number value='".$rows->new_pieces."'  name='pieces-".$rows->d_id."' id='pieces-".$rows->d_id."' onblur='update_pieces(".$rows->d_id.")'></td>"); } 
    else { echo("<td><input type=number value='".$rows->pieces."' name='pieces-".$rows->d_id."' id='pieces-".$rows->d_id."' onblur='update_pieces(".$rows->d_id.")'></td>"); }
    echo("<td>".$rows->date."</td>");
    echo("<td>".$rows->Sheet."</td>");
    echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->cn.")'>Remove</button></td>");
    echo("</tr>");  
     }}
	}
	
	public function sheet_count($code){
	if($code!=""){    
	echo $arrival_sheet_count=$this->Arrivalmodel->Get_Arrival_Sheet_Count_By_code($code);   
	} else { echo "0";}
	}

	public function delete_form_Arrival_sheet(){

	}

	public function set_barcode_cn($code){
    $targetDir = FCPATH."../assets/barcode/cn/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }	

	public function set_barcode($code){
    $targetDir = FCPATH."assets/barcode/arrivalscan/";
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
    $order_data=$this->Arrivalmodel->Get_Order_Detail_By_CN($cn);
    if(!empty($order_data)){
   	$code=$order_data[0]['arrival_id'];
    $order_id=$order_data[0]['order_id'];
    $this->Commonmodel->Delete_record('saimtech_arrival_detail', 'order_code', $cn);
 	$data =array(
 	'is_arrival' 			=> 0,
 	'arrival_id' 			=> 0,
 	'order_arrival_date' 	=> '0000-00-00 00:00:00',
 	'order_status' 			=> 'Booking'	
 	);
 	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
 	$this->Commonmodel->Delete_record_double_condition('saimtech_order_tracking', 'order_id', $order_id, 'order_event', 'Arrival');
    }	
    $this->db->trans_complete();
    }
	$this->redraw_table($code);
    }


    public function update_pieces(){
    $pieces = $this->input->post('pieces');
    $id 	= $this->input->post('id');
    $sheet 	= $this->input->post('sheet');
    if($pieces!="" && $id!="" && $sheet!=""){
    $data =array('new_pieces' 	=> $pieces);
 	$this->Commonmodel->Update_record('saimtech_arrival_detail', 'arrival_detail_id', $id, $data);	
    }
    $this->redraw_table($sheet);	
    }
	

	public function update_weight(){
    $weight = $this->input->post('weight');
    $id 	= $this->input->post('id');
    $sheet 	= $this->input->post('sheet');
    if($weight!="" && $id!="" && $sheet!=""){
    $data =array('new_weight' 	=> $weight);
 	$this->Commonmodel->Update_record('saimtech_arrival_detail', 'arrival_detail_id', $id, $data);	
    }
    $this->redraw_table($sheet);	
    }

    
    public function complete_sheet($sheet_code){
    // Create Arrival Sheet Barcode
       $this->set_barcode($sheet_code);
    // Create Arrival Sheet Barcode -End
    // Update Pieces, Weight & Rate INTO Order  
       $sheet_data=$this->Arrivalmodel->Get_Arrival_Sheet_By_code($sheet_code);
       if(!empty($sheet_data)){
       foreach($sheet_data as $rows){
       $cn=$rows->cn;
       $new_weight   = $rows->new_weight;
       $weight     = $rows->weight;
       $pieces     = $rows->pieces;
       $new_pieces   = $rows->new_pieces;
       $cash_limit   = 30000;
       if($new_pieces!="" && $new_pieces!=0){ 
       $data =array('pieces'   => $new_pieces);
       $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}
       if($new_weight!="" && $new_weight!=0){ 
        $order_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'order_code', $cn);
        $rate_type    = $order_data[0]['order_rate_type'];
        $customer_id  = $order_data[0]['customer_id'];
        $cod      = $order_data[0]['cod_amount']; 
        $order_id      = $order_data[0]['order_id']; 
        $service_type   = $order_data[0]['order_service_type'];
        $o_weight     = $new_weight;   
        $o_piece      =  $pieces;
        $this->db->trans_start();
        $order_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'order_id', $order_id);
        $d_city = $order_data[0]['destination_city'];
        $o_city = $order_data[0]['origin_city'];
        $customer_id = $order_data[0]['customer_id'];
        $ship_type = $order_data[0]['order_service_type'];
        $customer_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_customer', 'customer_id', $customer_id);
        $cal_type=$customer_data[0]['cal_type'];

        if($order_data[0]['order_status']=="Booking" || $order_data[0]['order_status']=="Arrival"){
        //==============Get Destination City ID & Name================
        $dest=$this->Commonmodel->Get_record_by_condition('saimtech_city', 'city_id', $d_city);
        if(!empty($dest)){foreach($dest as $rows){
        $d_city_name=$rows->city_name;
        $d_city_zone=$rows->city_zone;
        $d_city_code=$rows->city_code;
        $d_city_reporting=$rows->reporting_city;
        }}
        //=========================================================END
        $origin=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_id', $o_city);
        $o_city=$origin[0]['city_id'];  
        $o_city_name=$origin[0]['city_name'];
        $o_city_code=$origin[0]['city_code'];
        $o_city_zone=$origin[0]['city_zone'];
        $o_city_reporting=$origin[0]['reporting_city'];
        //==============Get Origin City ID & Name=====================  
        //=========================================================END

        //==============Get Rate Type and Rate Detail=================
        if($d_city==3 || $d_city==4){$d_city=4;}
        if($o_city==3 || $o_city==4){$o_city=4;}
        if($o_city_zone==$d_city_zone && $o_city==$d_city){ $rate_type="WC";}
        else if($o_city_zone==$d_city_zone && $o_city!=$d_city){ $rate_type="SZ";}
        else if($o_city_zone!=$d_city_zone){$rate_type="DZ"; }
        else {$rate_type="UK";}
        
        //=END============Calculate Rate
        $calcu=$this->new_zone_rating_module($o_city,$d_city,$customer_id,$ship_type,$o_weight,$cal_type);
        $order_rate           = 0;
        $order_add_rate         = 0;
        $order_gst            = $calcu->my_gst;
        $order_sc             = $calcu->my_amount;
        $order_sp_handling_rate     = 0;
        $order_cash_handling_rate     = 0;
        $order_fuel           = 0;
        $order_flyer_rate         = 0;
        $order_total_amount_with_flyer  = 0;
        $order_total_amount       = (($order_gst) + ($order_sc));
        $rate_type                      ='ZW';
        $rate_id                        = $calcu->my_rate_id;
          $dcheck=$this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $ship_type, 'customer_id', $customer_id, 'origin_city_id', $o_city, 'dest_city_id', $d_city, 'is_enable', '1');
        if($dcheck!=0){
        $calcu2=$this->new_destination_rating_module($o_city,$d_city,$customer_id,$ship_type,$o_weight,$cal_type);
        $order_rate           = 0;
        $order_add_rate         = 0;
        $order_gst            = $calcu2->my_gst;
        $order_sc             = $calcu2->my_amount;
        $order_sp_handling_rate     = 0;
        $order_cash_handling_rate     = 0;
        $order_fuel           = 0;
        $order_flyer_rate         = 0;
        $order_total_amount_with_flyer  = 0;
        $order_total_amount       = (($order_gst) + ($order_sc));
        $rate_type                      ='DW';
        $rate_id                        = $calcu2->my_rate_id;    
        }
        if($cod==""){
        $cod=0;    
        }
        echo "<br>OrderGST ".$order_gst;
        if($order_gst=="" || $order_gst==null){
        $order_gst=0;    
        }

        $ip= $_SERVER['REMOTE_ADDR'];
        //=========================================================END  
        
        $data = array(
        'weight'            =>  $o_weight,
        'pieces'            =>  $o_piece,
        'order_rate'          =>  $order_rate,
        'order_add_rate'        =>  $order_add_rate,
        'order_gst'           =>  $order_gst,
        'order_sc'            =>  $order_sc,
        'order_sp_handling_rate'    =>  $order_sp_handling_rate,
        'order_cash_handling_rate'    =>  $order_cash_handling_rate,
        'order_fuel'          =>  $order_fuel,
        'order_flyer_rate'        =>  $order_flyer_rate,
        'order_total_amount_with_flyer' =>  $order_total_amount_with_flyer,
        'order_total_amount'            =>  $order_total_amount, 
        'delivery_rider_id'       =>  '0',
        'order_cr'            =>  'N',
        'order_receive_amount'      =>  '0',
        'origin_reporting'              =>  $o_city_reporting,
        'destination_reporting'         =>  $d_city_reporting, 
        'rate_id'           =>  $rate_id ,
        'modify_by'             =>  $_SESSION['user_id'],
        'modify_date'         =>  date('Y-m-d H:i:s')
        );
        $this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);
        $this->db->trans_complete(); 
         }
       }
       }
    // Update Pieces, Weight & Rate END
    // Update Arrival sheet status 
    $data =array('is_complete'  => 1);
  $this->Commonmodel->Update_record('saimtech_arrival_list', 'arrival_sheet_code', $sheet_code, $data);   
    // Update Arrival sheet status -END
    redirect('Arrival');  
    }

    }


   public function new_zone_rating_module($origin_city_id,$destination_city_id,$customer_id,$service_type_id,$wgt,$cal_type){
    $origin_region="";
    $dest_zone="";
    $calcu="";
    //-------------Get Region By (Origin)City ID    
    $origin_region_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_id', $origin_city_id);
    if(!empty($origin_region_data)){
    $origin_region=$origin_region_data[0]['mixture'];    
    //-------------
    //-------------Get Zone By (Destination)City ID
    $query="SELECT ".$origin_region." FROM `saimtech_city` WHERE `city_id`=".$destination_city_id;
    $dest_zone_data=$this->Commonmodel->Custom_Query_Array($query);
    if(!empty($dest_zone_data)){
    $dest_zone=$dest_zone_data[0][$origin_region];    
    //$zone_rate_data=$this->Commonmodel->Get_record_by_condition_double_array('saimtech_rate', 'customer_id', $customer_id, 'service_id' ,$service_type_id);
    $zone_rate_data=$this->Commonmodel->Get_record_by_triple_condition('saimtech_rate', 'customer_id', $customer_id, 'service_id' ,$service_type_id,'is_enable', '1');
   // echo"<pre>";print_r( $zone_rate_data);exit();
    if(!empty($zone_rate_data)){
    $rate_id=$zone_rate_data[0]['rate_id'];    
    //=A============Zone A
    $zone_a_wgt1=$zone_rate_data[0]['sc_wgt1']; 
    $zone_a_wgt2=$zone_rate_data[0]['sc_wgt2']; 
    $zone_a_add_wgt=$zone_rate_data[0]['sc_add_wgt']; 
    $zone_a_rate1=$zone_rate_data[0]['sc_rate1']; 
    $zone_a_rate2=$zone_rate_data[0]['sc_rate2'];
    $zone_a_add_rate=$zone_rate_data[0]['sc_add_rate'];
    $zone_a_gst=$zone_rate_data[0]['sc_gst_rate'];
    if($dest_zone=="A"){
    $zone_A=$this->calculate_rate($wgt,$zone_a_wgt1, $zone_a_rate1, $zone_a_wgt2, $zone_a_rate2, $zone_a_add_wgt, $zone_a_add_rate, $zone_a_gst, $rate_id,$cal_type);
    $calcu=json_decode($zone_A);
    }
  //=A============END
    //=B============Zone B
    $zone_b_wgt1=$zone_rate_data[0]['sz_wgt1']; 
    $zone_b_wgt2=$zone_rate_data[0]['sz_wgt2']; 
    $zone_b_add_wgt=$zone_rate_data[0]['sz_add_wgt']; 
    $zone_b_rate1=$zone_rate_data[0]['sz_rate1']; 
    $zone_b_rate2=$zone_rate_data[0]['sz_rate2'];
    $zone_b_add_rate=$zone_rate_data[0]['sz_add_rate'];
    $zone_b_gst=$zone_rate_data[0]['sz_gst_rate'];
    if($dest_zone=="B"){
    $zone_B=$this->calculate_rate($wgt,$zone_b_wgt1, $zone_b_rate1, $zone_b_wgt2, $zone_b_rate2, $zone_b_add_wgt, $zone_b_add_rate, $zone_b_gst, $rate_id,$cal_type);
    $calcu=json_decode($zone_B);
    }
  //=B============END
  //=C============Zone C
  $zone_c_wgt1=$zone_rate_data[0]['dz_wgt1']; 
    $zone_c_wgt2=$zone_rate_data[0]['dz_wgt2']; 
    $zone_c_add_wgt=$zone_rate_data[0]['dz_add_wgt']; 
    $zone_c_rate1=$zone_rate_data[0]['dz_rate1']; 
    $zone_c_rate2=$zone_rate_data[0]['dz_rate2'];
    $zone_c_add_rate=$zone_rate_data[0]['dz_add_rate'];
    $zone_c_gst=$zone_rate_data[0]['dz_gst_rate'];
    if($dest_zone=="C"){
    $zone_C=$this->calculate_rate($wgt,$zone_c_wgt1, $zone_c_rate1, $zone_c_wgt2, $zone_c_rate2, $zone_c_add_wgt, $zone_c_add_rate, $zone_c_gst, $rate_id,$cal_type);
    $calcu=json_decode($zone_C);
    }
  //=C============END
  //=D============Zone D
  $zone_d_wgt1=$zone_rate_data[0]['zz_wgt1']; 
    $zone_d_wgt2=$zone_rate_data[0]['zz_wgt2']; 
    $zone_d_add_wgt=$zone_rate_data[0]['zz_add_wgt']; 
    $zone_d_rate1=$zone_rate_data[0]['zz_rate1']; 
    $zone_d_rate2=$zone_rate_data[0]['zz_rate2'];
    $zone_d_add_rate=$zone_rate_data[0]['zz_add_rate'];
    $zone_d_gst=$zone_rate_data[0]['zz_gst_rate'];
    if($dest_zone=="D"){
    $zone_D=$this->calculate_rate($wgt,$zone_d_wgt1, $zone_d_rate1, $zone_d_wgt2, $zone_d_rate2, $zone_d_add_wgt, $zone_d_add_rate, $zone_d_gst, $rate_id,$cal_type);
    $calcu=json_decode($zone_D);
    }
  //=D============END
    } else {echo("|ZR|Something Went Wrong."); } 
    } else {echo("|Z|Something Went Wrong."); }    
    } else {echo("|R|Something Went Wrong.");}
    return $calcu;
    }
    
    public function new_destination_rating_module($origin_city_id,$destination_city_id,$customer_id,$service_id,$wgt,$cal_type){
    $calcu=0;
    $check=$this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $service_id, 'customer_id', $customer_id, 'origin_city_id', $origin_city_id, 'dest_city_id', $destination_city_id, 'is_enable', '1');
    if($check>0){
    $rate_detail=$this->Commonmodel->Get_record_by_five_condition('saimtech_destination_rate', 'service_id', $service_id, 'customer_id', $customer_id, 'origin_city_id', $origin_city_id, 'dest_city_id', $destination_city_id, 'is_enable', '1');
    if(!empty($rate_detail)){
    $calcu=$this->calculate_rate($wgt,$rate_detail[0]['city_wgt1'], $rate_detail[0]['city_rate1'], $rate_detail[0]['city_wgt2'], $rate_detail[0]['city_rate2'], $rate_detail[0]['city_add_wgt'], $rate_detail[0]['city_add_rate'], $rate_detail[0]['city_gst'], $rate_detail[0]['dest_rate_id'],$cal_type);    
    $calcu=json_decode($calcu);
        
    }    
    }
    return $calcu;
    }



    public function calculate_rate($wgt,$wgt1, $rate1, $wgt2, $rate2, $add_wgt, $add_rate, $gst, $rate_id,$cal_type){
    //-----Initiate Varibles
    //echo($wgt." ".$wgt1." ".$rate1." ".$wgt2." ".$rate2." ".$add_wgt." ".$add_rate." ".$gst." ".$rate_id);
    echo $cal_type;
    $my_amount=0;
    $my_wht=0;
    $f_wht=0;
    $total_wht=0;
    $my_gst=0;
    $sum=0;
    //---------------------
    $f_weight=0;
    $my_additional_rate=0;
    //------Order Weight Under Weight1
    if($wgt <= $wgt1){
    $my_amount   = $rate1;}
    //END---Order Weight Under Weight1
        //------Order Weight Under Weight2
        else if($wgt <= $wgt2){
    $my_amount   =  $rate2; }
    //END---Order Weight Under Weight2
    //------Order Weight Above Weight2 (Additonal Rate)
        else if($wgt > $add_wgt && $cal_type!="Multiplication"){
    $my_wht    = $wgt - $wgt2;
    $f_wht     = ceil(($my_wht) /  ($add_wgt));
    $total_wht   =  $add_rate * $f_wht;
        $my_amount   = $rate2 + $total_wht; }
        else if($wgt > $add_wgt && $cal_type=="Multiplication" ){
        $my_amount   = $add_rate * $wgt;
        }
        //END---Order Weight Above Weight2 (Additonal Rate) 
         //------GST Calculation 
        $sum=$my_amount;
        //echo $sum;exit();
        if($gst!=0 && $gst!=""){
        $my_gst=round(((($sum)*($gst))/100),2);
        } else {
        $my_gst=0;    
        }
        //END---GST Calculation
        $arr= array(
        'my_amount'     => $my_amount,
    'my_wht'      => $my_wht,
    'f_wht'       => $f_wht,
    'total_wht'     => $total_wht,
    'my_gst'      => $my_gst,
    'my_rate_id'    => $rate_id);
        return json_encode($arr);

  }
	public function print_arrival_sheet($sheet_code){
	$sheet_data=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code($sheet_code);
	$sheet_data_archive=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code_Archive($sheet_code);
	$sheet_data_archive_archive=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code_Archive_Archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheet_data_archive,$sheet_data_archive_archive);
	$this->load->view('module_arrival/printarrivalView',$data);
	}

	public function view_arrival_sheet($sheet_code){
	$sheet_data=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code($sheet_code);
	$sheet_data_archive=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code_Archive($sheet_code);
	$sheet_data_archive_archive=$this->Arrivalmodel->Get_Arrival_Print_Sheet_By_code_Archive_Archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheet_data_archive,$sheet_data_archive_archive);
	$this->load->view('module_arrival/arrivalpreviewView',$data);
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


	public function insert_tracking_detail($id,$event,$locationid,$location,$message,$date,$ip,$userid,$cdate){
	$data = array(	
	'order_id' 				=> $id,
	'order_event'			=> $event,	
	'order_location'		=> $locationid,
	'order_location_name'	=> $location,
	'order_message'			=> $message,
	'order_event_date'		=> $date,
	'order_ip'				=> $ip,
	'created_by'			=> $userid,
	'created_date'			=> $cdate
	);
	$insert_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
	} 

    public function boost_up_arrival(){
  // $boost_up_numbers = $this->Arrivalmodel->Get_Boost_Up_Arrival_Record();
    $this->Arrivalmodel->Run_Boost_Up();
    echo("<p class='alert alert-info'>System Boost Up Arrival Module </p>");
    }
    
    public function cp(){
    $this->Arrivalmodel->Run_Boost_Up();
    echo("<center><p class='alert alert-success'>Arrival Archived successfully... Now Enjoy the System Speed.</p></center>");    
    }
}
