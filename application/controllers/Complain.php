<?php

class Complain extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Complainmodel');
    $this->load->model('Arrivalmodel');
    }
    public function index(){
	$this->session->set_flashdata('ticket_no','');
	$this->session->set_flashdata('cn_check','');
    $data['nature_data']=$this->Complainmodel->Get_All_Complain_Nature();
    $this->load->view('complainView',$data);
 }
    public function Complain_type_By_Nature_Id(){
      //echo"<pre>";print_r("ok");echo"</pre>";  
	$nature_id=$this->input->post('nature');
	$complain_type=$this->Complainmodel->Get_Complain_type_By_Nature_Id($nature_id);
    echo "<option value='' >Select Type</option>"; 
 	foreach($complain_type as $rows){
 	echo "<option value='".$rows->type_id."'>".$rows->type_name."</option>";
	}
	}
	public function Insert_Complain(){
	$data['cn_check']="";  
	$cn_no=$this->input->post('cn_no');
	$nature_id=$this->input->post('nature');
	$types_id=$this->input->post('types');
	$name=$this->input->post('name');
	$number=$this->input->post('number');
	$remarks=$this->input->post('remarks');
	$complainant_remarks=$this->input->post('complainant_remarks');
	$user_id=$_SESSION['user_id'];
	$date=date('Y-m-d');
	$chk=$this->Complainmodel->Duplicate_double_check('saimtech_complain', 'cn', $cn_no,'is_complete',0);
	
	if($chk!=[]){
	    $data_array= array();
	    $data_array['ticket_no']        =$chk[0]['ticket_no'];
	    $this->session->set_flashdata('tick_no',''.$data_array['ticket_no']);
	    $this->session->set_flashdata('cn_chk','fail');
	    redirect('Complain/index');
	}
	elseif($cn_no!="" && $nature_id!="" && $types_id!="" && $name!="" && $number!=""  && $user_id!="" && $date!=""){
	    	$data = array(
		 	'cn' 			 => $cn_no, 
		 	'nature_id' 		 => $nature_id, 
		 	'type_id' 	 => $types_id, 
		 	'complainant_name'=> $name, 
		 	'complainant_phone' 	 => $number, 
		 	'complainant_remarks'			 =>	$complainant_remarks,
		 	'date'			 =>	$date,
		 	'status'			 =>	'Pending',
		 	'is_complete'	 =>	0,
		 	'remarks'			 =>	$remarks,
		 	'created_by' 		 => $user_id,
		 	'assign_to'          =>$user_id
		 	);	
		 	 $detail_id=$this->Complainmodel->Insert_record('saimtech_complain', $data);
		 	 $ticket_no =2000 +$detail_id;
		 	 $result=$this->Complainmodel->update_complain_ticket_by_id($detail_id,$ticket_no);
		 	 if($result>0){
		 	 $this->send_mail($detail_id);
		 	 }
	         $this->session->set_flashdata('tick_no',''.$ticket_no);
	         $this->session->set_flashdata('cn_chk','pass');
	         redirect('Complain/index');
	}
	else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td></tr>");
	 }

	}
	public function send_mail($complain_id){
	$data['complain_data']=$this->Complainmodel->Get_Complain_By_Id($complain_id);
    $msg=$this->load->view('module_complain/mailView',$data,true);    
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
  	$this->load->library('email');
  	$this->email->initialize($config);
    $this->email->from('ops@delex.pk', 'TMCARGO AI Center');
    $this->email->to('humair.yousaf@tmcargo.net');
    // $this->email->to('muhammad.saim@tmcargo.net');
    $this->email->subject('New Complain Registered By '.$_SESSION['user_name']);
    $this->email->message($msg);
    $this->email->send();
    }
	public function report(){
	$data['start_date']="";	
	$data['end_date']="";
	$user_id=$_SESSION['user_id'];
	$enddate=date('Y-m-d');
    //$startdate=date('Y-m-d', strtotime('-29 day', strtotime($enddate)));
    $startdate=date('Y-m-01');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;   
	if(($_SESSION['user_power']=='SE') OR ($user_id== 3)OR ($user_id== 21))
	{
	$data['complain_list']=$this->Complainmodel->Get_Complains_By_Date_Range($startdate,$enddate);
	}
	else
	{
	$data['complain_list']=$this->Complainmodel->Get_Complains_By_User_Date($startdate,$enddate,$user_id);
	}
	$this->load->view('module_complain/complainReportView',$data);	
	}
	public function report_date_range(){
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$user_id=$_SESSION['user_id'];
	if(($_SESSION['user_power']=='SE') OR ($user_id== 3)OR ($user_id== 21))
	{
	$data['complain_list']=$this->Complainmodel->Get_Complains_By_Date_Range($startdate,$enddate);
	}
	else
	{
	$data['complain_list']=$this->Complainmodel->Get_Complains_By_User_Date($startdate,$enddate,$user_id);
	}
	$this->load->view('module_complain/complainReportView',$data);	
	
	}
	public function complain_status($id,$nature_id){
    $data['complain_data']=$this->Complainmodel->Get_Complain_By_Id($id);
    //echo"<pre>";print_r($data['complain_data']);echo "</pre>";
    
    $data['nature_data']=$this->Complainmodel->Get_All_Complain_Nature();
    $data['type_data']=$this->Complainmodel->Get_Complain_type_By_Nature_Id($nature_id);
    $this->load->view('module_complain/complainStatusView',$data);	
	}
	public function update_complain_status($id){
    $status=$this->input->post('status');
    $remarks=$this->input->post('remarks');
    if($status=="Pending")
    {
     $is_complete= 0;   
    }
    else
    {
      $is_complete= 1;  
    }
    $is_complete_date=date('Y-m-d');
    $modify_by=$_SESSION['user_id'];
    $modify_date=date('Y-m-d h:i:s');
    $this->Complainmodel->update_complain_status_by_id($id,$status,$remarks,$is_complete,$is_complete_date,$modify_by,$modify_date);
	redirect('complain/report');
	    
	}
	public function complain_assign($id,$nature_id){
	$data['cs_data']=$this->Complainmodel->Get_All_Cs_Employee();
	$data['complain_data']=$this->Complainmodel->Get_Complain_By_Id($id);
    $data['nature_data']=$this->Complainmodel->Get_All_Complain_Nature();
    $data['type_data']=$this->Complainmodel->Get_Complain_type_By_Nature_Id($nature_id);
    $this->load->view('module_complain/complainAssignView',$data);
	}
	public function update_complain_assign($id){
    $assign_id=$this->input->post('assign_id');
    $modify_by=$_SESSION['user_id'];
    $modify_date=date('Y-m-d h:i:s');
    $this->Complainmodel->update_complain_assign_by_id($id,$assign_id,$modify_by,$modify_date);
	redirect('complain/report');
	}
     
}
?>