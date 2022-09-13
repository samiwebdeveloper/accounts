<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
    .padd_18 {
        font-size: 13px !important;
        padding-top: 12px !important;
    }

    .radio,
    .checkbox {
        margin-bottom: 0px;
        margin-top: 0px;
        padding-left: 13px;
        padding-top: 8px;
    }

    .selected {
        color: white;
        background: #1f3953 !important;
    }
</style>
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
                        <li class="breadcrumb-item">Accounts</li>
                        <li class="breadcrumb-item">Debit Note</li>
                        <li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
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
                                        <div class="form-group-attached">
                                            <!-- <form action="" id="form"> -->
                                            <div class="row clearfix">
                                                <div class="col-sm-10">
                                                    <div class="form-group form-group-default required">
                                                        <select class="form-control" id="reason" tabindex=2 style="width:100% !important ;">
                                                            <option value="" selected>Select Debit Note Reason </option>
                                                            <option value='Due to CN"s not included'>Due to CN's not included</option>
                                                            <option value='Due to Weight Adjustment'>Due to Weight Adjustment</option>
                                                            <option value='Due to Rate Adjustment'>Due to Rate Adjustment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" col-sm-2">
                                                    <button type="submit" class="btn btn-primary" onclick="create_debit_note()" id="btnvrnote" style="height:100%">Create Debit Note</button>
                                                </div>
                                                <!-- </form> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive m-t-10">
                                            <table class="table table-bordered nowrap compact" id="myTable" style="border-top:1px solid black" style="width:100%">
                                                <thead>
                                                    <th>Sr #</th>
                                                    <th>check </th>
                                                    <th>CN No </th>
                                                    <th>order code </th>
                                                    <th>Origin </th>
                                                    <th>Destination </th>
                                                    <th>Consignee </th>
                                                    <th>Shipper </th>
                                                    <th>Pieces </th>
                                                    <th>Weight </th>
                                                    <th class="bg-primary text-white">Total </th>
                                                    <th>Sc </th>
                                                    <th>osa </th>
                                                    <th>osa | sd </th>
                                                    <th>fuel </th>
                                                    <th>others </th>
                                                    <th>gst </th>
                                                    <th>faf </th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    if (!empty($get_order_details)) {
                                                        foreach ($get_order_details as $rows) {
                                                            $i = $i + 1;
                                                            echo ("<tr>");
                                                            echo ("<td class='padd_18 text-center' width='10px'>" . $i . "</td>");
                                                            echo ('<td width="10px" class="text-center"><div class="checkbox check-primary"><input type="checkbox" name="check"  value="' . $rows->order_code . '"  id="checkbox_' . $i . '"> <label for="checkbox_' . $i . '" ></label></div></td>');
                                                            echo ("<td class='padd_18'>" . $rows->manual_cn . "</td>");
                                                            echo ("<td class='padd_18'>" . $rows->order_code . "</td>");
                                                            echo ("<td class='padd_18'>" . $rows->origin_city_name . "</td>");
                                                            echo ("<td class='padd_18'>" . $rows->destination_city_name . "</td>");
                                                            echo ("<td class='padd_18'>" . $rows->consignee_name . "</td>");
                                                            echo ("<td class='padd_18'>" . $rows->shipper_name . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->pieces) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->weight) . "</td>");
                                                            echo ("<td class=' padd_18 text-right bg-primary text-white' width='15px'>" . number_format($rows->order_osa + $rows->order_osa_sd_total + $rows->order_gst + $rows->order_sc + $rows->order_fuel + $rows->order_others + $rows->order_faf) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_sc) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_osa) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_osa_sd_total) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_fuel) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_others) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_gst) . "</td>");
                                                            echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->order_faf) . "</td>");
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
    <script>
        function create_debit_note() {
            var invoice_id = [];
            $('input[name="check"]:checked').each(function() {
                invoice_id.push(this.value);
            });
            var invoice_id_string = invoice_id.toString();
            console.log(invoice_id_string);
            $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait .</div></div>");
            if (invoice_id_string != "") {
                if ($('#reason').val() != "") {
                    $.ajax({
                        url: "<?php echo base_url(); ?>Invoice/insert_debit_note",
                        type: "POST",
                        data: {
                            order_code: invoice_id_string,
                            invoce_no: "<?php echo $this->uri->segment(3) ?>",
                            first_day: "<?php echo $invoce_data['first_day'] ?>",
                            last_day: "<?php echo $invoce_data['last_day'] ?>",
                            reason: $('#reason').val()
                        },
                        success: function(data) {
                            $("#msg_div").html(data);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(error) {
                            $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Already  credit note is created on these CNs ..</div></div>");
                        },
                    });
                } else {
                    $('#form').submit(function(event) {
                        event.preventDefault()
                    })
                    $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Minimum one reason  is required to create credit note.</div></div>");
                }
            } else {
                $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Minimum one record is required to create credit note.</div></div>");
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reason').select2();
            $('#myTable thead span').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '"  />');
            });
            var table = $('#myTable').DataTable({
                "lengthMenu": [
                    [20, 50, -1],
                    [20, 50, 'All']
                ],
                fixedHeader: true,
                "searching": true,
                "paging": true,
                "ordering": true,
                "bInfo": true,
                dom: 'Blfrtip',
                buttons: [
                    'colvis',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A3',
                        footer: 'true',
                        title: "Invoices List",
                        text: "<i class='fs-14 pg-download'></i> PDF",
                        titleAttr: 'PDF',
                        message: "T.M. Cargo\n  Powered By IT Department \n Date:<?php echo '' . date('Y-m-d'); ?> \n Invoices List \n "
                    },
                    {
                        extend: 'excelHtml5',
                        text: "<i class='fs-14 pg-form'></i> Excel",
                        titleAttr: 'Excel',
                        sheetName: 'Invoices List',
                        exportOptions: {
                            columns: ':visible'
                        },
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
                        title: "Invoices List",
                        message: "T.M. Cargo<br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>Invoices List<br>"
                    }
                ]
            });
            table.columns().every(function() {
                var that = this;
                $('input', this.header()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>