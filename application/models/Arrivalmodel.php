<?php
class Arrivalmodel extends CI_Model {

	
public function Get_Order_By_Code($cn){
$query="SELECT *  FROM `saimtech_order` WHERE  (`order_code`=? or manual_cn=?)";
$res = $this->db->query($query,array($cn,$cn));
return $res->result_array();
}

public function Get_Arrival_Print_Sheet_By_code($code){
$query="SELECT *, `saimtech_order`.`weight` as order_weight, `saimtech_order`.`pieces` as order_pieces FROM `saimtech_arrival_detail`
INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code` = `saimtech_arrival_detail`.`order_code`
INNER JOIN `saimtech_arrival_list` ON `saimtech_arrival_list`.`arrival_id` = `saimtech_arrival_detail`.`arrival_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_arrival_detail`.`created_by`
WHERE `saimtech_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}


public function Get_Arrival_Print_Sheet_By_code_Archive($code){
$query="SELECT *, `saimtech_order`.`weight` as order_weight, `saimtech_order`.`pieces` as order_pieces FROM `saimtech_archive_arrival_detail`
INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code` = `saimtech_archive_arrival_detail`.`order_code`
INNER JOIN `saimtech_archive_arrival_list` ON `saimtech_archive_arrival_list`.`arrival_id` = `saimtech_archive_arrival_detail`.`arrival_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_arrival_detail`.`created_by`
WHERE `saimtech_archive_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}


public function Get_Arrival_Print_Sheet_By_code_Archive_Archive($code){
$query="SELECT *, `saimtech_archive_order`.`weight` as order_weight, `saimtech_archive_order`.`pieces` as order_pieces FROM `saimtech_archive_arrival_detail`
INNER JOIN `saimtech_archive_order` ON `saimtech_archive_order`.`order_code` = `saimtech_archive_arrival_detail`.`order_code`
INNER JOIN `saimtech_archive_arrival_list` ON `saimtech_archive_arrival_list`.`arrival_id` = `saimtech_archive_arrival_detail`.`arrival_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_arrival_detail`.`created_by`
WHERE `saimtech_archive_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}

public function Get_Arrival_Sheets_By_Origin($origin){
$query="SELECT *  FROM `saimtech_arrival_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_arrival_list`.`arrival_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  `saimtech_arrival_list`.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_arrival_list`.`created_by`
		WHERE  `arrival_origin`=? ORDER BY `saimtech_arrival_list`.`arrival_id` DESC ";
$res = $this->db->query($query,array($origin));
return $res->result();
}


public function Get_Arrival_Sheets_By_Origin_Range($origin,$startdate,$enddate){
$query="SELECT * , (SELECT COUNT(`arrival_id`) FROM `saimtech_arrival_detail` WHERE `arrival_id`=A.`arrival_id`) as `cn` FROM `saimtech_arrival_list` A
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  A.`arrival_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  A.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  A.`created_by`
		WHERE  `arrival_origin`=? and (date(`arrival_date`)>=? and  date(`arrival_date`)<=?)
		ORDER BY A.`arrival_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}


public function Get_Arrival_Sheets_By_Origin_Range_Archive($origin,$startdate,$enddate){
$query="SELECT *, (SELECT COUNT(`arrival_id`) FROM `saimtech_archive_arrival_detail` WHERE `arrival_id`=A.`arrival_id`) as `cn`  FROM `saimtech_archive_arrival_list` A
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  A.`arrival_origin`
		INNER JOIN `saimtech_rider` ON `saimtech_rider`.`rider_id`=  A.`rider_id`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  A.`created_by`
		WHERE  `arrival_origin`=? and (date(`arrival_date`)>=? and  date(`arrival_date`)<=?)
		ORDER BY A.`arrival_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}

public function Check_CN($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE (`order_code`=? or manual_cn=?)";
$res = $this->db->query($query,array($cn,$cn));
return $res->num_rows();	
}

public function Get_All_Arrival_Sheets($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->num_rows();	
}

public function Get_Arrival_Sheet_By_code($code){
$query="SELECT `saimtech_arrival_list`.`arrival_date` as `date`,`order_id`, `saimtech_arrival_detail`.`order_code` as `cn`,`saimtech_order`.`manual_cn` as `manual`, `saimtech_arrival_list`.`arrival_id` as `id`, arrival_sheet_code as `Sheet`, `saimtech_arrival_detail`.weight , new_weight, `saimtech_arrival_detail`.pieces, new_pieces , arrival_detail_id AS d_id   FROM `saimtech_arrival_list`
INNER JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`arrival_id` = `saimtech_arrival_list`.`arrival_id`
INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code`=`saimtech_arrival_detail`.`order_code`
WHERE `saimtech_arrival_list`.`arrival_sheet_code`=?  order by `saimtech_arrival_detail`.`arrival_detail_id` DESC ";
$res = $this->db->query($query,array($code));
return $res->result();	
}

public function Get_Arrival_Sheet_Count_By_code($code){
$query="SELECT COUNT(`order_code`) as `cn` FROM `saimtech_arrival_list`
INNER JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.`arrival_id` = `saimtech_arrival_list`.`arrival_id`
WHERE `saimtech_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
$row = $res->result_array();
return $row[0]['cn'];
}

public function Get_Arrival_Status_By_Code($code){
$query="SELECT *  FROM `saimtech_arrival_list`
WHERE `saimtech_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result_array();
}


public function Get_City_Detail_By_id($id){
$query="SELECT *  FROM `saimtech_city` WHERE `city_id`=? ";
$res = $this->db->query($query,array($id));
return $res->result_array();
}

public function Check_Arrival_Sheet_Code($code){
$query="SELECT *  FROM `saimtech_arrival_list`
WHERE `saimtech_arrival_list`.`arrival_sheet_code`=? ";
$res = $this->db->query($query,array($code));
return $res->num_rows();	
}

public function Get_Last_Arrival_Sheet_Code(){
$id=0;
$code=0;
$year=0;
$sy_y=0;
$select_query="SELECT * from saimtech_order_code";
$res = $this->db->query($select_query);
$row=$res->result_array();
$id=$row[0]['arrival_sheet_code'];
$sys_y=$row[0]['order_year'];
if($sys_y==date('y')){
$code=(($id)+1);
$year=$sys_y;
} else {
$code=1;
$year=date('y');	
}
$query="UPDATE `saimtech_order_code` SET `arrival_sheet_code`=?,`order_year`=? WHERE 1";
$res = $this->db->query($query,array($code,$year));
return $code;
}

Public function Get_Incomplete_Arrival_Sheet($userid){
$query="SELECT `arrival_sheet_code` as `sheetcode`,`arrival_id`  FROM `saimtech_arrival_list`  WHERE `created_by`=? and is_complete=0 order by arrival_id DESC ";
$res = $this->db->query($query,array($userid));
return $res->result_array();
}

Public function Get_Incomplete_Arrival_Sheet_Count($userid){
$query="SELECT `arrival_sheet_code` as `sheetcode`,`arrival_id`  FROM `saimtech_arrival_list`  WHERE `created_by`=? and is_complete=0";
$res = $this->db->query($query,array($userid));
return $res->num_rows();
}

 

//-------------Remove---------------
public function Get_Order_Detail_By_CN($cn){
$query="SELECT * FROM `saimtech_order`  WHERE order_code=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();	
}


//-------------Remove------------END



//-----------Boost Up--------------
public function Get_Boost_Up_Arrival_Sheet_Record(){
$query="SELECT COUNT(`saimtech_arrival_list`.`arrival_id`) as `arrival_sheet` FROM `saimtech_arrival_list` 
        INNER JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.arrival_id = `saimtech_arrival_list`.`arrival_id`
        WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_list`.`arrival_date`))>15 and `saimtech_arrival_list`.`is_complete`=1";
