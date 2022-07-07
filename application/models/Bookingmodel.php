<?php
	class Bookingmodel extends CI_Model {
		
		/*public function Get_Active_Pickup_Points_By_Customer_id($cid){
			$query="SELECT *, `acc_pickup_points`.`is_enable` as `enable` FROM `acc_pickup_points` 
			INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_pickup_points`.`country_id`
			INNER JOIN `acc_city` ON `acc_city`.`city_id`=`acc_pickup_points`.`city_id`
			WHERE `acc_pickup_points`.`is_del_enable`='0' AND `customer_id`=? AND `acc_pickup_points`.`is_enable`=1";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}*/
		
		public function Get_Active_Cities(){
			$query="SELECT * FROM `acc_city` INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_city`.`country_id` where `acc_city`.`is_enable`=1 and (`city_type`='DP' OR `city_type`='D') order by city_full_name";
			$res = $this->db->query($query);
			return $res->result();
		}
		
		public function Get_All_Cities(){
			$query="SELECT * FROM `acc_city` INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_city`.`country_id` where (`city_type`='DP' OR `city_type`='D') and `is_delete`=0";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Active_Cities_By_Mixture($mixture){
			$query="SELECT * FROM `acc_city` 
			INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_city`.`country_id` 
			WHERE `acc_city`.`is_enable` = 1 
			AND `city_type` IN ('DP','D') 
			AND `mixture` IN ('".str_replace(",","','",$mixture)."') 
			ORDER BY city_full_name";
			$res = $this->db->query($query);
			return $res->result();
		}
		
		public function Get_All_Cities_By_Mixture($mixture){
			$query="SELECT * FROM `acc_city` 
			INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_city`.`country_id` 
			WHERE `city_type` IN ('DP','D') 
			AND `is_delete` = 0  
			AND `mixture` IN ('".str_replace(",","','",$mixture)."')";
			$res = $this->db->query($query);
			return $res->result();
		}
		
		public function Get_Active_Cities_api(){
			$query="SELECT city_id,city_name,city_code FROM `acc_city` INNER JOIN `acc_countries` ON `acc_countries`.`country_id`=`acc_city`.`country_id` where `acc_city`.`is_enable`=1 and (`city_type`='DP' OR `city_type`='D')";
			$res = $this->db->query($query);
			return $res->result();
		}
		
		public function Get_Last_Order(){
			$id=0;
			$code=0;
			$year=0;
			$sy_y=0;
			$select_query="SELECT * from `cargo`.`saimtech_order_code`";
			$res = $this->db->query($select_query);
			$row=$res->result_array();
			$id=$row[0]['order_code'];
			$sys_y=$row[0]['order_year'];
			if($sys_y==date('y')){
				$code=(($id)+1);
				$year=$sys_y;
				} else {
				$code=1;
				$year=date('y');	
			}
			$query="UPDATE `cargo`.`saimtech_order_code` SET `order_code`=?,`order_year`=? WHERE 1";
			$res = $this->db->query($query,array($code,$year));
			return $code;
		}
		
		public function Get_Orders_By_CID($cid){
			$query="SELECT *  FROM `acc_orders` WHERE (`order_status`='Order' OR `order_status`='Booked') AND `customer_id`=? ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		public function Get_After_Orders_By_CID($cid){
			$query="SELECT *  FROM `acc_orders` WHERE (`order_status`<>'RTS' AND `order_status`<>'Deliverd' AND `order_status`<>'On Route' ) AND `customer_id`=?  AND `is_invoice`<>1  AND `order_status`<>'Cancelled' AND `is_final`<>1 ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		public function Get_After_Orders_By_Order_ID($id){
			$query="SELECT *  FROM `acc_orders` WHERE (`order_status`<>'RTS' AND `order_status`<>'Deliverd' AND `order_status`<>'On Route' ) AND `order_id`=?  AND `is_invoice`<>1 AND `is_final`<>1  ";
			$res = $this->db->query($query,array($id));
			return $res->result_array();
		}
		
		public function Get_Selected_label_address($cid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_print_label_temp` on `acc_print_label_temp`.`print_cn` =`acc_orders`.`order_code`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`customer_id`=? order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		public function Get_Selected_label_address1($orderid){
			$query="SELECT *,`acc_oper_user`.`oper_user_name` AS `createdby`  FROM `acc_orders`
			INNER JOIN `acc_oper_user` ON `acc_oper_user`.`oper_user_id`=`acc_orders`.`created_by`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type` 
			WHERE `acc_orders`.`order_id`=? order by `acc_orders`.`order_date`";
			$res = $this->db->query($query,array($orderid));
			return $res->result();
		}
		
		public function Get_Single_label_address($orderid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`order_id`=? order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($orderid));
			return $res->result();
		}
		
		public function Get_ALL_Label_Address($cid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`customer_id`=? and  order_status='Order' order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		public function Get_Eligible_Load_Sheet($cid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`customer_id`=? and  order_status='Order' and temp_LS=0 and load_sheet_id=0 order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		public function Get_Eligible_Load_Sheet_UID($uid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`created_by`=? and  order_status='Order' and temp_LS=0 and load_sheet_id=0 order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($uid));
			return $res->result();
		}
		
		public function Get_Select_Cn_Sheet($cid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`customer_id`=? and  order_status='Order' and temp_LS=1 and load_sheet_id=0 order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		
		public function Get_Select_Cn_Sheet_UID($cid){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`created_by`=? and  order_status='Order' and temp_LS=1 and load_sheet_id=0 order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		
		public function Get_Load_Sheet_By_Customer($cid){
			$query="SELECT load_sheet_code as sheet_code, `load_sheet_date`, load_sheet_cn as `cn`  FROM `acc_load_sheet` where customer_id= ? group by  load_sheet_code order by Load_sheet_date DESC";
			$res = $this->db->query($query,array($cid));
			return $res->result();
		}
		
		public function Get_Load_Sheet_By_Customer_UID($uid){
			$query="SELECT load_sheet_code as sheet_code, `load_sheet_date`, load_sheet_cn as `cn`  FROM `acc_load_sheet` where created_by= ? group by  load_sheet_code order by Load_sheet_date DESC";
			$res = $this->db->query($query,array($uid));
			return $res->result();
		}
		
		public function Get_load_sheet_label_address($sheetcode){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			INNER JOIN `acc_services` on `acc_services`.`service_id` =`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`load_sheet_id`=? order by `acc_orders`.`order_date` ";
			$res = $this->db->query($query,array($sheetcode));
			return $res->result();	
		}
		
		public function Get_load_sheet_by_code($sheetcode){
			$query="SELECT *  FROM `acc_orders`
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` =`acc_orders`.`customer_id`
			WHERE `acc_orders`.`load_sheet_id`=? ";
			$res = $this->db->query($query,array($sheetcode));
			return $res->result();	
		}
		
		public function Get_Last_Load_Sheet_Code(){
			$id=0;
			$code=0;
			$year=0;
			$sy_y=0;
			$select_query="SELECT * from `cargo`.`saimtech_order_code`";
			$res = $this->db->query($select_query);
			$row=$res->result_array();
			$id=$row[0]['load_sheet_code'];
			$sys_y=$row[0]['order_year'];
			if($sys_y==date('y')){
				$code=(($id)+1);
				$year=$sys_y;
				} else {
				$code=1;
				$year=date('y');	
			}
			$query="UPDATE `cargo`.`saimtech_order_code` SET `load_sheet_code`=?,`order_year`=? WHERE 1";
			$res = $this->db->query($query,array($code,$year));
			return $code;
		}
		
		public function Get_All_Cancelled_Order($userid){
			$query="SELECT * FROM `acc_orders` WHERE order_status='Cancelled' and customer_id=?";
			$res = $this->db->query($query,array($userid));
			return $res->result();
		}
		
		public function Get_All_Cancelled_Order_UID($userid){
			$query="SELECT * FROM `acc_orders` WHERE order_status='Cancelled' and created_by=?";
			$res = $this->db->query($query,array($userid));
			return $res->result();
		}
		
		public function Get_customer_by_api_key($api_key){
			$query="SELECT * FROM `acc_customers` WHERE `api_key`=?";
			$res = $this->db->query($query,array($api_key));
			return $res->result_array();
		}
		
		public function Get_CNs_to_Hard_Check(){
			$query="SELECT o.order_id as 'order_id', c.customer_note as 'customer_note', o.origin_city_name as 'origin_city_name', o.destination_city_name as 'destination_city_name', if(o.manual_cn = 0, o.order_code, if(length(o.manual_cn) < 6, lpad(o.manual_cn,6,0), o.manual_cn)) AS 'manual_cn', 
			o.consignee_name as 'consignee_name', o.consignee_address as 'consignee_address', o.consignee_mobile as 'consignee_mobile', o.consignee_email as 'consignee_email', 
			o.shipper_name as 'shipper_name', o.shipper_address as 'shipper_address', o.shipper_phone as 'shipper_phone', o.shipper_email as 'shipper_email', 
			o.pieces as 'pieces', o.order_packing_type as 'order_packing_type', o.weight as 'weight',
			o.product_detail as 'product_detail', 
			o.order_pay_mode as 'order_pay_mode', s.service_name as 'service_name', DATE_FORMAT(o.order_date,'%Y-%m-%d') as 'order_date', o.is_hardchecked as 'is_hardchecked' FROM acc_orders o
			join acc_customers c on o.customer_id = c.customer_id
			join acc_services s on o.order_service_type = s.service_id
			where DATE_FORMAT(o.order_date,'%Y-%m-%d') between date_format(SUBDATE(NOW(),INTERVAL 1 MONTH), '%Y-%m-25') and date_format(now(), '%Y-%m-%d')
			and o.is_hardchecked = 0
			and o.manual_cn <> 0
			and o.is_invoice = 0
			order by o.manual_cn, o.order_code;";
			$res = $this->db->query($query);
			return $res->result_array();
		}
		
		public function Select_CNs_to_Hard_Check($booking_date_1, $booking_date_2, $customer, $mcn, $origin, $destination, $shipper, $consignee, $pieces, $weight, $content, $paymode, $services, $mixture){
			$query = "SELECT o.order_id as 'order_id', c.customer_note as 'customer_note', o.origin_city_name as 'origin_city_name', o.destination_city_name as 'destination_city_name', if(o.manual_cn = 0, o.order_code, if(length(o.manual_cn) < 6, lpad(o.manual_cn,6,0), o.manual_cn)) AS 'manual_cn', 
			o.consignee_name as 'consignee_name', o.consignee_address as 'consignee_address', o.consignee_mobile as 'consignee_mobile', o.consignee_email as 'consignee_email', 
			o.shipper_name as 'shipper_name', o.shipper_address as 'shipper_address', o.shipper_phone as 'shipper_phone', o.shipper_email as 'shipper_email', 
			o.pieces as 'pieces', o.order_packing_type as 'order_packing_type', o.weight as 'weight',
			o.product_detail as 'product_detail', 
			o.order_pay_mode as 'order_pay_mode', s.service_name as 'service_name', DATE_FORMAT(o.order_date,'%Y-%m-%d') as 'order_date', o.is_hardchecked as 'is_hardchecked' FROM acc_orders o
			join acc_customers c on o.customer_id = c.customer_id
			join acc_services s on o.order_service_type = s.service_id";

			strlen($mixture) > 0 ? $query .= " join acc_city y on o.origin_city = y.city_id" : "";
			
			$query .= " where date(o.order_date) between '". $booking_date_1 ."' and '". $booking_date_2 ."'";
			
			strlen($customer) > 0 ? $query.= " AND o.customer_id = ". $customer : "";
			strlen($mcn) > 0 ? $query.= " AND o.manual_cn = ". $mcn : "";
			strlen($origin) > 0 ? $query.= " AND o.origin_city = ". $origin : "";
			strlen($destination) > 0 ? $query.= " AND o.destination_id = ". $destination : "";
			strlen($shipper) > 0 ? $query.= " AND o.shipper_name = ". $shipper ."'" : "";
			strlen($consignee) > 0 ? $query.= " AND o.consignee_name = '". $consignee ."'" : "";
			strlen($pieces) > 0 ? $query.= " AND o.pieces = ". $pieces : "";
			strlen($weight) > 0 ? $query.= " AND o.weight = ". $weight : "";
			strlen($content) > 0 ? $query.= " AND o.product_detail = '". $content ."'" : "";
			strlen($paymode) > 0 ? $query.= " AND o.order_pay_mode = '". $paymode ."'" : "";
			strlen($services) > 0 ? $query.= " AND o.order_service_type = ". $services : "";
			strlen($mixture) > 0 ? $query.= " AND y.mixture IN ('". str_replace(",","','",$mixture) ."')": "";
			//$_SESSION['is_supervisor'] == 1 ? "" : $query .= " AND o.is_hardchecked = 0 " ;			
			
			/*$query .= " AND o.is_invoice = 0
			AND o.manual_cn <> 0
			ORDER BY o.manual_cn, o.order_code;";*/
			
			$query .= " AND o.is_invoice = 0
			ORDER BY o.manual_cn, o.order_code;";
			
			$res = $this->db->query($query);
			return $res->result_array();
		}
		
		public function Get_CNs_to_Hard_Check_Summary(){
			$query="SELECT 
			DATE(`order_date`) AS `order_date`,
			`origin_city_name`,
			`order_pay_mode`,
			FORMAT(COUNT(DISTINCT `order_id`), 0) AS `order_count`
			FROM
			`acc_orders`
			WHERE
			`is_hardchecked` = 0
			AND `is_invoice` = 0
			AND `origin_city` IN (SELECT `city_id` FROM `acc_city` WHERE `mixture` IN ('".str_replace(",","','",$_SESSION['user_mixture'])."'))
			GROUP BY DATE(`order_date`), `origin_city_name`, `order_pay_mode`
			ORDER BY DATE(`order_date`) DESC, `origin_city_name`, `order_pay_mode` limit 2,2";
			$res = $this->db->query($query);
			return $res->result_array();
		}
		
		public function Get_CNs_Hard_Checked_Summary(){
			$query="SELECT 
			DATE(`order_date`) AS `order_date`,
			`origin_city_name`,
			`order_pay_mode`,
			FORMAT(COUNT(DISTINCT `order_id`), 0) AS `order_count`
			FROM
			`acc_orders`
			WHERE
			`is_hardchecked` = 1
			AND `is_invoice` = 0
			AND `origin_city` IN (SELECT `city_id` FROM `acc_city` WHERE `mixture` IN ('".str_replace(",","','",$_SESSION['user_mixture'])."'))
			GROUP BY DATE(`order_date`), `origin_city_name`, `order_pay_mode`
			ORDER BY DATE(`order_date`) DESC, `origin_city_name`, `order_pay_mode` limit 2,2";
			$res = $this->db->query($query);
			return $res->result_array();
		}

		public function Get_Customers_By_Mixture($mixture){
			$query="SELECT * FROM acc_customers c
			join acc_city y on c.customer_city = y.city_id
			where c.is_enable = 1
			and y.mixture IN ('".str_replace(",","','",$mixture)."');";
			$res = $this->db->query($query);
			return $res->result();
		}
		
	}
