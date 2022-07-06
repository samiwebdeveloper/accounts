<?php

class Route extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    }


	public function index(){
	$data['sub_nav_active']="Manage";
	$data['nav_active']="Route";	
	$data['event_name']="Route";
	if($_SESSION['user_power']!="TPT"){
	$data['route_data']=$this->Commonmodel->Get_record_by_double_condition('saimtech_route', 'route_origin', $_SESSION['origin_id'],'agent_id',0);
	} else {$data['route_data']=$this->Commonmodel->Get_record_by_condition('saimtech_route', 'agent_id', $_SESSION['thrid_party_id']);}
	$this->load->view('module_route/routeView',$data);	
	}
	
	public function add_route(){
	$route_name=$this->input->post('name');
	$route_code=$this->input->post('code');
	$citycode=$_SESSION['city_code'];
	$message=0;  
    if($route_name!="" && $route_code!=""){
    $check=$this->Commonmodel->Duplicate_check('saimtech_route', 'route_code', $rider_code);    
    if($check==0){
	$data =array(    
	'route_code'                =>$route_code, 
	'route_name'                =>$route_name, 
	'route_origin'              =>$_SESSION['origin_id'], 
	'is_enable'                 =>1, 
	'agent_id'                  =>$_SESSION['thrid_party_id'], 
	'created_by'                =>$_SESSION['user_id'], 
	'created_date'              =>date('Y-m-d H:i:s'));
	$route_id=$this->Commonmodel->Insert_record('saimtech_route', $data);	
	$this->send_mail($route_id);
	echo $message;  
    } else {echo $message=2; }
    } else { echo $message=1; }	
	}
	

	
	public function update_status($status,$route_id){
	if($status!=""){
	$data =array('is_enable'=>$status);
	$this->Commonmodel->Update_record('saimtech_route', 'route_id', $route_id, $data);
	}
	$this->redraw_table();   
	}

	public function redraw_table(){
	$route_data=$this->Commonmodel->Get_record_by_condition('saimtech_route', 'route_origin', $_SESSION['origin_id']);
	if(!empty($route_data)){$i=0;   
    foreach($route_data as $rows){
    $i=$i+1;    
    echo("<tr>");
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->route_code."</td>");
    echo("<td>".$rows->route_name."</td>");
    if($rows->is_enable==1){
    echo("<td class='bg-success text-black' ><center>Active</center></td>");
    echo("<td><button class='btn btn-danger btn-xs' onclick='update_status(0,".$rows->route_id.")'>Deactive</button></td>");  
    } else if($rows->is_enable==0){
    echo("<td class='bg-danger text-black' ><center>Deactive</center></td>");
    echo("<td><button class='btn btn-success btn-xs' onclick='update_status(1,".$rows->route_id.")'>Active</button></td>");  
    }
    echo("</tr>"); }}  
	}


	public function send_mail($rider_id){
    $data['route_data']=$this->Commonmodel->Get_record_by_condition('saimtech_route', 'route_origin', $_SESSION['origin_id']);
    $msg=$this->load->view('module_route/mailView',$data,true);
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
  	$this->load->library('email');
  	$this->email->initialize($config);
    $this->email->from('ops@delex.pk', 'Delex AI Center');
    $this->email->to('muhammad.shahzad@tmcargo.net,mirza.abbas@tmcargo.net');
    $this->email->cc('muhammad.saim@tmcargo.net');
    $this->email->subject('New Route Found At '.$_SESSION['origin_name'].' Office');
    $this->email->message($msg);
    $this->email->send();
    }

    public function file(){
	$data['sub_nav_active']="Manage";
	$data['nav_active']="Shipment File";	
	$data['event_name']="Shipment File";
	$data['file_data']=$this->Commonmodel->Get_record_by_condition('saimtech_order', 'is_file', 1);	
	$this->load->view('module_file/fileView',$data);	
	}
	
	public function submit_import_file(){
	$cn=$this->input->post('cn');
	$manual_cn= $this->input->post('manual_cn');
	$file_name = $_FILES['file']['name'];
    $path="assets/cn_files/";
    if($cn!="" && $manual_cn!="" && 	$file_name!="" && $path!=""){
    $check=$this->Commonmodel->Duplicate_double_check('saimtech_order', 'order_code',$manual_cn, $cn, 'is_file', 0);
    if($check>0){
    $data =array(
    'is_file'=>1,
    'file_path'=>$file_name
    );
	$this->Commonmodel->Update_record('saimtech_order', 'order_code',$manual_cn, $cn, $data); 
	$this->upload_photo('file',$path);
    $this->redraw_file_table();
    } else {
     echo("<td><center><p class='alert alert-danger'>CN not found</p></center></td>");        
    }
    } else {
    echo("<td><center><p class='alert alert-danger'>Something went wrong please try again.</p></center></td>");    
    }
	}
	
	public function remove_file($id){
	if($id!="" && $id!=0){    
	$data =array('is_file'=>0,
    'file_path'=>"");
	$this->Commonmodel->Update_record('saimtech_order', 'order_id', $id, $data);     
	}
	$this->redraw_file_table();    
	}
	
    public function upload_photo($field_name,$path){
    $status="Doing";
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'png|jpg|gif|jpeg|PNG|JPG|GIF|JPEG';
    $config['max_size'] = '3000000';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload($field_name)) {
    $data['errormsg'] = "Upload Fail";
    $status= $this->upload->display_errors();
    } else {
    $upload_data = $this->upload->data();
    $data['errormsg'] = "Upload";
    $status = $upload_data['file_name'];
    }  
    return $status;}
    
    
    public function redraw_file_table(){
    $file_data=$this->Commonmodel->Get_record_by_condition('saimtech_order', 'is_file', 1);	    
    if(!empty($file_data)){$i=0;
    foreach($file_data as $rows){
    $i=$i+1;        
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->order_code."</td>");
    echo("<td><a href='".base_url()."/assets/cn_files/".$rows->file_path."' class='btn btn-info btn-xs'>View</a></td>");
    if($_SESSION['user_power']=="SE"){
    echo("<td><button onclick='remove_file(".$rows->order_id.")' class='btn btn-danger btn-xs'>Remove</button></td>");
    } else {
    echo("<td><code>No Rights</code></td>");
    }
    echo("</tr>");
    }    
    }
        
    }


}
