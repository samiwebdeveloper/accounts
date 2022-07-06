<?php
class Returnmodel extends CI_Model {

	
public function Get_Order_By_Code($cn){
$query="SELECT *  FROM `saimtech_order` WHERE  `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();
}

public function Check_CN($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->num_rows();	
}



}