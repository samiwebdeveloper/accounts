<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CnBook extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CnBookModel');
        $this->load->model('Commonmodel');
    }
    
    // fetch_cn book detail
    public function get_book_by_rider()
    {
        $rider = $_POST['rider'];
        $data  = $this->CnBookModel->get_book_by_rider($rider);
        if ($data[0]->Total_Issued != 0) {
            echo "<thead style='border-top:1px solid gray;'><th>Total Issued</th><th>Total Reported</th><th>Available</th></thead>";
            foreach ($data as  $value) {
                echo "<tbody ><tr><td>$value->Total_Issued</td><td>$value->Total_Reported</td><td>$value->Available</td></tr></tbody>";
            }
        }
    }
    public function total_cn()
    {
        $book_code = $this->uri->segment(3);
        $data['detail']  = $this->CnBookModel->total_cn_range($book_code);
        $this->load->view('cs_book_detail_view', $data);
    }
    public function ExportFile($records)
    {
        $heading = false;
        if (!empty($records))
            foreach ($records as $row) {
                if (!$heading) {
                    echo implode("\t", array_keys($row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values($row)) . "\n";
            }
            // exit;k
    }
    public function convert_array_to_excel()
    {
        $raw_query = $this->Commonmodel->Raw_Query_Execution('select * from acc_orders limit 0,50000');
        $filename = "cn_boook_record_" . date('Y-m-d') . ".xls";
        header("Content-Type: application/vnd.ms-xls");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        CnBook::ExportFile($raw_query);
    }

    public function default_load()
    {
        // $cn_boook_record['cn_range']          = $this->CnBookModel->fetch_cn_book_range('cn_book', $_SESSION['origin_id']);
        // $cn_boook_record['issue_book']        = $this->CnBookModel->issue_book('cn_book', $_SESSION['origin_id']);
        // $cn_boook_record['cn_issuance']       = $this->CnBookModel->cn_issuance($_SESSION['origin_id']);
        // $cn_boook_record['cn_reissue']        = $this->CnBookModel->cn_reissue($_SESSION['origin_id']);
        // $cn_boook_record['cn_book_summary']   = $this->CnBookModel->cn_book_summary($_SESSION['origin_id']);
        // $cn_boook_record['cn_summary']        = $this->CnBookModel->cn_summary($_SESSION['origin_id']);
        // $cn_boook_record['cn_book_instock']   = $this->CnBookModel->cn_book_instock($_SESSION['origin_id']);
        // $cn_boook_record['cn_usage']          = $this->CnBookModel->cn_usage($_SESSION['origin_id']);
        // $cn_boook_record['cn_missing']        = $this->CnBookModel->cn_missing($_SESSION['origin_id']);
        // // $cn_boook_record['result_rider']      = $this->CnBookModel->display_rider();
        // $cn_boook_record['result_route']      = $this->CnBookModel->display_route();
        
        $this->load->view('cnbookView');
    }

     public function select_cn_func($param=0)
    {
        if ($param == "stockin") {
            $cn_boook_record = $this->CnBookModel->cn_book_instock($_SESSION['origin_id']); 
        echo  json_encode($cn_boook_record);
        }
        if ($param == "book_issuance") {
            $cn_boook_record = $this->CnBookModel->issue_book('cn_book', $_SESSION['origin_id']);
        echo json_encode($cn_boook_record);
        }
        if ($param == "book_reissuance") {
            $cn_boook_record = $this->CnBookModel->cn_reissue($_SESSION['origin_id']);
        echo json_encode($cn_boook_record);
        }
        if ($param == "book_manage") {
            $cn_boook_record   = $this->CnBookModel->cn_usage($_SESSION['origin_id']);
        echo json_encode($cn_boook_record);
        }
        if ($param == "missing") {
            $cn_boook_record   = $this->CnBookModel->cn_missing($_SESSION['origin_id']);
        echo json_encode($cn_boook_record);
        }
       
    }

    public function insert_cn()
    {
        if ($_POST["action"] == 'fetch') {
            $this->form_validation->set_rules('seriesfrom', 'Start CN ', 'required|is_unique[cn_book.book_start_cn]');
            $this->form_validation->set_rules('seriesto', 'Start CN ', 'required|is_unique[cn_book.book_end_cn]');
            if ($this->form_validation->run() != true) {
                echo '<div class="  col-md-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button>
                      <strong>Alert!: </strong>Book CN Number is already existed.</div>';
            } else {
                $start = $_POST["seriesfrom"];
                $end = $_POST["seriesto"];
                $loop_count = $end - ($start - 1);
                for ($i = 1; $i <= $loop_count / 50; $i++) {
                    $from = $start;
                    $db_end = $start = $start + 49;
                    $datainsert = array(
                        'book_start_cn'     => $from,
                        'book_end_cn'       => $db_end,
                        'book_code'         =>  $from . "-" . $db_end,
                        'book_cn_count'     =>  $db_end - $from + 1,
                        'book_origin'       =>  $_SESSION['origin_id'],
                        'book_status'       => "Not Issue",
                        'created_by'        => $_SESSION['user_id'],
                        'created_date'      => $_POST["datetime"],
                        'modified_by'       => 'Null',
                        'modified_date'     => '0000-00-00 00:00:00'
                    );
                    $book_id =  $this->CnBookModel->Insert_record('cn_book', $datainsert);
                    $this->CnBookModel->Insert_cn_usage($from, $db_end, $book_id);
                    $start = $start + 1;
                }
                echo '<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button>
                      <strong>Successfully!: </strong>Record has been saved.</div>';
            }
        }
    }
    public function insert_issuance()
    {

        if ($_POST["action"] == 'fetch') {
            foreach ($_POST["cn_book"] as $item) {
                $datainsert = array(
                    'book_id'    => $item,
                    'issue_date' => $_POST["datetime_issuance"],
                    'issue_to'   => $_POST["rider"],
                    'route'      => $_POST['route'],
                    'created_by' => $_SESSION['user_id'],
                    'origin_id' => $_SESSION['origin_id'],
                    'type' => "New Issue"
                );
                $this->CnBookModel->Insert_record('cn_issue', $datainsert);
                $this->CnBookModel->Update_record($item);
            }
        }
    }
    public function manage_cn()
    {
        if ($_POST["action"] == 'fetch') {
            $book_id = $this->CnBookModel->get_book_id($_POST["missingcn"]);
            $datainsert = array(
                'cn_no'         => $_POST["missingcn"],
                'cn_status'     => $_POST["cnstatus"],
                'cn_detail'      => $_POST["mang_des"],
                'cn_datetime'   => $_POST["datetime_manag"],
                'created_by'    => $_SESSION['user_id'],
                'origin_id' => $_SESSION['origin_id'],
                'book_id' =>  $book_id[0]->book_id,
            );
            $this->CnBookModel->Insert_record('cn_status', $datainsert);
            echo '<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button>
                  <strong>Successfully!: </strong>Record has been saved.</div>';
        }
    }
    public function insert_reissue_data()
    {
        // update previuos book 
        $book_id = $_POST["issue_book"];
        $book_start_cn = $this->CnBookModel->get_book_start_cn($_POST["is_start"]);
        $dataupdate = array(
            'book_start_cn'     => $book_start_cn[0]->book_start_cn,
            'book_end_cn'       => $_POST["is_start"] - 1,
            'book_code'         => $book_start_cn[0]->book_start_cn . "-" . ($_POST["is_start"] - 1),
            'book_cn_count'     => ($_POST["is_start"] - 1) - $book_start_cn[0]->book_start_cn + 1,
            'modified_by'       => $_SESSION['user_id'],
            'modified_date'     => date("Y-m-d H:i:s")
        );
        $this->CnBookModel->Update_records('cn_book', 'book_id', $book_id, $dataupdate);
        // insert new remaning cn book 
        $datainsert = array(
            'book_start_cn'     => $_POST["is_start"],
            'book_end_cn'       => $_POST["is_end"],
            'book_code'         => $_POST["is_start"] . "-" . $_POST["is_end"],
            'book_cn_count'     => $_POST["is_end"] - $_POST["is_start"] + 1,
            'book_origin'       => $_SESSION['origin_id'],
            'book_status'       =>  "Is Issued",
            'created_by'        => $_SESSION['user_id'],
            'created_date'      => date("Y-m-d H:i:s"),
            'modified_by'       => 'Null',
            'modified_date'     => '0000-00-00 00:00:00'
        );
        $book_id_new =  $this->CnBookModel->Insert_record('cn_book', $datainsert);
        // create issuance 
        $datainsert = array(
            'book_id'    => $book_id_new,
            'issue_date' => $_POST["is_date"],
            'issue_to'   => $_POST["is_rider"],
            'route'      => $_POST['is_route'],
            'created_by' => $_SESSION['user_id'],
            'origin_id'  =>  $_SESSION['origin_id'],
            'type' => "Reissue"
        );
        $this->CnBookModel->Insert_record('cn_issue', $datainsert);
        // insert reissue
        $data = array(
            'book_id'      => $_POST["issue_book"],
            'start_cn'     => $_POST["is_start"],
            'end_cn'       => $_POST["is_end"],
            'rider'        => $_POST["is_rider"],
            'route'        => $_POST["is_route"],
            'reason'       => $_POST['is_des'],
            'date'         => $_POST['is_date'],
            'created_by'   => $_SESSION['user_id']
        );
        $this->CnBookModel->Insert_record('cn_reissue', $data);
        // update cn usage accoriding to new book
        $this->CnBookModel->Update_cn_usage($book_id_new, $book_id, ($_POST["is_start"] - 1));
    }
    public function edit()
    {
        $row_id = $_POST["row_id"];
        $edit_rider = $_POST["edit_rider"];
        $edit_route = $_POST["edit_route"];
        $modified_by = $_SESSION['user_id'];
        $this->CnBookModel->update_issuance($row_id, $edit_rider, $edit_route, $modified_by);
    }
}
