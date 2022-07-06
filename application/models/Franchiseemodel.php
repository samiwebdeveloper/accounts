<?php
	class Franchiseemodel extends CI_Model {
		
		public function Get_Franchise_Types(){
			$query="SELECT * FROM `acc_types`			
			WHERE `acc_type` = 'fr_type'
			AND `is_enable` = 1 
			ORDER BY `acc_types_full`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Franchise_Status(){
			$query="SELECT * FROM `acc_types`			
			WHERE `acc_type` = 'fr_status'
			AND `is_enable` = 1 
			ORDER BY `acc_types_full`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Franchise_Billing_Period(){
			$query="SELECT * FROM `acc_types`			
			WHERE `acc_type` = 'fr_billing_period'
			AND `is_enable` = 1 
			ORDER BY `acc_types_full`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Franchise_Pay_Method(){
			$query="SELECT * FROM `acc_types`			
			WHERE `acc_type` = 'fr_pay_method'
			AND `is_enable` = 1 
			ORDER BY `acc_types_full`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Active_Locations(){
			$query="SELECT * FROM `acc_city`			
			WHERE `is_enable` = 1
			ORDER BY `city_full_name`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Active_Sales_Team(){
			$query="SELECT * FROM acc_references
			WHERE `is_enable` = 1
			AND `reference_type` = 'Emp'
			ORDER BY `reference_name`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Active_Services(){
			$query="SELECT * FROM acc_services
			WHERE `is_enable` = 1
			ORDER BY `service_name`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Active_Franchisee(){
			$query="SELECT * FROM fran_profile
			WHERE `is_enable` = 1
			ORDER BY `fran_name`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_All_Franchisee(){
			$query="SELECT `p`.*, `c`.`city_full_name`, `r`.`reference_name`, `t`.`acc_types_full` FROM `fran_profile` `p`
			left join `acc_city` `c` on `c`.`city_id` = `p`.`city_id`
			left join `acc_references` `r` on `r`.`reference_id` = `p`.`person_id`
			left join `acc_types` `t` on `t`.`acc_types_short` = `p`.`sts` and `t`.`acc_type` = 'fr_status' 
			WHERE p.`is_enable` = 1
			ORDER BY `fran_name`";
			$res = $this->db->query($query);
			return $res->result();
		}

		public function Get_Franchisee_Data($fr_id){
			$query="SELECT `p`.* FROM `fran_profile` `p`
			WHERE `p`.`fr_id` = ?";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}

		public function Get_Franchisee_Route($fr_id){
			$query="SELECT `r`.* FROM `fran_route` `r`
			WHERE `r`.`fr_id` = ?
			AND `r`.`is_enable` = 1";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}

		public function Get_Franchisee_Locations($fr_id){
			$query="SELECT `r`.* FROM `fran_locs` `r`
			WHERE `r`.`fr_id` = ?
			AND `r`.`is_enable` = 1";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}

		public function Get_Franchisee_Weight_Charges($fr_id){
			$query="SELECT `r`.* FROM `fran_rates` `r`
			WHERE `r`.`fr_id` = ?
			AND `r`.`type` = 2
			AND `r`.`unit` = 2
			AND `r`.`is_enable` = 1";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}

		public function Get_Franchisee_Services($fr_id){
			$query="SELECT * FROM `fran_services`
			WHERE `fr_id` = ?
			AND `is_enable` = 1";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}

		public function Get_Franchisee_Rates($fr_id){
			$query="SELECT * FROM `fran_rates` `r`
			WHERE `r`.`fr_id` = ?
			AND `r`.`type` = 1
			AND `r`.`is_enable` = 1;";
			$res = $this->db->query($query,array($fr_id));
			return $res->result_array();
		}
	}	