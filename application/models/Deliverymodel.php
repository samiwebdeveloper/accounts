<?php
class Deliverymodel extends CI_Model {

	
public function Get_Order_By_Code($cn){
$query="SELECT *  FROM `saimtech_order` WHERE  (`order_code`=? OR `manual_cn`=?) ";
$res = $this->db->query($query,array($cn,$cn));
return $res->result_array();
}

public function Check_Delivery_Sheet_Code($code){
$query="SELECT *  FROM `saimtech_delivery_list`
WHERE `saimtech_delivery_list`.`delivery_code`=? ";
$res = $this->db->query($query,array($code));
return $res->num_rows();	
}

public function Get_Delivery_Status_By_Code($code){
$query="SELECT *  FROM `saimtech_delivery_list`
WHERE `saimtech_delivery_list`.`delivery_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result_array();
}

public function Update_Delivery_Riders(){
$query="UPDATE `saimtech_order` A SET `delivery_rider_id`=(SELECT saimtech_delivery_list.rider_id FROM saimtech_delivery_list WHERE A.on_route_id = saimtech_delivery_list.delivery_code) WHERE order_status='Deliverd'";
$this->db->query($query);
}

//SELECT `delivery_list_id`, `rider_id`, `route_id`, `delivery_code`, `delivery_origin`, `delivery_date`, `ip`, `delivery_created_by`, `delivery2_date`, `delivery2_created_by`, `rr_date`, `rr_created_by`, `modify_by`, `modify_date` FROM `saimtech_delivery_list` WHERE 1

//SELECT `delivery_detail_id`, `delivery_list_id`, `order_code`, `name`, `phone`, `address`, `cod`, `weight`, `delivery_date`, `is_delivery2`, `delivery2_created_by`, `delivery2_date`, `delivery2_status`, `delivery2_remark`, `is_rr`, `rr_date`, `rr_created_by` FROM `saimtech_delivery_detail` WHERE 1
public function Get_Delivery_Sheets_By_Origin($origin,$startdate,$enddate){
$query="SELECT *, COUNT(`saimtech_delivery_detail`.`order_code`) AS `Total`  FROM `saimtech_delivery_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_delivery_list`.`delivery_origin`
		INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id`=  `saimtech_delivery_list`.`delivery_list_id`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_delivery_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_delivery_list`.`delivery_created_by`
        WHERE   `saimtech_delivery_list`.`delivery_origin`=? and (date(`saimtech_delivery_list`.`delivery_date`)>=? and  date(`saimtech_delivery_list`.`delivery_date`)<=?) GROUP BY `delivery_code` ORDER BY `saimtech_delivery_list`.`delivery_date` DESC	 ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}

public function Get_Delivery_Sheets_By_User($userid,$startdate,$enddate){
$query="SELECT *  FROM `saimtech_delivery_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_delivery_list`.`delivery_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_delivery_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_delivery_list`.`delivery_created_by`
		WHERE   `saimtech_delivery_list`.`delivery_created_by`=? and (date(`delivery_date`)>=? and  date(`delivery_date`)<=?) ORDER BY `saimtech_delivery_list`.`delivery_list_id` DESC ";
$res = $this->db->query($query,array($userid,$startdate,$enddate));
return $res->result();
}

public function Get_Delivery_Sheets_By_Origin_Archive($origin,$startdate,$enddate){
$query="SELECT *  FROM `saimtech_archive_delivery_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_archive_delivery_list`.`delivery_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_archive_delivery_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_delivery_list`.`delivery_created_by`
		WHERE  `delivery_origin`=? and (date(`delivery_date`)>=? and  date(`delivery_date`)<=?) ORDER BY `saimtech_archive_delivery_list`.`delivery_list_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}


public function Get_Delivery_Sheets_By_User_Archive($userid,$startdate,$enddate){
$query="SELECT *  FROM `saimtech_archive_delivery_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_archive_delivery_list`.`delivery_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_archive_delivery_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_delivery_list`.`delivery_created_by`
		WHERE  saimtech_delivery_list`.`delivery_created_by`=? and (date(`delivery_date`)>=? and  date(`delivery_date`)<=?) ORDER BY `saimtech_archive_delivery_list`.`delivery_list_id` DESC ";
$res = $this->db->query($query,array($userid,$startdate,$enddate));
return $res->result();
}

public function Get_ReDelivery_Sheets_By_Origin($origin){
$query="SELECT *  FROM `saimtech_delivery_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_delivery_list`.`delivery_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_delivery_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_delivery_list`.`delivery_created_by`
		WHERE  `delivery_origin`=? and `delivery_type`='Return' ORDER BY `saimtech_delivery_list`.`delivery_list_id` DESC ";
$res = $this->db->query($query,array($origin));
return $res->result();
}

public function Get_Delivery_Sheet_By_Code($code){
$query="SELECT `saimtech_delivery_detail`.`delivery_date` as `date`, `saimtech_order`.`order_code` as `cn`,`saimtech_order`.`manual_cn` as `manual`, `saimtech_delivery_list`.`delivery_list_id` as `id`, delivery_code as `Sheet`, `name`, `saimtech_order`.`weight`, `phone`, `address`, `cod`, `delivery_detail_id` AS `d_id` FROM `saimtech_delivery_detail` INNER JOIN `saimtech_delivery_list` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id` INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code` = `saimtech_delivery_detail`.`order_code` WHERE `saimtech_delivery_list`.`delivery_code`=? ORDER BY `saimtech_delivery_detail`.`delivery_detail_id` DESC";
$res = $this->db->query($query,array($code));
return $res->result();	
}

public function Get_Delivery_Sheet_By_Code_Nums($code){
$query="SELECT `saimtech_delivery_detail`.`delivery_date` as `date`, `order_code` as `cn`, `saimtech_delivery_list`.`delivery_list_id` as `id`, delivery_code as `Sheet`, `name`, `weight`, `phone`, `address`, `cod`, `delivery_detail_id` AS `d_id`   FROM `saimtech_delivery_list`
INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.`delivery_list_id` = `saimtech_delivery_list`.`delivery_list_id`
WHERE `saimtech_delivery_list`.`delivery_code`=?  ORDER BY `saimtech_delivery_detail`.`delivery_detail_id` DESC";
$res = $this->db->query($query,array($code));
return $res->num_rows();		
}


public function Get_Incomplete_Delivery_Sheet($userid){
$query="SELECT `delivery_code` as `sheetcode`,`delivery_list_id`, rider_code, rider_name, route_code, route_name, `saimtech_delivery_list`.`rider_id` as `riderid`, `saimtech_delivery_list`.`route_id` as `routeid`   FROM `saimtech_delivery_list` 
LEFT JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_delivery_list`.`rider_id`
LEFT JOIN `saimtech_route` ON `saimtech_route`.`route_id`=  `saimtech_delivery_list`.`route_id`
 WHERE `delivery_created_by`=? and `is_delivery_complete`=0  order by `delivery_list_id`  DESC ";
$res = $this->db->query($query,array($userid));
return $res->result_array();
}

public function Get_Incomplete_Delivery_Sheet_Count($userid){
$query="SELECT `delivery_code` as `sheetcode`,`delivery_list_id`   FROM `saimtech_delivery_list`  WHERE `delivery_created_by`=? and `is_delivery_complete`=0";
$res = $this->db->query($query,array($userid));
return $res->num_rows();
}



Public function Get_Incomplete_ReDelivery_Sheet($userid){
$query="SELECT `delivery_code` as `sheetcode`,`delivery_list_id`, rider_code, rider_name, route_code, route_name, `saimtech_delivery_list`.`rider_id` as `riderid`, `saimtech_delivery_list`.`route_id` as `routeid`   FROM `saimtech_delivery_list` 
Left JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_delivery_list`.`rider_id`
Left JOIN `saimtech_route` ON `saimtech_route`.`route_id`=  `saimtech_delivery_list`.`route_id`
 WHERE `delivery_created_by`=? and `is_delivery_complete`=0 and delivery_type='Return' order by `delivery_list_id`  DESC ";
$res = $this->db->query($query,array($userid));
return $res->result_array();
}

Public function Get_Incomplete_ReDelivery_Sheet_Count($userid){
$query="SELECT Count(`delivery_code`) as `sheetcode`   FROM `saimtech_delivery_list`  WHERE `delivery_created_by`=? and is_delivery_complete=0 and delivery_type='Return'";
$res = $this->db->query($query,array($userid));
$ro=$res->result_array();
return $ro[0]['sheetcode'];
}


public function Get_Delivery_Print_Sheet_By_Code($code){
$query="SELECT *,`saimtech_order`.`manual_cn` as `manual`,`saimtech_order`.`pieces` AS `pcs`,`saimtech_order`.`order_pay_mode`,`saimtech_order`.`cod_amount` AS `COD` FROM `saimtech_delivery_detail`
INNER JOIN `saimtech_order` 	ON `saimtech_order`.`order_code` =  `saimtech_delivery_detail`.`order_code`
INNER JOIN `saimtech_delivery_list` 	ON `saimtech_delivery_list`.`delivery_list_id`=  `saimtech_delivery_detail`.`delivery_list_id` 
INNER JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
INNER JOIN `saimtech_route` 	ON `saimtech_route`.`route_id`			=  `saimtech_delivery_list`.`route_id`
INNER JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
WHERE `saimtech_delivery_list`.`delivery_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();
}


public function Get_Delivery_Print_Sheet_By_Code_Archive($code){
$query="SELECT * FROM `saimtech_archive_delivery_list`
INNER JOIN `saimtech_archive_delivery_detail` 	ON `saimtech_archive_delivery_detail`.`delivery_list_id`=  `saimtech_archive_delivery_list`.`delivery_list_id` 
INNER JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_archive_delivery_list`.`rider_id`
INNER JOIN `saimtech_route` 	ON `saimtech_route`.`route_id`			=  `saimtech_archive_delivery_list`.`route_id`
INNER JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_archive_delivery_list`.`delivery_origin`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_archive_delivery_list`.`delivery_created_by`
WHERE `delivery_code`=?  ";
$res = $this->db->query($query,array($code));
return $res->result();
}




public function Get_ReDelivery_Print_Sheet_By_Code($code){
$query="SELECT * FROM `saimtech_delivery_list`
INNER JOIN `saimtech_delivery_detail` 	ON `saimtech_delivery_detail`.`delivery_list_id`=  `saimtech_delivery_list`.`delivery_list_id` 
INNER JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
INNER JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
WHERE `delivery_code`=?  ";
$res = $this->db->query($query,array($code));
return $res->result();
}

public function Check_CN($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE `order_code`=? or manual_cn= ? ";
$res = $this->db->query($query,array($cn,$cn));
return $res->num_rows();	
}

public function Check_M_CN($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->num_rows();	
}

public function Get_All_Arrival_Sheets($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE (`order_code`=? or manual_cn=?) ";
$res = $this->db->query($query,array($cn));
return $res->num_rows();	
}


public function Get_City_Detail_By_id($id){
$query="SELECT *  FROM `saimtech_city` WHERE `city_id`=? ";
$res = $this->db->query($query,array($id));
return $res->result_array();
}



public function Get_Last_Delivery_Sheet_Code(){
$id=0;
$code=0;
$year=0;
$sy_y=0;
$select_query="SELECT * from saimtech_order_code";
$res = $this->db->query($select_query);
$row=$res->result_array();
$id=$row[0]['delivery_sheet_code'];
$sys_y=$row[0]['order_year'];
if($sys_y==date('y')){
$code=(($id)+1);
$year=$sys_y;
} else {
$code=1;
$year=date('y');	
}
$query="UPDATE `saimtech_order_code` SET `delivery_sheet_code`=?,`order_year`=? WHERE 1";
$res = $this->db->query($query,array($code,$year));
return $code;
}



 

//-------------Remove---------------
public function Get_Order_Detail_By_CN($cn){
$query="SELECT * FROM `saimtech_order`  WHERE order_code=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();	
}

public function Get_Order_Tracking_ID_By_CN($cn){
$query="SELECT * FROM `saimtech_delivery_detail`  WHERE order_code=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();
}

//-------------Remove------------END


public function Run_Boost_Up(){
$this->db->trans_start();	    
$query0="INSERT INTO `saimtech_archive_delivery_temp` SELECT 
`saimtech_delivery_list`.`delivery_list_id`,
`saimtech_delivery_detail`.`delivery_detail_id`
FROM `saimtech_delivery_list` 
INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.delivery_list_id= `saimtech_delivery_list`.`delivery_list_id`
WHERE 
DATEDIFF(CURDATE(),date(`saimtech_delivery_list`.`delivery_date`))>20
AND DATEDIFF(CURDATE(),date(`saimtech_delivery_detail`.`delivery2_date`))>20
AND `saimtech_delivery_detail`.`is_delivery2`=1";
$res = $this->db->query($query0);

$query="INSERT INTO `saimtech_archive_delivery_list` SELECT 
`saimtech_delivery_list`.`delivery_list_id`,
`saimtech_delivery_list`.`rider_id`,
`saimtech_delivery_list`.`route_id`,
`saimtech_delivery_list`.`delivery_code`,
`saimtech_delivery_list`.`delivery_origin`,
`saimtech_delivery_list`.`delivery_type`,
`saimtech_delivery_list`.`delivery_date`,
`saimtech_delivery_list`.`is_delivery_complete`,
`saimtech_delivery_list`.`ip`,
`saimtech_delivery_list`.`delivery_created_by`,
`saimtech_delivery_list`.`delivery2_date`,
`saimtech_delivery_list`.`is_delivery2_complete`,
`saimtech_delivery_list`.`delivery2_created_by`,
`saimtech_delivery_list`.`rr_date`,
`saimtech_delivery_list`.`is_rr_complete`,
`saimtech_delivery_list`.`rr_created_by`,
`saimtech_delivery_list`.`modify_by`,
`saimtech_delivery_list`.`modify_date`
FROM `saimtech_delivery_list` 
WHERE `saimtech_delivery_list`.`delivery_list_id` IN (SELECT  DISTINCT(`saimtech_archive_delivery_temp`.`delivery_list_id`) FROM  `saimtech_archive_delivery_temp` )";
$res = $this->db->query($query);    
$query1="INSERT INTO `saimtech_archive_delivery_detail` SELECT 
`saimtech_delivery_detail`.`delivery_detail_id`,
`saimtech_delivery_detail`.`delivery_list_id`,
`saimtech_delivery_detail`.`order_code`,
`saimtech_delivery_detail`.`order_detail_id`,
`saimtech_delivery_detail`.`name`,
`saimtech_delivery_detail`.`phone`,
`saimtech_delivery_detail`.`address`,
`saimtech_delivery_detail`.`cod`,
`saimtech_delivery_detail`.`weight`,
`saimtech_delivery_detail`.`delivery_date`,
`saimtech_delivery_detail`.`is_delivery2`,
`saimtech_delivery_detail`.`delivery2_created_by`,
`saimtech_delivery_detail`.`delivery2_date`,
`saimtech_delivery_detail`.`delivery2_status`,
`saimtech_delivery_detail`.`delivery2_remark`,
`saimtech_delivery_detail`.`is_rr`,
`saimtech_delivery_detail`.`rr_date`,
`saimtech_delivery_detail`.`rr_created_by`
FROM `saimtech_delivery_detail` 
WHERE `saimtech_delivery_detail`.`delivery_detail_id` IN (SELECT  DISTINCT(`saimtech_archive_delivery_temp`.`delivery_detail_id`) FROM  `saimtech_archive_delivery_temp` )";
$res = $this->db->query($query1);    
$query_delete1="DELETE FROM `saimtech_delivery_list` WHERE `delivery_list_id` IN (SELECT DISTINCT(`saimtech_archive_delivery_temp`.`delivery_list_id`) FROM `saimtech_archive_delivery_temp`)";
$this->db->query($query_delete1); 
$query_delete2="DELETE FROM `saimtech_delivery_detail` WHERE `delivery_detail_id` IN (SELECT `saimtech_archive_delivery_temp`.`delivery_detail_id` FROM `saimtech_archive_delivery_temp`)";
$this->db->query($query_delete2);
$query_delete3="DELETE FROM `saimtech_archive_delivery_temp` WHERE 1";
$this->db->query($query_delete3);
$this->db->trans_complete();
}

public function Pendding_Archive(){
$query="SELECT 
COUNT(`saimtech_delivery_list`.`delivery_list_id`) as `records`
FROM `saimtech_delivery_list` 
INNER JOIN `saimtech_delivery_detail` ON `saimtech_delivery_detail`.delivery_list_id= `saimtech_delivery_list`.`delivery_list_id`
WHERE 
DATEDIFF(CURDATE(),date(`saimtech_delivery_list`.`delivery_date`))>20
AND DATEDIFF(CURDATE(),date(`saimtech_delivery_detail`.`delivery2_date`))>20
AND `saimtech_delivery_detail`.`is_delivery2`=1";
$res=$this->db->query($query);
$row = $res->result_array();
return $row[0]['records'];
}

public function Get_OSA_By_ID($uid){
$date=date('Y-m-d');    
$query="SELECT * FROM `saimtech_osa`  WHERE created_by=? and date(created_date)=? ";
$res = $this->db->query($query,array($uid,$date));
return $res->result();	
}
public function Get_Thirty_Days_OSA(){
$date=date('Y-m-d');    
$query="SELECT * FROM `saimtech_osa` WHERE created_date >= (CURDATE() - INTERVAL 1 MONTH ) ORDER BY post ASC";
$res = $this->db->query($query); 
return $res->result();	
}


}