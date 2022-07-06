<?php
class Ratingmodel extends CI_Model {

	
	public function Update_Cheezmall_Rates(){
	$query1="UPDATE `saimtech_order` SET  rate_id=0, `order_rate`='75',	`order_sc`='75', `order_gst`='12', order_total_amount='87' WHERE customer_id=27 and  weight<=0.5 and destination_city<>origin_city  and rate_id<>0";
	$this->db->query($query1);
    $query2="UPDATE `saimtech_order` SET  rate_id=0, `order_rate`='65', `order_sc`='65', `order_gst`='10', order_total_amount='75' WHERE customer_id=27 and  weight<=0.5 and destination_city=origin_city and rate_id<>0";
	$this->db->query($query2);
    $query3="UPDATE `saimtech_order` SET  rate_id=0, `order_rate`='80', `order_sc`='80', `order_gst`='13', order_total_amount='93' WHERE customer_id=27 and (weight>0.5 and weight<=1) and destination_city<>origin_city and rate_id<>0";
	$this->db->query($query3);
    $query4="UPDATE `saimtech_order` SET  rate_id=0, `order_rate`='70',	`order_sc`='70', `order_gst`='11', order_total_amount='81' WHERE customer_id=27 and (weight>0.5 and weight<=1) and destination_city=origin_city  and rate_id<>0";
	$this->db->query($query4);
    $query5="UPDATE `saimtech_order` SET  rate_id=0, `order_rate`='325', `order_sc`='325',`order_gst`='52', order_total_amount='377' WHERE customer_id=27 and (weight>1 and weight<=5) 	and destination_city=origin_city   and rate_id<>0";
	$this->db->query($query5);
    $query6="UPDATE `saimtech_order` SET  rate_id=0,  `order_rate`='650', `order_sc`='650',`order_gst`='100',order_total_amount='750' WHERE customer_id=27 and (weight>5 and weight<=10) and destination_city=origin_city   and rate_id<>0";
	$this->db->query($query6);
    $query7="UPDATE `saimtech_order` SET  rate_id=0,  `order_rate`='375', `order_sc`='375',`order_gst`='60',order_total_amount='435' WHERE customer_id=27 and (weight>1 and weight<=5) 	and destination_city<>origin_city   and rate_id<>0";
	$this->db->query($query7);
    $query8="UPDATE `saimtech_order` SET  rate_id=0,  `order_rate`='700', `order_sc`='700',	`order_gst`='112', order_total_amount='812' WHERE customer_id=27 and (weight>5 and weight<=10) 	and destination_city<>origin_city  and rate_id<>0";
	$this->db->query($query8);
    $query9="UPDATE `saimtech_order` SET  rate_id=0,  `order_rate`=(700+((ceil(weight)-10)*70)), `order_sc`=(700+((ceil(weight)-10)*70)),`order_gst`=(((700+((ceil(weight)-10)*70))*16)/100), order_total_amount=((700+((ceil(weight)-10)*70))+(((700+((ceil(weight)-10)*70))*16)/100)) WHERE customer_id=27 and  weight>10  and destination_city<>origin_city and rate_id<>0";
	$this->db->query($query9);
    $query10="UPDATE `saimtech_order` SET  rate_id=0,  `order_rate`=(650+((ceil(weight)-10)*65)),	`order_sc`=(700+((ceil(weight)-10)*70)),`order_gst`=(((650+((ceil(weight)-10)*65))*16)/100), order_total_amount=((650+((ceil(weight)-10)*65))+(((650+((ceil(weight)-10)*65))*16)/100))	WHERE customer_id=27 and  weight>10  and destination_city=origin_city  and rate_id<>0";
	$this->db->query($query10);
  
	}
	
	
	
}