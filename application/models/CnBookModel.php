<?php
class CnBookModel extends CI_Model
{
    public function Insert_record($tablename, $data)
    {
        $this->db->insert($tablename, $data);
       return $this->db->insert_id();
    }

    public function Update_cn_usage($newbookid,$bookid,$cn)
	{
        
         echo $query="UPDATE `cn_book_usage` SET `book_id`=$newbookid WHERE `book_id`=$bookid and `manual_cn` > $cn";
       $this->db->query($query);
	}

    public function Insert_cn_usage($from,$db_end,$book_id)
    {
        $que="INSERT INTO cn_book_usage (book_id, manual_cn) (SELECT ".$book_id .", seq from seq_".$from."_to_".$db_end.")";
       $this->db->query($que);
 
    }
    public function total_cn_range($book_code)
    {
        // $query = $this->db->query("SELECT  IF(EXISTS( SELECT 1 FROM  cargo.saimtech_order o WHERE  o.manual_cn = seq),
        // (SELECT  CONCAT(seq,'|',DATE(o.order_arrival_date),'|',o.origin_city_name,'|',o.destination_city_name,'|', 
        // o.consignee_name, '|', o.shipper_name, '|', o.weight, '|', o.pieces, '|', o.order_status, '|', 'Booked')
        // FROM cargo.saimtech_order o WHERE  o.manual_cn = seq), CONCAT(seq, '|||||||||Available')) AS 'CNS' FROM
        // cargo.seq_" . $start_no . "_to_" . $end_no . "");
        $query = $this->db->query("SELECT b.book_code, u.manual_cn, date(o.order_date) as order_date, date(o.order_arrival_date) as order_arrival_date, o.origin_city_name, o.destination_city_name, o.shipper_name, o.consignee_name, s.service_name, o.order_pay_mode, o.weight, o.pieces, o.order_status, b.book_status, i.issue_date, r.rider_name, e.oper_user_name FROM `cn_book_usage` u
        join cargo.saimtech_order o on o.order_id = u.order_id
        join cargo.saimtech_service s on s.service_id = o.order_service_type
        join cn_book b on b.book_id = u.book_id
        left join cn_issue i on i.book_id = u.book_id
        left join cargo.saimtech_rider r on r.rider_id = i.issue_to
        left join cargo.saimtech_oper_user e on e.oper_user_id = i.created_by where  b.book_code='$book_code'");
    
       return $query->result();
    }
    public function Update_records($tablename, $columnname, $conditionvalue, $data)
    {
        $this->db->where($columnname, $conditionvalue);
        $this->db->update($tablename, $data);
    }
    public function Update_record($book_id)
    {
        $querys = "update cn_book SET book_status='Is Issued' where book_id='$book_id'";
        $this->db->query($querys);
    }
    public function update_issuance($row_id, $edit_rider, $edit_route, $modified_by)
    {
        $date = date('Y-m-d');
        if ($edit_route == 0) {
            $query = "UPDATE `cn_issue` SET `issue_date`='$date',`issue_to`='$edit_rider',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        } else if ($edit_rider == 0) {
            $query = "UPDATE `cn_issue` SET `issue_date`='$date',`route`='$edit_route',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        } else if ($edit_route != 0 and $edit_rider != 0) {
            $query = "UPDATE `cn_issue` SET `issue_date`='$date',`issue_to`='$edit_rider',`route`='$edit_route',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        }
        $this->db->query($query);
    }
    public function fetch_cn_book_range($tablename, $origin_id)
    {
        $query = $this->db->query("SELECT * from $tablename where book_status='Not Issue' And book_origin='$origin_id'");
        return $query->result();
    }
    public function get_book_by_rider($rider_id)
    {
        $query = $this->db->query("SELECT COUNT(u.manual_cn) AS 'Total_Issued', COUNT(u.order_id) + COUNT(m.cn_no) AS 'Total_Reported', COUNT(u.manual_cn) - COUNT(u.order_id) - COUNT(m.cn_no) AS 'Available'
         FROM `cn_book_usage` u LEFT JOIN `cn_issue` i ON i.book_id = u.book_id LEFT JOIN `cn_status` m ON m.book_id = u.book_id WHERE i.issue_to = '$rider_id'");
        return $query->result();
    }

    public function issue_book($tablename, $origin_id)
    {
        $query = $this->db->query("SELECT * from $tablename where book_status='Is Issued' And book_origin='$origin_id' and modified_by ='Null'");
        return $query->result();
    }
    public function get_cn($id)
    {
        $this->db->select('book_start_cn,book_end_cn');
        $this->db->where('book_id', $id);
        $query = $this->db->get('cn_book');
        return $query->result();
    }
    public function cn_book_summary($origin_id)
    {
        $query = $this->db->query("SELECT book_status,COUNT(*) total FROM `cn_book` where book_origin='$origin_id' and modified_by='Null' GROUP by book_status");
        return $query->result();
    }
    public function cn_summary($origin_id)
    {
        $query = $this->db->query("SELECT COUNT(u.manual_cn) AS 'Total_Issued', COUNT(u.order_id) + COUNT(m.cn_no) AS 'Total_Reported', COUNT(u.manual_cn) - COUNT(u.order_id) - COUNT(m.cn_no) AS 'Available'
        FROM `cn_book_usage` u LEFT JOIN `cn_issue` i ON i.book_id = u.book_id LEFT JOIN `cn_status` m ON m.book_id = u.book_id where i.origin_id='$origin_id'");
        return $query->result();
    }
    public function cn_book_instock($origin_id)
    {
        $query = $this->db->query("SELECT cn_book.*, cargo.saimtech_oper_user.oper_user_name
        from cn_book inner join cargo.saimtech_oper_user on cn_book.created_by=cargo.saimtech_oper_user.oper_user_id where book_status='Not issue' and cn_book.book_origin='$origin_id'");
        return $query->result();
    }
    function display_route()
    {
        $this->db->select('route_id,route_name');
        $this->db->where('is_enable', '1');
        $this->db->order_by("route_id", "asc");
        $query = $this->db->get("cargo.saimtech_route");
        return $query->result_array();
    }
    function display_rider()
    {
        $this->db->select('rider_id,rider_name');
        $this->db->where('is_enable', '1');
        $this->db->order_by("rider_id", "asc");
        $query = $this->db->get("cargo.saimtech_rider");
        return $query->result_array();
    }
    public function cn_issuance($origin_id)
    {
        // $query = "SELECT cn_issue.*, cargo.saimtech_rider.rider_name, cargo.saimtech_route.route_name, cargo.saimtech_oper_user.oper_user_name,
        //  cn_book.book_code from cn_issue inner join cargo.saimtech_rider on cn_issue.issue_to=cargo.saimtech_rider.rider_id inner join 
        //  cargo.saimtech_route on cn_issue.route=cargo.saimtech_route.route_id inner join cargo.saimtech_oper_user on 
        //  cn_issue.created_by=cargo.saimtech_oper_user.oper_user_id inner join cn_book on cn_issue.book_id=cn_book.book_id where
        //  cn_issue.origin_id='$origin_id' order by cargo.saimtech_rider.rider_name ";
        $query = "SELECT cn_issue.*, cargo.saimtech_rider.rider_name, cargo.saimtech_route.route_name, cargo.saimtech_oper_user.oper_user_name, cn_book.book_code, COUNT(cn_book_usage.manual_cn) AS 'Remaining' FROM cn_issue 
        LEFT JOIN cargo.saimtech_rider ON cn_issue.issue_to = cargo.saimtech_rider.rider_id LEFT JOIN cargo.saimtech_route ON cn_issue.route = cargo.saimtech_route.route_id LEFT JOIN cargo.saimtech_oper_user ON
         cn_issue.created_by = cargo.saimtech_oper_user.oper_user_id LEFT JOIN cn_book ON cn_issue.book_id = cn_book.book_id LEFT JOIN cn_book_usage ON cn_book_usage.book_id = cn_book.book_id AND cn_book_usage.order_id IS NULL
          WHERE cn_issue.origin_id = '$origin_id' GROUP BY cn_book_usage.book_id ORDER BY cargo.saimtech_rider.rider_name";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_book_id($cn)
    {
        $query = "SELECT book_id from cn_book where '$cn' between book_start_cn and book_end_cn";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_book_start_cn($cn)
    {
        $query = "SELECT book_start_cn from cn_book where $cn between book_start_cn and book_end_cn";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function cn_reissue($origin_id)
    {
        $query = "SELECT cn_reissue.*, cargo.saimtech_rider.rider_name, cargo.saimtech_route.route_name, 
        cargo.saimtech_oper_user.oper_user_name, cn_book.book_code from cn_reissue inner join cargo.saimtech_rider
         on cn_reissue.rider=cargo.saimtech_rider.rider_id inner join cargo.saimtech_route on 
         cn_reissue.route=cargo.saimtech_route.route_id inner join cargo.saimtech_oper_user on 
         cn_reissue.created_by=cargo.saimtech_oper_user.oper_user_id inner join cn_book on 
         cn_reissue.book_id=cn_book.book_id where book_origin='$origin_id'";
        $res = $this->db->query($query);
        return $res->result();
    }
    public function cn_usage($origin_id)
    {
        $query = " SELECT cn_status.*,
                cn_book.book_code,
                 cargo.saimtech_rider.rider_name,
                cargo.saimtech_route.route_name
                from cn_status 
                inner join cn_book on cn_status.cn_no BETWEEN cn_book.book_start_cn and cn_book.book_end_cn
                inner join cn_issue on cn_book.book_id = cn_issue.book_id
                inner join cargo.saimtech_rider on cn_issue.issue_to=cargo.saimtech_rider.rider_id 
                inner join cargo.saimtech_route on cn_issue.route=cargo.saimtech_route.route_id where cn_status.origin_id='$origin_id'";
        $res = $this->db->query($query);
        return $res->result();
    }
    public function cn_missing($origin_id)
    {
        // $query = "SELECT b.book_code, u.manual_cn, b.book_status, i.issue_date, r.rider_name, e.oper_user_name FROM `cn_book_usage` u
        // join cn_book b on b.book_id = u.book_id  left join cn_issue i on i.book_id = u.book_id
        // left join cargo.saimtech_rider r on r.rider_id = i.issue_to left join cargo.saimtech_oper_user e on e.oper_user_id = i.created_by
        // where u.order_id is null and b.book_origin='$origin_id' GROUP by u.book_id having COUNT(u.book_id) < 50  order by  r.rider_name";
       
        // $query="SELECT b.book_code, b.book_status, i.issue_date, r.rider_name, e.oper_user_name, a.manual_cn FROM cn_book_usage a 
        // JOIN cn_book b ON b.book_id = a.book_id LEFT JOIN cn_issue i ON i.book_id = a.book_id 
        // LEFT JOIN cargo.saimtech_rider r ON r.rider_id = i.issue_to LEFT JOIN cargo.saimtech_oper_user e ON e.oper_user_id = i.created_by 
        // WHERE a.book_id IN( SELECT b.book_id FROM `cn_book_usage` u JOIN cn_book b ON b.book_id = u.book_id WHERE b.book_origin = '$origin_id'
        //  GROUP BY u.book_id, b.book_cn_count HAVING COUNT(u.order_id) BETWEEN 1 AND b.book_cn_count ) AND a.order_id IS NULL";
        $query = "SELECT b.book_code, b.book_status, i.issue_date, r.rider_name, e.oper_user_name, a.manual_cn FROM cn_book_usage a 
        JOIN cn_book b ON b.book_id = a.book_id LEFT JOIN cn_issue i ON i.book_id = a.book_id 
        LEFT JOIN cargo.saimtech_rider r ON r.rider_id = i.issue_to LEFT JOIN cargo.saimtech_oper_user e ON e.oper_user_id = i.created_by 
        WHERE a.book_id IN( SELECT b.book_id FROM `cn_book_usage` u JOIN cn_book b ON b.book_id = u.book_id WHERE b.book_origin = '$origin_id'
         GROUP BY u.book_id, b.book_cn_count HAVING COUNT(u.order_id) > 1 AND b.book_cn_count/2 ) AND a.order_id IS NULL";
        $res = $this->db->query($query);
        return $res->result();
    }
}
