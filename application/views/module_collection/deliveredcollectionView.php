<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "lengthMenu": [
                [-1, 25, 50, 100],
                ["All", 25, 50, 100]
            ],
            fixedHeader: true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "bInfo": true,
            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    orientation: 'Portrait',
                    pageSize: 'A4',
                    footer: 'true',
                    title: "COD FOD Collection Lists",
                    text: "<i class='fs-14 pg-download'></i> PDF",
                    titleAttr: 'PDF',
                    message: "TMC Express \n IT Department \nDate:<?php echo '' . date('Y-m-d'); ?> \n  \nCOD FOD Collection Lists"
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
                }
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
                        <li class="breadcrumb-item"><mark>Delivered & Collected</mark></li>
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
                                            <h3>Delivered & Collected</h3>
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
                                                    <th>Collection | Sheet No | User</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    if (!empty($delivered_collect)) {
                                                        foreach ($delivered_collect as $rows) {
                                                            $i = $i + 1;
                                                            echo ("<tr>");
                                                            echo ("<td>" . $i . "</td>");
                                                            echo ("<td>" . $rows->order_code . " | " . $rows->manual_cn . "</td>");
                                                            echo ("<td>" . $rows->on_route_id . " | " . $rows->on_route_date . "</td>");
                                                            echo ("<td>" . $rows->origin_city_name . " | " . $rows->shipper_name . "</td>");
                                                            echo ("<td>" . $rows->destination_city_name . " | " . $rows->consignee_name . " | " . $rows->consignee_mobile . "</td>");
                                                            echo ("<td>" . $rows->pieces . " | " . $rows->weight . " KG | " . $rows->product_detail . "</td>");
                                                            echo ("<td>" . $rows->order_status . " | Rs. " . $rows->cod_amount . "</td>");
                                                            echo ("<td>Rs. " . $rows->collection . " | " . $rows->cod_sheet_no . " | " . $rows->oper_user_name . "</td>");
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