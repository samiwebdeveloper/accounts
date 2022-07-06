<?php

class RR extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Delivery2model');
    $this->load->model('Deliverymodel');
    }


	public function index(){
	//echo($_SESSION['origin_id']);	
	$data['sub_nav_active']="Operations";
	$data['nav_active']="RR";	
	$data['event_name']="RR";
	$this->load->view('module_rr/rrView');	
	}
	
	
	public function rr_sheet_data(){
	$sheet_code= trim($this->input->post('sheet_code'));
	if($sheet_code!=""){	
	$sheet_data=$this->Delivery2model->Get_RR_Sheet_By_Code($sheet_code);
	$total_cod=0;
	if(!empty($sheet_data)){
    $i=0;
    $total_cod=0;
    foreach($sheet_data as $rows){
    $i=$i+1;
    $total_cod = $total_cod + $rows->cod_amount;
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->delivery_code."</td>");
    echo("<td>".$rows->order_code."</td>");
    echo("<td>".$rows->rider_code."-".$rows->rider_name."</td>");
    echo("<td>".$rows->route_code."-".$rows->route_name."</td>");
    echo("<td>".$rows->delivery_date."</td>");
    if($rows->delivery_code==$rows->on_route_id){
    echo("<td>".$rows->order_deliver_date."</td>");
    } else {
     echo("<td>=>".$rows->order_deliver_date."</td>");    
    }
    echo("<td><center>".number_format($rows->cod_amount)."/-</center></td>");
    echo("<td><center>".number_format($rows->cod_amount)."/-</center></td>");
    echo("</tr>"); 
    }
	echo("<tr>");
	echo("<th></td>");
    echo("<th></th>");
    echo("<th</th>");
    echo("<th</th>");
    echo("<th></th>");
    echo("<th></th>");
    echo("<th></th>");
    echo("<th></th>");
    echo("<th></th>");
    echo("<th><center>".number_format($total_cod)."/-</center></th>");
    echo("<th><center>".number_format($total_cod)."/-</center></th>");
    echo("</tr>");
	}  
	} else {
	echo("<center><p class='alert alert-danger'>Some Thing is Went Wrong :(</p></center>");	} 
	//$this->redraw_table($sheet_code);
	//-----------------------------------------
	}
	

	public function rr_print($sheet_code){
	$data['sheet_data']=$this->Delivery2model->Get_RR_Sheet_By_Code($sheet_code);
	$this->load->view('module_rr/rrprintView');	
	} 
	
}
