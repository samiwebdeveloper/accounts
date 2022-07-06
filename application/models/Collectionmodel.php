<?php
class Collectionmodel extends CI_Model
{

    public function Get_FOD_to_collect($startDate, $endDate, $destReporting)
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`,2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`,2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
		CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`
    FROM
        `cargo`.`saimtech_order` `o`
			WHERE date(`o`.`order_date`) BETWEEN ? AND ?
			AND `o`.`destination_reporting` = ? 
			AND `o`.`order_status` = 'On Route'
			AND `o`.`cod_amount` > 0 
            AND `o`.`order_id` NOT IN (SELECT `order_id` FROM `cod_collection`)";

        $res = $this->db->query($query, array($startDate, $endDate, $destReporting));
        return $res->result();
    }

    public function Get_collected_fod($startDate, $endDate, $userId, $locationId)
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`,
        FORMAT(`c`.`collection`, 2) AS `collection`,
        `c`.`created_at` AS `collection_date`,
        `c`.`cod_collection_id` AS `cod_collection_id`
    FROM
        `cargo`.`saimtech_order` `o`
            JOIN
        `cod_collection` `c` ON `c`.`order_id` = `o`.`order_id`
    WHERE
        DATE(`c`.`created_at`) BETWEEN ? AND ?
            AND `c`.`is_submitted` = 0
            AND `c`.`user_id` = ?
            AND `c`.`location_id` = ?
            ORDER BY `c`.`created_at`;";

