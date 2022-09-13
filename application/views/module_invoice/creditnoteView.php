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
                        <li class="breadcrumb-item">Credit Note</li>
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
                                            <form action="">
                                                <div class="row clearfix">
                                                    <div class="col-sm-10">
                                                        <div class="form-group form-group-default required">
                                                            <select class="form-control" id="reason" tabindex=2 style="width:100% !important ;">
                                                                <option value="" selected>Select Credit Note Reason </option>
                                                                <option value='Due to claim Adjustment'>Due to claim Adjustment</option>
                                                                <option value='Due to periorical Adjustment'>Due to Periorical Adjustment</option>
                                                                <option value='Due to wrong CN included'>Due to wrong CN included</option>
                                                                <option value='Due to Weight Adjustment'>Due to Weight Adjustment</option>
                                                                <option value='Due to Rate Adjustment'>Due to Rate Adjustment</option>
                                                                <option value='Due to Discount Adjustment'>Due to Discount Adjustment</option>
                                                                <option value='Due to other station CN"s'>Due to Other station CN's</option>
                                                                <option value='Due to write off'>Due to Write off</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-primary" onclick="create_credit_note()" id="btnvrnote" style="height:100%">Create Credit Note</button>
                                                    </div>
                                            </form>
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
                                                <th>Origin </th>
                                                <th>Destination </th>
                                                <th>Consignee </th>
                                                <th>Service </th>
                                                <th>Pieces </th>
                                                <th>Weight </th>
                                                <th class="bg-info text-white">Total </th>
                                                <th>Sc </th>
                                                <th>osa </th>
                                                <th>Osa|Sd </th>
                                                <th>fuel </th>
                                                <th>others </th>
                                                <th>gst </th>
                                                <th>faf </th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                if (!empty($sheet_data)) {
                                                    foreach ($sheet_data as $rows) {
                                                        $i = $i + 1;
                                                        echo ("<tr>");
                                                        echo ("<td class='padd_18 text-center' width='10px'>" . $i . "</td>");
                                                        echo ('<td width="10px" class="text-center"><div class="checkbox check-primary"><input type="checkbox" name="check"  value="' . $rows->acc_invoice_detail_id . '"  id="checkbox_' . $i . '"> <label for="checkbox_' . $i . '" ></label></div></td>');
                                                        // echo ("<td class='padd_18'>" . date('Y-m-d', strtotime($rows->invoice_date)) . "</td>");
                                                        echo ("<td class='padd_18'>" . $rows->manual_cn . "</td>");
                                                        echo ("<td class='padd_18'>" . $rows->origin . "</td>");
                                                        echo ("<td class='padd_18'>" . $rows->destination_name . "</td>");
                                                        echo ("<td class='padd_18'>" . $rows->consignee_detail . "</td>");
                                                        echo ("<td class='padd_18'>" . $rows->serivce_name . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->pcs) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->weight) . "</td>");
                                                        echo ("<td class=' padd_18 text-right bg-info text-white' width='15px'>" . number_format($rows->osa + $rows->gst + $rows->sc + $rows->osa + $rows->osa_sd + $rows->fuel + $rows->others + $rows->faf) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->sc) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->osa) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->osa_sd) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->fuel) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->others) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->gst) . "</td>");
                                                        echo ("<td class='padd_18 text-right' width='15px'>" . number_format($rows->faf) . "</td>");
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
    function create_credit_note() {
        var invoice_id = [];
        $('input[name="check"]:checked').each(function() {
            invoice_id.push(this.value);
        });
        var invoice_id_string = invoice_id.toString();
        $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait .</div></div>");
        if (invoice_id.length != 0) {
            if ($('#reason').val() != "") {
                $.ajax({
                    url: "<?php echo base_url(); ?>Invoice/insert_credit_note",
                    type: "POST",
                    data: {
                        invoice_id: invoice_id_string,
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
                $('form').submit(function(event) {
                    event.preventDefault()
                })
                $("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Minimum one reason  is required to create credit note.</div></div>");
            }
        } else {
            $('form').submit(function(event) {
                event.preventDefault()
            })
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