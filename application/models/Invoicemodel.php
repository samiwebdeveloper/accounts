<?php
class Invoicemodel extends CI_Model
{

	public function Get_Invoice_Data_By_Date_Range($startdate, $enddate)
	{
		$query = "SELECT *, sum(`pcs`) as `t_pcs`, sum(ceil(`weight`)) as `t_wgt` FROM `acc_invoice`
			INNER JOIN `acc_invoice_detail` on `acc_invoice_detail`.`invoice_id` = `acc_invoice`.`acc_invoice_id`
            INNER JOIN `acc_customers` on `acc_customers`.customer_id=`acc_invoice`.`customer_id`
			INNER JOIN `acc_city` on `acc_customers`.customer_city=`acc_city`.`city_id`
			INNER JOIN `acc_user` on `acc_user`.`oper_user_id`=`acc_invoice`.`created_by`
			LEFT JOIN `acc_references` on `acc_references`.`reference_id` = `acc_customers`.`reference_by`
			WHERE  date(`invoice_date`) between ? and ?
            group by `acc_invoice_id`
             ORDER BY `invoice_date` DESC;";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_Invoice_Data_By_Date_Range_And_Mixture($startdate, $enddate, $mixture)
	{
		$query = "SELECT *, sum(`pcs`) as `t_pcs`, sum(ceil(`weight`)) as `t_wgt` FROM `acc_invoice`
			INNER JOIN `acc_invoice_detail` on `acc_invoice_detail`.`invoice_id` = `acc_invoice`.`acc_invoice_id`
            INNER JOIN `acc_customers` on `acc_customers`.customer_id=`acc_invoice`.`customer_id`
			INNER JOIN `acc_city` on `acc_customers`.customer_city=`acc_city`.`city_id`
			INNER JOIN `acc_user` on `acc_user`.`oper_user_id`=`acc_invoice`.`created_by`
			LEFT JOIN `acc_references` on `acc_references`.`reference_id` = `acc_customers`.`reference_by`
			WHERE  date(`invoice_date`) between ? and ?
			AND `mixture` in (?)
            group by `acc_invoice_id`
             ORDER BY `invoice_date` DESC;";
		$res = $this->db->query($query, array($startdate, $enddate, str_replace(",", "','", $mixture)));
		return $res->result();
	}


	public function Get_Invoice_Data_By_Is_Payment()
	{
		$query = "SELECT *  FROM `acc_invoice`
			INNER JOIN `acc_customers` on `acc_customers`.customer_id=`acc_invoice`.`customer_id`
			WHERE  is_payment=0 ORDER BY `invoice_date` DESC ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_RTS_Charges_By_Temp_Invocie_Code($code)
	{
		$query = "SELECT COUNT(order_code) as `shipments`,SUM(`order_return_sc`) as `rts_sc` FROM `acc_orders` WHERE  `is_temp_invoice`=? and order_status='RTS'  ";
		$res = $this->db->query($query, array($code));
		return $res->result_array();
	}

	public function Get_Invoice_Print_Sheet_By_Code($sheet_code)
	{
		$query = "SELECT *, `acc_invoice`.`discount_amount` as DC, `acc_customers`.`gst` as `gsst`,`acc_invoice`.`is_payment` as `ispayment`, `acc_invoice`.`payment_mode` as `paymentmode`,  `acc_invoice`.`payment_tid` as `paymenttid`,Monthname(`acc_invoice_detail`.`date`) as Month,Year(`acc_invoice_detail`.`date`) as Year,  date_format(date,'%d-%m-%Y') as 'date' FROM `acc_invoice`
			INNER JOIN `acc_customers` on `acc_customers`.customer_id=`acc_invoice`.`customer_id`
			INNER JOIN `acc_invoice_detail` on `acc_invoice_detail`.invoice_id=`acc_invoice`.`acc_invoice_id`
			INNER JOIN `acc_user` ON `acc_user`.`oper_user_id`=  `acc_invoice`.`created_by`
			WHERE  `acc_invoice`.`invoice_code`=?   ORDER BY `acc_invoice_detail`.`date`, `acc_invoice_detail`.`manual_cn`, `acc_invoice_detail`.`cn`";
		$res = $this->db->query($query, array($sheet_code));
		return $res->result();
	}

	public function Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code)
	{
		$query = "SELECT * , `acc_customers`.`gst` as `gsst`, `acc_invoice`.`is_payment` as `ispayment`, `acc_invoice`.`payment_mode` as `paymentmode`,  `acc_invoice`.`payment_tid` as `paymenttid` FROM `acc_invoice`
			INNER JOIN `acc_customers` on `acc_customers`.customer_id=`acc_invoice`.`customer_id`
			INNER JOIN `acc_invoice_detail` on `acc_invoice_detail`.invoice_id=`acc_invoice`.`invoice_id`
			INNER JOIN `acc_user` ON `acc_user`.`oper_user_id`=  `acc_invoice`.`created_by`
			INNER JOIN `acc_archive_orders` on `acc_archive_orders`.order_code=`acc_invoice_detail`.`cn`
			WHERE  `invoice_code`=?   ORDER BY `acc_invoice`.`invoice_date` DESC ";
		$res = $this->db->query($query, array($sheet_code));
		return $res->result();
	}




	public function Duplicate_Check($id, $name, $amount)
	{
		$query = "SELECT *  FROM `acc_invoice_extra` WHERE `invoice_id`=? and `extra_name`=? and `extra_amount`=?  ";
		$res = $this->db->query($query, array($id, $name, $amount));
		return $res->num_rows();
	}

	public function Get_Summary_By_Code($sheet_code)
	{
		$query = "SELECT COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, SUM(`order_gst`) as `GST`, SUM(`order_sc`) as `SC`  FROM `acc_orders` WHERE  `is_temp_invoice`=?  (`order_pay_mode`='Account' or `order_pay_mode`='account') ";
		$res = $this->db->query($query, array($sheet_code));
		return $res->result_array();
	}

	public function Get_Summary_By_Code_Date($sheet_code, $date, $datef)
	{
		$query = "SELECT COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, SUM(`order_gst`) as `GST`, SUM(`order_sc`) as `SC`,SUM(`order_osa_sd_total`) as osa_sd, SUM(`order_osa`) as order_osa, SUM(`order_fuel`) as order_fuel, SUM(`order_others`) as order_others, SUM(`order_faf`) as order_faf  
		FROM `acc_orders` WHERE  `is_temp_invoice`=? AND date(`order_date`) between ? AND ? 
		AND `order_pay_mode` IN ('Account','account')";
		$res = $this->db->query($query, array($sheet_code, $date, $datef));
		return $res->result_array();
	}



	public function Get_Summary_By_Code_OK($sheet_code)
	{
		$query = "SELECT  SUM(`cod_amount`) as `COD` FROM `acc_orders` WHERE  `is_temp_invoice`=? and `order_status`='Deliverd' ";
		$res = $this->db->query($query, array($sheet_code));
		$rows = $res->result_array();
		return $rows[0]['COD'];
	}


	public function Get_Summary_By_Code_OK_Date($sheet_code, $date, $datef)
	{
		$query = "SELECT  SUM(`cod_amount`) as `COD` FROM `acc_orders` WHERE  `is_temp_invoice`=? and `order_status`='Deliverd'  AND(date(`order_result_date`)>=? AND date(`order_result_date`)<=?) ";
		$res = $this->db->query($query, array($sheet_code, $date, $datef));
		$rows = $res->result_array();
		return $rows[0]['COD'];
	}

	public function Get_Unpaid_Summary_Customer_Wise_Delivered($origin_id)
	{
		$query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0 and `customer_city`=? group by A.customer_id";
		$res = $this->db->query($query, array($origin_id));
		return $res->result();
	}


	public function Get_Unpaid_Summary_Customer_Wise_RTS($origin_id)
	{
		$query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='RTS') and `is_invoice`=0 and `customer_city`=? group by A.customer_id";
		$res = $this->db->query($query, array($origin_id));
		return $res->result();
	}


