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
                        <li class="breadcrumb-item">Reconcile Cash booking Report</li>
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
                                            <form action="<?php echo base_url(); ?>booking/booking/cash_booking_report" method="post">
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
                                                            <option value="">All </option>
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
                                              
                                                    <th>Sr</th>
                                                    <th>Order Code</th>
                                                    <th>Manual CN</th>
                                                    <th>Origin </th>
                                                    <th>Destination </th>
                                                    <th>Pieces </th>
                                                    <th>Weight</th>
                                                    <th>Cash</th>
                                                    <th>collected</th>
                                                    <th class='bg-primary text-white' style="box-shadow: 3px 1px #6d5eac;">Balance</th>
                                                    <th class='bg-primary text-white' style="box-shadow: 3px 1px #6d5eac;">Cn Remaining</th>
                                                    <th>collected by</th>
                                                    <th>remarks</th>
                                                    <th>collected date</th>
                                                    <th>shipper</th>
                                                    <th>consignee</th>
                                                    <th>Order date</th>
                                                    <th>created by</th>
                                                    <th>created date</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($order_data)) {
                                                    $i = 1;
                                                    foreach ($order_data as $rows) {
                                                        $i = $i + 1;
                                                        echo ("<tr>");
                                                        echo ("<td width='20px'>" . $i . "</td>");
                                                        echo ("<td>" . $rows->order_code . "</td>");
                                                        echo ("<td>" . $rows->manual_cn . "</td>");
                                                        echo ("<td>" . $rows->origin_city_name . "</td>");
                                                        echo ("<td>" . $rows->destination_city_name . "</td>");
                                                        echo ("<td>" . number_format($rows->pieces) . "</td>");
                                                        echo ("<td>" . number_format($rows->weight) . "</td>");
                                                        echo ("<td>" . number_format($rows->cod_amount) . "</td>");
                                                        echo ("<td>" . number_format($rows->amount) . "</td>");
                                                        echo ("<td class='bg-primary text-white' style='box-shadow:5px 1px 10px #6d5eac;font-weight:600;font-size:13px;'><center>" . number_format($rows->balance) . "</center></td>");
                                                        echo ("<td class='bg-primary text-white' style='box-shadow:5px 1px 10px #6d5eac;font-weight:600;font-size:13px;'><center>" . number_format($rows->cod_amount-$rows->balance) . "</center></td>");
                                                        echo ("<td>" . $rows->collected_by . "</td>");
                                                        echo ("<td>" . $rows->remarks . "</td>");
                                                        if ($rows->collected_date == NULL OR $rows->collected_date == "" ) {
                                                        echo ("<td>NULL</td>");
                                                        } else {
                                                            echo ("<td>" . date_format(date_create($rows->collected_date), 'M-d-Y H:i') . "</td>");
                                                        }
                                                        echo ("<td>" . $rows->consignee_name . "</td>");
                                                        echo ("<td>" . $rows->shipper_name . "</td>");
                                                        echo ("<td>" . date('M-d-Y', strtotime($rows->order_date)) . "</td>");
                                                        echo ("<td>" . $rows->created_by . "</td>");
                                                        if ($rows->created_at == NULL OR $rows->created_at == "" ) {
                                                            echo ("<td>NULL</td>");
                                                            } else {
                                                                echo ("<td>" . date_format(date_create($rows->created_at), 'M-d-Y H:i') . "</td>");
                                                            }
                                                        ?>
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
        var groupColumn = 2;
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
                    extend: 'excelHtml5',
                    text: "<i class='fs-14 pg-form'></i> Excel",
                    titleAttr: 'Excel',
                    sheetName: 'Cash Reconcile Bookig Report',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],

            columnDefs: [{
                visible: true,
                targets: groupColumn
            }],
            order: [
                [11, 'desc']
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
                            $(rows).eq(i).before('<tr class="group"><th colspan="20">' + group + '</th></tr>');
                            last = group;
                        }
                    });
            },
            columnDefs: [{
                targets: [2,3,4,5,6],
                visible: false
            }],
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