<?php
error_reporting(0);
$this->load->view('inc/header');
?>


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
                        <li class="breadcrumb-item"><mark>Undelivered or Not Collected</mark></li>
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
                                            <h3>Undelivered or Not Collected</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center d-flex">
                                            <input type="text" class="form-control" id="min" name="min" style="width:50% ;" placeholder="Enter Start Date Like 01.">
                                            <input type="text" class="form-control" id="max" name="max" style="width:50% ;" placeholder="Enter End Date Like 30.">
                                        </div>
                                        <div class="text-center d-flex">
                                            <input type="text" class="form-control" id="min_date" name="min_date" style="width:50% ;" placeholder="Enter Start Month Like 01.">
                                            <input type="text" class="form-control" id="max_date" name="max_date" style="width:50% ;" placeholder="Enter End Month Like 12.">
                                        </div>
                                        <div class="table-responsive m-t-10">
                                            <table style="border-top:1px solid gray ;" class="table table-bordered" id="myTable" width="100%">
                                                <thead>
                                                    <th>Sr</th>
                                                    <th>Order Code | Manual CN</th>
                                                    <th>Delivery Code | Date</th>
                                                    <th>Arrival Date</th>
                                                    <th>Origin | Shipper</th>
                                                    <th>Destination | Consignee</th>
                                                    <th>Pcs | Weight | Product</th>
                                                    <th>Status | FOD</th>
                                                </thead>
                                                <tbody>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var min = parseInt($('#min').val(), 10);
                var max = parseInt($('#max').val(), 10);
                var date_data = data[3]
                const myArray = date_data.split("-");
                var age = parseFloat(myArray[2]) || 0; // use data for the age column
                if (
                    (isNaN(min) && isNaN(max)) ||
                    (isNaN(min) && age <= max) ||
                    (min <= age && isNaN(max)) ||
                    (min <= age && age <= max)

                ) {
                    return true;
                }
                return false;
            });
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var min_date = parseInt($('#min_date').val(), 10);
                var max_date = parseInt($('#max_date').val(), 10);
                var date_data = data[3]
                const myArray = date_data.split("-");
                var age = parseFloat(myArray[1]) || 0; // use data for the age column
                if (
                    (isNaN(min_date) && isNaN(max_date)) ||
                    (isNaN(min_date) && age <= max_date) ||
                    (min_date <= age && isNaN(max_date)) ||
                    (min_date <= age && age <= max_date)

                ) {
                    return true;
                }
                return false;
            });
            load_data()
        });

        function load_data() {
            // $('#myTable').DataTable().destroy();
            $.ajax({
                url: "undelivered_load",
                type: "GET",
                beforeSend: function() {
                    $('tbody').html("<tr><td colspan='14'><img src='<?php echo base_url(); ?>assets/ajax-loader.gif'  width='130px'></td></tr>");
                },
                success: function(data) {
                    $('tbody').html("");
                    var js_obj = $.parseJSON(data)
                    // add origin_city & des_city  
                    // add table
                    var data_arr = [];
                    var btn = "";
                    for (var count = 0; count < js_obj.length; count++) {
                        var sub_array = {
                            'sr': (count + 1),
                            'order_code': js_obj[count].order_code + " | " + js_obj[count].manual_cn,
                            'order_id': js_obj[count].on_route_id + " | " + js_obj[count].on_route_date,
                            'date': js_obj[count].order_arrival_date,
                            'Origin': js_obj[count].origin_city_name + " | " + js_obj[count].shipper_name,
                            'Destination': js_obj[count].destination_city_name + " | " + js_obj[count].manual_cn + " | " + js_obj[count].consignee_mobile,
                            'product_detail': js_obj[count].pieces + " | " + js_obj[count].weight + "KG | " + js_obj[count].product_detail,
                            'status': js_obj[count].order_status + " | Rs." + js_obj[count].cod_amount
                        };
                        data_arr.push(sub_array);

                    }
                    var table = $('#myTable').DataTable({
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        dom: 'Blfrtip',
                        buttons: ["colvis", {
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
                        ],
                        data: data_arr,
                        order: [],
                        columns: [{
                                data: "sr"
                            },
                            {
                                data: "order_code"
                            },
                            {
                                data: "order_id"
                            },
                            {
                                data: "date"
                            },
                            {
                                data: "Origin"
                            },
                            {
                                data: "Destination"
                            },
                            {
                                data: "product_detail"
                            },
                            {
                                data: "status"
                            }

                        ]
                    });
                    // for month
                    $('#min, #max').keyup(function() {
                        table.draw();
                    });
                    // for date
                    $('#min_date, #max_date').keyup(function() {
                        table.draw();
                    });

                }

            });
        }
    </script>