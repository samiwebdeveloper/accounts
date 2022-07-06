<?php
class Archivemodel extends CI_Model {

	//======================================================================
	//START--------------Creating Archive-------------------------
	//======================================================================
	
	
	public function Fill_Order_Archive(){
	$this->db->trans_start();		
	$query="INSERT INTO `saimtech_archive_order` SELECT `saimtech_order`.* FROM `saimtech_order` INNER JOIN `saimtech_invoice` ON `saimtech_invoice`.`invoice_code`=`saimtech_order`.`invoice_id` WHERE is_invoice=1 and is_final=1 and (`order_status`='Deliverd' OR `order_status`='RTS')  and DATEDIFF(CURDATE(),date(invoice_date))>20 LIMIT 500";
	$this->db->query($query);
	$query="DELETE FROM `saimtech_order` WHERE order_id IN (SELECT `order_id` FROM `saimtech_archive_order`)";
	$this->db->query($query);
	$this->db->trans_complete();
	}
	
	public function Pendding_Archive(){
    $query="SELECT COUNT(order_id) as `records` FROM `saimtech_order` INNER JOIN `saimtech_invoice` ON `saimtech_invoice`.`invoice_code`=`saimtech_order`.`invoice_id` WHERE is_invoice=1 and is_final=1  and (`order_status`='Deliverd' OR `order_status`='RTS')  and DATEDIFF(CURDATE(),date(invoice_date))>20";
	$res=$this->db->query($query);
	$row = $res->result_array();
	return $row[0]['records'];
	
	}

}
