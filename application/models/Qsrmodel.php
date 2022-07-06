<?php
class Qsrmodel extends CI_Model {

	
	

	public function Get_Shipments_By_Cid($cid,$start_date,$end_date){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE `acc_orders`.`customer_id`=? and  (`acc_orders`.`order_date`>=? and  `acc_orders`.`order_date`<=?) Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($cid,$start_date,$end_date));
    return $res->result();
	}
	

	public function Get_Shipments_By_Cid_Archive($cid,$start_date,$end_date){
	$query="SELECT * FROM `saimtech_archive_order` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`saimtech_archive_order`.`pickup_point_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			WHERE `saimtech_archive_order`.`customer_id`=? and  (`saimtech_archive_order`.`order_date`>=? and  `saimtech_archive_order`.`order_date`<=?) Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($cid,$start_date,$end_date));
    return $res->result();
	}



	public function Get_Shipments_Admin($start_date,$end_date){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	
//--------------Admin Shipments Start-------------------------------------------	
	public function Get_Shipments_Admin_Tm($start_date,$end_date){
	$query="SELECT * , `acc_city`.`is_enable` as `TM`,`acc_user`.`oper_user_name` AS `createdby`,`saimtech_transit_list`.`vehicle_no` AS `vehicle`,`saimtech_rider`.`rider_name` AS `rider`,`saimtech_route`.`route_name` as `route_name` FROM `acc_orders`
 	        LEFT JOIN `saimtech_transit_list` ON `saimtech_transit_list`.`transit_code`=`acc_orders`.`loading_id`
 	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
 			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
 			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
 			LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`acc_orders`.`destination_reporting`
 			LEFT JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`acc_orders`.`delivery_rider_id`
 			LEFT JOIN `saimtech_delivery_list` ON `saimtech_delivery_list`.`delivery_code`=`acc_orders`.`on_route_id`
             LEFT JOIN `saimtech_route` ON `saimtech_delivery_list`.`route_id`=`saimtech_route`.`route_id`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' )";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Customer_Tm($start_date,$end_date,$customer){
	$query="SELECT * , `acc_city`.`is_enable` as `TM`,`acc_user`.`oper_user_name` AS `createdby`,`saimtech_transit_list`.`vehicle_no` AS `vehicle`,`saimtech_rider`.`rider_name` AS `rider`,`saimtech_route`.`route_name` as `route_name` FROM `acc_orders`
 	        LEFT JOIN `saimtech_transit_list` ON `saimtech_transit_list`.`transit_code`=`acc_orders`.`loading_id`
 	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
 			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
 			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
 			LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`acc_orders`.`destination_reporting`
 			LEFT JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`acc_orders`.`delivery_rider_id`
 			LEFT JOIN `saimtech_delivery_list` ON `saimtech_delivery_list`.`delivery_code`=`acc_orders`.`on_route_id`
             LEFT JOIN `saimtech_route` ON `saimtech_delivery_list`.`route_id`=`saimtech_route`.`route_id`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) and `acc_orders`.`customer_id`=? AND  order_status<>'Cancelled'  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
//--------------Admin Shipments End---------------------------------------------

//--------------BM/CS Shipments Start-------------------------------------------	
// 	public function Get_Shipments_CS_Tm($start_date,$end_date){
// 	$query="SELECT * , `acc_city`.`is_enable` as `TM`,`acc_user`.`oper_user_name` AS `createdby`,`saimtech_transit_list`.`vehicle_no` AS `vehicle`,`saimtech_rider`.`rider_name` AS `rider`,`saimtech_route`.`route_name` as `route_name` FROM `acc_orders`
// 	        LEFT JOIN `saimtech_transit_list` ON `saimtech_transit_list`.`transit_code`=`acc_orders`.`loading_id`
// 	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
// 			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
// 			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
// 			LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`acc_orders`.`destination_reporting`
// 			LEFT JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`acc_orders`.`delivery_rider_id`
// 			LEFT JOIN `saimtech_delivery_list` ON `saimtech_delivery_list`.`delivery_code`=`acc_orders`.`on_route_id`
//             LEFT JOIN `saimtech_route` ON `saimtech_delivery_list`.`route_id`=`saimtech_route`.`route_id`
// 			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' )";
// 	$res = $this->db->query($query,array($start_date,$end_date));
//     return $res->result();
// 	}
	public function Get_Shipments_CS_Tm($start_date,$end_date){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_deliver_date`,`order_status`,`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,`consignee_address`,
`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`, `acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	         LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' )";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_CS_Customer_Tm($start_date,$end_date,$customer){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_deliver_date`,`order_status`,`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,`consignee_address`,
`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`, `acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) and `acc_orders`.`customer_id`=? AND  order_status<>'Cancelled'  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
//--------------BM/CS Shipments End---------------------------------------------

//--------------Super Shipments Start---------------------------------------------
	public function Get_Shipments_Super_Tm($start_date,$end_date){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_sc`,`order_deliver_date`,`order_status`,
	`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,
	`consignee_address`,`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,
	`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`,
	`acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' )";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Super_Customer_Tm($start_date,$end_date,$customer){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_sc`,`order_deliver_date`,`order_status`,`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,`consignee_address`,
`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`, `acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) and `acc_orders`.`customer_id`=? AND  order_status<>'Cancelled'  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
//--------------Super Shipments End---------------------------------------------

//------------Pending Shipments Start-------------------------------------------
public function Get_Shipments_Pending_Tm($start_date,$end_date){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_deliver_date`,`order_status`,`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,`consignee_address`,
`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`, `acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' AND order_status<>'RTS' and order_status<>'Deliverd' and order_status<>'Delivered' and order_status<>'LOST' )";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Pending_Customer_Tm($start_date,$end_date,$customer){
	$query="SELECT `acc_orders`.`order_code`,`manual_cn`,`order_date`,`order_booking_date`,`order_arrival_date`,`order_deliver_date`,`order_status`,`destination_city_name`,`origin_city_name`,`acc_orders`.`pieces`,`acc_orders`.`weight`,`acc_orders`.`cod_amount`,`consignee_name`,`consignee_mobile`,`consignee_address`,
`shipper_name`,`shipper_phone`,`shipper_address`,`order_pay_mode`,`acc_orders`.`arrival_id`,`unloading_id`,`loading_id`,`payment_mode`,`on_route_id`,`on_route_date`,`acc_customers`.`customer_name`,`acc_services`.`service_name`,`product_detail`,`shipment_received_by`, `acc_user`.`oper_user_name` AS `createdby` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) and `acc_orders`.`customer_id`=? AND  (order_status<>'Order' and order_status<>'Cancelled' AND order_status<>'RTS' and order_status<>'Deliverd' and order_status<>'Delivered' and order_status<>'LOST' )  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
//--------------Pending Shipments End-------------------------------------------	
	
		public function Get_Shipments_Admin_Tm_DEO($start_date,$end_date){
	$query="SELECT * , `acc_city`.`is_enable` as `TM`,`acc_user`.`oper_user_name` FROM `acc_orders`
	        LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`acc_orders`.`destination_reporting`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) AND (order_status<>'Order' and order_status<>'Cancelled' ) AND (`acc_orders`.`created_by`='7' OR `acc_orders`.`created_by`='12' OR `acc_orders`.`created_by`='34' OR `acc_orders`.`created_by`='30') Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Customer_Tm_DEO($start_date,$end_date,$customer){
	$query="SELECT * , `acc_city`.`is_enable` as `TM`,`acc_user`.`oper_user_name` FROM `acc_orders` 
			LEFT JOIN `acc_user` ON `acc_user`.`oper_user_id`=`acc_orders`.`created_by`
			LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			LEFT JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`acc_orders`.`destination_reporting`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) and `acc_orders`.`customer_id`=? AND  order_status<>'Cancelled' AND (`acc_orders`.`created_by`='7' OR `acc_orders`.`created_by`='12')  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
	
	//----------------------Booking-Arrival Difference Check Start----------------------------
	
	public function Get_Shipments_Booking_difference($start_date,$end_date){
	$query="SELECT `order_date`,`acc_orders`.`order_code`,`manual_cn`,`acc_orders`.`pieces` as pcs,`acc_orders`.`weight` as wgt,
	`saimtech_arrival_detail`.`new_pieces` as Apieces,`saimtech_arrival_detail`.`new_weight` AS Aweight FROM `acc_orders` 
	INNER JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code` 
	Where ((`saimtech_arrival_detail`.`new_weight`<>`acc_orders`.`weight` AND `saimtech_arrival_detail`.`new_weight`<>'0')
	OR (`saimtech_arrival_detail`.`new_pieces`<>`acc_orders`.`pieces` AND `saimtech_arrival_detail`.`new_pieces`<>'0'))
    AND (date(`order_date`)>=? and  date(`order_date`)<=?)  ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	//----------------------Booking-Arrival Difference Check End------------------------------
	
	//----------------------Arrival-Manifest Difference Check Start----------------------------
	
	public function Get_Shipments_Manifest_difference($start_date,$end_date){
	$query="SELECT `order_date`,`acc_orders`.`order_code`,`acc_orders`.`manual_cn`,`acc_orders`.`pieces` as pcs,`acc_orders`.`weight` as wgt,
	`saimtech_transit_detail`.`pieces` as Tpieces,`saimtech_transit_detail`.`weight` AS Tweight FROM `acc_orders` 
    INNER JOIN  `saimtech_transit_detail` ON `saimtech_transit_detail`.`transit_cn` =`acc_orders`.`order_code`
    Where ((`saimtech_transit_detail`.`weight`<>`acc_orders`.`weight`) OR (`saimtech_transit_detail`.`pieces`<>`acc_orders`.`pieces` ))
    AND (date(`order_date`)>=? and  date(`order_date`)<=?)  ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	//----------------------Arrival-Manifest Difference Check End------------------------------

	//----------------------Total Weight Check Start----------------------------
	public function Get_Shipments_Admin_Tm_OPS($start_date,$end_date){
    $query="SELECT COUNT(`order_code`) AS `TShip`,SUM(`pieces`) AS `TP`,ROUND(SUM(`weight`)) AS `TW` FROM `acc_orders` 
	WHERE (date(`order_date`)>=? and  date(`order_date`)<=?)  AND  order_status<>'Cancelled' ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Customer_Tm_OPS($start_date,$end_date,$customer){
	$query="SELECT COUNT(`order_code`) AS `TShip`,SUM(`pieces`) AS `TP`,ROUND(SUM(`weight`)) AS `TW` FROM `acc_orders` 
			WHERE (date(`order_date`)>=? and  date(`order_date`)<=?) and `customer_id`=? AND  order_status<>'Cancelled'  ";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
	
	//----------------------Total Weight Check End------------------------------
	
	
		public function Get_Shipments_Admin_Customer($start_date,$end_date,$customer){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) and `acc_orders`.`customer_id`=? Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
	

	public function Get_Shipments_Admin_Archive_Customer_Tm($start_date,$end_date,$customer){
	$query="SELECT * , `acc_city`.`is_enable` as `TM` FROM `saimtech_archive_order` 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`saimtech_archive_order`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_archive_order`.`destination_reporting`
			WHERE (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?) and `saimtech_archive_order`.`customer_id`=? Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
	
	
	public function Get_Shipments_Admin_Archive_Customer($start_date,$end_date,$customer){
	$query="SELECT * FROM `saimtech_archive_order` 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`saimtech_archive_order`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			WHERE (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?) and `saimtech_archive_order`.`customer_id`=? Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Archive($start_date,$end_date){
	$query="SELECT * 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`saimtech_archive_order`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			WHERE (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?)  Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
		public function Get_Shipments_Admin_Archive_Tm($start_date,$end_date){
	$query="SELECT * , `acc_city`.`is_enable` as `TM` FROM `saimtech_archive_order` 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`saimtech_archive_order`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_archive_order`.`destination_reporting`
			WHERE (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?)  Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Old($start_date,$end_date){
	$query="SELECT * FROM `saimtech_old_portal` 
	        LEFT JOIN `acc_customers` ON `acc_customers`.`old_portal_id`= `saimtech_old_portal`.`customer_id`
			WHERE (date(`order_date`)>=? and  date(`order_date`)<=?) Order By `order_date` DESC";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}

	
	
	public function Get_Shipments_Admin_Summary($start_date,$end_date){
	$query="SELECT `order_status`, COUNT(order_code) as `shipments`  FROM `acc_orders` 
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) Group By `order_status` ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
		public function Get_Shipments_Pending_Summary($start_date,$end_date){
	$query="SELECT `order_status`, COUNT(`acc_orders`.order_code) as `shipments`  FROM `acc_orders` 
			 LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) AND `order_status`<>'Deliverd' AND `order_status`<>'RTS' AND `order_status`<>'Cancelled' AND `order_status`<>'LOST'  Group By `order_status` ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	public function Get_Shipments_CS_Summary($start_date,$end_date){
	$query="SELECT `order_status`, COUNT(`acc_orders`.order_code) as `shipments`  FROM `acc_orders` 
	LEFT JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`order_code`=`acc_orders`.`order_code`
			WHERE (date(`saimtech_arrival_detail`.`arrival_date`)>=? and  date(`saimtech_arrival_detail`.`arrival_date`)<=?) AND  `order_status`<>'Cancelled' AND `order_status`<>'LOST'  Group By `order_status` ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Admin_Customer_Summary($start_date,$end_date,$customer){
	$query="SELECT `order_status`, COUNT(order_code) as `shipments`  FROM `acc_orders`
	        LEFT JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			WHERE (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) and `customer_id`=? Group By `order_status` ";
	$res = $this->db->query($query,array($start_date,$end_date,$customer));
    return $res->result();
	}

	public function Get_Shipments_Admin_Summary_archive($start_date,$end_date){
	$query="SELECT `order_status`, COUNT(order_code) as `shipments`  FROM `saimtech_archive_order` 
			WHERE (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?) Group By `order_status` ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	
	public function Get_Shipments_Admin_Summary_Old($start_date,$end_date){
	$query="SELECT `status` as `order_status`, COUNT(cn) as `shipments`  FROM `saimtech_old_portal` 
			WHERE (date(`order_date`)>=? and  date(`order_date`)<=?) Group By `status` ";
	$res = $this->db->query($query,array($start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Branch($oid,$start_date,$end_date){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE (`origin_reporting`=? OR `destination_reporting`=? ) and (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}
	

	public function Get_Shipments_Branch_Archive($oid,$start_date,$end_date){
	$query="SELECT * FROM `saimtech_archive_order` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`saimtech_archive_order`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`saimtech_archive_order`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`saimtech_archive_order`.`order_service_type`
			WHERE (`origin_reporting`=? OR `destination_reporting`=? ) and (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?) Order By `saimtech_archive_order`.`order_date` DESC";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}	
	public function Get_Shipments_Branch_Old($oid,$start_date,$end_date){
	$query="SELECT * FROM `saimtech_old_portal`
	        LEFT JOIN `acc_customers` ON `acc_customers`.`old_portal_id`= `saimtech_old_portal`.`customer_id`
			WHERE (`origin`=? OR `destination`=? ) and (date(`order_date`)>=? and  date(`order_date`)<=?) Order By `order_date` DESC";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}
	
	
	public function Get_Shipments_Branch_Summary($oid,$start_date,$end_date){
	$query="SELECT  `order_status`, COUNT(order_code) as `shipments` FROM `acc_orders` 
			WHERE (`origin_reporting`=? OR `destination_reporting`=? ) and  (date(`acc_orders`.`order_date`)>=? and  date(`acc_orders`.`order_date`)<=?) Group By `order_status` ";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}

	public function Get_Shipments_Branch_Summary_Archive($oid,$start_date,$end_date){
	$query="SELECT  `order_status`, COUNT(order_code) as `shipments` FROM `saimtech_archive_order` 
			WHERE (`origin_reporting`=? OR `destination_reporting`=? ) and  (date(`saimtech_archive_order`.`order_date`)>=? and  date(`saimtech_archive_order`.`order_date`)<=?) Group By `order_status` ";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}
	
	public function Get_Shipments_Branch_Summary_Old($oid,$start_date,$end_date){
	$query="SELECT  `status` as `order_status`, COUNT(cn) as `shipments` FROM `saimtech_old_portal` 
			WHERE (`origin`=? OR `destination`=?  ) and  ((`order_date`)>=? and  date(`order_date`)<=?) Group By `status` ";
	$res = $this->db->query($query,array($oid,$oid,$start_date,$end_date));
    return $res->result();
	}

    
    //-------------------------------------------------------------
   /* public function Get_Pendding_Shipments_Admin(){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE order_status<>'ORDER' AND order_status<>'Booking' AND order_status<>'Deliverd' AND order_status<>'RTS' Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query);
    return $res->result();
	}
	
	public function Get_Pendding_Shipments_Admin_Summary(){
	$query="SELECT `order_status`, COUNT(order_code) as `shipments`  FROM `acc_orders` 
			WHERE order_status<>'ORDER' AND order_status<>'Booking' AND order_status<>'Deliverd' AND order_status<>'RTS' Group By `order_status` ";
	$res = $this->db->query($query);
    return $res->result();
	}
	
*/	
	public function Get_Pending_Shipments_Branch($oid){
	$query="SELECT *, DATEDIFF(CURDATE(),date(order_arrival_date)) as `DOS`,`acc_orders`.`modify_date` as `lastactivitydate` FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE DATEDIFF(CURDATE(),date(order_arrival_date))>3 AND (`origin_reporting`=? OR `destination_reporting`=? ) AND (order_status<>'ORDER' AND order_status<>'Booking' AND order_status<>'Cancelled' AND order_status<>'Deliverd' AND order_status<>'RTS') and is_final='0' Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($oid,$oid));
    return $res->result();
	}
	
	
	public function Get_Pending_Shipments_Sale($uid){
	$query="SELECT *, DATEDIFF(CURDATE(),date(order_arrival_date)) as `DOS`,`acc_orders`.`modify_date` as `lastactivitydate` FROM `acc_orders` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE DATEDIFF(CURDATE(),date(order_arrival_date))>3 AND (`acc_customers`.`created_by`=?) AND (order_status<>'ORDER' AND order_status<>'Booking' AND order_status<>'Cancelled' AND order_status<>'Deliverd' AND order_status<>'RTS') and is_final='0' Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($uid));
    return $res->result();
	}
	
	public function Get_Pending_Shipments_admin(){
	$query="SELECT *, DATEDIFF(CURDATE(),date(order_date)) as `DOS`,`acc_orders`.`modify_date` as `lastactivitydate` FROM `acc_orders` 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE DATEDIFF(CURDATE(),date(order_date))>3 AND (order_status<>'ORDER' AND order_status='Booking' AND order_status<>'Cancelled' AND order_status<>'Deliverd' AND order_status<>'RTS') and is_final='0' AND `order_date`>='2021-01-01' Order By `DOS` DESC";
	$res = $this->db->query($query);
    return $res->result();
	}
	
	public function Get_Pending_Pickups($origin_id){
	$query="SELECT * FROM `acc_orders` 
			INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
			INNER JOIN `acc_services` ON `acc_services`.`service_id`=`acc_orders`.`order_service_type`
			WHERE order_status='Booking' and is_final='0' AND `origin_city`=?  AND `manual_cn`='' AND `acc_orders`.`order_date`>='2021-02-15'  Order By `acc_orders`.`order_date` DESC";
	$res = $this->db->query($query,array($origin_id));
    return $res->result();
	}
	
	
//	public function Get_Pendding_Shipments_Branch_Summary($oid){
//	$query="SELECT  `order_status`, COUNT(order_code) as `shipments` FROM `acc_orders` 
//			WHERE (`origin_reporting`=? OR `destination_reporting`=? ) Group By `order_status` ";
//	$res = $this->db->query($query,array($oid,$oid));
  //  return $res->result();
	//}
	
 public function Get_Incomming_Pendings_By_Orgin($origin_id){
 $query="SELECT COUNT(order_code) as `cns` FROM `acc_orders` WHERE `destination_reporting`=? AND order_status='Loading'"; 
	$res = $this->db->query($query,array($origin_id));
    $row= $res->result_array();
    return $row[0]['cns'];
    
 }
 
 
 public function Get_Incomming_Pendings_By_Sale($uid){
  $query="SELECT COUNT(order_code) as `cns` FROM `acc_orders`
        INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
        WHERE `acc_customers`.`created_by`=? AND order_status='Loading'"; 
	$res = $this->db->query($query,array($uid));
    $row= $res->result_array();
    return $row[0]['cns'];
 }
 
  public function Get_Incomming_Pendings_By_Admin(){
    $query="SELECT COUNT(order_code) as `cns` FROM `acc_orders` WHERE order_status='Loading'"; 
	$res = $this->db->query($query);
    $row= $res->result_array();
    return $row[0]['cns'];
 }
 
 
 public function Get_Incomming_Pendings_By_Orgin_detail($origin_id){
 $query="SELECT * FROM `acc_orders` WHERE `destination_reporting`=? AND order_status='Loading'"; 
	$res = $this->db->query($query,array($origin_id));
    return $res->result();
    
 }
 
 public function Get_Incomming_Pendings_By_Sale_detail($uid){
 $query="SELECT * FROM `acc_orders` INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
        WHERE `acc_customers`.`created_by`=?  AND order_status='Loading'"; 
	$res = $this->db->query($query,array($uid));
    return $res->result();
    
 }
 
  public function Get_Incomming_Pendings_By_Admin_detail(){
 $query="SELECT * FROM `acc_orders` WHERE order_status='Loading'"; 
	$res = $this->db->query($query);
    return $res->result();
    
 }
 
 
  public function Get_Pendings_DD_By_Orgin_detail($origin_id){
  $query="SELECT delivery_code as Sheet,
          date(`saimtech_delivery_list`.delivery_date) as Date, 
          rider_name, 
          city_name, 
          COUNT(`saimtech_delivery_detail`.`order_code`) as `Pending_DD` 
          FROM `saimtech_delivery_list` 
          INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
          INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`saimtech_delivery_list`.`rider_id`
          INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_delivery_list`.`delivery_origin` 
          WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0  and `saimtech_delivery_list`.`delivery_origin`=?
          Group By `delivery_code`";
  $res = $this->db->query($query,array($origin_id));
  return $res->result();
  }
  
  
  public function Get_Pendings_Manifest_By_Orgin_detail($origin_id){
  $query="SELECT `transit_code` as manifest,
  COUNT(`saimtech_transit_detail`.`transit_cn`) AS `Total_CN`,
  `acc_city`.`city_name` AS City,
  `complete_sheet_date` AS date 
  FROM `saimtech_transit_list`
LEFT JOIN `acc_orders` ON `acc_orders`.`loading_id`=`saimtech_transit_list`.`transit_code`
LEFT JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_transit_list`.`transit_origin`
LEFT JOIN `saimtech_transit_detail` ON `saimtech_transit_detail`.`transit_list_id`=`saimtech_transit_list`.`transit_list_id`
WHERE `acc_orders`.`order_status`<>'Deliverd' AND `acc_orders`.`order_status`<>'Booking' 
AND `acc_orders`.`order_status`<>'Arrival' AND `acc_orders`.`order_status`<>'RTS' 
AND `acc_orders`.`order_status`<>'Cancelled' AND date(`saimtech_transit_list`.`created_date`)<='2021-02-01' AND  `transit_origin`=?
 group by `transit_code`";
  $res = $this->db->query($query,array($origin_id));
  return $res->result();
  }
  
  
    public function Get_Pendings_DD_By_Sale_detail($uid){
  $query="SELECT delivery_code as Sheet,
          date(`saimtech_delivery_list`.delivery_date) as Date, 
          rider_name, 
          city_name, 
          COUNT(`saimtech_delivery_detail`.`order_code`) as `Pending_DD` 
          FROM `saimtech_delivery_list` 
          INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
          INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`saimtech_delivery_list`.`rider_id`
          INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_delivery_list`.`delivery_origin` 
          INNER JOIN `acc_orders` ON `acc_orders`.`customer_id`=`acc_orders`.`on_route_id`=`saimtech_delivery_list`.`delivery_code` 
          INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
          WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0  and `acc_customers`.`created_by`=?
          Group By `delivery_code`";
  $res = $this->db->query($query,array($uid));
  return $res->result();
  }
  
  
   public function Get_Pendings_DD_By_Admin_detail(){
  $query="SELECT delivery_code as Sheet,
          date(`saimtech_delivery_list`.delivery_date) as Date, 
          rider_name, 
          city_name, 
          COUNT(`saimtech_delivery_detail`.`order_code`) as `Pending_DD` 
          FROM `saimtech_delivery_list` 
          INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
          INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`saimtech_delivery_list`.`rider_id`
          INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_delivery_list`.`delivery_origin` 
          WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0  
          Group By `delivery_code`";
  $res = $this->db->query($query);
  return $res->result();
  }
  
  
  public function Get_Pendings_DD_By_TPT_detail($uid){
  $query="SELECT delivery_code as Sheet,
          date(`saimtech_delivery_list`.delivery_date) as Date, 
          rider_name, 
          city_name, 
          COUNT(`saimtech_delivery_detail`.`order_code`) as `Pending_DD` 
          FROM `saimtech_delivery_list` 
          INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
          INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=`saimtech_delivery_list`.`rider_id`
          INNER JOIN `acc_city` ON `acc_city`.`city_id`=`saimtech_delivery_list`.`delivery_origin` 
          WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0  and  `saimtech_delivery_list`.`delivery_created_by`=? 
          Group By `delivery_code`";
  $res = $this->db->query($query,array($uid));
  return $res->result();
  }
  
   public function Get_Pendings_DD_By_Orgin_Count($origin_id){
    $query="SELECT COUNT(DISTINCT(`delivery_code`))as `Sheet` FROM `saimtech_delivery_list` 
            INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
            WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0 and  `saimtech_delivery_list`.`delivery_origin`=?"; 
	$res = $this->db->query($query,array($origin_id));
    $row= $res->result_array();
    return $row[0]['Sheet'];
    }
    
    
       public function Get_Pendings_DD_By_Sale_Count($uid){
    $query="SELECT COUNT(DISTINCT(`delivery_code`))as `Sheet` FROM `saimtech_delivery_list` 
            INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
            INNER JOIN `acc_orders` ON `acc_orders`.`customer_id`=`acc_orders`.`on_route_id`=`saimtech_delivery_list`.`delivery_code` 
            INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0 and `acc_customers`.`created_by`=?"; 
	$res = $this->db->query($query,array($uid));
    $row= $res->result_array();
    return $row[0]['Sheet'];
    }
    
    public function Get_Pendings_DD_By_TPT_Count($uid){
    $query="SELECT COUNT(DISTINCT(`delivery_code`)) as `Sheet` FROM `saimtech_delivery_list` 
            INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
            WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0 and  `saimtech_delivery_list`.`delivery_created_by`=?"; 
	$res = $this->db->query($query,array($uid));
    $row= $res->result_array();
    return $row[0]['Sheet'];
    }
    
    
    
    public function Get_Pendings_DD_By_Admin_Count(){
    $query="SELECT COUNT(DISTINCT(`delivery_code`))as `Sheet` FROM `saimtech_delivery_list` 
            INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` 
            WHERE `delivery_type` is null and `saimtech_delivery_detail`.`is_delivery2`=0 "; 
	$res = $this->db->query($query);
    $row= $res->result_array();
    return $row[0]['Sheet'];
    }
 
    public function Get_Pendings_Pickup_By_Orgin_Count($origin_id){
    $query="SELECT Count(DISTINCT(`load_sheet_id`)) as `LoadSheet` FROM `acc_orders` WHERE `order_status`='Booking' and `origin_city`=?"; 
	$res = $this->db->query($query,array($origin_id));
    $row= $res->result_array();
    return $row[0]['LoadSheet'];     
    }
    
     public function Get_Pendings_Pickup_By_Sale_Count($uid){
    $query="SELECT Count(DISTINCT(`load_sheet_id`)) as `LoadSheet` FROM `acc_orders` 
            INNER JOIN `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            WHERE `acc_customers`.`created_by`=? and `order_status`='Booking' "; 
	$res = $this->db->query($query,array($uid));
    $row= $res->result_array();
    return $row[0]['LoadSheet'];     
    }
    
    
    public function Get_Pendings_Pickup_By_Admin_Count(){
    $query="SELECT Count(DISTINCT(`load_sheet_id`)) as `LoadSheet` FROM `acc_orders` WHERE `order_status`='Booking' "; 
	$res = $this->db->query($query);
    $row= $res->result_array();
    return $row[0]['LoadSheet'];     
    }
    
    public function Get_Pendings_Pickup_By_Orgin_Detail($origin_id){
    $query="SELECT `customer_name` as `Shipper`,
            `load_sheet_id` as `LoadSheet`, 
            `origin_city_name` as `Origin`,
            `order_booking_date` as `BookingDate`,
            `saimtech_pickup_points`.`point` as `Pickup_Address`, 
            `saimtech_pickup_points`.`name`  as `Name`, 
            `saimtech_pickup_points`.`phone` as `Phone`,  
            COUNT(`order_id`) as `Shipments` 
            FROM `acc_orders` 
            INNER JOIN  `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            INNER JOIN  `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
            WHERE `order_status`='Booking' and `origin_city`=? group by `load_sheet_id` "; 
	$res = $this->db->query($query,array($origin_id));
    return $res->result();
    }
    
    
     public function Get_Pendings_Pickup_By_Sale_Detail($uid){
    $query="SELECT `customer_name` as `Shipper`,
            `load_sheet_id` as `LoadSheet`, 
            `origin_city_name` as `Origin`,
            `order_booking_date` as `BookingDate`,
            `saimtech_pickup_points`.`point` as `Pickup_Address`, 
            `saimtech_pickup_points`.`name`  as `Name`, 
            `saimtech_pickup_points`.`phone` as `Phone`,  
            COUNT(`order_id`) as `Shipments` 
            FROM `acc_orders` 
            INNER JOIN  `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            INNER JOIN  `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
            WHERE `order_status`='Booking' and `acc_customers`.`created_by`=? group by `load_sheet_id` "; 
	$res = $this->db->query($query,array($uid));
    return $res->result();
    }
    
    
    public function Get_Pendings_Pickup_By_Admin_Detail(){
    $query="SELECT `customer_name` as `Shipper`,
            `load_sheet_id` as `LoadSheet`, 
            `origin_city_name` as `Origin`,
            `order_booking_date` as `BookingDate`,
            `saimtech_pickup_points`.`point` as `Pickup_Address`, 
            `saimtech_pickup_points`.`name`  as `Name`, 
            `saimtech_pickup_points`.`phone` as `Phone`,  
            COUNT(`order_id`) as `Shipments` 
            FROM `acc_orders` 
            INNER JOIN  `acc_customers` ON `acc_customers`.`customer_id`=`acc_orders`.`customer_id`
            INNER JOIN  `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`acc_orders`.`pickup_point_id`
            WHERE `order_status`='Booking' group by `load_sheet_id` "; 
	$res = $this->db->query($query);
    return $res->result();
    }
	
	public function Get_TPT_Pending_Shipments($agent_id){
	$query="SELECT * FROM `saimtech_agent_order`
            WHERE (`agent_status`<> 'Deliverd' AND `agent_status`<> 'RTD' AND `agent_status`<> 'Hand Over To') and  agent_id=?"; 
	$res = $this->db->query($query,array($agent_id));
    return $res->result();    
	}
	
	public function Get_Pendings_Pickup_By_TPT_Count($agent_id){
    $query="SELECT Count(DISTINCT(`agent_order_code`)) as `countt` FROM `saimtech_agent_order` WHERE `agent_status`='Hand Over To' and `agent_id`=?  "; 
	$res = $this->db->query($query,array($agent_id));
    $row= $res->result_array();
    return $row[0]['countt'];     
    }
    
   	public function Get_Pendings_Pickup_By_TPT_Detail($agent_id){
    $query="SELECT * FROM `saimtech_agent_order` WHERE `agent_status`='Hand Over To' and `agent_id`=?  "; 
	$res = $this->db->query($query,array($agent_id));
    return $res->result();    
    }
    
	public function Get_All_Deliverd_TPT_Detail($agent_id){
	$query="SELECT * FROM `saimtech_agent_order` WHERE `agent_status`='Deliverd' and `agent_id`=?  "; 
	$res = $this->db->query($query,array($agent_id));
    return $res->result();        
	}
	
	public function Get_All_RTD_TPT_Detail($agent_id){
	$query="SELECT * FROM `saimtech_agent_order` WHERE `agent_status`='RTD' and `agent_id`=?  "; 
	$res = $this->db->query($query,array($agent_id));
    return $res->result();        
	}
	
}
