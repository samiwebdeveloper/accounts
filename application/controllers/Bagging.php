<?php

class Loading extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Baggingmodel');
    }


	public function index(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loading";	
	$data['event_name']="Loading";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	//$data['loading_sheets']=$this->Loadingmodel->Get_Loading_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_loading/loadingView',$data);	
	}
	
	
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Bagging";	
	$data['event_name']="Bgging";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$bagging_sheets=$this->Baggingmodel->Get_Bagging_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$bagging_sheets_archive=$this->Baggingmodel->Get_Bagging_Sheets_By_Origin_Archive($_SESSION['origin_id'],$startdate,$enddate);
	$data['bagging_sheets']=array_merge($bagging_sheets,$bagging_sheets_archive);
	$this->load->view('module_baging/baggingView',$data);	
	}
	
	
	public function create_bagging_sheet_view(){
	$user_id=1;
	$data['bagging_sheet_code']="";
	$data['arrival_sheet_data']="";
	$data['cities_data']="";
	$arrival_id=0;
	$data['cities_data']=$this->Commonmodel->Get_record_by_condition('saimtech_city', 'is_enable', 1);	
	$check=$this->Baggingmodel->Get_Incomplete_Bagging_Sheet_Count($_SESSION['user_id']);	
	if($check>0){
	$sheet_detail=$this->Baggingmodel->Get_Incomplete_bagging_Sheet($_SESSION['user_id']);	
	$data['bagging_sheet_code']=$sheet_detail[0]['sheetcode'];
	$data['bagging_sheet_data']=$this->Baggingmodel->Get_Bagging_Sheet_By_code($sheet_detail[0]['sheetcode']);
	} else {
	$data['bagging_sheet_code']=$this->get_bagging_sheet_code();
	$data['bagging_sheet_data']="";
	}	
	$this->load->view('module_baging/baggingcreateView',$data);	
	}

	public function bagging_process(){
	$cn 				= $this->input->post('cn');
	$date 				= date('Y-m-d H:i:s');
	$barcode 			= $this->input->post('barcode');
	$seal_no 			= $this->input->post('seal_no');
    $destination 		= $this->input->post('destination');
	$bagging_sheet_code = $this->input->post('bagging_sheet_code');
	$origin 			= $_SESSION['origin_id'];
	$order_status 		= "";
	$order_detail 		= "";
	$sheet_check 		= "";
	$order_status 		= "";
	$order_id 			= "";
	$bagging_id 		= 0;
	$cn_check			= $this->Baggingmodel->Check_CN($cn);
	//-----------------------------------------
	if($cn_check>0){	
	 if($cn!="" && $date!="" && $barcode!="" && $bagging_sheet_code!="" && $seal_no!="" && $origin!="" && $destination!=""){
		$this->db->trans_start();
		$order_detail 		=$this->Baggingmodel->Get_Order_By_Code($cn);
		$sheet_check 		=$this->Baggingmodel->Check_Bagging_Sheet_Code($bagging_sheet_code);
		$order_status		= $order_detail[0]['order_status'];
		$order_weight		= $order_detail[0]['weight'];
 	    $order_destination	= $order_detail[0]['destination_city'];
		$is_final			= $order_detail[0]['is_final'];
		$is_bagging			= $order_detail[0]['is_bagging'];
		$order_id 			= $order_detail[0]['order_id'];
		//------------------------------------
		if($order_status=="Arrival" && $is_final==0 && $is_bagging==0){
			if($order_destination==$destination){
		 	//------------------------------------
		 	if($sheet_check<1){
		 	$data = array(
		 	'bagging_code' 		 	=> $bagging_sheet_code, 
		 	'bagging_barcode' 		=> $barcode,
		 	'bagging_type' 			=> 'Normal', 
		 	'bagging_seal' 			=> $seal_no,
		 	'bagging_date' 		 	=> date('Y-m-d'), 
		 	'bagging_origin' 	 	=> $origin, 
		 	'bagging_destination' 	=> $destination, 
		 	'is_complete' 		 	=> '0', 
		 	'is_debagging' 		 	=> '0',
		 	'ip' 		 			=> $_SERVER['REMOTE_ADDR'], 
		 	'created_by' 		 	=> $_SESSION['user_id'], 
		 	'created_date' 		 	=> $date, 
		 	'modify_by'			 	=> '0', 
		 	'modify_date'		 	=> '0000-00-00 00:00:00'
		 	);	
		 	$bagging_id=$this->Commonmodel->Insert_record('saimtech_bagging_list', $data);
		 	} else {
		 	$bagging_data=$this->Baggingmodel->Get_Bagging_Status_By_Code($bagging_sheet_code);	
		 	$bagging_id=$bagging_data[0]['bagging_list_id'];
		 	}
		 	//------------------------------------	
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=> 'Bagging',
		 	'is_bagging'		=>	1,
		 	'bagging_id'		=> $bagging_sheet_code,
		 	'modify_by'		    => $_SESSION['user_id'],
		 	'modify_date'		=> $date
		 	);
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 	//Insert into Order Detail
		 	$city_data=$this->Arrivalmodel->Get_City_Detail_By_id($origin);
		 	$origin_name=$city_data[0]['city_name']; 
		 	$order_message='Shipment Has Arrived at Origin Hub';
		 	$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'Bagging', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> $origin_name, 
		 	'order_message' 	 => 'Your shipment has bagged  at origin&nbsp'.$origin_name.' '.$bagging_sheet_code, 
		 	'order_ip'			 =>	$_SERVER['REMOTE_ADDR'],
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	
		 	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 	//Insert into bagging detail
		 	$data = array(
		 	'bagging_list_id' 	 => $bagging_id, 
		 	'order_code' 		 => $cn,
		 	'bagging_dbarcode' 	 => $barcode,
		 	'bagging_dseal' 	 => $seal_no, 
		 	'bagging_weight' 	 => $order_weight, 
		 	'order_detail_id' 	 => $detail_id, 
		 	'bagging_date'		 => date('Y-m-d'), 
		 	'is_debagging'		 => 0, 	
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );
		 	$bagging_detail_id=$this->Commonmodel->Insert_record('saimtech_bagging_detail', $data);	
		 	$this->db->trans_complete();
	} else {
	echo("<tr><td><p class='alert alert-danger'>Given CN belongs to another destination.</p></td><td></td><td></td><td></td><td></td><td></td></tr>");	
	}
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Eligible For Bagging</p></td><td></td><td></td><td></td><td></td><td></td></tr>");		
	}
		//------------------------------------	
		
	 } else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td><td></td><td></td></tr>");		
	 }
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Found :(</p></td><td></td><td></td><td></td><td></td><td></td></tr>");		
	} 
	$this->redraw_table($bagging_sheet_code);
	//-----------------------------------------
	}

	public function get_bagging_sheet_code(){
	$code=$this->Baggingmodel->Get_Last_bagging_Sheet_Code();
	$prefix="BAG".date('y');
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
	$bagging_sheet_data=$this->Baggingmodel->Get_Bagging_Sheet_By_code($code);
	if(!empty($bagging_sheet_data)){
	$i=0;    
    foreach($bagging_sheet_data as $rows){
    $i=$i+1;    
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
    echo("<td>".$rows->cn."</td>");
    echo("<td>".$rows->date."</td>");
    echo("<td>".$rows->Sheet."</td>");
    echo("<td>".$rows->barcode."</td>");
    echo("<td>".$rows->seal."</td>");
    echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->cn.")'>Remove</button></td>");
    echo("</tr>");  
     }}
	}

	


	public function set_barcode($code){
    $targetDir = FCPATH."assets/barcode/bagging/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }

    public function remove_cn(){
    $cn=$this->input->post('cn');
    if($cn!=""){
    $this->db->trans_start();
    $order_detail 	= $this->Baggingmodel->Get_Order_By_Code($cn);	
   	$this->Commonmodel->Delete_record('saimtech_bagging_detail', 'order_code', $cn);
 	$data =array(
 	'is_bagging' 	=> 0,
 	'bagging_id' 	=> 0,
 	'order_status' 	=> 'Arrival'	
 	);
 	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
 	
 	$order_id 		= $order_detail[0]['order_id'];
 	$code 			= $order_detail[0]['bagging_id'];
 	$this->Commonmodel->Delete_record_double_condition('saimtech_order_tracking', 'order_id', $order_id, 'order_event', 'Bagging');	
    $this->db->trans_complete();
    }
	$this->redraw_table($code);
    }


  
	
    
    public function complete_sheet($sheet_code){
    // Create Arrival Sheet Barcode
       $this->set_barcode($sheet_code);
    // Create Arrival Sheet Barcode -End
    // Update Last Barcode , Last Seal No iS Complete
       $sheet_data=$this->Baggingmodel->Get_Bagging_Detail_By_Bagging_Code($sheet_code);
       if(!empty($sheet_data)){
		$barcode = $sheet_data[0]['barcode'];
		$seal 	 = $sheet_data[0]['seal'];
		$id 	 = $sheet_data[0]['id'];
		$data =array(
 		'bagging_dbarcode' 	=>  $barcode,	
		'bagging_dseal'		=>	$seal,
		); 
		$this->Commonmodel->Update_record('saimtech_bagging_detail', 'bagging_list_id', $id, $data);
		$data =array(
 		'bagging_barcode' 	=>  $barcode,	
		'bagging_seal'		=>	$seal,
		'is_complete'		=>	1
		); 
		$this->Commonmodel->Update_record('saimtech_bagging_list', 'bagging_list_id', $id, $data);	   
    // Update Last Barcode , Last Seal No iS Complete END
   
    redirect('Bagging');
    } else {
    echo("<p class='alert alert-danger'>Something went wrong please try again.</p>");	
    }	
    }




    
	public function print_bagging_sheet($sheet_code){
    $sheet_data=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code($sheet_code);
	$sheet_data_archive=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code_archive($sheet_code);
	$sheet_data_archive_archive=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code_archive_archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheet_data_archive,$sheet_data_archive_archive);
	//$data['sheets_data']=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code($sheet_code);
	$this->load->view('module_baging/printbagginglView',$data);
	}

	public function view_bagging_sheet($sheet_code){
	$sheet_data=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code($sheet_code);
	$sheet_data_archive=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code_archive($sheet_code);
	$sheet_data_archive_archive=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code_archive_archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheet_data_archive,$sheet_data_archive_archive);
	//$data['sheets_data']=$this->Baggingmodel->Get_Bagging_Print_Sheet_By_code($sheet_code);
	$this->load->view('module_baging/baggingpreviewView',$data);
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

	public function bagging_barcode(){
	$barcode=$this->input->post('barcode');
	$chk=0;		
	if($barcode!=""){
	$chk=$this->Commonmodel->Duplicate_check('saimtech_bagging_list', 'bagging_barcode', $barcode);		
	}
	echo $chk;
	}

	public function bagging_seal(){
	$seal=$this->input->post('seal_no');
	$chk=0;
	if($seal!=""){
	$chk=$this->Commonmodel->Duplicate_check('saimtech_bagging_list', 'bagging_seal', $seal);		
	}
	echo $chk;
	}
	
	
	public function boost_up_bagging(){
	$this->Baggingmodel->Run_Boost_Up();
    echo("<p class='alert alert-info'>System Boost Up Bagging Module, DE Bagging Module, RE Bagging Module & RE DE Bagging Module  </p>");
	}
	
	public function cp(){
   	$this->Baggingmodel->Run_Boost_Up();
    echo("<center><p class='alert alert-success'>Bagging Archived successfully... Now Enjoy the System Speed.</p></center>");    
    }
}
