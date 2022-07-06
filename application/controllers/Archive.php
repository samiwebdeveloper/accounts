<?php

class Archive extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Archivemodel');
    $this->load->model('Commonmodel');
	}
    
    
    public function index(){
    $this->Archivemodel->Fill_Order_Archive();    
    }
    
    public function cp(){
    $this->Archivemodel->Fill_Order_Archive(); 
    echo("<center><p class='alert alert-success'>Order Archived successfully... Now Enjoy the System Speed.</p></center>");
    }
    
    public function cr_report(){
    $data['cr_origin']="";
    $data['cr_date']="";    
    $data['cn_data']="";
    $data['summary_data']="";
    $this->load->view('module_report/cramountView',$data);      
    }
    
    public function cr_report_submit(){
    $cr_date = $this->input->post('cr_date');
    $cr_origin = $this->input->post('cr_origin');
    $data['cr_origin']=$cr_origin;
    $data['cr_date']=$cr_date;    
    $data['cn_data']=$this->Commonmodel->Get_Depsoit_Detail_Cns($cr_date,$cr_origin);
    $data['summary_data']=$this->Commonmodel->Get_Depsoit_Detail_Sheet($cr_date,$cr_origin);    
    $this->load->view('module_report/cramountView',$data);      
    }
    
    
    
    
    public function crv_report(){
    $data['cr_origin']="";
    $data['cr_date']="";    
    $data['cn_data']="";
    $data['summary_data']="";
    $this->load->view('module_report/crvamountView',$data);      
    }
    
    public function crv_report_submit(){
    $cr_date = $this->input->post('cr_date');
    $cr_origin = $this->input->post('cr_origin');
    $data['cr_origin']=$cr_origin;
    $data['cr_date']=$cr_date;    
    $data['cn_data']=$this->Commonmodel->Get_Depsoit_Detail_Cns_CRV($cr_date,$cr_origin);
    $data['summary_data']=$this->Commonmodel->Get_Depsoit_Detail_Sheet_CRV($cr_date,$cr_origin);    
    $this->load->view('module_report/crvamountView',$data);      
    }
    
    public function crv_submit($sheetcode,$ddate,$routedate,$city){
    $this->Commonmodel->Update_CRV($sheetcode,$ddate,$routedate,$city);
    $cr_date = $ddate;
    $cr_origin = $_SESSION['origin_id'];
    $data['cr_origin']=$_SESSION['origin_id'];
    $data['cr_date']=$ddate;    
    $data['cn_data']=$this->Commonmodel->Get_Depsoit_Detail_Cns_CRV($cr_date,$cr_origin);
    $data['summary_data']=$this->Commonmodel->Get_Depsoit_Detail_Sheet_CRV($cr_date,$cr_origin);    
    $this->load->view('module_report/crvamountView',$data);      
    }
    
    
    public function crv_report_all(){
    $data['cr_origin']="";
    $data['cr_date']="";    
    $data['cn_data']="";
    $data['summary_data']="";
    $this->load->view('module_report/crvamountallView',$data);      
    }
    
    public function crv_report_submit_all(){
    $cr_date = $this->input->post('cr_date');
    $cr_origin = $this->input->post('cr_origin');
    $data['cr_origin']=$cr_origin;
    $data['cr_date']=$cr_date;    
    $cn_data=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_CRV($cr_date);
    $cn_archive_data=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_CRV_Archive($cr_date);
    $data['cn_data']=array_merge($cn_data,$cn_archive_data);
    $summary_data=$this->Commonmodel->Get_All_Depsoit_Detail_Sheet_CRV($cr_date);    
    $summary_archive_data=$this->Commonmodel->Get_All_Depsoit_Detail_Sheet_CRV_Archive($cr_date); 
    $data['summary_data']=array_merge($summary_data,$summary_archive_data);    
    $this->load->view('module_report/crvamountallView',$data);      
    }
    
    
    
    
    public function all_crv_report(){
    $data['cn_data']="";
    $data['start_data']="";
    $data['end_data']="";
    $this->load->view('module_report/crvreportView',$data);       
    }
    
    public function all_crv_submit_report(){
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    //$data['start_date']=$start_date;
    //$data['end_date']=$end_date;
    //$deposit_data=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts($start_date,$end_date);
    //$deposit_data_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_RTS($start_date,$end_date);
    //$deposit_data_Archive=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive($start_date,$end_date);
    //$deposit_data_Archive_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive_RTS($start_date,$end_date);
    $data['cn_data_archive']=$this->Commonmodel->Get_CRV_Summary_By_Date_Range_Archive($start_date,$end_date);
    $data['cn_data']=$this->Commonmodel->Get_CRV_Summary_By_Date_Range($start_date,$end_date);
   // print_r($this->Commonmodel->Get_CRV_Summary_By_Date_Range($start_date,$end_date));
    $this->load->view('module_report/crvreportView',$data);          
    }
    
    
    public function all_crv_pending_and_done_report(){
    $data['cn_data']="";
    $data['start_data']="";
    $data['end_data']="";
    $this->load->view('module_report/pdcrvreportView',$data);       
    }
    
    public function submit_all_crv_pending_and_done_report(){
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    //$data['start_date']=$start_date;
    //$data['end_date']=$end_date;
    //$deposit_data=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts($start_date,$end_date);
    //$deposit_data_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_RTS($start_date,$end_date);
    //$deposit_data_Archive=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive($start_date,$end_date);
    //$deposit_data_Archive_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive_RTS($start_date,$end_date);
    $data['cn_data_archive']=$this->Commonmodel->Get_CRV_Summary_By_Date_Range_Archive($start_date,$end_date);
    $data['cn_data']=$this->Commonmodel->Get_CRV_Summary_By_Date_Range($start_date,$end_date);
   // print_r($this->Commonmodel->Get_CRV_Summary_By_Date_Range($start_date,$end_date));
    $this->load->view('module_report/pdcrvreportView',$data);          
    }
    
    
    
    
    
    public function all_cr_report(){
    
    $data['cr_date']="";    
    $data['cn_data']="";
    $data['summary_data']="";
    $this->load->view('module_report/allcramountView',$data);      
    }
    
    public function all_cr_report_submit(){
    $cr_date = $this->input->post('cr_date');
    $data['cr_date']=$cr_date;    
    $data['cn_data']=$this->Commonmodel->Get_All_Depsoit_Detail_Cns($cr_date);
    $data['summary_data']=$this->Commonmodel->Get_All_Depsoit_Detail_Sheet($cr_date);    
    $this->load->view('module_report/allcramountView',$data);      
    }
   
   
   
    public function dcr_report(){
    $data['cn_data']="";
    $data['start_data']="";
    $data['end_data']="";
    $this->load->view('module_report/dcramountView',$data);      
    }
    
    
    
    public function dcr_report_submit(){
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $data['start_date']=$start_date;
    $data['end_date']=$end_date;
    $deposit_data=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts($start_date,$end_date);
    $deposit_data_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_RTS($start_date,$end_date);
    $deposit_data_Archive=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive($start_date,$end_date);
    $deposit_data_Archive_RTS=$this->Commonmodel->Get_All_Depsoit_Detail_Cns_Accounts_Archive_RTS($start_date,$end_date);
    $data['cn_data']=array_merge($deposit_data, $deposit_data_RTS,  $deposit_data_Archive,  $deposit_data_Archive_RTS);
    $this->load->view('module_report/dcramountView',$data);      
    }
    
    
    public function expense_report(){
    $data['expense_data']="";
    $data['start_data']="";
    $data['end_data']="";
    $this->load->view('module_report/expenseView',$data);      
    }
    
    public function expense_report_submit(){
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $data['start_date']=$start_date;
    $data['end_date']=$end_date;
    $data['expense_data']=$this->Commonmodel->Get_All_Expense_Detail($start_date,$end_date);
    $this->load->view('module_report/expenseView',$data);      
    }
   
   
    public function cpay_report(){
    $data['cpay_data']="";
    $data['start_data']="";
    $data['end_data']="";
    $this->load->view('module_report/cpayView',$data);      
    }
    
    public function cpay_report_submit(){
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $data['start_date']=$start_date;
    $data['end_date']=$end_date;
    $data['cpay_data']=$this->Commonmodel->Get_All_Cpay_Detail($start_date,$end_date);
    $this->load->view('module_report/cpayView',$data);   }   
    
    
 }

?>