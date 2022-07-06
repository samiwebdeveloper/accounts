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

class Web extends CI_Controller {

	function __construct() {
    parent::__construct();
     date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Ccommonmodel');
    $this->load->model('Bookingmodel');
    }
    
    public function api_json2(){
     $data=file_get_contents('php://input');
    $mdata=json_decode($data);
    echo $mdata->api_key;
    }
    
    //==========================================================
	public function api_json(){
	$data=file_get_contents('php://input');
    $mdata=json_decode($data);  
    $customer_detail=$this->Bookingmodel->Get_customer_by_api_key($mdata->api_key); 
    if(!empty($customer_detail)){
	//==============Get Values From Booking Form=================		
	$message			 = "";
	$cash_limit 		 =100000000;					
	$ship_type           = $mdata->shipment_type;
	$manual_cn           = null;
	$o_date              = date('Y-m-d H:i:s');
	$o_piece             = $mdata->order_piece;
	$o_weight            = $mdata->order_weight;
	$cod              	 = $mdata->cod_amount;
	$c_ref_no   		 = $mdata->customer_reference_no;
	$o_city              = $mdata->origin_city;
	$re_ship     		 = 'No';	
	$c_name              = $mdata->consignee_name;
	$c_phone             = $mdata->consignee_phone;
	$c_email             = $mdata->consignee_email;
	$s_name              = $mdata->shipper_name;
	$s_phone             = $mdata->shipper_phone;
	$s_email             = $mdata->shipper_email;
	$d_city              = $mdata->dest_city;
	$c_address           = $mdata->consignee_address;
	$s_address           = $mdata->shipper_address;
	$recheck_weight      = 'No';
	$remark              = $mdata->remark;
	$sp_handling         = $mdata->sp_handling;
	$product_detail		 = $mdata->product_detail;
	$payment_mode		 = $mdata->payment_mode;
	$packing_type		 = $mdata->packing_type;
	$customer_id 		 = $customer_detail[0]['customer_id'];
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
	$time = date('H');
	if($time<=5 || $time<=05){
    $date=date_create(date('Y-m-d'));
    date_sub($date,date_interval_create_from_date_string("1 days"));
    $order_date=date_format($date,"Y-m-d 00:00:00");    
	}
	else {
	$order_date= $o_date;    
	}
	//$m_Cn_check=$this->Commonmodel->Duplicate_check('saimtech_order', 'manual_cn', $manual_cn);
	//if($m_Cn_check==0){
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
	$dcheck=$this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $ship_type, 'customer_id', $customer_id, 'origin_city_id', $o_city, 'dest_city_id', $d_city, 'is_enable', '1');
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
	'manual_cn'					    => 	null,
	'order_date'					=> 	$order_date,
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
	'created_by'					=>	10000,
	'created_date'					=>	date('Y-m-d H:i:s')
	);
	$insert_id=$this->Commonmodel->Insert_record('saimtech_order', $data);
	$status_msg="Your Shipment Has Been Booked.";
	$this->insert_tracking_detail($insert_id,'Order',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,$customer_id,date('Y-m-d H:i:s'));
	$this->insert_tracking_detail($insert_id,'Booking',$o_city,$o_city_name,$status_msg,date('Y-m-d H:i:s'),$ip,$customer_id,date('Y-m-d H:i:s'));
	$this->db->trans_complete();
	if($insert_id>0){	
	$order_codee=$order_code;    
	$error=0;
	$message = "".$order_code." Your Shippment is successfully Booked.";
	$msg ="Dear Valued Customer,\r\n Your shipment #".$order_code." is booked from ".$o_city_name." to ".$d_city_name." Dated ".$order_date." For any further query  call us at 0309-7777228 for tracking update\r\n Thank you for using TM CARGO";
	$data = array(
    'sms_msg'       =>$msg, 
    'sms_phone'     =>$c_phone, 
    'sms_date'      =>date('Y-m-d'), 
    'sms_status'    =>'N',
    );	
	$sms_id=$this->Ccommonmodel->Insert_record('saimtech_sms', $data);
	    
	} else {
	$order_codee="";    
	$error = 1;
	$message = "Missing Error ! Something wrong.";}
	} else {
	$order_codee="";    
	$error = 1;
	$message = "Missing Error ! Something is missing please try again.";}
	//} else {
	//$order_codee="";      
	//$error = 1;
	//$message = "Duplicate CN Error !";}
	//=========================================================END
	} else {
	$order_codee="";      
	$error = 1;
	$message = "Invalid API Key";}
     $arr = array(
    'message'    => $message, 
    'order_code' => $order_code,
    'error'      => $error,
    );
     echo json_encode($arr);
	}
	//==========================================================
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
	//==========================================================
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
    //==========================================================
	public function set_barcode($code){
    $targetDir = FCPATH."../assets/barcode/cn/";
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
    $code = $code;
    $store_image = imagepng($file,$targetDir."/{$code}.png");
    }	
	//==========================================================
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
    //==========================================================
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
    //==========================================================
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
    //==========================================================

	
}
