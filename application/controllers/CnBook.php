<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CnBook extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('CnBookModel');
    }


    public function default_load()
    {
        $cn_boook_record['cn_range']          = $this->CnBookModel->fetch_cn_book_range('saimtech_book',$_SESSION['origin_id']);
        $cn_boook_record['issue_book']        = $this->CnBookModel->issue_book('saimtech_book',$_SESSION['origin_id']);
        $cn_boook_record['cn_issuance']       = $this->CnBookModel->cn_issuance('saimtech_book',$_SESSION['origin_id']);
        $cn_boook_record['cn_reissue']        = $this->CnBookModel->cn_reissue($_SESSION['origin_id']);
        $cn_boook_record['cn_book_summary']   = $this->CnBookModel->cn_book_summary($_SESSION['origin_id']);
        $cn_boook_record['cn_book_instock']   = $this->CnBookModel->cn_book_instock($_SESSION['origin_id']);
        $cn_boook_record['cn_usage']          = $this->CnBookModel->cn_usage($_SESSION['origin_id']);
        $cn_boook_record['result_rider']      = $this->CnBookModel->display_rider();
        $cn_boook_record['result_route']      = $this->CnBookModel->display_route();

        $this->load->view('cnbookView', $cn_boook_record);
    }


    public function insert_cn()
    {
        if ($_POST["action"] == 'fetch') {
            $this->form_validation->set_rules('seriesfrom', 'Start CN ', 'required|is_unique[saimtech_book.book_start_cn]');
            $this->form_validation->set_rules('seriesto', 'Start CN ', 'required|is_unique[saimtech_book.book_end_cn]');
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
                        'modified_by'       => '0000-00-00 00:00:00',
                        'modified_date'     => '0000-00-00 00:00:00'
                    );
                    $this->CnBookModel->Insert_record('saimtech_book', $datainsert);
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
            $datainsert = array(
                'book_id'    => $_POST["cn_book"],
                'issue_date' => $_POST["datetime_issuance"],
                'issue_to'   => $_POST["rider"],
                'route'      => $_POST['route'],
                'created_by' => $_SESSION['user_id'],
                'origin_id' => $_SESSION['origin_id']
            );
            $this->CnBookModel->Insert_record('saimtech_cn_issue', $datainsert);
            $this->CnBookModel->Update_record($_POST["cn_book"]);
        }
    }
    public function manage_cn()
    {
        if ($_POST["action"] == 'fetch') {
            $datainsert = array(
                'cn_no'         => $_POST["missingcn"],
                'cn_status'     => $_POST["cnstatus"],
                'cn_detail'      => $_POST["mang_des"],
                'cn_datetime'   => $_POST["datetime_manag"],
                'created_by'    => $_SESSION['user_id'],
                'origin_id' => $_SESSION['origin_id']
            );
            $this->CnBookModel->Insert_record('tbl_cn_management', $datainsert);
            echo '<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button>
            <strong>Successfully!: </strong>Record has been saved.</div>';
        }
    }

    public function insert_reissue_data()
    {
       
        if ($_POST["action"] == 'fetch') {
            $datainsert = array(
                'book_id'      => $_POST["issue_book"],
                'start_cn'     => $_POST["is_start"],
                'end_cn'       => $_POST["is_end"],
                'rider'        => $_POST["is_rider"],
                'route'        => $_POST["is_route"],
                'reason'       => $_POST['is_des'],
                'date'         => $_POST['is_date'],
                'created_by'   => $_SESSION['user_id']
            );
            $this->CnBookModel->Insert_record('saimtech_cn_reissue', $datainsert);
        }
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
