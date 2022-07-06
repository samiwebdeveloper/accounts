<?php
class Customermodel extends CI_Model
{

	public function Get_Customers_Data_By_Created_ID($created_id)
	{
		$query = "SELECT *  FROM `acc_customers` where created_by=?
			ORDER BY `customer_name` ";
		$res = $this->db->query($query, array($created_id));
		return $res->result();
	}

	public function Get_All_Customers()
	{
		$query = "SELECT *  FROM `acc_customers`
			ORDER BY `customer_name` ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_All_Customers_By_Mixture($mixture)
	{
		$query = "SELECT *  FROM `acc_customers`
			WHERE `customer_city` IN (SELECT city_id FROM `acc_city` WHERE `mixture` IN ('" . str_replace(",", "','", $mixture) . "'))
			ORDER BY `customer_name` ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Destination_Rate($customer_id)
	{
		$query = "SELECT
			`saimtech_customer`.`customer_name` as Customer,
			O.`city_name` as `Origin`,
			D.`city_name` as `Destination`,
			`saimtech_service`.`service_name` as Service,
			`saimtech_destination_rate`.`city_wgt1` AS w1,
			`saimtech_destination_rate`.`city_rate1` AS r1,
			`saimtech_destination_rate`.`city_wgt2` AS w2,
			`saimtech_destination_rate`.`city_rate2` AS r2,
			`saimtech_destination_rate`.`city_add_wgt` AS aw,
			`saimtech_destination_rate`.`city_add_rate` AS ar,
			`saimtech_destination_rate`.`city_gst` AS gst
			FROM `saimtech_destination_rate`
			INNER JOIN `saimtech_service` ON `saimtech_destination_rate`.`service_id`=`saimtech_service`.`service_id`
			INNER JOIN `saimtech_city` `O` on `O`.`city_id` = `saimtech_destination_rate`.`origin_city_id`
			INNER JOIN `saimtech_city` `D` on `D`.`city_id` = `saimtech_destination_rate`.`dest_city_id`
			INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=`saimtech_destination_rate`.`customer_id`
			WHERE `saimtech_customer`.`customer_id` =$customer_id";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Account_Rates($customer_id)
	{
		$query = "SELECT * FROM `customer_credit_rates` where `customer_id` = $customer_id;";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Article_By_Rateid($rate_id)
	{
		$query = "SELECT * FROM acc_customer_articles a
			JOIN acc_rates r ON r.o_or_z = a.acc_article_id AND r.rate_type = 'AR'
			WHERE r.rate_id = " . $rate_id . ";";
		$res = $this->db->query($query);
		return $res->result();
	}
}
