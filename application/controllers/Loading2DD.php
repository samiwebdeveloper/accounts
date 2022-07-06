<?php

class Loading2DD extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Loadingmodel');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loading2DD";	
	$data['event_name']="Loading2DD";
	//$data['pending_un_loading_sheets']=$this->Loadingmodel->Get_Pending_Un_Loading_Sheets_By_Origin($_SESSION['origin_id']);
	$data['pending_un_loading_sheets']=$this->Loadingmodel->Get_Pending_Un_Loading_Sheets();
	$this->load->view('module_loading2dd/loading2ddView',$data);	
	}
	
	public function loading_print($id){
	if($id!=""){
	$data['sheet_data']=$this->Loadingmodel->Get_Loading_Sheet_By_ID($id);
	$data['destination_data']=$this->Loadingmodel->Get_Loading_Sheet_Detail_Destination_By_ID($id);
	$this->load->view('module_transit/printtransitView',$data);}	
	}
	
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loading";	
	$data['event_name']="Loading";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['loading_sheets']=$this->Loadingmodel->Get_Loading_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_transit/transitView',$data);	
	}
	
	
	public function create_Loading_sheet_view(){
	$data['route_data']=$this->Commonmodel->Get_record_by_condition('saimtech_route_list', 'is_enable', 1);	
	$data['loading_sheet_code']=$this->get_loading_sheet_code();
	$data['loading_sheet_data']="";
	$this->load->view('module_transit/transitcreateView',$data);	
	}


    
    public function redraw_table(){
    $pending_un_loading_sheets=$this->Loadingmodel->Get_Pending_Un_Loading_Sheets();
    if(!empty($pending_un_loading_sheets)){
    foreach($pending_un_loading_sheets as $rows){
    $i=$i+1;  
  echo("<tr>");  
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->tDate."</center></td>");  
echo("<td><center>".$rows->ActaulD."</center></td>");
echo("<td><center>".$rows->loading_id."</center></td>");
echo("<td><center>".$rows->transit_cn." / ".$rows->manual_cn."</center></td>");
echo("<td><center>".$rows->pieces."</center></td>");
echo("<td><center>".$rows->weight."</center></td>");
echo("<td><center>".$rows->transit_shipper."</center></td>");
echo("<td><center>".$rows->consignee_detail."</center></td>");
echo("<td><center>".$rows->cod_amount."</center></td>");
echo("<td><button class='btn btn-xs btn-primary' data-toggle='modal' data-target='#exampleModal'  onclick='fill_deliverd_model(".$rows->transit_detail_id.")'>Delivered</button></td>");
echo("<td><button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#exampleModal2'  onclick='fill_not_delivered_model(".$rows->transit_detail_id.")'>Not Deliverd</button></td>");
    
echo("</tr>");}    
    }
    }
    
    public function complete_sheet(){
    redirect('Loading');    
    }
	
	public function fill_model($id){
	$detail_data=$this->Loadingmodel->Get_Loading_Detail_By_Detail_ID($id);
	$data_array = array();
	$data_array['cn']			= $detail_data[0]['transit_cn'];
	$data_array['detail_id']	= $id;  
	echo json_encode($data_array);	
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
	
	public function delivered(){
	$cn = $this->input->post('cn');
	$received_by = $this->input->post('received_by');	
	$id = $this->input->post('id');
	$ip =$this->get_client_ip();	
	$delivery_rider =0;
	if($cn!="" &&  $received_by!=""){
	$data = array(
	'order_status' 			=>'Deliverd',
	'order_deliver_date'   	=> date('Y-m-d H:i:s'),
	'order_result_date'     => date('Y-m-d H:i:s'),
	'order_rr_date'   		=> date('Y-m-d H:i:s'),
	'shipment_received_by'	=> $received_by,
	'is_final'				=> 1	
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);	
	//Insert into Order Detail
	$city_data=$this->Deliverymodel->Get_City_Detail_By_id($_SESSION['origin_id']);
	$origin_name=$city_data[0]['city_name']; 
	$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
	$order_id=$order_detail[0]['order_id'];
	$order_message='Shipment has been Delivered.';
	$data = array(
	'order_id' 				=> $order_id, 
	'order_event' 		 	=> 'Delivered', 
	'order_location' 	 	=> $_SESSION['origin_id'], 
	'order_location_name'	=> $origin_name, 
	'order_message' 	 	=> $order_message, 
	'order_ip'			 	=> $ip,
	'order_event_date'	 	=> date('Y-m-d H:i:s'),
	'created_by' 		 	=> $_SESSION['user_id'],  
	'created_date' 			=> date('Y-m-d H:i:s') );	
	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);	
	//Update Delivery Detail
	$data = array(
	//SELECT  `is_unload`, `unload_date`, `transit_date`, `unload_origin`, `created_by`, `modify_by` FROM `saimtech_transit_detail` WHERE 1
	'is_unload' 		=> '1',
	'unload_date' 		=> date('Y-m-d H:i:s'),
	'unload_origin' 	=> $_SESSION['origin_id'],
	'modify_by'         => $_SESSION['user_id']
	);
	$this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_detail_id', $id, $data);		
	}
	$this->redraw_table();
	}
	
	public function not_deliver_view($cn){
	    
	}
	
	public function not_delivered(){
	$cn = $this->input->post('cn');
	$remark = $this->input->post('remark');
	$status = $this->input->post('status');
	$id = $this->input->post('id');
	$ip =$this->get_client_ip();	
	if($cn!="" && $status!=""){
	if($status=="RTS"){
	$data = array(
	'order_status' 			=>$status,
	'order_result_date'     => date('Y-m-d H:i:s'),
	'is_final'				=> 1);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);	
	} else {
	$data = array(
	'order_status' 			=>$status,
	'order_result_date'     => date('Y-m-d H:i:s'),
	'is_final'				=> 0);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);	
	}

	//Insert into Order Detail
	$city_data=$this->Deliverymodel->Get_City_Detail_By_id($_SESSION['origin_id']);
	$origin_name=$city_data[0]['city_name']; 
	$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
	$order_id=$order_detail[0]['order_id'];
	$order_message='Shipment has been '.$status." (".$remark.")";
	$data = array(
	'order_id' 				=> $order_id, 
	'order_event' 		 	=> $status, 
	'order_location' 	 	=> $_SESSION['origin_id'], 
	'order_location_name'	=> $origin_name, 
	'order_message' 	 	=> $order_message, 
	'order_ip'			 	=> $ip,
	'order_event_date'	 	=> date('Y-m-d H:i:s'),
	'created_by' 		 	=> $_SESSION['user_id'],  
	'created_date' 			=> date('Y-m-d H:i:s') );	
	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);	
	//Update Delivery Detail
	$data = array(
	//SELECT  `is_unload`, `unload_date`, `transit_date`, `unload_origin`, `created_by`, `modify_by` FROM `saimtech_transit_detail` WHERE 1
	'is_unload' 		=> '1',
	'unload_date' 		=> date('Y-m-d H:i:s'),
	'unload_origin' 	=> $_SESSION['origin_id'],
	'modify_by'         => $_SESSION['user_id']
	);
	$this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_detail_id', $id, $data);	
	}
	$this->redraw_table();    
	}
}
