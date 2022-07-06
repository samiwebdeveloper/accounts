<?php

class Invoices extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Karachi');
        $this->load->model('Commonmodel');
        $this->load->model('Invoicesmodel');
    }

    public function index()
    {
        // echo($_SESSION['origin_id']);
        $data['sub_nav_active'] = "Accounts";
        $data['nav_active'] = "Invoice";
        $data['event_name'] = "Invoice";
        $enddate = date('Y-m-d');
        $startdate = date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['invoice_data'] = $this->Invoicesmodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
        $this->load->view('module_invoices/invoiceView', $data);
    }

    public function getCityList()
    {
        $active_city_list = $_SESSION['active_city_list'];

        if ($active_city_list == "") {
            $active_city_list = $this->Invoicesmodel->getCityList();
        }

        return $active_city_list;
    }

    public function getCityJson()
    {
     
        
        
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(500)
        ->set_output(json_encode($this->getCityList()));
    }
    public function in_payment()
    {
        // echo($_SESSION['origin_id']);
        $data['sub_nav_active'] = "Accounts";
        $data['nav_active'] = "Invoice";
        $data['event_name'] = "Invoice";
        $enddate = date('Y-m-d');
        $startdate = date('Y-m-d', strtotime('-15 day', strtotime($enddate)));
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['invoice_data'] = $this->Invoicesmodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
        $this->load->view('module_invoices/invoice2View', $data);
    }

    public function in_payment_submit()
    {
        $startdate = $this->input->post('start_date');
        $enddate = $this->input->post('end_date');
        if ($startdate != "" && $enddate != "") {
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['invoice_data'] = $this->Invoicesmodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
        } else {
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['invoice_data'] = "";
        }
        $this->load->view('module_invoices/invoice2View', $data);
    }

    public function create_invoice()
    {
        //$data['invoice_code'] = $this->get_invoice_sheet_code();
        $data['customer_data'] = $this->Invoicesmodel->Get_Invoice_Active_Customer();
        $data['city_data'] = $this->getCityList();
        $this->load->view('module_invoices/invoicecreateView', $data);
    }

    public function consignment_details()
    {
        $data['invoice_code'] = $this->get_invoice_sheet_code();
        // $data['customer_data']=$this->Invoicesmodel->Get_Invoice_Active_Customer();
        $this->load->view('module_invoices/consignmentDetailsView', $data);
    }

    public function date_range()
    {
        $startdate = $this->input->post('start_date');
        $enddate = $this->input->post('end_date');
        if ($startdate != "" && $enddate != "") {
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['invoice_data'] = $this->Invoicesmodel->Get_Invoice_Data_By_Date_Range($startdate, $enddate);
        } else {
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['invoice_data'] = "";
        }
        $this->load->view('module_invoices/invoiceView', $data);
    }

    public function unpaid_cn()
    {
        $data['deliverd_data'] = $this->Invoicesmodel->Get_Unpaid_Summary_Customer_Wise_Delivered($_SESSION['origin_id']);
        $data['rts_data'] = $this->Invoicesmodel->Get_Unpaid_Summary_Customer_Wise_RTS($_SESSION['origin_id']);
        $this->load->view('module_invoices/unpaidinvoiceView', $data);
    }

    public function unpaid_cn_all()
    {
        // $data['deliverd_data']=$this->Invoicesmodel->Get_All_Unpaid_Summary_Customer_Wise_Delivered();
        $data['deliverd_data'] = $this->Invoicesmodel->Get_All_Unpaid_Summary_Customer_Wise_Delivered_And_RTS();
        // $data['rts_data']=$this->Invoicesmodel->Get_All_Unpaid_Summary_Customer_Wise_RTS();
        $this->load->view('module_invoices/unpaidinvoiceView', $data);
    }

    public function uninvoiced_cn_all()
    {
        // $data['deliverd_data']=$this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_All();
        $data['deliverd_data'] = $this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS_All();
        // $data['rts_data']=$this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_RTS_All();
        $this->load->view('module_invoices/unpaidinvoicedetailView', $data);
    }

    public function unpaid_cn_all_detail($cid)
    {
        // $data['deliverd_data']=$this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered($cid);
        $data['deliverd_data'] = $this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS($cid);
        // $data['rts_data']=$this->Invoicesmodel->Get_All_Unpaid_Detail_Customer_Wise_RTS($cid);
        $this->load->view('module_invoices/unpaidinvoicedetailView', $data);
    }

    public function cn_data_list()
    {
        $customer = $this->input->post('customer');
        $customer_name = $this->input->post('customer_name');
        $gst = $this->input->post('gst');
        $destination = $this->input->post('destination');
        $origin = $this->input->post('origin');
        $invoice_code = $this->get_invoice_sheet_code();//$this->input->post('invoice_code');
        $invoice_date = $this->input->post('invoice_date');
        $invoice_date_f = $this->input->post('invoice_date_f');
        if ($customer != "" && $invoice_code != "" && $invoice_date != "" && $invoice_date_f != "") {
            
            $this->cal_index($customer); // Calculation of Rates and other things
            
            $data = array(
                'is_temp_invoice' => 0
            );
            $this->Commonmodel->Update_record('saimtech_order', 'is_temp_invoice', $invoice_code, $data);
            // $customer_data=$this->Invoicesmodel->Get_CN_BY_Customer_ID_And_Date($customer,$invoice_date,$invoice_date_f);
            $customer_data = $this->Invoicesmodel->Get_CN_BY_Customer_ID_Location_And_Date($customer, $invoice_date, $invoice_date_f, $origin, $destination);

            $isEmpty =  empty($customer_data);
                
                //echo ("<div class='panel-group'>");
                echo ("<div class='card'>");//echo ("<div class='panel panel-default'>");
                echo ("<div class='card-header'>");//echo ("<div class='panel-heading'>");
                //echo ("<h4 class='panel-title'>");
                echo ("<a data-toggle='collapse' href='#collapse".$customer."'><i class='fa fa-angle-right'></i> ".$invoice_code." | ".$customer_name." | PERMISSION With GST(" .$gst. ") </a>");
                echo ("<input type='hidden' id='invoice_".$customer."' name='invoice_".$customer."' value='" .$invoice_code. "'/>");
                echo ("<input type='hidden' id='gst_".$customer."' name='gst_".$customer."' value='".$gst."'/>");
                echo ("<input type='hidden' id='isValid_".$customer."' name='gst_".$customer."' value='".(($isEmpty)?(0):(1))."'/>");
                //echo ("</h4>");
                echo ("</div>");
                echo ("<div id='collapse".$customer."' class='collapse'>"); //echo ("<div id='collapse".$customer."' class='panel-collapse collapse'>");
                echo ("<div class='card-body'>");
                echo ("<table class='table table-bordered table-sm table-hover table-striped' id='data_panel'>");
                echo ("<thead class='thead-dark' style='position:sticky;'>");
                echo ("<tr>");
                echo ("<th>Sr</th>");
                echo ("<th>Date</th>");
                echo ("<th>CN</th>");
                echo ("<th>Origin</th>");
                echo ("<th>Dest</th>");
                echo ("<th>Consignee</th>");
                echo ("<th>Pcs</th>");
                echo ("<th>Weigh</th>");
                echo ("<th>Sc</th>");
                echo ("<th>OSA/SD</th>");
                //echo ("<th>Action</th>");
                echo ("</tr>");
                echo ("</thead>");
                echo ("<tbody id='autoload".$customer."'>");
                
				$total_sc = 0;
                $total_osa_sd = 0;
                $total_pieces = 0;
                $total_weight = 0;
                
				if (!$isEmpty) {
                
                $i = 0;
                
                    foreach ($customer_data as $rows) {
                        
                        $i = $i + 1;
                        $data = array(
                            'is_temp_invoice' => $invoice_code
                        );
                        $this->Commonmodel->Update_record('saimtech_order', 'order_id', $rows->order_id, $data);
     
                        echo ("<tr>");
                        echo ("<td class='text-right'>" . $i . "</td>");
                        echo ("<td>" . $rows->order_date . "</td>");
                        echo ("<td class='text-right'>" . $rows->order_code . "</td>");
                        echo ("<td>" . $rows->origin_city_name . "</td>");
                        echo ("<td>" . $rows->destination_city_name . "</td>");
                        echo ("<td>" . $rows->consignee_name . "</td>");
                        echo ("<td class='text-right'>" . $rows->pieces . "</td>");
                        echo ("<td class='text-right'>" . ceil($rows->weight) . "</td>");
                        echo ("<td class='text-right'>" . round($rows->order_sc) . "</td>");
                        echo ("<td class='text-right'>" . round($rows->order_osa_sd_total) . "</td>");
                        //echo ("<td><button onclick='remove_from_invoice(" . $rows->order_code . ")' class='btn btn-danger btn-sm'>Release</button></td>");
                        echo ("</tr>");
                        
                        $total_pieces+=$rows->pieces;
                        $total_weight+=$rows->weight;
                        $total_sc+=$rows->order_sc;
                        $total_osa_sd+=$rows->order_osa_sd_total;
                        
                    }
                }
                
                 $net = round($total_osa_sd+$total_sc);
                echo ("</tbody>");
                
                echo ("<tfoot>");
                
                echo ("<tr>");
                echo ("<td><span style='font-weight:bold'>Net</span></td>");
                echo ("<td class='text-right'><span style='font-weight:bold'>".$net."</span></td>");
                echo ("<td><span style='font-weight:bold'>-----</span></td>");
                echo ("<td><span style='font-weight:bold'>-----</span></td>");
                echo ("<td><span style='font-weight:bold'>-----</span></td>");
                echo ("<td><span style='font-weight:bold'>Totals</span></td>");
                echo ("<td class='text-right'><span style='font-weight:bold'>" . round($total_pieces) . "</span></td>");
                echo ("<td class='text-right'><span style='font-weight:bold'>" . ceil($total_weight) . "</span></td>");
                echo ("<td class='text-right'><span style='font-weight:bold'>" . round($total_sc) . "</span></td>");
                echo ("<td class='text-right'><span style='font-weight:bold'>" . round($total_osa_sd) . "</span></td>");
                //echo ("<td>Net:".round($total_sc)+round($total_osa_sd)."</td>");
                echo ("</tr>");
                
                echo ("</tfoot>");
                
                echo ("</table>");
                echo ("</div>");
                echo ("<input type='hidden' id='net_".$customer."' name='invoice_".$customer."' value='" .$net. "'/>");
                echo ("<input type='hidden' id='total_pieces_".$customer."' name='gst_".$customer."' value='".round($total_pieces)."'/>");
                echo ("<input type='hidden' id='total_weight_".$customer."' name='gst_".$customer."' value='".ceil($total_weight)."'/>");
                echo ("<input type='hidden' id='total_sc_".$customer."' name='gst_".$customer."' value='". round($total_sc) ."'/>");
                echo ("<input type='hidden' id='total_osa_sd_".$customer."' name='gst_".$customer."' value='" . round($total_osa_sd) ."'/>");
                
                
                echo ("</div>");
                echo ("</div>");
                //echo ("</div>");
            
        } else {
            echo ("<tr><td><p>Something Went Wrong.</p></td></tr>");
        }
    }

    public function summary()
    {
        $invoice_code = $this->input->post('invoice_code');
        $invoice_date = $this->input->post('invoice_date');
        $invoice_date_f = $this->input->post('invoice_date_f');
        if ($invoice_code != "") {
            $summary_data = $this->Invoicesmodel->Get_Summary_By_Code_Date($invoice_code, $invoice_date, $invoice_date_f);
            $summary_COD = $this->Invoicesmodel->Get_Summary_By_Code_OK_Date($invoice_code, $invoice_date, $invoice_date_f);
            if (! empty($summary_data)) {
                $net_total = $summary_data[0]['SC'] + $summary_data[0]['osa_sd'];
                echo ("<table class='table'><tr>");
                echo ("<td>Total Cns</td><td>" . $summary_data[0]['Cns'] . "</td></tr><tr>");
                echo ("<td>Total SC </td><td>" . number_format($summary_data[0]['SC']) . "/-</td></tr><tr>");
                echo ("<td>Total OSA/SD </td><td>" . number_format($summary_data[0]['osa_sd']) . "/-</td></tr><tr>");
                echo ("<tr>
	<td>NET</td><td>" . number_format($net_total) . "/-</td></tr><tr>
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
        $code = $this->Invoicesmodel->Get_Last_Invoice_Code();
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
        $data['invoice_data'] = $this->Commonmodel->Get_record_by_condition('saimtech_invoice', 'invoice_id', $id);
        $this->load->view('module_invoices/editinvoiceView', $data);
    }

    public function edit_invoice()
    {
        $osa_amount = $this->input->post('osa_amount');
        $other_amount = $this->input->post('other_amount');
        $bulk_flyer = $this->input->post('bulk_flyer');
        $remark = $this->input->post('remark');
        $permission = $this->input->post('permission');
        $invoice_id = $this->input->post('invoice_id');
        if ($osa_amount != "" && $other_amount != "" && $bulk_flyer != "" && $permission != "" && $invoice_id != "" && $invoice_id != "0") {
            $data = array(
                'bulk_flyer_amount' => $bulk_flyer,
                'osa_amount' => $osa_amount,
                'other_amount' => $other_amount,
                'invoice_remark' => $remark
            );
            $this->Commonmodel->Update_record('saimtech_invoice', 'invoice_id', $invoice_id, $data);
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
        $file = Zend_Barcode::draw('code128', 'image', array(
            'text' => $code
        ), array());
        $code = $code;
        $store_image = imagepng($file, $targetDir . "/{$code}.png");
    }

    public function release_from_invoice()
    {
        $cn = $this->input->post('cn');
        $invoice_date = $this->input->post('invoice_date');
        $invoice_date_f = $this->input->post('invoice_date_f');

        if ($cn != "" && $invoice_date != "") {
            $invoice_code = $this->Invoicesmodel->Get_Temp_Invoice_Code_By_Cn($cn);
            $data = array(
                'is_temp_invoice' => ''
            );
            $this->Commonmodel->Update_record('saimtech_order', 'order_code', $cn, $data);
        }
        $customer_data = $this->Invoicesmodel->Get_Cn_By_Invoice_Code_Date($invoice_code, $invoice_date, $invoice_date_f);
        if (! empty($customer_data)) {
            $i = 0;
            foreach ($customer_data as $rows) {
                $i = $i + 1;
                echo ("<tr>");
                echo ("<td>" . $i . "</td>");
                echo ("<td>" . $rows->order_date . "</td>");
                echo ("<td>" . $rows->order_code . "</td>");
                echo ("<td>" . $rows->origin_city_name . "</td>");
                echo ("<td>" . $rows->destination_city_name . "</td>");
                echo ("<td>" . $rows->consignee_name . "</td>");
                echo ("<td>" . $rows->pieces . "</td>");
                echo ("<td>" . ceil($rows->weight) . "</td>");
                echo ("<td>" . round($rows->order_sc) . "</td>");
                echo ("<td><button onclick='remove_from_invoice(" . $rows->order_code . ")' class='btn btn-danger btn-sm'>Release</button></td>");
                echo ("</tr>");
            }
        }
    }

    public function apply_rts_charges()
    {
        $invoice_code = $this->input->post('invoice_code');
        if ($invoice_code != "") {
            $customer_data = $this->Invoicesmodel->Get_RTS_Charges_By_Temp_Invocie_Code($invoice_code);
            if (! empty($customer_data)) {
                $rts_sc = $customer_data[0]['rts_sc'];
                $shipments = $customer_data[0]['shipments'];
                if ($shipments > 0) {
                    $msg = "Return Charges Applied on " . $shipments . " = " . $rts_sc;
                    $rts_set = array(
                        'rts_sc' => $rts_sc,
                        'msg' => $msg
                    );
                } else {
                    $rts_set = array(
                        'rts_sc' => 02,
                        'msg' => "2"
                    );
                }
            }
        }
        echo json_encode($rts_set);
    }

    public function complete_invoice()
    {
        $customer = $this->input->post('customer');
        $permission = $this->input->post('permission');
        $invoice_code = $this->input->post('invoice_code');
        $other = $this->input->post('other');
        $other_amount = $this->input->post('other_amount');
        $discount_amount = $this->input->post('discount_amount');
        $fuel_amount = $this->input->post('fuel_amount');
        $remark = $this->input->post('remark');
        $date = date('Y-m-d H:i:s');
        $total_gst = 0;
        $total_cn = 0;
        $total_sc = 0;
        $total_osa_sd = 0;
        $total_sp = 0;
        $total_cash = 0;
        $total_fuel = 0;
        $total_flyer = 0;
        $total_amount = 0;
        $invoice_id = 0;
        $osa_sd = 0;
        if ($invoice_code != "" && $customer != "" && $permission != "") {
            // --- INSERT INTO Invoice Main
            //$this->set_barcode($invoice_code);
            $data = array(
                'customer_id' => $customer,
                'invoice_code' => $invoice_code,
                'payment_date' => "0000-00-00 00:00:00",
                'invoice_cn' => 0,
                'invoice_permission' => $permission,
                'invoice_gst' => 0,
                'other_name' => $other,
                'invoice_sc' => 0,
                'invoice_osa_sd_total' => 0,
                'other_amount' => $other_amount,
                'fuel_surcharge' => $fuel_amount,
                'discount_amount' => $discount_amount,
                'invoice_ajustment_amount' => 0,
                'is_inovice_ajustment' => 0,
                'ajustment_narration' => "",
                'invoice_complete' => 0,
                'invoice_date' => $date,
                'invoice_remark' => $remark,
                'payment_mode' => "",
                'payment_tid' => "",
                'is_payment' => 0,
                'payment_created_by' => 0,
                'created_by' => $_SESSION['user_id'],
                'created_date' => $date,
                'modify_by' => 0,
                'modify_date' => '0000-00-00 00:00:00'
            );
            $invoice_id = $this->Commonmodel->Insert_record('saimtech_invoice', $data);
        }
        // --- INSERT INTO Invoice Main----END
        $cn_data = $this->Commonmodel->Get_record_by_condition('saimtech_order', 'is_temp_invoice', $invoice_code);
        // echo "<pre>";print_r($cn_data);exit();
        if (! empty($cn_data)) {
            $i = 0;
            foreach ($cn_data as $rows) {
                $i = $i + 1;
                $total_cn = $total_cn + 1;
                $total_gst = $total_gst + $rows->order_gst;
                $total_sc = $total_sc + $rows->order_sc;
                $total_osa_sd = $total_osa_sd + $rows->order_osa_sd_total;
                $total_rate = $rows->rate_id;
                $rate_type = $rows->order_rate_type;
                $dest_zone = $rows->destination_zone;
                $rateee = 0;
                $service_name = "";
                if ($rate_type != "DW") {
                    $zone_rate_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_rate', 'rate_id', $total_rate);
                    $service_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_service', 'service_id', $zone_rate_data[0]['service_id']);
                    $service_name = $service_data[0]['service_name'];
                    if ($dest_zone == "A") {
                        $rateee = $zone_rate_data[0]['sc_add_rate'];
                    } else if ($dest_zone == "B") {
                        $rateee = $zone_rate_data[0]['sz_add_rate'];
                    } else if ($dest_zone == "C") {
                        $rateee = $zone_rate_data[0]['dz_add_rate'];
                    } else if ($dest_zone == "D") {
                        $rateee = $zone_rate_data[0]['zz_add_rate'];
                    }
                } else {
                    $destination_rate_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_destination_rate', 'dest_rate_id', $total_rate);
                    $service_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_service', 'service_id', $destination_rate_data[0]['service_id']);
                    $service_name = $service_data[0]['service_name'];
                    $rateee = $destination_rate_data[0]['city_add_rate'];
                }
                $customer_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_customer', 'customer_id', $rows->customer_id);
                // --- INSERT INTO Invoice Detail
                if ($rows->manual_cn != "" && $rows->manual_cn != null) {
                    $mm_cn = $rows->manual_cn;
                } else {
                    $mm_cn = $rows->order_code;
                }
                if ($rows->order_osa_sd_total > 0) {
                    $osa_sd = $rows->order_osa_sd_total;
                } else {
                    $osa_sd = 0;
                }
                $data = array(
                    'invoice_id' => $invoice_id,
                    'cn' => $rows->order_code,
                    'manual_cn' => $mm_cn,
                    'origin' => $rows->origin_city_name,
                    'destination_name' => $rows->destination_city_name,
                    // 'consignee_detail' =>$rows->consignee_name."<br>".$rows->customer_reference_no."<br>".$rows->consignee_address,
                    'consignee_detail' => $rows->consignee_name,
                    'pcs' => $rows->pieces,
                    'weight' => $rows->weight,
                    'rate' => (($rateee == NULL || $rateee == '')?(0):($rateee)),
                    'sc' => $rows->order_sc,
                    'osa_sd' => $osa_sd,
                    'gst' => $rows->order_gst,
                    'date' => $rows->order_date,
                    'serivce_name' => (($service_name == NULL || $service_name == '')?('default'):($service_name)),
                    'current_table' => 'saimtech_order',
                    'created_by' => $_SESSION['user_id'],
                    'created_date' => $date
                );
                $invoice_detail_id = $this->Commonmodel->Insert_record('saimtech_invoice_detail', $data);

                // --- INSERT INTO Invoice Detail----END
                // --- UPDATE SaimTech Order
                $data = array(
                    'is_temp_invoice' => '',
                    'is_invoice' => 1,
                    'invoice_id' => $invoice_code
                );
                $this->Commonmodel->Update_record('saimtech_order', 'order_code', $rows->order_code, $data);
                // --- UPDATE SaimTech Order----END
            }
        }
        $total_order_gst = ((($total_sc) * ($customer_data[0]['gst'])) / 100);
        if ($total_osa_sd != 0) {
            $total_osa_sd_gst = ((($total_osa_sd) * ($customer_data[0]['gst'])) / 100);
        }
        $final_total_gst = $total_order_gst + $total_osa_sd_gst;
        // --- UPDATE SaimTech Invoice
        $data = array(
            'invoice_cn' => $total_cn,
            'invoice_sc' => $total_sc,
            'invoice_osa_sd_total' => $total_osa_sd,
            'invoice_gst' => $final_total_gst
        );
        $this->Commonmodel->Update_record('saimtech_invoice', 'invoice_id', $invoice_id, $data);
        // --- UPDATE SaimTech Invoice----END
        echo ("<p class='alert alert-success'>Successfully Done</p>");
    }

    public function add_deduction()
    {
        ECHO $code = $this->input->post('code');
        ECHO $name = $this->input->post('name');
        ECHO $amount = $this->input->post('amount');
        if ($code != "" && $name != "" && $amount != "") {
            $check = $this->Invoicesmodel->Duplicate_Check($code, $name, $amount);
            if ($check == 0) {
                $data = array(
                    'invoice_id' => $code,
                    'extra_amount' => $amount,
                    'extra_name' => $name,
                    'extra_date' => date('Y-m-d'),
                    'created_by' => $_SESSION['user_id'],
                    'created_date' => date('Y-m-d H:i:s')
                );
                $invoice_id = $this->Commonmodel->Insert_record('saimtech_invoice_extra', $data);
            } else {
                $msg = "<p class='alert alert-danger'><strong>Duplication Error!</strong> Activated Duplicate Sheild.</p>";
            }
        } else {
            $msg = "<p class='alert alert-danger'><strong>Missing Error !</strong> Something is missing please try again.</p>";
        }
    }

    public function print_invoice($sheet_code)
    {
        $sheet_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
        $sheet_archive_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
        if (! empty($sheet_archive_data)) {
            $data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
        } else {
            $data['sheet_data'] = $sheet_data;
        }
        $this->load->view('module_invoices/printinvoiceView', $data);
    }

    public function view_invoice_sheet($sheet_code)
    {
        $sheet_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
        $sheet_archive_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
        if (! empty($sheet_archive_data)) {
            $data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
        } else {
            $data['sheet_data'] = $sheet_data;
        }
        $this->load->view('module_invoices/invoicepreviewView', $data);
    }

    public function view2_invoice_sheet($sheet_code)
    {
        $sheet_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code($sheet_code);
        $sheet_archive_data = $this->Invoicesmodel->Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code);
        if (! empty($sheet_archive_data)) {
            $data['sheet_data'] = array_merge($sheet_data, $sheet_archive_data);
        } else {
            $data['sheet_data'] = $sheet_data;
        }
        $this->load->view('module_invoices/paiddetailView', $data);
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
        $data['sheet_data'] = $this->Invoicesmodel->Get_Invoice_Data_By_Is_Payment();
        $data['id'] = $id;
        $this->load->view('module_invoices/paymentView', $data);
    }

    public function submit_payment()
    {
        $invoice_id = $this->input->post('invoice_id');
        $payment_mode = $this->input->post('payment_mode');
        $tid = $this->input->post('tid');
        $payment_date = $this->input->post('payment_date');
        if ($invoice_id != 0 && $payment_mode != "" && $tid != "") {
            $data = array(
                'is_payment' => 1,
                'payment_mode' => $payment_mode,
                'payment_tid' => "|" . $payment_mode . "|" . $tid,
                'payment_date' => date('Y-m-d H:i:s'),
                'payment_created_by' => $_SESSION['user_id']
            );
            $this->Commonmodel->Update_record('saimtech_invoice', 'invoice_id', $invoice_id, $data);
            $invoice_data = $this->Commonmodel->Get_record_by_condition_array('saimtech_invoice', 'invoice_id', $invoice_id);
            if (! empty($invoice_data)) {
                $invoice_code = $invoice_data[0]['invoice_code'];
                $data = array(
                    'is_payment' => 1,
                    'payment_mode' => $payment_mode,
                    'payment_trans_id' => "|" . $payment_mode . "|" . $tid
                );
                $this->Commonmodel->Update_record('saimtech_order', 'invoice_id', $invoice_code, $data);
                $data = array(
                    'is_payment' => 1,
                    'payment_mode' => $payment_mode,
                    'payment_trans_id' => "|" . $payment_mode . "|" . $tid
                );
                $this->Commonmodel->Update_record('saimtech_archive_order', 'invoice_id', $invoice_code, $data);
            }
            redirect('Invoice');
        } else {
            echo ("<p class='alert alert-danger'>Something is missing. :(</p>");
        }
    }

    public function cal_index($customer_id)
    {
        $sz_return_formula = "";
        $dz_return_formula = "";
        $sc_return_formula = "";
        $sc_return_rate = 0;
        $sz_return_rate = 0;
        $dz_return_rate = 0;
        $order_pre = 0;
        // 1=============Get Return Rate From Saimtech_rate By Customer ID
        $returndetail = $this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
        if (! empty($returndetail)) {
            $sz_return_formula = $returndetail[0]['sz_return_formula'];
            $dz_return_formula = $returndetail[0]['dz_return_formula'];
            $sc_return_formula = $returndetail[0]['sc_return_formula'];
            $sc_return_rate = $returndetail[0]['sc_return_rate'];
            $sz_return_rate = $returndetail[0]['sz_return_rate'];
            $dz_return_rate = $returndetail[0]['dz_return_rate'];
            // End===========Get Return Rate From Saimtech_rate By Customer ID
            $orders = $this->Commonmodel->Get_Sc_By_Customer_RTS($customer_id);
            if (! empty($orders)) {
                foreach ($orders as $rows) {
                    $order_type = $rows->order_rate_type;
                    $order_id = $rows->order_id;
                    $order_sc = $rows->order_sc;
                    $order_pre_total = $rows->order_total_amount;
                    // -----SameZone---------------------
                    if ($order_type == 'SZ') {
                        if ($sz_return_formula == 'PER') {
                            $order_pre = 0;
                            $order_pre = (($order_sc * $sz_return_rate) / 100);
                            $data = array(
                                'order_return_sc' => $order_pre
                            );
                        } else if ($sz_return_formula == 'FIX') {
                            $order_pre = $sz_return_rate;
                            $data = array(
                                'order_return_sc' => $order_pre
                            );
                            // End--SameZone---------------------
                            // -----SameCity---------------------
                        } else if ($order_type == 'WC') {
                            if ($sc_return_formula == 'PER') {
                                $order_pre = 0;
                                $order_pre = (($order_sc * $sc_return_rate) / 100);
                                $data = array(
                                    'order_return_sc' => $order_pre
                                );
                            } else if ($sc_return_formula == 'FIX') {
                                $order_pre = $sc_return_rate;
                                $data = array(
                                    'order_return_sc' => $order_pre
                                );
                            }
                            // End--SameCity---------------------
                            // -----Different Zone---------------------
                        } else if ($order_type == 'DZ') {
                            if ($dz_return_formula == 'PER') {
                                $order_pre = 0;
                                $order_pre = (($order_sc * $dz_return_rate) / 100);
                                $data = array(
                                    'order_return_sc' => $order_pre
                                );
                            } else if ($dz_return_formula == 'FIX') {
                                $order_pre = $dz_return_rate;
                                $data = array(
                                    'order_return_sc' => $order_pre
                                );
                            }
                        }
                        $this->Commonmodel->Update_Triple_record('saimtech_order', 'customer_id', $customer_id, 'order_status', 'RTS', 'is_invoice', '0', $data);

                        // End--Different Zone---------------------
                    }
                }
                // 2=============Get Order Sc From Saimtech_order By Customer ID AND RTS
                // Loop
                // 2.1=============Update Order Return Sc INTO Saimtech_order By ORDER ID
                // END=============Update Order Return Sc INTO Saimtech_order By ORDER ID
                // ENDLoop
            }
            // End===========Get Order Sc From Saimtech_order By Customer ID AND RTS
        }
    }

    public function privot_table()
    {}

    public function get_cutomer_gst()
    {
        $customer_id = $this->input->post("customer");
        $gstcustomer = $this->Invoicesmodel->Get_Invoice_Active_Customer_gst($customer_id);

        $gstcustomer = $gstcustomer[0];
        $data['result'] = $gstcustomer;
        echo json_encode($data);
    }
}