<?php


class Order extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
	$this->load->model('Pickmodel');
	$this->load->model('Bookingmodel');
    }

    
	public function index($item,$price,$weight,$refer){
	$data['error']="N";
	$data['item']=$item;
	$data['price']=$price;
	$data['weight']=$weight;
	$data['refer']=$refer;
	$data['delivery_cities']=$this->Pickmodel->Get_Delivery_Cities();
	$this->load->view('orderView',$data);
    }

	public function pickup_cities(){
	$data['pick_up_cities']=$this->Pickmodel->Get_Pickup_Cities();	
	$this->load->view('module_pickup/pickupcitiesView',$data);		
	}

	public function delivery_cities(){
	$data['delivery_cities']=$this->Pickmodel->Get_Delivery_Cities();	
	$this->load->view('module_pickup/deliverycitiesView',$data);			
	}

	public function qsr(){
	$data['qsr_data']="";	
	$data['start_date']="";	
	$data['end_date']="";
	$data['msg']="";	
	$this->load->view('module_report/qsrView',$data);	
	}

	public function submit_qsr(){
	$data['qsr_data']="";	
	$data['start_date']="";	
	$data['end_date']="";
	$data['msg']="";		
	$start_date  = $this->input->post('start_date');
	$end_date    = $this->input->post('end_date');
	if($start_date!="" && $end_date!=""){
	$data['msg']="";
	$data['qsr_data']=$this->Commonmodel->Get_Shipments_By_Cid($_SESSION['customer_id'],$start_date,$end_date);	
	$data['start_date']=$start_date;	
	$data['end_date']=$end_date;		
	} else {
	$data['msg']="<p class='alert alert-danger'><strong>Something is Missing.</strong></p>";
	$data['qsr_data']="";	
	$data['start_date']=$start_date;	
	$data['end_date']=$end_date;
	}	
	$this->load->view('module_report/qsrView',$data);	
	}

	public function cancelled_cn_view(){
	$data['cancelled_data']=$this->Bookingmodel->Get_All_Cancelled_Order($_SESSION['customer_id']);	
	$this->load->view('module_booking/cancelledView',$data);		
	}

	public function re_order($order_id){
	$ip 	  = $_SERVER['REMOTE_ADDR'];
	if($order_id!=""){
	$data = array(
	'order_status'		=> 'Order',
	'modify_by'			=>	$_SESSION['customer_id'],
	'modify_date'		=>	date('Y-m-d H:i:s')	
	);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);	
	$this->insert_tracking_detail($order_id,'Re-Order',$_SESSION['origin_id'],$_SESSION['origin_name'],'Your order has been Generated',date('Y-m-d H:i:s'),$ip,$_SESSION['customer_id'],date('Y-m-d H:i:s'));
	}	
	redirect('Home/cancelled_cn_view');	
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

	public function setting_view(){
	$data['msg']="";	
	$this->load->view('module_report/settingView',$data);		
	}

	public function submit_setting(){
	$old_password = $this->input->post('old_password');
	$new_password = $this->input->post('new_password');
	$retype_password = $this->input->post('retype_password');
	$db_password  = "";
	if($old_password!="" && $new_password!="" && $retype_password!=""){
    $db_data=$this->Commonmodel->Get_record_by_condition('saimtech_user', 'customer_id', $_SESSION['customer_id']);
    if(!empty($db_data)){foreach($db_data as $rows){$db_password=$rows->user_password;}}
    if($db_password==md5($old_password)){
    if($new_password==$retype_password){
    $data = array('user_password' => md5($new_password));	
    $this->Commonmodel->Update_record('saimtech_user', 'user_id', $_SESSION['user_id'], $data);
    $data['msg']="<p class='alert alert-success'>Your password is successfully changed.</p>";
    } else { $data['msg']="<p class='alert alert-danger'>Retype password not matched.</p>";}
    } else { $data['msg']="<p class='alert alert-danger'>Incorrect old password.</p>";}
	} else { $data['msg']="<p class='alert alert-danger'>Something is missing please try again.</p>";}	
	$this->load->view('module_report/settingView',$data);		
	}


	public function paid_invoice(){
	$data['paid_invoice_data']="";	
	$data['start_date']="";	
	$data['end_date']="";
	$data['msg']="";	
	$this->load->view('module_report/paidView',$data);	
	}

	public function submit_invoice(){
	$data['paid_invoice_data']="";	
	$data['start_date']="";	
	$data['end_date']="";
	$data['msg']="";		
	$start_date  = $this->input->post('start_date');
	$end_date    = $this->input->post('end_date');
	if($start_date!="" && $end_date!=""){
	$data['msg']="";
	$data['paid_invoice_data']=$this->Commonmodel->Get_Paid_Invoice_By_date_range($start_date,$end_date,$_SESSION['customer_id']);	
	$data['start_date']=$start_date;	
	$data['end_date']=$end_date;		
	} else {
	$data['msg']="<p class='alert alert-danger'><strong>Something is Missing.</strong></p>";
	$data['qsr_data']="";	
	$data['start_date']=$start_date;	
	$data['end_date']=$end_date;
	}	
	$this->load->view('module_report/paidView',$data);	
	}
}
