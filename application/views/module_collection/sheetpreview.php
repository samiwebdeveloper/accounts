<?php
error_reporting(0);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $sheet_code; ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
    <style>
        @page {
            margin-left: 0.25in;
            margin-right: 0.25in;
            margin-top: 0.5in;
            margin-bottom: 0.5in;

            size: 8.3in 11.7in;
        }

        body {
            background: #fff;
        }

        table.report-container {
            page-break-after: always;
        }

        thead.report-header {
            display: table-header-group;
        }

        tfoot.report-footer {
            display: table-footer-group;
        }

        .table td,
        .table th {
            padding-top: 0.15rem !important;
            padding-right: 0.25rem !important;
            padding-bottom: 0.15rem !important;
            padding-left: 0.25rem !important;
        }

        .barcode {
            font-family: 'Libre Barcode 39 Text', cursive;
            font-size: 40px !important;
            color: #000 !important;
            line-height: 40px;
        }

        .pagebrake {
            page-break-after: always !important;
        }
    </style>
</head>

<body>
    <center>
        <table class="report-container">
            <thead class="report-header">
                <tr>
                    <th class="report-header-cell">
                        <div class="header-info">
                            <table width="100%">
                                <tr>
                                    <td class="text-center">
                                        <p class="font-montserrat" style="font-size: 1.25rem;font-weight: bolder;"><img src="<?php echo base_url(); ?>assets/img/logo12.png" height="75">                                            
                                            
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <h2>COD COLLECTION SHEET</h2>
                                        <p style="font-size: 1.25rem;"><?php echo strtoupper($sheet[0]->city_full_name); ?></p>
                                    </td>
                                    <td class="text-right">
                                        <p class="barcode"><?php echo "*" . $sheet[0]->cod_sheet_no . "*"; ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </th>
                </tr>
            </thead>
            <tfoot class="report-footer">
                <tr>
                    <td class="report-footer-cell">
                        <div class="footer-info">
                            <table width="100%">
                                <tr>
                                    <th class="text-left">
                                        <?php echo $sheet[0]->created_at; ?>
                                    </th>
                                    <th class="text-center">
                                        <?php echo $sheet[0]->oper_user_name; ?>
                                    </th>
                                    <th class="text-right">
                                        <?php echo $sheet[0]->cod_sheet_no; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="3">
                                        <hr>
                                        <center>
                                            <p style="margin-bottom: 0px;">Head Office : M-23, Madar-e-Millat Road, Quaid e Azam Industrial Estate, Lahore.</p>
                                            <p style="margin-bottom: 0px;">+92 (42) 3511 5300 &#8226; +92 309 777 7228 &#8226; info@tmcargo.net &#8226; www.tmcargo.net</p>
                                        </center>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </tfoot>
            <tbody class="report-content">
                <tr>
                    <td class="report-content-cell">
                        <table class="table table-striped text-center" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Order #</th>
                                    <th>CN</th>
                                    <th>Delivery #</th>
                                    <th>Date</th>
                                    <th>Origin</th>
                                    <th>Shipper</th>
                                    <th>Destination</th>
                                    <th>Consignee</th>
                                    <th>Pcs</th>
                                    <th>Weight</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>FOD</th>
                                    <th>Collection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cns_collect)) {

                                    foreach ($cns_collect as $rows) {
                                        $i = $i + 1;
                                ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $rows->order_code; ?></td>
                                            <td><?php echo $rows->manual_cn; ?></td>
                                            <td><?php echo $rows->on_route_id; ?></td>
                                            <td><?php echo $rows->on_route_date; ?></td>
                                            <td><?php echo $rows->origin_city_name; ?></td>
                                            <td><?php echo $rows->shipper_name; ?></td>
                                            <td><?php echo $rows->destination_city_name; ?></td>
                                            <td><?php echo $rows->consignee_name; ?></td>
                                            <td><?php echo $rows->pieces; ?></td>
                                            <td><?php echo $rows->weight; ?></td>
                                            <td><?php echo $rows->product_detail; ?></td>
                                            <td><?php echo $rows->order_status; ?></td>
                                            <td><?php echo $rows->cod_amount; ?></td>
                                            <td><b><?php echo $rows->collection; ?></b></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
                <tr>                    
                    <td class="report-content-cell">
                        <div class="row">
                            <div class="col-6">
                                <!--<table class="table table-striped" width="100%">
                                    <tr>
                                        <th>Denominations</th>
                                        <th>Count</th>
                                        <th>Coins</th>
                                        <th>Count</th>
                                    </tr>
                                    <tr>
                                        <td>5,000 x</td>
                                        <td></td>
                                        <td>5 x</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>1,000 x</td>
                                        <td></td>
                                        <td>2 x</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>500 x</td>
                                        <td></td>
                                        <td>1 x</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>100 x</td>
                                        <td></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>50 x</td>
                                        <td></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>10 x</td>
                                        <td></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>-->
                            </div>
                            <div class="col-6">
                                <table class="table table-striped" width="100%">
                                    <tr>
                                        <th>Sheet No:</th>
                                        <td><?php echo $sheet[0]->cod_sheet_no; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total CN:</th>
                                        <td><?php echo $sheet[0]->total_cns; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Collection:</th>
                                        <td><?php echo "Rs. " . $sheet[0]->total_amt . "/-"; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Submitted To:</th>
                                        <td><?php echo $sheet[0]->submit_to; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Remarks:</th>
                                        <td><?php echo $sheet[0]->remarks; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>