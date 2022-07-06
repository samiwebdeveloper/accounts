<?php

class  InvoiceRules extends CI_Controller {

 	function __construct() {
     parent::__construct();
     date_default_timezone_set('Asia/Karachi');
     $this->load->model('InvoiceRulesModel');
     }


    public function index()
    {
        $data['sub_nav_active']="Accounts";
        $data['nav_active']="InvoiceRules";
        $data['event_name']="InvoiceRules";
        
        $enddate=date('Y-m-d');
        $startdate=date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
        $data['startdate']=$startdate;
        $data['enddate']=$enddate;
        $data['customer_id'] = -1;
        $data['invoice_rule_customer_id'] = -1;
        $_SESSION['invoice_rule_customer_id']=-1;
        $data['customer_list']=$this->InvoiceRulesModel->getActiveCustomer();
        $_SESSION['active_customer_list']=$data['customer_list'];
        $this->load->view('module_invoice_rules/InvoiceRulesListVeiw',$data);	
    }
    
    public function getActiveCustomersList(){
        
        $active_customer_list = $_SESSION['active_customer_list'];
        
        if ($active_customer_list == ""){
            $active_customer_list=$this->InvoiceRulesModel->getActiveCustomer();
        }

        return $active_customer_list;
    }
    
    public function getCustomersName($customer_id){
        
        $active_customer_list = $_SESSION['active_customer_list'];
        
        if ($active_customer_list == ""){
            $active_customer_list=$this->InvoiceRulesModel->getActiveCustomer();
        }
        
        $active_customer_name = "";
        if(!empty($active_customer_list)){
            foreach($active_customer_list as $rows){
                if ($rows->id == $customer_id)
                {
                    $active_customer_name = $rows->name . "(" . $rows->city .")";
                }
                //echo("<option value='" .$rows->id."' ".(($rows->id == $customerid) ? 'selected' : '').">".$rows->name." </option>");
            }
        }
        
        return $active_customer_name;
    }
    
    public function get_customer_invoice_rules(){
        $customer_id = $this->input->post('customer');
        $data['customer_list']=$this->getActiveCustomersList();
        $data['customer_id'] = $customer_id;
        $_SESSION['invoice_rule_customer_id']=$customer_id;
        if($customer_id!="")
        {
            $data['invoice_rule_list']=$this->InvoiceRulesModel->getInvoiceRulesListByCustomer($customer_id);
            $data['customer_name'] = $this->getCustomersName($customer_id);
        }
        
        $this->load->view('module_invoice_rules/InvoiceRulesListVeiw',$data);
    }
    
    
    public function get_customer_invoice_rule_details($customer_id, $invoice_rule_id){
        
        if($customer_id!=-1 && $invoice_rule_id!="")
        {
            $data['customer_name'] = $this->getCustomersName($customer_id);
            $data['customer_id']=$customer_id;
            $data['invoice_rule_id']=$invoice_rule_id;
            $data['invoice_rule_details']=$this->InvoiceRulesModel->getInvoiceRuleDetailsByCustomer($customer_id, $invoice_rule_id);
        }
        
        $this->load->view('module_invoice_rules/InvoiceRuleVeiw',$data);
    }
    
    public function new_customer_invoice_rule_details(){

        $customer_id = $this->input->post('customer');
        $invoice_rule_id = -1;
        
        if($customer_id!="")
        {
            $data['customer_name'] = $this->getCustomersName($customer_id);
            $data['customer_id']=$customer_id;
            $data['invoice_rule_id']=$invoice_rule_id;
            $data['invoice_rule_details']=$this->InvoiceRulesModel->getInvoiceRuleDetailsByCustomer($customer_id, $invoice_rule_id);
        }
        
        $this->load->view('module_invoice_rules/InvoiceRuleVeiw',$data);
    }
    
    public function save_customer_invoice_rule_details(){
        
       
        $customer_id = $this->input->post('customer_id');
       
        $invoice_rule_id = $this->input->post('invoice_rule_id');
        $version_no = $this->input->post('version_no');
        $invoice_rule_name = $this->input->post('invoice_rule_name');
        $invoice_rule_json = $this->input->post('invoice_rule_json');
        $invoice_rule_sql = $this->input->post('invoice_rule_sql');
        $is_cancel = $this->input->post('is_cancel');
        $modified_by = $_SESSION['user_id'];
        
        
        if($customer_id!="" && $invoice_rule_id!="")
        {

            if($is_cancel ==0){
                $this->InvoiceRulesModel-> saveCustomerInvoiceRuleDetails($customer_id, $invoice_rule_id, $version_no, $invoice_rule_name, $invoice_rule_json, $invoice_rule_sql, $modified_by);
            }
            $data['customer_list']=$this->getActiveCustomersList();
            $data['customer_id'] = $customer_id;
            $data['customer_name'] = $this->getCustomersName($customer_id);
            $data['invoice_rule_list']=$this->InvoiceRulesModel->getInvoiceRulesListByCustomer($customer_id);
            
        }
        
        $this->load->view('module_invoice_rules/InvoiceRulesListVeiw',$data);
    } 
    
}