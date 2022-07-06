<?php
	class Trackingmodel extends CI_Model {
		
		
		public function Get_Shipment_Date_By_Cn($cn){
			$query="SELECT * FROM `acc_orders` 
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` = `acc_orders`.`customer_id`
			WHERE (`order_code`=? OR `manual_cn`=?) ";
			$res = $this->db->query($query,array($cn,$cn));
			return $res->result_array();
		}
		
		public function Get_Shipment_Date_By_Cn_Archive($cn){
			$query="SELECT * FROM `acc_archive_orders` 
			INNER JOIN `acc_customers` on `acc_customers`.`customer_id` = `acc_archive_orders`.`customer_id`
			WHERE (`order_code`=?  OR `manual_cn`=?)";
			$res = $this->db->query($query,array($cn,$cn));
			return $res->result_array();
		}
		
		public function Get_Shipment_detail_by_orderID($id){
			$query="SELECT * FROM `acc_order_trackings` 
			Left JOIN `acc_status`ON `acc_status`.`status_id`=`acc_order_trackings`.`order_reason`
			Left JOIN `acc_user` ON  `acc_user`.`oper_user_id` = `acc_order_trackings`.`created_by`
			WHERE `order_id`=? order by `order_event_date` ASC";
			$res = $this->db->query($query,array($id));
			return $res->result();
		}
	}
