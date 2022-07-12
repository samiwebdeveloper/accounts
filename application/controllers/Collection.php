<?php

class Collection extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Karachi');
		$this->load->model('Commonmodel');
		$this->load->model('Ccommonmodel');
		$this->load->model('Collectionmodel');
	}

	public function index()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collection";
		$data['event_name'] = "FOD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = date('Y-m-d');
		$startdate = '2022-03-01';
		//date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_FOD_to_collect($startdate, $enddate, $_SESSION['reporting_orign_id']);
		}
		$this->load->view('module_collection/fodView', $data);
	}

	public function collected()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collected";
		$data['event_name'] = "FDD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = date('Y-m-d');
		$startdate = date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_collected_fod($startdate, $enddate, $_SESSION['user_id'], $_SESSION['origin_id']);
		}
		$this->load->view('module_collection/fodcollectedView', $data);
	}

	public function collected_date_range()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collection";
		$data['event_name'] = "FOD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = $this->input->post('end_date');
		$startdate = $this->input->post('start_date');
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_collected_fod($startdate, $enddate, $_SESSION['user_id'], $_SESSION['origin_id']);
		}
		$this->load->view('module_collection/fodcollectedView', $data);
	}

	public function date_range()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collection";
		$data['event_name'] = "FOD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = $this->input->post('end_date');
		$startdate = $this->input->post('start_date');
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_FOD_to_collect($startdate, $enddate, $_SESSION['reporting_orign_id']);
		}
		$this->load->view('module_collection/fodView', $data);
	}

	public function cod_collection()
	{
		$order_id = $this->input->post('orderid');
		$cod_amt = $this->input->post('codamt');
		$data = array(
			'order_id' => $order_id,
			'collection' => $cod_amt,
			'user_id' => $_SESSION['user_id'],
			'location_id' => $_SESSION['origin_id'],
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		);

		$rtn = $this->Commonmodel->Insert_record('cod_collection', $data);
		echo $rtn;
	}

	public function cn_to_collect()
	{
		$cn = $this->input->get('cn');
		$rtn = $this->Collectionmodel->get_cn_to_collect($cn);
		echo json_encode($rtn);
	}

	public function submit_collection()
	{
		$collection_ids = explode(",", $this->input->post('collection_ids'));
		$to_submit_total = $this->input->post('to_submit_total');
		$submit_to = $this->input->post('submit_to');
		$rmks = $this->input->post('rmks');

		$sheet_id = 0;

		$sheet_code = $this->Collectionmodel->get_collect_sheet_code();
		$collection_code = str_pad($_SESSION['city_code'], 4, 0, STR_PAD_LEFT) . "-" . str_pad($sheet_code[0]->deposit_code, 6, 0, STR_PAD_LEFT) . "-" . str_pad($_SESSION['user_id'], 4, 0, STR_PAD_LEFT);

		$new_sheet_no = $sheet_code[0]->deposit_code + 1;

		$new_sheet_code = array(
			'deposit_code' => $new_sheet_no
		);

		$sheet_collection = array(
			'cod_sheet_no' => $collection_code,
			'total_cns' => count($collection_ids),
			'total_amt' => $to_submit_total,
			'submit_to' => $submit_to,
			'remarks' => $rmks,
			'user_id' => $_SESSION['user_id'],
			'location_id' => $_SESSION['origin_id'],
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->db->trans_start();
		$this->Commonmodel->Update_record('cargo.saimtech_order_code', 'id', 1, $new_sheet_code);
		$sheet_id = $this->Commonmodel->Insert_record('cod_sheet', $sheet_collection);
		foreach ($collection_ids as $cid) {
			$collection_update = array(
				'cod_sheet_id' => $sheet_id,
				'is_submitted' => 1
			);
			$this->Commonmodel->Update_record('cod_collection', 'cod_collection_id', $cid, $collection_update);
		}
		$this->db->trans_complete();

		echo $collection_code . "|" . $sheet_id;
	}

	public function submitted()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collected";
		$data['event_name'] = "FDD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = date('Y-m-d');
		$startdate = date('Y-m-d', strtotime('-2 day', strtotime($enddate)));
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_submitted_fod($startdate, $enddate, $_SESSION['user_id'], $_SESSION['origin_id']);
			$data['sheet'] = $this->Collectionmodel->Get_submitted_sheet($startdate, $enddate, $_SESSION['user_id'], $_SESSION['origin_id']);
		}
		$this->load->view('module_collection/fodsubmittedView', $data);
	}

	public function submitted_date_range()
	{
		$data['sub_nav_active'] = "Operations";
		$data['nav_active'] = "Collection";
		$data['event_name'] = "FOD";
		$data['start_date'] = "";
		$data['end_date'] = "";
		$enddate = $this->input->post('end_date');
		$startdate = $this->input->post('start_date');
		$data['start_date'] = $startdate;
		$data['end_date'] = $enddate;
		if ($_SESSION['user_power'] != "TP") {
			$data['cns_collect'] = $this->Collectionmodel->Get_submitted_fod($startdate, $enddate, $_SESSION['user_id'], $_SESSION['origin_id']);
		}
		$this->load->view('module_collection/fodsubmittedView', $data);
	}

	public function submit_preview($sheet_id)
	{
		$data['sheet'] = $this->Collectionmodel->get_sheet_preview($sheet_id);
		$data['cns_collect'] = $this->Collectionmodel->get_collection_preview($sheet_id);

		$this->load->view('module_collection/sheetpreview', $data);
	}

	public function discrepancy()
	{
		$data['discrepancy_collect'] = $this->Collectionmodel->get_discrepancy();

		$this->load->view('module_collection/discrepancyView', $data);
	}

	public function delivered()
	{
		$data['delivered_collect'] = $this->Collectionmodel->get_delivered_collection();

		$this->load->view('module_collection/deliveredcollectionView', $data);
	}

	public function undelivered()
	{
		$this->load->view('module_collection/undeliveredcollectionView');
	}
	public function undelivered_load()
	{
		$data['undelivered_collect'] = $this->Collectionmodel->get_undelivered_collection();
		echo json_encode($data['undelivered_collect']);
	}
}
