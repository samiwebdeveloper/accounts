<?php
error_reporting(0);
$sheet_code = "";
$sheet_date = "";
$sheet_customer_name = "";
$sheet_type = "";
$sheet_payment = "";
$sheet_tid = "";
$total_fuel = "";
$total_sc = "";
$total_gst = "";
$sheet_id = "";
$other_amount = "";
$remark = "";
$others = "";
$fuel = "";
$osa = "";
$t_crn_pcs = 0;
$t_crn_weight = 0;
$t_crn_sc = 0;
$t_crn_osa_sd = 0;
$t_crn_osa = 0;
$t_crn_fuel = 0;
$t_crn_others = 0;
$t_crn_gst = 0;
$t_crn_faf = 0;
$t_fod = 0;
$crn_net = 0;
$t_db_pcs = 0;
$t_db_weight = 0;
$t_db_sc = 0;
$t_db_osa_sd = 0;
$t_db_osa = 0;
$t_db_fuel = 0;
$t_db_others = 0;
$t_db_gst = 0;
$t_db_faf = 0;
$tdb__fod = 0;
$db_net = 0;
if (!empty($sheet_data)) {
    foreach ($sheet_data as $rows) {
        $sheet_code             = $rows->invoice_code;
        $other_name             = $rows->other_name;
        $other_amount           = $rows->other_amount;
        $customer_account_no    = $rows->customer_account_no;
        $sheet_id               = $rows->invoice_id;
        $sheet_date             = $rows->invoice_date;
        $cn_date                = $rows->cn_date;
        $origin                 = $rows->city_name;
        $sheet_customer_name    = $rows->customer_name;
        $sheet_customer_address = $rows->customer_address;
        $sheet_customer_ntn     = $rows->customer_ntn;
        $sheet_customer_cnic     = $rows->customer_cnic;
        $sheet_customer_note    = $rows->customer_note;
        $sheet_type             = $rows->invoice_permission;
        $sheet_payment          = $rows->payment_mode;
        $sheet_tid              = $rows->payment_tid;
        $total_sc               = $rows->invoice_sc;
        $total_osa_sd           = $rows->invoice_osa_sd_total;
        $total_gst              = $rows->invoice_gst;
        $total_fuel             = $rows->fuel_surcharge;
        $discounSSt_amount      = $rows->DC;
        $remark                 = $rows->invoice_remark;
        $t_others               = $rows->invoice_others;
        $t_fuel                 = $rows->invoice_fuel;
        $t_faf                  = $rows->invoice_faf;
        $total_osa              = $rows->invoice_osa;
        $c_gst                  = ($rows->gsst * 100);
        $c_fuel                 = ($rows->fuel_surcharge * 100);
        $c_others               = ($rows->others_charges * 100);
        $c_faf                  = ($rows->faf * 100);
        $invoice_fod            = $rows->invoice_fod;
    }
}
/*if (!empty($cr_data)) {
    foreach ($cr_data as $cr) {
        $crn_cn = $cr->crn_cn;
        $crn_manual_cn = $cr->crn_manual_cn;
        $crn_origin = $cr->crn_origin;
        $crn_destination = $cr->crn_destination;
        $crn_consignee = $cr->crn_consignee;
        $crn_pcs = $cr->crn_pcs;
        $crn_weight = $cr->crn_weight;
        $crn_sc = $cr->crn_sc;
        $crn_osa_sd = $cr->crn_osa_sd;
        $crn_osa = $cr->crn_osa;
        $crn_fuel = $cr->crn_fuel;
        $crn_others = $cr->crn_others;
        $crn_gst = $cr->crn_gst;
        $crn_faf = $cr->crn_faf;
        $fod = $cr->fod;
        $crn_serivce_name = $cr->crn_serivce_name;
    }
}*/
if (!empty($cr_data)) {
    foreach ($cr_data as $cr) {
        $t_crn_pcs += $cr->crn_pcs;
        $t_crn_weight += $cr->crn_weight;
        $t_crn_sc += $cr->crn_sc;
        $t_crn_osa_sd += $cr->crn_osa_sd;
        $t_crn_osa += $cr->crn_osa;
        $t_crn_fuel += $cr->crn_fuel;
        $t_crn_others += $cr->crn_others;
        $t_crn_gst += $cr->crn_gst;
        $t_crn_faf += $cr->crn_faf;
        $t_crn_fod += $cr->fod;
    }
    $crn_net = ($t_crn_sc + $t_crn_osa_sd + $t_crn_osa + $t_crn_fuel + $t_crn_others + $t_crn_gst + $t_crn_faf) - $t_crn_fod;
}
if (!empty($deb_data)) {
    foreach ($deb_data as $db) {
        $t_db_pcs += $db->debit_pcs;
        $t_db_weight += $db->debit_weight;
        $t_db_sc += $db->debit_sc;
        $t_db_osa_sd += $db->debit_osa_sd;
        $t_db_osa += $db->debit_osa;
        $t_db_fuel += $db->debit_fuel;
        $t_db_others += $db->debit_others;
        $t_db_gst += $db->debit_gst;
        $t_db_faf += $db->debit_faf;
        $t_db_fod += $db->cod_amount;
    }
    $db_net = ($t_db_sc + $t_db_osa_sd + $t_db_osa + $t_db_fuel + $t_db_others + $t_db_gst + $t_db_faf) - $t_db_fod;
}
function AmountInWords(float $amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
														' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
														' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
												" . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
    return ($implode_to_Rupees ? $implode_to_Rupees . '' : '') . $get_paise;
}
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
            margin-left: 0.5in;
            margin-right: 0.5in;
            margin-top: 0.70in;
            margin-bottom: 0.5in;
            size: 8.3in 11in;
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
            page-break-before: always !important;
        }
    </style>