        $res = $this->db->query($query, array($startDate, $endDate, $userId, $locationId));
        return $res->result();
    }

    public function Get_submitted_fod($startDate, $endDate, $userId, $locationId)
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`,
        FORMAT(`c`.`collection`, 2) AS `collection`,
        `c`.`created_at` AS `collection_date`,
        FORMAT(`c`.`collection`,2) AS `collection`,
        `s`.`cod_sheet_no` AS `cod_sheet_no`,
        `s`.`cod_sheet_id` AS `cod_sheet_id`
    FROM
        `cargo`.`saimtech_order` `o`
            JOIN
        `cod_collection` `c` ON `c`.`order_id` = `o`.`order_id`
        JOIN
    `cod_sheet` `s` ON `s`.`cod_sheet_id` = `c`.`cod_sheet_id`
    WHERE
        DATE(`c`.`created_at`) BETWEEN ? AND ?
            AND `c`.`is_submitted` = 1
            AND `c`.`user_id` = ?
            AND `c`.`location_id` = ?
            ORDER BY `c`.`created_at`;";

        $res = $this->db->query($query, array($startDate, $endDate, $userId, $locationId));
        return $res->result();
    }

    public function Get_submitted_sheet($startDate, $endDate, $userId, $locationId)
    {
        $query = "SELECT 
        s.cod_sheet_no,
        s.cod_sheet_id,
        s.total_cns,
        FORMAT(s.total_amt,2) AS 'total_amt',
        s.submit_to,
        s.remarks,
        s.created_at,
        u.oper_user_name,
        c.city_full_name
    FROM
        cod_sheet s
            JOIN
        acc_user u ON u.oper_user_id = s.user_id
            JOIN
        acc_city c ON c.city_id = s.location_id
    WHERE
        DATE(s.created_at) BETWEEN ? AND ?
            AND s.user_id = ?
            AND s.location_id = ?;";

        $res = $this->db->query($query, array($startDate, $endDate, $userId, $locationId));
        return $res->result();
    }

    public function get_cn_to_collect($cn)
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`,2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`,2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
		CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`
    FROM
        `cargo`.`saimtech_order` `o`		
        WHERE ";

        if (strlen($cn) < 10) {
            $query .= "`o`.`manual_cn` = " . $cn;
        } else {
            $query .= "`o`.`order_code` = " . $cn;
        }

        $query .= " AND `o`.`order_id` NOT IN (SELECT `order_id` FROM `cod_collection`);";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_collect_sheet_code()
    {
        $query = "select deposit_code
        FROM cargo.saimtech_order_code";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_sheet_preview($sheet_id)
    {
        $query = "SELECT 
        s.cod_sheet_no,
        s.cod_sheet_id,
        s.total_cns,
        FORMAT(s.total_amt,2) as 'total_amt',
        s.submit_to,
        s.remarks,
        s.created_at,
        u.oper_user_name,
        c.city_full_name
    FROM
        cod_sheet s
            JOIN
        acc_user u ON u.oper_user_id = s.user_id
            JOIN
        acc_city c ON c.city_id = s.location_id
    WHERE
        s.cod_sheet_id = '" . $sheet_id . "';";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_collection_preview($sheet_id)
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`,
        FORMAT(`c`.`collection`, 2) AS `collection`,
        `c`.`created_at` AS `collection_date`,
        FORMAT(`c`.`collection`,2) AS `collection`,
        `s`.`cod_sheet_no` AS `cod_sheet_no`,
        `s`.`cod_sheet_id` AS `cod_sheet_id`
    FROM
    `cargo`.`saimtech_order` `o`
            JOIN
            `cod_collection` `c` ON `c`.`order_id` = `o`.`order_id`
        JOIN
    `cod_sheet` `s` ON `s`.`cod_sheet_id` = `c`.`cod_sheet_id`
    WHERE
       `s`.`cod_sheet_id` = '" . $sheet_id . "'
            ORDER BY `c`.`created_at`;";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_discrepancy()
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`,
        FORMAT(`c`.`collection`, 2) AS `collection`,
        `c`.`created_at` AS `collection_date`,
        `s`.`cod_sheet_no` AS `cod_sheet_no`,
        `u`.`oper_user_name` AS `oper_user_name`,    
        FORMAT(`c`.`collection` - `o`.`cod_amount`, 2) AS `Difference`
    FROM
        `tmaccounts`.`cod_collection` `c`
            JOIN
        `cargo`.`saimtech_order` `o` ON `o`.`order_id` = `c`.`order_id`
        JOIN
        `tmaccounts`.`cod_sheet` `s` ON `s`.`cod_sheet_id` = `c`.`cod_sheet_id`
        JOIN
        `tmaccounts`.`acc_user` `u` ON `u`.`oper_user_id` = `s`.`user_id`
    WHERE
        `o`.`cod_amount` <> `c`.`collection`;";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_delivered_collection()
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`,
        FORMAT(`c`.`collection`, 2) AS `collection`,
        `c`.`created_at` AS `collection_date`,
        `s`.`cod_sheet_no` AS `cod_sheet_no`,
        `u`.`oper_user_name` AS `oper_user_name`,    
        FORMAT(`c`.`collection` - `o`.`cod_amount`, 2) AS `Difference`
    FROM
        `tmaccounts`.`cod_collection` `c`
            JOIN
        `cargo`.`saimtech_order` `o` ON `o`.`order_id` = `c`.`order_id`
        JOIN
        `tmaccounts`.`cod_sheet` `s` ON `s`.`cod_sheet_id` = `c`.`cod_sheet_id`
        JOIN
        `tmaccounts`.`acc_user` `u` ON `u`.`oper_user_id` = `s`.`user_id`
    WHERE
        `o`.`cod_amount` <> `c`.`collection`
        AND `o`.`order_status` in ('Deliverd','Delivered');";

        $res = $this->db->query($query);
        return $res->result();
    }

    public function get_undelivered_collection()
    {
        $query = "SELECT 
        `o`.`order_id` AS `order_id`,
        `o`.`order_code` AS `order_code`,
        `o`.`manual_cn` AS `manual_cn`,
        CAST(`o`.`order_date` AS DATE) AS `order_date`,
        CAST(`o`.`order_arrival_date` AS DATE) AS `order_arrival_date`,
        `o`.`order_status` AS `order_status`,
        `o`.`origin_city_name` AS `origin_city_name`,
        `o`.`shipper_name` AS `shipper_name`,
        `o`.`destination_city_name` AS `destination_city_name`,
        `o`.`destination_reporting` AS `destination_reporting`,
        `o`.`consignee_name` AS `consignee_name`,
        `o`.`consignee_mobile` AS `consignee_mobile`,
        `o`.`order_pay_mode` AS `order_pay_mode`,
        FORMAT(`o`.`weight`, 2) AS `weight`,
        `o`.`pieces` AS `pieces`,
        FORMAT(`o`.`cod_amount`, 2) AS `cod_amount`,
        `o`.`product_detail` AS `product_detail`,
        CAST(`o`.`on_route_date` AS DATE) AS `on_route_date`,
        `o`.`on_route_id` AS `on_route_id`        
    FROM
        `cargo`.`saimtech_order` `o` 
    WHERE
        `o`.`cod_amount` > 0
        AND `o`.`order_id` not in (SELECT order_id FROM cod_collection)
        AND DATE(`o`.`order_date`) >= '2022-03-01'
        AND `o`.`order_status` not in ('Order','Booking');";

        $res = $this->db->query($query);
        return $res->result();
    }
}
