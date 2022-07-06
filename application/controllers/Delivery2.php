<?php

class Delivery2 extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Delivery2model');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	//echo($_SESSION['origin_id']);	
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Delivery2";	
	$data['event_name']="Delivery2";
	$this->load->view('module_delivery2/delivery2View');	
	}
	
	
	public function delivery_sheet_data(){
	$sheet_code= trim($this->input->post('sheet_code'));
	if($sheet_code!=""){	
	$sheet_data=$this->Delivery2model->Get_Delivery_Sheet_By_Code($sheet_code);
	if(!empty($sheet_data)){
    $i=0;
    foreach($sheet_data as $rows){
    $i=$i+1;
    $order_detail=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'order_code', $rows->order_code);
    echo("<tr>");
    echo("<td>".$i."</td>");
     if($rows->is_delivery2==0){
    if($order_detail[0]['order_pay_mode']=="ToPay" || $order_detail[0]['order_pay_mode']=="Topay"){
    echo("<td>
    <button class='btn btn-xs btn-primary' data-toggle='modal' data-target='#exampleModal'  onclick='fill_deliverd_model(".$rows->delivery_detail_id.",1)'>Delivered</button>
    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#exampleModal2'  onclick='fill_not_delivered_model(".$rows->delivery_detail_id.")'>Not Deliverd</button>
    </td>");
    } else {
    echo("<td>
    <button class='btn btn-xs btn-primary' data-toggle='modal' data-target='#exampleModal'  onclick='fill_deliverd_model(".$rows->delivery_detail_id.",0)'>Delivered</button>
    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#exampleModal2'  onclick='fill_not_delivered_model(".$rows->delivery_detail_id.")'>Not Deliverd</button>
    </td>");
        
    }
    } else {
    echo("<td><code>No Rights</code></td>");	
    }
    echo("<td>".$rows->order_code." / ".$order_detail[0]['manual_cn']."</td>");
    echo("<td>".$rows->name."</td>");
    echo("<td>".$rows->phone."</td>");
    echo("<td>".$rows->address."</td>");
    echo("<td>".$rows->weight."</td>");
    if($order_detail[0]['order_pay_mode']=="ToPay" || $order_detail[0]['order_pay_mode']=="Topay"){
    echo("<td>".$rows->cod."</td>");
    } else {
    echo("<td>NA</td>");
    }
    echo("<td>".$rows->delivery_date."</td>");
   
    echo("</tr>"); }}  
	} else {
	echo("<center><p class='alert alert-danger'>Some Thing is Went Wrong :(</p></center>");	} 
	//$this->redraw_table($sheet_code);
	//-----------------------------------------
	}

	 
	public function not_delivered(){
	$cn = $this->input->post('cn');
	$sheet = $this->input->post('sheet');	
	$status = $this->input->post('status');
	$remark = $this->input->post('remark');
	$id = $this->input->post('id');	
	$ip =$this->get_client_ip();
	$order_message="";
	if($cn!="" && $sheet!="" && $status!="" && $id!=""){
	if($status=="RTS"){
	$order_message="Shipment has been return to shipper";
	//Update Order
	$data = array(
	'order_status' 			=>'RTS',
	'order_deliver_date'   	=> date('Y-m-d H:i:s'),
	'order_result_date'     => date('Y-m-d H:i:s'),
	'order_rr_date'   		=> date('Y-m-d H:i:s'),
	'is_final'				=> 1	
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
	}
	else if($status=="Refused"){
	$order_message="Consignee Refused Shipment";	
	} else if($status=="ICA"){
	$order_message="Incomplete Address";	
	} else if($status=="CNA"){
	$order_message="Consignee Not Available";	
	//} else if($status=="UL"){
	//$order_message="Un Located";	
	} else if($status=="HIO"){
	$order_message="Hold in Operations";	
	} else if($status=="NSA"){
	$order_message="None Service Area";	
	} else if($status=="OSA"){
	$order_message="Out of Service Area";	
	} else if($status=="RTO"){
	$order_message="Return To Origin";	
	} else if($status=="MR"){
	$order_message="Miss Route";
	} else if($status=="PI"){
	$order_message="Payment Issue";
	} else if($status=="HFC"){
	$order_message="Hold For Collection";	
	} else if($status=="CA"){
	$order_message="Close Address";	
	} else if($status=="SD"){
	$order_message="Stop Delivery";	
	}  else if($status=="Return"){
	$order_message="Return";	
	}  else if($status=="NSC"){
	$order_message="No Such Consignee At Given Address";	
	}  else if($status=="SFC"){
	$order_message="Friday/Saturday Closed";	
	} else if($status=="NCI"){
	$order_message="Undelivered shipment hold in operation for shipper/origin advice ";	
	}  else if($status=="CN"){
	$order_message="Cash Not Available";	
	}  else if($status=="EBA"){
	$order_message="Entry Banned Area";	
	}							
	//Update Order
	$data = array(
	'order_status' => $status,
	
	'modify_by'		    => $_SESSION['user_id'],
	'modify_date'		=> date('Y-m-d H:i:s')
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);		
	//Insert into Order Detail
	$city_data=$this->Deliverymodel->Get_City_Detail_By_id($_SESSION['origin_id']);
	$origin_name=$city_data[0]['city_name']; 
	$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
	$order_id=$order_detail[0]['order_id'];
	$data = array(
	'order_id' 				=> $order_id, 
	'order_event' 		 	=> $status, 
	'order_location' 	 	=> $_SESSION['origin_id'], 
	'order_location_name'	=> $origin_name, 
	'order_message' 	 	=> $order_message, 
	'order_reason'          => $remark,
	'order_ip'			 	=> $ip,
	'order_event_date'	 	=> date('Y-m-d H:i:s'),
	'created_by' 		 	=> $_SESSION['user_id'],  
	'created_date' 			=> date('Y-m-d H:i:s') );	
	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);	
	//Update Delivery Detail
	$data = array(
	'is_delivery2' 			=> '1',
	'delivery2_date' 		=> date('Y-m-d H:i:s'),	
	'delivery2_created_by' 	=> $_SESSION['user_id']
	);
	$this->Commonmodel->Update_record('saimtech_delivery_detail', 'delivery_detail_id', $id, $data);		
	//$this->Commonmodel->Delete_record('saimtech_short_excess', 'cn', $cn);
	$msg ="Dear Valued Customer,\r\n Your shipment #".$cn." was received by ".$received_by." at ".date('Y-m-d H:i:s')." For further query  call us at 0309-7777228 or visit www.delex.pk\r\nThank you for using TM Delievey Express";
	
	$data = array(
    'sms_msg'       =>$msg, 
    'sms_phone'     =>$cus_phone, 
    'sms_date'      =>date('Y-m-d'), 
    'sms_status'    =>'N',
    );	
	$sms_id=$this->Commonmodel->Insert_record('saimtech_sms', $data);   
	}
	$this->redraw_table($sheet);
	}

    	

	public function delivered(){
	$cn = $this->input->post('cn');
	$sheet = $this->input->post('sheet');
	$received_by = $this->input->post('received_by');	
	$id = $this->input->post('id');
	$ip =$this->get_client_ip();	
	$delivery_rider =0;
	if($cn!="" && $sheet!="" && $received_by!=""){
	$sheet_rider=$this->Commonmodel->Get_record_by_condition_array('saimtech_delivery_list', 'delivery_code', $sheet);    
	if(!empty($sheet_rider)){
	$delivery_rider=$sheet_rider[0]['rider_id'];     
	}
	//Update Order
	$data = array(
	'order_status' 			=>'Deliverd',
	'order_deliver_date'   	=> date('Y-m-d H:i:s'),
	'order_result_date'     => date('Y-m-d H:i:s'),
	'order_rr_date'   		=> date('Y-m-d H:i:s'),
	'shipment_received_by'	=> $received_by,
	'delivery_rider_id'     => $delivery_rider,
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
	'is_delivery2' 			=> '1',
	'delivery2_date' 		=> date('Y-m-d H:i:s'),
	'delivery2_created_by' 	=> $_SESSION['user_id'],
	'is_rr' 				=> '1',
	'rr_date' 				=> date('Y-m-d H:i:s'),
	'rr_created_by' 		=> $_SESSION['user_id']
	);
	$this->Commonmodel->Update_record('saimtech_delivery_detail', 'delivery_detail_id', $id, $data);		
	$this->Commonmodel->Delete_record('saimtech_short_excess', 'cn', $cn);
	}
	$this->redraw_table($sheet);
	}

	public function redraw_table($code){
	$sheet_data=$this->Delivery2model->Get_Delivery_Sheet_By_Code($code);
	if(!empty($sheet_data)){
    $i=0;
    foreach($sheet_data as $rows){
    $i=$i+1;
    $order_detail=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'order_code', $rows->order_code);
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->delivery_code."</td>");
    echo("<td>".$rows->order_code." / ".$order_detail[0]['manual_cn']."</td>");
    echo("<td>".$rows->name."</td>");
    echo("<td>".$rows->phone."</td>");
    echo("<td>".$rows->address."</td>");
    echo("<td>".$rows->weight."</td>");
    echo("<td>".$rows->cod."</td>");
    echo("<td>".$rows->delivery_date."</td>");
    if($rows->is_delivery2==0){
    echo("<td>
    <button class='btn btn-xs btn-primary' data-toggle='modal' data-target='#exampleModal'  onclick='fill_deliverd_model(".$rows->delivery_detail_id.")'>Delivered</button>
    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#exampleModal2'  onclick='fill_not_delivered_model(".$rows->delivery_detail_id.")'>Not Deliverd</button>
    </td>");
    } else {echo("<td><code>No Rights</code></td>");}
    echo("</tr>"); }}  	
	}

	public function Get_Data_For_Model($id){
	$sheet_data=$this->Delivery2model->Get_Delivery_Sheet_By_Detail_id($id);	
	$data_array = array();
	$data_array['cn']			= $sheet_data[0]['order_code'];
	$data_array['sheet_code']	= $sheet_data[0]['delivery_code'];  
	$data_array['cod']			= number_format($sheet_data[0]['cod']);
	$data_array['detail_id']	= $id;  
	echo json_encode($data_array);	
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
