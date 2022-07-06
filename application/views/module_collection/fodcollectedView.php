<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#myTable').DataTable({
			"lengthMenu": [
				[25, 50, 100, -1],
				[25, 50, 100, "All"]
			],
			fixedHeader: true,
			"searching": true,
			"paging": true,
			"ordering": true,
			"bInfo": true,
			dom: 'Blfrtip',
			buttons: [{
					extend: 'pdfHtml5',
					orientation: 'Portrait',
					pageSize: 'A4',
					footer: 'true',
					title: "COD FOD Collection Lists",
					text: "<i class='fs-14 pg-download'></i> PDF",
					titleAttr: 'PDF',
					message: "Delivery Express\n  Powered By SaimTech \n Date:<?php echo '' . date('Y-m-d'); ?> \n Delivery Phase 1 Lists \n "
				},
				{
					extend: 'excelHtml5',
					text: "<i class='fs-14 pg-form'></i> Excel",
					titleAttr: 'Excel',
					sheetName: 'Delivery Phase 1 Lists',
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
					title: "COD FOD Collection Lists",
					message: "TMC Express <br> IT Department <br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>COD FOD Collection Lists<br>"
				}
			]
		});
	});
</script>
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
						<li class="breadcrumb-item">Collection</li>
						<li class="breadcrumb-item"><mark>Submit Collection</mark></li>
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
										<div class="card-title">
											<h3>Select Collection to Submit</h3>
										</div>
										<div class="form-group-attached">
											<div class="row clearfix">
												<div class="col-sm-3">
													<div class="form-group form-group-default required" id="user_name_div">
														<form action="<?php echo base_url(); ?>Collection/collected_date_range" method="post">
															<label>Start Date</label>
															<input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php if (!empty($start_date)) {
																																								echo $start_date;
																																							} ?>">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group form-group-default required">
														<label>End Date</label>
														<input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php if (!empty($end_date)) {
																																						echo $end_date;
																																					} ?>">
													</div>
												</div>
												<div class="col-sm-3">
													<button type="submit" class='btn btn-primary' style="height:100%">GO</button>
												</div>
											</div>
											</form>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive m-t-10">
											<table class="table table-bordered" id="myTable">
												<thead>
													<th>Sr</th>
													<th>Order Code | Manual CN</th>
													<th>Delivery Code | Date</th>
													<th>Origin | Shipper</th>
													<th>Destination | Consignee | Mobile</th>
													<th>Pcs | Weight | Product</th>
													<th>Status | FOD</th>
													<th>Collection | Date</th>
												</thead>
												<tbody>
													<?php
													$i = 0;
													$total_collection = 0;
													$collection_ids = '';
													if (!empty($cns_collect)) {
														foreach ($cns_collect as $rows) {
															$i = $i + 1;
															$total_collection +=  str_replace(",", "", $rows->collection);
															if ($i == count($cns_collect)) {
																$collection_ids .= $rows->cod_collection_id;
															} else {
																$collection_ids .= $rows->cod_collection_id . ",";
															}
															echo ("<tr>");
															echo ("<td>" . $i . "</td>");
															echo ("<td>" . $rows->order_code . " | " . $rows->manual_cn . "</td>");
															echo ("<td>" . $rows->on_route_id . " | " . $rows->on_route_date . "</td>");
															echo ("<td>" . $rows->origin_city_name . " | " . $rows->shipper_name . "</td>");
															echo ("<td>" . $rows->destination_city_name . " | " . $rows->consignee_name . " | " . $rows->consignee_mobile . "</td>");
															echo ("<td>" . $rows->pieces . " | " . $rows->weight . " KG | " . $rows->product_detail . "</td>");
															echo ("<td>" . $rows->order_status . " | Rs. " . $rows->cod_amount . "</td>");
															echo ("<td>Rs. " . $rows->collection . " | " . $rows->collection_date . "</td>");
															echo ("</tr>");
														}
													} ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="card-footer">
										<div class="col-sm-4">
											<div class="form-group form-group-default">
												<label>Total</label>
												<input type="hidden" class="form-control" id="collection_ids" name="colletion_ids" value="<?php echo $collection_ids; ?>">
												<input type="number" class="form-control" id="to_submit_total" name="to_submit_total" value="<?php echo $total_collection; ?>" readonly>
											</div>
											<div class="form-group form-group-default required" aria-required="true">
												<label>Submit To</label>
												<select class="form-control" name="submit_to" id="submit_to" aria-required="true">
													<option value="0">Select One</option>
													<optgroup label="Finance Department">
														<option value="Finance Manager">Finance Manager</option>
													</optgroup>
													<optgroup label="Admin Department">
														<option value="Admin Manager">Admin Manager</option>
													</optgroup>
													<optgroup label="Bank Deposit">
														<option value="UBL">UBL</option>
														<option value="HBL">HBL</option>
														<option value="MBL">MBL</option>
													</optgroup>
													<optgroup label="Operations Department">
														<option value="Cashier">Cashier</option>
														<option value="Operation Manager(Day)">Operation Manager(Day)</option>
														<option value="Operation Manager(Night)">Operation Manager(Night)</option>
													</optgroup>
												</select>
											</div>
											<div class="form-group form-group-default">
												<label>Person Name / Remarks</label>
												<textarea class="form-control" id="rmks" name="rmks" max="500" rowss="4"></textarea>
											</div>
											<button class="btn btn-info" onclick="create_Sheet();">Submit</button>
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

	<script>
		$(document).ready(function() {
			$("#submit_to").select2();
		});
		
		function create_Sheet() {
			var collection_ids = $('#collection_ids').val();
			var to_submit_total = $('#to_submit_total').val();
			var submit_to = $('#submit_to').find(':selected').val();
			var rmks = $('#rmks').val();

			$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>Please Wait</strong> We Are Getting Up Things For You.</div></div>");

			var mydata = {
				collection_ids: collection_ids,
				to_submit_total: to_submit_total,
				submit_to: submit_to,
				rmks: rmks
			};

			$.ajax({
				url: "<?php echo base_url(); ?>Collection/submit_collection",
				type: "POST",
				data: mydata,
				success: function(data, status, xhr) {
					if (data.length > 0) {
						var rtn = data.split("|");
						$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>" + rtn[0] + "</strong> has been created and submitted.</div></div>");
						window.open('<?php echo base_url(); ?>Collection/submit_preview/' + rtn[1], '_blank');
					} else {
						$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Something went <strong>wrong</strong>.</div></div>");
					}
				}
			});
		}
	</script>

	<?php
	$this->load->view('inc/footer');
	?>