<?php

class Cr extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    }

    public function Get_Cr_From_Old_System(){
    $url = "https://delex.com.pk/Web/cr_data";
	//Curl Start
	$ch  =  curl_init();
	$timeout  =  30;
	curl_setopt ($ch,CURLOPT_URL, $url) ;
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
	$response = curl_exec($ch) ;
	curl_close($ch) ; 
	$order_data          = json_decode($response);
	$check=$this->Commonmodel->Duplicate_check('saimtech_cr_payment', 'cr_date', $order_data[0]);
	if($check==0){
	if(!empty($order_data[1])){
	foreach($order_data[1] as $rows){
	if($rows->cr_due_amount!=0){
	$city_list=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_name', $rows->Destination);    
    $data = array(
    'cr_due_amount'       => $rows->cr_due_amount,
    'cr_cns_count'        => $rows->CNs,    
    'cr_deposit_amount'   => 0,    
    'cr_date'             => $rows->Date, 
    'cr_difference'       => $rows->cr_due_amount,  
    'cr_origin'           => $city_list[0]['city_id']
    );
    $insert_id=$this->Commonmodel->Insert_record('saimtech_cr_payment', $data);}
	}
	    
	}
	} else {
	echo "Already Sync-ed RunTim Protection Activated";    
	}
	}

}
