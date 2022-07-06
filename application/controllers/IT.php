<?php

class IT extends CI_Controller {

	function __construct() {
    parent::__construct();
    $this->load->model('Commonmodel');
    $this->load->model('Customermodel');
    $this->load->model('Mailmodel');
    $this->load->model('Archivemodel');
    $this->load->model('Arrivalmodel');
    $this->load->model('Baggingmodel');
    $this->load->model('Loadingmodel');
    $this->load->model('Deliverymodel');
    }


	
	public function Clone_customers(){
	$customer_id=0;
	$old_portal_customer=$this->Commonmodel->Get_all_record('login');
	if(!empty($old_portal_customer)){
	foreach($old_portal_customer as $rows){
	$this->db->trans_start();	    
	$city_date=$this->Commonmodel->Get_record_by_condition_array('saimtech_city', 'city_code', $rows->city_code);
	$cityid=$city_date[0]['city_id'];
	//--------INSERT INTO Saimtech_Customer
	//SELECT `id`, `account_no`, `account_title`, `username`, `password`, `area`, `contact_no`, `other_contact_no`, `address`, `company_name`, `iban_no`, `ntn_no`, `stn_no`, `url`, `product`, `cnic_no`, `email`, `country_id`, `state_id`, `city_id`, `city_code`, `account_start_code`, `account_end_code`, `total_booking`, `booking_start_code`, `booking_end_code`, `special_handling`, `api_key`, `expiry_date`, `user_type`, `ip_address`, `password_decrpyt`, `is_enable`, `verify_key`, `last_login`, `last_logout`, `last_action`, `created_date`, `created_by`, `modify_date`, `modify_by` FROM `login` WHERE 1
	$gst=16;
	if($rows->city_code=='21'){
	$gst=13;   
	} else if($rows->city_code=='511'){
	$gst=15;
	} else if($rows->city_code=='91'){
	$gst=15;
	}
	$bank=substr($rows->iban_no, 4, 4);
	$data = array(
	'old_portal_id'                 => $rows->id, 
	'customer_name'                 => $rows->username,
	'customer_contact'              => $rows->contact_no,
	'customer_contact2'             => $rows->email,
	'customer_address'              => $rows->address,
	'customer_city'                 => $cityid,
	'customer_cnic'                 => $rows->cnic_no,
	'customer_ntn'                  => $rows->ntn_no,
	'customer_bank'                 => $bank,
	'customer_bank_account_title'   => $rows->username,
	'customer_bank_account_no'      => $rows->iban_no,
	'customer_iban'                 => $rows->iban_no,
	'customer_url'                  => "http://".$rows->url,
	'customer_note'                 => 'Clone From OLD PORTAL',
	'handling_limit'                => '500000',
	'customer_product_type'         => $rows->product,
	'customer_pickup_points'        => '5',
	'customer_account_type'         => 'NW',
	'gst'                           => $gst,
	'is_enable'                     => 1,
	'api_key'                       => uniqid(),
	'reference_by'                  => 1,
	'secondary_reference_by'        => 1,
	'created_by'                    => 7,
	'created_date'                  => $rows->created_date,
	'modify_by'                     => 7,
	'modify_date'                   => $rows->modify_date
	);	
	$customer_id=$this->Commonmodel->Insert_record('saimtech_customer',$data);
	//=====================================
	//--------INSERT INTO Saimtech_User
	$data = array(
	'user_name'         =>strtoupper($rows->username), 
	'account_no'        =>$rows->account_no, 
	'user_password'     =>$rows->password_decrpyt, 
	'user_power'        =>'AGENT',
	'user_city'         =>$cityid, 
	'is_enable'         =>1,
	'customer_id'       =>$customer_id, 
	'last_login'        =>'0000-00-00', 
	'last_logout'       =>'0000-00-00', 
	'created_date'      =>$rows->created_date, 
	'created_by'        =>7,
	'modify_date'       =>date('Y-m-d H:i:s'), 
	'modify_by'         =>7 
	);	
	$user_id=$this->Commonmodel->Insert_record('saimtech_user', $data);
	//=====================================
	//--------INSERT INTO Saimtech_Rate
	$wc_date=$this->Commonmodel->Get_record_by_double_condition_array('user_service_list', 'user_service_code', 'sc', 'user_id', $rows->id);
	$dz_date=$this->Commonmodel->Get_record_by_double_condition_array('user_service_list', 'user_service_code', 'dz', 'user_id', $rows->id);
	$sz_date=$this->Commonmodel->Get_record_by_double_condition_array('user_service_list', 'user_service_code', 'sz', 'user_id', $rows->id);
	//`weight1`, `weight2`, `rate1`, `rate2`, `additional_weight`, `additional_rate`, `total_rate`, `gst`, `total_gst`, `fuel`, `total_fuel`, `other_charges`, `handling_charges`, `total_price`, `return_charges`, `user_id`, `user_type`, `is_enable`, `created_date`, `created_by`, `modify_date`, `modify_by`
	$data = array(
	'customer_id'           =>$customer_id, 
	'service_id'            =>1, 
	'sc_wgt1'               =>$wc_date[0]['weight1'], 
	'sc_rate1'              =>$wc_date[0]['rate1'], 
	'sc_wgt2'               =>$wc_date[0]['weight2'], 
	'sc_rate2'              =>$wc_date[0]['rate2'], 
	'sc_add_wgt'            =>$wc_date[0]['additional_weight'], 
	'sc_add_rate'           =>$wc_date[0]['additional_rate'],
	'sc_gst_rate'           =>$wc_date[0]['gst'], 
	'sc_fuel_formula'       =>'PER', 
	'sc_fuel_rate'          =>$wc_date[0]['fuel'], 
	'sc_sp_handling_formula'=>'PER',
	'sc_sp_handling_rate'   =>0, 
	'sc_return_formula'     =>'PER', 
	'sc_return_rate'        =>0, 
	'sz_wgt1'               =>$sz_date[0]['weight1'], 
	'sz_rate1'              =>$sz_date[0]['rate1'], 
	'sz_wgt2'               =>$sz_date[0]['weight2'], 
	'sz_rate2'              =>$sz_date[0]['rate2'],
	'sz_add_wgt'            =>$sz_date[0]['additional_weight'], 
	'sz_add_rate'           =>$sz_date[0]['additional_rate'], 
	'sz_gst_rate'           =>$sz_date[0]['gst'],
	'sz_fuel_formula'       =>'PER',
	'sz_fuel_rate'          =>$sz_date[0]['fuel'],
	'sz_sp_handling_formula'=>'PER',
	'sz_sp_handling_rate'   =>0,
	'sz_return_formula'     =>'PER', 
	'sz_return_rate'        =>0, 
	'dz_wgt1'               =>$dz_date[0]['weight1'], 
	'dz_rate1'              =>$dz_date[0]['rate1'], 
	'dz_wgt2'               =>$dz_date[0]['weight2'], 
	'dz_rate2'              =>$dz_date[0]['rate2'], 
	'dz_add_wgt'            =>$dz_date[0]['additional_weight'], 
	'dz_add_rate'           =>$dz_date[0]['additional_rate'], 
	'dz_fuel_formula'       =>'PER', 
	'dz_fuel_rate'          =>$dz_date[0]['fuel'],
	'dz_sp_handling_formula'=>'PER', 
	'dz_sp_handling_rate'   =>0, 
	'dz_gst_rate'           =>$dz_date[0]['gst'], 
	'dz_return_formula'     =>'PER', 
	'dz_return_rate'        =>0, 
	'cash_handling_formula' =>'PER', 
	'cash_handling_rate'    =>0, 
	'reference_formula'     =>'PER', 
	'reference_rate'        =>0, 
	'flyer_rate'            =>15, 
	'is_enable'             =>1, 
	'deactive_date'         =>'0000-00-00 00:00:00', 
	'delete_date'           =>'0000-00-00 00:00:00', 
	'created_by'            =>7, 
	'created_date'          =>$rows->created_date, 
	'modify_by'             =>7, 
	'modify_date'           =>$rows->modify_date, 
	);	
	$rate_id=$this->Commonmodel->Insert_record('saimtech_rate', $data);
	echo("<br>");
	echo($rows->username."   Done");
	//=====================================
	//--------DELETE From Login
	$this->Commonmodel->Delete_record('login', 'id', $rows->id);
	//=====================================
	$this->db->trans_complete();
	}  
	} else {
	echo("<center>No data found for clone. :(</center>");   
	}
	}
	
	
	
	
	
	
	public function index(){
	echo substr("PK20SCBL0000001994998401", 4, 4);
	}


