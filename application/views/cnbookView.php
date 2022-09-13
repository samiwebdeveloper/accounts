<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
    .form-group-default .form-control {
        color: black;
    }

    #myDataTable tbody tr td {
        font-size: 28px;
        border-top: 1px solid black;
    }

    #myDataTable thead tr th {
        font-size: 14px;
        border-top: 1px solid black;
    }

    .nav-nav li a:hover {
        color: #fff !important;
        background-color: #6d5eac !important;
        border-color: #6d5eac !important;
        border-radius: 5px;
    }

    .nav-nav li .btncolor:hover {
        color: #fff !important;
        background-color: #6d5eac !important;
        border-color: #6d5eac !important;
        border-radius: 5px;
    }

    .btn-outline-light:hover {
        color: #fff !important;
        background-color: #6d5eac !important;
        border-color: #6d5eac !important;
        border-radius: 5px;
    }

    .btn-outline-light:focus {
        color: #fff !important;
        background-color: #6d5eac !important;
        border-color: #6d5eac !important;
        border-radius: 5px;
    }

    .nav-nav li .btncolor {
        color: #212529 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #6d5eac !important;
        border-radius: 5px;
        margin-left: 9px;
    }

    .color {
        color: #fff !important;
        background-color: #6d5eac !important;
        border-color: #6d5eac !important;
        border-radius: 5px;
    }

    .btn-outline-light {
        color: #212529;
        background-color: #f8f9fa;
        border: 1px solid #6d5eac;
        border-radius: 5px;
        margin-left: 9px;
    }

    .nav-nav li a {
        color: #212529 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #6d5eac !important;
        border-radius: 5px;
        margin-left: 9px;
    }

    .nav-tabs-fillup>li>a:after {
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        backface-visibility: hidden;
        background: none repeat scroll 0 0 #6d5eac;
        border: 1px solid #6d5eac;
    }

    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">CnBook</li>
                        <li class="breadcrumb-item">Manage CnBook</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class=" container-fluid   container-fixed-lg bg-gray">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#stockin"><i class="pg-plus_circle"></i> Stock In </button>
                        <button class="btn btn-primary " data-toggle="modal" data-target="#stockout"><i class="pg-minus_circle"></i>Book Issuance </button>
                        <button class="btn btn-primary " data-toggle="modal" data-target="#bookreissue"><i class="fa fa-share-square"></i>Book ReIssue </button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#stockmanag"><i class="pg-settings"></i> CN Management </button>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="table-responsive m-t-1">
                                            <div class="card-header  separator">
                                                <div class="card-title ">CN Book Summary </div>
                                            </div>
                                            <table id="myDataTable" class=" text-center table table-bordered compact nowrap " cellspacing="0" width="100%">
                                                <thead>
                                                    <th>Total CN Book</th>
                                                    <th>Issue CN Book</th>
                                                    <th>Remaining CN Book</th>
                                                </thead>
                                                <tbody style="border-top: 1px solid black;font-size: 20px !important;">
                                                    <?php if (!empty($cn_book_summary)) {
                                                        $total = 0;
                                                        $isissue = 0;
                                                        $notissue = 0;
                                                        foreach ($cn_book_summary as $rows) {
                                                            if ($rows->book_status == "Is Issued") {
                                                                $isissue = $rows->total;
                                                            }
                                                            if ($rows->book_status == "Not Issue") {
                                                                $notissue = $rows->total;
                                                            }
                                                            $total = $total + $rows->total;
                                                        }
                                                    }
                                                    echo ("<tr>");
                                                    echo ("<td>" . number_format($total) . "</td>");
                                                    echo ("<td>" . number_format($isissue) . "</td>");
                                                    echo ("<td>" . number_format($notissue) . "</td>");
                                                    echo ("</tr>");
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="table-responsive m-t-1">
                                            <div class="card-header  separator">
                                                <div class="card-title ">CNs Summary </div>
                                            </div>
                                            <table id="myDataTable" class=" text-center table table-bordered compact nowrap " cellspacing="0" width="100%">
                                                <thead>
                                                    <th>Total CN Issued</th>
                                                    <th>Total CN Reported</th>
                                                    <th>Available CN</th>
                                                </thead>
                                                <tbody style="border-top: 1px solid black;font-size: 20px !important;">
                                                    <?php if (!empty($cn_book_summary)) {
                                                        $total = 0;
                                                        $isissue = 0;
                                                        $notissue = 0;
                                                        foreach ($cn_summary as $cn) {
                                                            echo ("<tr>");
                                                            echo ("<td>" . number_format($cn->Total_Issued) . "</td>");
                                                            echo ("<td>" . number_format($cn->Total_Reported) . "</td>");
                                                            echo ("<td>" . number_format($cn->Available) . "</td>");
                                                            echo ("</tr>");
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END card -->
                        </div>
                    </div>
                    <!-- START card -->
                    <div class=" container-fluid   container-fixed-lg bg-gray">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card m-t-2">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="panel">
                                                <ul class="nav nav-tabs nav-tabs-fillup">
                                                    <li class="active"> <a data-toggle="tab" href="#maindashbord" class="active show" onclick="get_stock_record('stockin')" id="main">Book Stock In</a></li>
                                                    <li><a data-toggle="tab" href="#OriginCityWise" id="origin_city" onclick="get_stock_record('book_issuance')">Book Issuance Report</a></li>
                                                    <li><a data-toggle="tab" href="#reissue" onclick="get_stock_record('book_reissuance')">Book Re Issue Report</a></li>
                                                    <li> <a data-toggle="tab" href="#destinationCityWise" id="des_city" onclick="get_stock_record('book_manage')">Book Mangement Report</a></li>
                                                    <li> <a data-toggle="tab" href="#missingcns" id="des_city" onclick="get_stock_record('missing')">Missing CNs Report</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane slide-right active" id="maindashbord">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <table id="stockin" style="border-top: 1px solid black;" class="table tbl_js table-bordered compact nowrap dataTable no-footer">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Series Range</th>
                                                                        <th>Total CN</th>
                                                                        <th>Book Status</th>
                                                                        <th>Date&Time</th>
                                                                        <th>Created By</th>
                                                                    </thead>
                                                                    <!-- <tbody id="autoload">
                                                                        <?php if (!empty($cn_book_instock)) {
                                                                            $i = 1;
                                                                            foreach ($cn_book_instock as $rows) {
                                                                                echo ("<tr>");
                                                                                echo ("<td>" . $i . "</td>");
                                                                                echo ("<td>" . $rows->book_code . "</td>");
                                                                                echo ("<td>" . $rows->book_cn_count . "</td>");
                                                                                echo ("<td>" . $rows->book_status . "</td>");
                                                                                echo ("<td>" . date('d-M-Y', strtotime($rows->created_date)) . "</td>");
                                                                                echo ("<td>" . $rows->oper_user_name . "</td>");
                                                                                echo ("</tr>");
                                                                                $i = $i + 1;
                                                                            }
                                                                        }  ?>
                                                                    </tbody> -->
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane slide-left" id="OriginCityWise">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <?php if ($_SESSION['is_supervisor'] == 1) { ?>
                                                                    <table id="book_issuance" style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" width="100%">
                                                                        <thead>
                                                                            <th>Sr #</th>
                                                                            <th>Series Range</th>
                                                                            <th>Total Cn</th>
                                                                            <th>available</th>
                                                                            <th>Date&Time</th>
                                                                            <th>Rider</th>
                                                                            <th>Route</th>
                                                                            <th>Issue By</th>
                                                                            <th style="display:none ;">Issue By</th>
                                                                            <th width=4%>Edit</th>
                                                                            <th width=4%>Detail</th>
                                                                        </thead>
                                                                        <tbody id="autoload">
                                                                            <?php if (!empty($cn_issuance)) {
                                                                                $i = 0;

                                                                                foreach ($cn_issuance as $rows) {
                                                                                    $get_toal_cn = [];
                                                                                    $get_toal_cn = explode('-', $rows->book_code);
                                                                                    $i = $i + 1;
                                                                                    echo ("<tr>");
                                                                                    echo ("<td>" . $i  . "</td>");
                                                                                    echo ("<td class='cn_range'>" . $rows->book_code . "</td>");
                                                                                    echo ("<td>" . ($get_toal_cn[1] - $get_toal_cn[0] + 1) . "</td>");
                                                                                    echo ("<td>" . $rows->Remaining . "</td>");
                                                                                    echo ("<td>" . date('d-M-Y', strtotime($rows->issue_date)) . "</td>");
                                                                                    echo ("<td class='edit_dc'>" . $rows->rider_name . "</td>");
                                                                                    echo ("<td>" . $rows->route_name . "</td>");
                                                                                    echo ("<td>" . $rows->oper_user_name . "</td>");
                                                                                    echo ("<td hidden class='row_id'>" . $rows->cn_id . "</td>");
                                                                                    echo '<td class="text-center " data-toggle="modal" data-target="#edit"><button class="edit_btn btn btn-success btn-xs"><i class="fa fa-edit"></i></button></td>';
                                                                                    echo '<td class="text-center "><button class="view_btn btn btn-info btn-xs"><i class="fa fa-eye"></i></button></td>';
                                                                                    echo ("</tr>");
                                                                                }
                                                                            }  ?>
                                                                        </tbody>
                                                                    </table>
                                                                <?php } else { ?>
                                                                    <table id="book_issuance" style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer">
                                                                        <thead>
                                                                            <th>Sr#</th>
                                                                            <th>Series Range</th>
                                                                            <th>Date&Time</th>
                                                                            <th>Rider</th>
                                                                            <th>Route</th>
                                                                            <th>Issue By</th>
                                                                        </thead>
                                                                        <tbody id="autoload">
                                                                            <?php if (!empty($cn_issuance)) {
                                                                                $i = 0;
                                                                                foreach ($cn_issuance as $rows) {
                                                                                    $i = $i + 1;
                                                                                    echo ("<tr>");
                                                                                    echo ("<td>" . $i . "</td>");
                                                                                    echo ("<td>" . $rows->book_code . "</td>");
                                                                                    echo ("<td>" . date('d-M-Y', strtotime($rows->issue_date)) . "</td>");
                                                                                    echo ("<td>" . $rows->rider_name . "</td>");
                                                                                    echo ("<td>" . $rows->route_name . "</td>");
                                                                                    echo ("<td>" . $rows->oper_user_name . "</td>");
                                                                                    echo ("</tr>");
                                                                                }
                                                                            }  ?>
                                                                        </tbody>
                                                                    </table>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane slide-left" id="destinationCityWise">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <table id="book_manage" style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Series Range</th>
                                                                        <th>Cn No</th>
                                                                        <th>Date&Time</th>
                                                                        <th>Rider</th>
                                                                        <th>Route</th>
                                                                        <th>CN Status</th>
                                                                    </thead>
                                                                    <tbody id="">
                                                                        <?php if (!empty($cn_usage)) {
                                                                            $i = 0;
                                                                            foreach ($cn_usage as $rowss) {
                                                                                $i = $i + 1;
                                                                                echo ("<tr>");
                                                                                echo ("<td>" . $i . "</td>");
                                                                                echo ("<td>" . $rowss->book_code . "</td>");
                                                                                echo ("<td>" . $rowss->cn_no . "</td>");
                                                                                echo ("<td>" . date('d-M-Y', strtotime($rowss->cn_datetime)) . "</td>");
                                                                                echo ("<td>" . $rowss->rider_name . "</td>");
                                                                                echo ("<td>" . $rowss->route_name . "</td>");
                                                                                echo ("<td>" . $rowss->cn_status . "</td>");
                                                                                echo ("</tr>");
                                                                            }
                                                                        }  ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane slide-left" id="reissue">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <table id="book_reissuance" style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Book Range</th>
                                                                        <th>Total CN</th>
                                                                        <th>Reason</th>
                                                                        <th>Rider</th>
                                                                        <th>Route</th>
                                                                        <th>Date</th>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane slide-left" id="missingcns">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <table id="missing" style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable_m no-footer">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Book Range</th>
                                                                        <th>Total CN</th>
                                                                        <th>Missing CN</th>
                                                                        <th>book status</th>
                                                                        <th>issue date</th>
                                                                        <th>Rider</th>
                                                                        <th>Created By</th>
                                                                    </thead>
                                                                    <tbody id="">
                                                                        <?php if (!empty($cn_missing)) {
                                                                            $i = 0;
                                                                            foreach ($cn_missing as $rowss) {
                                                                                $b_count = explode('-', $rowss->book_code);
                                                                                $i = $i + 1;
                                                                                $total = $rowss->end_cn - $rowss->start_cn;
                                                                                echo ("<tr>");
                                                                                echo ("<td>" . $i . "</td>");
                                                                                echo ("<td>" . $rowss->book_code . "</td>");
                                                                                echo ("<td>" . ($b_count[1] - $b_count[0] + 1)  . "</td>");
                                                                                echo ("<td>" . $rowss->manual_cn . "</td>");
                                                                                echo ("<td>" . $rowss->book_status . "</td>");
                                                                                echo ("<td>" . $rowss->issue_date . "</td>");
                                                                                echo ("<td>" . $rowss->rider_name . "</td>");
                                                                                echo ("<td>" . $rowss->oper_user_name . "</td>");
                                                                                echo ("</tr>");
                                                                            }
                                                                        }  ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END card -->
                        </div>
                    </div>
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
                <!-- END CONTAINER FLUID -->
            </div>
            <!-- END PAGE CONTENT -->
            <!-- The Modal -->
            <div class="modal" id="edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Edit CN Book Issuance </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p id="msg_show"></p>
                            <div class="form-group-attached" style="border-color: black">
                                <div class="row" id="editerror">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default ">
                                            <label>Select Rider</label>
                                            <span class="ridererror" style="color:red ;"></span>
                                            <select class="form-control" id="edit_rider" tabindex=2 style="width:100% !important ;">
                                                <option value="0" selected>Select Rider</option>
                                                <?php
                                                foreach ($result_rider as $row) {
                                                    echo " <option value='" . $row['rider_id'] . "'>" . $row['rider_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default ">
                                            <label>Select Route</label>
                                            <span class="routeerror" style="color:red ;"></span>
                                            <select class="form-control" id="edit_route" ntabindex=4 style="width:100% !important ;">
                                                <option value="0" selected>Select Route</option>
                                                <?php
                                                foreach ($result_route as $row) {
                                                    echo " <option value='" . $row['route_id'] . "'>" . $row['route_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="issuance_data_edit">Save</button>
                            <button type="button" class="btn btn-default " data-dismiss="modal" type="submit">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal show" id="stockin">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">CN Book Stock In</h4>
                            <button type="button" class="close load_data" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p id="msg_show"></p>
                            <span class="checkerror" style="color:red ;"></span>
                            <div class="form-group-attached" style="border-color: black">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required" aria-required="true" id="route_code_div">
                                            <label>Book Start CN</label>
                                            <input type="number" class="form-control" placeholder="Start CN Number" name="seriesfrom" id="seriesfrom">
                                            <span class="sfromerror" style="color:red ;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required" aria-required="true" id="route_code_div">
                                            <label>Book End CN</label>
                                            <input type="number" class="form-control" placeholder="End CN Number" name="seriesto" id="seriesto">
                                            <span class="stoerror" style="color:red ;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-default required">
                                    <label>Issuance DateTime</label>
                                    <input type="datetime-local" class="form-control" name="datetime" id="datetime" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                    <span class="dateerror" style="color:red ;"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="create_cn">Save</button>
                            <button type="button" class="btn btn-default load_data" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="stockmanag">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">CN Book Stock Management</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p id="msg"></p>
                            <p id="msg_show"></p>
                            <span class="checkerror" style="color:red ;"></span>
                            <div class="form-group-attached" style="border-color: black">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required" aria-required="true" id="route_code_div">
                                            <label> CN #</label>
                                            <span class="mantoerror" style="color:red ;"></span>
                                            <input type="number" class="form-control" placeholder=" Enter CN Number" name="seriesfrom" id="missingcn">
                                            <span class="sfromerror" style="color:red ;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required">
                                            <label>CN Status</label>
                                            <span class="manstoerror" style="color:red ;"></span>
                                            <span class="cnerror" style="color:red ;"></span>
                                            <select class="form-control" id="cnstatus" tabindex=2 style="width:100% !important ;">
                                                <option value='0' selected disabled>Select Status </option>
                                                <option value='Cancelled'>Cancelled</option>
                                                <option value='Void'>Void</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-default required">
                                    <label>Detail</label>
                                    <textarea id="mang_des" name="mang_des" class="form-control " style=" height:100px;min-height:100px; max-height:150px;"></textarea>
                                </div>
                                <div class="form-group form-group-default required">
                                    <label>DateTime</label>
                                    <span class="mandateerror" style="color:red ;"></span>
                                    <input type="datetime-local" class="form-control" name="datetime_manag" id="datetime_manag" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                    <span class="dateerror" style="color:red ;"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="manag_cn">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="stockout">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">CN Book Issuance </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p id="msg_show"></p>
                            <div class="form-group-attached" style="border-color: black">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required">
                                            <label>Select Rider</label>
                                            <span class="ridererror" style="color:red ;"></span>
                                            <select class="form-control" id="Select_rider" tabindex=2 style="width:100% !important ;">
                                                <option value="0" selected id="append_rider">Select Rider</option>
                                                <?php
                                                foreach ($result_rider as $row) {
                                                    echo " <option value='" . $row['rider_id'] . "'>" . $row['rider_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required">
                                            <label>Select CN Book</label>
                                            <span class="cnerror" style="color:red ;"></span>
                                            <select class="form-control" id="cn_book" multiple tabindex=2 style="width:100% !important ;">
                                                <!-- <option value='0' selected>Select CN </option> -->
                                                <?php foreach ($cn_range as $cn_range) { ?>
                                                    <option value=<?php echo $cn_range->book_id; ?>><?php echo  $cn_range->book_code; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group form-group-default ">
                                        <div class="table-responsive m-t-1">
                                            <table id="add_book_detail" class=" text-center table table-bordered compact nowrap " cellspacing="0" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-default required">
                                    <label>Select Route</label>
                                    <span class="routeerror" style="color:red ;"></span>
                                    <select class="form-control" id="Select_route" tabindex=4 style="width:100% !important ;">
                                        <option value="0" selected id="append_route">Select Route</option>
                                        <?php
                                        foreach ($result_route as $row) {
                                            echo " <option value='" . $row['route_id'] . "'>" . $row['route_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <textarea name="" hidden id="narration" class="form-control" style="height:50px ;"></textarea>
                                <div class="form-group form-group-default required">
                                    <label>Date Time</label>
                                    <span class="datetimeerror" style="color:red ;"></span>
                                    <input type="datetime-local" class="form-control" name="datetime_issuance" id="datetime_issuance" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="issuance_data">Save</button>
                            <button type="button" class="btn btn-default " data-dismiss="modal" type="submit">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="bookreissue">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">CN Book ReIssue </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p id="reissue_msg"></p>
                            <form action="">
                                <div class="form-group-attached" style="border-color: black">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-group-default required">
                                                <label>Select CN Book</label>
                                                <span class="is_book" style="color:red ;"></span>
                                                <select class="form-control" id="is_book" tabindex=2 style="width:100% !important ;">
                                                    <option value='0' selected>Select CN </option>
                                                    <?php foreach ($issue_book as $issue_book) { ?>
                                                        <option value=<?php echo $issue_book->book_id; ?>><?php echo  $issue_book->book_code; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label>Start CN Book</label>
                                                <span class="is_start" style="color:red ;"></span>
                                                <input type="number" class="form-control" name="is_start" id="is_start" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label>End CN Book</label>
                                                <span class="is_start" style="color:red ;"></span>
                                                <input type="number" class="form-control" disabled name="is_end" id="is_end" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label>Select Rider</label>
                                                <span class="ridererror" style="color:red ;"></span>
                                                <select class="form-control" id="is_rider" tabindex=2 style="width:100% !important ;">
                                                    <option value="0" selected id="append_rider">Select Rider</option>
                                                    <?php
                                                    foreach ($result_rider as $row) {
                                                        echo " <option value='" . $row['rider_id'] . "'>" . $row['rider_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label>Select Route</label>
                                                <span class="routeerror" style="color:red ;"></span>
                                                <select class="form-control" id="is_route" tabindex=4 style="width:100% !important ;">
                                                    <option value="0" selected id="append_route">Select Route</option>
                                                    <?php
                                                    foreach ($result_route as $row) {
                                                        echo " <option value='" . $row['route_id'] . "'>" . $row['route_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="is_des" style="color:red ;"></span>
                                        <div class="form-group form-group-default required">
                                            <label>Reason</label>
                                            <textarea id="is_des" name="is_des" class="form-control " style=" height:50px;min-height:30px; max-height:150px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Date Time</label>
                                        <span class="datetimeerror" style="color:red ;"></span>
                                        <input type="datetime-local" class="form-control" name="datetime_issuance" id="is_date" value="<?php echo date('Y-m-d\TH:i') ?>" tabindex="2">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="reissue_data">Save</button>
                            <button type="button" class="btn btn-default " data-dismiss="modal" type="submit">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->load->view('inc/footer');
    ?>

    <script>
        function get_stock_record(param) {
            $.ajax({
                url: "<?php echo base_url() ?>CnBook/select_cn_func/" + param + "",
                method: "POST",
                success: function(data) {
                    var js_obj = JSON.parse(data)
                    var data_arr = [];
                    var data_arr_key = [];
                    var data="data";
                    for (var count = 0; count < js_obj.length; count++) {
                        var a = [];
                        var str = "";
                        const obj = {}
                        const obj_key = {}
                        $.each(js_obj[count], function(key, val) {
                            obj[key] = val
                            obj_key["data"] = key
                         
                        });
                        data_arr.push(obj)
                        data_arr_key.push(obj_key)
                       
                    }
                    data_array(data_arr, param,data_arr_key)

                }
            });
        }

        function data_array(get_array, param,data_arr_key) {
            var id = "#" + param;
            var columns;
            console.log(id);
            console.log(data_arr_key);
            $(id).DataTable().destroy();

            var jsonString = JSON.stringify(get_array  ) ;
            console.log(jsonString);
            table = $(id).DataTable({
            //     data : jsonString.book_code,
            //   columns : jsonString.book_code,
                lengthMenu: [
                    [25, 50, -1],
                    [25, 50, "All"]
                ],
                dom: 'Blfrtip',
                buttons: ['colvis'],
                data: get_array,
                order: [],
                columns: [
                    
                    {
                    	data: "book_code"
                    },
                    {
                    	data: "book_id"
                    },
                    {
                    	data: "created_at"
                    },
                    {
                    	data: "created_by"
                    },
                    {
                    	data: "date"
                    },
                    {
                    	data: "end_cn"
                    },
                    {
                    	data: "oper_user_name"
                    }
                ],
            });
            // console.log(columns);


        }
    </script>