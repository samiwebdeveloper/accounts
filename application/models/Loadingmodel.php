<?php
class Loadingmodel extends CI_Model {


public function Get_Loading_Sheets_By_Origin($origin,$startdate,$enddate){
$query="SELECT *,`C`.`city_name` as `Current`  FROM `saimtech_transit_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_transit_list`.`transit_origin`
		INNER JOIN `saimtech_city` C ON C.`city_id`=  `saimtech_transit_list`.`current_location`
		INNER JOIN `saimtech_route_list` ON `saimtech_route_list`.`route_list_id`=  `saimtech_transit_list`.`transit_route_id`
		Left JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_transit_list`.`created_by`
		WHERE  `transit_origin`=?  and (date(`saimtech_transit_list`.`created_date`)>=? and  date(`saimtech_transit_list`.`created_date`)<=?)  ORDER BY `saimtech_transit_list`.`transit_list_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}

public function Get_Pending_Un_Loading_Sheets_By_Origin($origin){
 $query="SELECT *, date(`saimtech_transit_list`.`transit_date`) as `tDate`,TD.city_name as `TransitD`, AD.city_name as `ActaulD` FROM `saimtech_transit_detail`
        INNER JOIN `saimtech_transit_list`      ON `saimtech_transit_list`.`transit_list_id`=`saimtech_transit_detail`.`transit_list_id`
		INNER JOIN `saimtech_city`          TD  ON TD.`city_id`=  `saimtech_transit_detail`.`destination`
		INNER JOIN `saimtech_city`          AD  ON AD.`city_id`=  `saimtech_transit_detail`.`actual_destination`
		INNER JOIN `saimtech_order`     		ON `saimtech_order`.`order_code`=  `saimtech_transit_detail`.`transit_cn`
		WHERE `saimtech_transit_detail`.`is_unload`=0 and destination=? order by `saimtech_transit_list`.`transit_list_id` DESC";
		$res = $this->db->query($query,array($origin));
return $res->result();
}
 
