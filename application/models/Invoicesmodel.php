<?php

class Invoicesmodel extends CI_Model
{

    public function getCityList()
    {
        $query = "SELECT city_id as id, city_name as name FROM saimtech_city where is_enable=1 order by city_name";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_Invoice_Data_By_Date_Range($startdate, $enddate)
    {
        $query = "SELECT *  FROM `saimtech_invoice`
		INNER JOIN `saimtech_customer` on `saimtech_customer`.customer_id=`saimtech_invoice`.`customer_id`
		INNER JOIN `saimtech_city` on `saimtech_customer`.customer_city=`saimtech_city`.`city_id`
		INNER JOIN `saimtech_oper_user` on `saimtech_oper_user`.`oper_user_id`=`saimtech_invoice`.`created_by`
		WHERE  (date(`invoice_date`)>=? AND date(`invoice_date`)<=?)  ORDER BY `invoice_date` DESC ";
        $res = $this->db->query($query, array(
            $startdate,
            $enddate
        ));
        return $res->result();
    }

    public function Get_Invoice_Data_By_Is_Payment()
    {
        $query = "SELECT *  FROM `saimtech_invoice`
			 INNER JOIN `saimtech_customer` on `saimtech_customer`.customer_id=`saimtech_invoice`.`customer_id`
			 WHERE  is_payment=0 ORDER BY `invoice_date` DESC ";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_RTS_Charges_By_Temp_Invocie_Code($code)
    {
        $query = "SELECT COUNT(order_code) as `shipments`,SUM(`order_return_sc`) as `rts_sc` FROM `saimtech_order` WHERE  `is_temp_invoice`=? and order_status='RTS'  ";
        $res = $this->db->query($query, array(
            $code
        ));
        return $res->result_array();
    }

    public function Get_Invoice_Print_Sheet_By_Code($sheet_code)
    {
        $query = "SELECT *, `saimtech_invoice`.`discount_amount` as DC, `saimtech_customer`.`gst` as `gsst`,`saimtech_invoice`.`is_payment` as `ispayment`, `saimtech_invoice`.`payment_mode` as `paymentmode`,  `saimtech_invoice`.`payment_tid` as `paymenttid`,Monthname(`saimtech_invoice_detail`.`date`) as Month,Year(`saimtech_invoice_detail`.`date`) as Year   FROM `saimtech_invoice`
			 INNER JOIN `saimtech_customer` on `saimtech_customer`.customer_id=`saimtech_invoice`.`customer_id`
			 INNER JOIN `saimtech_invoice_detail` on `saimtech_invoice_detail`.invoice_id=`saimtech_invoice`.`invoice_id`
			 INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_invoice`.`created_by`
			 WHERE  `saimtech_invoice`.`invoice_code`=?   ORDER BY `saimtech_invoice`.`invoice_date` DESC  ";
        $res = $this->db->query($query, array(
            $sheet_code
        ));
        return $res->result();
    }

    public function Get_Invoice_Print_Sheet_By_Code_Archive($sheet_code)
    {
        $query = "SELECT * , `saimtech_customer`.`gst` as `gsst`, `saimtech_invoice`.`is_payment` as `ispayment`, `saimtech_invoice`.`payment_mode` as `paymentmode`,  `saimtech_invoice`.`payment_tid` as `paymenttid` FROM `saimtech_invoice`
			 INNER JOIN `saimtech_customer` on `saimtech_customer`.customer_id=`saimtech_invoice`.`customer_id`
			 INNER JOIN `saimtech_invoice_detail` on `saimtech_invoice_detail`.invoice_id=`saimtech_invoice`.`invoice_id`
			 INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_invoice`.`created_by`
			 INNER JOIN `saimtech_archive_order` on `saimtech_archive_order`.order_code=`saimtech_invoice_detail`.`cn`
			 WHERE  `invoice_code`=?   ORDER BY `saimtech_invoice`.`invoice_date` DESC ";
        $res = $this->db->query($query, array(
            $sheet_code
        ));
        return $res->result();
    }

    public function Duplicate_Check($id, $name, $amount)
    {
        $query = "SELECT *  FROM `saimtech_invoice_extra` WHERE `invoice_id`=? and `extra_name`=? and `extra_amount`=?  ";
        $res = $this->db->query($query, array(
            $id,
            $name,
            $amount
        ));
        return $res->num_rows();
    }

    public function Get_Summary_By_Code($sheet_code)
    {
        $query = "SELECT COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, SUM(`order_gst`) as `GST`, SUM(`order_sc`) as `SC`  FROM `saimtech_order` WHERE  `is_temp_invoice`=?  (`order_pay_mode`='Account' or `order_pay_mode`='account') ";
        $res = $this->db->query($query, array(
            $sheet_code
        ));
        return $res->result_array();
    }

    public function Get_Summary_By_Code_Date($sheet_code, $date, $datef)
    {
        $query = "SELECT COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, SUM(`order_gst`) as `GST`, SUM(`order_sc`) as `SC`,SUM(`order_osa_sd_total`) as osa_sd  FROM `saimtech_order` WHERE  `is_temp_invoice`=? AND (date(`order_date`)>=? AND date(`order_date`)<=?) AND (`order_pay_mode`='Account' or `order_pay_mode`='account')";
        $res = $this->db->query($query, array(
            $sheet_code,
            $date,
            $datef
        ));
        return $res->result_array();
    }

    public function Get_Summary_By_Code_OK($sheet_code)
    {
        $query = "SELECT  SUM(`cod_amount`) as `COD` FROM `saimtech_order` WHERE  `is_temp_invoice`=? and `order_status`='Deliverd' ";
        $res = $this->db->query($query, array(
            $sheet_code
        ));
        $rows = $res->result_array();
        return $rows[0]['COD'];
    }

    public function Get_Summary_By_Code_OK_Date($sheet_code, $date, $datef)
    {
        $query = "SELECT  SUM(`cod_amount`) as `COD` FROM `saimtech_order` WHERE  `is_temp_invoice`=? and `order_status`='Deliverd'  AND(date(`order_result_date`)>=? AND date(`order_result_date`)<=?) ";
        $res = $this->db->query($query, array(
            $sheet_code,
            $date,
            $datef
        ));
        $rows = $res->result_array();
        return $rows[0]['COD'];
    }

    public function Get_Unpaid_Summary_Customer_Wise_Delivered($origin_id)
    {
        $query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0 and `customer_city`=? group by A.customer_id";
        $res = $this->db->query($query, array(
            $origin_id
        ));
        return $res->result();
    }

    public function Get_Unpaid_Summary_Customer_Wise_RTS($origin_id)
    {
        $query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='RTS') and `is_invoice`=0 and `customer_city`=? group by A.customer_id";
        $res = $this->db->query($query, array(
            $origin_id
        ));
        return $res->result();
    }

    public function Get_All_Unpaid_Summary_Customer_Wise_Delivered()
    {
        $query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0  group by A.customer_id";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_All_Unpaid_Summary_Customer_Wise_Delivered_And_RTS()
    {
        $query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(cod_amount),
IF((SELECT SUM(`cod_amount`) FROM saimtech_order where customer_id=A.customer_id and `is_invoice`=0  and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM saimtech_order where customer_id=A.customer_id and `is_invoice`=0  and `order_status`='Deliverd')) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` 
FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0  group by A.customer_id";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS_All()
    {
        $query = "SELECT 
A.`customer_id` as `id`,
`customer_name`,
order_code as `Cn`, 
IF((SELECT `cod_amount` FROM saimtech_order where order_code=A.order_code and `is_invoice`=0  and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM saimtech_order where order_code=A.order_code and `is_invoice`=0  and `order_status`='Deliverd')) as `COD`, 
round(`order_gst`) as `GST`,
`order_sc` as `SC`,
date(`order_result_date`) as `ResultDate` 
FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0 ";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_Delivered($cid)
    {
        $query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_deliver_date`) as `ResultDate` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0  and A.customer_id=?";
        $res = $this->db->query($query, array(
            $cid
        ));
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_Delivered_And_RTS($cid)
    {
        $query = "SELECT A.`customer_id` as `id`, `customer_name`, order_code as `Cn`, 
IF((SELECT `cod_amount` FROM saimtech_order where order_code=A.order_code and `is_invoice`=0 and `order_status`='Deliverd')is NULL,'0',(SELECT SUM(`cod_amount`) FROM saimtech_order where order_code=A.order_code and `is_invoice`=0 and `order_status`='Deliverd')) as `COD`,
round(`order_gst`) as `GST`, `order_sc` as `SC` FROM `saimtech_order` A 
INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` 
WHERE (`order_status`='Deliverd' or `order_status`='RTS') and `is_invoice`=0 and A.customer_id=? ";
        $res = $this->db->query($query, array(
            $cid
        ));
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_Delivered_All()
    {
        $query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_deliver_date`) as `ResultDate` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='Deliverd') and `is_invoice`=0 order by date(`order_result_date`)";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_All_Unpaid_Summary_Customer_Wise_RTS()
    {
        $query = "SELECT A.`customer_id` as `id`,`customer_name`,COUNT('order_code') as `Cns`, SUM(`cod_amount`) as `COD`, round(SUM(`order_gst`)) as `GST`, SUM(`order_sc`) as `SC` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_status`='RTS') and `is_invoice`=0  group by A.customer_id";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_RTS($cid)
    {
        $query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_date`) as `ResultDate` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_pay_mode`='Account' OR `order_pay_mode`='account') and `is_invoice`=0  and A.customer_id=?";
        $res = $this->db->query($query, array(
            $cid
        ));
        return $res->result();
    }

    public function Get_All_Unpaid_Detail_Customer_Wise_RTS_All()
    {
        $query = "SELECT `customer_name`,`order_code` as `Cn`, `cod_amount` as `COD`, round(`order_gst`) as `GST`, `order_sc` as `SC`, date(`order_date`) as `ResultDate` FROM `saimtech_order` A INNER JOIN `saimtech_customer` ON `saimtech_customer`.`customer_id`=A.`customer_id` WHERE (`order_pay_mode`='Account' OR `order_pay_mode`='account') and `is_invoice`=0 order by date(`order_date`) ";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_Last_Invoice_Code()
    {
        $id = 0;
        $code = 0;
        $year = 0;
        $sy_y = 0;
        $select_query = "SELECT * from saimtech_order_code";
        $res = $this->db->query($select_query);
        $row = $res->result_array();
        $id = $row[0]['invoice_code'];
        $sys_y = $row[0]['order_year'];
        if ($sys_y == date('y')) {
            $code = (($id) + 1);
            $year = $sys_y;
        } else {
            $code = 1;
            $year = date('y');
        }
        $query = "UPDATE `saimtech_order_code` SET `invoice_code`=?,`order_year`=? WHERE 1";
        $res = $this->db->query($query, array(
            $code,
            $year
        ));
        return $code;
    }

    public function Get_Active_Customer()
    {
        $query = "SELECT * FROM `saimtech_customer` WHERE `is_enable`=1 ORDER BY `customer_id` DESC ";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_Invoice_Active_Customer()
    {
        $query = "SELECT `saimtech_customer`.`customer_id` as `id`,`saimtech_customer`.`customer_name` as `name`,`city_name` as `city`,is_gst
FROM `saimtech_order`
INNER JOIN saimtech_customer ON saimtech_customer.customer_id=saimtech_order.customer_id
INNER JOIN saimtech_city ON saimtech_city.city_id=saimtech_customer.customer_city
WHERE  `is_invoice`=0 AND (`order_pay_mode`='Account' OR `order_pay_mode`='account')
GROUP BY `saimtech_customer`.`customer_id` order by `saimtech_customer`.`customer_name`";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function Get_Invoice_Active_Customer_gst($customer_id)
    {
        $query = "SELECT `customer_id`, `customer_name`, `is_gst` FROM `saimtech_customer` WHERE `customer_id`=?";
        $res = $this->db->query($query, array(
            $customer_id
        ));
        return $res->result_array();
    }

    public function Get_OK_RTS_CN_BY_Customer_ID($customer_id)
    {
        $query = "SELECT * FROM `saimtech_order` WHERE `is_invoice`=0 AND `customer_id`=? ORDER BY `order_date` DESC ";
        $res = $this->db->query($query, array(
            $customer_id
        ));
        return $res->result();
    }

    public function Get_CN_BY_Customer_ID_And_Date($customer_id, $date, $date_f)
    {
        $query = "SELECT * FROM `saimtech_order` WHERE `is_invoice`=0 AND `customer_id`=? AND (date(`order_date`)>=? AND date(`order_date`)<=?) AND (`order_pay_mode`='Account' OR `order_pay_mode`='account')  ORDER BY `order_date`  ";
        $res = $this->db->query($query, array(
            $customer_id,
            $date,
            $date_f
        ));
        return $res->result();
    }

    public function Get_CN_BY_Customer_ID_Location_And_Date($customer_id, $date, $date_f, $origin, $destination)
    {
        //$query = "SELECT * FROM saimtech_order WHERE is_invoice=0 AND customer_id=? AND (date(order_date)>=? AND date(order_date)<=?) AND (order_pay_mode='Account' OR order_pay_mode='account')  ORDER BY order_date  ";
        
        $query = "SELECT order_id, date(order_date) as order_date, order_code, origin_city_name, destination_city_name, consignee_name, pieces, weight, order_sc, order_osa_sd_total
                    FROM saimtech_order WHERE is_invoice=0 AND customer_id=? AND (date(order_date)>=? AND date(order_date)<=?) AND (order_pay_mode='Account' OR order_pay_mode='account')  ORDER BY order_date  ";

        $select = "SELECT * FROM saimtech_order";
        $f_is_invoice = "is_invoice=0";
        $f_customer_id = "customer_id=?";
        $f_st_date = "date(order_date)>=?";
        $f_ed_date = "date(order_date)<=?";
        $f_st_n_ed_dates = "(" . $f_st_date . " AND " . $f_ed_date . ")";

        $where = 
        $res = $this->db->query($query, array(
            $customer_id,
            $date,
            $date_f
        ));
        return $res->result();
    }

    public function Get_Cn_By_Invoice_Code($invoice_code)
    {
        $query = "SELECT * FROM `saimtech_order` WHERE is_temp_invoice=? ORDER BY `order_date` DESC ";
        $res = $this->db->query($query, array(
            $invoice_code
        ));
        return $res->result();
    }

    public function Get_Cn_By_Invoice_Code_Date($invoice_code, $invoice_date, $invoice_date_f)
    {
        $query = "SELECT * FROM `saimtech_order` WHERE is_temp_invoice=? AND (date(`order_date`)>=? AND date(`order_date`)<=?) AND (`order_pay_mode`='Account' OR `order_pay_mode`='account')  ORDER BY `order_arrival_date` DESC ";
        $res = $this->db->query($query, array(
            $invoice_code,
            $invoice_date,
            $invoice_date_f
        ));
        return $res->result();
    }

    public function Get_Temp_Invoice_Code_By_Cn($cn)
    {
        $query = "SELECT * FROM `saimtech_order` WHERE order_code=? ORDER BY `order_date` DESC ";
        $res = $this->db->query($query, array(
            $cn
        ));
        $invoice = $res->result_array();
        return $invoice[0]['is_temp_invoice'];
    }
}