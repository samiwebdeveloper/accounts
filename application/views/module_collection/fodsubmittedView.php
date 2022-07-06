<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            fixedHeader: true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "bInfo": true,
            dom: 'Blfrtip',
            buttons: [
                /*{
                					extend: 'pdfHtml5',
                					orientation: 'Portrait',
                					pageSize: 'A4',
                					footer: 'true',
                					title: "COD FOD Collection Lists",
                					text: "<i class='fs-14 pg-download'></i> PDF",
                					titleAttr: 'PDF',
                					message: "Delivery Express\n  Powered By SaimTech \n Date:<?php echo '' . date('Y-m-d'); ?> \n Delivery Phase 1 Lists \n "
                				},
                				{
                					extend: 'excelHtml5',
                					text: "<i class='fs-14 pg-form'></i> Excel",
                					titleAttr: 'Excel',
                					sheetName: 'Delivery Phase 1 Lists',
                					exportOptions: {
                						modifier: {
                							page: 'current'
                						}
                					}
                				},
                				{
                					extend: 'copyHtml5',
                					footer: 'true',
                					text: "<i class='fs-14 pg-note'></i> Copy",
                					titleAttr: 'Copy'
                				},
                				{
                					extend: 'print',
                					text: "<i class='fs-14 pg-ui'></i> Print",
                					titleAttr: 'Print',
                					footer: 'true',
                					title: "COD FOD Collection Lists",
                					message: "TMC Express <br> IT Department <br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>COD FOD Collection Lists<br>"
                				}*/
            ]
        });

        var table = $('#sheet_detail').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            fixedHeader: true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "bInfo": true,
            dom: 'Blfrtip',
            buttons: [
                /*{
                					extend: 'pdfHtml5',
                					orientation: 'Portrait',
                					pageSize: 'A4',
                					footer: 'true',
                					title: "COD FOD Collection Lists",
                					text: "<i class='fs-14 pg-download'></i> PDF",
                					titleAttr: 'PDF',
                					message: "Delivery Express\n  Powered By SaimTech \n Date:<?php echo '' . date('Y-m-d'); ?> \n Delivery Phase 1 Lists \n "
                				},
                				{
                					extend: 'excelHtml5',
                					text: "<i class='fs-14 pg-form'></i> Excel",
                					titleAttr: 'Excel',
                					sheetName: 'Delivery Phase 1 Lists',
                					exportOptions: {
                						modifier: {
                							page: 'current'
                						}
                					}
                				},
                				{
                					extend: 'copyHtml5',
                					footer: 'true',
                					text: "<i class='fs-14 pg-note'></i> Copy",
                					titleAttr: 'Copy'
                				},
                				{
                					extend: 'print',
                					text: "<i class='fs-14 pg-ui'></i> Print",
                					titleAttr: 'Print',
                					footer: 'true',
                					title: "COD FOD Collection Lists",
                					message: "TMC Express <br> IT Department <br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>COD FOD Collection Lists<br>"
                				}*/
            ]
        });
    });
