<?php

class Loading extends CI_Controller {

	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    $this->load->model('Loadingmodel');
    }


	public function index(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loading";	
	$data['event_name']="Loading";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=date('Y-m-d');
    $startdate=date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['loading_sheets']=$this->Loadingmodel->Get_Loading_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_transit/transitView',$data);	
	}
	
	public function loading_print($id){
	if($id!=""){
	$data['sheet_data']=$this->Loadingmodel->Get_Loading_Sheet_By_ID($id);
	$data['destination_data']=$this->Loadingmodel->Get_Loading_Sheet_Detail_Destination_By_ID($id);
	$this->load->view('module_transit/printtransitView',$data);}	
	}
	public function loading_print_all($id){
	if($id!=""){
	$data['sheet_data']=$this->Loadingmodel->Get_Loading_Sheet_By_ID($id);
	$data['hub_data']=$this->Loadingmodel->Get_Loading_Sheet_By_ID2($id);
	$this->load->view('module_transit/printalltransitView',$data);}	
	}
	
	
	public function date_range(){
	$data['sub_nav_active']="Operations";
	$data['nav_active']="Loading";	
	$data['event_name']="Loading";
	$data['start_date']="";	
	$data['end_date']="";
	$enddate=$this->input->post('end_date');
    $startdate=$this->input->post('start_date');
    $data['start_date']=$startdate;	
	$data['end_date']=$enddate;
	$data['loading_sheets']=$this->Loadingmodel->Get_Loading_Sheets_By_Origin($_SESSION['origin_id'],$startdate,$enddate);
	$this->load->view('module_transit/transitView',$data);	
	}
	
	
	public function create_Loading_sheet_view(){
	$data['route_data']=$this->Commonmodel->Get_record_by_condition('saimtech_route_list', 'is_enable', 1);	
	$data['loading_sheet_code']=$this->get_loading_sheet_code();
	$data['loading_sheet_data']="";
	$this->load->view('module_transit/transitcreateView',$data);	
	}


    public function get_loading_sheet_code(){
	$code=$this->Loadingmodel->Get_Last_Loading_Sheet_Code();
	$prefix="MENI".date('y');
	if(strlen($code)==1){ $precode=$prefix."000000".$code;} 
	else if(strlen($code)==2){ $precode=$prefix."00000".$code;} 
	else if(strlen($code)==3){ $precode=$prefix."0000".$code;} 
	else if(strlen($code)==4){ $precode=$prefix."000".$code;} 
	else if(strlen($code)==5){ $precode=$prefix."00".$code;}
	else if(strlen($code)==6){ $precode=$prefix."0".$code;} 
	else if(strlen($code)==7){ $precode=$prefix.$code;}
	return $precode;
	}

    public function loading_seal(){
	$seal=$this->input->post('seal_no');
	$chk=0;
	if($seal!=""){
	$chk=$this->Commonmodel->Duplicate_check('saimtech_vehicle_history', 'seal_no', $seal);}
	echo $chk;
	}
	
	
    public function Loading_process(){
	$cn 				= $this->input->post('cn');
    $date 				= date('Y-m-d H:i:s');
	$seal_no 			= $this->input->post('seal_no');
    $route 		        = $this->input->post('route');
	$loading_sheet_code = $this->input->post('loading_sheet_code');
	$staff_name         = $this->input->post('staff_name');
	$staff_number       = $this->input->post('staff_number');
	$vehicle_no         = $this->input->post('vehicle_no');
	$origin 			= $_SESSION['origin_id'];
	$origin_name 		= $_SESSION['origin_name'];
	$order_status 		= "";
	$order_detail 		= "";
	$sheet_check 		= "";
	$order_status 		= "";
	$order_id 			= "";
    $loading_id 		= 0;
	$cn_check			= $this->Commonmodel->Duplicate_check('saimtech_order', 'order_code', $cn);
	$cn_check2			= $this->Commonmodel->Duplicate_check('saimtech_order', 'manual_cn', $cn);
	//-----------------------------------------
	if($cn_check>0 || $cn_check2>0){	
	 if($cn!="" && $date!=""  && $loading_sheet_code!="" && $seal_no!="" && $staff_name!="" && $route!="" && $staff_number!="" && $staff_name!="" && $vehicle_no!="" ){
		$this->db->trans_start();
		$order_detail 		= $this->Commonmodel->Order_Code_AND_Anaul($cn);
		$sheet_check 		= $this->Commonmodel->Duplicate_check('saimtech_transit_list', 'transit_code', 	$loading_sheet_code);
		$route_destination  = $this->Commonmodel->Get_record_by_double_condition_array('saimtech_route_detail', 'route_list_id', $route, 'type', 'D');
		$order_status		= $order_detail[0]['order_status'];
		$cn		            = $order_detail[0]['order_code'];
		$order_weight		= $order_detail[0]['weight'];
		$order_pieces		= $order_detail[0]['pieces'];
		$manual_cn		    = $order_detail[0]['manual_cn'];
		$consginee		    = $order_detail[0]['consignee_name'];
 	   	$order_destination	= $order_detail[0]['destination_reporting'];
 	   	$order_origin	    = $order_detail[0]['origin_reporting'];
 	   	$destination_city	= $order_detail[0]['destination_city'];
 	   	$is_transit         = $this->Commonmodel->Duplicate_double_check('saimtech_route_detail', 'city_id', $order_destination,'route_list_id', $route );
		$origin_is_transit  = $this->Commonmodel->Duplicate_double_check('saimtech_route_detail', 'city_id', $order_origin,'route_list_id', $route );
		$is_final			= $order_detail[0]['is_final'];
		$shipper			= $order_detail[0]['shipper_name'];
		$order_id 			= $order_detail[0]['order_id'];
		//------------------------------------
		//if(($order_status=="Arrival" || $order_status=="Booking" || $order_status=="DE Manifest" || $order_status=="Return") && $is_final==0 ){
		if(($order_status=="Arrival" || $order_status=="DE Manifest" || $order_status=="Short Received") && $is_final==0 ){
		
			if($is_transit>0){
		 	//------------------------------------
		 	if($sheet_check<1){
		 	$data = array(
		 	'transit_code'          =>$loading_sheet_code, 
		 	'transit_date'          =>$date, 
		 	'transit_seal'          =>$seal_no, 
		 	'transit_route_id'      =>$route, 
		 	'staff_name'            =>$staff_name,
		 	'staff_number'          =>$staff_number,
		 	'vehicle_no'            =>$vehicle_no, 
		 	'transit_origin'        =>$origin, 
		 	'current_location'      =>$origin, 
		 	'route_destination'     =>$route_destination[0]['city_id'], 
		 	'created_by'            =>$_SESSION['user_id'], 
		 	'created_date'          =>date('Y-m-d H:i:s'), 
		 	'modify_by'             =>0, 
		 	'modify_date'           =>date('Y-m-d h:i:s'));	
		 	$loading_id=$this->Commonmodel->Insert_record('saimtech_transit_list', $data);
		 	} else {
		 	$loading_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_transit_list','transit_code',$loading_sheet_code);	
		 	$loading_id=$loading_data[0]['transit_list_id'];
		 	}
		 	$m_double_manifest_check=$this->Commonmodel->Duplicate_double_check('saimtech_transit_detail', 'transit_list_id', $loading_id, 'manual_cn', $cn);
		 	$e_double_manifest_check=$this->Commonmodel->Duplicate_double_check('saimtech_transit_detail', 'transit_list_id', $loading_id, 'transit_cn', $cn);
		 	//------------------------------------	
		 	if($m_double_manifest_check==0 && $e_double_manifest_check==0){
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=> 'Transit',
		 	'is_loading'		=>	1,
		 	'loading_id'		=> $loading_sheet_code,
		 	'modify_by'		    => $_SESSION['user_id'],
		 	'modify_date'		=> $date
		 	);
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 	//Insert into Order Detail
		 	$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'Transit', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> 	$_SESSION['origin_name'], 
		 	'order_message' 	 => 'Your shipment is Transit / '.$loading_sheet_code.' / '.$staff_name.' / '.$staff_number.' / '.$vehicle_no, 
		 	'order_ip'			 =>	$_SERVER['REMOTE_ADDR'],
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	
		 	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 	//Insert into saimtech_vehicle History
		 	$data = array(
		 	'loading_code' 			=> $loading_sheet_code, 
		 	'staff_name' 		    => $staff_name, 
		 	'seal_no' 		        => $seal_no, 
		 	'staff_number'          => $staff_number,
		 	'vehicle_no'            => $vehicle_no, 
		 	'origin_id'             => $origin, 
		 	'created_by' 		    => $_SESSION['user_id'],  
		 	'created_date' 		    => $date );	
		 	$vehicle_history_id=$this->Commonmodel->Insert_record('saimtech_vehicle_history', $data);
		 	//Insert into transit detail
		 	$data = array(
		 	'transit_list_id' 	 => $loading_id, 
		 	'transit_cn' 		 => $cn,
		 	'transit_shipper' 	 => $shipper,
		 	'weight' 	         => $order_weight, 
		 	'pieces' 	         => $order_pieces, 
		 	'consignee_detail'   => $consginee,
		 	'manual_cn'          => $manual_cn,
		 	'destination' 	     => $order_destination, 
		 	'actual_destination' => $destination_city,
		 	'transit_date'		 => date('Y-m-d H:i:s'), 
		 	'is_unload'		     => 0, 	
		 	'unload_date'        => '0000-00-00 00:00:00',
		 	'unload_origin'      => 0,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'modify_by' 		 =>	0,
		 	'modify_date'		 => date('Y-m-d H:i:s'));
		 	$loading_detail_id=$this->Commonmodel->Insert_record('saimtech_transit_detail', $data);	
		 	} else {
	        echo("<tr><td><p class='alert alert-danger'>Duplicate Cn found.</p></td><td></td><td></td><td></td><td></td><td></td></tr>");}
		 	$this->db->trans_complete();
	        } else {echo("<tr><td><p class='alert alert-danger'>Given CN belongs to another Route.</p></td><td></td><td></td><td></td><td></td><td></td></tr>");}
	
		    } else if($order_status=="Return" && $is_final==0 ){
		    if($origin_is_transit>0){
		 	//------------------------------------
		 	if($sheet_check<1){
		 	$data = array(
		 	'transit_code'          =>$loading_sheet_code, 
		 	'transit_date'          =>$date, 
		 	'transit_seal'          =>$seal_no, 
		 	'transit_route_id'      =>$route, 
		 	'staff_name'            =>$staff_name,
		 	'staff_number'          =>$staff_number,
		 	'vehicle_no'            =>$vehicle_no, 
		 	'transit_origin'        =>$origin, 
		 	'current_location'      =>$origin, 
		 	'route_destination'     =>$route_destination[0]['city_id'], 
		 	'created_by'            =>$_SESSION['user_id'], 
		 	'created_date'          =>date('Y-m-d H:i:s'), 
		 	'modify_by'             =>0, 
		 	'modify_date'           =>date('Y-m-d h:i:s'));	
		 	$loading_id=$this->Commonmodel->Insert_record('saimtech_transit_list', $data);
		 	} else {
		 	$loading_data=$this->Commonmodel->Get_record_by_condition_array('saimtech_transit_list','transit_code',$loading_sheet_code);	
		 	$loading_id=$loading_data[0]['transit_list_id'];
		 	}
		 	$m_double_manifest_check=$this->Commonmodel->Duplicate_double_check('saimtech_transit_detail', 'transit_list_id', $loading_id, 'manual_cn', $cn);
		 	$e_double_manifest_check=$this->Commonmodel->Duplicate_double_check('saimtech_transit_detail', 'transit_list_id', $loading_id, 'transit_cn', $cn);
		 	//------------------------------------	
		 	if($m_double_manifest_check==0 && $e_double_manifest_check==0){
		 	//Update Order
		 	$data = array(
		 	'order_status' 		=> 'Transit',
		 	'is_loading'		=>	1,
		 	'loading_id'		=> $loading_sheet_code,
		 	'modify_by'		    => $_SESSION['user_id'],
		 	'modify_date'		=> $date
		 	);
		 	 $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
		 	//Insert into Order Detail
		 	$data = array(
		 	'order_id' 			 => $order_id, 
		 	'order_event' 		 => 'Transit', 
		 	'order_location' 	 => $origin, 
		 	'order_location_name'=> 	$_SESSION['origin_name'], 
		 	'order_message' 	 => 'Your shipment is Transit / '.$loading_sheet_code.' / '.$staff_name.' / '.$staff_number.' / '.$vehicle_no, 
		 	'order_ip'			 =>	$_SERVER['REMOTE_ADDR'],
		 	'order_event_date'	 =>	$date,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'created_date' 		 =>	$date );	
		 	$detail_id=$this->Commonmodel->Insert_record('saimtech_order_tracking', $data);
		 	//Insert into saimtech_vehicle History
		 	$data = array(
		 	'loading_code' 			=> $loading_sheet_code, 
		 	'staff_name' 		    => $staff_name, 
		 	'seal_no' 		        => $seal_no, 
		 	'staff_number'          => $staff_number,
		 	'vehicle_no'            => $vehicle_no, 
		 	'origin_id'             => $origin, 
		 	'created_by' 		    => $_SESSION['user_id'],  
		 	'created_date' 		    => $date );	
		 	$vehicle_history_id=$this->Commonmodel->Insert_record('saimtech_vehicle_history', $data);
		 	//Insert into transit detail
		 	$data = array(
		 	'transit_list_id' 	 => $loading_id, 
		 	'transit_cn' 		 => $cn,
		 	'transit_shipper' 	 => $shipper,
		 	'weight' 	         => $order_weight, 
		 	'pieces' 	         => $order_pieces, 
		 	'consignee_detail'   => $consginee,
		 	'manual_cn'          => $manual_cn,
		 	'destination' 	     => $order_destination, 
		 	'actual_destination' => $destination_city,
		 	'transit_date'		 => date('Y-m-d H:i:s'), 
		 	'is_unload'		     => 0, 	
		 	'unload_date'        => '0000-00-00 00:00:00',
		 	'unload_origin'      => 0,
		 	'created_by' 		 => $_SESSION['user_id'],  
		 	'modify_by' 		 =>	0,
		 	'modify_date'		 => date('Y-m-d H:i:s'));
		 	$loading_detail_id=$this->Commonmodel->Insert_record('saimtech_transit_detail', $data);	
		 	} else {
	        echo("<tr><td><p class='alert alert-danger'>Duplicate Cn found.</p></td><td></td><td></td><td></td><td></td><td></td></tr>");	
		 	}
		 	$this->db->trans_complete();} 
		 	else { echo("<tr><td><p class='alert alert-danger'>Given CN belongs to another Route.</p></td><td></td><td></td><td></td><td></td><td></td></tr>");}
		} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Eligible For Manifest</p></td><td></td><td></td><td></td><td></td><td></td></tr>");}
	//------------------------------------	
	} else {
	echo("<tr><td><p class='alert alert-danger'>Something Went Wrong Please Try Again :(</p></td><td></td><td></td><td></td><td></td><td></td></tr>");}
	} else {
	echo("<tr><td><p class='alert alert-danger'>This CN is Not Found :(</p></td><td></td><td></td><td></td><td></td><td></td></tr>");		
	} 
    $this->redraw_table($loading_sheet_code);
	//-----------------------------------------
	} 

    public function redraw_table($loading_sheet_code){
    $loading_sheets=$this->Loadingmodel->Get_Loading_Sheet_By_Sheet_Code($loading_sheet_code);
    if(!empty($loading_sheets)){
    $i=0;    
    foreach($loading_sheets as $rows){
    $i=$i+1;      
    echo("<tr>");
    echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->transit_cn."</td>");
    echo("<td>".$rows->manual_cn."</td>");
    echo("<td>".$rows->pieces."</td>");
    echo("<td>".$rows->weight."</td>");
    if($rows->order_pay_mode=='ToPay' || $rows->order_pay_mode=='Topay'){
  echo("<td><center>".$rows->cod_amount."</center></td>");
    } else {
  echo("<td><center>"."0"."</center></td>");
    }
    echo("<td>".$rows->ActualD."</td>");
    echo("<td>".$rows->route_name."</td>");
    echo("<td>".$rows->tDate."</td>");
    echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->transit_cn.")'>Remove</button></td>");
    echo("</tr>");     
    }    
    }
    }
    
    public function complete_sheet($sheet){
    $data = array('complete_sheet_date' => date('Y-m-d H:i:s'));
	$this->Commonmodel->Update_record('saimtech_transit_list', 'transit_code', $sheet, $data);    
    redirect('Loading');    
    }
	
	public function remove_cn(){
    $cn=$this->input->post('cn');
    $code="";
    $order_id="";
    if($cn!=""){
    $this->db->trans_start();	
    $loading_sheet_data=$this->Loadingmodel->Get_Order_Detail_By_CN($cn);
    if(!empty($loading_sheet_data)){
  	$code=$loading_sheet_data[0]['loading_id'];
    $order_id=$loading_sheet_data[0]['order_id'];
    $this->Commonmodel->Delete_record('saimtech_transit_detail', 'transit_cn', $cn);
 	$data =array(
 	'loading_id' 			=> 0,
 	'is_loading' 			=> 0,
 	'order_status' 			=> 'Arrival'	
 	);
 	$this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
 	$this->Commonmodel->Delete_record_double_condition('saimtech_order_tracking', 'order_id', $order_id, 'order_event', 'Transit');
    }	
    $this->db->trans_complete();
    } 
	$this->redraw_table($code);
    }
    
    public function export_manifest_detail($id){
        $manifest_data=$this->Loadingmodel->Get_Loading_Sheet_By_ID($id);
	//$invoice_archive_data=$this->Invoicemodel->Get_Invoice_Detail_Data_By_ID_Archive($id);
	
    //$invoices_data=array_merge($invoices_data,$invoice_archive_data);
	//$invoice_archive_data=$this->Invoicemodel->Get_Invoice_Detail_Data_By_ID_Archive($id);
	//if(!empty($invoice_archive_data)){
	//$invoice_data=array_merge($invoices_data,$invoice_archive_data);
	//} else {
	//$invoice_data=$invoices_data;    
	//}
    if(!empty($manifest_data)){
    $i=0;    
    $this->load->library("excel");
	$object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $table_columns = array("Sr #","Origin","Electron Number", "Manual. No", "Shipper", "Consignee" , "Pieces","Weight","FOD","Destination");
				$object->getActiveSheet()->setTitle('Manifest');
			  $column = 0;

  
	foreach($table_columns as $field){
	$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	$column++;
	}for ($col = ord('A'); $col <= ord('Z'); $col++) {
							//set column dimension
							$object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
							$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
							$object->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
							
							//change the font size
							$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
						}
						 $excel_row = 2;
                foreach($manifest_data as $row){
			    $i=$i+1;
                
			   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $i);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->origin_city_name);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->transit_cn);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->manual_cn);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->transit_shipper);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->consignee_detail);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->pieces);
			   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->weight);
			   if ($row->order_pay_mode=='ToPay' || $row->order_pay_mode=='Topay'){
			   $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->cod_amount);}
			   else 
			   {$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, 0);}
			   $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->ActaulD);
			   $excel_row++;
			   $i++;
            
			  }
			   		   
			  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			  header('Content-Type: application/vnd.ms-excel');
			  header('Content-Disposition: attachment;filename="Manifest.xls"');
			  $object_writer->save('php://output');
			  
    } 
    }
	
}
