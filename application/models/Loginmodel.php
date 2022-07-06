<?php
class Loginmodel extends CI_Model {
	
public function Get_User_Detail_By_Username($email){
$query="SELECT * FROM `acc_user` 
		INNER JOIN acc_city on `acc_city`.`city_id` = `acc_user`. `oper_user_city_id`
		WHERE `oper_account_no`=?  and `acc_user`.`is_enable`=1";
$res = $this->db->query($query,array($email));
return $res->result();
}

public function Update_Login_Date($userid){

$ipAddress=$_SERVER['REMOTE_ADDR'];
$macAddr=false;

#run the external command, break output into lines
$arp=`arp -a $ipAddress`;
$lines=explode("\n", $arp);

#look for the output line describing our IP address
foreach($lines as $line)
{
   $cols=preg_split('/\s+/', trim($line));
   if ($cols[0]==$ipAddress)
   {
       $macAddr=$cols[1];
   }
}

$_SESSION['MAC'] = $macAddr;

$data = array(
'oper_user_id' => $userid,
'last_login' => date('Y-m-d H:i:s'),
'oper_user_mac' => $macAddr,
'oper_user_session' => session_id());
$this->db->insert('acc_sessions',$data);

$data = array(
'last_login' => date('Y-m-d H:i:s'),
'oper_user_mac' => $macAddr,
'oper_user_session' => session_id());
$this->db->where('oper_user_id', $userid);
$this->db->update('acc_user', $data); 
return $this->db->affected_rows();
}

public function Update_Logout_Date($userid){
$data= array(
'last_logout' => date('Y-m-d H:i:s'));
$this->db->where('oper_user_session', session_id());
$this->db->update('acc_sessions', $data); 

$data= array(
'last_logout' => date('Y-m-d H:i:s'));
$this->db->where('oper_user_id', $userid);
$this->db->update('acc_user', $data); 
return $this->db->affected_rows();
}	

}