 public function Get_Pending_Un_Loading_Sheets(){
 $query="SELECT *,  date(`saimtech_transit_list`.`transit_date`) as `tDate`,TD.city_name as `TransitD`, AD.city_name as `ActaulD` FROM `saimtech_transit_detail`
        INNER JOIN `saimtech_transit_list`      ON `saimtech_transit_list`.`transit_list_id`=`saimtech_transit_detail`.`transit_list_id`
		INNER JOIN `saimtech_city`          TD  ON TD.`city_id`=  `saimtech_transit_detail`.`destination`
		INNER JOIN `saimtech_city`          AD  ON AD.`city_id`=  `saimtech_transit_detail`.`actual_destination`
		INNER JOIN `saimtech_order`     		ON `saimtech_order`.`order_code`=  `saimtech_transit_detail`.`transit_cn`
		WHERE `saimtech_transit_detail`.`is_unload`=0  and is_final=0 order by `saimtech_transit_list`.`transit_list_id` DESC";
		$res = $this->db->query($query);
return $res->result();
}
 
public function Get_Loading_Detail_By_Detail_ID($id){
$query="SELECT * FROM `saimtech_transit_detail`
        WHERE transit_detail_id=?";
$res = $this->db->query($query,array($id));
return $res->result_array();    
} 
 

public function Get_Loading_Sheet_By_ID($id){
$query="SELECT *, `saimtech_order`.`origin_city_name`,`saimtech_route_list`.`route_service_name` AS `sname`,`saimtech_transit_list`.`transit_date` as `tDate`,`saimtech_transit_list`.`complete_sheet_date` as `CompleteDate`,TD.city_name as `TransitD`, AD.city_name as `ActaulD`,`saimtech_order`.`order_pay_mode` FROM `saimtech_transit_list`
		INNER JOIN `saimtech_transit_detail` ON `saimtech_transit_detail`.`transit_list_id`=  `saimtech_transit_list`.`transit_list_id`
		INNER JOIN `saimtech_city`          TD ON TD.`city_id`=  `saimtech_transit_detail`.`destination`
		INNER JOIN `saimtech_city`          AD ON AD.`city_id`=  `saimtech_transit_detail`.`actual_destination`
		INNER JOIN `saimtech_order`     ON `saimtech_order`.`order_code`=  `saimtech_transit_detail`.`transit_cn`
		INNER JOIN `saimtech_route_list`     ON `saimtech_route_list`.`route_list_id`=  `saimtech_transit_list`.`transit_route_id`
		LEFT  JOIN `saimtech_oper_user`      ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_transit_list`.`created_by`
		WHERE saimtech_transit_list.transit_list_id=?  ORDER BY AD.city_name DESC ";
$res = $this->db->query($query,array($id));
return $res->result();
}

public function Get_Loading_Sheet_By_ID2($id){
$query="SELECT `saimtech_city`.`city_name` AS `hub` FROM `saimtech_route_detail`
INNER JOIN `saimtech_route_list` ON `saimtech_route_detail`.`route_list_id`=`saimtech_route_list`.`route_list_id`
INNER JOIN `saimtech_transit_list` ON `saimtech_route_detail`.`route_list_id`=`saimtech_transit_list`.`transit_route_id`
INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=`saimtech_route_detail`.`city_id`
Where `saimtech_transit_list`.`transit_list_id`=? AND `saimtech_route_detail`.`type`='D' ";
$res = $this->db->query($query,array($id));
return $res->result();
}

public function Get_Loading_Sheet_Detail_Destination_By_ID($id){
$query="SELECT DISTINCT(`destination`) as dest FROM `saimtech_transit_detail` WHERE   transit_list_id=? ORDER BY `destination` DESC";
$res = $this->db->query($query,array($id));
return $res->result();
}

public function Get_Loading_Sheet_By_Sheet_Code($code){
$query="SELECT *,AD.city_name as `ActualD`, `saimtech_transit_list`.`transit_date` as `tDate` FROM `saimtech_transit_list`
		INNER JOIN `saimtech_transit_detail` ON `saimtech_transit_detail`.`transit_list_id`=  `saimtech_transit_list`.`transit_list_id`
		INNER JOIN `saimtech_city`        TD ON TD.`city_id`=  `saimtech_transit_detail`.`destination`
		INNER JOIN `saimtech_order`          ON `saimtech_order`.`order_code`=  `saimtech_transit_detail`.`transit_cn`
		INNER JOIN `saimtech_city`        AD ON AD.`city_id`=  `saimtech_transit_detail`.`actual_destination`
		INNER JOIN `saimtech_route_list`     ON `saimtech_route_list`.`route_list_id`=  `saimtech_transit_list`.`transit_route_id`
		LEFT  JOIN `saimtech_oper_user`      ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_transit_list`.`created_by`
		WHERE saimtech_transit_list.transit_code=?  ORDER BY `saimtech_transit_detail`.`transit_detail_id` DESC";
$res = $this->db->query($query,array($code));
return $res->result();
}




public function Get_Last_Loading_Sheet_Code(){
$id=0;
$code=0;
$year=0;
$sy_y=0;
$select_query="SELECT * from saimtech_order_code";
$res = $this->db->query($select_query);
$row=$res->result_array();
$id=$row[0]['loading_sheet_code'];
$sys_y=$row[0]['order_year'];
if($sys_y==date('y')){
$code=(($id)+1);
$year=$sys_y;
} else {
$code=1;
$year=date('y');	
}
$query="UPDATE `saimtech_order_code` SET `loading_sheet_code`=?,`order_year`=? WHERE 1";
$res = $this->db->query($query,array($code,$year));
return $code;
}

Public function Get_Order_Detail_By_CN($cn){
$query="SELECT * FROM `saimtech_order`  WHERE order_code=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();	
}




}