<?php

class Debagging extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
     $this->load->model('Baggingmodel');
    $this->load->model('Debaggingmodel');
    }


	public function index(){
	$_SESSION['bagging_sheet_code']="";	
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Debagging";	
	$data['event_name']="Debgging";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['debagging_sheets']=$this->Debaggingmodel->Get_Debagging_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_debaging/debaggingView',$data);	
	}
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Debagging";	
	$data['event_name']="Debagging";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$debagging_sheets=$this->Debaggingmodel->Get_Debagging_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$debagging_sheets_archive=$this->Debaggingmodel->Get_Debagging_Sheets_By_Origin_Archive($_SESSION['origin_id'],$startdate,$enddate);
	$data['debagging_sheets']=array_merge($debagging_sheets,$debagging_sheets_archive);
	$this->load->view('module_debaging/debaggingView',$data);	
	}
	
	public function create_debagging_sheet_view(){
	$_SESSION['bagging_sheet_code']="";	
	$this->load->view('module_debaging/debaggingcreateView');	
	}

	public function debagging_short_excess(){
	$bagging_code 	= $this->input->post('bag_code');
	if($bagging_code!=""){
	$_SESSION['bagging_sheet_code']=$bagging_code;	
	echo $this->Debaggingmodel->Get_Calculate_Bags_By_Code($bagging_code);	
	}	
	}


	public function check_bag(){
	$bag_code=$this->input->post('bag_code');
	$chk=0;		
	if($bag_code!=""){
	$chk=$this->Debaggingmodel->Check_Bag($bag_code);		
	}
	echo $chk;
	}

	public function debagging_process(){
	$this->db->trans_start();	
	$cn 				= $this->input->post('cn');
	$date 				= date('Y-m-d H:i:s');
	$bagcode 			= $this->input->post('bag_code');
	$origin 			= $_SESSION['origin_id'];
	$order_status 		= "";
	$order_detail 		= "";
	$sheet_check 		= "";
	$order_status 		= "";
	$order_id 			= "";
	$bagging_id 		= 0;
	$bagging_code 		= "";
	$cn_check			= $this->Debaggingmodel->Check_CN($cn);
	$bag_detail			= $this->Debaggingmodel->Get_Bag_Detail($bagcode);
	$is_final           = "";
	$_SESSION['bagging_sheet_code']="";
	//-----------------------------------------
	if($cn_check>0){	
	 if($cn!="" && $date!="" && $bagcode!="" && $origin!="" ){
		
		$order_detail=$this->Debaggingmodel->Get_Order_By_Code($cn);
		$order_status	= $order_detail[0]['order_status'];
		$order_weight	= $order_detail[0]['weight'];
		$is_final		= $order_detail[0]['is_final'];
		$is_bagging		= $order_detail[0]['is_bagging'];
		$is_loading		= $order_detail[0]['is_loading'];
		$is_unloading	= $order_detail[0]['is_unloading'];
		$order_id 		= $order_detail[0]['order_id'];
		$bagging_code 	= $bag_detail[0]['bagging_code'];
		$_SESSION['bagging_sheet_code']=$bagging_code;
		$sheet_check	= $this->Debaggingmodel->Check_Cn_BAG($bagcode,$cn);
		//------------------------------------
		if($sheet_check==1){
		if($order_status=="UN Loading"  && $is_final==0 && $is_bagging==1 && $is_loading==1 && $is_unloading==1){
		 	//------------------------------------
		 	// Update Bagging Detail ID
		 	$data = array('is_debagging' => 1);	
		 	$this->Commonmodel->Update_record('saimtech_bagging_detail', 'order_code', $cn, $data);
		 	
		 	//------------------------------------	
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=> 'De Bagging',
		 	'is_debagging'		=>	1,
		 	'debagging_id'		=> $bagging_code,
		 	'modify_by'		    => $_SESSION['user_id'],
	        'modify_date'		=> date('Y-m-d H:i:s')
		 	);
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 	
		 	//Insert into Order Detail
		 	$city_data=$this->Debaggingmodel->Get_City_Detail_By_id($origin);
		 	$origin_name=$city_data[0]['city_name']; 
		 	$order_message='Shipment Has Arrived at Origin Hub';
		 	$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'De Bagging', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> $origin_name, 
		 	'order_message' 	 => 'De Bagged at destination &nbsp'.$origin_name, 
		 	'order_ip'			 =>	$this->get_client_ip(),
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	
		 	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 
				} else {
		echo("<tr><td><p class='alert alert-danger'>This CN is Not Eligible For Debagging</p></td><td></td><td></td><td></td></tr>");
		}	
		//}

		} else if($sheet_check==0 && $is_final!=1) {
		$city_data=$this->Debaggingmodel->Get_City_Detail_By_id($origin);
		$origin_name=$city_data[0]['city_name']; 
		$this->db->trans_start();
			$data = array(
				'cn' 				=> $cn, 
				'type'				=> 'Shipment', 
				'previous_status'	=> $order_status, 
				'new_status' 		=> 'EM De Bagging', 
				'remark' 			=> 'Excess shipment found at the time of Debagging at '.$origin_name, 
				'created_by' 		=> $_SESSION['user_id'], 
				'created_date' 		=> date('Y-m-d H:i:s'), 
				'modify_by' 		=> '0', 
				'modfiy_date' 		=> '0000-00-00 00:00:00', 
				'created_origin'  	=> $origin, 
				'modify_origin'     => '0');	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_short_excess', $data);	
		/*$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'De Bagging', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> $origin_name, 
		 	'order_message' 	 => 'De Bagged At Destination &nbsp '.$origin_name, 
		 	'order_ip'			 =>	$this->get_client_ip(),
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	

		$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
          
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=> 'De Bagging',
		 	'is_debagging'		=>	1,
		 	'debagging_id'		=> $bagging_code	
		 	);
	
		$id=$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);*/
		 //Update Bagging Detail ID
		$this->db->trans_complete();
		//$data = array('is_debagging' => 1);	
		//$id=$this->Commonmodel->Update_record('saimtech_bagging_detail', 'order_code', $cn, $data);
		
		echo("<tr><td><p class='alert alert-warning'>Excess shipment found.</p></td><td></td><td></td><td></td></tr>");	
		//------------------------------------	
		}
	 } else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td></tr>");		
	 }
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Found :(</p></td><td></td><td></td><td></td></tr>");		
	} 
	$this->db->trans_complete();

	$this->redraw_table($bagging_code);
	//-----------------------------------------
	}

	

	public function redraw_table($code){
	$debagging_data=$this->Debaggingmodel->Get_Debagging_Cn_Detail($code);
	if(!empty($debagging_data)){
    foreach($debagging_data as $rows){
    echo("<tr>");
    echo("<td>".$rows['order_code']."</td>");
    echo("<td>".$rows['bagging_code']."</td>");
    echo("<td>".$rows['bagging_seal']."</td>");
   	echo("</tr>");  
     }}
	}

    
    public function complete_sheet(){
    	echo $sheet_code = $_SESSION['bagging_sheet_code'];
    	$short=$this->Debaggingmodel->Get_Short_Count($sheet_code);
		$data =array(
		'is_debagging'			=> '1',
		'debagging_origin' 		=> $_SESSION['origin_id'], 
		'debagging_created_by'	=> $_SESSION['user_id'], 
		'is_debagging_complete' => '1', 
		'debagging_date'		=> date('Y-m-d H:i:s'), 
		'debagging_short'		=> $short
		); 
		$this->Commonmodel->Update_record('saimtech_bagging_list', 'bagging_code', $sheet_code, $data);	
    	redirect('Debagging');
    	
    }




    
	public function print_debagging_sheet($sheet_code){
	$sheet_data=$this->Debaggingmodel->Get_debagging_Print_Sheet_By_code($sheet_code);
	$sheets_data=$this->Debaggingmodel->Get_debagging_Print_Sheet_By_code_Archive($sheet_code);
	$sheets_archive_data=$this->Debaggingmodel->Get_Debagging_Print_Sheet_By_code_Archive_Archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheets_data,$sheets_archive_data);
	$this->load->view('module_debaging/printdebagginglView',$data);
	}

	public function view_debagging_sheet($sheet_code){
	$sheet_data=$this->Debaggingmodel->Get_debagging_Print_Sheet_By_code($sheet_code);
	$sheets_data=$this->Debaggingmodel->Get_debagging_Print_Sheet_By_code_Archive($sheet_code);
	$sheets_archive_data=$this->Debaggingmodel->Get_Debagging_Print_Sheet_By_code_Archive_Archive($sheet_code);
	$data['sheet_data']=array_merge($sheet_data,$sheets_data,$sheets_archive_data);
	$this->load->view('module_debaging/debaggingpreviewView',$data);
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

	

	
}
