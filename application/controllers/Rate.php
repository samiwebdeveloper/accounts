<?php
//WC=With in City
//SZ=Same in Zone
//DZ=Different in Zone
//UK=Unknown
//PSB=Portal Single Booking
//PIB=Portal Import Booking
//WAB=Web Api Booking

class Rate extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Bookingmodel');
    $this->load->model('Pickmodel');
    $this->load->model('Ratingmodel');
    }

    public function index(){
    echo("<center>All Done</center>");    
    }

	public function rating($customer_id){
	$this->Commonmodel->Update_Rate_Type();
	$rate_id                        = 0;
	$rate_type                      ="";
	$o_weight                       = "";//---Order Weight
	$cash_limit                     = 10000000;   
	$cod                            = "";
	$order_id                       = 0;
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
	//------------------------------------------------    
	//	$rate_detail=$this->Commonmodel->Get_record_by_triple_condition('saimtech_ratess', 'customer_id', $customer_id, 'service_id', $ship_type, 'is_enable', 1);
	$order_detail=$this->Commonmodel->Get_record_by_condition('saimtech_order', 'customer_id', $customer_id);
	if(!empty($order_detail)){
	foreach($order_detail as $rows){
	$rate_id                        = $rows->rate_id;
	$o_weight                       = $rows->weight;
	$cash_limit                     = 10000000;   
	$cod                            = $rows->cod_amount;
	$order_id                       = $rows->order_id;
	$rate_type                      = $rows->order_rate_type;
	$rate_detail=$this->Commonmodel->Get_record_by_condition_array('saimtech_rate', 'rate_id', $rate_id);
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
	
	$data = array(
	'order_rate'					=>	$order_rate,
	'order_add_rate'				=>	$order_add_rate,
	'order_gst'						=>	$order_gst,
	'order_sc'						=>	$order_sc,
	'order_sp_handling_rate'		=>	$order_sp_handling_rate,
	'order_cash_handling_rate'		=>  $order_cash_handling_rate,
	'order_fuel'					=>	$order_fuel,
	'order_flyer_rate'				=>	$order_flyer_rate,
	'order_total_amount_with_flyer' =>  $order_total_amount_with_flyer,
	'order_total_amount'            =>  $order_total_amount
	);
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $order_id, $data);
	//redirect('Rate');
	} 
	} else {echo "Something Went Wrong";    }
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
	
        
        public function cal_all_rating(){
        $customer=$this->Commonmodel->Get_all_record('saimtech_customer'); 
        if(!empty($customer)){
        foreach($customer as $rows){
        $this->rating($rows->customer_id);
        echo("<br>".$rows->customer_name." Rating Done");
        }    
        }
        }
        
        
	    public function cheezmall_rating(){
	    $this->Ratingmodel->Update_Cheezmall_Rates();    
	    echo("<p class='alert alert-sucess'>Orders Rating Successfully Done</p>");    
	    }
	




	
}