	public function Get_All_Unpaid_Summary_Customer_Wise_Delivered()
	{
		$query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0  group by A.customer_id";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function  Get_All_Unpaid_Summary_Customer_Wise_Delivered_And_RTS()
	{
		$query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(cod_amount),
		IF((SELECT SUM(`cod_amount`) FROM acc_orders where customer_id=A.customer_id and `is_invoice`=0  and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM acc_orders where customer_id=A.customer_id and `is_invoice`=0  and `order_status`='Deliverd')) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` 
		FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0  group by A.customer_id";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function  Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS_All()
	{
		$query = "SELECT 
		A.`customer_id` as `id`,
		`customer_name`,
		order_code as `Cn`, 
		IF((SELECT `cod_amount` FROM acc_orders where order_code=A.order_code and `is_invoice`=0  and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM acc_orders where order_code=A.order_code and `is_invoice`=0  and `order_status`='Deliverd')) as `COD`, 
		round(`order_gst`) as `GST`,
		`order_sc` as `SC`,
		date(`order_result_date`) as `ResultDate` 
		FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0 ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_All_Unpaid_Detail_Customer_Wise_Delivered($cid)
	{
		$query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_deliver_date`) as `ResultDate` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0  and A.customer_id=?";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}

	public function Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS($cid)
	{
		$query = "SELECT A.`customer_id` as `id`, `customer_name`, order_code as `Cn`, 
		IF((SELECT `cod_amount` FROM acc_orders where order_code=A.order_code and `is_invoice`=0 and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM acc_orders where order_code=A.order_code and `is_invoice`=0 and `order_status`='Deliverd')) as `COD`,
		round(`order_gst`) as `GST`, `order_sc` as `SC` FROM `acc_orders` A 
		INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` 
		WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0 and A.customer_id=? ";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}

	public function Get_All_Unpaid_Detail_Customer_Wise_Delivered_All()
	{
		$query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_deliver_date`) as `ResultDate` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0 order by date(`order_result_date`)";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_All_Unpaid_Summary_Customer_Wise_RTS()
	{
		$query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_status`='RTS') and `is_invoice`=0  group by A.customer_id";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_All_Unpaid_Detail_Customer_Wise_RTS($cid)
	{
		$query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_date`) as `ResultDate` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_pay_mode`='Account' OR `order_pay_mode`='account') and `is_invoice`=0  and A.customer_id=?";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}


	public function Get_All_Unpaid_Detail_Customer_Wise_RTS_All()
	{
		$query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_date`) as `ResultDate` FROM `acc_orders` A INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=A.`customer_id` WHERE (`order_pay_mode`='Account' OR `order_pay_mode`='account') and `is_invoice`=0 order by date(`order_date`) ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_Last_Invoice_Code()
	{
		$id = 0;
		$code = 0;
		$year = 0;
		$sy_y = 0;
		$select_query = "SELECT * from cargo.saimtech_order_code";
		$res = $this->db->query($select_query);
		$row = $res->result_array();
		$id = $row[0]['invoice_code'];
		$sys_y = $row[0]['order_year'];
		if ($sys_y == date('y')) {
			$code = (($id) + 1);
			$year = $sys_y;
		} else {
			$code = 1;
			$year = date('y');
		}
		$query = "UPDATE `cargo`.`saimtech_order_code` SET `invoice_code`=?,`order_year`=? WHERE 1";
		$res = $this->db->query($query, array($code, $year));
		return $code;
	}

