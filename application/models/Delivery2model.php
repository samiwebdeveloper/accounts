<?php
class Delivery2model extends CI_Model {

	
public function Get_Delivery_Sheet_By_Code($code){
$query="SELECT * FROM `saimtech_delivery_list`
LEFT JOIN `saimtech_delivery_detail` 	ON `saimtech_delivery_detail`.`delivery_list_id`=  `saimtech_delivery_list`.`delivery_list_id` 
LEFT JOIN `saimtech_rider`          	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
LEFT JOIN `saimtech_route` 	            ON `saimtech_route`.`route_id`			=  `saimtech_delivery_list`.`route_id`
LEFT JOIN `saimtech_city` 	        	ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
LEFT JOIN `saimtech_oper_user`          ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
WHERE `delivery_code`=?  and is_delivery_complete=1";
$res = $this->db->query($query,array($code));
return $res->result();
}


public function Get_Return_Sheet_By_Code($code){
$query="SELECT * FROM `saimtech_delivery_list`
LEFT JOIN `saimtech_delivery_detail` 	ON `saimtech_delivery_detail`.`delivery_list_id`=  `saimtech_delivery_list`.`delivery_list_id` 
LEFT JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
LEFT JOIN `saimtech_route` 	ON `saimtech_route`.`route_id`			=  `saimtech_delivery_list`.`route_id`
LEFT JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
LEFT JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
LEFT JOIN `saimtech_order` ON `saimtech_order`.`order_code`	=  `saimtech_delivery_detail`.`order_code`
WHERE `delivery_code`=?  AND delivery_type='Return'  ";
$res = $this->db->query($query,array($code));
return $res->result();    
}


public function Get_RR_Sheet_By_Code($code){
$query="SELECT * FROM `saimtech_order`
LEFT JOIN `saimtech_delivery_list` 	ON `saimtech_delivery_list`.`delivery_code`=  `saimtech_order`.`on_route_id` 
LEFT JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
LEFT JOIN `saimtech_route` 	ON `saimtech_route`.`route_id`			=  `saimtech_delivery_list`.`route_id`
LEFT JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
LEFT JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
WHERE `on_route_id`=? AND  order_status='Deliverd'";
$res = $this->db->query($query,array($code));
return $res->result();    
}


public function Get_Delivery_Sheet_By_Detail_id($id){
$query="SELECT * FROM `saimtech_delivery_list`
LEFT JOIN `saimtech_delivery_detail` 	ON `saimtech_delivery_detail`.`delivery_list_id`=  `saimtech_delivery_list`.`delivery_list_id` 
LEFT JOIN `saimtech_rider` 	ON `saimtech_rider`.`rider_id`			=  `saimtech_delivery_list`.`rider_id`
LEFT JOIN `saimtech_route` 	ON `saimtech_route`.`route_id`			=  `saimtech_delivery_list`.`route_id`
LEFT JOIN `saimtech_city` 		ON `saimtech_city`.`city_id`			=  `saimtech_delivery_list`.`delivery_origin`
LEFT JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`	=  `saimtech_delivery_list`.`delivery_created_by`
WHERE `saimtech_delivery_detail`.`delivery_detail_id`=?  ";
$res = $this->db->query($query,array($id));
return $res->result_array();
}

}