<?php
class Reportmodel extends CI_Model
{
	public function get_aging_report()
	{
		$query = "SELECT a.cl_customer_id as customer_id,b.reference_name,b.customer_name,round(SUM(a.cl_outstanding_amount)) Total, group_concat(date_format(a.cl_created_date,'%b-%y'),'|', round(a.cl_outstanding_amount)) as data FROM `customer_ledger` a join (SELECT cl_customer_id, max(cl_id) as `clid`,acc_customers.customer_name,acc_references.reference_name FROM `customer_ledger` INNER JOIN acc_customers on customer_ledger.cl_customer_id=acc_customers.customer_id INNER JOIN acc_references on customer_ledger.cl_sale_person=acc_references.reference_id GROUP by cl_customer_id, date_format(cl_created_date,'%b-%y')) b ON b.cl_customer_id = a.cl_customer_id and b.`clid` = a.cl_id group by a.cl_customer_id order by b.customer_name";
		$res = $this->db->query($query);
		return $res->result_array();
	}
	public function get_aging_report_month()
	{
		$query = "SELECT date_format(cl_created_date,'%b-%y') `Month` from customer_ledger group by Month order by Month;";
		$res = $this->db->query($query);
		return $res->result_array();
	}
}
