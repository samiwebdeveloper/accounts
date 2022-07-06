<?php
class Debaggingmodel extends CI_Model {




public function Get_Debagging_Sheets_By_Origin($origin,$startdate,$enddate){
$query="SELECT *  FROM `saimtech_bagging_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_bagging_list`.`debagging_origin`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_bagging_list`.`debagging_created_by`
		WHERE  `debagging_origin`=? and (date(`debagging_date`)>=? and  date(`debagging_date`)<=?) ORDER BY `saimtech_bagging_list`.`bagging_list_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}


public function Get_Debagging_Sheets_By_Origin_Archive($origin,$startdate,$enddate){
$query="SELECT *  FROM `saimtech_archive_bagging_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_archive_bagging_list`.`debagging_origin`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_bagging_list`.`debagging_created_by`
		WHERE  `debagging_origin`=? and (date(`debagging_date`)>=? and  date(`debagging_date`)<=?) ORDER BY `saimtech_archive_bagging_list`.`bagging_list_id` DESC ";
$res = $this->db->query($query,array($origin,$startdate,$enddate));
return $res->result();
}


public function Get_ReDebagging_Sheets_By_Origin($origin){
$query="SELECT *  FROM `saimtech_bagging_list`
		INNER JOIN `saimtech_city` ON `saimtech_city`.`city_id`=  `saimtech_bagging_list`.`debagging_origin`
		INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_bagging_list`.`debagging_created_by`
		WHERE  `debagging_origin`=? And `bagging_type`='Return' ORDER BY `saimtech_bagging_list`.`bagging_list_id` DESC ";
$res = $this->db->query($query,array($origin));
return $res->result();
}



public function Check_Bag($bagcode){
$query="SELECT *  FROM `saimtech_bagging_list` WHERE bagging_seal=? OR bagging_code=?";
$res =$this->db->query($query,array($bagcode,$bagcode));
return $res->num_rows();
}


public function Get_Bag_Detail($bagcode){
$query="SELECT *  FROM `saimtech_bagging_list` WHERE bagging_seal=? OR bagging_code=?";
$res =$this->db->query($query,array($bagcode,$bagcode));
return $res->result_array();
}

public function Get_Calculate_Bags_By_Code($bagcode){
$query="SELECT Count(`bagging_detail_id`) as `total_bag` FROM `saimtech_bagging_list`
INNER JOIN `saimtech_bagging_detail` ON `saimtech_bagging_detail`.`bagging_list_id` = `saimtech_bagging_list`.`bagging_list_id`
WHERE bagging_seal=? OR bagging_code=?";
$res = $this->db->query($query,array($bagcode,$bagcode));
$total=$res->result_array();	
$total_bag=$total[0]['total_bag'];
//=============================
$query2="SELECT Count(`bagging_detail_id`) as `scan_bag` FROM `saimtech_bagging_list`
INNER JOIN `saimtech_bagging_detail` ON `saimtech_bagging_detail`.`bagging_list_id` = `saimtech_bagging_list`.`bagging_list_id`
WHERE ( `bagging_seal`=? OR `bagging_code`=? ) and  `saimtech_bagging_detail`.`is_debagging`=1";
$res1 = $this->db->query($query2,array($bagcode,$bagcode));
$scan=$res1->result_array();	
$scan_bag=$scan[0]['scan_bag'];
//=============================
$narration=$scan_bag."/".$total_bag;
return $narration;
}


public function Check_CN($cn){
$query="SELECT *  FROM `saimtech_order`
WHERE `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->num_rows();	
}

public function Check_Cn_BAG($code,$cn){
$query="SELECT *  FROM `saimtech_bagging_list` 
INNER JOIN  `saimtech_bagging_detail` ON `saimtech_bagging_detail`.`bagging_list_id`=`saimtech_bagging_list`.`bagging_list_id`
WHERE  `order_code`=? AND (`bagging_code`=? OR `bagging_seal`=?)";
$res = $this->db->query($query,array($cn,$code,$code));
return $res->num_rows();
}



public function Get_Short_Count($code){
$query="SELECT  COUNT(`saimtech_bagging_detail`.`is_debagging`) as `Short`  FROM `saimtech_bagging_list` 
		INNER JOIN `saimtech_bagging_detail` ON `saimtech_bagging_detail`.`bagging_list_id` = `saimtech_bagging_list`.`bagging_list_id`		
		WHERE `saimtech_bagging_list`.`bagging_code`=?  AND  `saimtech_bagging_detail`.`is_debagging`=0" ;
$res = $this->db->query($query,array($code));
$row = $res->result_array();
return $row[0]['Short'];
} 

public function Get_Order_By_Code($cn){
$query="SELECT *  FROM `saimtech_order` WHERE  `order_code`=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();
}



public function Get_City_Detail_By_id($id){
$query="SELECT *  FROM `saimtech_city` WHERE `city_id`=? ";
$res = $this->db->query($query,array($id));
return $res->result_array();
}

public function Check_Bagging_Sheet_Code($code){
$query="SELECT *  FROM `saimtech_bagging_list`
WHERE `saimtech_bagging_list`.`bagging_code`=? ";
$res = $this->db->query($query,array($code));
return $res->num_rows();	
}


public function Get_Debagging_Cn_Detail($code){
$query="SELECT *  FROM `saimtech_bagging_list`
		INNER JOIN `saimtech_bagging_detail` ON `saimtech_bagging_detail`.`bagging_list_id` = `saimtech_bagging_list`.`bagging_list_id` 
		WHERE (`bagging_code`=? OR `bagging_seal`=?) AND `saimtech_bagging_detail`.`is_debagging`=1 ";
$res = $this->db->query($query,array($code,$code));
return $res->result_array();
} 


public function Get_Debagging_Print_Sheet_By_code($code){
$query="SELECT *, `saimtech_order`.`weight` as order_weight, `saimtech_order`.`pieces` as order_pieces FROM `saimtech_bagging_detail`
INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code` = `saimtech_bagging_detail`.`order_code`
INNER JOIN `saimtech_bagging_list` ON `saimtech_bagging_list`.`bagging_list_id` = `saimtech_bagging_detail`.`bagging_list_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_bagging_list`.`debagging_created_by`
WHERE `saimtech_bagging_list`.`bagging_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}


public function Get_Debagging_Print_Sheet_By_code_Archive($code){
$query="SELECT *, `saimtech_order`.`weight` as order_weight, `saimtech_order`.`pieces` as order_pieces FROM `saimtech_archive_bagging_detail`
INNER JOIN `saimtech_order` ON `saimtech_order`.`order_code` = `saimtech_archive_bagging_detail`.`order_code`
INNER JOIN `saimtech_archive_bagging_list` ON `saimtech_archive_bagging_list`.`bagging_list_id` = `saimtech_archive_bagging_detail`.`bagging_list_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_bagging_list`.`debagging_created_by`
WHERE `saimtech_archive_bagging_list`.`bagging_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}


public function Get_Debagging_Print_Sheet_By_code_Archive_Archive($code){
$query="SELECT *, `saimtech_archive_order`.`weight` as order_weight, `saimtech_archive_order`.`pieces` as order_pieces FROM `saimtech_archive_bagging_detail`
INNER JOIN `saimtech_archive_order` ON `saimtech_archive_order`.`order_code` = `saimtech_archive_bagging_detail`.`order_code`
INNER JOIN `saimtech_archive_bagging_list` ON `saimtech_archive_bagging_list`.`bagging_list_id` = `saimtech_archive_bagging_detail`.`bagging_list_id`
INNER JOIN `saimtech_oper_user` ON `saimtech_oper_user`.`oper_user_id`=  `saimtech_archive_bagging_list`.`debagging_created_by`
WHERE `saimtech_archive_bagging_list`.`bagging_code`=? ";
$res = $this->db->query($query,array($code));
return $res->result();	
}


//-------------Remove---------------
Public function Get_Order_Detail_By_CN($cn){
$query="SELECT * FROM `saimtech_order`  WHERE order_code=? ";
$res = $this->db->query($query,array($cn));
return $res->result_array();	
}


//-------------Remove------------END


}