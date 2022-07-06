<?php
//WC=With in City
//SZ=Same in Zone
//DZ=Different in Zone
//UK=Unknown
//PSB=Portal Single Booking
//PIB=Portal Import Booking
//WAB=Web Api Booking

class Booking2 extends CI_Controller {

	function __construct() {
    parent::__construct();
     date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Bookingmodel');
    $this->load->model('Pickmodel');
    }


	public function index(){
	$data['sub_nav_active']="Single";
	$data['nav_active']="Booking";	
	$data['event_name']="Single Booking";
	$cid=$_SESSION['customer_id'];
	$data['shipment_types']=$this->Commonmodel->Get_record_by_condition('saimtech_service', 'is_enable', 1);
	$data['pick_up_point']=$this->Bookingmodel->Get_Active_Pickup_Points_By_Customer_id($cid);
	if($_SESSION['is_tm']==0){
	$data['cities_data']=$this->Bookingmodel->Get_Active_Cities();
	} else {
	$data['cities_data']=$this->Bookingmodel->Get_All_Cities();
	}
	$this->load->view('module_booking/singleView',$data);	
	}
	
	
	
	
	

	
	public function print_all_address_label(){
	$cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_ALL_Label_Address($cid);
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);
	$this->load->view('module_booking/printView',$data);	
	}
	
	public function insert_temp_print(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	if($cn!="" && $customer_id !=""){
	$check=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'print_cn', $cn);
	if($check<1){	
	$data=array(
	'print_cn' 	 => $cn, 
	'customer_id'	 => $customer_id);	
	$this->Commonmodel->Insert_record('saimtech_print_label_temp', $data);}
	}
	echo $count=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'customer_id', $customer_id);
	}

	public function delete_temp_print_by_cn(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	if($cn!="" ){
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'print_cn', $cn);	
	}
	echo $count=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'customer_id', $customer_id);
	}


	public function all_delete_temp_print_by_cn(){
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);	
	echo $count=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);
	}

	public function all_insert_temp_print(){
	$order_data=$this->Bookingmodel->Get_ALL_Label_Address($_SESSION['customer_id']);
	if(!empty($order_data)){
	foreach($order_data as $rows){	
	$cn	 		 = $rows->order_code;
	$customer_id = $rows->customer_id;
	if($cn!="" && $customer_id !=""){
	$check=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'print_cn', $cn);
	if($check<1){	
	$data=array(
	'print_cn' 	 => $cn, 
	'customer_id'	 => $customer_id);	
	$this->Commonmodel->Insert_record('saimtech_print_label_temp', $data);}
	} } }
	echo $count=$this->Commonmodel->Duplicate_check('saimtech_print_label_temp', 'customer_id', $customer_id);
	}


	


	public function cancel_shipment(){
	$order_id = $this->input->post('id');
	$ip 	  = $_SERVER['REMOTE_ADDR'];
	if($order_id!=""){
	$data = array(
	'order_status'		=> 'Cancelled',
	'modify_by'			=>	$_SESSION['customer_id'],
	'modify_date'		=>	date('Y-m-d H:i:s')	
	);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);	
	$this->insert_tracking_detail($order_id,'Cancelled',$_SESSION['origin_id'],$_SESSION['origin_name'],'Your shipment has been cancelled by shipper',date('Y-m-d H:i:s'),$ip,$_SESSION['customer_id'],date('Y-m-d H:i:s'));
	}
	$this->redraw_order_table();	
	}

	public function load_sheet_view(){
	$cid=$_SESSION['customer_id'];
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_record('saimtech_order', 'customer_id', $cid, $data);
	$data['order_data']=$this->Bookingmodel->Get_Eligible_Load_Sheet($cid);		
	$data['col1_data']=$this->Commonmodel->Get_record_by_double_condition('saimtech_order', 'customer_id', $cid, 'temp_ls', 1);
	$this->load->view('module_booking/loadsheetpanel2View',$data);		
	}

	public function insert_temp_ls(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	if($cn!="" && $customer_id !=""){
	$data=array('temp_ls' 	 => 1);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $customer_id, 'temp_ls', 1);
	}
	
	public function draw_temp_ls_table(){
	$customer_id 		 = $_SESSION['customer_id'];    
    $selected_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_order', 'customer_id', $customer_id, 'temp_ls', 1);
    if(!empty($selected_data)){ $i=0;
    foreach($selected_data as $rows){
    $i=$i+1;     
    echo("<tr>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$i."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->order_code."</center></td>");
    echo("<td style='font-size:10px;padding-top:15px'><center>".$rows->weight."KG</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->order_date."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->origin_city_name."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->destination_city_name."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>Selected For LoadSheet</center></td>");
    echo("</tr>");
    }}
	}
	
	
	public function draw_eligi_ls_table(){
	$customer_id 		 = $_SESSION['customer_id'];    
    $order_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_order', 'customer_id', $customer_id, 'order_status', 'Order');
    if(!empty($order_data)){ $i=0;
    foreach($order_data as $rows){
    $i=$i+1;     
    echo("<tr>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$i."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->order_code."</center></td>");
    echo("<td style='font-size:10px;padding-top:15px'><center>".$rows->weight."KG</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->order_date."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->origin_city_name."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->destination_city_name."</center></td>");
    echo("<td style='font-size:12px;padding-top:15px'><center>".$rows->order_status."</center></td>");
    echo("</tr>");
    }}
	}

	public function delete_temp_ls_by_cn(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	if($cn!="" ){
	$data=array('temp_ls' => 0);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}	
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $customer_id, 'temp_ls', 1);
	}

	public function all_delete_temp_ls_by_cn(){
	$cid=$_SESSION['customer_id'];
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'customer_id', $cid, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1);
	}

	public function all_insert_temp_ls(){
	$cid=$_SESSION['customer_id'];
	$data=array('temp_ls' 	 => 1);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'customer_id', $cid, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1);
	}

	public function ls_cancel_shipment(){
	$cid=$_SESSION['customer_id'];	
	$order_id = $this->input->post('id');
	$ip 	  = $_SERVER['REMOTE_ADDR'];
	if($order_id!=""){
	$data = array(
	'order_status'		=> 'Cancelled',
	'modify_by'			=>	$_SESSION['customer_id'],
	'modify_date'		=>	date('Y-m-d H:i:s')	
	);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);	
	$this->insert_tracking_detail($order_id,'Cancelled',$_SESSION['origin_id'],$_SESSION['origin_name'],'Your shipment has been cancelled by shipper',date('Y-m-d H:i:s'),$ip,$_SESSION['customer_id'],date('Y-m-d H:i:s'));
	}
	$col1_data=$this->Bookingmodel->Get_Eligible_Load_Sheet($cid);
	if(!empty($col1_data)){foreach($col1_data as $rows){ 
    echo("<tr>");
    echo("<td><div class='checkbox check-danger checkbox-circle'>");
    echo("<input type='checkbox' onclick='select_function(".$rows->order_code.")' value='".$rows->order_code."' id='checkbox".$rows->order_code."'>");
    echo("<label for='checkbox".$rows->order_code."'>".$rows->order_code."</label>");
    echo("</div></td>");
    echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->origin_city_name."</center></td>");
    echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->weight."</center></td>");
    echo("<td style='font-size:13px;padding-top:18px'><center>PKR ".number_format($rows->cod_amount)."/-</center></td>"); 
    echo("<td style='font-size:13px;padding-top:18px'>");
    echo("<button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#exampleModal' onclick='cancel_shipment(".$rows->order_code.",".$rows->cod_amount.",".$rows->order_id.")'>Cancel</button>");
	echo("</td>");   
    echo("</tr>");
    } }
	}

	public function create_load_sheet(){
	//----Define Vatibles	
	$cid=$_SESSION['customer_id'];	
	$order_id="";
	$cn_array="";
	$load_sheet_id=0;
	$i=0;
	$ip 	  = $_SERVER['REMOTE_ADDR'];
	//----Start Trans
	$this->db->trans_start();
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet($cid);
	if(!empty($selected_data)){
	$sheet_code = $this->get_load_sheet_code();	
	$this->set_loadsheet_barcode($sheet_code);
	$data = array(
	'load_sheet_code'		=> 	$sheet_code,
	'load_sheet_cn'			=> 	'NULL',
	'load_sheet_shipments'	=> 	'0',	
	'load_sheet_date'		=> 	date('Y-m-d H:i:s'),
	'customer_id'			=> 	$cid,
	'created_by'			=> 	$cid,
	'created_date'			=> 	date('Y-m-d H:i:s')
	);
	$load_sheet_id=$this->Commonmodel->Insert_record('saimtech_load_sheet', $data);
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet($cid);
	foreach($selected_data as $rows){
	$order_id=$rows->order_id;
	$i=$i+1;
	if($i==1){
	$cn_array=$rows->order_code;}
	else if($i>1){
	$cn_array=$cn_array.", ".$rows->order_code;	}
	$data=array(
	'temp_ls' 	 			=> 0,
	'load_sheet_id'     	=>  $sheet_code,
	'order_status'      	=> 'Booking',
	'order_booking_date'	=> 	date('Y-m-d H:i:s'),
	);	
	$status_msg="Your Shipment has been Booked.";
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $rows->order_code, $data);
	$this->insert_tracking_detail($order_id,'Booking',$_SESSION['origin_id'],$_SESSION['origin_name'],$status_msg,date('Y-m-d H:i:s'),$ip,$cid,date('Y-m-d H:i:s'));
	}
	$data=array(	
	'load_sheet_cn'			=> 	$cn_array,
	'load_sheet_shipments'	=> 	$i);	
	$this->Commonmodel->Update_record('saimtech_load_sheet', 'load_sheet_id', $load_sheet_id, $data);
	$this->db->trans_complete();
	}
	redirect('Booking/load_sheet_view');	
	}


	public function set_loadsheet_barcode($code){
    $targetDir = FCPATH."assets/barcode/loadsheet/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }	

    public function print_load_sheet_address_label($sheetcode){
    $cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_load_sheet_label_address($sheetcode);
	$this->load->view('module_booking/printView',$data);		
    }
    
    public function print_load_sheet_address_label_3x($sheetcode){
    $cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_load_sheet_label_address($sheetcode);
	$this->load->view('module_booking/3xprintView',$data);		
    }
    
    public function print_load_sheet_address_label_one_by_one($sheetcode){
    $cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_load_sheet_label_address($sheetcode);
	$this->load->view('module_booking/printoneView',$data);		
    }

    public function print_load_sheet_mini_address_label($sheetcode){
    $cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_load_sheet_label_address($sheetcode);
	$this->load->view('module_booking/printminiView',$data);		
    }
    
    
    public function print_load_sheet_short_address_label($sheetcode){
    $cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_load_sheet_label_address($sheetcode);
	$this->load->view('module_booking/printshortView',$data);		
    }

    public function print_load_sheet($sheetcode){
    $data['print_data']=$this->Bookingmodel->Get_load_sheet_by_code($sheetcode);
    $this->load->view('module_booking/printlsView',$data);		
    }

	
    public function get_load_sheet_code(){
	$code=$this->Bookingmodel->Get_Last_Load_Sheet_Code();
	$prefix="LS".date('y');
	if(strlen($code)==1){ $precode=$prefix."000000".$code;} 
	else if(strlen($code)==2){ $precode=$prefix."00000".$code;} 
	else if(strlen($code)==3){ $precode=$prefix."0000".$code;} 
	else if(strlen($code)==4){ $precode=$prefix."000".$code;} 
	else if(strlen($code)==5){ $precode=$prefix."00".$code;}
	else if(strlen($code)==6){ $precode=$prefix."0".$code;} 
	else if(strlen($code)==7){ $precode=$prefix.$code;}
	return $precode;
	}








    



	
}
