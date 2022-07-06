<?php
class Importfile extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Deliverymodel');
    }


    public function index(){
	if($_SESSION['user_power']==CS || $_SESSION['user_power']==SE){     	
	$this->load->view('importfileView');		
	} else {
	echo("<center><h1>Access Denied.........<BR>Name : ".$_SESSION['user_name']." <BR>IP : ".$this->get_client_ip(). "</h1></center>");    
    }
	}



	public function submit_import_file(){
	echo"<a href='https://cargo.tmcargoexpress.com/ops_tm/Importfile'>Go back</a>";
	if(($_FILES['file']['tmp_name'])!="" ){ 
	$handle = fopen($_FILES['file']['tmp_name'], "r");
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	if($data[0]!="CN" && $data[1]!="Date" ){	
	    $cn           = $data[0];
	    $date         = $data[1];
	    $receive_by   = $data[2];
	    $origin 	  = $_SESSION['origin_id'];
	    $ip 				= $this->get_client_ip();
	    
     //	echo"<pre>";print_r($data[0]);print_r($data[1]);print_r($data[2]);print_r($data[3]);  
	//==============Get Values From Booking Form=================
	
	if($cn!="" && $date!=""  && $origin!="" && $receive_by!=""){
	    //echo"<pre>";print_r($cn);exit();
		$order_detail=$this->Deliverymodel->Get_Order_By_Code($cn);
		//echo"<pre>";print_r($order_detail);exit();
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
        
        $current_time = date(' H:i:s'); 
        $deliverydatetime =date('Y-m-d H:i:s', strtotime("$delivery_date $current_time"));
        //echo"<pre>";print_r($deliverydatetime);exit();
		//------------------------------------
		if($order_date < $delivery_date){
		if($is_final!=1 ){
		$this->db->trans_start();	
		$data = array(
		 'order_status' 		=>'Deliverd',
		 'on_route_date'   		=> $date,
		 'is_on_route'			=> 1,
		 'on_route_id'			=> 'CSDD'.date('Y')."0000NA",
		 'order_deliver_date'   => $deliverydatetime,
	     'order_result_date'    => date('Y-m-d H:i:s'),
	     'order_rr_date'   		=> $date,
	     'shipment_received_by'	=> $receive_by,
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
		 'order_event_date'	 	=> $deliverydatetime,
		 'created_by' 		 	=> $_SESSION['user_id'],  
		 'created_date' 		=> date('Y-m-d H:i:s') );	
		 $detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 $data = array(
		 'is_delivery2' => 1 );
		 $this->Commonmodel->Update_record('saimtech_delivery_detail','order_code', $order_code, $data);
		 $data = array('is_unload' => 1);
		 $this->Commonmodel->Update_record('saimtech_transit_detail', 'transit_cn', $order_code, $data);
		 $this->db->trans_complete();
		 echo("<p class='alert alert-success'> Status is successfully updated delivered </p>");
		 //--------------------------------------------------------------------------
		}
		else {
		echo("<p class='alert alert-danger'>This CN is Not Eligible For IT Controller</p>");}
		}else {
		echo("<p class='alert alert-danger'>Please Enter a Valid Date");}
		//------------------------------------	
		
	     } else {
	    echo("<p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p>");}
	    //----------------------------------------- 
		    echo $order_code."<br>";
		}
		}

		fclose($handle);
	}else{
	     echo("<p class='alert alert-danger'>Please Select a CSV import File :(</p>");
	}
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