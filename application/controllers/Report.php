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

    public function overnight_manifested()
	{
		$startdate 	  = $this->input->post('start_date');
		$enddate      = $this->input->post('end_date');
		if ($startdate != "" && $enddate != "") {
			$data['startdate']  = $startdate;
			$data['enddate']    = $enddate;
          $data['detail'] = $this->Commonmodel->Raw_Query_Execution("select o.order_code, o.manual_cn, date(o.order_date), date(o.order_arrival_date), date(t.transit_date), t.transit_code, c.customer_name, s.service_name, o.order_status, o.shipper_name, o.origin_city_name, o.consignee_name, o.destination_city_name, o.pieces, o.weight, o.order_total_amount, o.is_invoice, o.invoice_id, r.add_rate 
            from cargo.saimtech_order o
            left join cargo.saimtech_customer c on c.customer_id = o.customer_id
            left join cargo.saimtech_service s on s.service_id = o.order_service_type
            left join cargo.saimtech_transit_detail d ON d.transit_cn = o.order_code
            left join cargo.saimtech_transit_list t ON t.transit_list_id = d.transit_list_id
            left join accounts.acc_rates r ON r.rate_id = o.rate_id and date(o.order_date) between r.start_date and r.end_date
            where t.transit_route_id = 17
            and date(t.transit_date) between '$startdate' and '$enddate'
            and order_service_type <> 4 ");
			
		} else {
			$startdate 	       = date('Y-m-d', strtotime('-1 days'));
			$enddate           = date('Y-m-d');
			$data['startdate'] = $startdate;
			$data['enddate']   = $enddate;
        //   $data['detail'] = $this->Commonmodel->Raw_Query_Execution("select o.order_code, o.manual_cn, date(o.order_date), date(o.order_arrival_date), date(t.transit_date), t.transit_code, c.customer_name, s.service_name, o.order_status, o.shipper_name, o.origin_city_name, o.consignee_name, o.destination_city_name, o.pieces, o.weight, o.order_total_amount, o.is_invoice, o.invoice_id, r.add_rate 
        //     from cargo.saimtech_order o
        //     left join cargo.saimtech_customer c on c.customer_id = o.customer_id
        //     left join cargo.saimtech_service s on s.service_id = o.order_service_type
        //     left join cargo.saimtech_transit_detail d ON d.transit_cn = o.order_code
        //     left join cargo.saimtech_transit_list t ON t.transit_list_id = d.transit_list_id
        //     left join accounts.acc_rates r ON r.rate_id = o.rate_id and date(o.order_date) between r.start_date and r.end_date
        //     where t.transit_route_id = 17
        //     and date(t.transit_date) between '$startdate' and '$enddate'
        //     and order_service_type <> 4 ");
		}
        
     
		$this->load->view('overnightreport', $data);
	}
}
