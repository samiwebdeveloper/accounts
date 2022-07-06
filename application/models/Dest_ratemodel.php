<?php
class Dest_ratemodel extends CI_Model {

	
public function Get_Active_Cities(){
$query="SELECT * FROM `saimtech_city` INNER JOIN `saimtech_country` ON `saimtech_country`.`country_id`=`saimtech_city`.`country_id` where `saimtech_city`.`is_enable`=1";
$res = $this->db->query($query);
return $res->result();
}
public function Dest_Duplicate_Check($service_type_id,$dest_city_id)
	{
	$query ="SELECT * FROM `saimtech_destination_rate` where `service_type_id`=? AND `dest_city_id`=?";
	$res =  $this->db->query($query,array($service_type_id,$dest_city_id));
	return $res->num_rows();
	
	}

public function Zone_Duplicate_Check($customer_id,$z_service_type_id)
	{
	$query ="SELECT * FROM `saimtech_zone_rate` where `customer_id`=? AND `z_service_type_id`=?";
	$res =  $this->db->query($query,array($customer_id,$z_service_type_id));
	return $res->num_rows();
	
	}
	
public function Insert_Zone_Rate($customer_id,$zone_a,$zone_a_gst,$zone_b,$zone_b_gst,$zone_c,$zone_c_gst,$zone_d,$zone_d_gst,$zone_service_type){	
	$data = array(
	'customer_id' 		    => $customer_id,
	'zone_a_rate' 		    => $zone_a,
	'zone_a_gst' 		    => $zone_a_gst,
	'zone_b_rate' 		    => $zone_b,
	'zone_b_gst' 		    => $zone_b_gst,
	'zone_c_rate' 		    => $zone_c,
	'zone_c_gst' 		    => $zone_c_gst,
	'zone_d_rate' 		    => $zone_d,
	'zone_d_gst' 		    => $zone_d_gst,
	'z_service_type_id' 	=> $zone_service_type,
	'modify_by'				=> $_SESSION['user_id']

	);
		$this->db->insert('saimtech_zone_rate', $data);  
		return $this->db->insert_id();   
		
	}
	
	public function Insert_Destination_Rate($customer_id,$origin_city_id,$dest_city_id,$rate,$additional_rate,$service_type_id){	
	$data = array(
	'customer_id' 		    => $customer_id,
	'origin_city_id' 		=> $origin_city_id,
	'dest_city_id' 		    => $dest_city_id,
	'rate' 		            => $rate,
	'additional_rate' 	    => $additional_rate,
	'service_type_id'      	=> $service_type_id,
	'modify_by'				=> $_SESSION['user_id']

	);
		$this->db->insert('saimtech_destination_rate', $data);  
		return $this->db->insert_id();   
		
	}

    public function Get_Zone_Detail($customer_id){
        
        $query ="SELECT *,`saimtech_service`.`service_name` FROM `saimtech_zone_rate`
LEFT JOIN  `saimtech_service` ON `saimtech_service`.`service_id`=`saimtech_zone_rate`.`z_service_type_id` ORDER BY `saimtech_zone_rate`.`zone_id` DESC  ";
	$res =  $this->db->query($query);
	return $res->result();
    }
     public function Get_Destination_Detail($customer_id){
        
        $query ="SELECT *,`saimtech_service`.`service_name` FROM `saimtech_destination_rate`
LEFT JOIN  `saimtech_service` ON `saimtech_service`.`service_id`=`saimtech_destination_rate`.`service_type_id` ORDER BY `saimtech_destination_rate`.`dest_rate_id` DESC  ";
	$res =  $this->db->query($query);
	return $res->result();
    }
}
 