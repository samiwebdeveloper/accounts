<?php

class Invoice extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Karachi');
		$this->load->model('Commonmodel');
		$this->load->model('Invoicemodel');
		$this->load->model('Bookingmodel');
	}


	public function index()
	{
		//echo($_SESSION['origin_id']);
		$data['sub_nav_active'] = "Accounts";
		$data['nav_active'] = "Invoice";
		$data['event_name'] = "Invoice";
		$enddate = date('Y-m-d');
		$startdate = date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
		$data['startdate'] = $startdate;
		$data['enddate'] = $enddate;
		$data['invoice_data'] = $this->Invoicemodel->Get_Invoice_Data_By_Date_Range_And_Mixture($startdate, $enddate, $_SESSION['user_mixture']);
		$this->load->view('module_invoice/invoiceView', $data);
	}



	public function in_payment()
	{
		//echo($_SESSION['origin_id']);
		$data['sub_nav_active'] = "Accounts";
		$data['nav_active'] = "Invoice";
		$data['event_name'] = "Invoice";
		$enddate = date('Y-m-d');
		$startdate = date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
		$data['startdate'] = $startdate;
		$data['enddate'] = $enddate;
		$data['invoice_data'] = $this->Invoicemodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
		$this->load->view('module_invoice/invoice2View', $data);
	}

	public function in_payment_submit()
	{
		$startdate 	  = $this->input->post('start_date');
		$enddate      = $this->input->post('end_date');
		if ($startdate != "" && $enddate != "") {
			$data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
			$data['invoice_data'] = $this->Invoicemodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
		} else {
			$data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
			$data['invoice_data'] = "";
		}
		$this->load->view('module_invoice/invoice2View', $data);
	}

	public function customer_destinations()
	{
		$customer_id = $this->input->post();
		$data['destinations'] = $this->Invoicemodel->Get_Customer_Billable_Destinations($customer_id);
		return $data['destinations'];
	}

	public function customer_services()
	{
		$customer_id = $this->input->post();
		$data['services'] = $this->Invoicemodel->Get_Customer_Billable_Services($customer_id);
		return $data['services'];
	}


	public function create_invoice()
	{
		$this->load->view('module_invoice/invoicecreateView');
	}

	public function create_invoice_data()
	{
		$startdate 	  = $this->input->get('start_date');
		$enddate      = $this->input->get('end_date');

		//$data['invoice_code'] = $this->get_invoice_sheet_code();
		$data['customer_data'] = $this->Invoicemodel->Get_Invoice_Active_Customer($startdate,$enddate);
		$data['destinations'] = $this->Invoicemodel->Get_Destinations();
		$data['services'] = $this->Invoicemodel->Get_Services();
		$encoded = json_encode($data, JSON_NUMERIC_CHECK);
		echo $encoded;
		//$this->load->view('module_invoice/invoicecreateView');


	}


	public function date_range()
	{
		$startdate 	  = $this->input->post('start_date');
		$enddate      = $this->input->post('end_date');
		if ($startdate != "" && $enddate != "") {
			$data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
			$data['invoice_data'] = $this->Invoicemodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
		} else {
			$data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
			$data['invoice_data'] = "";
		}
		$this->load->view('module_invoice/invoiceView', $data);
	}


	public function unpaid_cn()
	{
		$data['deliverd_data'] = $this->Invoicemodel->Get_Unpaid_Summary_Customer_Wise_Delivered($_SESSION['origin_id']);
		$data['rts_data'] = $this->Invoicemodel->Get_Unpaid_Summary_Customer_Wise_RTS($_SESSION['origin_id']);
		$this->load->view('module_invoice/unpaidinvoiceView', $data);
	}


	public function unpaid_cn_all()
	{
		//$data['deliverd_data']=$this->Invoicemodel->Get_All_Unpaid_Summary_Customer_Wise_Delivered();
		$data['deliverd_data'] = $this->Invoicemodel->Get_All_Unpaid_Summary_Customer_Wise_Delivered_And_RTS();
		//$data['rts_data']=$this->Invoicemodel->Get_All_Unpaid_Summary_Customer_Wise_RTS();
		$this->load->view('module_invoice/unpaidinvoiceView', $data);
	}

	public function uninvoiced_cn_all()
	{
		//$data['deliverd_data']=$this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_All();
		$data['deliverd_data'] = $this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS_All();
		//$data['rts_data']=$this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_RTS_All();
		$this->load->view('module_invoice/unpaidinvoicedetailView', $data);
	}

	public function unpaid_cn_all_detail($cid)
	{
		//$data['deliverd_data']=$this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered($cid);
		$data['deliverd_data'] = $this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS($cid);
		//$data['rts_data']=$this->Invoicemodel->Get_All_Unpaid_Detail_Customer_Wise_RTS($cid);
		$this->load->view('module_invoice/unpaidinvoicedetailView', $data);
	}

	public function cn_data_list()
	{
		$customer 	  = $this->input->post('customer');
		$invoice_code = $this->input->post('invoice_code');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_date_f = $this->input->post('invoice_date_f');
		$invoice_destination = $this->input->post('invoice_destination');
		$invoice_service = $this->input->post('invoice_service');
		// if ($customer != "" && $invoice_code != "" && $invoice_date != "" && $invoice_date_f != "") {
		$customer_data = $this->Invoicemodel->Get_CN_BY_Customer_ID_And_Date($customer, $invoice_date, $invoice_date_f, $invoice_destination, $invoice_service);

		/*if (!empty($customer_data)) {
			foreach ($customer_data as $rows) {
				$data = array(
					'is_temp_invoice' => $invoice_code,
					'modify_by' => $_SESSION['user_id'],
					'modify_date' => date('Y-m-d H:i:s'),
					'session' => session_id()
				);
				$this->Commonmodel->Update_record('acc_orders', 'acc_orders_id', $rows->acc_orders_id, $data);
			}*/

			echo json_encode($customer_data);

	}


	public function summary()
	{
		$invoice_code = $this->input->post('invoice_code');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_date_f = $this->input->post('invoice_date_f');
		if ($invoice_code != "") {
			$summary_data = $this->Invoicemodel->Get_Summary_By_Code_Date($invoice_code, $invoice_date, $invoice_date_f);
			$summary_COD = $this->Invoicemodel->Get_Summary_By_Code_OK_Date($invoice_code, $invoice_date, $invoice_date_f);
			if (!empty($summary_data)) {
				$net_total = $summary_data[0]['SC'] + $summary_data[0]['osa_sd'] + $summary_data[0]['order_osa'] + $summary_data[0]['order_fuel'] + $summary_data[0]['order_others'] + $summary_data[0]['GST'] + $summary_data[0]['order_faf'];
				echo ("<table class='table'><tr>");
				echo ("<td>Total Cns</td><td>" . $summary_data[0]['Cns'] . "</td></tr><tr>");
				echo ("<td>Total SC </td><td>" . number_format($summary_data[0]['SC'],2) . "/-</td></tr><tr>");
				echo ("<td>Total GST </td><td>" . number_format($summary_data[0]['GST'],2) . "/-</td></tr><tr>");
				echo ("<td>Total OSA|SD </td><td>" . number_format(($summary_data[0]['osa_sd'] + $summary_data[0]['order_osa']),2) . "/-</td></tr><tr>");
				echo ("<td>Total Fuel </td><td>" . number_format($summary_data[0]['order_fuel'],2) . "/-</td></tr><tr>");
				echo ("<td>Total FAF </td><td>" . number_format($summary_data[0]['order_faf'],2) . "/-</td></tr><tr>");
				echo ("<td>Total Others </td><td>" . number_format($summary_data[0]['order_others'],2) . "/-</td></tr><tr>");
				echo ("<tr>
					<td>NET</td><td>" . number_format($net_total,2) . "/-</td></tr><tr>
					</table>");
			} else {
				echo ("<table class='table'><tr>");
				echo ("<td>Total Cns</td><td></td></tr><tr>");
				echo ("<td>Total SC </td><td></td></tr><tr>");
			}
		}
	}

	public function get_invoice_sheet_code()
	{
		$code = $this->Invoicemodel->Get_Last_Invoice_Code();
		$prefix = "INV" . date('y') . date('m');
		if (strlen($code) == 1) {
			$precode = $prefix . "0000" . $code;
		} else if (strlen($code) == 2) {
			$precode = $prefix . "000" . $code;
		} else if (strlen($code) == 3) {
			$precode = $prefix . "00" . $code;
		} else if (strlen($code) == 4) {
			$precode = $prefix . "0" . $code;
		} else if (strlen($code) == 5) {
			$precode = $prefix . $code;
		}
		return $precode;
	}

	public function edit_invoice_view($id)
	{
		$data['invoice_data'] = $this->Commonmodel->Get_record_by_condition('acc_invoice', 'invoice_id', $id);
		$this->load->view('module_invoice/editinvoiceView', $data);
	}


	public function edit_invoice()
	{
		$osa_amount 	= $this->input->post('osa_amount');
		$other_amount 	= $this->input->post('other_amount');
		$bulk_flyer 	= $this->input->post('bulk_flyer');
		$remark 		= $this->input->post('remark');
		$permission 	= $this->input->post('permission');
		$invoice_id 	= $this->input->post('invoice_id');
		if ($osa_amount != "" && $other_amount != "" && $bulk_flyer != "" && $permission != "" && $invoice_id != ""  && $invoice_id != "0") {
			$data = array(
				'bulk_flyer_amount' =>	$bulk_flyer,
				'osa_amount' 		=>	$osa_amount,
				'other_amount' 		=>	$other_amount,
				'invoice_remark'	=>	$remark
			);
			$this->Commonmodel->Update_record('acc_invoice', 'invoice_id', $invoice_id, $data);
			redirect('Invoice');
		} else {
			echo ("<p class='alert alert-dnager'>Something is missing please try again.</p>");
		}
	}


	public function set_barcode($code)
	{
		$targetDir = FCPATH . "assets/barcode/invoice/";
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
		$code = $code;
		$store_image = imagepng($file, $targetDir . "/{$code}.png");
	}

	public function release_from_invoice()
	{
		$cn = $this->input->post('cn');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_date_f = $this->input->post('invoice_date_f');

		if ($cn != "" && $invoice_date != "") {
			$invoice_code = $this->Invoicemodel->Get_Temp_Invoice_Code_By_Cn($cn);
			$data = array('is_temp_invoice' => '');
			$this->Commonmodel->Update_record('acc_orders', 'order_code', $cn, $data);
		}
		$customer_data = $this->Invoicemodel->Get_Cn_By_Invoice_Code_Date($invoice_code, $invoice_date, $invoice_date_f);
		if (!empty($customer_data)) {
			$i = 0;
			foreach ($customer_data as $rows) {
				$i = $i + 1;
				echo ("<tr>");
				echo ("<td>" . $i . "</td>");
				echo ("<td>" . $rows->order_date . "</td>");
				echo ("<td>" . $rows->order_code . " | " . $rows->manual_cn . "</td>");
				echo ("<td>" . $rows->origin_city_name . "</td>");
				echo ("<td>" . $rows->destination_city_name . "</td>");
				echo ("<td>" . $rows->consignee_name . "</td>");
				echo ("<td>" . $rows->pieces . "</td>");
				echo ("<td>" . ceil($rows->weight) . "</td>");
				echo ("<td>" . number_format($rows->order_sc,2) . "</td>");
				echo ("<td>" . number_format($rows->order_gst,2) . "</td>");
				echo ("<td>" . number_format($rows->order_osa,2) . "|" . number_format($rows->order_osa_sd_total,2) . "</td>");
				echo ("<td>" . number_format($rows->order_fuel,2) . "</td>");
				echo ("<td>" . number_format($rows->order_others,2) . "</td>");
				echo ("<td><button onclick='remove_from_invoice(" . $rows->order_code . ")' class='btn btn-danger btn-sm'>Release</button></td>");
				echo ("</tr>");
			}
		}
	}

	public function apply_rts_charges()
	{
		$invoice_code = $this->input->post('invoice_code');
		if ($invoice_code != "") {
			$customer_data = $this->Invoicemodel->Get_RTS_Charges_By_Temp_Invocie_Code($invoice_code);
			if (!empty($customer_data)) {
				$rts_sc = $customer_data[0]['rts_sc'];
				$shipments = $customer_data[0]['shipments'];
				if ($shipments > 0) {
					$msg = "Return Charges Applied on " . $shipments . " = " . $rts_sc;
					$rts_set = array(
						'rts_sc' => $rts_sc,
						'msg'    => $msg
					);
				} else {
					$rts_set = array(
						'rts_sc' => 02,
						'msg'    => "2"
					);
				}
			}
		}
		echo json_encode($rts_set);
	}


	public function complete_invoice()
	{

		$remaining_order_code_array=$_POST['order_acc'];
		$summary_data=$_POST['summary'];
		$form_data_array=$_POST['form_data_array'];

		$array_form=[];
		foreach ($form_data_array as $value) {
			$array_form[]=explode("=",$value);
		}

		$customer 	 	    = $array_form[2][1]; // dropdown value
		$permission 	    = $array_form[3][1]; //might be hidden value
		$invoice_code 	    = $this->get_invoice_sheet_code();
		$other 	            = $array_form[4][1]; // dropdown
		$other_amount 	    = $array_form[5][1]; //input
		$discount_amount    = $array_form[6][1]; //input
		$fuel_amount 	    =  $summary_data[7][1]; //summary
		$remark 		    = $array_form[7][1]; //input
		$date 			    = date('Y-m-d H:i:s');
		$total_gst		    = $summary_data[4][1];
		$total_cn		    = $summary_data[0][1];
		$total_sc 		    = $summary_data[3][1];
		$total_osa_sd       = $summary_data[6][1];
		$total_fuel 	    = $summary_data[7][1];
		$total_amount 	    = $summary_data[10][1];
		$invoice_id 	    = 0;
		$osa_sd             = $summary_data[6][1];
		$total_others	    = $summary_data[9][1];
		$total_osa		    = $summary_data[5][1];
		$total_fuel		    =  $summary_data[7][1];
		$total_faf		    = $summary_data[8][1];
	
		if ($invoice_code != "" && $customer != "" && $permission != "") {
			$data = array(
				'customer_id'                => $customer,
				'invoice_code'               => $invoice_code,
				'payment_date'               => "0000-00-00 00:00:00",
				'invoice_cn'                 => $total_cn,
				'invoice_permission'         => $permission,
				'invoice_gst'                => $total_gst,
				'other_name'                 => $other,
				'invoice_sc'                 => $total_sc,
				'invoice_osa_sd_total'       => $total_osa_sd ,
				'other_amount'               => $other_amount,
				'fuel_surcharge'             => $fuel_amount,
				'discount_amount'            => $discount_amount,
				'invoice_osa'                => $total_osa,
				'invoice_fuel'               => $total_fuel,
				'invoice_others'             => $other_amount,
				'invoice_faf'                => $total_faf,
				'invoice_ajustment_amount'   => 0,
				'is_inovice_ajustment'       => 0,
				'ajustment_narration'        => "",
				'invoice_complete'           => 0,
				'invoice_date'               => $date,
				'invoice_remark'             => $remark,
				'payment_mode'               => "",
				'payment_tid'                => "",
				'is_payment'                 => 0,
				'payment_created_by'         => 0,
				'created_by'                 => $_SESSION['user_id'],
				'created_date'               => $date,
				'modify_by'                  => 0,
				'modify_date'                => '0000-00-00 00:00:00'
			);

			$invoice_id = $this->Commonmodel->Insert_record('acc_invoice', $data);
		
		}
	

		if (!empty($remaining_order_code_array)) {
			$i = 0;
			foreach ($remaining_order_code_array as $rows) {
				 $order_code_mcn=explode("|",$rows['order_code']);
				 $order_code=$order_code_mcn[0];
				 $manual_cn=$order_code_mcn[1];
				 $origin=$rows['Origin'];
				 $destination=$rows['Destination'];
				 $order_date=$rows['order_date'];
				 $order_rate=$rows['order_rate'];
				 $service_name=$rows['service_name'];
				 $Consignee=$rows['Consignee'];
				 $Pieces=$rows['Pieces'];
				 $Weight=$rows['Weight'];
				 $order_sc=$rows['order_sc'];
				 $order_gst=$rows['order_gst'];
				 $order_osa=$rows['order_osa'];
				 $order_fuel=$rows['order_fuel'];
				 $order_faf=$rows['order_faf'];
				 $order_others=$rows['order_others'];

				if ($manual_cn != "" && $manual_cn != null) {
					$mm_cn = $manual_cn;
				} else {
					$mm_cn = $order_code;
				}
			
				$data = array(
					'invoice_id'        => $invoice_id,
					'cn'                => $order_code,
					'manual_cn'         => $mm_cn,
					'origin'            => $origin,
					'destination_name'  => $destination,
					'consignee_detail'  => $Consignee,
					'pcs'               => $Pieces,
					'weight'            => $Weight,
					'rate'              => $order_rate,
					'sc'                => $order_sc,
					'osa_sd'            => $osa_sd,
					'osa'				=> $order_osa,
					'fuel'				=> $order_fuel,
					'others'			=> $order_others,
					'gst'               => $order_gst,
					'date' 				=> $order_date,
					'faf' 				=> $order_faf,
					'serivce_name' 		=> $service_name,
					'current_table' 	=> 'acc_orders',
					'created_by' 		=> $_SESSION['user_id'],
					'created_date' 		=> $date
				);
				$invoice_detail_id = $this->Commonmodel->Insert_record('acc_invoice_detail', $data);
				echo $this->db->last_query();
			}
		}
		echo ("<p class='alert alert-success'>Successfully Done</p>");
	}



	public function add_deduction()
	{
		echo $code 	 	= $this->input->post('code');
		echo $name 		= $this->input->post('name');
		echo $amount 	= $this->input->post('amount');
		if ($code != "" && $name != "" && $amount != "") {
			$check = $this->Invoicemodel->Duplicate_Check($code, $name, $amount);
			if ($check == 0) {
				$data = array(
					'invoice_id' 		=> $code,
					'extra_amount'		=> $amount,
					'extra_name' 		=> $name,
					'extra_date' 		=> date('Y-m-d'),
					'created_by' 		=> $_SESSION['user_id'],
					'created_date' 		=> date('Y-m-d H:i:s')
				);
				$invoice_id = $this->Commonmodel->Insert_record('acc_invoice_extra', $data);
			} else {
				$msg = "<p class='alert alert-danger'><strong>Duplication Error!</strong> Activated Duplicate Sheild.</p>";
			}
		} else {
			$msg = "<p class='alert alert-danger'><strong>Missing Error !</strong> Something is missing please try again.</p>";
		}
	}




	public function print_invoice($sheet_code)
	{
		$sheet_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
		$sheet_archive_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
		if (!empty($sheet_archive_data)) {
			$data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
		} else {
			$data['sheet_data'] = $sheet_data;
		}
		$this->load->view('module_invoice/printinvoiceView', $data);
	}

	public function view_invoice_sheet($sheet_code)
	{
		$sheet_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
		$sheet_archive_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
		if (!empty($sheet_archive_data)) {
			$data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
		} else {
			$data['sheet_data'] = $sheet_data;
		}
		$this->load->view('module_invoice/invoicepreviewView', $data);
	}

	public function view_invoice_sheet_v2($sheet_code)
	{
		$sheet_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
		$sheet_archive_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
		if (!empty($sheet_archive_data)) {
			$data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
		} else {
			$data['sheet_data'] = $sheet_data;
		}
		$this->load->view('module_invoice/invoiceView2', $data);
	}

	public function view_invoice_sheet_v3($sheet_code)
	{
		$sheet_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
		$sheet_archive_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
		if (!empty($sheet_archive_data)) {
			$data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
		} else {
			$data['sheet_data'] = $sheet_data;
		}
		$this->load->view('module_invoice/invoiceView4', $data);
	}

	public function view2_invoice_sheet($sheet_code)
	{
		$sheet_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
		$sheet_archive_data = $this->Invoicemodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
		if (!empty($sheet_archive_data)) {
			$data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
		} else {
			$data['sheet_data'] = $sheet_data;
		}
		$this->load->view('module_invoice/paiddetailView', $data);
	}


	public function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	public function invoice_payment_view($id)
	{
		$data['sheet_data'] = $this->Invoicemodel->Get_Invoice_Data_By_Is_Payment();
		$data['id'] = $id;
		$this->load->view('module_invoice/paymentView', $data);
	}

	public function submit_payment()
	{
		$invoice_id    = $this->input->post('invoice_id');
		$payment_mode  = $this->input->post('payment_mode');
		$tid 	 	   = $this->input->post('tid');
		$payment_date  = $this->input->post('payment_date');
		if ($invoice_id != 0 && $payment_mode != "" && $tid != "") {
			$data = array(
				'is_payment'           => 1,
				'payment_mode'         => $payment_mode,
				'payment_tid'          => "|" . $payment_mode . "|" . $tid,
				'payment_date'         => date('Y-m-d H:i:s'),
				'payment_created_by'   => $_SESSION['user_id'],
			);
			$this->Commonmodel->Update_record('acc_invoice', 'invoice_id', $invoice_id, $data);
			$invoice_data = $this->Commonmodel->Get_record_by_condition_array('acc_invoice', 'invoice_id', $invoice_id);
			if (!empty($invoice_data)) {
				$invoice_code = $invoice_data[0]['invoice_code'];
				$data = array(
					'is_payment'        => 1,
					'payment_mode'      => $payment_mode,
					'payment_trans_id'  => "|" . $payment_mode . "|" . $tid
				);
				$this->Commonmodel->Update_record('acc_orders', 'invoice_id', $invoice_code, $data);
				$data = array(
					'is_payment'         => 1,
					'payment_mode'       => $payment_mode,
					'payment_trans_id'   => "|" . $payment_mode . "|" . $tid
				);
				$this->Commonmodel->Update_record('acc_archive_orders', 'invoice_id', $invoice_code, $data);
			}
			redirect('Invoice');
		} else {
			echo ("<p class='alert alert-danger'>Something is missing. :(</p>");
		}
	}


	public function cal_index($customer_id)
	{
		$sz_return_formula  = "";
		$dz_return_formula  = "";
		$sc_return_formula  = "";
		$sc_return_rate     = 0;
		$sz_return_rate     = 0;
		$dz_return_rate     = 0;
		$order_pre          = 0;
		//1=============Get Return Rate From Saimtech_rate By Customer ID
		$returndetail = $this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
		if (!empty($returndetail)) {
			$sz_return_formula  = $returndetail[0]['sz_return_formula'];
			$dz_return_formula  = $returndetail[0]['dz_return_formula'];
			$sc_return_formula  = $returndetail[0]['sc_return_formula'];
			$sc_return_rate     = $returndetail[0]['sc_return_rate'];
			$sz_return_rate     = $returndetail[0]['sz_return_rate'];
			$dz_return_rate     = $returndetail[0]['dz_return_rate'];
			//End===========Get Return Rate From Saimtech_rate By Customer ID
			$orders = $this->Commonmodel->Get_Sc_By_Customer_RTS($customer_id);
			if (!empty($orders)) {
				foreach ($orders as $rows) {
					$order_type     = $rows->order_rate_type;
					$order_id       = $rows->order_id;
					$order_sc       = $rows->order_sc;
					$order_pre_total = $rows->order_total_amount;
					//-----SameZone---------------------
					if ($order_type == 'SZ') {
						if ($sz_return_formula == 'PER') {
							$order_pre = 0;
							$order_pre = (($order_sc * $sz_return_rate) / 100);
							$data = array('order_return_sc'  => $order_pre);
						} else if ($sz_return_formula == 'FIX') {
							$order_pre = $sz_return_rate;
							$data = array('order_return_sc'  => $order_pre);
							//End--SameZone---------------------
							//-----SameCity---------------------
						} else if ($order_type == 'WC') {
							if ($sc_return_formula == 'PER') {
								$order_pre = 0;
								$order_pre = (($order_sc * $sc_return_rate) / 100);
								$data = array('order_return_sc'  => $order_pre);
							} else if ($sc_return_formula == 'FIX') {
								$order_pre = $sc_return_rate;
								$data = array('order_return_sc'  => $order_pre);
							}
							//End--SameCity---------------------
							//-----Different Zone---------------------
						} else if ($order_type == 'DZ') {
							if ($dz_return_formula == 'PER') {
								$order_pre = 0;
								$order_pre = (($order_sc * $dz_return_rate) / 100);
								$data = array('order_return_sc'  => $order_pre);
							} else if ($dz_return_formula == 'FIX') {
								$order_pre = $dz_return_rate;
								$data = array('order_return_sc'  => $order_pre);
							}
						}
						$this->Commonmodel->Update_Triple_record('acc_orders', 'customer_id', $customer_id, 'order_status', 'RTS', 'is_invoice', '0', $data);

						//End--Different Zone---------------------

					}
				}
				//2=============Get Order Sc From acc_orders By Customer ID AND RTS
				//Loop
				//2.1=============Update Order Return Sc INTO acc_orders By ORDER ID
				//END=============Update Order Return Sc INTO acc_orders By ORDER ID
				//ENDLoop
			}
			//End===========Get Order Sc From acc_orders By Customer ID AND RTS
		}
	}

	public function privot_table()
	{
	}
	public function get_cutomer_gst()
	{
		$customer_id = $this->input->post("customer");
		$gstcustomer = $this->Invoicemodel->Get_Invoice_Active_Customer_gst($customer_id);


		$gstcustomer = $gstcustomer[0];
		$data['result'] = $gstcustomer;
		echo json_encode($data);
	}

	public function zero_cn()
	{
		$data['sub_nav_active'] = "Find";
		$data['nav_active'] = "Invoice";
		$data['event_name'] = "Zero Rated CN";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data = array(
				'order_booking_date1'	=>	$this->input->post('booking_range_1'),
				'order_booking_date2'	=>	$this->input->post('booking_range_2'),
				'customer_id'			=>	$this->input->post('customer'),
				'manual_cn'				=>	$this->input->post('mcn'),
				'origin_city'			=>	$this->input->post('origin'),
				'destination_city'		=>	$this->input->post('destination'),
				'shipper_name'			=>	$this->input->post('shipper'),
				'consignee_name'		=>	$this->input->post('consignee'),
				'pieces'				=>	$this->input->post('pieces'),
				'weight'				=>	$this->input->post('weight'),
				'content'				=>	$this->input->post('content'),
				'payment_mode'			=>	$this->input->post('paymode'),
				'order_service_type'	=>	$this->input->post('services')
			);

			$data['action'] = "POST";
			$data['selected_cns'] = $this->Invoicemodel->Select_Zero_Rated_CN(
				$data['order_booking_date1'],
				$data['order_booking_date2'],
				$data['customer_id'],
				$data['manual_cn'],
				$data['origin_city'],
				$data['destination_city'],
				$data['shipper_name'],
				$data['consignee_name'],
				$data['pieces'],
				$data['weight'],
				$data['content'],
				$data['payment_mode'],
				$data['order_service_type']
			);
		}
		isset($_SESSION['customer_id']) ? $cid = $_SESSION['customer_id'] : $cid = null;
		$data['shipment_types'] = $this->Commonmodel->Get_record_by_condition('acc_services', 'is_enable', 1);
		$data['customer_data'] = $this->Commonmodel->Get_record_by_condition('acc_customers', 'is_enable', 1);
		$data['action'] = "GET";

		if ((isset($_SESSION['is_tm']) ? $_SESSION['is_tm'] : 0) == 0) {
			$data['cities_data'] = $this->Bookingmodel->Get_Active_Cities();
		} else {
			$data['cities_data'] = $this->Bookingmodel->Get_All_Cities();
		}
		$this->load->view('module_invoice/zerorateView', $data);
	}
}
