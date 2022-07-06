<?php
class Pickupmodel extends CI_Model {

	
public function Get_Pickup_Data_By_Date_Range($origin,$startdate,$enddate){
$query="SELECT * FROM `saimtech_pickup_request`
        INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`= `saimtech_pickup_request`.`customer_id`
        WHERE (`pickup_date`>=? and `pickup_date`<=?) and `saimtech_pickup_request`.`origin_id`=? ";
$res = $this->db->query($query,array($startdate,$enddate,$origin));
return $res->result();
}

public function Get_Newly_Enter_Pickup_Request($user){
$date=date('Y-m-d');    
$query="SELECT * FROM `saimtech_pickup_request`
        INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`= `saimtech_pickup_request`.`customer_id`
        WHERE `saimtech_pickup_request`.`pickup_date`=? and `saimtech_pickup_request`.`created_by`=? ";
$res = $this->db->query($query,array($date,$user));
return $res->result();    
}



}