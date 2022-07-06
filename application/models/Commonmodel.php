<?php
class Commonmodel extends CI_Model
{

	//======================================================================
	//START--------------Generic Function For Model-------------------------
	//======================================================================

	public function check_session()
	{
		if (isset($_SESSION['user_name'])) {
			$this->db->where('oper_user_session', session_id());
			$this->db->reconnect();
			$query = $this->db->get('acc_user');

			if ($query->num_rows() <= 0) {
				$data = array(
					'oper_user_id' => $_SESSION['user_id'],
					'last_login' => date('Y-m-d H:i:s'),
					'oper_user_mac' => $_SESSION['MAC'],
					'oper_user_session' => session_id()
				);

				$this->db->insert('acc_sessions', $data);

				$data = array(
					'last_login' => date('Y-m-d H:i:s'),
					'oper_user_mac' => $_SESSION['MAC'],
					'oper_user_session' => session_id()
				);

				$this->db->where('oper_user_id', $_SESSION['user_id']);
				$this->db->update('acc_user', $data);
				return $this->db->affected_rows();
			}
		}
	}

	public function Delete_record($tablename, $columnname, $conditionvalue)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->delete($tablename);
	}

	public function Delete_all_record($tablename)
	{
		$this->check_session();
		$this->db->delete($tablename);
	}

	public function Delete_record_double_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->delete($tablename);
	}


	public function Duplicate_check($tablename, $columnname, $conditionvalue)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$query = $this->db->get($tablename);
		return $query->num_rows();
	}

	public function Duplicate_double_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$query = $this->db->get($tablename);
		return $query->num_rows();
	}


	public function five_double_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2, $columnname3, $conditionvalue3, $columnname4, $conditionvalue4)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$this->db->where($columnname4, $conditionvalue4);
		$query = $this->db->get($tablename);
		return $query->num_rows();
	}

	public function Duplicate_check_six($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2, $columnname3, $conditionvalue3, $columnname4, $conditionvalue4, $columnname5, $conditionvalue5)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$this->db->where($columnname4, $conditionvalue4);
		$this->db->where($columnname5, $conditionvalue5);
		$query = $this->db->get($tablename);
		return $query->num_rows();
	}

	public function rows_number($tablename)
	{
		$this->check_session();
		$query = $this->db->get($tablename);
		return $query->num_rows();
	}


	public function Update_record($tablename, $columnname, $conditionvalue, $data)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->update($tablename, $data);
		return $this->db->affected_rows();
	}

	public function Update_double_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $data)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->update($tablename, $data);
		return $this->db->affected_rows();
	}


	public function Update_Triple_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,  $columnname2, $conditionvalue2, $data)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->update($tablename, $data);
		return $this->db->affected_rows();
	}

	public function Update_Four_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,  $columnname2, $conditionvalue2,  $columnname3, $conditionvalue3, $data)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$this->db->update($tablename, $data);
		return $this->db->affected_rows();
	}

	public function Update_Five_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,  $columnname2, $conditionvalue2, $columnname3, $conditionvalue3, $columnname4, $conditionvalue4,  $data)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$this->db->where($columnname4, $conditionvalue4);
		$this->db->update($tablename, $data);
		return $this->db->affected_rows();
	}

	public function Insert_record($tablename, $data)
	{
		$this->check_session();
		$this->db->insert($tablename, $data);
		return $this->db->insert_id();
	}
	public function Insert_record1($tablename, $data)
	{
		$this->check_session();
		$this->db->insert($tablename, $data);
		return $this->db->insert_id();
	}

	public function Get_all_record($tablename)
	{
		$this->check_session();
		$query = $this->db->get($tablename);
		return $query->result();
	}

	public function Get_record_by_condition($tablename, $columnname, $conditionvalue)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$query = $this->db->get($tablename);
		return $query->result();
	}


	public function Get_record_by_condition_array($tablename, $columnname, $conditionvalue)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_double_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$query = $this->db->get($tablename);
		return $query->result();
	}


	public function Get_record_by_double_condition_array($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_triple_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_triple_condition_array($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_four_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2, $columnname3, $conditionvalue3)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_five_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2, $columnname3, $conditionvalue3, $columnname4, $conditionvalue4)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$this->db->where($columnname3, $conditionvalue3);
		$this->db->where($columnname4, $conditionvalue4);
		$query = $this->db->get($tablename);
		return $query->result_array();
	}

	public function Get_record_by_triple_condition_non($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2)
	{
		$this->check_session();
		$this->db->where($columnname, $conditionvalue);
		$this->db->where($columnname1, $conditionvalue1);
		$this->db->where($columnname2, $conditionvalue2);
		$query = $this->db->get($tablename);
		return $query->result();
	}

	public function Get_record_by_join_and_condition($tablename, $columnname, $conditionvalue, $jointablename, $jointablecolumnname, $basecolumnname)
	{
		$this->check_session();
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->join($jointablename, $jointablename . $jointablecolumnname = $tablename . $basecolumnname);
		$this->db->where($columnname, $conditionvalue);
		$query = $this->db->get();
		return $query->result();
	}

	public function Raw_Query_Execution($query_data)
	{
		$this->check_session();
		if ($query_data != "") {
			$query = $query_data;
			$res = $this->db->query($query);
			return $res->result();
		}
	}

	public function Update_Customer_CN_Service($customer, $sdate, $edate, $current_service, $new_service)
	{
		$this->check_session();
		$query = "UPDATE acc_orders SET order_service_type = ? WHERE customer_id = ? AND date(order_date) BETWEEN ? AND ? AND order_pay_mode = 'Account' and order_service_type = ?;";
		$res = $this->db->query($query, array($new_service, $customer, $sdate, $edate, $current_service));
		return $this->db->affected_rows();
	}

	//======================================================================
	//START--------------Generic Function For Model-------------------------
	//======================================================================

	public function Order_Code_AND_Anaul($CN)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE order_code=? or manual_cn=?";
		$res = $this->db->query($query, array($CN, $CN));
		return $res->result_array();
	}

	public function Edit_Booking_Check($mcn)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  (manual_cn=? or order_code=?) and (`order_status`='Arrival' OR `order_status`='Booking') and `is_invoice`=0";
		$res = $this->db->query($query, array($mcn, $mcn));
		return $res->num_rows();
	}

	public function Edit_Booking_Check_All($mcn)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  (manual_cn=? or order_code=?) and `is_invoice`=0 ";
		$res = $this->db->query($query, array($mcn, $mcn));
		return $res->num_rows();
	}


	public function Edit_Booking_Data($mcn)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  (manual_cn=? or order_code=?) and (`order_status`='Arrival' OR `order_status`='Booking') and is_invoice=0";
		$res = $this->db->query($query, array($mcn, $mcn));
		return $res->result_array();
	}


	public function Edit_Booking_Data_All($mcn)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  (manual_cn=? or order_code=?) and is_invoice=0";
		$res = $this->db->query($query, array($mcn, $mcn));
		return $res->result_array();
	}

	public function Get_Transit_Detail_ID_By_CN_And_Transit($cn, $mani)
	{
		$this->check_session();
		$query = "SELECT `saimtech_transit_detail`.`transit_detail_id` as `tdid`  FROM `saimtech_transit_list` 
			INNER JOIN `saimtech_transit_detail` on `saimtech_transit_detail`.`transit_list_id` = `saimtech_transit_list`.`transit_list_id` 
			WHERE `saimtech_transit_list`.`transit_code`=? and `saimtech_transit_detail`.`transit_cn`=?";
		$res = $this->db->query($query, array($mani, $cn));
		$rows = $res->result_array();
		return $rows[0]['tdid'];
	}

	public function Manifest_Summary($code)
	{
		$this->check_session();
		$query = "SELECT COUNT(transit_cn) as cns FROM `saimtech_transit_list` inner join `saimtech_transit_detail` on `saimtech_transit_detail`.`transit_list_id` = `saimtech_transit_list`.`transit_list_id` WHERE `saimtech_transit_list`.`transit_code`=?";
		$res = $this->db->query($query, array($code));
		$rows = $res->result_array();
		return $rows[0]['cns'];
	}

	public function Manifest_check($code, $cn)
	{
		$this->check_session();
		$query = "SELECT COUNT(transit_cn) as cns FROM `saimtech_transit_list` inner join `saimtech_transit_detail` on `saimtech_transit_detail`.`transit_list_id` = `saimtech_transit_list`.`transit_list_id` WHERE `saimtech_transit_list`.`transit_code`=? and is_unload=0 and (transit_cn=? or manual_cn=?)";
		$res = $this->db->query($query, array($code, $cn, $cn));
		$rows = $res->result_array();
		return $rows[0]['cns'];
	}


	public function Manifest_Detail($code)
	{
		$this->check_session();
		$query = "SELECT *, `saimtech_transit_detail`.`transit_date` as `Tdate` FROM `saimtech_transit_list` inner join `saimtech_transit_detail` on `saimtech_transit_detail`.`transit_list_id` = `saimtech_transit_list`.`transit_list_id` WHERE `saimtech_transit_list`.`transit_code`=? and `saimtech_transit_detail`.`is_unload`=1";
		$res = $this->db->query($query, array($code));
		return $res->result();
	}

	public function Manifest_Unload_Summary($code)
	{
		$this->check_session();
		$query = "SELECT COUNT(transit_cn) as cns FROM `saimtech_transit_list` inner join `saimtech_transit_detail` on `saimtech_transit_detail`.`transit_list_id` = `saimtech_transit_list`.`transit_list_id` WHERE `saimtech_transit_list`.`transit_code`=? and `saimtech_transit_detail`.`is_unload`=1";
		$res = $this->db->query($query, array($code));
		$rows = $res->result_array();
		return $rows[0]['cns'];
	}

	public function Seprate_Tm_Cities()
	{
		$this->check_session();
		$query = "UPDATE `saimtech_order` SET `thrid_party_name`='TM', `is_handover`='1' WHERE `is_handover`=1 AND (`destination_city`<>1 AND `destination_city`<>2 AND`destination_city`<>3 AND `destination_city`<>4 AND `destination_city`<>5 AND `destination_city`<>6 AND `destination_city`<>7 AND `destination_city`<>8 AND `destination_city`<>9 AND `destination_city`<>10 AND `destination_city`<>15 AND `destination_city`<>17 AND `destination_city`<>165 )";
		$this->db->query($query);
		$query = "UPDATE `saimtech_archive_order` SET `thrid_party_name`='TM', `is_handover`='1' WHERE `is_handover`=1 AND (`destination_city`<>1 AND `destination_city`<>2 AND`destination_city`<>3 AND `destination_city`<>4 AND `destination_city`<>5 AND `destination_city`<>6 AND `destination_city`<>7 AND `destination_city`<>8 AND `destination_city`<>9 AND `destination_city`<>10 AND `destination_city`<>15 AND `destination_city`<>17  AND `destination_city`<>165)";
		$this->db->query($query);
	}

	public function Get_Sc_By_Customer_RTS($cid)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` 
			WHERE order_status='RTS' AND customer_id=? AND is_invoice=0";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}


	public function Get_Pickup_Points_By_Customer_id($cid)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_pickup_points` 
			INNER JOIN `saimtech_country` ON `saimtech_country`.`country_id`=`saimtech_pickup_points`.`country_id`
			INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=`saimtech_pickup_points`.`city_id`
			WHERE is_enable='1' AND customer_id=?";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}

	public function Custom_Query_Array($query)
	{
		$this->check_session();
		$res = $this->db->query($query);
		return $res->result_array();
	}

	public function Get_Today_Deliverd_Cn()
	{
		$this->check_session();
		$datee = date('Y-m-d');
		$city = $_SESSION['origin_id'];
		$query = "SELECT * FROM `saimtech_order` WHERE `order_status`='Deliverd' AND date(`order_deliver_date`)=? AND `destination_city`=? AND `is_invoice`=0";
		$res = $this->db->query($query, array($datee, $city));
		return $res->result();
	}


	public function Get_Live_And_Gender_Animal($uid, $gender)
	{
		$this->check_session();
		$query = "SELECT * FROM `herd_main` where `uid`=? AND `status`='Live' AND `gender`=? ";
		$res = $this->db->query($query, array($uid, $gender));
		return $res->result_array();
	}

	public function Customer_Data_By_CID($cutomer_id)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_customer` 
			INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=`saimtech_customer`.`customer_city`
			WHERE `customer_id`=?";
		$res = $this->db->query($query, array($cutomer_id));
		return $res->result();
	}


	public function Get_Pickup_Points_By_pickup_id($pid)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_pickup_points` 
			INNER JOIN `saimtech_country` ON `saimtech_country`.`country_id`=`saimtech_pickup_points`.`country_id`
			INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=`saimtech_pickup_points`.`city_id`
			WHERE points_id=?";
		$res = $this->db->query($query, array($pid));
		return $res->result_array();
	}


	public function Get_Shipments_By_Cid($cid, $start_date, $end_date)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` 
			INNER JOIN `saimtech_pickup_points` ON `saimtech_pickup_points`.`points_id`=`saimtech_order`.`pickup_point_id`
			INNER JOIN `saimtech_service` ON `saimtech_service`.`service_id`=`saimtech_order`.`order_service_type`
			WHERE `saimtech_order`.`customer_id`=? and  (`saimtech_order`.`order_date`>=? and  `saimtech_order`.`order_date`<=?) Order By `saimtech_order`.`order_date` DESC";
		$res = $this->db->query($query, array($cid, $start_date, $end_date));
		return $res->result();
	}


	public function Get_Paid_Invoice_By_date_range($start, $end, $cid)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_invoice` 
			WHERE `customer_id`=? AND (`invoice_date`>=? and `invoice_date`<=?)  Order By `invoice_date` DESC";
		$res = $this->db->query($query, array($cid, $start, $end));
		return $res->result();
	}


	public function Get_Service_Type_By_customer_id($cid)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_rate` 
			INNER JOIN  `saimtech_service` ON `saimtech_service`.`service_id`=`saimtech_rate`.`service_id`
			WHERE `customer_id`=?";
		$res = $this->db->query($query, array($cid));
		return $res->result();
	}

	public function Get_Depsoit_Detail_Cns($date, $origin)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city ,order_code as `shipments`,  date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)=? and `destination_city`=? ";
		$res = $this->db->query($query, array($date, $origin));
		return $res->result();
	}


	public function Get_Depsoit_Detail_Sheet($date, $origin)
	{
		$this->check_session();
		$query = "SELECT destination_city,`on_route_id`,`destination_city_name` as city, COUNT(order_code) as `cns`, date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  SUM(cod_amount) as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)=? and `destination_city`=? group by `on_route_id`";
		$res = $this->db->query($query, array($date, $origin));
		return $res->result();
	}


	public function Get_Depsoit_Detail_Cns_CRV($date, $origin)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city ,order_code as `shipments`,  date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)<=? and `destination_city`=? and is_crv=0 ";
		$res = $this->db->query($query, array($date, $origin));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Cns_CRV($date)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city ,order_code as `shipments`,  date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and  (date(`order_deliver_date`)>='2020-08-01' and date(`order_deliver_date`)<=? )
			";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Cns_CRV_Archive($date)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city ,order_code as `shipments`,  date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount` FROM `saimtech_archive_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)>='2020-08-01' and (date(`order_deliver_date`)>='2020-08-01' and date(`order_deliver_date`)<=? )";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}


	public function Get_Depsoit_Detail_Sheet_CRV($date, $origin)
	{
		$this->check_session();
		$query = "SELECT is_crv, destination_city,`on_route_id`,`destination_city_name` as city, COUNT(order_code) as `cns`, date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  SUM(cod_amount) as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and  (date(`order_deliver_date`)>='2020-08-01' and date(`order_deliver_date`)<=?) and `destination_city`=?  and `is_crv`=0 group by `on_route_id`";
		$res = $this->db->query($query, array($date, $origin));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Sheet_CRV($date)
	{
		$this->check_session();
		$query = "SELECT is_crv, destination_city,`on_route_id`,`destination_city_name` as city, COUNT(order_code) as `cns`, date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  SUM(cod_amount) as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and (date(`order_deliver_date`)>='2020-08-01' and date(`order_deliver_date`)<=?) 
			group by `on_route_id`";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}

	public function Get_All_Depsoit_Detail_Sheet_CRV_Archive($date)
	{
		$this->check_session();
		$query = "SELECT is_crv, destination_city,`on_route_id`,`destination_city_name` as city, COUNT(order_code) as `cns`, date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  SUM(cod_amount) as `amount` FROM `saimtech_archive_order` WHERE order_status='Deliverd' and (date(`order_deliver_date`)>='2020-08-01' and date(`order_deliver_date`)<=?)
			group by `on_route_id`";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Sheet($date)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city, COUNT(order_code) as `cns`, date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate, SUM(cod_amount) as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)=? group by destination_city,`on_route_id`";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}

	public function Get_All_Depsoit_Detail_Cns($date)
	{
		$this->check_session();
		$query = "SELECT `on_route_id`,`destination_city_name` as city ,order_code as `shipments`,  date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount` FROM `saimtech_order` WHERE order_status='Deliverd' and date(`order_deliver_date`)=? ";
		$res = $this->db->query($query, array($date));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Cns_Accounts($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT payment_tid,invoice_code,date(invoice_date) as `invdate`,customer_name as `shipper`,`on_route_id`,`origin_city_name` as `origin`,`destination_city_name` as city ,order_code as `shipments`, order_gst as `gst` , date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount`, `order_sc` as sc,order_status, weight FROM `saimtech_order`
			INNER JOIN saimtech_customer ON saimtech_customer.customer_id = saimtech_order.customer_id
			LEFT JOIN saimtech_invoice ON saimtech_invoice.invoice_code = saimtech_order.invoice_id
			WHERE order_status='Deliverd' and (date(`order_deliver_date`)>=? AND date(`order_deliver_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_All_Depsoit_Detail_Cns_Accounts_RTS($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT payment_tid, invoice_code,date(invoice_date) as `invdate`,customer_name as `shipper`,`on_route_id`,`origin_city_name` as `origin`,`destination_city_name` as city ,order_code as `shipments`, order_gst as `gst` , date(`order_result_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount`, `order_sc` as sc,order_status, weight FROM `saimtech_order`
			INNER JOIN saimtech_customer ON saimtech_customer.customer_id = saimtech_order.customer_id
			LEFT JOIN saimtech_invoice ON saimtech_invoice.invoice_code = saimtech_order.invoice_id
			WHERE order_status='RTS' and (date(`order_result_date`)>=? AND date(`order_result_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}


	public function Get_All_Depsoit_Detail_Cns_Accounts_Archive($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT payment_tid,invoice_code,date(invoice_date) as `invdate`,customer_name as `shipper`,`on_route_id`,`origin_city_name` as `origin`,`destination_city_name` as city ,order_code as `shipments`, order_gst as `gst` , date(`order_deliver_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount`, `order_sc` as sc,order_status, weight FROM `saimtech_archive_order`
			INNER JOIN saimtech_customer ON saimtech_customer.customer_id = saimtech_archive_order.customer_id
			LEFT JOIN saimtech_invoice ON saimtech_invoice.invoice_code = saimtech_archive_order.invoice_id
			WHERE order_status='Deliverd' and (date(`order_deliver_date`)>=? AND date(`order_deliver_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_All_Depsoit_Detail_Cns_Accounts_Archive_RTS($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT payment_tid, invoice_code,date(invoice_date) as `invdate`,customer_name as `shipper`,`on_route_id`,`origin_city_name` as `origin`,`destination_city_name` as city ,order_code as `shipments`, order_gst as `gst` , date(`order_result_date`) as deliverdate, date(`on_route_date`) as RouteDate,  cod_amount as `amount`, `order_sc` as sc,order_status, weight FROM `saimtech_archive_order`
			INNER JOIN saimtech_customer ON saimtech_customer.customer_id = saimtech_archive_order.customer_id
			LEFT JOIN saimtech_invoice ON saimtech_invoice.invoice_code = saimtech_archive_order.invoice_id
			WHERE order_status='RTS' and (date(`order_result_date`)>=? AND date(`order_result_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Remove_tracking_event($uid, $date, $orderid)
	{
		$this->check_session();
		$query = "DELETE FROM `saimtech_order_tracking` WHERE `order_event`='Deliverd' And `created_by`=? And date(`created_date`)=? AND `order_id`=?";
		$this->db->query($query, array($uid, $date, $orderid));
	}

	public function Get_Tm_Shipment_Data()
	{
		$this->check_session();
		$query = "SELECT `customer_name`,`order_code`,`order_status`,date(order_arrival_date) as `order_arrvial_date`,`destination_city_name`,`cod_amount`,`thrid_party_name`,`thrid_party_cn`,`thrid_party_status`,consignee_name,consignee_mobile,consignee_address FROM `saimtech_order`
			INNER JOIN `saimtech_city` on `saimtech_city`.`city_id` = `saimtech_order`.`destination_city`
			INNER JOIN `saimtech_customer` on `saimtech_customer`.`customer_id` = `saimtech_order`.`customer_id`
			WHERE `thrid_party_cn` like 'LHE-DX%'";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Not_Deliverd_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`<>'Delivered' AND  `thrid_party_status`<>'N/A' AND  `thrid_party_status`<>'RTS'";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Booked_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='Booked' ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_B_Booked_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_archive_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='Booked' ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_RAS_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='Received At Station' ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_B_RAS_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_archive_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='Received At Station' ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_Transit_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='In Transit' ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_B_Transit_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_archive_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='In Transit' ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_Refused_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='RTS' ";
		$res = $this->db->query($query);
		return $res->result();
	}


	public function Get_B_Refused_TM_CN()
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_archive_order` WHERE  `thrid_party_name`='TM' AND `thrid_party_status`='RTS' ";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_Tm_Archive_Shipment_Data()
	{
		$this->check_session();
		$query = "SELECT `customer_name`,`order_code`,`order_status`,date(order_arrival_date) as `order_arrvial_date`,`destination_city_name`,`cod_amount`,`thrid_party_name`,`thrid_party_cn`,`thrid_party_status`,consignee_name,consignee_mobile,consignee_address FROM `saimtech_archive_order`
			INNER JOIN `saimtech_city` on `saimtech_city`.`city_id` = `saimtech_archive_order`.`destination_city`
			INNER JOIN `saimtech_customer` on `saimtech_customer`.`customer_id` = `saimtech_archive_order`.`customer_id`
			WHERE `thrid_party_cn` like 'LHE-DX%'";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_So_Kamal_QSR()
	{
		$this->check_session();
		$query = "SELECT `order_code` as `CN`, `customer_reference_no`, `order_status` as `Status`, `consignee_name`, `consignee_email`, `consignee_address`,`consignee_mobile`,`product_detail`,`cod_amount` as `COD`,`order_booking_date`,`order_date`,`order_arrival_date`,`order_deliver_date`,`origin_city` as `Origin`,`destination_city_name` as `Destination` FROM `saimtech_order` WHERE `saimtech_order`.`customer_id`=632 And (order_status<>'Cancelled' And order_status<>'Order')";
		$res = $this->db->query($query);
		return $res->result();
	}

	public function Get_All_Expense_Detail($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_expense` 
            INNER JOIN saimtech_city ON saimtech_city.city_id=saimtech_expense.expense_city  
            INNER JOIN saimtech_oper_user ON saimtech_oper_user.oper_user_id=saimtech_expense.created_by  
            WHERE (date(`expense_date`)>=? AND date(`expense_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_All_Cpay_Detail($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_cpay` 
            INNER JOIN saimtech_city ON saimtech_city.city_id=saimtech_cpay.cpay_city  
            INNER JOIN saimtech_customer ON saimtech_cpay.cpay_customer_id=saimtech_customer.customer_id
            INNER JOIN saimtech_oper_user ON saimtech_oper_user.oper_user_id=saimtech_cpay.created_by  
            WHERE (date(`cpay_date`)>=? AND date(`cpay_date`)<=?) ";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Update_CRV($sheetcode, $ddate, $routedate, $city)
	{
		$this->check_session();
		$date = date('Y-m-d');
		$query = "UPDATE `saimtech_order` SET `is_crv`=1,`crv_date`=?,`crv_id`=? WHERE date(`order_deliver_date`)=? AND date(`on_route_date`)=? AND `destination_city`=? AND `on_route_id`=?";
		$res = $this->db->query($query, array($date, $sheetcode, $ddate, $routedate, $city, $sheetcode));
		return $this->db->affected_rows();
	}

	public function Get_CRV_Summary_By_Date_Range($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT 
			crv_date AS `DATE`, 
			destination_city_name AS `City`,
			`on_route_id` as `RRsheets`,
			Count(order_code) as `CNs`,
			SUM(cod_amount) as `ReceiveCOD`,  
			(SELECT SUM(cod_amount) FROM saimtech_order WHERE destination_city=A.destination_city and date(order_deliver_date)=A.crv_date) as `ActualCOD`
			FROM `saimtech_order` A
			WHERE is_crv=1 and crv_date>=? AND crv_date<=?
			Group By  crv_date, destination_city_name, `on_route_id`";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_CRV_Detail_By_Date_Range($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT * FROM `saimtech_order`  WHERE is_crv=1 and crv_date>=? AND crv_date<=? Group By `order_code`";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_CRV_Summary_By_Date_Range_Archive($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT 
			crv_date AS `DATE`, 
			destination_city_name AS `City`,
			`on_route_id` as `RRsheets`,
			Count(order_code) as `CNs`,
			SUM(cod_amount) as `ReceiveCOD`,  
			(SELECT SUM(cod_amount) FROM saimtech_archive_order WHERE destination_city=A.destination_city and date(order_deliver_date)=A.crv_date) as `ActualCOD`
			FROM `saimtech_archive_order` A
			WHERE is_crv=1 and crv_date>=? AND crv_date<=?
			Group By  crv_date, destination_city_name, on_route_id";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}


	public function Get_CRV_Pending_And_Done_By_Date_Range_Archive($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT
			is_crv,
			crv_date AS `DATE`, 
			destination_city_name AS `City`,
			`on_route_id` as `RRsheets`,
			Count(order_code) as `CNs`,
			SUM(cod_amount) as `ReceiveCOD`,  
			(SELECT SUM(cod_amount) FROM saimtech_archive_order WHERE destination_city=A.destination_city and date(order_deliver_date)=A.crv_date) as `ActualCOD`
			FROM `saimtech_archive_order` A
			WHERE order_status='Deliverd' and is_final=1 and (date(order_deliver_date)>=? and date(order_deliver_date)<=?)
			Group By  date(order_deliver_date), destination_city_name, on_route_id";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_CRV_Pending_And_Done_By_Date_Range($startdate, $enddate)
	{
		$this->check_session();
		$query = "SELECT
			is_crv,
			crv_date AS `DATE`, 
			destination_city_name AS `City`,
			`on_route_id` as `RRsheets`,
			Count(order_code) as `CNs`,
			SUM(cod_amount) as `ReceiveCOD`,  
			(SELECT SUM(cod_amount) FROM saimtech_order WHERE destination_city=A.destination_city and date(order_deliver_date)=A.crv_date) as `ActualCOD`
			FROM `saimtech_order` A
			WHERE order_status='Deliverd' and is_final=1 and (date(order_deliver_date)>=? and date(order_deliver_date)<=?)
			Group By  date(order_deliver_date), destination_city_name, on_route_id";
		$res = $this->db->query($query, array($startdate, $enddate));
		return $res->result();
	}

	public function Get_Destination_Wise_Rate($customer_id, $service_id)
	{
		$this->check_session();
		$query = "SELECT 
			`saimtech_customer`.`customer_name` as `Shipper`, 
			`saimtech_service`.`service_name` as `Service`,
			A.`city_name` as `Origin`,
			B.`city_name` as `Destination`,
			`city_wgt1`,
			`city_rate1`,
			`city_wgt2`,
			`city_rate2`,
			`city_add_wgt`,
			`city_add_rate`,
			`city_gst`,
			`saimtech_destination_rate`.`is_enable` as wenable
			FROM `saimtech_destination_rate`
			INNER JOIN `saimtech_city` A ON A.city_id=saimtech_destination_rate.origin_city_id
			INNER JOIN `saimtech_city` B ON B.city_id=saimtech_destination_rate.dest_city_id
			INNER JOIN `saimtech_service` ON saimtech_service.service_id=saimtech_destination_rate.service_id
			INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=`saimtech_destination_rate`.`customer_id`
			WHERE `saimtech_destination_rate`.`customer_id`=? and `saimtech_destination_rate`.`service_id`=?";
		$res = $this->db->query($query, array($customer_id, $service_id));
		return $res->result();
	}
}
