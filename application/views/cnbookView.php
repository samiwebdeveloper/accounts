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
                            <div class="col-md-7">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="table-responsive m-t-1">
                                            <div class="card-header  separator">
                                                <div class="card-title ">CN Book Summary </div>
                                            </div>
                                            <table id="myDataTable" class=" text-center table table-bordered compact nowrap table-hover" cellspacing="0" width="100%">
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
                                                    echo ("<td>" . $total . "</td>");
                                                    echo ("<td>" . $isissue  . "</td>");
                                                    echo ("<td>" . $notissue . "</td>");
                                                    echo ("</tr>");
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
                                                    <li class="active"> <a data-toggle="tab" href="#maindashbord" class="active show" id="main">Book Stock In</a></li>
                                                    <li><a data-toggle="tab" href="#OriginCityWise" id="origin_city">Book Issuance Report</a></li>
                                                    <li><a data-toggle="tab" href="#reissue" >Book Re Issue Report</a></li>
                                                    <li> <a data-toggle="tab" href="#destinationCityWise" id="des_city">Book Mangement Report</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane slide-right active" id="maindashbord">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <table style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" id="myTable">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Series Range</th>
                                                                        <th>Total CN</th>
                                                                        <th>Book Status</th>
                                                                        <th>Date&Time</th>
                                                                        <th>Created By</th>
                                                                    </thead>
                                                                    <tbody id="autoload">
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
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane slide-left" id="OriginCityWise">
                                                        <div class="row">
                                                            <div class="table-responsive m-t-2">
                                                                <?php if ($_SESSION['is_supervisor'] == 1) { ?>
                                                                    <table style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" width="100%" id="myTable">
                                                                        <thead>
                                                                            <th>Sr #</th>
                                                                            <th>Series Range</th>
                                                                            <th>Date&Time</th>
                                                                            <th>Rider</th>
                                                                            <th>Route</th>
                                                                            <th>Issue By</th>
                                                                            <th style="display:none ;">Issue By</th>
                                                                            <th width=4%>Edit</th>

                                                                        </thead>
                                                                        <tbody id="autoload">
                                                                            <?php if (!empty($cn_issuance)) {
                                                                                $i = 0;
                                                                                foreach ($cn_issuance as $rows) {
                                                                                    $i = $i + 1;
                                                                                    echo ("<tr>");
                                                                                    echo ("<td>" . $i  . "</td>");
                                                                                    echo ("<td>" . $rows->book_code . "</td>");
                                                                                    echo ("<td>" . date('d-M-Y', strtotime($rows->issue_date)) . "</td>");
                                                                                    echo ("<td class='edit_dc'>" . $rows->rider_name . "</td>");
                                                                                    echo ("<td>" . $rows->route_name . "</td>");
                                                                                    echo ("<td>" . $rows->oper_user_name . "</td>");
                                                                                    echo ("<td hidden class='row_id'>" . $rows->cn_id . "</td>");
                                                                                    echo '<td class="text-center " data-toggle="modal" data-target="#edit"><button class="edit_btn btn btn-success btn-xs"><i class="fa fa-edit"></i></button></td>';
                                                                                    echo ("</tr>");
                                                                                }
                                                                            }  ?>
                                                                        </tbody>
                                                                    </table>
                                                                <?php } else { ?>
                                                                    <table style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" id="myTable">
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
                                                                <table style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" id="myTable">
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
                                                                <table style="border-top: 1px solid black;" class="table table-bordered compact nowrap dataTable no-footer" id="myTable">
                                                                    <thead>
                                                                        <th>Sr #</th>
                                                                        <th>Book Range</th>
                                                                        <th>Total CN</th>
                                                                        <th>Reason</th>
                                                                        <th>Rider</th>
                                                                        <th>Route</th>
                                                                        <th>Date</th>
                                                                        <th>Created By</th>
                                                                    </thead>
                                                                    <tbody id="">
                                                                        <?php if (!empty($cn_reissue)) {
                                                                            $i = 0;
                                                                            foreach ($cn_reissue as $rowss) {
                                                                                $i = $i + 1;
                                                                             $total= $rowss->end_cn-$rowss->start_cn;
                                                                                echo ("<tr>");
                                                                                echo ("<td>" . $i . "</td>");
                                                                                echo ("<td>" . $rowss->start_cn."-". $rowss->end_cn . "</td>");
                                                                                echo ("<td>" .$total . "</td>");
                                                                                
                                                                                echo ("<td>" . $rowss->reason . "</td>");
                                                                                echo ("<td>" . $rowss->rider_name . "</td>");
                                                                                echo ("<td>" . $rowss->route_name . "</td>");
                                                                                echo ("<td>" . date('d-M-Y', strtotime($rowss->date)) . "</td>");
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
                            <p id="msg_show">Stock In</p>
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
                            <p id="msg">Stock In</p>

                            <p id="msg_show">Stock Management</p>
                            <span class="checkerror" style="color:red ;"></span>
                            <div class="form-group-attached" style="border-color: black">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required" aria-required="true" id="route_code_div">
                                            <label>Missing CN #</label>
                                            <span class="mantoerror" style="color:red ;"></span>
                                            <input type="number" class="form-control" placeholder=" Missing CN Number" name="seriesfrom" id="missingcn">
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
                                            <label>Select CN Book</label>
                                            <span class="cnerror" style="color:red ;"></span>
                                            <select class="form-control" id="cn_book" tabindex=2 style="width:100% !important ;">
                                                <option value='0' selected>Select CN </option>
                                                <?php foreach ($cn_range as $cn_range) { ?>
                                                    <option value=<?php echo $cn_range->book_id; ?>><?php echo  $cn_range->book_code; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
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
        $(".edit_btn").click(function() {
            var $row = $(this).closest("tr");
            $('#issuance_data_edit').on("click", function(event) {
                var row_id = $row.find(".row_id").html();
                var edit_rider = $("#edit_rider :selected").val();
                var edit_route = $("#edit_route :selected").val();
                var chk = 0;
                var ajaxurl = "";
                var mydata = {};

                if (edit_route != 0 || edit_rider == 0) {
                    mydata = {
                        row_id: row_id,
                        edit_rider: 0,
                        edit_route: edit_route,
                    };
                    chk = 1;
                }
                if (edit_route == 0 || edit_rider != 0) {
                    mydata = {
                        row_id: row_id,
                        edit_rider: edit_rider,
                        edit_route: 0,
                    };
                    chk = 1;
                }
                if (edit_route != 0 || edit_rider != 0) {
                    mydata = {
                        row_id: row_id,
                        edit_rider: edit_rider,
                        edit_route: edit_route,
                    };
                    chk = 1;
                }

                if (chk == 1) {
                    if (edit_route == 0 && edit_rider == 0) {
                        $('#editerror').before('<div class="  col-md-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong>One field is required.</div>')
                    } else {
                        console.log(mydata);
                        $.ajax({
                            url: "edit",
                            type: "POST",
                            data: mydata,
                            success: function(data) {
                                location.reload();
                            },
                        });
                    }


                }

            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#cn_book').select2();
            $('#Select_rider').select2();
            $('#Select_route').select2();
            $('#is_rider').select2();
            $('#is_route').select2();
            $('#cnstatus').select2();
            $('#edit_route').select2();
            $('#edit_rider').select2();
            $('#is_book').select2();
        });
    </script>
    <script>
        $('#is_book').change(function(event) {
            var issue_book_text = $('#is_book :selected').text();
            var split_string = issue_book_text.split("-");
            $('#is_start').val(split_string[0]);
            $('#is_end').val(split_string[1]);

            $('#reissue_data').on("click", function() {
                var issue_book = $('#is_book :selected').val();
                var is_rider = $('#is_rider :selected').val();
                var is_route = $('#is_route :selected').val();
                var is_start = $('#is_start').val();
                var is_end = $('#is_end').val();
                var is_des = $('#is_des').val();
                var is_date = $('#is_date').val();
                mydata = {
                    action: 'fetch',
                    issue_book: issue_book,
                    is_start: is_start,
                    is_end: is_end,
                    is_rider: is_rider,
                    is_route: is_route,
                    is_des: is_des,
                    is_date: is_date,
                };
                $('#is_book :selected').text("Select CN")
                $('#is_book').val("Select CN")
                if (issue_book != 0 && is_rider != 0 && is_route != 0 && is_start != '' && is_des != '') {
                    $.ajax({
                        url: "insert_reissue_data",
                        method: "POST",
                        data: mydata,
                        success: function(data) {
                            $('#reissue_msg').html('<div class="  col-md-12 alert alert-success" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>Record is saved.</div>')
                            $("form")[0].reset();
                            location.reload();
                        }
                    });
                }else{
                    $('#reissue_msg').html('<div class="  col-md-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong>All field is required.</div>')
                }
            })

        });
    </script>
    <script>
        $('.load_data').on("click", function(event) {
            location.reload();
        })
        document.getElementById("seriesfrom").addEventListener("input", function() {
            document.getElementById("seriesto").value = parseInt(this.value) + 49;
        });
        $('#create_cn').on("click", function(event) {
            var seriesto = $('#seriesto').val();
            var seriesfrom = $('#seriesfrom').val();
            var datetime = $('#datetime').val()
            if (seriesto == "") {
                $('.stoerror').html('<p >This field is required.</p>');
            } else {
                $('.stoerror').html('');
            }
            if (seriesfrom == '') {
                $('.sfromerror').html('<p>This field is required.</p>');
            } else {
                $('.sfromerror').html('');
            }
            if (datetime == '') {
                $('.dateerror').html('<p >This field is required.</p>');
            } else {
                $('.dateerror').html('');
            }

            if (seriesto != "" && seriesfrom != "" && datetime != "") {
                if (parseInt(seriesto) > parseInt(seriesfrom)) {
                    $('.checkerror').html('');
                    mydata = {
                        action: 'fetch',
                        seriesto: seriesto,
                        seriesfrom: seriesfrom,
                        datetime: datetime,
                    };

                    $.ajax({
                        url: "insert_cn",
                        method: "POST",
                        data: mydata,
                        beforeSend: function() {
                            $('#create_cn').attr("disabled", true).css("cursor", "not-allowed")
                            $('#create_cn').html("Sending ...")
                        },
                        success: function(data) {
                            $('.checkerror').html(data);
                            $('#create_cn').attr("disabled", false).css("cursor", "pointer")
                            $('#create_cn').html("Save")
                            $('#seriesfrom').val("").focus();
                            $('#seriesto').val("");
                        }
                    });
                } else {
                    $('.checkerror').html('<p >Start CN Must be less than from End CN .</p>');
                }
            }
        });
    </script>

    <script>
        $('#issuance_data').on("click", function(event) {
            var cn_book = $('#cn_book  option:selected').val();
            var Select_rider = $('#Select_rider  option:selected').val();
            var Select_route = $('#Select_route  option:selected').val();
            var datetime_issuance = $('#datetime_issuance').val();
            if (cn_book == 0) {
                $('.cnerror').html('<p >This field is required.</p>');
            } else {
                $('.cnerror').html('');
            }
            if (Select_rider == 0) {
                $('.ridererror').html('<p>This field is required.</p>');
            } else {
                $('.ridererror').html('');
            }
            if (Select_route == 0) {
                $('.routeerror').html('<p>This field is required.</p>');
            } else {
                $('.routeerror').html('');
            }
            if (datetime == "") {
                $('.datetimeerror').html('<p >This field is required.</p>');
            } else {
                $('.datetimeerror').html('');
            }

            if (cn_book != 0 && Select_rider != 0 && Select_route != 0 && datetime != "") {
                console.log('testing2');

                mydata = {
                    action: 'fetch',
                    cn_book: cn_book,
                    rider: Select_rider,
                    route: Select_route,
                    datetime_issuance: datetime_issuance
                };
                console.log(mydata);

                $.ajax({
                    url: "insert_issuance",
                    method: "POST",
                    data: mydata,
                    beforeSend: function() {
                        $('#issuance_data').attr("disabled", true).css("cursor", "not-allowed")
                        $('#issuance_data').html("Sending ...")
                    },
                    success: function(data) {
                        alert('Record has been successfully saved.')
                        $('#issuance_data').attr("disabled", false).css("cursor", "pointer")
                        $('#issuance_data').html("Save")
                        location.reload();
                    }
                });

            }
        });
    </script>

    <script>
        $('#manag_cn').on("click", function(event) {
            var missingcn = $('#missingcn').val();
            var cnstatus = $('#cnstatus option:selected').val();
            var datetime_manag = $('#datetime_manag').val();
            var mang_des = $('#mang_des').val();

            if (missingcn == "") {
                $('.mantoerror').html('<p >This field is required.</p>');
            } else {
                $('.mantoerror').html('');
            }
            if (cnstatus == 0) {
                $('.manstoerror').html('<p>This field is required.</p>');
            } else {
                $('.manstoerror').html('');
            }
            if (datetime == '') {
                $('.mandateerror').html('<p >This field is required.</p>');
            } else {
                $('.mandateerror').html('');
            }

            if (missingcn != "" && cnstatus != 0 && datetime_manag != "") {
                $('.checkerror').html('');
                mydata = {
                    action: 'fetch',
                    missingcn: missingcn,
                    cnstatus: cnstatus,
                    datetime_manag: datetime_manag,
                    mang_des: mang_des
                };

                $.ajax({
                    url: "manage_cn",
                    method: "POST",
                    data: mydata,
                    beforeSend: function() {
                        $('#manag_cn').attr("disabled", true).css("cursor", "not-allowed")
                        $('#manag_cn').html("Sending ...")
                    },
                    success: function(data) {
                        $('#msg').html(data);
                        $('#manag_cn').attr("disabled", false).css("cursor", "pointer")
                        $('#manag_cn').html("Save")
                        $('#missingcn').val("");
                        location.reload();
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.dataTable').DataTable({
                "displayLength": 10,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],

                "fixedHeader": true,
                "searching": true,
                "paging": true,
                "ordering": true,
                "bInfo": true,
                dom: 'Blfrtip',
                buttons: [
                    'colvis',
                    {
                        extend: 'csv',
                        titleAttr: 'Excel',
                        title: "Route Detail",
                    },
                    {
                        extend: 'copyHtml5',
                        footer: 'true',
                        text: "<i class='fs-14 pg-note'></i> Copy",
                        titleAttr: 'Copy'
                    },
                    {
                        extend: 'print',
                        titleAttr: 'Print',
                        title: "Manage CNBook",

                    }
                ]

            });
        });
    </script>