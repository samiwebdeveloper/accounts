<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	class Home extends CI_Controller {
		
		function __construct() {
			parent::__construct();
			$this->load->model('Commonmodel');
			$this->load->model('Bookingmodel');
		}
		
		
		public function index(){
			
			$data['cns']=$this->Bookingmodel->Get_CNs_to_Hard_Check_Summary();
			$data['chkd_cns']=$this->Bookingmodel->Get_CNs_Hard_Checked_Summary();
			$this->load->view('dashboardView',$data);
		}
		
		public function mail(){
			$this->load->view('module_report/inboxView');	        
		}
		
		
		public function setting_view(){
			$data['msg']="";	
			$this->load->view('module_report/settingView',$data);		
		}
		
		public function submit_setting(){
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			$retype_password = $this->input->post('retype_password');
			$db_password  = "";
			if($old_password!="" && $new_password!="" && $retype_password!=""){
				$db_data=$this->Commonmodel->Get_record_by_condition('acc_oper_user', 'oper_user_id', $_SESSION['user_id']);
				if(!empty($db_data)){foreach($db_data as $rows){$db_password=$rows->oper_user_password;}}
				if($db_password==md5($old_password)){
					if($new_password==$retype_password){
						$data = array('oper_user_password' => md5($new_password));	
						$this->Commonmodel->Update_record('acc_oper_user', 'oper_user_id', $_SESSION['user_id'], $data);
						$data['msg']="<p class='alert alert-success'>Your password is successfully changed.</p>";
					} else { $data['msg']="<p class='alert alert-danger'>Retype password not matched.</p>";}
				} else { $data['msg']="<p class='alert alert-danger'>Incorrect old password.</p>";}
			} else { $data['msg']="<p class='alert alert-danger'>Something is missing please try again.</p>";}	
			$this->load->view('module_report/settingView',$data);		
		}
	}