</head>

<body>
    <center>
        <table class="report-container" width="99%">
            <thead class="report-header">
                <tr>
                    <th class="report-header-cell">
                        <div class="header-info">
                            <table width="100%">
                                <tr>
                                    <td class="text-left">
                                        <p class="barcode"><?php echo "*" . $sheet_code . "*"; ?></p>
                                    </td>
                                    <td>
                                        <!--<p class="font-montserrat" style="font-size: 2rem;font-weight: bolder;"><img src="<?php echo base_url(); ?>assets/img/logo12.png" width="170" height="80">
                                            <?php if ($c_gst > 0) { ?>
                                                LOGISTICS
                                            <?php } else { ?>
                                                SERVICES
                                            <?php } ?>
                                        </p>-->
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
                                        <?php echo $sheet_customer_name; ?>
                                    </th>
                                    <td>
                                        <center>It is a system-generated invoice and doesn't need any signature or stamp.</center>
                                    </td>
                                    <th class="text-right">
                                        <?php echo $sheet_code; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="3">
                                        <hr>
                                        <center>
                                            <p style="margin-bottom: 0px;">Head Office : M-23, Madar-e-Millat Road, Quaid-e-Azam Industrial Estate, Lahore.</p>
                                            <p style="margin-bottom: 0px;"><?php if ($total_gst > 0) { ?>NTN: 7900821-0 &#8226; <?php } else { ?>NTN: 1354205-2 &#8226; <?php } ?>+92 (42) 3511 5300 &#8226; +92 309 777 7228 &#8226; info@tmcargo.net &#8226; www.tmcargo.net</p>
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
                        <!--<p style="margin-top: 1em;">&nbsp;</p>-->
                        <div class="row">
                            <div class="col-6">
                                <table width="100%">
                                    <tr>
                                        <th>Account No:</th>
                                        <td><?php echo $customer_account_no; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo $sheet_customer_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td><?php echo $sheet_customer_address; ?></td>
                                    </tr>
                                    <?php if ((strlen($sheet_customer_ntn) > 1) || ($sheet_customer_ntn <> 'NIL')) { ?>
                                        <tr>
                                            <th>NTN:</th>
                                            <td><?php echo $sheet_customer_ntn; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ((strlen($sheet_customer_cnic) > 1) || ($sheet_customer_cnic <> 'NIL')) { ?>
                                        <tr>
                                            <th>CNIC:</th>
                                            <td><?php echo $sheet_customer_cnic; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-6">
                                <?php $date = date_create($sheet_date); ?>
                                <table width="100%">
                                    <tr>
                                        <th>Invoice No:</th>
                                        <td><?php echo $sheet_code; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date:</th>
                                        <td><?php echo date_format($date, "M-d-Y"); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Month:</th>
                                        <td><?php echo $rows->Month; ?>-<?php echo $rows->Year; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Origin:</th>
                                        <td><?php echo ucwords($_SESSION['origin_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Due Date:</th>
                                        <td><?php echo date_format($date->modify('+9 days'), "M-d-Y"); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center" style="margin-top: 2.5rem;">
                                <center>
                                    <h2>Invoice Summary</h2>
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Head</th>
                                                <th>Charges</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Service Charges</td>
                                                <td><?php echo number_format($total_sc - $t_crn_sc, 2); ?></td>
                                            </tr>
                                            <?php if ($total_osa > 0 || $total_osa_sd > 0) { ?>
                                                <tr>
                                                    <td>OSA | SD Charges</td>
                                                    <td><?php echo number_format(($total_osa + $total_osa_sd) - ($t_crn_osa_sd + $t_crn_osa) + ($t_db_osa_sd + $t_db_osa), 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($t_others > 0 || $other_amount > 0) { ?>
                                                <tr>
                                                    <?php if ($other_name == "") { ?>
                                                        <td>Others</td>
                                                        <td><?php echo number_format($other_amount - $t_crn_others + $t_db_others, 2); ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo $other_name; ?></td>
                                                        <td><?php echo number_format(($t_others + $other_amount) - $t_crn_others + $t_db_others, 2); ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($t_fuel > 0 || $total_fuel > 0) { ?>
                                                <tr>
                                                    <td>Fuel Surcharge</td>
                                                    <td><?php echo number_format(($t_fuel + $total_fuel) - $t_crn_fuel + $t_db_fuel, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($t_faf > 0) { ?>
                                                <tr>
                                                    <td>F.A.F</td>
                                                    <td><?php echo number_format($t_faf - $t_crn_faf + $t_db_faf, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($discounSSt_amount != 0) { ?>
                                                <tr>
                                                    <td>Discount Amount</td>
                                                    <td><?php echo number_format($discounSSt_amount, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($invoice_fod != 0) { ?>
                                                <tr>
                                                    <td>FOD</td>
                                                    <td><?php echo number_format($invoice_fod - $t_crn_fod + $t_db_fod, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($total_gst != 0) { ?>
                                                <tr>
                                                    <td>G.S.T</td>
                                                    <?php if ($sheet_type == 1) { ?>
                                                        <td><?php echo number_format($total_gst - $t_crn_gst + $t_db_gst, 2); ?></td>
                                                    <?php } else { ?>
                                                        <td> <?php echo number_format(0); ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            <?php
                                            $total_net = $sheet_type == 1 ? round(($total_sc + $total_osa_sd + $total_gst + $total_fuel + $other_amount + $t_fuel + $t_others + $total_osa + $t_faf + $db_net) - ($discounSSt_amount + $invoice_fod + $crn_net)) : round(($total_sc + $total_osa_sd + $total_fuel + $other_amount + $t_fuel + $t_others + $total_osa + $t_faf + $db_net) - ($discounSSt_amount + $invoice_fod + $crn_net));
                                            ?>
                                            <tr>
                                                <td>Net Amount</td>
                                                <td><?php echo "PKR " . number_format($total_net); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Amount in Pak Rupees</td>
                                                <td>
                                                    <?php
                                                    $get_amount = AmountInWords(abs($total_net));
                                                    echo $get_amount . "Rupees only.";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Consignments</td>
                                                <td><?php echo number_format(count($sheet_data) - count($cr_data) + count($deb_data)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <p>Any discrepancy in the Invoice must be reported at cfo@tmcargo.net</p>
                                <!--<center><img src="<?php echo base_url(); ?>assets/may22.jpg" width="60%"></center>-->
                                <?php if (strlen($remark) > 0) { ?><div><b>Note:</b> <?php echo $remark; ?></div><?php } ?>
                                <div class="pagebrake">&nbsp;</div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="m-10">Consignment Details:</h4>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped text-center pagebrake" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Date</th>
                                            <th>CN No</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Consignee</th>
                                            <th>Pieces</th>
                                            <th>Weight</th>
                                            <th>Service</th>
                                            <?php if ($total_osa + $total_osa_sd > 0) { ?> <th>OSA|SD</th> <?php } ?>
                                            <?php if ($t_others > 0) { ?> <th>Others</th> <?php } ?>
                                            <?php if ($invoice_fod != 0) { ?> <th>FOD</th> <?php } ?>
                                            <?php if ($total_gst != 0) { ?> <th>GST</th> <?php } ?>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sheet_data)) {
                                            $total_wgt = 0;
                                            $total_pcs = 0;
                                            $t_osa = 0;
                                            $t_sd = 0;
                                            $t_oth = 0;
                                            $t_fuel = 0;
                                            $t_amt = 0;
                                            $t_fod = 0;
                                            $i = 0;
                                            $j = 0;
                                            $page = 0;
                                            foreach ($sheet_data as $rows) {
                                                $i = $i + 1;
                                                $j = $j + 1;
                                                $total_wgt = $total_wgt + ceil($rows->weight);
                                                $total_pcs = $total_pcs + $rows->pcs;
                                                $t_osa = $t_osa + $rows->osa;
                                                $t_sd = $t_sd + $rows->osa_sd;
                                                $t_oth = $t_oth + $rows->others;
                                                $t_fuel = $t_fuel + $rows->fuel;
                                                $t_amt = $t_amt + $rows->sc;
                                                $t_gst = $t_gst + $rows->gst;
                                                $t_fod = $t_fod + $rows->fod;
                                                $t_faf = $t_faf + $rows->faf;
                                        ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $rows->date; ?></td>
                                                    <td><?php if ($rows->manual_cn != "") {
                                                            echo $rows->manual_cn;
                                                        } else {
                                                            echo $rows->cn;
                                                        }; ?></td>
                                                    <td class="text-left"><?php echo $rows->origin; ?></td>
                                                    <td class="text-left"><?php echo $rows->destination_name; ?></td>
                                                    <td class="text-left"><?php echo ucwords(strtolower($rows->consignee_detail)); ?></td>
                                                    <td><?php echo $rows->pcs; ?></td>
                                                    <td><?php echo ceil($rows->weight); ?></td>
                                                    <?php if ($rows->serivce_name == "Over Night") { ?>
                                                        <td>ONT</td>
                                                    <?php } else if ($rows->serivce_name == "Over Land") { ?>
                                                        <td>OVL</td>
                                                    <?php } else if ($rows->serivce_name == "Detain") { ?>
                                                        <td>DET</td>
                                                    <?php } else if ($rows->serivce_name == "Air Frieght") { ?>
                                                        <td>AF</td>
                                                    <?php } else if ($rows->serivce_name == "Per Piece Movement") { ?>
                                                        <td>PPM</td>
                                                    <?php } else { ?>
                                                        <td>WH</td>
                                                    <?php }  ?>
                                                    <?php if (($total_osa + $total_osa_sd) != 0) { ?><td><?php echo number_format(($rows->osa + $rows->osa_sd), 2); ?></td><?php } ?>
                                                    <?php if ($t_others != 0) { ?><td><?php echo number_format($rows->others, 2); ?></td><?php } ?>
                                                    <?php if ($invoice_fod != 0) { ?> <td><?php echo number_format($rows->fod, 2); ?></td><?php } ?>
                                                    <?php if ($total_gst != 0) { ?> <td><?php echo number_format($rows->gst, 2); ?></td><?php } ?>
                                                    <td><?php echo number_format($rows->sc, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th></th>
                                                <th colspan="5" class="text-right">Sub Total</th>
                                                <th><?php echo number_format($total_pcs); ?></th>
                                                <th><?php echo number_format($total_wgt, 2); ?></th>
                                                <th></th>
                                                <?php if (($total_osa + $total_osa_sd) != 0) { ?><th><?php echo number_format(($total_osa + $total_osa_sd), 2); ?></th><?php } ?>
                                                <?php if ($t_others != 0) { ?><th><?php echo number_format($t_oth, 2); ?></th><?php } ?>
                                                <?php if ($invoice_fod != 0) { ?> <th><?php echo number_format($t_fod, 2); ?></th> <?php } ?>
                                                <?php if ($total_gst != 0) { ?> <th><?php echo number_format($t_gst, 2); ?></th> <?php } ?>
                                                <th><?php echo number_format($t_amt, 2); ?></th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php if (!empty($cr_data)) { ?>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-10">Credit Note:</h4>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped text-center pagebrake" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Date</th>
                                                <th>CN No</th>
                                                <th>Origin</th>
                                                <th>Destination</th>
                                                <th>Consignee</th>
                                                <th>Pieces</th>
                                                <th>Weight</th>
                                                <th>Service</th>
                                                <?php if ($t_crn_osa  + $t_crn_osa_sd  > 0) { ?> <th>OSA|SD</th> <?php } ?>
                                                <?php if ($t_others > 0) { ?> <th>Others</th> <?php } ?>
                                                <?php if ($t_crn_fod != 0) { ?> <th>FOD</th> <?php } ?>
                                                <?php if ($total_gst != 0) { ?> <th>GST</th> <?php } ?>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($cr_data)) {
                                                $i = 0;
                                                $j = 0;
                                                $page = 0;
                                                foreach ($cr_data as $rows) {
                                                    $i = $i + 1;
                                                    $j = $j + 1;
                                            ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $rows->cn_date; ?></td>
                                                        <td><?php if ($rows->crn_manual_cn != "") {
                                                                echo $rows->crn_manual_cn;
                                                            } else {
                                                                echo $rows->crn_cn;
                                                            }; ?></td>
                                                        <td class="text-left"><?php echo $rows->crn_origin; ?></td>
                                                        <td class="text-left"><?php echo $rows->crn_destination; ?></td>
                                                        <td class="text-left"><?php echo ucwords(strtolower($rows->crn_consignee)); ?></td>
                                                        <td><?php echo $rows->crn_pcs; ?></td>
                                                        <td><?php echo ceil($rows->crn_weight); ?></td>
                                                        <?php if ($rows->crn_serivce_name == "Over Night") { ?>
                                                            <td>ONT</td>
                                                        <?php } else if ($rows->crn_serivce_name == "Over Land") { ?>
                                                            <td>OVL</td>
                                                        <?php } else if ($rows->crn_serivce_name == "Detain") { ?>
                                                            <td>DET</td>
                                                        <?php } else if ($rows->crn_serivce_name == "Air Frieght") { ?>
                                                            <td>AF</td>
                                                        <?php } else if ($rows->crn_serivce_name == "Per Piece Movement") { ?>
                                                            <td>PPM</td>
                                                        <?php } else { ?>
                                                            <td>WH</td>
                                                        <?php }  ?>
                                                        <?php if (($t_crn_osa  + $t_crn_osa_sd) != 0) { ?><td><?php echo number_format(($rows->crn_osa + $rows->crn_osa_sd), 2); ?></td><?php } ?>
                                                        <?php if ($t_crn_others != 0) { ?><td><?php echo number_format($rows->crn_others, 2); ?></td><?php } ?>
                                                        <?php if ($t_crn_fod != 0) { ?> <td><?php echo number_format($rows->fod, 2); ?></td><?php } ?>
                                                        <?php if ($t_crn_gst != 0) { ?> <td><?php echo number_format($rows->crn_gst, 2); ?></td><?php } ?>
                                                        <td><?php echo number_format($rows->crn_sc, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="6" class="text-right">Sub Total</th>
                                                    <th><?php echo "(" . number_format($t_crn_pcs) . ")"; ?></th>
                                                    <th><?php echo "(" . number_format($t_crn_weight, 2) . ")"; ?></th>
                                                    <th></th>
                                                    <?php if (($t_crn_osa_sd + $t_crn_osa) != 0) { ?><th><?php echo "(" . number_format(($t_crn_osa + $t_crn_osa), 2) . ")"; ?></th><?php } ?>
                                                    <?php if ($t_crn_others  != 0) { ?><th><?php echo "(" . number_format($t_crn_others, 2) . ")"; ?></th><?php } ?>
                                                    <?php if ($t_crn_fod  != 0) { ?> <th><?php echo "(" . number_format($t_crn_fod, 2) . ")"; ?></th> <?php } ?>
                                                    <?php if ($t_crn_gst  != 0) { ?> <th><?php echo "(" . number_format($t_crn_gst, 2) . ")"; ?></th> <?php } ?>
                                                    <th><?php echo "(" . number_format($t_crn_sc, 2) . ")"; ?></th>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (!empty($deb_data)) { ?>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-10">Debit Note:</h4>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped text-center pagebrake" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Date</th>
                                                <th>CN No</th>
                                                <th>Origin</th>
                                                <th>Destination</th>
                                                <th>Consignee</th>
                                                <th>Pieces</th>
                                                <th>Weight</th>
                                                <th>Service</th>
                                                <?php if ($t_db_osa  + $t_db_osa_sd  > 0) { ?> <th>OSA|SD</th> <?php } ?>
                                                <?php if ($t_others > 0) { ?> <th>Others</th> <?php } ?>
                                                <?php if ($t_db_fod != 0) { ?> <th>FOD</th> <?php } ?>
                                                <?php if ($total_gst != 0) { ?> <th>GST</th> <?php } ?>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($deb_data)) {
                                                $i = 0;
                                                $j = 0;
                                                $page = 0;
                                                foreach ($deb_data as $rows) {
                                                    $i = $i + 1;
                                                    $j = $j + 1;
                                            ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $rows->cn_date; ?></td>
                                                        <td><?php if ($rows->debit_manual_cn != "") {
                                                                echo $rows->debit_manual_cn;
                                                            } else {
                                                                echo $rows->debit_cn;
                                                            }; ?></td>
                                                        <td class="text-left"><?php echo $rows->debit_origin; ?></td>
                                                        <td class="text-left"><?php echo $rows->debit_destination; ?></td>
                                                        <td class="text-left"><?php echo ucwords(strtolower($rows->debit_consignee)); ?></td>
                                                        <td><?php echo $rows->debit_pcs; ?></td>
                                                        <td><?php echo ceil($rows->debit_weight); ?></td>
                                                        <?php if ($rows->debit_serivce_name == "Over Night") { ?>
                                                            <td>ONT</td>
                                                        <?php } else if ($rows->debit_serivce_name == "Over Land") { ?>
                                                            <td>OVL</td>
                                                        <?php } else if ($rows->debit_serivce_name == "Detain") { ?>
                                                            <td>DET</td>
                                                        <?php } else if ($rows->debit_serivce_name == "Air Frieght") { ?>
                                                            <td>AF</td>
                                                        <?php } else if ($rows->debit_serivce_name == "Per Piece Movement") { ?>
                                                            <td>PPM</td>
                                                        <?php } else { ?>
                                                            <td>WH</td>
                                                        <?php }  ?>
                                                        <?php if (($t_db_osa  + $t_db_osa_sd) != 0) { ?><td><?php echo number_format(($rows->debit_osa + $rows->debit_osa_sd), 2); ?></td><?php } ?>
                                                        <?php if ($t_db_others != 0) { ?><td><?php echo number_format($rows->debit_others, 2); ?></td><?php } ?>
                                                        <?php if ($t_db_fod != 0) { ?> <td><?php echo number_format($rows->cod_amount, 2); ?></td><?php } ?>
                                                        <?php if ($t_db_gst != 0) { ?> <td><?php echo number_format($rows->debit_gst, 2); ?></td><?php } ?>
                                                        <td><?php echo number_format($rows->debit_sc, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="6" class="text-right">Sub Total</th>
                                                    <th><?php echo number_format($t_db_pcs); ?></th>
                                                    <th><?php echo number_format($t_db_weight, 2); ?></th>
                                                    <th></th>
                                                    <?php if (($t_db_osa_sd + $t_db_osa) != 0) { ?><th><?php echo number_format(($t_db_osa + $t_db_osa), 2); ?></th><?php } ?>
                                                    <?php if ($t_db_others  != 0) { ?><th><?php echo number_format($t_db_others, 2); ?></th><?php } ?>
                                                    <?php if ($t_db_fod  != 0) { ?> <th><?php echo number_format($t_db_fod, 2); ?></th> <?php } ?>
                                                    <?php if ($t_db_gst  != 0) { ?> <th><?php echo number_format($t_db_gst, 2); ?></th> <?php } ?>
                                                    <th><?php echo number_format($t_db_sc, 2); ?></th>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <h4>Grand Totals:</h4>
                                <table class="table table-striped" width="98%">
                                    <tbody>
                                        <tr>
                                            <td>Service Charges</td>
                                            <th class="text-right"><?php echo number_format($total_sc - $t_crn_sc + $t_db_sc, 2); ?></th>
                                        </tr>
                                        <?php if ($total_osa > 0 || $total_osa_sd > 0) { ?>
                                            <tr>
                                                <td>OSA | SD Charges</td>
                                                <td class="text-right"><?php echo number_format(($total_osa + $total_osa_sd) - ($t_crn_osa_sd + $t_crn_osa) + ($t_db_osa_sd + $t_db_osa), 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($t_others > 0 || $other_amount > 0) { ?>
                                            <tr>
                                                <?php if ($other_name == "") { ?>
                                                    <td>Others</td>
                                                    <td class="text-right"><?php echo number_format($other_amount - $t_crn_others + $t_db_others, 2); ?></td>
                                                <?php } else { ?>
                                                    <td><?php echo $other_name; ?></td>
                                                    <td class="text-right"><?php echo number_format(($t_others + $other_amount) - $t_crn_others + $t_db_others, 2); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($t_fuel > 0 || $total_fuel > 0) { ?>
                                            <tr>
                                                <td>Fuel Surcharge</td>
                                                <td class="text-right"><?php echo number_format(($t_fuel + $total_fuel) - $t_crn_fuel + $t_db_fuel, 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($t_faf > 0) { ?>
                                            <tr>
                                                <td>F.A.F</td>
                                                <td class="text-right"><?php echo number_format($t_faf - $t_crn_faf + $t_db_faf, 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($discounSSt_amount != 0) { ?>
                                            <tr>
                                                <td>Discount Amount</td>
                                                <td class="text-right"><?php echo number_format($discounSSt_amount, 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($invoice_fod != 0) { ?>
                                            <tr>
                                                <td>FOD</td>
                                                <td class="text-right"><?php echo number_format($invoice_fod - $t_crn_fod + $t_db_fod, 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($total_gst != 0) { ?>
                                            <tr>
                                                <td>G.S.T</td>
                                                <?php if ($sheet_type == 1) { ?>
                                                    <td class="text-right"><?php echo number_format($total_gst - $t_crn_gst + $t_db_gst, 2); ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"> <?php echo number_format(0); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Net Amount</td>
                                            <th class="text-right"><?php echo "PKR " . number_format($total_net); ?></th>
                                        </tr>
                                    </tbody>
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