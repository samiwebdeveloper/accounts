<?php
error_reporting(0);
// echo $o_customer;
// exit;
$this->load->view('inc/header');
?>

<style>
    .table thead tr th {
        text-transform: capitalize;
        font-weight: 600;
        font-family: apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        font-size: 10.5px;
        letter-spacing: 0.05em;
        padding-top: 3px;
        padding-bottom: 3px;
        vertical-align: middle;
        border-bottom: 1px solid rgb(57, 44, 40);
        color: #6d5eac;
        border-top: none;
        border-top: 1px solid gray !important;
    }

    .edit_bts {
        display: block;
        width: 85px;
        font-size: 13px;
        padding: 3px 5px;
        line-height: normal;
        min-height: 8px;
    }

    .edit_bts_success {
        color: #04AA6D !important;
        font-weight: 600;
    }

    .edit_bts_danger {
        color: red !important;
        font-weight: 600;
    }



    .lds-ring {
        display: inline-block;
        position: relative;
        width: 9px;
        height: 14px;
        top: -2px;
        right: 11px;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 25px;
        height: 25px;
        margin: 3px;
        border: 5px solid #fff;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #fff transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    tr.odd td:first-child,
    tr.even td:first-child {
        padding-left: 4em;
    }

    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
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
                        <li class="breadcrumb-item">Cusotmer Ledger </li>
                        <li class="breadcrumb-item">Cusotmer Ledger Detail</li>
                        <li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <div class="pgn-wrapper" data-position="top" style="top: 4px;" id="msg_div"></div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class=" container-fluid   container-fixed-lg bg-gray">
                        <div class="card ">
                            <div class="card-header  separator">
                                <div class="form-group-attached">
                                    <form method="POST" action="<?php echo base_url() ?>/invoice/fetch_record">
                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group form-group-default " id="user_name_div">
                                                    <label>Enter start date</label>
                                                    <?php
                                                    $start_date = "";
                                                    $end_date = "";
                                                    if (!empty($startdate)) {
                                                        $start_date = $startdate;
                                                        $end_date = $enddate;
                                                    } else {
                                                        $start_date = date('Y-m-d', strtotime("-10 days"));
                                                        $end_date = date('Y-m-d');
                                                    }
                                                    // exit;
                                                    ?>
                                                    <input type="date" placeholder="Enter start date " class="form-control" required id="start_date" value="<?php echo $start_date; ?>" name="start_date">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-group-default " id="user_name_div">
                                                    <label>Enter End date</label>
                                                    <input type="date" placeholder="Enter end date " class="form-control" value="<?php echo  $end_date; ?>" required id="end_date" name="end_date">
                                                </div>
                                            </div>
                                            <div style="width:100% ;" class="form-group col-sm-3 form-group-default " ria-="true" id="o_city_div">
                                                <select class="form-control" id="o_city" name="o_city" tabindex=4>
                                                    <option value="">All</option>
                                                    <?php
                                                    foreach ($customer_data as $customer) {
                                                        $selected = "";
                                                        if (!empty($o_customer)) {
                                                            if ($o_customer == $customer->customer_id) {
                                                                $selected = "selected";
                                                            }
                                                        }
                                                        echo "<option $selected value='$customer->customer_id' >" . $customer->customer_name . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-1">
                                                <input id="fetch_data" type="submit" class='btn btn-primary' style="height:100%" value="GO">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1 mt-0">
                            <div class="col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="table-responsive ">
                                            <table class="table table-bordered compact wrap dataTable no-footer" id="myTable" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width=10px> Sr#</th>
                                                        <th> instrument type </th>
                                                        <th> instrument no</th>
                                                        <th> cusomter name </th>
                                                        <th> Sale person </th>
                                                        <th> amount </th>
                                                        <th class='bg-primary text-white' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'> Balance </th>
                                                        <th> created by </th>
                                                        <th> created date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($cusotmer_ledger)) {
                                                        $i = 0;
                                                        foreach ($cusotmer_ledger as $rows) {
                                                            $i = $i + 1;
                                                            echo ("<tr>");
                                                            echo ("<td>" . $i . "</td>");
                                                            echo ("<td>" . $rows->cl_instrument_type . "</td>");
                                                            echo ("<td>" . $rows->cl_instrument_no . "</td>");
                                                            echo ("<td>" . $rows->cusomter_name . "</td>");
                                                            echo ("<td>" . $rows->sale_person . "</td>");
                                                            echo ("<td>" . number_format($rows->cl_amount) . "</td>");
                                                            echo ("<td class='bg-primary text-white' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'><center>" . number_format($rows->cl_outstanding_amount) . "</center></td>");
                                                            echo ("<td>" . $rows->ops_name . "</td>");
                                                            $date = date_create($rows->created_date);
                                                            echo ("<td>" . date_format($date, 'M-d-Y') . "</td>");
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
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
    <script>
        $(document).ready(function() {
            // data_array()
            $("#o_city").select2();
        })

        $(document).ready(function() {
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
                        sheetName: 'Customer Ledger Report',
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
                        title: "Customer Ledger Report",
                        message: "T.M. Cargo<br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>Customer Ledger Report<br>"
                    }
                ],
                order: [
                    [4, 'asc']
                ],
                displayLength: 25,
                "ordering": true,
                "columnDefs": [{
                    "visible": true,
                    "targets": [4, 3]
                }],
                
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    var columns = [4, 3];
                    for (c = 0; c < columns.length; c++) {
                        var colNo = columns[c];
                        api.column(colNo, {page: 'current'}).data().each(function(group, i) {
                            if (last !== group) {
                                if (colNo == 4) {
                                    $(rows).eq(i).before(
                                        '<tr class="sale_' + colNo + ' text-center group"><th colspan="9" style="font-weight: bold !important;">' + group + '</th></tr>'
                                    );
                                } else {
                                    $(rows).eq(i).before(
                                        '<tr class="cusotmer_' + colNo + '"><th colspan="9" style="font-weight: bold !important;">' + group + '</th></tr>'
                                    );
                                }

                                last = group;
                            }
                        });
                    }
                },
              
            });
        });
    </script>