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
						<li class="breadcrumb-item">Accounts</li>
						<li class="breadcrumb-item">Manage Invoices</li>
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
										<div class="card-title"><a href="<?php echo base_url(); ?>Invoice/create_invoice" class='btn btn-primary'>New Invoice</a>
										</div>
										<div class="form-group-attached">
											<div class="row clearfix">
												<div class="col-sm-3">
													<div class="form-group form-group-default required" id="user_name_div">
														<form action="<?php echo base_url(); ?>Invoice/date_range" method="post">
															<label>Start Date</label>
															<input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php echo $startdate; ?>">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group form-group-default required">
														<label>End Date</label>
														<input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php echo $enddate; ?>">
													</div>
												</div>
												<div class="col-sm-3">
													<button type="submit" class="btn btn-primary" style="height:100%">GO</button>
													</form>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive m-t-10">
											<table class="table table-bordered nowrap" id="myTable" style="border-top:1px solid black ;">
												<thead>
													<th class="text-center">Action</th>
													<!-- <th>Deposit</th> -->
													<th>Origin</th>
													<th>Invoice Number</th>
													<th>CNs</th>
													<th>Customer Name</th>
													<th>Account #</th>
													<th class='bg-primary text-white text-center' style="box-shadow: 5px 10px #6d5eac;">Net Total</th>
													<th>Invoice Date</th>
													<th>SC</th>
													<th>OSA | SD</th>
													<th>GST</th>
													<th>Fuel</th>
													<th>FAF</th>
													<th>Others</th>
													<th>Discount</th>
													<th>Pieces</th>
													<th>Weight</th>
													<th>Sales Person</th>
													<th>Username</th>
													<?php if ($_SESSION['user_id'] == "74" or $_SESSION['user_id'] == "90") { ?>
														<th>Revert</th>
													<?php } ?>
												</thead>
												<tbody>
													<?php
													$i = 0;
													if (!empty($invoice_data)) {
														foreach ($invoice_data as $rows) {
															$i = $i + 1;
															echo ("<tr>");
															echo ("<td><a href='" . base_url() . "Invoice/view_invoice_sheet_v3/" . $rows->invoice_code . "' target='_blank' class='btn btn-primary btn-xs'>View V3</a>");
															echo "&nbsp; <a  href='" . base_url() . "Invoice/create_credit_note/" . $rows->invoice_code . "' class='btn btn-xs btn-primary'>Credit Note</a>";
															echo "&nbsp; <a  href='" . base_url() . "Invoice/create_debit_note/" . $rows->invoice_code . "' class='btn btn-xs btn-primary'>Debit Note</a>";
															//--------------------------
															if ($rows->is_payment == 0) {
																echo (" &nbsp;<a class=' btn btn-xs btn-primary edit_btn_" . $rows->invoice_code . "' data-toggle='modal' data-target='#edit_" . $rows->acc_invoice_id . "' href='javascript:void(0)'>Deposit</a></td>");
															} else {
																echo ($rows->payment_tid . "</td>");
															}
													?>
															<div class="modal fade stick-up" id="edit_<?php echo $rows->acc_invoice_id ?>">
																<div class="modal-dialog">
																	<div class="modal-dialog ">
																		<div class="modal-content-wrapper">
																			<div class="modal-content">
																				<div class="modal-header clearfix text-left">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
																					</button>
																					<h5>Update Payment Detail &nbsp;&nbsp;&nbsp;&nbsp;<span class="ml-5"> <b>[<?php echo $rows->invoice_code  ?>] </b></span></h5>
																				</div>
																				<div class="modal-body">
																					<form role="form">
																						<div class="form-group-attached">
																							<div class="row">
																								<div class="col-md-12">
																									<p class="msg_div2"></p>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-md-12">
																									<div class="form-group form-group-default required">
																										<label>Date</label>
																										<input type="datetime-local" class="form-control" name="datetime" id="datetime_<?php echo $rows->invoice_code ?>" value="<?php echo date('Y-m-d\TH:i') ?>">
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-md-7">
																									<div class="form-group form-group-default required">
																										<label>Instrument type</label>
																										<select name="payment_mode" id="insetrument_type_<?php echo $rows->invoice_code ?>" class="form-control payment_mode" style="width: 100%">
																											<option value="">Select Mode</option>
																											<option value='Cash'>Cash</option>
																											<option value='Cheque'>Cheque</option>
																										</select>
																									</div>
																								</div>
																								<div class="col-md-5">
																									<div class="form-group form-group-default ">
																										<label>Bank</label>
																										<select name="payment_mode" id="bank_type_<?php echo $rows->invoice_code ?>" class="form-control payment_mode" style="width: 100%">
																											<option value="">Select Bank</option>
																											<option value='UBL'>UBL</option>
																											<option value='FBL'>FBL</option>
																										</select>
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-md-7">
																									<div class="form-group form-group-default ">
																										<label>Instrument No</label>
																										<input type="text" class="form-control" name="insetrument_no" id="insetrument_no_<?php echo $rows->invoice_code ?>">
																									</div>
																								</div>
																								<div class="col-md-5">
																									<div class="form-group form-group-default required">
																										<label>Amount</label>
																										<input type="number" class="form-control" name="Amount" id="Amount_<?php echo $rows->invoice_code ?>">
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-md-7">
																									<div class="form-group form-group-default ">
																										<label>Sales Tax</label>
																										<input type="number" class="form-control" name="insetrument_no" id="sales_tax_<?php echo $rows->invoice_code ?>">
																									</div>
																								</div>
																								<div class="col-md-5">
																									<div class="form-group form-group-default ">
																										<label>Income  Tax</label>
																										<input type="number" class="form-control" name="Amount" id="income_tax_<?php echo $rows->invoice_code ?>">
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-md-12">
																									<div class="form-group form-group-default">
																										<label>Remarks</label>
																										<textarea id="mang_des_<?php echo $rows->invoice_code ?>" name="mang_des" class="form-control " style=" height:60px;min-height:50px; max-height:80px;"></textarea>
																									</div>
																								</div>
																							</div>
																						</div>
																					</form>
																					<div class="row">
																						<div class="col-md-8">
																						</div>
																						<div class="col-md-4 m-t-10 sm-m-t-10">
																							<button type="button" class="btn btn-primary btn-block m-t-5" id="save_<?php echo $rows->invoice_code ?>">Save</button>
																						</div>
																						<script>
																							$("#save_<?php echo $rows->invoice_code ?>").click(function() {
																								$(".msg_div2").html("")
																								var insetrument_type = $("#insetrument_type_<?php echo $rows->invoice_code ?>").val();
																								var insetrument_no = $("#insetrument_no_<?php echo $rows->invoice_code ?>").val();
																								var Amount = $("#Amount_<?php echo $rows->invoice_code ?>").val();
																								var datetime = $("#datetime_<?php echo $rows->invoice_code ?>").val();
																								var mang_des = $("#mang_des_<?php echo $rows->invoice_code ?>").val();
																								var bank = $("#bank_type_<?php echo $rows->invoice_code ?>").val();
																								var income_tax = $("#income_tax_<?php echo $rows->invoice_code ?>").val();
																								var sales_tax = $("#sales_tax_<?php echo $rows->invoice_code ?>").val();
																								if (insetrument_type != "" && Amount != "" && datetime != "") {
																									var mydata = {
																										insetrument_type: insetrument_type,
																										insetrument_no: insetrument_no,
																										bank: bank,
																										date: datetime,
																										Amount: Amount,
																										remarks: mang_des,
																										income_tax: income_tax,
																										sales_tax: sales_tax,
																										invoice_id: "<?php echo $rows->acc_invoice_id ?>",
																										invoice_code: "<?php echo $rows->invoice_code ?>",
																										created_by: "<?php echo $_SESSION['user_id'] ?>"
																									};
																									console.log(mydata);

																									$.ajax({
																										url: "receive_cash",
																										type: "POST",
																										data: mydata,
																										beforeSend: function() {
																											$(".msg_div2").html('<div class="  col-lg-12 alert alert-warnning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>please wait...</div>')
																											$("#save_<?php echo $rows->invoice_code ?>").html('please wait...')
																										},
																										success: function(data) {
																											$('#edit_<?php echo $rows->acc_invoice_id ?>').modal('hide');
																											$(".msg_div2").html(data);
																											$('.edit_btn_<?php echo $rows->invoice_code ?>').attr("disabled", true).css("cursor", "not-allowed").addClass('btn-success').removeClass('btn-primary');
																											$("#save_<?php echo $rows->invoice_code ?>").html('Save')
																											$("#insetrument_type_<?php echo $rows->invoice_code ?>").change("")
																											$("#insetrument_no_<?php echo $rows->invoice_code ?>").val("")
																											$("#datetime_<?php echo $rows->invoice_code ?>").val("<?php echo date('Y-m-d\TH:i') ?>")
																											$("#mang_des_<?php echo $rows->invoice_code ?>").val("")
																											$("#Amount_<?php echo $rows->invoice_code ?>").val("")
																										},
																										error: function(data, sts, errmsg) {
																											$(".msg_div2").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
																										}
																									});
																								} else {
																									// console.log("all * field is required");
																									$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
																								}
																								setTimeout(() => {
																									$(".msg_div2").html("")
																								}, 1000);
																							})
																						</script>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
														<?php
															//--------------------------
															echo ("<td><center>" . $rows->city_full_name . "</center></td>");
															echo ("<td><center>" . $rows->invoice_code . "</center></td>");
															echo ("<td><center>" . $rows->invoice_cn . "</center></td>");
															echo ("<td>" . $rows->customer_name . "</td>");
															echo ("<td>" . $rows->customer_account_no . "</td>");
															if ($rows->invoice_permission == 1) {
																echo ("<td class='bg-primary text-white text-center' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'>" . number_format($rows->invoice_osa + $rows->other_amount + $rows->invoice_gst + $rows->invoice_sc + $rows->invoice_osa_sd_total + $rows->fuel_surcharge + $rows->invoice_fuel + $row->others + $rows->invoice_faf - ($rows->discount_amount)) . "</td>");
															} else {
																echo ("<td class='bg-primary text-white text-center' style='box-shadow:5px 5px 10px #6d5eac;font-weight:600;font-size:13px;'>" . number_format($rows->invoice_osa + $rows->other_amount + $rows->invoice_sc + $rows->invoice_osa_sd_total +  $rows->fuel_surcharge + $rows->invoice_fuel + $row->others + $rows->invoice_faf - ($rows->discount_amount)) . "</td>");
															}
															$date = date_create($rows->invoice_date);
															echo ("<td>" . date_format($date, "M-d-Y") . "</td>");
															echo ("<td><center>" . number_format($rows->invoice_sc) . "</center></td>");
															echo ("<td><center>" . number_format($rows->invoice_osa_sd_total + $rows->invoice_osa) . "</center></td>");
															//--------------------------
															if ($rows->invoice_permission == 1) {
																echo ("<td><center>" . number_format($rows->invoice_gst) . "</center></td>");
															} else if ($rows->invoice_permission == "No") {
																echo ("<td><center>0</center></td>");
															} else {
																echo ("<td><center>0</center></td>");
															}
															//--------------------------
															echo ("<td><center>" . number_format($rows->invoice_fuel) . "</center></td>");
															echo ("<td><center>" . number_format($rows->invoice_faf) . "</center></td>");
															if ($rows->other_amount == 0) {
																echo ("<td><center>" . number_format($rows->other_amount + $rows->invoice_others) . "</center></td>");
															} else {
																echo ("<td><center><b>" . $rows->other_name . "</b> " . number_format($rows->other_amount + $rows->invoice_others) . "</center></td>");
															}
															//--------------------------
															echo ("<td><center>" . number_format($rows->discount_amount) . "</center></td>");
															echo ("<td>" . number_format($rows->t_pcs) . "</td>");
															echo ("<td>" . number_format($rows->t_wgt, 2) . "</td>");
															echo ("<td>" . $rows->reference_name . "</td>");
															echo ("<td>" . $rows->oper_user_name . "</td>");
															if ($_SESSION['user_id'] == "74" or $_SESSION['user_id'] == "90") {
																echo ("<td><a href='" . base_url() . "Invoice/revert_invoice/" . $rows->invoice_code . "' class='btn btn-primary btn-xs'>Revert</a></td>");
															}
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
		$(".payment_mode").select2();
	</script>
	<script>
		$(document).ready(function() {
			data_array()
		})

		function data_array() {
			var groupColumn = 7;
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
								$(rows).eq(i).before('<tr class="group "><th colspan="19">' + group + '</th></tr>');
								last = group;
							}
						});
				},
			});
			
		}
	</script>