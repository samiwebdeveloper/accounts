<?php
class Mailmodel extends CI_Model {

public function Get_Invoice_Data_By_Date_Range($startdate){
$query="SELECT `order_code`, `order_status`, `consignee_name`, `consignee_mobile`
        ,`on_route_id`,`destination_city_name` as `city`,
         cod_amount as `amount` 
         FROM `saimtech_order` 
         WHERE (order_status<>'Deliverd' and order_status<>'RTS' 
         and order_status<>'RTO' and order_status<>'Return De Bagging' 
         AND order_status<>'ReLoading' AND order_status<>'RE UN Loading' 
         and order_status<>'Return Bagging') 
         and date(`on_route_date`)=? 
         group by order_code,`on_route_id`, `destination_city`";
$res = $this->db->query($query,array($startdate));
return $res->result();
}


public function Get_not_deliverd_cns_send_date(){
$query="SELECT * FROM saimtech_mail_sender";
$res = $this->db->query($query);
$row= $res->result_array(); 
return $row[0]['not_deliverd_cns'];
}

public function Get_deliverd_cns_send_date(){
$query="SELECT * FROM saimtech_mail_sender";
$res = $this->db->query($query);
$row= $res->result_array(); 
return $row[0]['deliver_cn_date'];
}

public function Get_deliverd_cns_send_data($prev_date){
$query="SELECT `destination_city_name` as city ,COUNT(order_code) as `shipments`, SUM(`cod_amount`) as `amount` FROM `saimtech_order` 
        WHERE `order_status`='Deliverd' AND date(`order_deliver_date`)=? GROUP BY `destination_city_name` ORDER BY SUM(`cod_amount`) DESC";
$res = $this->db->query($query,array($prev_date));
return $res->result();         
}

public function Get_Daily_Arrival_Report($prev_date,$Month){
$year_prev_date=date('Y', strtotime('-1 day', strtotime($prev_date)));
$Year=$year_prev_date;
$query="SELECT
date(order_arrival_date) as Date,
origin_city_name AS `Origin`, 
COUNT(order_code) as `Arrival`,
SUM(`order_sc`) AS `SC`, 
SUM(cod_amount) AS `COD`,
((SELECT COUNT(`order_code`)    FROM `saimtech_order`   WHERE  MONTH(`order_arrival_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_arrival_date`)=?)) AS `TodayDateCN`,
((SELECT   SUM(`order_sc`)      FROM `saimtech_order`   WHERE  MONTH(`order_arrival_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_arrival_date`)=?)) AS `TodayDateSC`,
((SELECT   SUM(`cod_amount`)    FROM `saimtech_order`   WHERE  MONTH(`order_arrival_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_arrival_date`)=?)) AS `TodayDateCOD`
FROM `saimtech_order` A where date(order_arrival_date)=? group by origin_city";
$res = $this->db->query($query,array($Month,$Year,$Month,$Year,$Month,$Year,$prev_date));
return $res->result();         
}

public function Get_Daily_Delivery_Report($prev_date,$Month){
$year_prev_date=date('Y', strtotime('-1 day', strtotime($prev_date)));
$Year=$year_prev_date;    
$query="SELECT
date(order_deliver_date) as Date,
destination_city_name AS `Destination`, 
COUNT(order_code) as `Deliver`,
SUM(`order_sc`) AS `SC`, 
SUM(cod_amount) AS `COD`,
((SELECT COUNT(`order_code`) FROM `saimtech_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=?) + (SELECT COUNT(`order_code`) FROM `saimtech_archive_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=?))  AS `TodayDateCN`,
((SELECT   SUM(`order_sc`)   FROM `saimtech_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=?) + (SELECT   SUM(`order_sc`)   FROM `saimtech_archive_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=? )) AS `TodayDateSC`,
((SELECT   SUM(`cod_amount`) FROM `saimtech_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=?) + (SELECT   SUM(`cod_amount`) FROM `saimtech_archive_order` WHERE  MONTH(`order_deliver_date`)=? AND `origin_city`=A.`origin_city` AND YEAR(`order_deliver_date`)=?) ) AS `TodayDateCOD`
FROM `saimtech_order` A where date(order_deliver_date)=? group by origin_city";
$res = $this->db->query($query,array($Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$prev_date));
return $res->result();         
}


public function Get_Daily_RTS_Report($prev_date,$Month){
$year_prev_date=date('Y', strtotime('-1 day', strtotime($prev_date)));
$Year=$year_prev_date;    
$query="SELECT
date(order_result_date) as Date,
destination_city_name AS `Destination`, 
COUNT(order_code) as `RTS`,
SUM(`order_sc`) AS `SC`, 
SUM(cod_amount) AS `COD`,
((SELECT COUNT(`order_code`) FROM `saimtech_order` WHERE  MONTH(`order_result_date`)=? AND `origin_city`=A.`origin_city` and `order_status`='RTS' AND YEAR(`order_result_date`)=?) + (SELECT COUNT(`order_code`) FROM `saimtech_archive_order` WHERE  MONTH(`order_result_date`)=? AND `origin_city`=A.`origin_city` AND `order_status`='RTS' AND YEAR(`order_result_date`)=?)) AS `TodayDateCN`,
((SELECT   SUM(`order_sc`)   FROM `saimtech_order` WHERE  MONTH(`order_result_date`)=? AND `origin_city`=A.`origin_city` and `order_status`='RTS' AND YEAR(`order_result_date`)=?) + (SELECT   SUM(`order_sc`)   FROM `saimtech_archive_order` WHERE  MONTH(`order_result_date`)=? AND `origin_city`=A.`origin_city` AND `order_status`='RTS' AND YEAR(`order_result_date`)=?)) AS `TodayDateSC`,
(0) AS `TodayDateCOD`
FROM `saimtech_order` A where date(`order_result_date`)=? and `order_status`='RTS' group by `origin_city`";
$res = $this->db->query($query,array($Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$Month,$Year,$prev_date));
return $res->result();         
}



public function Get_Mail_Date(){
$query="SELECT `arrival_mail_date` FROM `saimtech_mail_sender` ";
$res = $this->db->query($query);
$row = $res->result_array();        
return $row[0]['arrival_mail_date'];
}    



}