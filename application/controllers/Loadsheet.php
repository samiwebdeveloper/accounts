<?php

class Loadsheet extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Arrivalmodel');
    }


	public function index(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loadsheet";	
	$data['event_name']="Loadsheet";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['arrival_sheets']=$this->Arrivalmodel->Get_Arrival_Sheets_By_Origin_Range($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_loadsheet/loadsheetView',$data);	
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
	$date=date('Y-m-d h:i:s');
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
		$order_weight	= $order_detail[0]['weight'];
		$order_pieces	= $order_detail[0]['pieces'];
		$is_final		= $order_detail[0]['is_final'];
		$is_arrival		= $order_detail[0]['is_arrival'];
		$order_id 		= $order_detail[0]['order_id'];
		//------------------------------------
		if($order_status=="Booking" && $is_final==0 && $is_arrival==0){
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
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
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
		 	'order_code' 		 => $cn, 
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
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Found :(</p></td><td></td><td></td><td></td></tr>");		
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


	public function redraw_table($code){
	$arrival_sheet_data=$this->Arrivalmodel->Get_Arrival_Sheet_By_code($code);
	if(!empty($arrival_sheet_data)){
    foreach($arrival_sheet_data as $rows){
    echo("<tr>");
    echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
    echo("<td>".$rows->cn."</td>");
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
       $new_weight 	 = $rows->new_weight;
       $weight 		 = $rows->weight;
       $pieces 		 = $rows->pieces;
       $new_pieces	 = $rows->new_pieces;
       $cash_limit   = 30000;
       if($new_pieces!="" && $new_pieces!=0){ 
    	$data =array('pieces' 	=> $new_pieces);
 		$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);}
       	if($new_weight!="" && $new_weight!=0){ 
       	$order_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_order', 'order_code', $cn);
       	$rate_type 	 	= $order_data[0]['order_rate_type'];
       	$customer_id 	= $order_data[0]['customer_id'];
       	$cod 			= $order_data[0]['cod_amount'];	
       	$service_type 	= $order_data[0]['order_service_type'];
       	$o_weight 		= $new_weight;
       	$rate_detail=$this->Commonmodel->Get_record_by_triple_condition('saimtech_rate', 'customer_id', $customer_id, 'service_id', $service_type, 'is_enable', 1);
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
		$order_add_rate 				=$sz_add_wgt;
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
		$order_add_rate 				= $dz_add_wgt;
		$order_gst 						= $calcu->my_gst;
		$order_sc 						= $calcu->my_amount;
		$order_sp_handling_rate 		= $calcu->my_handling;
		$order_cash_handling_rate 		= $calcu->my_cash_handling;
		$order_fuel 					= $calcu->my_fuel;
		$order_flyer_rate 				= $flyer_rate;
		$order_total_amount_with_flyer 	= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel) + ($order_flyer_rate));
		$order_total_amount 			= (($order_gst) + ($order_sc) + ($order_sp_handling_rate) + ($order_cash_handling_rate) + ($order_fuel));
		}
		$data =array(
 		'weight' 						=>  $new_weight,	
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
		'modify_by'						=>  $_SESSION['user_id'],
		'modify_date' 					=>  date('Y-m-d h:i:s') 
		); 
		$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);	
       	 }
       }
       }
    // Update Pieces, Weight & Rate END
    // Update Arrival sheet status 
    $data =array('is_complete' 	=> 1);
 	$this->Commonmodel->Update_record('saimtech_arrival_list', 'arrival_sheet_code', $sheet_code, $data);		
    // Update Arrival sheet status -END
    redirect('Arrival');	
    }




    public function calculate_rate($wgt,$wgt1, $rate1, $wgt2, $rate2, $add_wgt, $add_rate, $gst, $fuel_formula, $fuel_rate, $sp_formula, $sp_rate, $cash_handling_rate, $cash_handling_formula, $cash_limit, $cod){
	//-----Initiate Varibles
	$my_amount=0;
	$my_wht=0;
	$f_wht=0;
	$total_wht=0;
	$my_gst=0;
	$my_fuel=0;
	$my_handling=0;
	$my_cash_handling=0;
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
	$f_wht 		 = ceil($my_wht) /  $add_wgt;
	$total_wht 	 =  $add_rate * $f_wht;
    $my_amount 	 = $rate2 + $total_wht; }
    //END---Order Weight Above Weight2 (Additonal Rate)	
    //------Fuel Calculation 
    if($fuel_formula=="PER"){
    $my_fuel=round(((($my_amount)*($fuel_rate))/100),2);} 
    else if($fuel_formula=="FIX"){
    $my_fuel=$fuel_rate;}
    //END---Fuel Calculation 
    //------Sp Handling Calculation 
    if($sp_formula=="PER"){
    $my_handling=round(((($my_amount)*($sp_rate))/100),2);} 
    else if($sp_formula=="FIX"){
    $my_handling=$sp_rate;}
    //END---Sp Handling Calculation 
    //------Cash Handling Calculation 
    if($cash_limit>=$cod){
    if($cash_handling_formula=="PER"){	
    $my_cash_handling=round(((($my_amount)*($cash_handling_rate))/100),2);} 
    else if($cash_handling_formula=="FIX"){
    $my_cash_handling=$cash_handling_rate;}} 
    else { $my_cash_handling=0;}
    //END---Cash Handling Calculation 
    //------GST Calculation 
    $sum=(($my_amount)+($my_cash_handling)+($my_fuel)+($my_handling));
    $my_gst=round(((($sum)*($gst))/100),2);
    //END---GST Calculation
    $arr= array(
    'my_amount'			=> $my_amount,
	'my_wht'			=> $my_wht,
	'f_wht'				=> $f_wht,
	'total_wht'			=> $total_wht,
	'my_gst'			=> $my_gst,
	'my_fuel'			=> $my_fuel,
	'my_handling'		=> $my_handling,
	'my_cash_handling'	=> $my_cash_handling);
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
