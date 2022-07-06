<?php

class Dest_Rate extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Dest_ratemodel');
    $this->load->model('Bookingmodel');
    $this->load->model('Commonmodel');
	}
    
    public function index($customer_id){
    $data['customer_id']=$customer_id;
    $data['cities_data']=$this->Bookingmodel->Get_All_Cities();
    $data['zone_data']=$this->Dest_ratemodel->Get_Zone_Detail($customer_id);
    $data['dest_data']=$this->Dest_ratemodel->Get_Destination_Detail($customer_id);
    $data['shipment_types']=$this->Commonmodel->Get_record_by_condition('saimtech_service', 'is_enable', 1);
    $this->load->view('module_customer/dest_rateView',$data);
 }
 
    public function Add_Zone_Rate()
	{
	    
	    
	    
	    
	    
	    
	$customer_id=$this->input->post('zone_customer_id');    
	$zone_a=$this->input->post('zone_a');
	$zone_a_gst=$this->input->post('zone_a_gst');
	$zone_b=$this->input->post('zone_b');
	$zone_b_gst=$this->input->post('zone_b_gst');
	$zone_c=$this->input->post('zone_c');
	$zone_c_gst=$this->input->post('zone_c_gst');
	$zone_d=$this->input->post('zone_d');
	$zone_d_gst=$this->input->post('zone_d_gst');
	$zone_service_type=$this->input->post('zone_service_type');
	$this->load->model('Dest_ratemodel');
	$data =array('is_enable' => 0);
	$this->Commonmodel->Update_double_record('saimtech_zone_rate', 'customer_id', $customer_id, 'z_service_type_id', $zone_service_type, $data);   
	 
	$check=$this->Dest_ratemodel->Zone_Duplicate_Check($customer_id,$zone_service_type);
	if($check < 1)
	{
	    
	$this->Dest_ratemodel->Insert_Zone_Rate($customer_id,$zone_a,$zone_a_gst,$zone_b,$zone_b_gst,$zone_c,$zone_c_gst,$zone_d,$zone_d_gst,$zone_service_type);
	$this->index();
	}
}

public function Add_Destination_Rate()
	{
	$customer_id=$this->input->post('dest_customer_id');
	$dest_city_id=$this->input->post('dest_city_id');
	$rate=$this->input->post('rate');
	$additional_rate=$this->input->post('additional_rate');
	$service_type_id=$this->input->post('service_type_id');
	$this->load->model('Dest_ratemodel');
	$check=$this->Dest_ratemodel->Dest_Duplicate_Check($service_type_id,$dest_city_id);
	if($check < 1)
	{
	$this->Dest_ratemodel->Insert_Destination_Rate($customer_id,$origin_city_id,$dest_city_id,$rate,$additional_rate,$service_type_id);
	$this->index();
	}
}


     
}
?>