$res = $this->db->query($query);
$rows= $res->result_array();    
return $rows[0]['arrival_sheet'];
}

public function Run_Boost_Up(){
$this->db->trans_start();	    
$query="INSERT INTO `saimtech_archive_arrival_list` SELECT 
`saimtech_arrival_list`.`arrival_id`,
`saimtech_arrival_list`.`arrival_sheet_code`,
`saimtech_arrival_list`.`arrival_date`,
`saimtech_arrival_list`.`arrival_origin`,
`saimtech_arrival_list`.`rider_id`,
`saimtech_arrival_list`.`is_complete`,
`saimtech_arrival_list`.`ip_address`,
`saimtech_arrival_list`.`created_by`,
`saimtech_arrival_list`.`created_date`,
`saimtech_arrival_list`.`modify_by`,
`saimtech_arrival_list`.`modify_date` 
FROM `saimtech_arrival_list` 
WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_list`.`arrival_date`))>15 and `saimtech_arrival_list`.`is_complete`=1";
$res = $this->db->query($query);    
$query1="INSERT INTO `saimtech_archive_arrival_detail` SELECT 
`saimtech_arrival_detail`.`arrival_detail_id`, 
`saimtech_arrival_detail`.`arrival_id`, 
`saimtech_arrival_detail`.`order_code`, 
`saimtech_arrival_detail`.`weight`, 
`saimtech_arrival_detail`.`new_weight`, 
`saimtech_arrival_detail`.`pieces`, 
`saimtech_arrival_detail`.`new_pieces`, 
`saimtech_arrival_detail`.`order_detail_id`, 
`saimtech_arrival_detail`.`arrival_date`, 
`saimtech_arrival_detail`.`created_by`, 
`saimtech_arrival_detail`.`created_date` 
FROM `saimtech_arrival_list` 
INNER JOIN `saimtech_arrival_detail` ON `saimtech_arrival_detail`.arrival_id = `saimtech_arrival_list`.`arrival_id` 
WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_list`.`arrival_date`))>15 and `saimtech_arrival_list`.`is_complete`=1";
$res = $this->db->query($query1);    
$query_delete1="DELETE FROM `saimtech_arrival_detail` WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_detail`.`arrival_date`))>15";
$this->db->query($query_delete1); 
$query_delete2="DELETE FROM `saimtech_arrival_list` WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_list`.`arrival_date`))>15 and `saimtech_arrival_list`.`is_complete`=1";
$this->db->query($query_delete2);
$this->db->trans_complete();
}

public function Pendding_Archive(){
$query="SELECT COUNT(`saimtech_arrival_list`.`arrival_id`) as `records` FROM `saimtech_arrival_list`
        WHERE DATEDIFF(CURDATE(),date(`saimtech_arrival_list`.`arrival_date`))>15 and `saimtech_arrival_list`.`is_complete`=1";
$res=$this->db->query($query);
$row = $res->result_array();
return $row[0]['records'];
}
//-----------Boost Up------------END
public function Update_Pick_Riders(){
$query="UPDATE `saimtech_order` A SET `pickup_rider_id`=(SELECT saimtech_arrival_list.rider_id FROM saimtech_arrival_list WHERE A.arrival_id = saimtech_arrival_list.arrival_sheet_code) WHERE is_arrival='1'";
$this->db->query($query);    
    
}

}