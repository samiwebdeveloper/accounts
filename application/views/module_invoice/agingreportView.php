<?php
error_reporting(0);
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

    table.dataTable {
        border-collapse: collapse;
    }

    tfoot tr {
        border-bottom: 1.1px solid black !important;
    }

    .row_sum,
    .row_sum_soft,
    .row_sum_hard {
        font-size: 16px !important;
        font-weight: 500;
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
                        <li class="breadcrumb-item">Report </li>
                        <li class="breadcrumb-item">Aging Report</li>
                        <li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <div class="pgn-wrapper" data-position="top" style="top: 10px;"></div>
            <div class="row">
                <div id="get_massage"></div>
                <div class="col-xl-12 col-lg-12">
                    <div class=" container-fluid   container-fixed-lg bg-gray">
                        <div class="card ">
                        </div>
                        <div class="row mb-1 mt-0">
                            <div class="col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="table-responsive ">
                                            <div><?php echo $errors[0] ?><?php echo $errors[1] ?></div>
                                            <div id="msg_div"></div>
                                            <table class="table display_1 table-bordered compact nowrap dataTable no-footer" width="99%" id="aging_report">
                                                <thead>
                                                    <tr>
                                                        <th>Sr #</th>
                                                        <th>Customer Name</th>
                                                        <th>Sale Person</th>
                                                        <th class='text-right'>Accumulated</th>
                                                        <?php
                                                        foreach ($hmonth as $hvalue) {
                                                            echo "<th class='text-center'>" . $hvalue['Month'] . "</th>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <!-- <input type="text" autocomplete="off"> -->
                                                    <?php
                                                    $hdata_value = array();
                                                    $i = 0;
                                                    foreach ($hsummary as $month_value) {
                                                        $hdata_value[$i]['customer'] = $month_value['customer_name'];
                                                        $hdata_value[$i]['customer_id'] = $month_value['customer_id'];
                                                        $hdata_value[$i]['reference_name'] = $month_value['reference_name'];
                                                        $hdata_value[$i]['Total'] = $month_value['Total'];
                                                        foreach (explode(",",  $month_value['data']) as $value_sep) {
                                                            $val = explode("|", $value_sep);
                                                            $hard_copy_grand_sum = $hard_copy_grand_sum + $val[1];
                                                            $hdata_value[$i][$val[0]] = $val[1];
                                                        }
                                                        $i++;
                                                    }
                                                    ?>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($hdata_value as  $rows) {
                                                        $i = $i + 1;
                                                        echo "  <tr> <td width='15px'>" . $i . " </td>";
                                                        echo "  <td class='text-left'>" . $rows['customer'] . " </td>";
                                                        echo "  <td class='text-left'>" . $rows['reference_name'] . " </td>";
                                                        echo "  <td class=''  width='20px'>" . number_format($rows['Total']) . " </td>";
                                                        foreach ($hmonth as $value) {
                                                            if (strlen($rows[$value['Month']])) {
                                                                echo "<td  class='get_id text-right'  width='20px' > " . number_format($rows[$value['Month']]) . "</td>";
                                                            } else {
                                                                echo "<td class='text-right'>0</td>";
                                                            }
                                                        }
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2" class="text-center total_dc_row ">Total</th>
                                                        <th class="  text-center"></th>
                                                    </tr>
                                                </tfoot>
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
        </div>
    </div>
    <?php
    $this->load->view('inc/footer');
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var total_dc_row = document.getElementById('aging_report').rows[0].cells.length
            for (let index = 3; index < total_dc_row; index++) {
                $(".total_dc_row").after('<th class="text-center"></th>')
            }


            var table = $('#aging_report').DataTable({
                dom: 'Blfrtip',
                "lengthMenu": [
                    [20, -1],
                    [20, "All"]
                ],
                buttons: [
                    'colvis',
                    {
                        extend: 'excelHtml5',
                        text: "<i class='fs-14 pg-form'></i> Excel",
                        titleAttr: 'Excel',
                        sheetName: 'Aging Report',
                        className: 'btn-info',
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
                        title: "Aging Report",
                        //    message: "Delivery Express <br> System Developer M.Saim <br>  Pending Report<br>"
                    }
                ], order:[3],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // converting to interger to find total
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var formatter = new Intl.NumberFormat('en-US');


                    for (let index = 3; index < total_dc_row; index++) {
                        $(api.column(index).footer()).html(api.column(index).data().reduce(function(a, b) {
                            var c = intVal(a) + intVal(b);
                            return formatter.format(c)

                        }, 0));
                    }


                },

            });
        });
    </script>