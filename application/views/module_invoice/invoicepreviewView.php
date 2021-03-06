<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<?php
$sheet_code = "";
$sheet_date = "";
$sheet_customer_name = "";
$sheet_type = "";
$sheet_payment = "";
$sheet_tid = "";
$total_fuel = "";
$total_sc = "";
$total_gst = "";
$total_faf = "";
$sheet_id = "";
$other_amount = "";
$remark = "";
$others = "";
$fuel = "";
$osa = "";
$faf = "";
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
		$t_others				= $rows->invoice_others;
		$t_fuel					= $rows->invoice_fuel;
		$t_faf					= $rows->invoice_faf;
		$t_osa					= $rows->invoice_osa;
		$c_gst                  = ($rows->gsst * 100);
		$c_fuel                 = ($rows->fuel_surcharge * 100);
		$c_others               = ($rows->others_charges * 100);
		$c_faf               	= ($rows->faf * 100);
	}
} ?>
<style type="text/css">
	@media print {
		body {
			background: #fff;
		}
	}

	@media print {

		@page {
			margin-left: 0.75in;
			margin-right: 0.75in;
			margin-top: 2in;
			margin-bottom: 1.25in;
		}
	}

	@media print {
		.pagebrake {
			page-break-before: always;
		}
	}

	.table tbody tr td {
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #000;
		padding: 4px;
		font-size: 16px;

	}

	.table tbody tr th {
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #000;

		border-top-width: 1px;
		border-top-style: solid;
		border-top-color: #000;

		padding: 6px;
		font-size: 16px;
	}
