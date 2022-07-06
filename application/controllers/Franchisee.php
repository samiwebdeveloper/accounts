<?php

class Franchisee extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Karachi');
		$this->load->model('Commonmodel');
		$this->load->model('Franchiseemodel');
	}

	public function index()
	{
		$data['sub_nav_active'] = "Franchisee";
		$data['nav_active'] = "View Franchises";
		$data['event_name'] = "View Franchises";

		$data['franchises_data'] = $this->Franchiseemodel->Get_All_Franchisee();
		$this->load->view('module_franchisee/listView', $data);
	}

	public function add_franchisee_view()
	{
		$data['sub_nav_active'] = "Add Franchisee";
		$data['nav_active'] = "Add Franchises";
		$data['event_name'] = "Add Franchises";

		$data['fran_type'] = $this->Franchiseemodel->Get_Franchise_Types();
		$data['fran_status'] = $this->Franchiseemodel->Get_Franchise_Status();
		$data['locs'] = $this->Franchiseemodel->Get_Active_Locations();
		$data['sales_team'] = $this->Franchiseemodel->Get_Active_Sales_Team();
		$data['services'] = $this->Franchiseemodel->Get_Active_Services();
		$data['fran_bill_perd'] = $this->Franchiseemodel->Get_Franchise_Billing_Period();
		$data['fran_pay_meth'] = $this->Franchiseemodel->Get_Franchise_Pay_Method();

		$this->load->view('module_franchisee/singleView', $data);
	}

	public function add_new_franchisee()
	{
		$data = array(
			'b_cycle' => $this->input->post('billing_period'),
			'city_id' => $this->input->post('location'),
			'fran_name' => $this->input->post('name'),
			'fran_code' => $this->input->post('code'),
			'fran_ntn' => $this->input->post('ntn'),
			'fran_gst' => $this->input->post('gst_no'),
			'fran_address' => $this->input->post('address'),
			'fran_ll' => $this->input->post('land_line'),
			'fran_mob' => $this->input->post('mobile_no'),
			'type_id' => $this->input->post('franchisee_type'),
			'reg_date' => $this->input->post('date_of_registration'),
			'pay_terms_days' => $this->input->post('payment_terms'),
			'wht' => $this->input->post('withhold'),
			'gst' => $this->input->post('gst'),
			'osa' => $this->input->post('osa'),
			'btm_rev' => $this->input->post('bottomline'),
			'hr_srv' => $this->input->post('hr_services'),
			'sp_payoff' => $this->input->post('special_pay_off_charges'),
			'agr_exp' => $this->input->post('agreement_expiry'),
			'person_id' => $this->input->post('sales_person'),
			'pay_method' => $this->input->post('payment_method'),
			'sts' => $this->input->post('franchisee_status'),
			'cnic' => $this->input->post('cnic'),
			'ntn' => $this->input->post('ntn'),
			'gst_no' => $this->input->post('gst_no'),
			'is_enable' =>  1,
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		);
		$fr_id = $this->Commonmodel->Insert_record('fran_profile', $data); //Return from Franchisee Profile Table

		//Table Franischee Services
		//loop for selected services
		$fran_services = explode(",", $this->input->post('services'));
		foreach ($fran_services as $srv) {
			$data = array(
				'fr_id' => $fr_id,
				'services_id' => $srv,
				'is_enable' => 1,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Insert_record('fran_services', $data);
		}

		//Table Franchisee Rates
		// Delivery Loop for Locations		
		$fran_loc_chrgs = json_decode($this->input->post('loc_chrg'));
		foreach ($fran_loc_chrgs as $key => $value) {
			$data = array(
				'fr_id' => $fr_id,
				'loc_id' => $key,
				'type' => 1,
				'min' => $value,
				'max' => 0,
				'additional' => 0,
				'unit' => 1,
				'is_enable' => 1,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Insert_record('fran_rates', $data);

			//Child Locations
			if ($key != $this->input->post('location')) {
				$data = array(
					'fr_id' => $fr_id,
					'city_id' => $key,
					'reporting_loc' => $this->input->post('location'),
					'is_enable' => 1,
					'created_by' => $_SESSION['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Commonmodel->Insert_record('fran_locs', $data);
			}
		}

		//Weight
		$data = array(
			'fr_id' => $fr_id,
			'loc_id' => $this->input->post('location'),
			'type' => 2,
			'min' => $this->input->post('weight_charges_min'),
			'max' => $this->input->post('weight_charges_max'),
			'additional' => $this->input->post('additional_weight_charges'),
			'unit' => 2,
			'is_enable' => 1,
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->Commonmodel->Insert_record('fran_rates', $data);

		/*Table Bills
		$fr_id = $fr_id;
		$b_month = $this->input->post('b_month');
		$wht = $this->input->post('wht');
		$gst = $this->input->post('gst');
		$osa = $this->input->post('osa');
		$sp_payoff = $this->input->post('sp_payoff');
		$trans_adj = $this->input->post('trans_adj');
		$arrears = $this->input->post('arrears');
		$deductions = $this->input->post('deductions');
		$adj = $this->input->post('adj');
		$pay_method = $this->input->post('pay_method');
		$created_by = $this->input->post('created_by');
		$created_at = $this->input->post('created_at');*/

		//Table Route
		$data = array(
			'fr_id' => $fr_id,
			'route_id' => $this->input->post('route'),
			'is_enable' => 1,
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->Commonmodel->Insert_record('fran_route', $data);

		$message = "<p class='alert alert-success'>" . $this->input->post('name') . " is Added.</p>";
		redirect(base_url() . 'Franchisee', $message);
	}

	function update_status($fr_id, $sts)
	{
		$data = array(
			'is_enable'	=> $sts,
			'modify_by' => $_SESSION['user_id'],
			'modify_at' => date('Y-m-d H:i:s')
		);

		$chk = $this->Commonmodel->Update_record('fran_profile', 'fr_id', $fr_id, $data);

		$message = $chk > 0 ? "<p class='alert alert-success'>Franchisee enabled.</p>" : "<p class='alert alert-danger'>Error, Pls try again later.</p>";
		redirect(base_url() . 'Franchisee', $message);
	}

	function view_franchisee($fr_id)
	{
		$data['fran_type'] = $this->Franchiseemodel->Get_Franchise_Types();
		$data['fran_status'] = $this->Franchiseemodel->Get_Franchise_Status();
		$data['locs'] = $this->Franchiseemodel->Get_Active_Locations();
		$data['sales_team'] = $this->Franchiseemodel->Get_Active_Sales_Team();
		$data['services'] = $this->Franchiseemodel->Get_Active_Services();
		$data['fran_bill_perd'] = $this->Franchiseemodel->Get_Franchise_Billing_Period();
		$data['fran_pay_meth'] = $this->Franchiseemodel->Get_Franchise_Pay_Method();

		$data['fran_data'] = $this->Franchiseemodel->Get_Franchisee_Data($fr_id);
		$data['fran_route_data'] = $this->Franchiseemodel->Get_Franchisee_Route($fr_id);
		$data['fran_locs_data'] = $this->Franchiseemodel->Get_Franchisee_Locations($fr_id);
		$data['fran_wt_chrg_data'] = $this->Franchiseemodel->Get_Franchisee_Weight_Charges($fr_id);
		$data['fran_services'] = $this->Franchiseemodel->Get_Franchisee_Services($fr_id);
		$data['fran_rates'] = $this->Franchiseemodel->Get_Franchisee_Rates($fr_id);

		$this->load->view('module_franchisee/singleView', $data);
	}

	public function update_franchisee()
	{
		$fr_id = $this->input->post('fr_id');
		$fr_wt_id = $this->input->post('fr_wt_id');
		$fr_route_id = $this->input->post('fr_rt_id');

		$data = array(
			'b_cycle' => $this->input->post('billing_period'),
			'city_id' => $this->input->post('location'),
			'fran_name' => $this->input->post('name'),
			'fran_code' => $this->input->post('code'),
			'fran_ntn' => $this->input->post('ntn'),
			'fran_gst' => $this->input->post('gst_no'),
			'fran_address' => $this->input->post('address'),
			'fran_ll' => $this->input->post('land_line'),
			'fran_mob' => $this->input->post('mobile_no'),
			'type_id' => $this->input->post('franchisee_type'),
			'reg_date' => $this->input->post('date_of_registration'),
			'pay_terms_days' => $this->input->post('payment_terms'),
			'wht' => $this->input->post('withhold'),
			'gst' => $this->input->post('gst'),
			'osa' => $this->input->post('osa'),
			'btm_rev' => $this->input->post('bottomline'),
			'hr_srv' => $this->input->post('hr_services'),
			'sp_payoff' => $this->input->post('special_pay_off_charges'),
			'agr_exp' => $this->input->post('agreement_expiry'),
			'person_id' => $this->input->post('sales_person'),
			'pay_method' => $this->input->post('payment_method'),
			'sts' => $this->input->post('franchisee_status'),
			'cnic' => $this->input->post('cnic'),
			'ntn' => $this->input->post('ntn'),
			'gst_no' => $this->input->post('gst_no'),
			'is_enable' =>  1,
			'modify_by' => $_SESSION['user_id'],
			'modify_at' => date('Y-m-d H:i:s')
		);
		$this->Commonmodel->Update_record('fran_profile', 'fr_id', $fr_id, $data); //Return from Franchisee Profile Table

		//Table Franischee Services
		//loop for selected services
		$fran_services = explode(",", $this->input->post('services'));
		$exist_services = array_column($this->Commonmodel->Get_record_by_double_condition_array('fran_services', 'fr_id', $fr_id, 'is_enable', 1), 'services_id', 'fran_services_id');
		foreach ($fran_services as $srv) {
			if (array_key_exists($srv, $exist_services)) {
				unset($exist_services[$srv]);
			} else {
				$data = array(
					'fr_id' => $fr_id,
					'services_id' => $srv,
					'is_enable' => 1,
					'created_by' => $_SESSION['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Commonmodel->Insert_record('fran_services', $data);
			}
		}

		foreach ($exist_services as $id => $value) {
			$data = array(
				'is_enable' => 0,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Update_record('fran_services', 'fran_services_id', $value, $data);
		}

		//Table Franchisee Rates
		// Delivery Loop for Locations		
		$fran_loc_chrgs = json_decode($this->input->post('loc_chrg'));
		$exist_chrgs = $this->Commonmodel->Get_record_by_triple_condition_array('fran_rates', 'fr_id', $fr_id, 'type', 1, 'is_enable', 1);
		$fran_exist_chrgs = array_column($exist_chrgs, 'min', 'loc_id');
		$fran_exist_id = array_column($exist_chrgs, 'fran_rates_id', 'loc_id');

		foreach ($fran_loc_chrgs as $key => $value) {
			if (array_key_exists($key, $fran_exist_chrgs)) {
				if ($fran_exist_chrgs[$key] != $value) {
					$data = array(
						'min' => $value,
						'modify_by' => $_SESSION['user_id'],
						'modify_at' => date('Y-m-d H:i:s')
					);
					$this->Commonmodel->Update_record('fran_rates', 'fran_rates_id', $fran_exist_id[$key], $data);
				}
				unset($fran_exist_chrgs[$key]);
				unset($fran_exist_id[$key]);
			} else {
				$data = array(
					'fr_id' => $fr_id,
					'loc_id' => $key,
					'type' => 1,
					'min' => $value,
					'max' => 0,
					'additional' => 0,
					'unit' => 1,
					'is_enable' => 1,
					'created_by' => $_SESSION['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Commonmodel->Insert_record('fran_rates', $data);

				$data = array(
					'fr_id' => $fr_id,
					'city_id' => $key,
					'reporting_loc' => $this->input->post('location'),
					'is_enable' => 1,
					'created_by' => $_SESSION['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Commonmodel->Insert_record('fran_locs', $data);
			}
		}

		foreach ($fran_exist_id as $key => $value) {
			$data = array(
				'is_enable' => 0,
				'modify_by' => $_SESSION['user_id'],
				'modify_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Update_record('fran_rates', 'fran_rates_id', $value, $data);
		}

		foreach ($fran_exist_chrgs as $key => $value) {
			$data = array(
				'is_enable' => 0,
				'modify_by' => $_SESSION['user_id'],
				'modify_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Update_double_record('fran_locs', 'fr_id', $fr_id, 'city_id', $key, $data);
		}

		//Weight
		if ($fr_wt_id > 0) {
			$data = array(
				'loc_id' => $this->input->post('location'),
				'min' => $this->input->post('weight_charges_min'),
				'max' => $this->input->post('weight_charges_max'),
				'additional' => $this->input->post('additional_weight_charges'),
				'modify_by' => $_SESSION['user_id'],
				'modify_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Update_record('fran_rates', 'fran_rates_id', $fr_wt_id, $data);
		} else {
			$data = array(
				'fr_id' => $fr_id,
				'loc_id' => $this->input->post('location'),
				'type' => 2,
				'min' => $this->input->post('weight_charges_min'),
				'max' => $this->input->post('weight_charges_max'),
				'additional' => $this->input->post('additional_weight_charges'),
				'unit' => 2,
				'is_enable' => 1,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Insert_record('fran_rates', $data);
		}


		//Table Route
		if ($fr_route_id > 0) {
			$data = array(
				'route_id' => $this->input->post('route'),
				'modify_by' => $_SESSION['user_id'],
				'modify_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Update_record('fran_route', 'fran_route_id', $fr_route_id, $data);
		} else {
			$data = array(
				'fr_id' => $fr_id,
				'route_id' => $this->input->post('route'),
				'is_enable' => 1,
				'created_by' => $_SESSION['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Commonmodel->Insert_record('fran_route', $data);
		}

		$message = "<p class='alert alert-success'>" . $this->input->post('name') . " is Updated.</p>";
		redirect(base_url() . 'Franchisee', $message);
	}
}
