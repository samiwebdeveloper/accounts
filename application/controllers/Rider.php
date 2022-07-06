<?php

class Rider extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    }


	public function index(){
	$data['sub_nav_active']="Manage";
	$data['nav_active']="Rider";	
	$data['event_name']="Rider";
	if($_SESSION['user_power']!="TPT"){
	$data['rider_data']=$this->Commonmodel->Get_record_by_double_condition('saimtech_rider', 'rider_origin_id', $_SESSION['origin_id'],'agent_id',0);} 
	else {$data['rider_data']=$this->Commonmodel->Get_record_by_condition('saimtech_rider', 'agent_id', $_SESSION['thrid_party_id']);}
	$this->load->view('module_rider/riderView',$data);	
	}
	
	public function add_rider(){
	$rider_name=$this->input->post('name');
	$rider_cnic=$this->input->post('cnic');
	$citycode=$_SESSION['city_code'];
	$message=0;  
    if($rider_name!="" && $rider_cnic!=""){
    $check=$this->Commonmodel->Duplicate_check('saimtech_rider', 'rider_cnic', $rider_cnic);    
    if($check==0){
	$data =array(    
	'rider_code'                =>uniqid(), 
	'rider_cnic'                =>$rider_cnic, 
	'rider_name'                =>$rider_name, 
	'rider_origin_id'           =>$_SESSION['origin_id'], 
	'rider_reporting_station'   =>$_SESSION['origin_name'], 
	'rider_empcode'             =>'NA', 
	'is_enable'                 =>1, 
	'agent_id'                  =>$_SESSION['thrid_party_id'], 
	'created_by'                =>$_SESSION['user_id'], 
	'created_date'              =>date('Y-m-d H:i:s'));
	$rider_id=$this->Commonmodel->Insert_record('saimtech_rider', $data);	
	$rider_code=$this->Rider_code($rider_id);   
	$data =array('rider_code' =>$rider_code);
	$this->Commonmodel->Update_record('saimtech_rider', 'rider_id', $rider_id, $data);
	$this->send_mail($rider_id);
    } else {echo $message=2; }
    } else { echo $message=1; }	
	}
	
	public function Rider_code($rider_id){
	$code=$rider_id;
	$prefix=$_SESSION['city_code'].date('y');
		 if(strlen($rider_id)==1){ $precode=$prefix."0000".$code;} 
	else if(strlen($rider_id)==2){ $precode=$prefix."000".$code;} 
	else if(strlen($rider_id)==3){ $precode=$prefix."00".$code;} 
	else if(strlen($rider_id)==4){ $precode=$prefix."0".$code;} 
	return $precode;
	}
	
	public function update_status($status,$rider_id){
	if($status!=""){
	$data =array('is_enable'=>$status);
	$this->Commonmodel->Update_record('saimtech_rider', 'rider_id', $rider_id, $data);
	}
	$this->redraw_table();   
	}

	public function redraw_table(){
	$rider_data=$this->Commonmodel->Get_record_by_condition('saimtech_rider', 'rider_origin_id', $_SESSION['origin_id']);
	if(!empty($rider_data)){$i=0;   
    foreach($rider_data as $rows){
    $i=$i+1;    
    echo("<tr>");
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->rider_code."</td>");
    echo("<td>".$rows->rider_name."</td>");
    echo("<td>".$rows->rider_cnic."</td>");
    echo("<td>".$rows->rider_empcode."</td>");
    if($rows->is_enable==1){
    echo("<td class='bg-success text-black' ><center>Active</center></td>");
    echo("<td><button class='btn btn-danger btn-xs' onclick='update_status(0,".$rows->rider_id.")'>Deactive</button></td>");  
    } else if($rows->is_enable==0){
    echo("<td class='bg-danger text-black' ><center>Deactive</center></td>");
    echo("<td><button class='btn btn-success btn-xs' onclick='update_status(1,".$rows->rider_id.")'>Active</button></td>");  
    }
    echo("</tr>"); }}  
	}


	public function send_mail($rider_id){
    $data['rider_data']=$this->Commonmodel->Get_record_by_condition('saimtech_rider', 'rider_id', $rider_id);
    $msg=$this->load->view('module_rider/mailView',$data,true);
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
  	$this->load->library('email');
  	$this->email->initialize($config);
    $this->email->from('ops@delex.pk', 'Delex AI Center');
    $this->email->to('kashif.mazhar@tmcargo.net,ehsan@tmcargo.net');
    $this->email->cc('muhammad.saim@tmcargo.net,waseem.beg@tmcargo.net');
    $this->email->subject('New Rider Found At '.$_SESSION['origin_name'].' Office');
    $this->email->message($msg);
    $this->email->send();
    }

   
    

}