	public function Get_Active_Customer()
	{
		$query = "SELECT * FROM `acc_customers` WHERE `is_enable`=1 ORDER BY `customer_id` DESC ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Invoice_Active_Customer($s_date, $e_date)
	{
		$query = "SELECT `acc_customers`.`customer_id` as `id`,`acc_customers`.`customer_name` as `name`,`city_name` as `city`,is_gst
		FROM `acc_orders`
		INNER JOIN acc_customers ON acc_customers.customer_id=acc_orders.customer_id
		INNER JOIN acc_city ON acc_city.city_id=acc_customers.customer_city
		WHERE date(order_date) BETWEEN '". $s_date ."' AND '". $e_date ."' 
		AND `is_invoice`= 0 
		AND `order_pay_mode` IN ('Account','account')
		GROUP BY `acc_customers`.`customer_id` order by `acc_customers`.`customer_name`";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Invoice_Active_Customer_By_Mixture($mixture, $s_date, $e_date)
	{
		$query = "SELECT `acc_customers`.`customer_id` as `id`,`acc_customers`.`customer_name` as `name`,`city_name` as `city`,is_gst
			FROM `acc_orders`
			INNER JOIN acc_customers ON acc_customers.customer_id=acc_orders.customer_id
			INNER JOIN acc_city ON acc_city.city_id=acc_customers.customer_city
			WHERE date(order_date) BETWEEN '". $s_date ."' AND '". $e_date ."'
			AND `is_invoice`= 0 
			AND `order_pay_mode` IN ('Account','account')
			AND `mixture` IN ('" . str_replace(",", "','", $mixture) . "') 
			GROUP BY `acc_customers`.`customer_id` order by `acc_customers`.`customer_name`";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Customer_Billable_Services($customer)
	{
		$query = "SELECT distinct `service_id`, `service_name`
		FROM `acc_services`
		INNER JOIN `acc_orders` ON `acc_services`.`service_id` = `acc_orders`.`order_service_type`
		WHERE `is_invoice`= 0 
		AND `order_pay_mode` IN ('Account','account')
		AND `customer_id` = " . $customer . "
		order by `service_name`";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Customer_Billable_Destinations($customer)
	{
		$query = "SELECT distinct `city_id`, `city_full_name`
		FROM `acc_city`
		INNER JOIN `acc_orders` ON `acc_city`.`city_id` = `acc_orders`.`destination_city`
		WHERE `is_invoice`= 0 
		AND `order_pay_mode` IN ('Account','account')
		AND `customer_id` = " . $customer . "
		order by `city_full_name`";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Services()
	{
		$query = "SELECT distinct `service_id`, `service_name`
		FROM `acc_services`
		WHERE `is_enable`= 1 		
		order by `service_name`";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Destinations()
	{
		$query = "SELECT distinct `city_id`, `city_full_name`, `city_short_code`
		FROM `acc_city`
		WHERE `is_enable`= 1
		order by `city_full_name`";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_Invoice_Active_Customer_gst($customer_id)
	{
		$query = "SELECT `customer_name`, `is_gst` FROM `acc_customers` WHERE `customer_id`=?";
		$res = $this->db->query($query, array($customer_id));
		return $res->result_array();
	}

	public function Get_OK_RTS_CN_BY_Customer_ID($customer_id)
	{
		$query = "SELECT * FROM `acc_orders` WHERE `is_invoice`=0 AND `customer_id`=? ORDER BY `order_date` DESC ";
		$res = $this->db->query($query, array($customer_id));
		return $res->result();
	}


	public function Get_CN_BY_Customer_ID_And_Date($customer_id, $date, $date_f, $destination, $service)
	{
		$query = "SELECT
		`acc_orders_id`,
		`order_code`,
		`manual_cn`,
		DATE_FORMAT(order_date, '%Y-%m-%d') AS `order_date`,
		`destination_city_name`,
		`origin_city_name`,
		`weight`,
		`pieces`,
		`order_osa_sd_total`,
		`consignee_name`,
		`order_rate`,
		`order_sc`,
		`order_osa`,
		`order_gst`,
		`order_others`,
		`order_fuel`,
		`order_faf`,
		acc_services.service_name
	FROM
		`acc_orders`
	INNER JOIN acc_services ON acc_orders.order_service_type = acc_services.service_id
		WHERE `is_invoice`= 0 
		AND `customer_id`= ? 
		AND date(`order_date`) BETWEEN ? AND ? 
		AND `order_pay_mode` IN ('Account','account')";

		$query .= strlen($destination) > 0 ? " AND `destination_city` IN (" . $destination . ")" : "";
		$query .= strlen($service) > 0 ? " AND `order_service_type` IN (" . $service . ")" : "";
		$query .= " ORDER BY `order_date`;";
		$res = $this->db->query($query, array($customer_id, $date, $date_f));
		
		return $res->result();
	}

	public function Get_Cn_By_Invoice_Code($invoice_code)
	{
		$query = "SELECT * FROM `acc_orders` WHERE is_temp_invoice=? ORDER BY `order_date` DESC ";
		$res = $this->db->query($query, array($invoice_code));
		return $res->result();
	}


	public function Get_Cn_By_Invoice_Code_Date($invoice_code, $invoice_date, $invoice_date_f)
	{
		$query = "SELECT * FROM `acc_orders` WHERE is_temp_invoice=? AND (date(`order_date`)>=? AND date(`order_date`)<=?) AND (`order_pay_mode`='Account' OR `order_pay_mode`='account')  ORDER BY `order_arrival_date` DESC ";
		$res = $this->db->query($query, array($invoice_code, $invoice_date, $invoice_date_f));
		return $res->result();
	}

	public function Get_Temp_Invoice_Code_By_Cn($cn)
	{
		$query 	= "SELECT * FROM `acc_orders` WHERE order_code=? ORDER BY `order_date` DESC ";
		$res 	= $this->db->query($query, array($cn));
		$invoice = $res->result_array();
		return 	  $invoice[0]['is_temp_invoice'];
	}

	public function Select_Zero_Rated_CN($booking_date_1, $booking_date_2, $customer, $mcn, $origin, $destination, $shipper, $consignee, $pieces, $weight, $content, $paymode, $services)
	{
		$query = "SELECT o.order_id as 'order_id', c.customer_note as 'customer_note', o.origin_city_name as 'origin_city_name', o.destination_city_name as 'destination_city_name', if(o.manual_cn = 0, o.order_code, if(length(o.manual_cn) < 6, lpad(o.manual_cn,6,0), o.manual_cn)) AS 'manual_cn', 
			o.consignee_name as 'consignee_name', o.consignee_address as 'consignee_address', o.consignee_mobile as 'consignee_mobile', o.consignee_email as 'consignee_email', 
			o.shipper_name as 'shipper_name', o.shipper_address as 'shipper_address', o.shipper_phone as 'shipper_phone', o.shipper_email as 'shipper_email', 
			o.pieces as 'pieces', o.order_packing_type as 'order_packing_type', o.weight as 'weight',
			o.product_detail as 'product_detail', 
			o.order_pay_mode as 'order_pay_mode', s.service_name as 'service_name', DATE_FORMAT(o.order_date,'%Y-%m-%d') as 'order_date', o.is_hardchecked as 'is_hardchecked' FROM acc_orders o
			join acc_customers c on o.customer_id = c.customer_id
			join acc_services s on o.order_service_type = s.service_id
			where date(o.order_date) between '" . $booking_date_1 . "' and '" . $booking_date_2 . "'";

		strlen($customer) > 0 ? $query .= " AND o.customer_id = " . $customer : "";
		strlen($mcn) > 0 ? $query .= " AND o.manual_cn = " . $mcn : "";
		strlen($origin) > 0 ? $query .= " AND o.origin_city = " . $origin : "";
		strlen($destination) > 0 ? $query .= " AND o.destination_id = " . $destination : "";
		strlen($shipper) > 0 ? $query .= " AND o.shipper_name = " . $shipper . "'" : "";
		strlen($consignee) > 0 ? $query .= " AND o.consignee_name = '" . $consignee . "'" : "";
		strlen($pieces) > 0 ? $query .= " AND o.pieces = " . $pieces : "";
		strlen($weight) > 0 ? $query .= " AND o.weight = " . $weight : "";
		strlen($content) > 0 ? $query .= " AND o.product_detail = '" . $content . "'" : "";
		strlen($paymode) > 0 ? $query .= " AND o.order_pay_mode = '" . $paymode . "'" : "";
		strlen($services) > 0 ? $query .= " AND o.order_service_type = " . $services : "";
		//$_SESSION['is_supervisor'] == 1 ? "" : $query .= " AND o.is_hardchecked = 0 " ;			

		$query .= " AND o.rate_id = 0
			ORDER BY o.manual_cn, o.order_code;";

		$res = $this->db->query($query);
		return $res->result_array();
	}
}
