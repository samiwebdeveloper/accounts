<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
        font-weight: 600;
    }

    .form-control[disabled],
    .form-control[readonly],
    fieldset[disabled] .form-control {
        color: black;
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
                        <li class="breadcrumb-item">Booking</li>
                        <li class="breadcrumb-item">Reconcile Cash booking</li>
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
                                <div class="card ">
                                    <div class="card-header  separator">
                                        <div class="form-group-attached">
                                            <form action="<?php echo base_url(); ?>Booking/booking/reconcile_cash_booking" method="post">
                                                <div class="row clearfix">
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-group-default required" id="user_name_div">
                                                            <label>Start Date</label>
                                                            <?php if ($startdate != "") {
                                                                $startdate;
                                                                $enddate;
                                                            } else {
                                                                $enddate = date('Y-m-d');
                                                                $startdate = date('Y-m-d', strtotime('-10 days'));
                                                            } ?>
                                                            <input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php echo  $startdate; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-group-default required">
                                                            <label>End Date</label>
                                                            <input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php echo $enddate; ?>">
                                                        </div>
                                                    </div>
                                                    <div style="width:100% ;" class="form-group col-sm-3 form-group-default " ria-="true" id="o_city_div">
                                                        <select class="form-control" id="o_city" name="o_city" tabindex=4>
                                                            <option value="">Origin City </option>
                                                            <?php
                                                            foreach ($city_data as $city) {
                                                                $selected = "";
                                                                if (!empty($o_city)) {
                                                                    if ($o_city == $city->city_id) {
                                                                        $selected = "selected";
                                                                    }
                                                                }
                                                                echo "<option  $selected value='$city->city_id' >" . $city->city_name . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="submit" class="btn btn-primary" style="height:100%">GO</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive m-t-10">
                                        <table class="table table-bordered compact nowrap" style="border-top:1px solid black ;" id='myTable' width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Sr #</th>
                                                    <th>Action</th>
                                                    <th>CN</th>
                                                    <th>Manual CN</th>
                                                    <th>Origin </th>
                                                    <th>Destination </th>
                                                    <th>Pieces </th>
                                                    <th>Weight</th>
                                                    <th width="70px" class='bg-primary text-center text-white' style="box-shadow: 1px 1px #6d5eac;"> Cash </th>
                                                    <th width="70px" class='bg-primary text-center  text-white' style="box-shadow: 1px 1px #6d5eac;">collected </th>
                                                    <th width="70px" class='bg-primary text-center  text-white' style="box-shadow: 1px 1px #6d5eac;">balance</th>
                                                    <th>rider  </th>
                                                    <th>route </th>
                                                    <th>shipper </th>
                                                    <th>consignee</th>
                                                    <th>Order date</th>
                                                    <th style="display:none ;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="resultTable">
                                                <?php if (!empty($order_data)) {
                                                    $i = 0;
                                                    foreach ($order_data as $rows) {
                                                        $i = $i + 1;
                                                        echo ("<tr>");
                                                        echo ("<td>" . $i . "</td>");
                                                         echo '<td class="text-center " data-toggle="modal" data-target="#edit_' . $rows->order_id . '"><button class="edit_btn_' . $rows->order_id . ' btn btn-primary btn-xs"><i class="fa fa-edit"></i></button></td>';
                                                        echo ("<td>" . $rows->order_code . "</td>");
                                                        echo ("<td>" . $rows->manual_cn . "</td>");
                                                        echo ("<td>" . $rows->origin_city_name . "</td>");
                                                        echo ("<td>" . $rows->destination_city_name . "</td>");
                                                        echo ("<td class='text-right'>" . number_format($rows->pieces) . "</td>");
                                                        echo ("<td class='text-right'>" . number_format($rows->weight) . "</td>");
                                                        echo ("<td  class='bg-primary text-right text-white' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'>" . number_format($rows->cod_amount) . "</td>");
                                                        echo ("<td id='collected_amount_$rows->order_id' class='bg-primary text-right text-white' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'>" . number_format($rows->balance) . "</td>");
                                                        echo ("<td id='balance_amount_$rows->order_id' class='bg-primary text-center text-white' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'>" . number_format($rows->cod_amount - $rows->balance) . "</td>");
                                                        echo ("<td>" . $rows->rider_name . "</td>");
                                                        echo ("<td>" . $rows->route_name . "</td>");
                                                        echo ("<td>" . $rows->consignee_name . "</td>");
                                                        echo ("<td>" . $rows->shipper_name . "</td>");
                                                        $date = date_create($rows->order_date);
                                                        echo ("<td>" . date_format($date, 'M-d-Y') . "</td>");
                                                ?>
                                                        <td style="display:none ;"><input type="text" class="order_id" hidden value="<?php echo $rows->order_id ?>"></td>
                                                        <div class="modal fade stick-up" id="edit_<?php echo $rows->order_id ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-dialog ">
                                                                    <div class="modal-content-wrapper">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header clearfix text-left">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                                                                                </button>
                                                                                <h5>Cash <span class="semi-bold"> Receive</span></h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form role="form">
                                                                                    <div class="form-group-attached">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <p id="msg_div_ins_<?php echo $rows->order_id  ?>"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-7">
                                                                                                <div class="form-group form-group-default ">
                                                                                                    <label>Cash Amount</label>
                                                                                                    <input type="text" class="form-control" readonly name="total_amount" value="<?php echo  number_format($rows->cod_amount) ?>" id="total_amount_<?php echo $rows->order_id ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="form-group form-group-default required">
                                                                                                    <label>Collected Amount</label>
                                                                                                    <input type="text" class="form-control" value="<?php echo  number_format($rows->balance) ?>" readonly id="model_collected_<?php echo $rows->order_id ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-7">
                                                                                                <div class="form-group form-group-default ">
                                                                                                    <label>Balance</label>
                                                                                                    <input type="text" class="form-control" readonly name="total_amount" value="<?php echo number_format($rows->cod_amount - $rows->balance) ?>" id="model_balance_<?php echo $rows->order_id ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="form-group form-group-default required">
                                                                                                    <label>Receive Amount</label>
                                                                                                    <input type="number" class="form-control" name="cash_amount" id="cash_amount_<?php echo $rows->order_id ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-7">
                                                                                                <div class="form-group form-group-default required">
                                                                                                    <label>Collected By</label>
                                                                                                    <input type="text" class="form-control" name="collected_by" id="collected_by_<?php echo $rows->order_id ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="form-group form-group-default required">
                                                                                                    <label>Date</label>
                                                                                                    <input type="datetime-local" class="form-control" name="datetime" id="datetime_<?php echo $rows->order_id ?>" value="<?php echo date('Y-m-d\TH:i') ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group form-group-default">
                                                                                                    <label>Remarks</label>
                                                                                                    <textarea id="mang_des_<?php echo $rows->order_id ?>" name="mang_des" class="form-control " style=" height:60px;min-height:50px; max-height:80px;"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                                <div class="row">
                                                                                    <div class="col-md-8">
                                                                                        <div class="p-t-20 clearfix p-l-10 p-r-10">
                                                                                            <div class="pull-left">
                                                                                                <p class="bold font-montserrat text-uppercase">Remaining Balance</p>
                                                                                            </div>
                                                                                            <div class="pull-right">
                                                                                                <p class="bold font-montserrat text-uppercase" id="balance_<?php echo $rows->order_id ?>"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 m-t-10 sm-m-t-10">
                                                                                        <button type="button" class="btn btn-primary btn-block m-t-5" id="save_<?php echo $rows->order_id ?>">Save</button>
                                                                                    </div>
                                                                                    <script>
                                                                                        $("#cash_amount_<?php echo $rows->order_id ?>").on("input", function() {
                                                                                            var cash_amount = $(this).val();
                                                                                           var bal= $("#model_balance_<?php echo $rows->order_id ?>").val();
                                                                                            $("#balance_<?php echo $rows->order_id ?>").html(parseInt(bal.replace(",", "")) - parseInt(cash_amount));
                                                                                        });
                                                                                        $("#save_<?php echo $rows->order_id ?>").click(function() {
                                                                                            var collected_amount = $("#collected_amount_<?php echo $rows->order_id ?>").text();
                                                                                            var balance_amount = $("#balance_amount_<?php echo $rows->order_id ?>").text();
                                                                                            var receive_amount = $("#cash_amount_<?php echo $rows->order_id ?>").val();
                                                                                            var collected_by = $("#collected_by_<?php echo $rows->order_id ?>").val();
                                                                                            var datetime = $("#datetime_<?php echo $rows->order_id ?>").val();
                                                                                            var mang_des = $("#mang_des_<?php echo $rows->order_id ?>").val();
                                                                                            var balance = $("#balance_<?php echo $rows->order_id ?>").text();
                                                                                            if (receive_amount != "" && receive_amount > 0 && collected_by != "" && datetime != "") {
                                                                                                var mydata = {
                                                                                                    amount: receive_amount,
                                                                                                    order_id: <?php echo $rows->order_id ?>,
                                                                                                    collected_by: collected_by,
                                                                                                    date: datetime,
                                                                                                    balance: balance,
                                                                                                    remarks: mang_des,
                                                                                                    created_by: <?php echo $_SESSION['user_id'] ?>
                                                                                                };
                                                                                                $.ajax({
                                                                                                    url: "<?php echo base_url(); ?>booking/booking/cash_receive",
                                                                                                    type: "POST",
                                                                                                    data: mydata,
                                                                                                    beforeSend: function() {
                                                                                                        $('#msg_div_ins_<?php echo $rows->order_id ?>').html('<div class="  col-lg-12 alert alert-warnning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>please wait...</div>')
                                                                                                        $("#save_<?php echo $rows->order_id ?>").html('please wait...')
                                                                                                    },
                                                                                                    success: function(data) {
                                                                                                        $('#msg_div_ins_<?php echo $rows->order_id ?>').html(data);
                                                                                                        $('.edit_btn_<?php echo $rows->order_id ?>').attr("disabled", true).css("cursor", "not-allowed").addClass('btn-success').removeClass('btn-primary');
                                                                                                        var formatter = new Intl.NumberFormat('en-US');
                                                                                                        var total_collected_amount = parseInt(collected_amount.replace(",", "")) + parseInt(receive_amount)
                                                                                                        var total_balance_amount = parseInt("<?php echo $rows->cod_amount ?>") - parseInt(total_collected_amount)
                                                                                                        $("#collected_amount_<?php echo $rows->order_id ?>").text(formatter.format(total_collected_amount));
                                                                                                        $("#balance_amount_<?php echo $rows->order_id ?>").text(formatter.format(total_balance_amount))
                                                                                                        $("#model_collected_<?php echo $rows->order_id ?>").val(formatter.format(total_collected_amount));
                                                                                                        $("#model_balance_<?php echo $rows->order_id ?>").val(formatter.format(total_balance_amount))
                                                                                                        $("#balance_<?php echo $rows->order_id ?>").html(formatter.format(total_balance_amount))
                                                                                                        $("#save_<?php echo $rows->order_id ?>").html('Save')
                                                                                                        $("#cash_amount_<?php echo $rows->order_id ?>").val("")
                                                                                                        $("#collected_by_<?php echo $rows->order_id ?>").val("")
                                                                                                        $("#datetime_<?php echo $rows->order_id ?>").val("<?php echo date('Y-m-d\TH:i') ?>")
                                                                                                        $("#mang_des_<?php echo $rows->order_id ?>").val("")
                                                                                                    },
                                                                                                    error: function(data, sts, errmsg) {
                                                                                                        $('#msg_div_ins_<?php echo $rows->order_id ?>').html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
                                                                                                    }
                                                                                                });
                                                                                            } else {
                                                                                                if (receive_amount < 0) {
                                                                                                    $('#msg_div_ins_<?php echo $rows->order_id ?>').html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> Please enter correct amount.</div>')
                                                                                                } else {
                                                                                                    $('#msg_div_ins_<?php echo $rows->order_id ?>').html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
                                                                                                }
                                                                                            }
                                                                                        })
                                                                                    </script>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
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
    $(document).ready(function() {
        $('#o_city').select2();
        data_array()
    })

    function data_array() {
        var groupColumn = 15;
        var table = $('#myTable').DataTable({
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
                    sheetName: 'Booking Reconcile List',
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
                    title: "Booking Reconcile List",
                    message: "T.M. Cargo<br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>Invoices List<br>"
                }
            ],
            columnDefs: [{
                visible: true,
                targets: groupColumn
            }],
            order: [
                [groupColumn, 'asc']
            ],
            displayLength: 10,
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(groupColumn, {
                        page: 'current'
                    })
                    .data()
                    .each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><th colspan="16">' + group + '</th></tr>');
                            last = group;
                        }
                    });
            },
        });
        $('#myTable').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                table.order([groupColumn, 'desc']).draw();
            } else {
                table.order([groupColumn, 'asc']).draw();
            }
        });
    }
</script>