    public function tm_api(){
    $cn_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_order', 'thrid_party_name', 'TM','thrid_party_status','N/A');
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    public function b_tm_api(){
    $cn_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_archive_order', 'thrid_party_name', 'TM','thrid_party_status','N/A');
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_not_delivered(){
    $cn_data=$this->Commonmodel->Get_Not_Deliverd_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_booked(){
    $cn_data=$this->Commonmodel->Get_Booked_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
    echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_b_booked(){
    $cn_data=$this->Commonmodel->Get_B_Booked_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
    echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    
    
     public function tm_api_refused(){
    $cn_data=$this->Commonmodel->Get_Refused_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    public function tm_api_b_refused(){
    $cn_data=$this->Commonmodel->Get_B_Refused_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_ras(){
    $cn_data=$this->Commonmodel->Get_RAS_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    public function tm_api_b_ras(){
    $cn_data=$this->Commonmodel->Get_B_RAS_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_delivered(){
    $cn_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_order', 'thrid_party_name', 'TM','thrid_party_status','Delivered');
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function b_tm_api_delivered(){
    $cn_data=$this->Commonmodel->Get_record_by_double_condition('saimtech_archive_order', 'thrid_party_name', 'TM','thrid_party_status','Delivered');
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    
    public function tm_api_Transit(){
    $cn_data=$this->Commonmodel->Get_Transit_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
    
    public function tm_api_b_Transit(){
    $cn_data=$this->Commonmodel->Get_B_Transit_TM_CN();
    if(!empty($cn_data)){
    foreach($cn_data as $rows){    
   echo $str    = $rows->thrid_party_cn;
    $NEW    = explode("-",$str);    
    $cn     = $NEW[2];
    $code   = $NEW[0]."-".$NEW[1];
    $url    = "https://tmcargo.net/dashboard/getStatus.php?code=".$code."&cn=".$cn; 
	$ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    if($result!="Invalid CN" && $result!="Something is Missing" && $result!=""){
    $data = array('thrid_party_status' => $result);
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    } else if($result==""){
    $data = array('thrid_party_status' => 'N/A');
     $this->Commonmodel->Update_record('saimtech_archive_order', 'thrid_party_cn', $str,$data);    
    }
    }
    } else {
    echo "No Data Require";    
    }
    }
    
	

    public function not_deliverd_cns(){
    $db_date=$this->Mailmodel->Get_not_deliverd_cns_send_date();    
    $date_raw=date('Y-m-d');
    $prev_date=date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));    
    if($db_date!=$prev_date){
    $data['report_data']=$this->Mailmodel->Get_Invoice_Data_By_Date_Range($prev_date);
    $data['rdate']=$prev_date;
    $udata= array(
    'not_deliverd_cns' => $prev_date    
    );
    $this->Commonmodel->Update_record('saimtech_mail_sender', 'mail_sender_id', 1, $udata);
    $msg=$this->load->view('mailView',$data,true);
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
  	$this->load->library('email');
  	$this->email->initialize($config);
    $this->email->from('ops@delex.pk', 'Delex AI Center');
    $this->email->to('humair.yousaf@tmcargo.net,danish.mehmood@tmcargo.net');
    $this->email->cc('muhammad.saim@tmcargo.net,waseem.beg@tmcargo.net');
    $this->email->subject($prev_date.' Not Delivered CNS');
    $this->email->message($msg);
    $this->email->send();
    echo("Mail Sended");}
    else {
    echo("Mail Already Send");    
    }    
        
    }    
    
    public function deliverd_cns(){
    $url = "https://delex.com.pk/Web/cr_amount_data";
	//Curl Start
	$ch  =  curl_init();
	$timeout  =  30;
	curl_setopt ($ch,CURLOPT_URL, $url) ;
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
	$response = curl_exec($ch) ;
	curl_close($ch) ; 
	//Write out the response
    $json_data          = json_decode($response); 
   
    $db_date=$this->Mailmodel->Get_deliverd_cns_send_date();    
    $date_raw=date('Y-m-d');
    $prev_date=date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));    
    if($db_date!=$prev_date){
    $data['report_data']=$this->Mailmodel->Get_deliverd_cns_send_data($prev_date);
    $data['rdate']=$prev_date;
     $data['old_report_data']=$json_data;
    $udata= array(
    'deliver_cn_date' => $prev_date    
    );
    $this->Commonmodel->Update_record('saimtech_mail_sender', 'mail_sender_id', 1, $udata);
    $msg=$this->load->view('mailGDCSDView',$data,true);
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
  	$this->load->library('email');
  	$this->email->initialize($config);
    $this->email->from('ops@delex.pk', 'Delex AI Center');
    $this->email->to('waseem.beg@tmcargo.net,mirza.abbas@tmcargo.net,ehsan@tmcargo.net');
    $this->email->cc('muhammad.saim@tmcargo.net');
    $this->email->subject($prev_date.' Both Portal Delivered CNS');
    $this->email->message($msg);
    $this->email->send();
    echo("Mail Sended");
      $this->load->view('mailGDCSDView',$data);       
        
    }
    else {
    echo("Mail Already Send");    
    }    
   
    }    


    public function daily_arrival_cns(){
        echo $db_date=$this->Mailmodel->Get_Mail_Date();
        $date_raw=date('Y-m-d');
        $prev_date=date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));
        //$prev_date='2020-07-18';
        $month_prev_date=date('m', strtotime('-1 day', strtotime($prev_date)));
        if($db_date!=$prev_date){
        $data=array('arrival_mail_date' => $prev_date);    
        $this->Commonmodel->Update_record('saimtech_mail_sender', 'mail_sender_id', '1', $data);    
        $Current_arrival_date=$this->Mailmodel->Get_Daily_Arrival_Report($prev_date,$month_prev_date);
        $data['report_data']=$Current_arrival_date;
        //$data['delivery_report_data']=$this->Mailmodel->Get_Daily_Delivery_Report($prev_date,$month_prev_date);
        //$data['rts_report_data']=$this->Mailmodel->Get_Daily_RTS_Report($prev_date,$month_prev_date);
        $msg=$this->load->view('arrivalmailView',$data,true);
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
  	    $this->load->library('email');
  	    $this->email->initialize($config);
        $this->email->from('delex@delex.pk', 'Delex AI ');
        $this->email->to('waseem.beg@tmcargo.net,javed.akhtar@tmcargo.net, abid.choudhary@tmcargo.net, ehsan@tmcargo.net');
        //$this->email->to('waseem.beg@tmcargo.net');
        $this->email->cc('muhammad.saim@tmcargo.net');
        $this->email->subject('Daily Arrival Report '.$prev_date);
        $this->email->message($msg);
        $this->email->send();
        $this->load->view('arrivalmailView',$data);
        } else {
        echo("Mail Already Send");    
        } 
        $data['report_data']=$this->Mailmodel->Get_Daily_Arrival_Report($prev_date,$month_prev_date);
        //$data['delivery_report_data']=$this->Mailmodel->Get_Daily_Delivery_Report($prev_date,$month_prev_date);
        //$data['rts_report_data']=$this->Mailmodel->Get_Daily_RTS_Report($prev_date,$month_prev_date);
        $this->load->view('arrivalmailView',$data);
       }
       
       public function check_date(){
       echo $db_date=$this->Mailmodel->Get_Mail_Date();    
       }
       
       
    public function cpanel(){
    $data['order_archive_num']  =$this->Archivemodel->Pendding_Archive();
    $data['arrival_archive_num']=$this->Arrivalmodel->Pendding_Archive();
    $data['bagging_archive_num']=$this->Baggingmodel->Pendding_Archive();
    $data['loading_archive_num']="0";
    $data['delivery_archive_num']=$this->Deliverymodel->Pendding_Archive();
    $this->load->view('module_IT/itView',$data);	    
    }
    
    public function delivery_rider(){
    $this->Deliverymodel->Update_Delivery_Riders();
    echo("<p class='alert alert-success'>Done Riders Updated</p>");
    }
	
	
	public function pickup_rider(){
    $this->Arrivalmodel->Update_Pick_Riders();
    echo("<p class='alert alert-success'>Done Pickup Riders Updated</p>");
    }
	
    
    public function Get_So_Kamal_QSR(){
    $results=$this->Commonmodel->Get_So_Kamal_QSR();   
    $myJSON = json_encode($results);
    echo $myJSON; 
    }
    
    
    public function change_weight_destination(){
    $this->load->view('module_IT/wdView',$data);    
    }

    public function change_weight_destination_submit(){
        
    }
    
    public function change_weight_process(){
        
    }
	
}