</script>
<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Collection</li>
                        <li class="breadcrumb-item"><mark>FOD Collection</mark></li>
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
                    <!-- START card -->
                    <div class=" container-fluid   container-fixed-lg bg-gray">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card m-t-10">
                                    <div class="card-header  separator">
                                        <div class="card-title">
                                            <h3>Collection Sheet</h3>
                                        </div>
                                        <div class="form-group-attached">
                                            <div class="row clearfix">
                                                <div class="col-sm-3">
                                                    <div class="form-group form-group-default required" id="user_name_div">
                                                        <form action="<?php echo base_url(); ?>Collection/date_range" method="post">
                                                            <label>Start Date</label>
                                                            <input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php if (!empty($start_date)) {
                                                                                                                                                                echo $start_date;
                                                                                                                                                            } ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-group-default required">
                                                        <label>End Date</label>
                                                        <input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php if (!empty($end_date)) {
                                                                                                                                                        echo $end_date;
                                                                                                                                                    } ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="submit" class='btn btn-primary' style="height:100%">GO</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive m-t-10">
                                            <table class="table table-bordered" id="sheet_detail">
                                                <thead>
                                                    <th>Sr</th>
                                                    <th>Sheet No</th>
                                                    <th>Total CNs</th>
                                                    <th>Total Amount</th>
                                                    <th>Submitted To</th>
                                                    <th>Remarks</th>
                                                    <th>Date Time</th>
                                                    <th>User</th>
                                                    <th>Location</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    if (!empty($sheet)) {
                                                        foreach ($sheet as $rows) {
                                                            $i = $i + 1;
                                                            echo ("<tr>");
                                                            echo ("<td>" . $i . "</td>");
                                                            echo ("<td>" . $rows->cod_sheet_no . "</td>");
                                                            echo ("<td>" . $rows->total_cns . "</td>");
                                                            echo ("<td>" . $rows->total_amt . "</td>");
                                                            echo ("<td>" . $rows->submit_to . "</td>");
                                                            echo ("<td>" . $rows->remarks . "</td>");
                                                            echo ("<td>" . $rows->created_at . "</td>");
                                                            echo ("<td>" . $rows->oper_user_name . "</td>");
                                                            echo ("<td>" . $rows->city_full_name . "</td>");
                                                            echo ("<td><a href='" . base_url() . "Collection/submit_preview/" . $rows->cod_sheet_id . "' target='_blank' class='btn btn-info btn-xs'>View / Print</a></td>");
                                                            echo ("</tr>");
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END card -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card m-t-10">
                                    <div class="card-header  separator">
                                        <div class="card-title">
                                            <h3>Collection Detail</h3>
                                        </div>
                                        <div class="form-group-attached">
                                            <div class="row clearfix">
                                                <div class="col-sm-3">
                                                    <div class="form-group form-group-default required" id="user_name_div">
                                                        <form action="<?php echo base_url(); ?>Collection/date_range" method="post">
                                                            <label>Start Date</label>
                                                            <input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php if (!empty($start_date)) {
                                                                                                                                                                echo $start_date;
                                                                                                                                                            } ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-group-default required">
                                                        <label>End Date</label>
                                                        <input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php if (!empty($end_date)) {
                                                                                                                                                        echo $end_date;
                                                                                                                                                    } ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="submit" class='btn btn-primary' style="height:100%">GO</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive m-t-10">
                                            <table class="table table-bordered" id="myTable">
                                                <thead>
                                                    <th>Sr</th>
                                                    <th>Order Code | Manual CN</th>
                                                    <th>Delivery Code | Date</th>
                                                    <th>Origin | Shipper</th>
                                                    <th>Destination | Consignee</th>
                                                    <th>Pcs | Weight | Product</th>
                                                    <th>Status | FOD</th>
                                                    <th>Sheet No</th>
                                                    <th>Collection</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    if (!empty($cns_collect)) {
                                                        foreach ($cns_collect as $rows) {
                                                            $i = $i + 1;
                                                            $outstand += $rows->cod;
                                                            $collected += $rows->accts_rcvd_amount;
                                                            $ops_collection = $rows->cod - $rows->ops_rcvd_amount;
                                                            $ops_col_mark = $ops_collection > 0 ? " | <strong class='text-danger'>Short Receive</strong>" : " | <strong class='text-success'>Okay</strong>";
                                                            echo ("<tr>");
                                                            echo ("<td>" . $i . "</td>");
                                                            echo ("<td>" . $rows->order_code . " | " . $rows->manual_cn . "</td>");
                                                            echo ("<td>" . $rows->on_route_id . " | " . $rows->on_route_date . "</td>");
                                                            echo ("<td>" . $rows->origin_city_name . " | " . $rows->shipper_name . "</td>");
                                                            echo ("<td>" . $rows->destination_city_name . " | " . $rows->consignee_name . " | " . $rows->consignee_mobile . "</td>");
                                                            echo ("<td>" . $rows->pieces . " | " . $rows->weight . " KG | " . $rows->product_detail . "</td>");
                                                            echo ("<td>" . $rows->order_status . " | Rs. " . $rows->cod_amount . "</td>");
                                                            echo ("<td>" . $rows->cod_sheet_no . "</td>");
                                                            echo ("<td>" . $rows->collection . "</td>");
                                                            echo ("</tr>");
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
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
        </div>
    </div>
    <?php
    $this->load->view('inc/footer');
    ?>