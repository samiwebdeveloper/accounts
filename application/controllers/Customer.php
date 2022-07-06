<?php

class Customer extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Karachi');
		$this->load->model('Commonmodel');
		$this->load->model('Customermodel');
	}

	public $zone_type = array(
		'I' => 'Islamabad',
		'K' => 'Karachi',
		'L' => 'Lahore',
		'M' => 'Main',
		'T' => 'Tranist'
	);

	public $zone = array(
		'IA' => 'ISB A',
		'IB' => 'ISB B',
		'IC' => 'ISB C',
		'ID' => 'ISB D',
		'IE' => 'ISB E',
		'KA' => 'KHI A',
		'KB' => 'KHI B',
		'KC' => 'KHI C',
		'KD' => 'KHI D',
		'KE' => 'KHI E',
		'LA' => 'LHE A',
		'LB' => 'LHE B',
		'LC' => 'LHE C',
		'LD' => 'LHE D',
		'LE' => 'LHE E',
		'WC' => 'With-In City',
		'ex_ajk' => 'Ex AJK',
		'ex_bal' => 'Ex Balochistan',
		'ex_gb' => 'Ex GB',
		'ex_kpk' => 'Ex KPK',
		'ex_punjab' => 'Ex Punjab',
		'ex_sindh' => 'Ex Sindh'
	);

	public $rate_type = array(
		'DW' => 'Destination Wise',
		'FR' => 'Flate Rate',
		'PW' => 'Province Wise',
		'SW' => 'Service Wise',
		'TW' => 'Tranist Wise',
		'ZW' => 'Zone Wise'
	);

	public $zone_type_region = array(
		'I' => 'Region: Islamabad',
		'K' => 'Region: Karachi',
		'L' => 'Region: Lahore'
	);

	public $zone_type_tranist = array(
		'M' => 'Tranist: Main',
		'T' => 'Tranist: Tranist'
	);

	public $zones = array(
		'IA' => 'Zone: ISB A',
		'IB' => 'Zone: ISB B',
		'IC' => 'Zone: ISB C',
		'ID' => 'Zone: ISB D',
		'IE' => 'Zone: ISB E',
		'KA' => 'Zone: KHI A',
		'KB' => 'Zone: KHI B',
		'KC' => 'Zone: KHI C',
		'KD' => 'Zone: KHI D',
		'KE' => 'Zone: KHI E',
		'LA' => 'Zone: LHE A',
		'LB' => 'Zone: LHE B',
		'LC' => 'Zone: LHE C',
		'LD' => 'Zone: LHE D',
		'LE' => 'Zone: LHE E',
		'WC' => 'With-In City'
	);

	public $zone_ex = array(
		'ex_ajk' => 'Province / Tranist: Ex AJK',
		'ex_bal' => 'Province / Tranist: Ex Balochistan',
		'ex_gb' => 'Province / Tranist: Ex GB',
		'ex_kpk' => 'Province / Tranist: Ex KPK',
		'ex_punjab' => 'Province / Tranist: Ex Punjab',
		'ex_sindh' => 'Province / Tranist: Ex Sindh'
	);

	public function index()
	{
		//echo($_SESSION['origin_id']);	
		$data['sub_nav_active'] = "Customer";
		$data['nav_active'] = "Add Customer";
		$data['event_name'] = "Add Customer";
		if ($_SESSION['user_power'] == 'BM') {
			$data['customer_data'] = $this->Customermodel->Get_Customers_Data_By_Created_ID($_SESSION['user_id']);
		} else if ($_SESSION['user_power'] == 'SE' || $_SESSION['user_power'] == 'Accounts') {
			$data['customer_data'] = $this->Customermodel->Get_All_Customers_By_Mixture($_SESSION['user_mixture']);
		} else if ($_SESSION['user_power'] == 'SM') {
			$data['customer_data'] = $this->Customermodel->Get_Customers_Data_By_Created_ID($_SESSION['user_id']);
		}
		$this->load->view('module_customer/customerView', $data);
	}

	public function update_status($status, $id)
	{
	}

	public function add_customer_view($error)
	{
		$data['event_name'] = "Add Customer";
		$data['cities_data'] = $this->Commonmodel->Get_record_by_condition('acc_city', 'is_enable', 1);
		$data['freelancer_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'FL', 'is_enable', 1);
		$data['reference_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'Emp', 'is_enable', 1);
		$data['error'] = $error;
		$this->load->view('module_customer/addcustomerView', $data);
	}

	public function show_customer_view($customer_id)
	{
		//$get_rate_id=$this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
		//$rate_id=$get_rate_id[0]['rate_id'];
		$data['cities_data'] = $this->Commonmodel->Get_record_by_condition('acc_city', 'is_enable', 1);
		$data['customer_faf'] = $this->Commonmodel->Get_record_by_condition('acc_customer_faf', 'customer_id', $customer_id);
		$data['customer_data'] = $this->Commonmodel->Get_record_by_condition_array('acc_customers', 'customer_id', $customer_id);
		$data['freelancer_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'FL', 'is_enable', 1);
		$data['reference_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'Emp', 'is_enable', 1);
		$this->load->view('module_customer/showcustomerView', $data);
	}

	public function show_rate_view($customer_id)
	{
		$get_rate_id = $this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
		$rate_id = $get_rate_id[0]['rate_id'];
		$data['cities_data'] = $this->Commonmodel->Get_record_by_condition('acc_city', 'is_enable', 1);
		$data['customer_data'] = $this->Commonmodel->Get_record_by_condition_array('acc_customers', 'customer_id', $customer_id);
		//$data['freelancer_data']=$this->Commonmodel->Get_record_by_double_condition('saimtech_reference', 'reference_type', 'FL', 'is_enable', 1);
		//$data['reference_data']=$this->Commonmodel->Get_record_by_double_condition('saimtech_reference', 'reference_type', 'Emp', 'is_enable', 1);
		$data['rate_data'] = $this->Commonmodel->Get_record_by_condition_array('saimtech_rate', 'rate_id', $rate_id);
		$data['dest_data'] = $this->Customermodel->Get_Destination_Rate($customer_id);
		$this->load->view('module_customer/rateshowView', $data);
	}

	public function add_customer()
	{
		$message                 = "";
		$gst                     = $this->input->post('gst');
		$is_gst					 = $gst > 0 ? 1 : 0;
		$fuel_surc				 = $this->input->post('fuel');
		$is_fuel				 = $fuel_surc > 0 ? 1 : 0;
		$others_chrg			 = $this->input->post('others');
		$is_others				 = $others_chrg > 0 ? 1 : 0;
		$faf			 		 = $this->input->post('faf');
		$is_faf				 	 = $faf > 0 ? 1 : 0;
		$fsd				 	 = $this->input->post('faf_start_date');
		$fed				 	 = $this->input->post('faf_end_date');
		$service_type 	 	     = $this->input->post('services_type');
		$b_unit					 = $this->input->post('bunits');
		$customer_id 	 	     = $this->input->post('customer_id');
		$brand_name 	 	     = $this->input->post('brand_name');
		$brand_url   	 	     = $this->input->post('brand_url');
		$brand_cnic 	 	     = $this->input->post('brand_cnic');
		$account_type 	         = $this->input->post('operating_type');
		$gst_type 	             = $this->input->post('gst_type');
		$brand_product 	         = $this->input->post('brand_product');
		$calculation_type 	     = $this->input->post('calculation_type');
		$pickup_points 	         = $this->input->post('pickup_points');
		$brand_ntn 	             = $this->input->post('brand_ntn');
		$brand_email 	         = $this->input->post('brand_email');
		$brand_phone 	         = $this->input->post('brand_phone');
		$brand_note 	         = $this->input->post('brand_note');
		$bank_name 	 	         = $this->input->post('bank_name');
		$bank_address 	 	     = $this->input->post('brand_address');
		$pay_mode_id 	         = $this->input->post('pay_mode');
		$brand_city 	 	     = $this->input->post('brand_city');
		$account_title 	 	     = $this->input->post('account_title');
		$account_no 	 	     = $this->input->post('account_no');
		$account_iban 	 	     = $this->input->post('account_iban');
		$display_name            = $this->input->post('display_name');
		$reference_by            = $this->input->post('reference_by');
		$secondary_reference_by  = $this->input->post('secondary_reference_by');
		$user_name               = $this->input->post('user_name');
		$user_password           = $this->input->post('user_password');
		$date 			         = date('Y-m-d H:i:s');
		$api_key                 = uniqid();

		if ($pay_mode_id == "1") {
			$paymode = "Account";
		} else if ($pay_mode_id == "2") {
			$paymode = "FOD";
		} else if ($pay_mode_id == "3") {
			$paymode = "Account & FOD";
		} else if ($pay_mode_id == "4") {
			$paymode = "Cash";
		} else if ($pay_mode_id == "5") {
			$paymode = "FOC";
		}

		if ($service_type == '1') {
			$service_name = "1";
		} else if ($service_type == '2') {
			$service_name = "2";
		} else if ($service_type == '3') {
			$service_name = "3";
		} else if ($service_type == '4') {
			$service_name = "4";
		} else if (($service_type == '1,2') || ($service_type == '2,1')) {
			$service_name = "5";
		} else if (($service_type == '1,3') || ($service_type == '3,1')) {
			$service_name = "6";
		} else if (($service_type == '1,4') || ($service_type == '4,1')) {
			$service_name = "7";
		} else if (($service_type == '2,3') || ($service_type == '3,2')) {
			$service_name = "8";
		} else if (($service_type == '2,4') || ($service_type == '4,2')) {
			$service_name = "9";
		} else if (($service_type == '4,3') || ($service_type == '3,4')) {
			$service_name = "10";
		} else if (($service_type == '1,3,4') || ($service_type == '1,4,3') || ($service_type == '4,3,1') || ($service_type == '4,1,3') || ($service_type == '3,1,4') || ($service_type == '3,4,1')) {
			$service_name = "11";
		} else if (($service_type == '1,2,3') || ($service_type == '1,3,2') || ($service_type == '3,2,1') || ($service_type == '3,1,2') || ($service_type == '2,1,3') || ($service_type == '2,3,1')) {
			$service_name = "13";
		} else if (($service_type == '1,2,4') || ($service_type == '1,4,2') || ($service_type == '4,2,1') || ($service_type == '4,1,2') || ($service_type == '2,1,4') || ($service_type == '2,4,1')) {
			$service_name = "14";
		} else if (($service_type == "") || ($service_type ==  null)) {
			$service_name = '';
		} else {
			$service_name = "12";
		}

		$api_key = uniqid();
		//$faf_date = $is_faf == 1 ? $faf_date : '0000-00-00';

		if (
			$brand_name != "" && $brand_city != "" && $service_type != "" && $paymode != "" && $account_type != "" && $service_name != ""
			&& $brand_product != "" && $calculation_type != "" && $brand_note != "" && $bank_address != "" && $pickup_points != ""
			&& $brand_city != "" && $b_unit != "" && $display_name != "" && $user_name != "" && $user_password != "" && $reference_by != ""
		) {
			//--- Update INTO Customer
			$brand = array(
				'type'							=> 'Customer',
				'customer_name'                 => $brand_name,
				'customer_contact'              => $brand_phone,
				'customer_contact2'             => $brand_email,
				'customer_address'              => $bank_address,
				'customer_city'                 => $brand_city,
				'customer_cnic'                 => $brand_cnic,
				'customer_ntn'                  => $brand_ntn,
				'customer_bank'                 => $bank_name,
				'customer_bank_account_title'   => $account_title,
				'customer_bank_account_no'      => $account_no,
				'customer_iban'                 => $account_iban,
				'customer_url'                  => $brand_url,
				'customer_note'                 => $brand_note,
				'handling_limit'                => '500000',
				'customer_product_type'         => $brand_product,
				'cal_type'                      => $calculation_type,
				'customer_contact_person'       => $pickup_points,
				'customer_account_type'         => $account_type,
				'is_gst'                        => $is_gst,
				'gst'                           => $gst,
				'is_fuel_surcharge'				=> $is_fuel,
				'fuel_surcharge'				=> $fuel_surc,
				'is_others_charges'				=> $is_others,
				'others_charges'				=> $others_chrg,
				'reference_by'                  => $reference_by,
				'secondary_reference_by'        => $secondary_reference_by,
				'pay_mode'                      => $paymode,
				'services'                  	=> $service_type,
				'pay_mode_id'                   => $pay_mode_id,
				'billable_unit'					=> $b_unit,
				'is_enable'						=> 1,
				'serivce_name'					=> $service_name,
				'api_key'						=> $api_key,
				'created_by'                    => $_SESSION['user_id'],
				'created_date'                  =>  date('Y-m-d H:i:s')
			);
			$this->db->trans_start();
			$customer_id = $this->Commonmodel->Insert_record('cargo.saimtech_customer', $brand);

			$ccity_data = $this->Commonmodel->Get_record_by_condition_array('acc_city', 'city_id', $brand_city);
			$city_code = $ccity_data[0]['city_code'] . $customer_id;
			$slip_name = $brand_name . " (" . $customer_id . ")";
			$brand_info = array(
				'customer_account_no'  	=> $city_code,
				'customer_name_slip'	=> $slip_name
			);
			$this->Commonmodel->Update_record('cargo.saimtech_customer', 'customer_id', $customer_id, $brand_info);

			if ($is_faf == 1) {
				$faf_data = array(
					'customer_id' => $customer_id,
					'faf' => ($faf / 100),
					'start_date' => $fsd,
					'end_date' => $fed,
					'is_enable' => 1,
					'created_by' => $_SESSION['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$chk = $this->Commonmodel->Insert_record('acc_customer_faf', $faf_data);
			}

			if (strlen($user_name) > 0) {
				$brand_user = array(
					'user_name'         => $display_name,
					'account_no'        => $user_name,
					'user_password'     => md5($user_password),
					'user_power'        => 'AGENT',
					'user_city'         => $brand_city,
					'is_enable'         => 1,
					'customer_id'       => $customer_id,
					'created_date'      => $date,
					'created_by'        => $_SESSION['user_id']
				);
				$user_id = $this->Commonmodel->Insert_record('cargo.saimtech_user', $brand_user);
			}

			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 1,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 500,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 500,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 50,
				'sc_gst_rate'           => 0,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 500,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 500,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 50,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 500,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 500,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 50,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 50,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 500,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 50,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('cargo.saimtech_rate', $data);

			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 2,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 200,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 200,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 20,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 250,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 250,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 25,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 350,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 350,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 35,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 500,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 500,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 50,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('cargo.saimtech_rate', $data);

			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 3,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 450,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 450,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 45,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 450,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 450,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 45,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 450,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 450,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 45,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 450,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 450,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 45,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('cargo.saimtech_rate', $data);

			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 4,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 500,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 500,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 50,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 500,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 500,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 50,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 500,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 500,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 50,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 1,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 0,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 0,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 0,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('cargo.saimtech_rate', $data);
			$this->db->trans_complete();

			$message = "<p class='alert alert-success'>Successfully Done</p>";
			redirect(base_url() . 'Customer');
		} else {
			echo "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
		}
	}

	/*public function add_customer()
	{
		$brand_city 	 	     = $this->input->post('brand_city');
		$message                 = "";
		$gst                     = 16;
		if ($brand_city == 2) {
			$gst  = 13;
		}
		$brand_name 	 	     = $this->input->post('brand_name');
		$brand_name 	 	     = $this->input->post('brand_name');
		$service_type 	 	     = $this->input->post('serivce_type');
		$brand_url   	 	     = $this->input->post('brand_url');
		$brand_cnic 	 	     = $this->input->post('brand_cnic');
		$account_type 	         = $this->input->post('operating_type');
		$gst_type 	             = $this->input->post('gst_type');
		$brand_product 	         = $this->input->post('brand_product');
		$calculation_type 	     = $this->input->post('calculation_type');
		$pay_mode 	             = $this->input->post('pay_mode');
		$pickup_points 	         = $this->input->post('pickup_points');
		$brand_ntn 	             = $this->input->post('brand_ntn');
		$brand_email 	         = $this->input->post('brand_email');
		$brand_phone 	         = $this->input->post('brand_phone');
		$brand_note 	         = $this->input->post('brand_note');
		$bank_name 	 	         = $this->input->post('bank_name');
		$bank_address 	 	     = $this->input->post('brand_address');
		$account_title 	 	     = $this->input->post('account_title');
		$account_no 	 	     = $this->input->post('account_no');
		$account_iban 	 	     = $this->input->post('account_iban');
		$display_name            = $this->input->post('display_name');
		$reference_by            = $this->input->post('reference_by');
		$secondary_reference_by  = $this->input->post('secondary_reference_by');
		$user_name               = $this->input->post('user_name');
		$user_password           = $this->input->post('user_password');
		$date 			         = date('Y-m-d H:i:s');
		$pay_mode_id             = $this->input->post('pay_mode');
		$serivce_name			 = $this->input->post('service_name');
		if ($pay_mode_id == "1") {
			$paymode = "Account";
		} else if ($pay_mode_id == "2") {
			$paymode = "FOD";
		} else if ($pay_mode_id == "3") {
			$paymode = "Account & FOD";
		} else if ($pay_mode_id == "4") {
			$paymode = "Cash";
		} else if ($pay_mode_id == "5") {
			$paymode = "FOC";
		}
		$api_key                 = uniqid();
		if ($brand_name != "" && $brand_city != "" && $user_name != "" && $brand_cnic != "" && $pay_mode_id != "" && $service_type != "") {
			$this->db->trans_start();
			//--- INSERT INTO Invoice Customer
			$data = array(
				'customer_name'                 => $brand_name,
				'type'                          => 'Customer',
				'customer_contact'              => $brand_phone,
				'customer_contact2'             => $brand_email,
				'customer_address'              => $bank_address,
				'customer_city'                 => $brand_city,
				'customer_cnic'                 => $brand_cnic,
				'customer_ntn'                  => $brand_ntn,
				'customer_bank'                 => $bank_name,
				'customer_bank_account_title'   => $account_title,
				'customer_bank_account_no'      => $account_no,
				'customer_iban'                 => $account_iban,
				'customer_url'                  => $brand_url,
				'customer_note'                 => $brand_note,
				'handling_limit'                => '500000',
				'customer_account_type'         => $account_type,
				'is_gst'                        => $gst_type,
				'customer_product_type'         => $brand_product,
				'cal_type'                      => $calculation_type,
				'customer_contact_person'       => $pickup_points,
				'serivce_name'                  => $service_type,
				'gst'                           => $gst,
				'is_enable'                     => 1,
				'api_key'                       => $api_key,
				'reference_by'                  => $reference_by,
				'pay_mode_id'                   => $pay_mode,
				'pay_mode'                      => $paymode,
				'serivce_name'                  => $service_type,
				'secondary_reference_by'        => $secondary_reference_by,
				'created_by'                    => $_SESSION['user_id'],
				'created_date'                  => date('Y-m-d H:i:s'),
				'modify_by'                     => 0,
				'modify_date'                   => '0000-00-00 00:00:00'
			);
			$customer_id = $this->Commonmodel->Insert_record('acc_customers', $data);
			$ccity_data = $this->Commonmodel->Get_record_by_condition_array('acc_city', 'city_id', $brand_city);
			$city_code = $ccity_data[0]['city_code'] . $customer_id;
			$data = array('customer_account_no'  => $city_code);
			$this->Commonmodel->Update_record('acc_customers', 'customer_id', $customer_id, $data);
			$data = array(
				'user_name'         => $display_name,
				'account_no'        => $user_name,
				'user_password'     => md5($user_password),
				'user_power'        => 'AGENT',
				'user_city'         => $brand_city,
				'is_enable'         => 1,
				'customer_id'       => $customer_id,
				'last_login'        => '0000-00-00',
				'last_logout'       => '0000-00-00',
				'created_date'      => $date,
				'created_by'        => $_SESSION['user_id'],
				'modify_date'       => '0000-00-00 00:00:00',
				'modify_by'         => 1
			);
			$user_id = $this->Commonmodel->Insert_record('saimtech_user', $data);

			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 1,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 500,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 500,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 50,
				'sc_gst_rate'           => 0,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 500,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 500,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 50,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 500,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 500,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 50,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 50,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 500,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 50,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 2,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 200,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 200,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 20,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 250,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 250,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 25,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 350,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 350,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 35,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 500,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 500,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 50,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 3,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 450,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 450,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 45,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 450,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 450,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 45,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 450,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 450,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 45,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 0,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 450,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 450,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 45,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			$data = array(
				'customer_id'           => $customer_id,
				'service_id'            => 4,
				'sc_wgt1'               => 1,
				'sc_rate1'              => 500,
				'sc_wgt2'               => 10,
				'sc_rate2'              => 500,
				'sc_add_wgt'            => 1,
				'sc_add_rate'           => 50,
				'sc_gst_rate'           => 16,
				'sc_fuel_formula'       => 'Fix',
				'sc_fuel_rate'          => 0,
				'sc_sp_handling_formula' => 'Fix',
				'sc_sp_handling_rate'   => 0,
				'sc_return_formula'     => 'Fix',
				'sc_return_rate'        => 0,
				'sz_wgt1'               => 1,
				'sz_rate1'              => 500,
				'sz_wgt2'               => 10,
				'sz_rate2'              => 500,
				'sz_add_wgt'            => 1,
				'sz_add_rate'           => 50,
				'sz_gst_rate'           => 16,
				'sz_fuel_formula'       => 'FIX',
				'sz_fuel_rate'          => 0,
				'sz_sp_handling_formula' => 'FIX',
				'sz_sp_handling_rate'   => 0,
				'sz_return_formula'     => 'FIX',
				'sz_return_rate'        => 0,
				'dz_wgt1'               => 1,
				'dz_rate1'              => 500,
				'dz_wgt2'               => 10,
				'dz_rate2'              => 500,
				'dz_add_wgt'            => 1,
				'dz_add_rate'           => 50,
				'dz_fuel_formula'       => 'FIX',
				'dz_fuel_rate'          => 0,
				'dz_sp_handling_formula' => 'FIX',
				'dz_sp_handling_rate'   => 0,
				'dz_gst_rate'           => 1,
				'dz_return_formula'     => 'FIX',
				'dz_return_rate'        => 0,
				'zz_wgt1'               => 1,
				'zz_rate1'              => 0,
				'zz_wgt2'               => 10,
				'zz_rate2'              => 0,
				'zz_add_wgt'            => 1,
				'zz_add_rate'           => 0,
				'zz_fuel_formula'       => 'FIX',
				'zz_fuel_rate'          => 0,
				'zz_sp_handling_formula' => 'FIX',
				'zz_sp_handling_rate'   => 0,
				'zz_gst_rate'           => 0,
				'zz_return_formula'     => 'FIX',
				'zz_return_rate'        => 0,
				'cash_handling_formula' => 'FIX',
				'cash_handling_rate'    => 0,
				'reference_formula'     => 'FIX',
				'reference_rate'        => 0,
				'flyer_rate'            => 0,
				'is_enable'             => 1,
				'deactive_date'         => '0000-00-00 00:00:00',
				'delete_date'           => '0000-00-00 00:00:00',
				'created_by'            => $_SESSION['user_id'],
				'created_date'          => date('Y-m-d H:i:s'),
				'modify_by'             => 0,
				'modify_date'           => '0000-00-00 00:00:00',
			);
			$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			$this->db->trans_complete();
			redirect('Customer/add_customer_view/1');
		} else {
			redirect('Customer/add_customer_view/2');
		}
	}*/

	public function edit_customer_view($customer_id)
	{
		//$get_rate_id=$this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
		//$rate_id=$get_rate_id[0]['rate_id'];
		$data['customer_id'] = $customer_id;
		$data['customer_faf'] = $this->Commonmodel->Get_record_by_condition('acc_customer_faf', 'customer_id', $customer_id);
		$data['cities_data'] = $this->Commonmodel->Get_record_by_condition('acc_city', 'is_enable', 1);
		$data['customer_data'] = $this->Commonmodel->Get_record_by_condition_array('acc_customers', 'customer_id', $customer_id);
		$data['freelancer_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'FL', 'is_enable', 1);
		$data['reference_data'] = $this->Commonmodel->Get_record_by_double_condition('acc_references', 'reference_type', 'Emp', 'is_enable', 1);
		$this->load->view('module_customer/editcustomerView', $data);
	}

	public function edit_customer()
	{
		$message                 = "";
		$gst                     = $this->input->post('gst');
		$is_gst					 = $gst > 0 ? 1 : 0;
		$fuel_surc				 = $this->input->post('fuel');
		$is_fuel				 = $fuel_surc > 0 ? 1 : 0;
		$others_chrg			 = $this->input->post('others');
		$is_others				 = $others_chrg > 0 ? 1 : 0;
		$faf			 		 = $this->input->post('faf');
		$is_faf				 	 = $faf > 0 ? 1 : 0;
		$faf_date				 = $this->input->post('faf_date');
		$service_type 	 	     = $this->input->post('services_type');
		$b_unit					 = $this->input->post('bunits');
		$customer_id 	 	     = $this->input->post('customer_id');
		//$rate_id 	 	         = $this->input->post('rate_id');
		$brand_name 	 	     = $this->input->post('brand_name');
		$brand_url   	 	     = $this->input->post('brand_url');
		$brand_cnic 	 	     = $this->input->post('brand_cnic');
		$account_type 	         = $this->input->post('operating_type');
		$gst_type 	             = $this->input->post('gst_type');
		$brand_product 	         = $this->input->post('brand_product');
		$calculation_type 	     = $this->input->post('calculation_type');
		$pickup_points 	         = $this->input->post('pickup_points');
		$brand_ntn 	             = $this->input->post('brand_ntn');
		$brand_email 	         = $this->input->post('brand_email');
		$brand_phone 	         = $this->input->post('brand_phone');
		$brand_note 	         = $this->input->post('brand_note');
		$bank_name 	 	         = $this->input->post('bank_name');
		$bank_address 	 	     = $this->input->post('brand_address');
		$pay_mode_id 	         = $this->input->post('pay_mode');
		$brand_city 	 	     = $this->input->post('brand_city');
		$account_title 	 	     = $this->input->post('account_title');
		$account_no 	 	     = $this->input->post('account_no');
		$account_iban 	 	     = $this->input->post('account_iban');
		$display_name            = $this->input->post('display_name');
		$reference_by            = $this->input->post('reference_by');
		$secondary_reference_by  = $this->input->post('secondary_reference_by');
		$user_name               = $this->input->post('user_name');
		$user_password           = $this->input->post('user_password');
		$date 			         = date('Y-m-d H:i:s');
		$api_key                 = uniqid();

		if ($pay_mode_id == "1") {
			$paymode = "Account";
		} else if ($pay_mode_id == "2") {
			$paymode = "FOD";
		} else if ($pay_mode_id == "3") {
			$paymode = "Account & FOD";
		} else if ($pay_mode_id == "4") {
			$paymode = "Cash";
		} else if ($pay_mode_id == "5") {
			$paymode = "FOC";
		}

		//$faf_date = $is_faf == 1 ? $faf_date : '0000-00-00';

		if ($customer_id != "" && $brand_name != "" && $brand_city != "" &&  $brand_cnic != "" && $service_type != "") {
			//$this->db->save_queries = TRUE;
			//$this->db->trans_start();
			//--- Update INTO Customer
			$data = array(
				'customer_name'                 => $brand_name,
				'customer_contact'              => $brand_phone,
				'customer_contact2'             => $brand_email,
				'customer_address'              => $bank_address,
				'customer_city'                 => $brand_city,
				'customer_cnic'                 => $brand_cnic,
				'customer_ntn'                  => $brand_ntn,
				'customer_bank'                 => $bank_name,
				'customer_bank_account_title'   => $account_title,
				'customer_bank_account_no'      => $account_no,
				'customer_iban'                 => $account_iban,
				'customer_url'                  => $brand_url,
				'customer_note'                 => $brand_note,
				'handling_limit'                => '500000',
				'customer_product_type'         => $brand_product,
				'cal_type'                      => $calculation_type,
				'customer_contact_person'       => $pickup_points,
				'customer_account_type'         => $account_type,
				'is_gst'                        => $is_gst,
				'gst'                           => $gst,
				'is_fuel_surcharge'				=> $is_fuel,
				'fuel_surcharge'				=> $fuel_surc,
				'is_others_charges'				=> $is_others,
				'others_charges'				=> $others_chrg,
				//'is_faf'						=> $is_faf,
				//'faf'							=> $faf,
				//'faf_start_date'				=> $faf_date,
				'reference_by'                  => $reference_by,
				'secondary_reference_by'        => $secondary_reference_by,
				'pay_mode'                      => $paymode,
				'services'                  	=> $service_type,
				'pay_mode_id'                   => $pay_mode_id,
				'billable_unit'					=> $b_unit,
				'modify_by'                     => $_SESSION['user_id'],
				'modify_date'                   =>  date('Y-m-d H:i:s')
			);
			$effective_rows = $this->Commonmodel->Update_record('cargo.saimtech_customer', 'customer_id', $customer_id, $data);
			//echo $this->db->last_query();
			$this->update_customer_services($customer_id);
			//$this->db->trans_complete();

			$message = "<p class='alert alert-success'>Successfully Done</p>";
			redirect(base_url() . 'Customer/edit_customer_view/' . $customer_id);
		} else {

			echo "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>" . $service_type;
		}
	}

	public function check_username()
	{
		$username = $this->input->post('username');
		$check = 0;
		if ($username != "") {
			$check = $this->Commonmodel->Duplicate_check('saimtech_user', 'account_no', $username);
		} else {
			$check = 0;
		}
		echo ($check);
	}

	public function zone_wise_rate_view($customer_id)
	{
		if ($customer_id) {

			$data['service_data'] = $this->Commonmodel->Get_record_by_condition('acc_services', 'is_enable', 1);
			$data['customer_id'] = $customer_id;

			$data['rate_data'] = $this->Customermodel->Get_Account_Rates($customer_id);
			$data['locs'] = $this->Commonmodel->Get_record_by_double_condition('acc_city', 'is_enable', 1, 'is_bookable', 1);

			/*$data['rate_type_list'] = $this->rate_type;
					$data['zone_type_region_list'] = $this->zone_type_region;
					$data['zone_type_tranist_list'] = $this->zone_type_tranist;
					$data['zones_list'] = $this->zones;
					$data['zone_ex_list'] = $this->zone_ex;
					
					$data['zone_type_list'] = $this->zone_type;
				$data['zone_list'] = $this->zone;*/

			$data['zone_type'] = $this->Commonmodel->Get_record_by_double_condition('acc_types', 'is_enable', 1, 'acc_type', 'zone_type');
			$data['zone_ex'] = $this->Commonmodel->Get_record_by_double_condition('acc_types', 'is_enable', 1, 'acc_type', 'zone_ex');
			$data['zone_tranist'] = $this->Commonmodel->Get_record_by_double_condition('acc_types', 'is_enable', 1, 'acc_type', 'zone_tw');
			$data['zone_province'] = $this->Commonmodel->Get_record_by_double_condition('acc_types', 'is_enable', 1, 'acc_type', 'zone_pw');
			$data['zone'] = $this->Commonmodel->Get_record_by_double_condition('acc_types', 'is_enable', 1, 'acc_type', 'zone');
			$data['rate_types'] = $this->Commonmodel->Get_record_by_double_condition_array('acc_types', 'is_enable', 1, 'acc_type', 'rate_type');
			$data['loc_types'] = $this->Commonmodel->Get_record_by_double_condition_array('acc_types', 'is_enable', 1, 'acc_type', 'loc_type');

			$this->load->view('module_customer/ratecreateView', $data);
		} else {
			echo ("<center><h1><mark>Access Blocked.....</mark></h1></center>");
		}
	}

	public function add_article()
	{
		$in_customer_id = $this->input->post('customer_id');
		$in_art_name = $this->input->post('art_name');
		$in_art_wgt = $this->input->post('art_wgt');
		$in_art_pcs = $this->input->post('art_pcs');
		$in_art_rate = $this->input->post('art_rate');
		$in_art_start_date = $this->input->post('art_start_date');
		$in_art_end_date = $this->input->post('art_end_date');
		$in_rate_id = $this->input->post('art_rate_id');
		$in_art_id = $this->input->post('art_id');

		if (!strlen($in_art_id) > 0) {
			$art = array(
				'customer_id' => $in_customer_id,
				'article_name' => $in_art_name,
				'article_weight' => $in_art_wgt,
				'pcs_unit' => $in_art_pcs
			);
			$in_art_id = $this->Commonmodel->Insert_record('acc_customer_articles', $art);
		} else {
			$art = array(
				'customer_id' => $in_customer_id,
				'article_name' => $in_art_name,
				'article_weight' => $in_art_wgt,
				'pcs_unit' => $in_art_pcs
			);
			$this->Commonmodel->Update_record('acc_customer_articles', 'acc_article_id', $in_art_id, $art);
		}

		if (!strlen($in_rate_id) > 0) {
			$rate = array(
				'rate_type'				=> 'AR',
				'customer_id'			=> $in_customer_id,
				'service_id'			=> 5,
				'o_or_z'				=> $in_art_id,
				'd_or_zt'				=> '',
				'min_wgt'				=> $in_art_wgt,
				'min_rate'				=> $in_art_rate,
				'add_wgt'				=> 1,
				'add_rate'				=> $in_art_rate / $in_art_wgt,
				'start_date'			=> $in_art_start_date,
				'end_date'				=> $in_art_end_date
			);
			$in_rate_id = $this->Commonmodel->Insert_record('acc_rates', $rate);
		} else {
			$rate = array(
				'rate_type'				=> 'AR',
				'customer_id'			=> $in_customer_id,
				'service_id'			=> 5,
				'o_or_z'				=> $in_art_id,
				'd_or_zt'				=> '',
				'min_wgt'				=> $in_art_wgt,
				'min_rate'				=> $in_art_rate,
				'add_wgt'				=> 1,
				'add_rate'				=> $in_art_rate / $in_art_wgt,
				'start_date'			=> $in_art_start_date,
				'end_date'				=> $in_art_end_date
			);
			$this->Commonmodel->Update_record('acc_rates', 'rate_id', $in_rate_id, $rate);
		}

		redirect('customer/zone_wise_rate_view/' . $in_customer_id);
	}

	public function get_article()
	{
		$rate_id = $this->input->get('rate_id');
		$art = $this->Customermodel->Get_Article_By_Rateid($rate_id);
		echo json_encode($art);
	}

	public function add_rates()
	{
		$p_min_wgt			= $this->input->post('min_wgt');
		$p_min_rate			= $this->input->post('min_rate');
		$p_add_wgt			= $this->input->post('add_wgt');
		$p_add_rate			= $this->input->post('add_rate');
		$p_start_date		= $this->input->post('start_date');
		$p_end_date			= $this->input->post('end_date');
		$p_customer_id		= $this->input->post('customer_id');
		$p_service_type		= $this->input->post('service_type');
		$p_rate_type		= $this->input->post('rate_type');
		$p_zone				= $this->input->post('zone');
		$p_zone_type		= $this->input->post('zone_type');
		$p_zone_list		= $this->input->post('zonelist');
		$p_rate_id			= !empty($this->input->post('rate_id')) ? $this->input->post('rate_id') : 0;

		$rate_id 			= 0;
		$chk 				= 0;

		if ($p_rate_id == 0) {
			if ($p_rate_type == "FR") {
				$fr_zone = explode("|", $p_zone_list);
				foreach ($fr_zone as $z) {
					if ($z != 'WC') {
						$data = array(
							'rate_type'				=> $p_rate_type,
							'customer_id'			=> $p_customer_id,
							'service_id'			=> $p_service_type,
							'o_or_z'				=> $z,
							'd_or_zt'				=> substr($z, 0, 1),
							'min_wgt'				=> $p_min_wgt,
							'min_rate'				=> $p_min_rate,
							'add_wgt'				=> $p_add_wgt,
							'add_rate'				=> $p_add_rate,
							'start_date'			=> $p_start_date,
							'end_date'				=> $p_end_date
						);

						$chk = $this->Commonmodel->Duplicate_check_six('acc_rates', 'customer_id', 'is_enable', 1, $p_customer_id, 'service_id', $p_service_type, 'rate_type', $p_rate_type, 'o_or_z', $z, 'd_or_zt', substr($z, 0, 1));
						if ($chk == 0) {
							$rate_id = $this->Commonmodel->Insert_record('acc_rates', $data);
						} else {
							$rate_id = 0;
						}
					}
				}
			} else if ($p_rate_type == "DW") {
				$data = array(
					'rate_type'				=> $p_rate_type,
					'customer_id'			=> $p_customer_id,
					'service_id'			=> $p_service_type,
					'o_or_z'				=> $p_zone,
					'd_or_zt'				=> $p_zone_type,
					'min_wgt'				=> $p_min_wgt,
					'min_rate'				=> $p_min_rate,
					'add_wgt'				=> $p_add_wgt,
					'add_rate'				=> $p_add_rate,
					'start_date'			=> $p_start_date,
					'end_date'				=> $p_end_date
				);

				$chk = $this->Commonmodel->Duplicate_check_six('acc_rates', 'customer_id', 'is_enable', 1, $p_customer_id, 'service_id', $p_service_type, 'rate_type', $p_rate_type, 'o_or_z', $p_zone, 'd_or_zt', $p_zone_type);
				if ($chk == 0) {
					$rate_id = $this->Commonmodel->Insert_record('acc_rates', $data);
				} else {
					$rate_id = 0;
				}

				$data = array(
					'rate_type'				=> $p_rate_type,
					'customer_id'			=> $p_customer_id,
					'service_id'			=> $p_service_type,
					'o_or_z'				=> $p_zone_type,
					'd_or_zt'				=> $p_zone,
					'min_wgt'				=> $p_min_wgt,
					'min_rate'				=> $p_min_rate,
					'add_wgt'				=> $p_add_wgt,
					'add_rate'				=> $p_add_rate,
					'start_date'			=> $p_start_date,
					'end_date'				=> $p_end_date
				);

				$chk = $this->Commonmodel->Duplicate_check_six('acc_rates', 'customer_id', 'is_enable', 1, $p_customer_id, 'service_id', $p_service_type, 'rate_type', $p_rate_type, 'o_or_z', $p_zone_type, 'd_or_zt', $p_zone);
				if ($chk == 0) {
					$rate_id = $this->Commonmodel->Insert_record('acc_rates', $data);
				} else {
					$rate_id = 0;
				}
			} else {
				$data = array(
					'rate_type'				=> $p_rate_type,
					'customer_id'			=> $p_customer_id,
					'service_id'			=> $p_service_type,
					'o_or_z'				=> $p_zone,
					'd_or_zt'				=> $p_zone_type,
					'min_wgt'				=> $p_min_wgt,
					'min_rate'				=> $p_min_rate,
					'add_wgt'				=> $p_add_wgt,
					'add_rate'				=> $p_add_rate,
					'start_date'			=> $p_start_date,
					'end_date'				=> $p_end_date
				);

				$chk = $this->Commonmodel->Duplicate_check_six('acc_rates', 'customer_id', 'is_enable', 1, $p_customer_id, 'service_id', $p_service_type, 'rate_type', $p_rate_type, 'o_or_z', $p_zone, 'd_or_zt', $p_zone_type);
				if ($chk == 0) {
					$rate_id = $this->Commonmodel->Insert_record('acc_rates', $data);
				} else {
					$rate_id = 0;
				}
			}
		} else {
			$data = array(
				'min_wgt'				=> $p_min_wgt,
				'min_rate'				=> $p_min_rate,
				'add_wgt'				=> $p_add_wgt,
				'add_rate'				=> $p_add_rate,
				'start_date'			=> $p_start_date,
				'end_date'				=> $p_end_date
			);

			$rate_id = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $p_rate_id, $data);
		}

		$this->update_customer_services($p_customer_id);

		if ($rate_id > 0) {
			$message = "<p class='alert alert-success'>Successfully Done</p>";
			redirect(base_url() . 'Customer/zone_wise_rate_view/' . $p_customer_id);
		} else {
			$message = "<p class='alert alert-danger'>Error</p>";
			redirect(base_url() . 'Customer/zone_wise_rate_view/' . $p_customer_id);
		}
	}

	public function add_faf()
	{
		$chk = 0;
		$cid = $this->input->post("c_id");
		$fid = $this->input->post("faf_id");
		$faf = $this->input->post("faf");
		$fsd = $this->input->post("faf_start_date");
		$fed = $this->input->post("faf_end_date");

		if ($fid > 0) {
			$data = array(
				'faf' => ($faf / 100),
				'start_date' => $fsd,
				'end_date' => $fed,
				'modify_by' => $_SESSION['user_id'],
				'modify_at' => date('Y-m-d H:i:s')
			);
			$chk = $this->Commonmodel->Update_record('acc_customer_faf', 'acc_cf_id', $fid, $data);
		} else {
			$data = array(
				'customer_id' => $cid,
				'faf' => ($faf / 100),
				'start_date' => $fsd,
				'end_date' => $fed,
				'is_enable' => 1,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$chk = $this->Commonmodel->Insert_record('acc_customer_faf', $data);
		}

		redirect(base_url() . 'Customer/edit_customer_view/' . $cid);
	}

	public function update_customer_services($cid)
	{
		$srvs = $this->Commonmodel->Raw_Query_Execution("SELECT GROUP_CONCAT(DISTINCT service_id) as 'srs' FROM acc_rates WHERE customer_id = " . $cid . " AND is_enable = 1;");

		$data = array('services' => $srvs[0]->srs);

		$this->Commonmodel->Update_record('acc_customers', 'customer_id', $cid, $data);
		$this->db->query("CALL `tmaccounts_cargo_cust_services_update`(" . $cid . ");");
	}

	public function suspend_faf()
	{
		$chk = 0;

		$cf_id		= $this->input->post('cf_id');

		$data = array(
			'is_enable'	=> 0,
			'modify_by' => $_SESSION['user_id'],
			'modify_at' => date('Y-m-d H:i:s')
		);

		$chk = $this->Commonmodel->Update_record('acc_customer_faf', 'acc_cf_id', $cf_id, $data);

		echo $chk;
	}

	public function suspend_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');

		$data = array('is_enable'	=> 0);

		$chk = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $rate_id, $data);

		$this->update_customer_services($customer_id);

		echo $chk;
	}

	public function enable_faf()
	{
		$chk = 0;

		$cf_id		= $this->input->post('cf_id');

		$data = array(
			'is_enable'	=> 1,
			'modify_by' => $_SESSION['user_id'],
			'modify_at' => date('Y-m-d H:i:s')
		);

		$chk = $this->Commonmodel->Update_record('acc_customer_faf', 'acc_cf_id', $cf_id, $data);
		echo $chk;
	}

	public function suspend_art_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');
		$art = $this->Customermodel->Get_Article_By_Rateid($rate_id)[0];

		$data = array('is_enable'	=> 0);
		$chk = $this->Commonmodel->Update_record('acc_customer_articles', 'acc_article_id', $art->acc_article_id, $data);
		$chk = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $rate_id, $data);

		$this->update_customer_services($customer_id);

		echo $chk;
	}

	public function suspend_edit_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');

		$data = array('is_enable'	=> 0);
		$chk = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $rate_id, $data);

		$this->update_customer_services($customer_id);
		echo $chk;
	}

	public function enable_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');

		$data = array('is_enable'	=> 1);

		$chk = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $rate_id, $data);

		$this->update_customer_services($customer_id);

		echo $chk;
	}

	public function enable_art_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');
		$art = $this->Customermodel->Get_Article_By_Rateid($rate_id)[0];

		$data = array('is_enable'	=> 1);
		$chk = $this->Commonmodel->Update_record('acc_customer_articles', 'acc_article_id', $art->acc_article_id, $data);
		$chk = $this->Commonmodel->Update_record('acc_rates', 'rate_id', $rate_id, $data);

		$this->update_customer_services($customer_id);

		echo $chk;
	}

	public function delete_rate()
	{
		$chk = 0;

		$customer_id	= $this->input->post('customer_id');
		$rate_id		= $this->input->post('rate_id');

		$chk = $this->Commonmodel->Delete_record('acc_rates', 'rate_id', $rate_id);

		$this->update_customer_services($customer_id);

		echo $chk;
	}

	public function delete_faf()
	{
		$chk = 0;

		$cf_id		= $this->input->post('cf_id');

		$data = array(
			'is_enable'	=> 0,
			'modify_by' => $_SESSION['user_id'],
			'modify_at' => date('Y-m-d H:i:s')
		);

		$chk = $this->Commonmodel->Delete_record('acc_customer_faf', 'acc_cf_id', $cf_id, $data);
		echo $chk;
	}

	public function delete_art_rate()
	{
		$chk = 0;

		$customer_id = $this->input->get('customer_id');
		$rate_id = $this->input->get('rate_id');
		$art = $this->Customermodel->Get_Article_By_Rateid($rate_id)[0];
		$chk = $this->Commonmodel->Delete_record('acc_customer_articles', 'acc_article_id', $art->acc_article_id);
		$chk = $this->Commonmodel->Delete_record('acc_rates', 'rate_id', $rate_id);

		$this->update_customer_services($customer_id);
		echo $chk;
	}


	public function add_zone_wise_rate()
	{
		$service_type           = $this->input->post('service_type');
		$customer_id            = $this->input->post('customer_id');
		$zone_a_wgt_1           = $this->input->post('zone_a_wgt_1');
		$zone_a_rate_1          = $this->input->post('zone_a_rate_1');
		$zone_a_wgt_2           = $this->input->post('zone_a_wgt_2');
		$zone_a_rate_2          = $this->input->post('zone_a_rate_2');
		$zone_a_add_wgt         = $this->input->post('zone_a_add_wgt');
		$zone_a_add_rate        = $this->input->post('zone_a_add_rate');
		$zone_a_gst             = $this->input->post('zone_a_gst');
		$zone_b_gst             = $this->input->post('zone_b_gst');
		$zone_c_gst             = $this->input->post('zone_c_gst');
		$zone_d_gst             = $this->input->post('zone_d_gst');
		$zone_b_wgt_1           = $this->input->post('zone_b_wgt_1');
		$zone_b_rate_1          = $this->input->post('zone_b_rate_1');
		$zone_b_wgt_2           = $this->input->post('zone_b_wgt_2');
		$zone_b_rate_2          = $this->input->post('zone_b_rate_2');
		$zone_b_add_wgt         = $this->input->post('zone_b_add_wgt');
		$zone_b_add_rate        = $this->input->post('zone_b_add_rate');
		$zone_c_wgt_1           = $this->input->post('zone_c_wgt_1');
		$zone_c_rate_1          = $this->input->post('zone_c_rate_1');
		$zone_c_wgt_2           = $this->input->post('zone_c_wgt_2');
		$zone_c_rate_2          = $this->input->post('zone_c_rate_2');
		$zone_c_add_wgt         = $this->input->post('zone_c_add_wgt');
		$zone_c_add_rate        = $this->input->post('zone_c_add_rate');
		$zone_d_wgt_1           = $this->input->post('zone_d_wgt_1');
		$zone_d_rate_1          = $this->input->post('zone_d_rate_1');
		$zone_d_wgt_2           = $this->input->post('zone_d_wgt_2');
		$zone_d_rate_2          = $this->input->post('zone_d_rate_2');
		$zone_d_add_wgt         = $this->input->post('zone_d_add_wgt');
		$zone_d_add_rate        = $this->input->post('zone_d_add_rate');
		$check                  = 0;
		if (
			$service_type != "" &&
			$customer_id != "" &&
			$zone_a_wgt_1 > 0 &&
			$zone_b_wgt_1 > 0 &&
			$zone_c_wgt_1 > 0 &&
			$zone_d_wgt_1 > 0 &&
			$zone_a_wgt_2 > 0 &&
			$zone_b_wgt_2 > 0 &&
			$zone_c_wgt_2 > 0 &&
			$zone_d_wgt_2 > 0 &&
			$zone_a_add_wgt > 0 &&
			$zone_b_add_wgt > 0 &&
			$zone_c_add_wgt > 0 &&
			$zone_d_add_wgt > 0 &&
			$zone_a_rate_1 > 0 &&
			$zone_b_rate_1 > 0 &&
			$zone_c_rate_1 > 0 &&
			$zone_d_rate_1 > 0 &&
			$zone_a_rate_2 > 0 &&
			$zone_b_rate_2 > 0 &&
			$zone_c_rate_2 > 0 &&
			$zone_d_rate_2 > 0 &&
			$zone_a_add_rate > 0 &&
			$zone_b_add_rate > 0 &&
			$zone_c_add_rate > 0 &&
			$zone_d_add_rate > 0
		) {
			//---------Duplicate Check----------------
			$check = $this->Commonmodel->Duplicate_double_check('saimtech_rate', 'service_id', $service_type, 'customer_id', $customer_id);
			if ($check == 0) {
				$data = array(
					'customer_id'           => $customer_id,
					'service_id'            => $service_type,
					'sc_wgt1'               => $zone_a_wgt_1,
					'sc_rate1'              => $zone_a_rate_1,
					'sc_wgt2'               => $zone_a_wgt_2,
					'sc_rate2'              => $zone_a_rate_2,
					'sc_add_wgt'            => $zone_a_add_wgt,
					'sc_add_rate'           => $zone_a_add_rate,
					'sc_gst_rate'           => $zone_a_gst,
					'sc_fuel_formula'       => 'FIX',
					'sc_fuel_rate'          => 0,
					'sc_sp_handling_formula' => 'FIX',
					'sc_sp_handling_rate'   => 0,
					'sc_return_formula'     => 'FIX',
					'sc_return_rate'        => 0,
					'sz_wgt1'               => $zone_b_wgt_1,
					'sz_rate1'              => $zone_b_rate_1,
					'sz_wgt2'               => $zone_b_wgt_2,
					'sz_rate2'              => $zone_b_rate_2,
					'sz_add_wgt'            => $zone_b_add_wgt,
					'sz_add_rate'           => $zone_b_add_rate,
					'sz_gst_rate'           => $zone_b_gst,
					'sz_fuel_formula'       => 'FIX',
					'sz_fuel_rate'          => 0,
					'sz_sp_handling_formula' => 'FIX',
					'sz_sp_handling_rate'   => 0,
					'sz_return_formula'     => 'FIX',
					'sz_return_rate'        => 0,
					'dz_wgt1'               => $zone_c_wgt_1,
					'dz_rate1'              => $zone_c_rate_1,
					'dz_wgt2'               => $zone_c_wgt_2,
					'dz_rate2'              => $zone_c_rate_2,
					'dz_add_wgt'            => $zone_c_add_wgt,
					'dz_add_rate'           => $zone_c_add_rate,
					'dz_fuel_formula'       => 'FIX',
					'dz_fuel_rate'          => 0,
					'dz_sp_handling_formula' => 'FIX',
					'dz_sp_handling_rate'   => 0,
					'dz_gst_rate'           => $zone_c_gst,
					'dz_return_formula'     => 'FIX',
					'dz_return_rate'        => 0,
					'zz_wgt1'               => $zone_d_wgt_1,
					'zz_rate1'              => $zone_d_rate_1,
					'zz_wgt2'               => $zone_d_wgt_2,
					'zz_rate2'              => $zone_d_rate_2,
					'zz_add_wgt'            => $zone_d_add_wgt,
					'zz_add_rate'           => $zone_d_add_rate,
					'zz_fuel_formula'       => 'FIX',
					'zz_fuel_rate'          => 0,
					'zz_sp_handling_formula' => 'FIX',
					'zz_sp_handling_rate'   => 0,
					'zz_gst_rate'           => $zone_d_gst,
					'zz_return_formula'     => 'FIX',
					'zz_return_rate'        => 0,
					'cash_handling_formula' => 'FIX',
					'cash_handling_rate'    => 0,
					'reference_formula'     => 'FIX',
					'reference_rate'        => 0,
					'flyer_rate'            => 0,
					'is_enable'             => 1,
					'deactive_date'         => '0000-00-00 00:00:00',
					'delete_date'           => '0000-00-00 00:00:00',
					'created_by'            => $_SESSION['user_id'],
					'created_date'          => date('Y-m-d H:i:s'),
					'modify_by'             => 0,
					'modify_date'           => '0000-00-00 00:00:00',
				);
				$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			} else {
				$data = array(
					'is_enable'     => 0,
					'deactive_date' => date('Y-m-d'),
					'modify_by'     => $_SESSION['user_id'],
					'modify_date'   => date('Y-m-d H:i:s')
				);
				$rate_id = $this->Commonmodel->Update_double_record('saimtech_rate', 'service_id', $service_type, 'customer_id', $customer_id, $data);
				$data = array(
					'customer_id'           => $customer_id,
					'service_id'            => $service_type,
					'sc_wgt1'               => $zone_a_wgt_1,
					'sc_rate1'              => $zone_a_rate_1,
					'sc_wgt2'               => $zone_a_wgt_2,
					'sc_rate2'              => $zone_a_rate_2,
					'sc_add_wgt'            => $zone_a_add_wgt,
					'sc_add_rate'           => $zone_a_add_rate,
					'sc_gst_rate'           => $zone_a_gst,
					'sc_fuel_formula'       => 'FIX',
					'sc_fuel_rate'          => 0,
					'sc_sp_handling_formula' => 'FIX',
					'sc_sp_handling_rate'   => 0,
					'sc_return_formula'     => 'FIX',
					'sc_return_rate'        => 0,
					'sz_wgt1'               => $zone_b_wgt_1,
					'sz_rate1'              => $zone_b_rate_1,
					'sz_wgt2'               => $zone_b_wgt_2,
					'sz_rate2'              => $zone_b_rate_2,
					'sz_add_wgt'            => $zone_b_add_wgt,
					'sz_add_rate'           => $zone_b_add_rate,
					'sz_gst_rate'           => $zone_b_gst,
					'sz_fuel_formula'       => 'FIX',
					'sz_fuel_rate'          => 0,
					'sz_sp_handling_formula' => 'FIX',
					'sz_sp_handling_rate'   => 0,
					'sz_return_formula'     => 'FIX',
					'sz_return_rate'        => 0,
					'dz_wgt1'               => $zone_c_wgt_1,
					'dz_rate1'              => $zone_c_rate_1,
					'dz_wgt2'               => $zone_c_wgt_2,
					'dz_rate2'              => $zone_c_rate_2,
					'dz_add_wgt'            => $zone_c_add_wgt,
					'dz_add_rate'           => $zone_c_add_rate,
					'dz_fuel_formula'       => 'FIX',
					'dz_fuel_rate'          => 0,
					'dz_sp_handling_formula' => 'FIX',
					'dz_sp_handling_rate'   => 0,
					'dz_gst_rate'           => $zone_c_gst,
					'dz_return_formula'     => 'FIX',
					'dz_return_rate'        => 0,
					'zz_wgt1'               => $zone_d_wgt_1,
					'zz_rate1'              => $zone_d_rate_1,
					'zz_wgt2'               => $zone_d_wgt_2,
					'zz_rate2'              => $zone_d_rate_2,
					'zz_add_wgt'            => $zone_d_add_wgt,
					'zz_add_rate'           => $zone_d_add_rate,
					'zz_fuel_formula'       => 'FIX',
					'zz_fuel_rate'          => 0,
					'zz_sp_handling_formula' => 'FIX',
					'zz_sp_handling_rate'   => 0,
					'zz_gst_rate'           => $zone_d_gst,
					'zz_return_formula'     => 'FIX',
					'zz_return_rate'        => 0,
					'cash_handling_formula' => 'FIX',
					'cash_handling_rate'    => 0,
					'reference_formula'     => 'FIX',
					'reference_rate'        => 0,
					'flyer_rate'            => 0,
					'is_enable'             => 1,
					'deactive_date'         => '0000-00-00 00:00:00',
					'delete_date'           => '0000-00-00 00:00:00',
					'created_by'            => $_SESSION['user_id'],
					'created_date'          => date('Y-m-d H:i:s'),
					'modify_by'             => 0,
					'modify_date'           => '0000-00-00 00:00:00',
				);
				$rate_id = $this->Commonmodel->Insert_record('saimtech_rate', $data);
			}
			$this->redraw_table_zone_rate($customer_id);
			//======================================END
		} else {
			echo ("Fail");
		}
	}

	public function redraw_table_zone_rate($customer_id)
	{
		$query = "SELECT *, `saimtech_rate`.`is_enable` as rate_status  FROM `saimtech_rate` INNER JOIN saimtech_service ON saimtech_service.service_id=saimtech_rate.service_id WHERE customer_id=" . $customer_id;
		$rate_data = $this->Commonmodel->Raw_Query_Execution($query);
		if (!empty($rate_data)) {
			foreach ($rate_data as $rows) {
				echo ("<tr>");
				echo ("<td><center>" . $rows->service_name . " (" . $rows->service_code . ")<p><b>Rate ID:</b>" . $rows->rate_id . "</p>");
				if ($rows->rate_status == 1) {
					echo ("<a href='" . base_url() . "customer/destination_wise_rate_view/" . $rows->customer_id . "/" . $rows->service_id . "' class='btn btn-info'>Destination Wise</a>");
				}
				echo ("</center></td>");
				echo ("<td style='border-color:#6f42c1'>
					<p><b>WGT1:</b> " . $rows->sc_wgt1 . "    <b>Rate1:</b> " . $rows->sc_rate1 . "</p>
					<p><b>WGT2:</b> " . $rows->sc_wgt2 . "    <b>Rate2:</b> " . $rows->sc_rate2 . "</p>
					<p><b>AWGT:</b> " . $rows->sc_dd_wgt . "        <b>ARate:</b> " . $rows->sc_add_rate . "</p>
					<p><b>GST:</b> " . $rows->sc_gst_rate . "</p>
					</td>");
				echo ("<td style='border-color:#007bff'>
					<p><b>WGT1:</b> " . $rows->sz_wgt1 . "    <b>Rate1:</b> " . $rows->sz_rate1 . "</p>
					<p><b>WGT2:</b> " . $rows->sz_wgt2 . "    <b>Rate2:</b> " . $rows->sz_rate2 . "</p>
					<p><b>AWGT:</b> " . $rows->sz_add_wgt . "        <b>ARate:</b> " . $rows->sz_add_rate . "</p>
					<p><b>GST:</b> " . $rows->sz_gst_rate . "</p>
					</td>");
				echo ("<td style='border-color:#17a2b8'>
					<p><b>WGT1:</b> " . $rows->dz_wgt1 . "    <b>Rate1:</b> " . $rows->dz_rate1 . "</p>
					<p><b>WGT2:</b> " . $rows->dz_wgt2 . "    <b>Rate2:</b> " . $rows->dz_rate2 . "</p>
					<p><b>AWGT:</b> " . $rows->dz_add_wgt . "        <b>ARate:</b> " . $rows->dz_add_rate . "</p>
					<p><b>GST:</b> " . $rows->dz_gst_rate . "</p>
					</td>");
				echo ("<td style='border-color:#20c997'>
					<p><b>WGT1:</b> " . $rows->zz_wgt1 . "    <b>Rate1:</b> " . $rows->zz_rate1 . "</p>
					<p><b>WGT2:</b> " . $rows->zz_wgt2 . "    <b>Rate2:</b> " . $rows->zz_rate2 . "</p>
					<p><b>AWGT:</b> " . $rows->zz_add_wgt . " <b>ARate:</b> " . $rows->zz_add_rate . "</p>
					<p><b>GST:</b> " . $rows->zz_gst_rate . "</p>
					</td>");
				if ($rows->rate_status == 1) {
					echo ("<td class='bg-success text-white'><center>Active</center></td>");
				} else {
					echo ("<td class='bg-danger text-white'><center>Blocked</center></td>");
				}
				echo ("</tr>");
			}
		}
	}

	public function destination_wise_rate_view($customer_id, $service_type)
	{
		$data['city_data'] = $this->Commonmodel->Get_record_by_condition('acc_city', 'is_enable', 1);
		$data['customer_id'] = $customer_id;
		$data['service_type'] = $service_type;
		$data['service_data'] = $this->Commonmodel->Get_record_by_condition('saimtech_service', 'is_enable', 1);


		$data['destination_data'] = $this->Commonmodel->Get_Destination_Wise_Rate($customer_id, $service_type);
		$this->load->view('module_customer/dratecreateView', $data);
	}

	public function destination_wise_rate()
	{
		$service_type   = $this->input->post('service_type');
		$customer_id    = $this->input->post('customer_id');
		$wgt1           = $this->input->post('wgt1');
		$rate1          = $this->input->post('rate1');
		$wgt2           = $this->input->post('wgt2');
		$rate2          = $this->input->post('rate2');
		$addwgt         = $this->input->post('addwgt');
		$addrate        = $this->input->post('addrate');
		$gst            = $this->input->post('gst');
		$origin         = $this->input->post('origin');
		$destination    = $this->input->post('destination');
		$j              = sizeof($destination);
		if ($service_type != "" && $customer_id != "" && $wgt1 != "" &&  $rate1 != "" &&  $wgt2 != "" &&  $rate2 != "" && $addwgt != "" && $addrate != "" && $gst != "" && $origin != "" && $j != "") {


			for ($i = 0; $i <= $j; $i++) {
				if ($destination[$i] != "ex_punjab" && $destination[$i] != "ex_sindh" && $destination[$i] != "ex_kpk") {
					$check = $this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $service_type, 'customer_id', $customer_id, 'dest_city_id', $destination[$i], 'origin_city_id', $origin, 'is_enable', 1);
					if ($check > 0) {
						$data = array(
							'is_enable'    => 0,
							'modify_by'    => $_SESSION['user_id'],
							'modify_date'  => date('Y-m-d H:i:s')
						);
						$this->Commonmodel->Update_Five_record('saimtech_destination_rate', 'service_id', $service_type, 'customer_id', $customer_id, 'dest_city_id', $destination[$i], 'origin_city_id', $origin, 'is_enable', 1, $data);
					}
					$data = array(
						'customer_id'   => $customer_id,
						'service_id'    => $service_type,
						'origin_city_id' => $origin,
						'dest_city_id'  => $destination[$i],
						'city_wgt1'     => $wgt1,
						'city_rate1'    => $rate1,
						'city_wgt2'     => $wgt2,
						'city_rate2'    => $rate2,
						'city_add_wgt'  => $addwgt,
						'city_add_rate' => $addrate,
						'city_gst'      => $gst,
						'is_enable'     => 1,
						'created_by'    => $_SESSION['user_id'],
						'created_date'  => date('Y-m-d H:i:s'),
						'modify_by'     => 0,
						'modify_date'   => '0000-00-00 00:00:00'
					);
					$this->Commonmodel->Insert_record('saimtech_destination_rate', $data);
				} else {
					$dest_cities_data = $this->Commonmodel->Get_record_by_condition('acc_city', 'mixture', $destination[$i]);
					if (!empty($dest_cities_data)) {
						foreach ($dest_cities_data as $rows) {
							$check = $this->Commonmodel->five_double_check('saimtech_destination_rate', 'service_id', $service_type, 'customer_id', $customer_id, 'dest_city_id', $rows->city_id, 'origin_city_id', $origin, 'is_enable', 1);
							if ($check > 0) {
								$data = array(
									'is_enable'    => 0,
									'modify_by'    => $_SESSION['user_id'],
									'modify_date'  => date('Y-m-d H:i:s')
								);
								$this->Commonmodel->Update_Five_record('saimtech_destination_rate', 'service_id', $service_type, 'customer_id', $customer_id, 'dest_city_id', $rows->city_id, 'origin_city_id', $origin, 'is_enable', 1, $data);
							}
							$data = array(
								'customer_id'   => $customer_id,
								'service_id'    => $service_type,
								'origin_city_id' => $origin,
								'dest_city_id'  => $rows->city_id,
								'city_wgt1'     => $wgt1,
								'city_rate1'    => $rate1,
								'city_wgt2'     => $wgt2,
								'city_rate2'    => $rate2,
								'city_add_wgt'  => $addwgt,
								'city_add_rate' => $addrate,
								'city_gst'      => $gst,
								'is_enable'     => 1,
								'created_by'    => $_SESSION['user_id'],
								'created_date'  => date('Y-m-d H:i:s'),
								'modify_by'     => 0,
								'modify_date'   => '0000-00-00 00:00:00'
							);
							$this->Commonmodel->Insert_record('saimtech_destination_rate', $data);
						}
					}
				}
			}

			$this->redraw_table_destination_wise($customer_id, $service_type);
		}
	}

	public function redraw_table_destination_wise($customer_id, $service_type)
	{
		$destination_data = $this->Commonmodel->Get_Destination_Wise_Rate($customer_id, $service_type);
		if (!empty($destination_data)) {
			foreach ($destination_data as $rows) {
				echo ("<tr>");
				echo ("<td>" . $rows->Service . "</td>");
				echo ("<td>" . $rows->Origin . "</td>");
				echo ("<td>" . $rows->Destination . "</td>");
				echo ("<td>" . $rows->city_wgt1 . "</td>");
				echo ("<td>" . $rows->city_rate1 . "</td>");
				echo ("<td>" . $rows->city_wgt2 . "</td>");
				echo ("<td>" . $rows->city_rate2 . "</td>");
				echo ("<td>" . $rows->city_add_wgt . "</td>");
				echo ("<td>" . $rows->city_add_rate . "</td>");
				echo ("<td>" . $rows->city_gst . "</td>");
				if ($rows->wenable == 1) {
					echo ("<td class='bg-success text-white'>Active</td>");
				} else {
					echo ("<td class='bg-danger text-white'>Blocked</td>");
				}
				echo ("</tr>");
			}
		}
	}

	public function update_status_customer($customerid, $status)
	{
		$this->db->trans_start();
		if ($customerid != "" && $status != "") {
			$narration = "Profile Suspended";
			if ($status == 1) {
				$narration = "Reactive Customer Profile";
			}
			$data = array(
				'is_enable'                 => $status,
				'modify_by'                 => $_SESSION['user_id'],
				'modify_date'               => date('Y-m-d H:i:s ')
			);

			$this->Commonmodel->Update_record('cargo.saimtech_customer', 'customer_id', $customerid, $data);
			//print_r($data);
			//$data =array(
			//'customer_id'      => $customerid,
			//'narration'        => $narration,
			//'user_id'          => $_SESSION['user_id']
			//);
			//$this->Commonmodel->Insert_record('acc_customers_log', $data);
			//print_r($data);
			$this->db->trans_complete();
		}
		redirect('customer');
	}
}
