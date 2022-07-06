<?php
//WC=A
//SZ=B
//DZ=C
//ZZ=D
//ZW='Zone Wise'
//DW='Zone Wise'
//UK=Unknown
//PSB=Portal Single Booking
//ASB=Admin Portal Single Booking
//PIB=Portal Import Booking
//WAB=Web Api Booking

class Booking extends CI_Controller {

	function __construct() {
    parent::__construct();
     date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Bookingmodel');
    //$this->load->model('Pickmodel');
    }

    public function check_manual_cn(){
    $manual_cn= $this->input->post('manual_cn'); 
    if($manual_cn!=""){
    $check1=$this->Commonmodel->Duplicate_check('saimtech_order', 'manual_cn', $manual_cn);
    $check2=$this->Commonmodel->Duplicate_check('saimtech_archive_order', 'manual_cn', $manual_cn);
    if($check1==0 && $check2==0){
    $check=0;} else {$check=1; }
    echo $check;}
    }
    
    
    
    public function auto_fill_MCN(){
    $manual_cn= $this->input->post('manual_cn'); 
    if($manual_cn!=""){
    $customer_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'manual_cn', $manual_cn); 
     $mydata=array(
    'order_id'                  =>$customer_data[0]['order_id'],
    'customer_id'               =>$customer_data[0]['customer_id'],
    'order_date'                =>$customer_data[0]['order_date'], 
    'customer_reference_no'     =>$customer_data[0]['customer_reference_no'],
    'destination_city'          =>$customer_data[0]['destination_city'],
    'origin_city'               =>$customer_data[0]['origin_city'],
    'order_service_type'        =>$customer_data[0]['order_service_type'],
    'weight'                    =>$customer_data[0]['weight'],
    'pieces'                    =>$customer_data[0]['pieces'],
    'cod_amount'                =>$customer_data[0]['cod_amount'],
    'consignee_name'            =>$customer_data[0]['consignee_name'],
    'shipper_detail'            =>$customer_data[0]['shipper_detail'],
    'order_pay_mode'            =>$customer_data[0]['order_pay_mode'], 
    'order_packing_type'        =>$customer_data[0]['order_packing_type'], 
    'consignee_email'           =>$customer_data[0]['consignee_email'],
    'consignee_address'         =>$customer_data[0]['consignee_address'],
    'consignee_mobile'          =>$customer_data[0]['consignee_mobile'],
    'shipper_name'              =>$customer_data[0]['shipper_name'],
    'shipper_phone'             =>$customer_data[0]['shipper_phone'],
    'shipper_email'             =>$customer_data[0]['shipper_email'],
    'shipper_address'           =>$customer_data[0]['shipper_address'],
    'product_detail'            =>$customer_data[0]['product_detail'],
    'order_remark'              =>$customer_data[0]['order_remark']);
    echo json_encode($mydata);
    }    
    }
    
    public function edit_booking_view(){
    $data['sub_nav_active']="Edit Single";
	$data['nav_active']="Edit Booking";	
	$data['event_name']="Edit Single Booking";
	$cid=$_SESSION['customer_id'];
	$data['shipment_types']=$this->Commonmodel->Get_record_by_condition('saimtech_service', 'is_enable', 1);
	$data['customer_data']=$this->Commonmodel->Get_record_by_condition('saimtech_customer', 'is_enable', 1);
	$data['pick_up_point']=$this->Bookingmodel->Get_Active_Pickup_Points_By_Customer_id($cid);
	$data['cities_data']=$this->Bookingmodel->Get_Active_Cities();
	$this->load->view('module_booking/editsingleView',$data);	
    }

    public function get_pay_mode(){
    $customer_id = $this->input->post('customer_id');
    if($customer_id!=""){
    $customer_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_customer', 'customer_id', $customer_id);
    $pay_mode=$customer_data[0]['pay_mode'];
    $phone=$customer_data[0]['customer_contact'];
    $address=$customer_data[0]['customer_address'];
    $city=$customer_data[0]['customer_city'];
    $email=$customer_data[0]['customer_contact2'];
    $name=$customer_data[0]['customer_bank_account_title'];
    $product_type=$customer_data[0]['customer_product_type'];
    $mydata=array(
    'pay_mode'      => $pay_mode,
    'phone'         => $phone,
    'address'       => $address,
    'city'          => $city,
    'email'         => $email,
    'name'          => $name,
    'product_type'  => $product_type);
    echo json_encode($mydata);
    }
    }
    
    public function get_cong_detail(){
    $customer = $this->input->post('customer');
    $destination = $this->input->post('destination');
    $name = $this->input->post('name');
    if($customer!="" && $destination!="" && $name!=""){
    $order_data=$this->Commonmodel->Get_record_by_triple_condition('saimtech_order', 'customer_id', $customer, 'destination_city' , $destination, 'consignee_name',$name);
    if(!empty($order_data)){
    $mydata=array(
    'phone'     => $order_data[0]['consignee_mobile'],
    'address'   => $order_data[0]['consignee_address'],
    'email'     => $order_data[0]['consignee_email']);
    } else {
    $mydata=array(
    'phone'     => "",
    'address'   => "",
    'email'     => "");    
    }
    echo json_encode($mydata);
    }
    }
	public function index(){
	$data['sub_nav_active']="Single";
	$data['nav_active']="Booking";	
	$data['event_name']="Single Booking";
	$cid=$_SESSION['customer_id'];
	$data['shipment_types']=$this->Commonmodel->Get_record_by_condition('saimtech_service', 'is_enable', 1);
	$data['customer_data']=$this->Commonmodel->Get_record_by_condition('saimtech_customer', 'is_enable', 1);
	$data['pick_up_point']=$this->Bookingmodel->Get_Active_Pickup_Points_By_Customer_id($cid);
	if($_SESSION['is_tm']==0){
	$data['cities_data']=$this->Bookingmodel->Get_Active_Cities();
	} else {
	$data['cities_data']=$this->Bookingmodel->Get_All_Cities();
	}
	$this->load->view('module_booking/singleView',$data);	
	}
	
	
	

	
	public function add_tm_shipment(){
	$data = array(
	'ship_type'           => $this->input->post('shipment_type'),
	'o_date'              => $this->input->post('order_date'),
	'o_piece'             => $this->input->post('order_piece'),
	'o_weight'            => $this->input->post('order_weight'),
	'cod'              	  => $this->input->post('cod_amount'),
	'c_ref_no'   		  => $this->input->post('customer_reference_no'),
	're_ship'     		  => $this->input->post('return_shipment'),	
	'c_name'              => $this->input->post('c_name'),
	'c_phone'             => $this->input->post('c_phone'),
	'c_email'             => $this->input->post('c_email'),
	'd_city'              => $this->input->post('d_city'),
	'c_address'           => $this->input->post('c_address'),
	's_name'              => $this->input->post('s_name'),
	's_phone'             => $this->input->post('s_phone'),
	's_email'             => $this->input->post('s_email'),
	'o_city'              => $this->input->post('o_city'),
	's_address'           => $this->input->post('s_address'),
	'remark'              => $this->input->post('remark'),
	'sp_handling'         => $this->input->post('sp_handling'),
	'product_detail'	  => $this->input->post('product_detail'),
	'payment_mode'		  => $this->input->post('payment_mode'),
	'packing_type'		  => $this->input->post('packing_type'),
	'customer_id' 		  => $this->input->post('customer_id')    
	);    
	print_r($data);
	}

	public function add_shipment(){
	//==============Get Values From Booking Form=================		
	$message			 = "";
	$cash_limit 		 =100000000;					
	$ship_type           = $this->input->post('shipment_type');
	$manual_cn           = $this->input->post('manual_cn');
	$o_date              = $this->input->post('order_date');
	$o_piece             = $this->input->post('order_piece');
	$o_weight            = $this->input->post('order_weight');
	$cod              	 = $this->input->post('cod_amount');
	$c_ref_no   		 = $this->input->post('customer_reference_no');
	$o_city              = $this->input->post('o_city');
	$re_ship     		 = $this->input->post('return_shipment');	
	$c_name              = $this->input->post('c_name');
	$c_phone             = $this->input->post('c_phone');
	$c_email             = $this->input->post('c_email');
	$s_name              = $this->input->post('s_name');
	$s_phone             = $this->input->post('s_phone');
	$s_email             = $this->input->post('s_email');
	$d_city              = $this->input->post('d_city');
	$c_address           = $this->input->post('c_address');
	$s_address           = $this->input->post('s_address');
	$recheck_weight      = $this->input->post('recheck_weight');
	$remark              = $this->input->post('remark');
	$sp_handling         = $this->input->post('sp_handling');
	$product_detail		 = $this->input->post('product_detail');
	$payment_mode		 = $this->input->post('payment_mode');
	$packing_type		 = $this->input->post('packing_type');
	$customer_id 		 = $this->input->post('customer_id');
	$d_city_name 		 = "";
	$d_city_zone 		 = "";
	$o_city_name 		 = "";
	$o_city_zone 		 = "";
	$rate_type 			 = "";
	$order_rate 		 = "";
	$order_add_rate 	 = "";
	$order_gst 	 		 = "";
	$order_fuel 	 	 = "";
	$order_handling 	 = "";
	$order_cash_handling = "";
	$rate_id             = "";
	$d_city_reporting    = "";
	$o_city_reporting    = "";
	$first_char_customer =substr($c_ref_no, 0, 1);
	$first_char_phone    =substr($c_phone, 0, 1);
	if($first_char_customer!="#"){
	$c_ref_no   		 = "#".$c_ref_no;    
	}
	if($first_char_phone !=0){
	$c_phone   		     = "0".$c_phone;    
	}
	//=========================================================END
	//==============Missing Main Attribute Coditions===============
	if($ship_type !="" && $o_date!="" && $o_piece!="" && $o_weight!=""  &&
	    $re_ship!="" && $c_name!="" && $c_phone!="" && $c_email!=""
	   && $d_city!="" && $c_address!="" && $remark!="" && $sp_handling!="" && $customer_id!="" && $product_detail!="" && $recheck_weight!=""){
	$this->db->trans_start();
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
	
	/* $rate_detail=$this->Commonmodel->Get_record_by_triple_condition('saimtech_rate', 'customer_id', $customer_id, 'service_id', $ship_type, 'is_enable', 1);
	//=WC============With in CITY
	$sc_wgt1=$rate_detail[0]['sc_wgt1'];
	$sc_rate1=$rate_detail[0]['sc_rate1']; 
	$sc_wgt2=$rate_detail[0]['sc_wgt2']; 
	$sc_rate2=$rate_detail[0]['sc_rate2']; 
	$sc_add_wgt=$rate_detail[0]['sc_add_wgt'];
	$sc_add_rate=$rate_detail[0]['sc_add_rate'];
	$sc_gst_rate=$rate_detail[0]['sc_gst_rate'];
	$sc_fuel_formula=$rate_detail[0]['sc_fuel_formula'];
	$sc_fuel_rate=$rate_detail[0]['sc_fuel_rate']; 
	$sc_sp_handling_formula=$rate_detail[0]['sc_sp_handling_formula']; 
	$sc_sp_handling_rate=$rate_detail[0]['sc_sp_handling_rate'];
	//=END============With in CITY
	//=SZ============Same Zone
	$sz_wgt1=$rate_detail[0]['sz_wgt1'];
	$sz_rate1=$rate_detail[0]['sz_rate1']; 
	$sz_wgt2=$rate_detail[0]['sz_wgt2']; 
	$sz_rate2=$rate_detail[0]['sz_rate2'];
	$sz_add_wgt=$rate_detail[0]['sz_add_wgt']; 
	$sz_add_rate=$rate_detail[0]['sz_add_rate']; 
	$sz_gst_rate=$rate_detail[0]['sz_gst_rate']; 
	$sz_fuel_formula=$rate_detail[0]['sz_fuel_formula']; 
	$sz_fuel_rate=$rate_detail[0]['sz_fuel_rate']; 
	$sz_sp_handling_formula=$rate_detail[0]['sz_sp_handling_formula']; 
	$sz_sp_handling_rate=$rate_detail[0]['sz_sp_handling_rate']; 
	//=END============Same Zone
	//=DZ============Different Zone
	$dz_wgt1=$rate_detail[0]['dz_wgt1']; 
	$dz_rate1=$rate_detail[0]['dz_rate1']; 
	$dz_wgt2=$rate_detail[0]['dz_wgt2']; 
	$dz_rate2=$rate_detail[0]['dz_rate2'];
	$dz_add_wgt=$rate_detail[0]['dz_add_wgt']; 
	$dz_add_rate=$rate_detail[0]['dz_add_rate'];
	$dz_fuel_formula=$rate_detail[0]['dz_fuel_formula'];
	$dz_fuel_rate=$rate_detail[0]['dz_fuel_rate'];
	$dz_sp_handling_formula=$rate_detail[0]['dz_sp_handling_formula'];
	$dz_sp_handling_rate=$rate_detail[0]['dz_sp_handling_rate'];
	$dz_gst_rate=$rate_detail[0]['dz_gst_rate']; 
	//=END============Different Zone
	$cash_handling_formula=$rate_detail[0]['cash_handling_formula']; 
	$cash_handling_rate=$rate_detail[0]['cash_handling_rate'];
	$flyer_rate=$rate_detail[0]['flyer_rate']; 
    $rate_id=$rate_detail[0]['rate_id']; 
	//================Calculate Rate
	if($rate_type=="WC"){
	$calcu=$this->calculate_rate($o_weight,$sc_wgt1, $sc_rate1, $sc_wgt2, $sc_rate2, $sc_add_wgt, $sc_add_rate, $sc_gst_rate, $sc_fuel_formula, $sc_fuel_rate, $sc_sp_handling_formula, $sc_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sc_rate1;
	$order_add_rate 				=$sc_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
	} else if($rate_type=="SZ"){
	$calcu=$this->calculate_rate($o_weight,$sz_wgt1, $sz_rate1, $sz_wgt2, $sz_rate2, $sz_add_wgt, $sz_add_rate, $sz_gst_rate, $sz_fuel_formula, $sz_fuel_rate, $sz_sp_handling_formula, $sz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sz_rate1;
	$order_add_rate 				=$sz_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));

	} else if($rate_type=="DZ"){
	$calcu=$this->calculate_rate($o_weight,$dz_wgt1, $dz_rate1, $dz_wgt2, $dz_rate2, $dz_add_wgt, $dz_add_rate, $dz_gst_rate, $dz_fuel_formula, $dz_fuel_rate, $dz_sp_handling_formula, $dz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					= $dz_rate1;
	$order_add_rate 				= $dz_add_rate;
	$order_gst 						= $calcu->my_gst;
	$order_sc 						= $calcu->my_amount;
	$order_sp_handling_rate 		= $calcu->my_handling;
	$order_cash_handling_rate 		= $calcu->my_cash_handling;
	$order_fuel 					= $calcu->my_fuel;
	$order_flyer_rate 				= $flyer_rate;
	$order_total_amount_with_flyer 	= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));

	} */
	//=END============Calculate Rate
	$calcu=$this->new_zone_rating_module($o_city,$d_city,$customer_id,$ship_type,$o_weight);
	$order_rate 					= 0;
	$order_add_rate 				= 0;
	$order_gst 						= $calcu->my_gst;
	$order_sc 						= $calcu->my_amount;
	$order_sp_handling_rate 		= 0;
	$order_cash_handling_rate 		= 0;
	$order_fuel 					= 0;
	$order_flyer_rate 				= 0;
	$order_total_amount_with_flyer 	= 0;
	$order_total_amount 			= (($order_gst) + ($order_sc));
	$rate_type                      ='ZW';
	$rate_id                        = $calcu->my_rate_id;
	echo $dcheck=$this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $ship_type, 'customer_id', $customer_id, 'origin_city_id', $o_city, 'dest_city_id', $d_city, 'is_enable', '1');
	if($dcheck!=0){
	$calcu2=$this->new_destination_rating_module($o_city,$d_city,$customer_id,$ship_type,$o_weight);
	$order_rate 					= 0;
	$order_add_rate 				= 0;
	$order_gst 						= $calcu2->my_gst;
	$order_sc 						= $calcu2->my_amount;
	$order_sp_handling_rate 		= 0;
	$order_cash_handling_rate 		= 0;
	$order_fuel 					= 0;
	$order_flyer_rate 				= 0;
	$order_total_amount_with_flyer 	= 0;
	$order_total_amount 			= (($order_gst) + ($order_sc));
	$rate_type                      ='DW';
	$rate_id                        = $calcu2->my_rate_id;    
	}
	if($cod==""){
	$cod=0;    
	} 
	$order_code=$this->get_order_code($o_city_code);
	$ip= $_SERVER['REMOTE_ADDR'];
	$this->set_barcode($order_code);
	//=========================================================END	
	
	$data = array(
	'recheck_weight'			    => 	$recheck_weight,    
	'customer_id'					=> 	$customer_id,
	'cod_amount'					=> 	$cod,
	'manual_cn'					    => 	$manual_cn,
	'order_date'					=> 	$o_date,
	'order_code'					=> 	$order_code,
	'customer_reference_no'			=> 	$c_ref_no,
	'order_booking_date'			=> 	date('Y-m-d H:i:s'),
	'order_arrival_date'			=> 	'0000-00-00 00:00:00',
	'order_deliver_date'			=> 	'0000-00-00 00:00:00',
	'order_rr_date'					=> 	'0000-00-00 00:00:00',
	'order_cr_date'					=> 	'0000-00-00 00:00:00',
	'order_status'					=> 	'Booking',
	'destination_city'				=> 	$d_city,
	'destination_zone'				=> 	$d_city_zone,
	'destination_city_name'			=> 	$d_city_name,
	'origin_city'					=> 	$o_city,
	'origin_zone'					=> 	$o_city_zone,
	'origin_city_name'				=> 	$o_city_name,
	'order_rate_type'				=> 	$rate_type,
	'order_service_type'			=> 	$ship_type,
	'order_receive_from'			=> 	'ASB',
	'weight'						=>	$o_weight,
	'pieces'						=>	$o_piece,
	'consignee_name'				=>	$c_name,
	'consignee_email'				=>	$c_email,
	'consignee_address'				=>	$c_address,
	'consignee_mobile'				=>	$c_phone,
	'shipper_name'				    =>	$s_name,
	'shipper_email'				    =>	$s_email,
	'shipper_address'				=>	$s_address,
	'shipper_phone'				    =>	$s_phone,
	'product_detail'				=>	$product_detail,
	'order_remark'					=>	$remark,
	'order_rate'					=>	$order_rate,
	'order_add_rate'				=>	$order_add_rate,
	'order_gst'						=>	$order_gst,
	'order_sc'						=>	$order_sc,
	'order_sp_handling_rate'		=>	$order_sp_handling_rate,
	'order_cash_handling_rate'		=>  $order_cash_handling_rate,
	'order_fuel'					=>	$order_fuel,
	'order_flyer_rate'				=>	$order_flyer_rate,
	'order_pay_mode'                =>  $payment_mode,
	'order_packing_type'            =>  $packing_type,
	'order_total_amount_with_flyer' =>  $order_total_amount_with_flyer,
	'order_total_amount'            =>  $order_total_amount, 
	'delivery_rider_id'				=>	'0',
	'order_cr'						=>	'N',
	'order_receive_amount'			=> 	'0',
	'origin_reporting'              =>  $o_city_reporting,
	'destination_reporting'         =>  $d_city_reporting, 
	'rate_id'						=>	$rate_id,
	'created_by'					=>	$_SESSION['user_id'],
	'created_date'					=>	date('Y-m-d H:i:s')
	);
	$insert_id=$this->Commonmodel->Insert_record('saimtech_order', $data);
	$status_msg="Your Shipment Has Been Booked.";
	$this->insert_tracking_detail($insert_id,'Order',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,$customer_id,date('Y-m-d H:i:s'));
	$this->insert_tracking_detail($insert_id,'Booking',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,$customer_id,date('Y-m-d H:i:s'));
	 $this->db->trans_complete();
	if($insert_id>0){	
	$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>".$order_code."</strong> Your Shippment is successfully Booked. <a href='".base_url()."Booking/Booking/print_address_label2'>Print</a> </div></div>";
	} else {
		
	}
	} 
	else {$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>Missing Error !</strong> Something is missing please try again.</div></div>";	}
	//=========================================================END
	echo $message;	
	}
	
		public function edit_shipment(){
	//==============Get Values From Booking Form=================		
	$message			 = "";
	$cash_limit 		 =100000000;					
	$order_id           = $this->input->post('order_id');
	$ship_type           = $this->input->post('shipment_type');
	$manual_cn           = $this->input->post('manual_cn');
	$o_date              = $this->input->post('order_date');
	$o_piece             = $this->input->post('order_piece');
	$o_weight            = $this->input->post('order_weight');
	$cod              	 = $this->input->post('cod_amount');
	$c_ref_no   		 = $this->input->post('customer_reference_no');
	$o_city              = $this->input->post('o_city');
	$re_ship     		 = $this->input->post('return_shipment');	
	$c_name              = $this->input->post('c_name');
	$c_phone             = $this->input->post('c_phone');
	$c_email             = $this->input->post('s_email');
	$s_name              = $this->input->post('s_name');
	$s_phone             = $this->input->post('s_phone');
	$s_email             = $this->input->post('s_email');
	$d_city              = $this->input->post('d_city');
	$c_address           = $this->input->post('c_address');
	$s_address           = $this->input->post('s_address');
	$remark              = $this->input->post('remark');
	$sp_handling         = $this->input->post('sp_handling');
	$product_detail		 = $this->input->post('product_detail');
	$payment_mode		 = $this->input->post('payment_mode');
	$packing_type		 = $this->input->post('packing_type');
	$customer_id 		 = $this->input->post('customer_id');
	$d_city_name 		 = "";
	$d_city_zone 		 = "";
	$o_city_name 		 = "";
	$o_city_zone 		 = "";
	$rate_type 			 = "";
	$order_rate 		 = "";
	$order_add_rate 	 = "";
	$order_gst 	 		 = "";
	$order_fuel 	 	 = "";
	$order_handling 	 = "";
	$order_cash_handling = "";
	$rate_id             = "";
	$d_city_reporting    = "";
	$o_city_reporting    = "";
	$first_char_customer =substr($c_ref_no, 0, 1);
	$first_char_phone    =substr($c_phone, 0, 1);
	if($first_char_customer!="#"){
	$c_ref_no   		 = "#".$c_ref_no;    
	}
	if($first_char_phone !=0){
	$c_phone   		     = "0".$c_phone;    
	}
	//=========================================================END
	//==============Missing Main Attribute Coditions===============
	if($ship_type !="" && $order_id !="" && $o_date!="" && $o_piece!="" && $o_weight!=""  &&
	    $re_ship!="" && $c_name!="" && $c_phone!="" && $c_email!=""
	   && $d_city!="" && $c_address!="" && $remark!="" && $sp_handling!="" && $customer_id!="" && $product_detail!=""){
	$this->db->trans_start();
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
	
	/* $rate_detail=$this->Commonmodel->Get_record_by_triple_condition('saimtech_rate', 'customer_id', $customer_id, 'service_id', $ship_type, 'is_enable', 1);
	//=WC============With in CITY
	$sc_wgt1=$rate_detail[0]['sc_wgt1'];
	$sc_rate1=$rate_detail[0]['sc_rate1']; 
	$sc_wgt2=$rate_detail[0]['sc_wgt2']; 
	$sc_rate2=$rate_detail[0]['sc_rate2']; 
	$sc_add_wgt=$rate_detail[0]['sc_add_wgt'];
	$sc_add_rate=$rate_detail[0]['sc_add_rate'];
	$sc_gst_rate=$rate_detail[0]['sc_gst_rate'];
	$sc_fuel_formula=$rate_detail[0]['sc_fuel_formula'];
	$sc_fuel_rate=$rate_detail[0]['sc_fuel_rate']; 
	$sc_sp_handling_formula=$rate_detail[0]['sc_sp_handling_formula']; 
	$sc_sp_handling_rate=$rate_detail[0]['sc_sp_handling_rate'];
	//=END============With in CITY
	//=SZ============Same Zone
	$sz_wgt1=$rate_detail[0]['sz_wgt1'];
	$sz_rate1=$rate_detail[0]['sz_rate1']; 
	$sz_wgt2=$rate_detail[0]['sz_wgt2']; 
	$sz_rate2=$rate_detail[0]['sz_rate2'];
	$sz_add_wgt=$rate_detail[0]['sz_add_wgt']; 
	$sz_add_rate=$rate_detail[0]['sz_add_rate']; 
	$sz_gst_rate=$rate_detail[0]['sz_gst_rate']; 
	$sz_fuel_formula=$rate_detail[0]['sz_fuel_formula']; 
	$sz_fuel_rate=$rate_detail[0]['sz_fuel_rate']; 
	$sz_sp_handling_formula=$rate_detail[0]['sz_sp_handling_formula']; 
	$sz_sp_handling_rate=$rate_detail[0]['sz_sp_handling_rate']; 
	//=END============Same Zone
	//=DZ============Different Zone
	$dz_wgt1=$rate_detail[0]['dz_wgt1']; 
	$dz_rate1=$rate_detail[0]['dz_rate1']; 
	$dz_wgt2=$rate_detail[0]['dz_wgt2']; 
	$dz_rate2=$rate_detail[0]['dz_rate2'];
	$dz_add_wgt=$rate_detail[0]['dz_add_wgt']; 
	$dz_add_rate=$rate_detail[0]['dz_add_rate'];
	$dz_fuel_formula=$rate_detail[0]['dz_fuel_formula'];
	$dz_fuel_rate=$rate_detail[0]['dz_fuel_rate'];
	$dz_sp_handling_formula=$rate_detail[0]['dz_sp_handling_formula'];
	$dz_sp_handling_rate=$rate_detail[0]['dz_sp_handling_rate'];
	$dz_gst_rate=$rate_detail[0]['dz_gst_rate']; 
	//=END============Different Zone
	$cash_handling_formula=$rate_detail[0]['cash_handling_formula']; 
	$cash_handling_rate=$rate_detail[0]['cash_handling_rate'];
	$flyer_rate=$rate_detail[0]['flyer_rate']; 
    $rate_id=$rate_detail[0]['rate_id']; 
	//================Calculate Rate
	if($rate_type=="WC"){
	$calcu=$this->calculate_rate($o_weight,$sc_wgt1, $sc_rate1, $sc_wgt2, $sc_rate2, $sc_add_wgt, $sc_add_rate, $sc_gst_rate, $sc_fuel_formula, $sc_fuel_rate, $sc_sp_handling_formula, $sc_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sc_rate1;
	$order_add_rate 				=$sc_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
	} else if($rate_type=="SZ"){
	$calcu=$this->calculate_rate($o_weight,$sz_wgt1, $sz_rate1, $sz_wgt2, $sz_rate2, $sz_add_wgt, $sz_add_rate, $sz_gst_rate, $sz_fuel_formula, $sz_fuel_rate, $sz_sp_handling_formula, $sz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sz_rate1;
	$order_add_rate 				=$sz_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));

	} else if($rate_type=="DZ"){
	$calcu=$this->calculate_rate($o_weight,$dz_wgt1, $dz_rate1, $dz_wgt2, $dz_rate2, $dz_add_wgt, $dz_add_rate, $dz_gst_rate, $dz_fuel_formula, $dz_fuel_rate, $dz_sp_handling_formula, $dz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					= $dz_rate1;
	$order_add_rate 				= $dz_add_rate;
	$order_gst 						= $calcu->my_gst;
	$order_sc 						= $calcu->my_amount;
	$order_sp_handling_rate 		= $calcu->my_handling;
	$order_cash_handling_rate 		= $calcu->my_cash_handling;
	$order_fuel 					= $calcu->my_fuel;
	$order_flyer_rate 				= $flyer_rate;
	$order_total_amount_with_flyer 	= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));

	} */
	//=END============Calculate Rate
	
	$order_rate 					= 0;
	$order_add_rate 				= 0;
	$order_gst 						= 0;
	$order_sc 						= 0;
	$order_sp_handling_rate 		= 0;
	$order_cash_handling_rate 		= 0;
	$order_fuel 					= 0;
	$order_flyer_rate 				= 0;
	$order_total_amount_with_flyer 	= 0;
	$order_total_amount 			= 0;
	if($cod==""){
	$cod=0;    
	} 
	
	$ip= $_SERVER['REMOTE_ADDR'];
	//=========================================================END	
	
	$data = array(
	'customer_id'					=> 	$customer_id,
	'cod_amount'					=> 	$cod,
	'customer_reference_no'			=> 	$c_ref_no,
	'destination_city'				=> 	$d_city,
	'destination_zone'				=> 	$d_city_zone,
	'destination_city_name'			=> 	$d_city_name,
	'origin_city'					=> 	$o_city,
	'origin_zone'					=> 	$o_city_zone,
	'origin_city_name'				=> 	$o_city_name,
	'order_rate_type'				=> 	$rate_type,
	'order_service_type'			=> 	$ship_type,
	'order_receive_from'			=> 	'EAB',
	'weight'						=>	$o_weight,
	'pieces'						=>	$o_piece,
	'consignee_name'				=>	$c_name,
	'consignee_email'				=>	$c_email,
	'consignee_address'				=>	$c_address,
	'consignee_mobile'				=>	$c_phone,
	'shipper_name'				    =>	$s_name,
	'shipper_email'				    =>	$s_email,
	'shipper_address'				=>	$s_address,
	'shipper_phone'				    =>	$s_phone,
	'product_detail'				=>	$product_detail,
	'order_remark'					=>	$remark,
	'order_rate'					=>	$order_rate,
	'order_add_rate'				=>	$order_add_rate,
	'order_gst'						=>	$order_gst,
	'order_sc'						=>	$order_sc,
	'order_sp_handling_rate'		=>	$order_sp_handling_rate,
	'order_cash_handling_rate'		=>  $order_cash_handling_rate,
	'order_fuel'					=>	$order_fuel,
	'order_flyer_rate'				=>	$order_flyer_rate,
	'order_pay_mode'                =>  $payment_mode,
	'order_packing_type'            =>  $packing_type,
	'order_total_amount_with_flyer' =>  $order_total_amount_with_flyer,
	'order_total_amount'            =>  $order_total_amount, 
	'delivery_rider_id'				=>	'0',
	'order_cr'						=>	'N',
	'order_receive_amount'			=> 	'0',
	'origin_reporting'              =>  $o_city_reporting,
	'destination_reporting'         =>  $d_city_reporting, 
	'rate_id'						=>	0,
	'modify_by'					=>	$_SESSION['user_id'],
	'modify_date'					=>	date('Y-m-d H:i:s')
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);
	$this->db->trans_complete();
	$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button> Your Shippment is successfully Updated</div></div>";
	} 
	else {$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>Missing Error !</strong> Something is missing please try again.</div></div>";	}
	//=========================================================END
	echo $message;	
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

	public function import_booking_view(){
	$this->Commonmodel->Delete_record('saimtech_import_error', 'customer_id',$_SESSION['customer_id']);  
	if($_SESSION['is_tm']==0){
	$data['delivery_cities']=$this->Pickmodel->Get_Delivery_Cities();
	} else if($_SESSION['is_tm']==1){
	$data['delivery_cities']=$this->Pickmodel->Get_ALL_Delivery_Cities(); }
	$data['pick_up_point']=$this->Pickmodel->Get_Pickup_Points_By_Customer_id($_SESSION['customer_id']);
	$data['shipment_type']=$this->Commonmodel->Get_Service_Type_By_customer_id($_SESSION['customer_id']);	
	$this->load->view('module_booking/importView',$data);	
	}



	public function set_barcode($code){
    $targetDir = FCPATH."../assets/barcode/cn/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }	

	public function address_label(){
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);	
	$data['orders_data']=$this->Bookingmodel->Get_Orders_By_CID($_SESSION['customer_id']);		
	$this->load->view('module_booking/printpanelView',$data);		
	}
	
	public function single_print_address_label($orderid){
	$data['print_data']=$this->Bookingmodel->Get_Single_label_address($orderid);
	$this->load->view('module_booking/printView',$data);	
	}
	
	public function single2_print_address_label($orderid){
	$data['print_data']=$this->Bookingmodel->Get_Single_label_address($orderid);
	$this->load->view('module_booking/print2View',$data);	
	}

	public function print_address_label(){
	$cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_Selected_label_address($cid);
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);
	$this->load->view('module_booking/printView',$data);	
	}
	
	public function print_address_label1($orderid){

	$data['print_data']=$this->Bookingmodel->Get_Selected_label_address1($orderid);
	$this->load->view('module_booking/printView',$data);	
	}
	
	public function print_address_label2($orderid){

	$data['print_data']=$this->Bookingmodel->Get_Selected_label_address1($orderid);
	$this->load->view('module_booking/printbpView',$data);	
	}
	
	public function print_address_label_one_by_one(){
	$cid=$_SESSION['customer_id'];	
	$data['print_data']=$this->Bookingmodel->Get_Selected_label_address($cid);
	$this->Commonmodel->Delete_record('saimtech_print_label_temp', 'customer_id', $_SESSION['customer_id']);
	$this->load->view('module_booking/printoneView',$data);	    
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


	public function redraw_order_table(){
	$orders_data=$this->Bookingmodel->Get_Orders_By_CID($_SESSION['customer_id']);			
	if(!empty($orders_data)){
	foreach($orders_data as $rows){ 
	echo("<tr>");
	echo("<td><div class='checkbox check-danger checkbox-circle'>
	<input type='checkbox' onclick='select_function(".$rows->order_code.")' value='".$rows->order_code."' id='checkbox".$rows->order_code.">
	<label for='checkbox".$rows->order_code."'>".$rows->order_code."</label>
	</div></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->cod_amount."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->customer_reference_no."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->destination_city_name."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->order_date."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->order_status."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->origin_city_name."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->pieces."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'><center>".$rows->weight."</center></td>");
	echo("<td style='font-size:13px;padding-top:18px'>");
	echo("<a href='".base_url()."Tracking/index/".$rows->order_code." target='_blank'><button class='btn btn-danger 	btn-xs'>View</button></a>"); 
	echo("<button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#exampleModal' onclick='cancel_shipment(".$rows->order_code.",".$rows->cod_amount.",".$rows->order_id.")'>Cancel</button>");
	echo("</td>");  
	echo("</tr>");
    }}	
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
	if($_SESSION['user_power']!="SUBAGENT"){
	$cid=$_SESSION['customer_id'];
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_record('saimtech_order', 'customer_id', $cid, $data);
	$data['load_sheet_data']=$this->Bookingmodel->Get_Load_Sheet_By_Customer($cid);		
	$data['col1_data']=$this->Bookingmodel->Get_Eligible_Load_Sheet($cid);
	} else if($_SESSION['user_power']=="SUBAGENT"){
	$cid=$_SESSION['customer_id'];
	$uid=$_SESSION['user_id'];
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'customer_id', $cid, 'created_by', $uid, $data);
	$data['load_sheet_data']=$this->Bookingmodel->Get_Load_Sheet_By_Customer_UID($uid);		
	$data['col1_data']=$this->Bookingmodel->Get_Eligible_Load_Sheet_UID($uid);    
	}
	$this->load->view('module_booking/loadsheetpanelView',$data);		
	}

	public function insert_temp_ls(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	if($cn!="" && $customer_id !=""){
	$data=array('temp_ls' 	 => 1);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $customer_id, 'temp_ls', 1);
	}

	public function delete_temp_ls_by_cn(){
	$cn	 				 = $this->input->post('cn');
	$customer_id 		 = $_SESSION['customer_id'];
	$user_id 		     = $_SESSION['user_id'];
    if($_SESSION['user_power']!="SUBAGENT"){    
	if($cn!="" ){
	$data=array('temp_ls' => 0);	
	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}	
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $customer_id, 'temp_ls', 1);
    } else if($_SESSION['user_power']=="SUBAGENT"){
    if($cn!="" ){
	$data=array('temp_ls' => 0);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'order_code', $cn, 'created_by',$user_id, $data);}	    
    }
	}

	public function all_delete_temp_ls_by_cn(){
	$cid=$_SESSION['customer_id'];
	$uid= $_SESSION['user_id'];
	if($_SESSION['user_power']!="SUBAGENT"){    
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'customer_id', $cid, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1);
	} else if($_SESSION['user_power']=="SUBAGENT"){
	$data=array('temp_ls' 	 => 0);	
	$this->Commonmodel->Update_triple_record('saimtech_order', 'customer_id', $cid, 'created_by',$user_id, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_triple_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1, 'created_by', $user_id);
	}
	}

	public function all_insert_temp_ls(){
	$cid=$_SESSION['customer_id'];
	$uid= $_SESSION['user_id'];
	if($_SESSION['user_power']!="SUBAGENT"){ 
	$data=array('temp_ls' 	 => 1);	
	$this->Commonmodel->Update_double_record('saimtech_order', 'customer_id', $cid, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1);
	} else if($_SESSION['user_power']=="SUBAGENT"){
	$data=array('temp_ls' 	 => 1);	
	$this->Commonmodel->Update_triple_record('saimtech_order', 'customer_id', $cid, 'created_by',$user_id, 'order_status', 'Order', $data);
	echo $count=$this->Commonmodel->Duplicate_triple_check('saimtech_order', 'customer_id', $cid, 'temp_ls', 1, 'created_by', $user_id);
	}    
	}

	public function ls_cancel_shipment(){
	$cid=$_SESSION['customer_id'];	
	$order_id = $this->input->post('id');
	$ip 	  = $_SERVER['REMOTE_ADDR'];
	if($order_id!=""){
	if($_SESSION['user_power']!="SUBAGENT"){  
	$data = array(
	'order_status'		=> 'Cancelled',
	'modify_by'			=>	$_SESSION['customer_id'],
	'modify_date'		=>	date('Y-m-d H:i:s')	
	); } else if($_SESSION['user_power']=="SUBAGENT"){
	$data = array(
	'order_status'		=> 'Cancelled',
	'modify_by'			=>	$_SESSION['user_id'],
	'modify_date'		=>	date('Y-m-d H:i:s')	
	);}	
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
	 if($_SESSION['user_power']!="SUBAGENT"){  
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet($cid);
	} else  if($_SESSION['user_power']=="SUBAGENT"){  
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet_UID($_SESSION['user_id']); }
	if(!empty($selected_data)){
	$sheet_code = $this->get_load_sheet_code();	
	$this->set_loadsheet_barcode($sheet_code);
	 if($_SESSION['user_power']!="SUBAGENT"){  
	$data = array(
	'load_sheet_code'		=> 	$sheet_code,
	'load_sheet_cn'			=> 	'NULL',
	'load_sheet_shipments'	=> 	'0',	
	'load_sheet_date'		=> 	date('Y-m-d H:i:s'),
	'customer_id'			=> 	$cid,
	'created_by'			=> 	$cid,
	'created_date'			=> 	date('Y-m-d H:i:s')
	 );} 
	 else if($_SESSION['user_power']=="SUBAGENT"){
	 $data = array(
	'load_sheet_code'		=> 	$sheet_code,
	'load_sheet_cn'			=> 	'NULL',
	'load_sheet_shipments'	=> 	'0',	
	'load_sheet_date'		=> 	date('Y-m-d H:i:s'),
	'customer_id'			=> 	$cid,
	'created_by'			=> 	$_SESSION['user_id'],
	'created_date'			=> 	date('Y-m-d H:i:s')
	 );}
	$load_sheet_id=$this->Commonmodel->Insert_record('saimtech_load_sheet', $data);
	 if($_SESSION['user_power']!="SUBAGENT"){  
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet($cid);
	} else  if($_SESSION['user_power']=="SUBAGENT"){  
	$selected_data=$this->Bookingmodel->Get_Select_Cn_Sheet_UID($_SESSION['user_id']); }
	
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

    public function clean($string){
	$string = trim($string);
	$num = array(0,1,2,3,4,5,6,7,8,9);
    $string = str_replace($num, null, $string);    
    $string = str_replace('-', '', $string);
    $string = str_replace('.', '', $string);
    // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

	public function submit_import_file(){
	$handle = fopen($_FILES['file']['tmp_name'], "r");
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	if($data[0]!="Shipment Type" && $data[1]!="Pieces" && $data[2]!="Weight" && $data[3]!="COD Amount" && $data[10]!=""){	
	//==============Get Values From Booking Form=================		
	$message			 = "";
	$cash_limit 		 = 1000;					
	$ship_type           = $data[0];
	$o_date              = date('Y-m-d H:i:s');
	$o_piece        	 = $data[1];
	$o_weight            = $data[2];
	$cod              	 = $data[3];
	$c_ref_no   		 = $data[4];
	$pick_point          = $data[6];
	$re_ship     		 = "N";	
	$c_name              = $data[7];
	$c_phone             = $data[8];
	$c_email             = $data[9];
	$d_city              = ucfirst(ltrim($data[10]));
	$c_address           = $data[11];
	$remark              = $data[12];
	$sp_handling         = $data[13];
	$packing_type        = $data[14];
	$payment_mode        = $data[15];
	$product_detail		 = $data[5];
	$customer_id 		 = $_SESSION['customer_id'];
	$d_city_name 		 = "";
	$d_city_zone 		 = "";
	$o_city 		 	 = "";
	$o_city_name 		 = "";
	$o_city_zone 		 = "";
	$rate_type 			 = "";
	$order_rate 		 = "";
	$order_add_rate 	 = "";
	$order_gst 	 		 = "";
	$order_fuel 	 	 = "";
	$order_handling 	 = "";
	$order_cash_handling = "";
	$d_city_id           = "";
	$o_city_reporting    = "";     
	$d_city_reporting    = "";
	$rate_id             = "";
	$first_char_customer =substr($data[4], 0, 1);
	$first_char_phone    =substr($data[8], 0, 1);
	if($first_char_customer!="#"){
	$c_ref_no   		 = "#".$data[4];    
	}
	if($first_char_phone !=0){
	$c_phone   		     = "0".$data[8];    
	}
	$data = array(	
	'shipment_type'     => $data[0],
	'pieces'            => $data[1], 
	'weight'            => $data[2], 
	'cod'               => $data[3],
	'reference_no'      => $data[4],
	'product'           => $data[5],
	'pickup_id'         => $data[6],
	'name'              => $data[7], 
	'phone'             => $data[8],
	'email'             => $data[9], 
	'destination'       => $data[10], 
	'address'           => $data[11],
	'remark'            => $data[12], 
	'handling'          => $data[13],
	'packing_type'      => $data[14],
	'payment_mode'      => $data[15],
	'customer_id'       => $customer_id 
	);
	$import_error_id=$this->Commonmodel->Insert_record('saimtech_import_error',$data);
	//=========================================================END
		//==============Missing Main Attribute Coditions===============
	if($ship_type !="" && $o_date!="" && $o_piece!="" && $o_weight!=""  &&
	   $cod!="" && $pick_point!="" && $re_ship!="" && $c_name!="" && $c_phone!="" && $c_email!=""
	   && $d_city!="" && $c_address!="" && $remark!="" && $sp_handling!="" && $customer_id!="" && $product_detail!=""){
	$this->db->trans_start();
	//==============Get Destination City ID & Name================
	$d_city=ucwords($this->clean($d_city));
	$dest=$this->Commonmodel->Get_record_by_double_condition('saimtech_city','city_name',trim($d_city),'is_enable',1);
	if($_SESSION['is_tm']==1){
	$dest=$this->Commonmodel->Get_record_by_double_condition('saimtech_city','city_name',trim($d_city),'is_delete',0); }
	if(!empty($dest)){foreach($dest as $rows){
	$d_city_name=$rows->city_name;
	$d_city_zone=$rows->city_zone;
	$d_city_code=$rows->city_code;
	$d_city_id=$rows->city_id;
	$d_city_reporting    = $rows->reporting_city;
	}}
	//=========================================================END
	$origin=$this->Commonmodel->Get_Pickup_Points_By_pickup_id($pick_point);
	$o_city=$origin[0]['city_id'];	
	$o_city_name=$origin[0]['city_name'];
	$o_city_code=$origin[0]['city_code'];
	$o_city_zone=$origin[0]['city_zone'];
	$o_city_reporting  = $origin[0]['reporting_city'];
	//==============Get Origin City ID & Name=====================	
	//=========================================================END

	//==============Get Rate Type and Rate Detail=================	
	if($d_city_id==3 || $d_city_id==4){$d_city_id=4;}
	if($o_city==3 || $o_city==4){$o_city=4;}
	if($o_city==$d_city_id){ $rate_type="WC";}
	else if($o_city_zone==$d_city_zone && $o_city!=$d_city_id){ $rate_type="SZ";}
	else if($o_city_zone!=$d_city_zone){$rate_type="DZ"; }
	else {$rate_type="UK";}
	
	/*$rate_detail=$this->Commonmodel->Get_record_by_triple_condition('saimtech_rate', 'customer_id', $customer_id, 'service_id', $ship_type, 'is_enable', 1);
	//=WC============With in CITY
	$sc_wgt1=$rate_detail[0]['sc_wgt1'];
	$sc_rate1=$rate_detail[0]['sc_rate1']; 
	$sc_wgt2=$rate_detail[0]['sc_wgt2']; 
	$sc_rate2=$rate_detail[0]['sc_rate2']; 
	$sc_add_wgt=$rate_detail[0]['sc_add_wgt'];
	$sc_add_rate=$rate_detail[0]['sc_add_rate'];
	$sc_gst_rate=$rate_detail[0]['sc_gst_rate'];
	$sc_fuel_formula=$rate_detail[0]['sc_fuel_formula'];
	$sc_fuel_rate=$rate_detail[0]['sc_fuel_rate']; 
	$sc_sp_handling_formula=$rate_detail[0]['sc_sp_handling_formula']; 
	$sc_sp_handling_rate=$rate_detail[0]['sc_sp_handling_rate'];
	//=END============With in CITY
	//=SZ============Same Zone
	$sz_wgt1=$rate_detail[0]['sz_wgt1'];
	$sz_rate1=$rate_detail[0]['sz_rate1']; 
	$sz_wgt2=$rate_detail[0]['sz_wgt2']; 
	$sz_rate2=$rate_detail[0]['sz_rate2'];
	$sz_add_wgt=$rate_detail[0]['sz_add_wgt']; 
	$sz_add_rate=$rate_detail[0]['sz_add_rate']; 
	$sz_gst_rate=$rate_detail[0]['sz_gst_rate']; 
	$sz_fuel_formula=$rate_detail[0]['sz_fuel_formula']; 
	$sz_fuel_rate=$rate_detail[0]['sz_fuel_rate']; 
	$sz_sp_handling_formula=$rate_detail[0]['sz_sp_handling_formula']; 
	$sz_sp_handling_rate=$rate_detail[0]['sz_sp_handling_rate']; 
	//=END============Same Zone
	//=DZ============Different Zone
	$dz_wgt1=$rate_detail[0]['dz_wgt1']; 
	$dz_rate1=$rate_detail[0]['dz_rate1']; 
	$dz_wgt2=$rate_detail[0]['dz_wgt2']; 
	$dz_rate2=$rate_detail[0]['dz_rate2'];
	$dz_add_wgt=$rate_detail[0]['dz_add_wgt']; 
	$dz_add_rate=$rate_detail[0]['dz_add_rate'];
	$dz_fuel_formula=$rate_detail[0]['dz_fuel_formula'];
	$dz_fuel_rate=$rate_detail[0]['dz_fuel_rate'];
	$dz_sp_handling_formula=$rate_detail[0]['dz_sp_handling_formula'];
	$dz_sp_handling_rate=$rate_detail[0]['dz_sp_handling_rate'];
	$dz_gst_rate=$rate_detail[0]['dz_gst_rate']; 
	//=END============Different Zone
	$cash_handling_formula=$rate_detail[0]['cash_handling_formula']; 
	$cash_handling_rate=$rate_detail[0]['cash_handling_rate'];
	$flyer_rate=$rate_detail[0]['flyer_rate']; 
	$rate_id = $rate_detail[0]['rate_id'];
	//================Calculate Rate
	if($rate_type=="WC"){
	$calcu=$this->calculate_rate($o_weight,$sc_wgt1, $sc_rate1, $sc_wgt2, $sc_rate2, $sc_add_wgt, $sc_add_rate, $sc_gst_rate, $sc_fuel_formula, $sc_fuel_rate, $sc_sp_handling_formula, $sc_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sc_rate1;
	$order_add_rate 				=$sc_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
	} else if($rate_type=="SZ"){
	$calcu=$this->calculate_rate($o_weight,$sz_wgt1, $sz_rate1, $sz_wgt2, $sz_rate2, $sz_add_wgt, $sz_add_rate, $sz_gst_rate, $sz_fuel_formula, $sz_fuel_rate, $sz_sp_handling_formula, $sz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					=$sz_rate1;
	$order_add_rate 				=$sz_add_rate;
	$order_gst 						=$calcu->my_gst;
	$order_sc 						=$calcu->my_amount;
	$order_sp_handling_rate 		=$calcu->my_handling;
	$order_cash_handling_rate 		=$calcu->my_cash_handling;
	$order_fuel 					=$calcu->my_fuel;
	$order_flyer_rate 				=$flyer_rate;
	$order_total_amount_with_flyer 	=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			=(($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));

	} else if($rate_type=="DZ"){
	$calcu=$this->calculate_rate($o_weight,$dz_wgt1, $dz_rate1, $dz_wgt2, $dz_rate2, $dz_add_wgt, $dz_add_rate, $dz_gst_rate, $dz_fuel_formula, $dz_fuel_rate, $dz_sp_handling_formula, $dz_sp_handling_rate, $cash_handling_formula, $cash_handling_rate, $cash_limit, $cod);
	$calcu=json_decode($calcu);
	
	$order_rate 					= $dz_rate1;
	$order_add_rate 				= $dz_add_rate;
	$order_gst 						= $calcu->my_gst;
	$order_sc 						= $calcu->my_amount;
	$order_sp_handling_rate 		= $calcu->my_handling;
	$order_cash_handling_rate 		= $calcu->my_cash_handling;
	$order_fuel 					= $calcu->my_fuel;
	$order_flyer_rate 				= $flyer_rate;
	$order_total_amount_with_flyer 	= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
    virtal hable
	} */
	//=END============Calculate Rate
	$order_rate 					= 0;
	$order_add_rate 				= 0;
	$order_gst 						= 0;
	$order_sc 						= 0;
	$order_sp_handling_rate 		= 0;
	$order_cash_handling_rate 		= 0;
	$order_fuel 					= 0;
	$order_flyer_rate 				= 0;
	$order_total_amount_with_flyer 	= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
	$order_total_amount 			= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
	$order_code=$this->get_order_code($o_city_code);
	$ip= $_SERVER['REMOTE_ADDR'];
	if($d_city_id!=0 && $d_city_id!=null){
	$this->set_barcode($order_code);
	//=========================================================END	
	$data = array(
	'customer_id'					=> 	$customer_id,
	'cod_amount'					=> 	$cod,
	'order_date'					=> 	$o_date,
	'order_code'					=> 	$order_code,
	'customer_reference_no'			=> 	$c_ref_no,
	'order_booking_date'			=> 	'0000-00-00 00:00:00',
	'order_arrival_date'			=> 	'0000-00-00 00:00:00',
	'order_deliver_date'			=> 	'0000-00-00 00:00:00',
	'order_rr_date'					=> 	'0000-00-00 00:00:00',
	'order_cr_date'					=> 	'0000-00-00 00:00:00',
	'order_status'					=> 	'Order',
	'destination_city'				=> 	$d_city_id,
	'destination_zone'				=> 	$d_city_zone,
	'destination_city_name'			=> 	$d_city_name,
	'origin_city'					=> 	$o_city,
	'origin_zone'					=> 	$o_city_zone,
	'origin_city_name'				=> 	$o_city_name,
	'pickup_point_id'				=>	$pick_point,
	'order_rate_type'				=> 	$rate_type,
	'order_service_type'			=> 	$ship_type,
	'order_receive_from'			=> 	'PIB',
	'weight'						=>	$o_weight,
	'pieces'						=>	$o_piece,
	'consignee_name'				=>	$c_name,
	'consignee_email'				=>	$c_email,
	'consignee_address'				=>	$c_address,
	'consignee_mobile'				=>	$c_phone,
	'product_detail'				=>	$product_detail,
	'order_remark'					=>	$remark,
	'order_rate'					=>	$order_rate,
	'order_add_rate'				=>	$order_add_rate,
	'order_gst'						=>	$order_gst,
	'order_sc'						=>	$order_sc,
	'order_sp_handling_rate'		=>	$order_sp_handling_rate,
	'order_cash_handling_rate'		=>  $order_cash_handling_rate,
	'order_fuel'					=>	$order_fuel,
	'order_flyer_rate'				=>	$order_flyer_rate,
	'order_total_amount_with_flyer' =>  $order_total_amount_with_flyer,
	'order_total_amount'            =>  $order_total_amount, 
	'pickup_rider_id'				=>	'0',
	'delivery_rider_id'				=>	'0',
	'order_cr'						=>	'N',
	'order_receive_amount'			=> 	'0',
	'order_pay_mode'                =>  $payment_mode,
	'order_packing_type'            =>  $packing_type,
	'rate_id'						=>	$rate_id,
	'origin_reporting'              =>  $o_city_reporting,
	'destination_reporting'         =>  $d_city_reporting,
	'created_by'					=>	$customer_id,
	'created_date'					=>	date('Y-m-d H:i:s')
	);
	
		    
	
	$insert_id=$this->Commonmodel->Insert_record('saimtech_order', $data);
	$status_msg="Your Order Has Been Generated.";
	$this->insert_tracking_detail($insert_id,'Order',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,$customer_id,date('Y-m-d H:i:s'));
	$this->Commonmodel->Delete_record_double_condition('saimtech_import_error', 'import_error', $import_error_id, 'customer_id', $customer_id);
	$this->db->trans_complete();
	} else {
    $data=array('error' => 'City Error');
	$this->Commonmodel->Update_record('saimtech_import_error', 'import_error', $import_error_id, $data);
    $message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>".$c_name.", ".$c_ref_no." City Error</strong> Please Enter Currect City. And Try Again <a href='".base_url()."Booking/error_data'>View Detail</a></div></div>";
    } 
	if($insert_id>0){	
	$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>".$d_city.", ".$c_name.", ".$order_code."</strong> Your Shippment is successfully Booked</div></div>";
	} 
	} else {
	$data=array('error' => 'Missing Error');
	$this->Commonmodel->Update_record('saimtech_import_error', 'import_error', $import_error_id, $data);    
	$message = "<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>".$c_name." Missing Error !</strong> Something is missing please try again. <a href='".base_url()."Booking/error_data'>View Detail</a></div></div>";	}
	//=========================================================END
	}
	echo $message;	
	}
	fclose($handle);
	}	
	


    public function draw_import_error_table(){
    $error_data=$this->Commonmodel->Get_record_by_condition('saimtech_import_error', 'customer_id', $_SESSION['customer_id']);
    if(!empty($error_data)){
    echo("<table class='table'>");
    echo("<tr>");
	echo("<th>Reference#</th>");
    echo("<th>Name</th>");
    echo("<th>phone</th>");
    echo("</tr>");
    foreach($error_data as $rows){
    echo("<tr>");
    echo("<td>".$rows->reference_no."</th>");
    echo("<td>".$rows->name."</th>");
    echo("<td>".$rows->phone."</th>");
    echo("</tr>");    
    }    
    }
    }
    
    
    public function error_data(){
        
    //get records from database
	$error_data=$this->Commonmodel->Get_record_by_condition('saimtech_import_error', 'customer_id', $_SESSION['customer_id']);
    $delimiter = ",";
    $filename = "Tm Cargo Import_Erro_File " . date('Y-m-d') . ".csv";
    //create a file pointer
    $f = fopen('php://memory', 'w');
    //set column headers
    	
    $fields = array('Error','Shipment Type', 'Pieces', 'Weight', 'COD Amount', 'Reference No', 'Product Detail', 'Pickup Point ID', 'Consignee Name', 'Consignee Phone', 'Consignee Email', 'Destination City Code', 'Consignee Address', 'Remark', 'Speical Handling','Packing Type', 'Payment Mode');
    fputcsv($f, $fields, $delimiter);
    //output each row of the data, format line as csv and write to file pointer
    foreach($error_data as $rows){    
        $lineData = array($rows->error,$rows->shipment_type, $rows->pieces, $rows->weight, $rows->cod, $rows->reference_no, $rows->product, $rows->pickup_id, $rows->name, $rows->phone, $rows->email, $rows->destination, $rows->address, $rows->remark, $rows->handling, $rows->packing_type ,$rows->payment_mode);
        fputcsv($f, $lineData, $delimiter);
    }
    //move back to beginning of file
    fseek($f, 0);
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    //output all remaining data on a file pointer
    fpassthru($f);
    exit;
   
        
    }    

    
    public function incomplete_detail_view(){
    $data['order_data']=$this->Commonmodel->Get_record_by_condition('saimtech_order', 'order_receive_from', 'AB');
	$this->load->view('module_booking/incompleteView',$data);	    
    }



    public function new_zone_rating_module($origin_city_id,$destination_city_id,$customer_id,$service_type_id,$wgt){
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
    if(!empty($zone_rate_data)){
    $rate_id=$zone_rate_data[0]['rate_id'];    
    //SELECT `rate_id`, `customer_id`, `service_id`, `sc_wgt1`, `sc_rate1`, `sc_wgt2`, `sc_rate2`, `sc_add_wgt`, `sc_add_rate`, `sc_gst_rate`, `sc_fuel_formula`, `sc_fuel_rate`, `sc_sp_handling_formula`, `sc_sp_handling_rate`, `sc_return_formula`, `sc_return_rate`, `sz_wgt1`, `sz_rate1`, `sz_wgt2`, `sz_rate2`, `sz_add_wgt`, `sz_add_rate`, `sz_gst_rate`, `sz_fuel_formula`, `sz_fuel_rate`, `sz_sp_handling_formula`, `sz_sp_handling_rate`, `sz_return_formula`, `sz_return_rate`, `dz_wgt1`, `dz_rate1`, `dz_wgt2`, `dz_rate2`, `dz_add_wgt`, `dz_add_rate`, `dz_fuel_formula`, `dz_fuel_rate`, `dz_sp_handling_formula`, `dz_sp_handling_rate`, `dz_gst_rate`, `dz_return_formula`, `dz_return_rate`, `zz_wgt1`, `zz_rate1`, `zz_wgt2`, `zz_rate2`, `zz_add_wgt`, `zz_add_rate`, `zz_fuel_formula`, `zz_fuel_rate`, `zz_sp_handling_formula`, `zz_sp_handling_rate`, `zz_gst_rate`, `zz_return_formula`, `zz_return_rate`, `cash_handling_formula`, `cash_handling_rate`, `reference_formula`, `reference_rate`, `flyer_rate`, `is_enable`, `deactive_date`, `delete_date`, `created_by`, `created_date`, `modify_by`, `modify_date`, `timestamp` FROM `saimtech_rate`
    //=A============Zone A
    $zone_a_wgt1=$zone_rate_data[0]['sc_wgt1'];	
    $zone_a_wgt2=$zone_rate_data[0]['sc_wgt2'];	
    $zone_a_add_wgt=$zone_rate_data[0]['sc_add_wgt'];	
    $zone_a_rate1=$zone_rate_data[0]['sc_rate1'];	
    $zone_a_rate2=$zone_rate_data[0]['sc_rate2'];
    $zone_a_add_rate=$zone_rate_data[0]['sc_add_rate'];
    $zone_a_gst=$zone_rate_data[0]['sc_gst_rate'];
    if($dest_zone=="A"){
    $zone_A=$this->calculate_rate($wgt,$zone_a_wgt1, $zone_a_rate1, $zone_a_wgt2, $zone_a_rate2, $zone_a_add_wgt, $zone_a_add_rate, $zone_a_gst, $rate_id);
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
    $zone_B=$this->calculate_rate($wgt,$zone_b_wgt1, $zone_b_rate1, $zone_b_wgt2, $zone_b_rate2, $zone_b_add_wgt, $zone_b_add_rate, $zone_b_gst, $rate_id);
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
    $zone_C=$this->calculate_rate($wgt,$zone_c_wgt1, $zone_c_rate1, $zone_c_wgt2, $zone_c_rate2, $zone_c_add_wgt, $zone_c_add_rate, $zone_c_gst, $rate_id);
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
    $zone_D=$this->calculate_rate($wgt,$zone_d_wgt1, $zone_d_rate1, $zone_d_wgt2, $zone_d_rate2, $zone_d_add_wgt, $zone_d_add_rate, $zone_d_gst, $rate_id);
    $calcu=json_decode($zone_D);
    }
	//=D============END
    } else {echo("|ZR|Something Went Wrong."); } 
    } else {echo("|Z|Something Went Wrong."); }    
    } else {echo("|R|Something Went Wrong.");}
    return $calcu;
    }
    
    public function new_destination_rating_module($origin_city_id,$destination_city_id,$customer_id,$service_id,$wgt){
    $calcu=0;
    $check=$this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $service_id, 'customer_id', $customer_id, 'origin_city_id', $origin_city_id, 'dest_city_id', $destination_city_id, 'is_enable', '1');
    if($check>0){
    $rate_detail=$this->Commonmodel->Get_record_by_five_condition('saimtech_destination_rate', 'service_id', $service_id, 'customer_id', $customer_id, 'origin_city_id', $origin_city_id, 'dest_city_id', $destination_city_id, 'is_enable', '1');
    //SELECT `dest_rate_id`, `customer_id`, `service_id`, `origin_city_id`, `dest_city_id`, `city_wgt1`, `city_rate1`, `city_wgt2`, `city_rate2`, `city_add_wgt`, `city_add_rate`, `is_enable`, `created_by`, `created_date`, `modify_by`, `modify_date` FROM `saimtech_destination_rate` WHERE 1
    if(!empty($rate_detail)){
    $calcu=$this->calculate_rate($wgt,$rate_detail[0]['city_wgt1'], $rate_detail[0]['city_rate1'], $rate_detail[0]['city_wgt2'], $rate_detail[0]['city_rate2'], $rate_detail[0]['city_add_wgt'], $rate_detail[0]['city_add_rate'], $rate_detail[0]['city_gst'], $rate_detail[0]['dest_rate_id']);    
    $calcu=json_decode($calcu);
        
    }    
    }
    return $calcu;
    }



   public function calculate_rate($wgt,$wgt1, $rate1, $wgt2, $rate2, $add_wgt, $add_rate, $gst, $rate_id){
		//-----Initiate Varibles
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
		$my_amount	 = $rate1;}
		//END---Order Weight Under Weight1
        //------Order Weight Under Weight2
        else if($wgt <= $wgt2){
		$my_amount 	 =  $rate2; }
		//END---Order Weight Under Weight2
		//------Order Weight Above Weight2 (Additonal Rate)
        else if($wgt > $add_wgt){
		$my_wht 	 = $wgt - $wgt2;
		$f_wht 		 = ceil(($my_wht) /  ($add_wgt));
		$total_wht 	 =  $add_rate * $f_wht;
        $my_amount 	 = $rate2 + $total_wht; }
        //END---Order Weight Above Weight2 (Additonal Rate)	
         //------GST Calculation 
        $sum=$my_amount;
        $my_gst=round(((($sum)*($gst))/100),2);
        //END---GST Calculation
        $arr= array(
        'my_amount'			=> $my_amount,
		'my_wht'			=> $my_wht,
		'f_wht'				=> $f_wht,
		'total_wht'			=> $total_wht,
		'my_gst'			=> $my_gst,
		'my_rate_id'		=> $rate_id);
        return json_encode($arr);

	}
	

	
}
