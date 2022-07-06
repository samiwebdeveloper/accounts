<?php
class Complainmodel extends CI_Model {

	
public function Insert_record($tablename, $data){
$this->db->insert($tablename, $data);  
return $this->db->insert_id();      
}
public function Duplicate_double_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
    $this->db->where($columnname, $conditionvalue);	
    $this->db->where($columnname1, $conditionvalue1);	
    $query = $this->db->get($tablename);  
    return $query->result_array();	
    }    
public function Get_All_Complain_Nature(){
$query ="SELECT * FROM `saimtech_complain_nature`";
$res =  $this->db->query($query);
return $res->result();
}
public function Get_All_Cs_Employee(){
$query ="SELECT * FROM `saimtech_oper_user` WHERE oper_user_power ='CS'";
$res =  $this->db->query($query);
return $res->result();
}
public function Get_Complain_type_By_Nature_Id($nature_id){
$query ="SELECT * FROM `saimtech_complain_type` INNER JOIN `saimtech_complain_nature` on `saimtech_complain_nature`.`nature_id`=`saimtech_complain_type`.`nature_id` WHERE saimtech_complain_nature.nature_id=?";
$res =  $this->db->query($query,array($nature_id));
return $res->result();
}
public function Get_all_Complains(){
$GC_query ="SELECT * 
FROM((( `saimtech_complain`
INNER JOIN `saimtech_complain_nature` on `saimtech_complain_nature`.`nature_id`= `saimtech_complain`.`nature_id`)
INNER JOIN `saimtech_complain_type` on `saimtech_complain_type`.`type_id`= `saimtech_complain`.`type_id`)
INNER JOIN `saimtech_oper_user` on `saimtech_oper_user`.`oper_user_id`= `saimtech_complain`.`created_by`)
ORDER BY `complain_id` DESC";
$res =  $this->db->query($GC_query);
return $res->result();
}
public function Get_Complains_By_Date_Range($startdate,$enddate){
$query ="SELECT saimtech_complain.complain_id, saimtech_complain.ticket_no,saimtech_complain.cn,saimtech_complain.complainant_remarks,
saimtech_complain.complainant_name,saimtech_complain.complainant_phone,saimtech_complain.date,saimtech_complain.remarks,
saimtech_complain.status,saimtech_complain.is_complete,saimtech_complain.is_complete_date,saimtech_complain.created_by as created,saimtech_complain.assign_to,
saimtech_complain_nature.complain_name,saimtech_complain_nature.nature_id,saimtech_complain_type.type_name,saimtech_oper_user.oper_user_name 
FROM((( `saimtech_complain`
INNER JOIN `saimtech_complain_nature` on `saimtech_complain_nature`.`nature_id`= `saimtech_complain`.`nature_id`)
INNER JOIN `saimtech_complain_type` on `saimtech_complain_type`.`type_id`= `saimtech_complain`.`type_id`)
LEFT JOIN `saimtech_oper_user` on `saimtech_oper_user`.`oper_user_id`= `saimtech_complain`.`assign_to`)
WHERE (date(`date`)>=? and  date(`date`)<=?)
ORDER BY  `is_complete` ASC,`complain_id` DESC";
$res = $this->db->query($query,array($startdate,$enddate));
return $res->result();
}
public function Get_Complains_By_User_Date($startdate,$enddate,$user_id){
$query ="SELECT saimtech_complain.complain_id, saimtech_complain.ticket_no,saimtech_complain.cn,saimtech_complain.complainant_remarks,
saimtech_complain.complainant_name,saimtech_complain.complainant_phone,saimtech_complain.date,saimtech_complain.remarks,
saimtech_complain.status,saimtech_complain.is_complete,saimtech_complain.is_complete_date,saimtech_complain.created_by as created,saimtech_complain.assign_to,
saimtech_complain_nature.complain_name,saimtech_complain_nature.nature_id,saimtech_complain_type.type_name,saimtech_oper_user.oper_user_name 
FROM((( `saimtech_complain`
INNER JOIN `saimtech_complain_nature` on `saimtech_complain_nature`.`nature_id`= `saimtech_complain`.`nature_id`)
INNER JOIN `saimtech_complain_type` on `saimtech_complain_type`.`type_id`= `saimtech_complain`.`type_id`)
LEFT JOIN `saimtech_oper_user` on `saimtech_oper_user`.`oper_user_id`= `saimtech_complain`.`assign_to`)
WHERE  (date(`date`)>=? and  date(`date`)<=?) and `saimtech_complain`.`assign_to` =? 
ORDER BY `complain_id` DESC";
$res = $this->db->query($query,array($startdate,$enddate,$user_id));
return $res->result();
}
public function Get_Complain_By_Id($complain_id){
$GC_query ="SELECT * 
FROM((( `saimtech_complain`
INNER JOIN `saimtech_complain_nature` on `saimtech_complain_nature`.`nature_id`= `saimtech_complain`.`nature_id`)
INNER JOIN `saimtech_complain_type` on `saimtech_complain_type`.`type_id`= `saimtech_complain`.`type_id`)
LEFT JOIN `saimtech_oper_user` on `saimtech_oper_user`.`oper_user_id`= `saimtech_complain`.`created_by`)
WHERE complain_id=?
ORDER BY `complain_id` DESC";
$res =  $this->db->query($GC_query,array($complain_id));
return $res->result_array();
}
public function update_complain_status_by_id($id,$status,$remarks,$is_complete,$is_complete_date,$modify_by,$modify_date){
	$data = array(
	'status' 	=> $status,
	'remarks'	=> $remarks,
	'is_complete'=> $is_complete,
	'is_complete_date'	=> $is_complete_date,
	'modify_by'=> $modify_by,
	'modify_date'=> $modify_date,
	
	);
	$this->db->where('complain_id', $id);
	$this->db->update('saimtech_complain', $data); 
	return $this->db->affected_rows();      
	}
public function update_complain_assign_by_id($id,$assign_id,$modify_by,$modify_date){
	$data = array(
	'assign_to' 	=> $assign_id,
	'modify_by'=> $modify_by,
	'modify_date'=> $modify_date,
	
	);
	$this->db->where('complain_id', $id);
	$this->db->update('saimtech_complain', $data); 
	return $this->db->affected_rows();      
	}	
public function update_complain_ticket_by_id($id,$ticket_no){
	$data = array(
	'ticket_no' 			 => $ticket_no,
	);
	$this->db->where('complain_id', $id);
	$this->db->update('saimtech_complain', $data); 
	return $this->db->affected_rows();      
	}

}