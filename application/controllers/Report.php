<?php
class Report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Karachi');
        $this->load->model('Commonmodel');
        $this->load->model('Reportmodel');
    }
      public function customer_aging_report()
    {
        $dc_summary['hsummary'] = $this->Reportmodel->get_aging_report();
        $dc_summary['hmonth'] = $this->Reportmodel->get_aging_report_month();
        $this->load->view('module_invoice/agingreportView', $dc_summary);
    }	
}
