<?php

class CnBookModel extends CI_Model
{
    public function Insert_record($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function Update_record($book_id)
    {
        $querys = "update saimtech_book SET book_status='Is Issued' where book_id='$book_id'";
        $this->db->query($querys);
    }

    public function update_issuance($row_id, $edit_rider, $edit_route, $modified_by)
    {
        $date = date('Y-m-d');
        if ($edit_route == 0) {
            $query = "UPDATE `saimtech_cn_issue` SET `issue_date`='$date',`issue_to`='$edit_rider',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        } else if ($edit_rider == 0) {
            $query = "UPDATE `saimtech_cn_issue` SET `issue_date`='$date',`route`='$edit_route',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        } else if ($edit_route != 0 and $edit_rider != 0) {
            $query = "UPDATE `saimtech_cn_issue` SET `issue_date`='$date',`issue_to`='$edit_rider',`route`='$edit_route',`modified_by`='$modified_by',`modified_date`='$date' WHERE cn_id='$row_id'";
        }
        $this->db->query($query);
    }

    public function fetch_cn_book_range($tablename, $origin_id)
    {

        $query = $this->db->query("SELECT * from $tablename where book_status='Not Issue' And book_origin='$origin_id'");
        return $query->result();
    }

    public function issue_book($tablename, $origin_id)
    {
        $query = $this->db->query("SELECT * from $tablename where book_status='Is Issued' And book_origin='$origin_id'");
        return $query->result();
    }

    public function get_cn($id)
    {
        $this->db->select('book_start_cn,book_end_cn');
        $this->db->where('book_id', $id);
        $query = $this->db->get('saimtech_book');
        return $query->result();
    }

    public function cn_book_summary($origin_id)
    {
        $query = $this->db->query("SELECT book_status,COUNT(*) total FROM `saimtech_book` where book_origin='$origin_id' GROUP by book_status");
        return $query->result();
    }

    public function cn_book_instock($origin_id)
    {
        $query = $this->db->query("SELECT saimtech_book.*, cargo.saimtech_oper_user.oper_user_name
        from saimtech_book inner join cargo.saimtech_oper_user on saimtech_book.created_by=cargo.saimtech_oper_user.oper_user_id where book_status='Not issue' and saimtech_book.book_origin='$origin_id'");
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


    public function cn_issuance($tablename, $origin_id)
    {
        $query = "SELECT saimtech_cn_issue.*,
        cargo.saimtech_rider.rider_name,
        cargo.saimtech_route.route_name,
        cargo.saimtech_oper_user.oper_user_name,
        saimtech_book.book_code
        from saimtech_cn_issue 
        inner join cargo.saimtech_rider on saimtech_cn_issue.issue_to=cargo.saimtech_rider.rider_id 
        inner join cargo.saimtech_route on saimtech_cn_issue.route=cargo.saimtech_route.route_id 
        inner join cargo.saimtech_oper_user on saimtech_cn_issue.created_by=cargo.saimtech_oper_user.oper_user_id
        inner join saimtech_book on saimtech_cn_issue.book_id=saimtech_book.book_id where saimtech_cn_issue.origin_id='$origin_id'";
        $res = $this->db->query($query);
        return $res->result();
    }
    public function cn_reissue($origin_id)
    {
        $query = "SELECT saimtech_cn_reissue.*, cargo.saimtech_rider.rider_name, cargo.saimtech_route.route_name, 
        cargo.saimtech_oper_user.oper_user_name, saimtech_book.book_code from saimtech_cn_reissue inner join cargo.saimtech_rider
         on saimtech_cn_reissue.rider=cargo.saimtech_rider.rider_id inner join cargo.saimtech_route on 
         saimtech_cn_reissue.route=cargo.saimtech_route.route_id inner join cargo.saimtech_oper_user on 
         saimtech_cn_reissue.created_by=cargo.saimtech_oper_user.oper_user_id inner join saimtech_book on 
         saimtech_cn_reissue.book_id=saimtech_book.book_id where book_origin='$origin_id'";
        $res = $this->db->query($query);
        return $res->result();
    }

    public function cn_usage($origin_id)
    {
        $query = " SELECT tbl_cn_management.*,
                saimtech_book.book_code,
                 cargo.saimtech_rider.rider_name,
                cargo.saimtech_route.route_name
                from tbl_cn_management 
                inner join saimtech_book on tbl_cn_management.cn_no BETWEEN saimtech_book.book_start_cn and saimtech_book.book_end_cn
                inner join saimtech_cn_issue on saimtech_book.book_id = saimtech_cn_issue.book_id
                 inner join cargo.saimtech_rider on saimtech_cn_issue.issue_to=cargo.saimtech_rider.rider_id 
                inner join cargo.saimtech_route on saimtech_cn_issue.route=cargo.saimtech_route.route_id where tbl_cn_management.origin_id='$origin_id'";
        $res = $this->db->query($query);
        return $res->result();
    }
}
