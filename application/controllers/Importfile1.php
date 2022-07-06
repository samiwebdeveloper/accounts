<?php
class Importfile extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonnewmodel');
    }


    public function index(){
    $this->load->view('importfileView');		
    }


	public function submit_import_file(){
	$handle = fopen($_FILES['file']['tmp_name'], "r");
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	if($data[0]!="id" && $data[1]!="random_code" ){	
	//==============Get Values From Booking Form=================		
	$mydata =array(
			
 			'random_code' =>$data[1],
 	 		'order_code' =>$data[2].$data[96], 
 	 		'agent_code' => $data[3],
 	 		'agent_name' =>$data[4],
 	 		'consignee_mobile_no' =>$data[5],
 	 		'consignee_email' =>$data[6],
     		'consignee_name' =>$data[7],
     		'consignee_address' => $data[8],
     		'destination_city_id' => $data[9],
     		'origin_city_id' => $data[10],
     		'weight' => $data[11],
     		'pieces' => $data[12],
      		'cod_amount' => $data[13],
      		'customer_reference_no' => $data[14],
            'service_type_id' =>$data[15],
            'special_handling' =>$data[16], 
            'special_handling_charges' => $data[17],
            'product_detail' => $data[18],
            'remarks' => $data[19],
            'flyer_no' =>$data[20],
            'flyer_status' => $data[21],
            'order_date' =>$data[22],
            'order_time' =>$data[23],
            'user_id' => $data[24],
            'order_status' => 'Booking',
            'order_type' =>$data[26],
            'ip_address' => $data[27],
            'load_sheet_status' => $data[28],
            'load_sheet_id' => $data[29],
            'rider_id' => $data[30],
            'is_arrival' => 0,
            'arrival_order' => 0,
            'arrival_id' => 0,
            'is_manifest' => 0,
            'manifest_id' => 0,
            'manifest_remarks' => 0,
            'is_bagging' => 0,
            'bagging_order' => 0,
            'bagging_id' => 0,
            'is_loading' => 0,
            'loading_order' => 0,
            'loading_id' => 0,
            'is_unloading' => 0,
            'unloading_id' => 0,
            'is_debagging' => 0,
            'debagging_order' => 0,
            'debagging_id' => 0,
            'debagging_date_time' => 0,
            'debagging_by' => 0,
            'is_sheet' => 0,
            'sheet_order' => 0,
            'sheet_id' => 0,
            'is_rr_sheet' => $data[53],
            'rr_sheet_id' => $data[54],
            'rr_sheet_status' => $data[55],
            'received_date' => $data[56],
            'received_time' => $data[57],
            'received_by' => $data[58],
            'sheet_reason' => $data[59],
            'receiver_cnic' => $data[60],
            'receiver_relation' => $data[61],
            'given_to_rider' => $data[62],
            'sheet_comments' => $data[63],
            'is_final' => $data[64],
            'is_invoice' =>$data[65],
            'invoice_order' => $data[66],
            'invoice_id' => $data[67],
            'rate' => $data[68],
            'additional_rate' =>  $data[69],
            'total_rate' => $data[70],
            'gst' => $data[71],
            'total_gst' => $data[72],
            'fuel' => $data[73],
            'total_fuel' => $data[74],
            'flyer_charges' => $data[75],
            'handling_charges' => $data[76],
            'return_charges' => $data[77],
            'total_rate_with_gst' => $data[78],
            'total_cod' => $data[79],
            'total_receiveable' => $data[80],
            'net_receiveable' => $data[81],
            'payment_reference' => $data[82],
            'reference_date' => $data[83],
            'reference_time' => $data[84],
            'reference_by' => $data[85],
            'is_payment' => $data[86],
            'is_payment_id' => $data[87],
            'payment_deposit_date' => $data[88],
            'payment_deposit_mode' => $data[89],
            'payment_deposit_reference' => $data[90],
            'is_enable' => $data[91],
            'created_date' => $data[92],
            'created_by' => $data[93],
            'modify_date' => $data[94],
            'modify_by'=>$data[95] );
		    $id=$this->Commonmodel->Insert_record('user_order_list', $mydata);
		    echo $id."<br>";
		}
		}

		fclose($handle);
		}
}