</style>

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
	<!-- START PAGE CONTENT -->
	<div class="content">
		<!-- START JUMBOTRON -->
		<!-- END JUMBOTRON -->
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid  container-fixed-lg bg-gray">
						<div class="row">
							<div class="card card-default m-t-10">
								<br>
								<br>
								<?php function AmountInWords(float $amount)
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

								<div class="card-body">
									<div class="invoice padding-10 sm-padding-5">
										<div class="col-12">
											<div class="row">
												<div class="col-4">
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
														<?php if (strlen($sheet_customer_ntn) > 1) { ?>
															<tr>
																<th>NTN:</th>
																<td><?php echo $sheet_customer_ntn; ?></td>
															</tr>
														<?php } ?>
														<?php if (strlen($sheet_customer_cnic) > 1) { ?>
															<tr>
																<th>CNIC:</th>
																<td><?php echo $sheet_customer_cnic; ?></td>
															</tr>
														<?php } ?>
													</table>
												</div>
												<div class="col-4">
													<?php $date = date_create($sheet_date); ?>
													<table width="65%" align="center">
														<tr>
															<th>No:</th>
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
													</table>
												</div>
												<div class="col-4 text-right">

													<?php if ($sheet_type == 1) { ?>
														<!----<img width="235" height="155" alt="" class="invoice-logo" data-src-retina="<?php echo base_url(); ?>assets/gst.png" data-src="<?php echo base_url(); ?>assets/gst.png" src="<?php echo base_url(); ?>assets/gst.png">-->

													<?php } else { ?>
														<!----<img width="235" height="155" alt="" class="invoice-logo" data-src-retina="<?php echo base_url(); ?>assets/gst.png" data-src="<?php echo base_url(); ?>assets/not_gst.png" src="<?php echo base_url(); ?>assets/not_gst.png">-->


													<?php } ?>


													<?php if ($c_gst > 0) { ?>
														<h4 class="font-montserrat">T.M Cargo & Logistics</h4>
														<h5 class="font-montserrat">NTN: 7900821-0 </h5>
													<?php } else { ?>
														<h2 class="font-montserrat">T.M Cargo Services</h2>
													<?php } ?>
													<img src="<?php echo base_url(); ?>assets/barcode/invoice/<?php echo $sheet_code; ?>.png">
												</div>
											</div>
										</div>
										<!--<p style="font-size:20px; padding-left:17px; padding-top:20px; margin-bottom:-15px;"><b>Statement of Account</b></p>-->
										<div class="col-10 m-t-40">
											<table class="m-t-10 table table-striped">
												<tr>
													<th>Head</th>
													<th>Charges</th>
												</tr>
												<tr>
													<td>Service Charges</td>
													<td><?php echo number_format($total_sc); ?></td>
												</tr>
												<?php if ($t_osa > 0 || $total_osa_sd > 0) { ?>
													<tr>
														<td>OSA | SD Charges</td>
														<td><?php echo number_format($t_osa + $total_osa_sd); ?></td>
													</tr>
												<?php } ?>

												<?php if ($t_others > 0 || $other_amount > 0) { ?>
													<tr>
														<?php if ($other_name == "") { ?>
															<td>Others</td>
															<td><?php echo number_format($t_others); ?></td>
														<?php } else { ?>
															<td><?php echo $other_name; ?></td>
															<td><?php echo number_format($t_others + $other_amount); ?></td>
														<?php } ?>
													</tr>
												<?php } ?>

												<?php if ($t_fuel > 0 || $total_fuel > 0) { ?>
													<tr>
														<td>Fuel Surcharge</td>
														<td><?php echo number_format($t_fuel + $total_fuel); ?></td>
													</tr>
												<?php } ?>

												<?php if ($t_faf > 0) { ?>
													<tr>
														<td>F.A.F</td>
														<td><?php echo number_format($t_faf); ?></td>
													</tr>
												<?php } ?>

												<!--<tr>
															<td>Insurance Premium</td>
															<td>0</td>
														</tr>-->

												<?php if ($discounSSt_amount != 0) { ?>
													<tr>
														<td>Discount Amount</td>
														<td><?php echo number_format($discounSSt_amount); ?></td>
													</tr>
												<?php } ?>
												<?php if ($total_gst != 0) { ?>
													<tr>
														<td>G.S.T</td>
														<?php if ($sheet_type == 1) { ?>
															<td><?php echo number_format($total_gst); ?></td>
														<?php } else { ?>
															<td> <?php echo number_format(0); ?></td>
														<?php } ?>
													</tr>
												<?php } ?>
												
												<?php
												    $total_net = $sheet_type == 1 ? round(($total_sc + $total_osa_sd + $total_gst + $total_fuel + $other_amount + $t_fuel + $t_others + $t_osa + $t_faf) - $discounSSt_amount) : round(($total_sc + $total_osa_sd + $total_fuel + $other_amount + $t_fuel + $t_others + $t_osa + $t_faf) - $discounSSt_amount);
												?>

												<tr>
													<td>Net Amount</td>
													<td><?php echo "PKR " . number_format($total_net); ?></td>
												</tr>
												<tr>
													<td>Amount in Words (PKR)</td>
													<td>
														<?php
														$get_amount = AmountInWords($total_net);
														echo "Rs. " . $get_amount . " only";
														?>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
										<div class="col-12 m-t-40">
											<hr>
											<p>Any discrepancy in the Invoice must be reported at cfo@tmcargo.net within 7 days upon receipt of the Invoice.</p>
											<p>Payment terms 7 days after receipt of Invoice.</p>
											<?php if (strlen($remark) > 0) { ?><p>Note:<?php echo $remark; ?></p><?php } ?>
											<!--<div class="m-t-40 text-center">
												<img src="<?php echo base_url(); ?>assets/may22.jpg" width="60%">
											</div>-->
										</div>
										<div class="pagebrake table-responsive">
											<center>
												<table width="80%">
													<tr>
														<th class="text-left"><?php echo $sheet_customer_name; ?></th>
														<th class="text-right"><?php echo $sheet_code; ?></th>
													</tr>
												</table>
												<!--<h5 class="semi-bold m-t-0"><span style="font-size: 12px; color:#575757;" ><b>Client Name: </b></span><?php echo $sheet_customer_name; ?></h5>
													<div class="font-montserrat bold all-caps">Invoice No : <?php echo $sheet_code; ?></div>-->
												<table class="table table-striped text-center">
													<tbody>
														<tr>
															<th>Sr</th>
															<th>Date</th>
															<th>CN No</th>
															<th>Origin</th>
															<th>Destination</th>
															<!--<th class="text-center" style="border:1px solid black">Conignee</th>-->
															<th>Pieces</th>
															<th>Weight</th>
															<th>Service</th>
															<!--<th class="text-center" style="border:1px solid black">Rate</th>-->
															<th>OSA|SD</th>
															<th>Others</th>
															<th>Fuel</th>
															<?php if ($total_gst != 0) { ?> <th>GST</th> <?php } ?>
															<th>Amount</th>
														</tr>
														<?php if (!empty($sheet_data)) {
															$total_wgt = 0;
															$total_pcs = 0;
															$t_osa = 0;
															$t_sd = 0;
															$t_oth = 0;
															$t_fuel = 0;
															$t_amt = 0;
															$i = 0;
															$j = 0;
															$page = 0;
															foreach ($sheet_data as $rows) {
																$i = $i + 1;
																$j = $j + 1;
																$total_wgt = $total_wgt + ceil($rows->weight);
																$total_pcs = $total_pcs + ceil($rows->pcs);
																$t_osa = $t_osa + $rows->osa;
																$t_sd = $t_sd + $rows->osa_sd;
																$t_oth = $t_oth + $rows->others;
																$t_fuel = $t_fuel + $rows->fuel;
																$t_amt = $t_amt + $rows->sc;
																$t_gst = $t_gst + $rows->gst;
														?>
																<tr>
																	<td><?php echo $i; ?></td>
																	<td><?php echo $rows->date; ?></td>
																	<td><?php if ($rows->manual_cn != "") {
																			echo $rows->manual_cn;
																		} else {
																			echo $rows->cn;
																		}; ?></td>
																	<td><?php echo $rows->origin; ?></td>
																	<td><?php echo $rows->destination_name; ?></td>
																	<!--<th class="text-center" style="border:1px solid black; width:14%"><?php echo $rows->consignee_detail; ?></th>-->
																	<td><?php echo $rows->pcs; ?></td>
																	<td><?php echo ceil($rows->weight); ?></td>
																	<?php if ($rows->serivce_name == "Over Night") { ?>
																		<td>O/N</td>
																	<?php } else if ($rows->serivce_name == "Over Land") { ?>
																		<td>OLE</td>
																	<?php } else if ($rows->serivce_name == "Detain") { ?>
																		<td>DTN</td>
																	<?php } else { ?>
																		<td>AF</td>
																	<?php }  ?>
																	<!--<th class="text-center" style="border:1px solid black; width:5%"><?php echo number_format($rows->rate); ?></th>-->
																	<td><?php echo number_format($rows->osa + $rows->osa_sd); ?></td>
																	<td><?php echo number_format($rows->others); ?></td>
																	<td><?php echo number_format($rows->fuel); ?></td>
																	<?php if ($total_gst != 0) { ?> <td><?php echo number_format($rows->gst); ?></th> <?php } ?>
																		<td><?php echo number_format($rows->sc); ?></td>
																</tr>
															<?php } ?>
															<tr>
																<!--<td style="border:1px solid black;background-color:white"></td>
																	<td style="border:1px solid black;background-color:white"></td>
																	<td style="border:1px solid black;background-color:white"></td>
																	<td style="border:1px solid black;background-color:white"></td>
																<td style="border:1px solid black;background-color:white"></td>-->
																<th colspan="5" class="text-right">Total</th>
																<th><?php echo number_format($total_pcs); ?></th>
																<th><?php echo number_format($total_wgt); ?></th>
																<!--<td style="border:1px solid black;background-color:white"></td>-->
																<th></th>
																<th><?php echo number_format($t_osa + $t_sd); ?></th>
																<th><?php echo number_format($t_oth); ?></th>
																<th><?php echo number_format($t_fuel); ?></th>
																<?php if ($total_gst != 0) { ?> <th><?php echo number_format($t_gst); ?></th> <?php } ?>
																<th><?php echo number_format($t_amt); ?></th>
															</tr>
														<?php } ?>
												</table>
										</div>
										</center>
										<!--<hr>
														<p class="small">Note: The Items and particulars of shipments on this statement must be verified and T.M Cargo notified of any discrepancy within 07 days hereof it would be considered true. </p>
													<p class="small">For complaints that remain unsolved beyond 10 days, you may send an email to cfo@tmcargo.net or call 042-111-862-862</p><br>-->

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
$this->load->view('inc/wfooter');
?>