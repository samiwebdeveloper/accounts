<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#myTable').DataTable({
			"lengthMenu": [
				[-1, 25, 50, 100],
				["All", 25, 50, 100]
			],
			fixedHeader: true,
			"searching": true,
			"paging": true,
			"ordering": true,
			"bInfo": true,
			dom: 'Blfrtip',
			buttons: [
				/*{
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
								}*/
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
						<li class="breadcrumb-item"><mark>FOD Collection</mark></li>						
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
											Get CN Information
										</div>
										<div class="form-group-attached">
											<div class="row clearfix">
												<div class="col-sm-3">
													<div class="form-group form-group-default required" id="user_name_div">
														<label>Electron ID or Manual CN</label>
														<input type="number" class="form-control" id="order_no" name="order_no" min="6" max="13" value="<?php if (!empty($order_no)) {
																																							echo $order_no;
																																						} ?>">
													</div>
												</div>
												<div class="col-sm-3">
													<button type="button" class='btn btn-primary' style="height:100%" onclick="get_cn_data()">GO</button>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive m-t-10">
											<table class="table table-bordered">
												<thead>
													<th>Sr</th>
													<th>Order Code | Manual CN</th>
													<th>Delivery Code | Date</th>
													<th>Origin | Shipper</th>
													<th>Destination | Consignee</th>
													<th>Pcs | Weight | Product</th>
													<th>Status | FOD | OPS Collection</th>
													<th>Amount</th>
													<th>Action</th>
												</thead>
												<tbody id="cn_tbody">

												</tbody>
											</table>
										</div>
									</div>
									<div class="card-footer">

									</div>
								</div>
							</div>
							<!-- END card -->
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">
										</div>
										<!--<div class="form-group-attached">
											<div class="row clearfix">
												<div class="col-sm-3">
													<div class="form-group form-group-default required" id="user_name_div">
														<form action="<?php echo base_url(); ?>Collection/date_range" method="post">
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
										</div>-->
									</div>
									<div class="card-body">
										<div class="table-responsive m-t-10">
											<table class="table table-bordered" id="myTable">
												<thead>
													<th>Sr</th>
													<th>Order Code | Manual CN</th>
													<th>Delivery Code | Date</th>
													<th>Origin | Shipper</th>
													<th>Destination | Consignee</th>
													<th>Pcs | Weight | Product</th>
													<th>Status | FOD | OPS Collection</th>
													<th>Amount</th>
													<th>Action</th>
												</thead>
												<tbody>
													<?php
													$i = 0;
													if (!empty($cns_collect)) {
														foreach ($cns_collect as $rows) {
															$i = $i + 1;
															$outstand += $rows->cod;
															$collected += $rows->accts_rcvd_amount;
															$ops_collection = $rows->cod - $rows->ops_rcvd_amount;
															$ops_col_mark = $ops_collection > 0 ? " | <strong class='text-danger'>Short Receive</strong>" : " | <strong class='text-success'>Okay</strong>";
															echo ("<tr>");
															echo ("<td>" . $i . "</td>");
															echo ("<td>" . $rows->order_code . " | " . $rows->manual_cn . "</td>");
															echo ("<td>" . $rows->on_route_id . " | " . $rows->on_route_date . "</td>");
															echo ("<td>" . $rows->origin_city_name . " | " . $rows->shipper_name . "</td>");
															echo ("<td>" . $rows->destination_city_name . " | " . $rows->consignee_name . " | " . $rows->consignee_mobile . "</td>");
															echo ("<td>" . $rows->pieces . " | " . $rows->weight . " KG | " . $rows->product_detail . "</td>");
															echo ("<td>" . $rows->order_status . " | Rs. " . $rows->cod_amount . "</td>");
															echo ("<td><input type='number' class='form-control' id='cod_" . $rows->order_id . "' name='cod_" . $rows->order_id . "' /></td>");
															echo ("<td><button class='btn btn-info cn-collect' id='btn_" . $rows->order_id . "' name='btn_" . $rows->order_id . "' value=" . $rows->order_id . "|" . $rows->order_code . ">Collect</button></td>");
															echo ("</tr>");
														}
													} ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="card-footer">
										<!-- <p class="text-right">Outstandings: <?php echo "<strong id='out' name='out' class='text-info'>" . number_format($outstand, 2) . "</strong> Collection: <strong id='cal' name='cal' class='text-success'>" . number_format($collected, 2) . "</strong> Balance: <strong id='bal' name='bal' class='text-danger'>" . number_format($outstand - $collected, 2) . "</strong>" ?></p>-->
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
		function get_cn_data() {
			var cn = $("#order_no").val();
			var mydata = {
				cn: cn
			};

			var table = $('#myTable').DataTable().search(cn);
			var r_count = table.rows({
				search: 'applied'
			}).count();			

			if (r_count > 0) {
				table.draw();
			} else {
				$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Fetching information of " + cn + " <strong>Please wait...</strong></div></div>");
				$('#cn_tbody').html("");
				$.ajax({
					url: "<?php echo base_url(); ?>Collection/cn_to_collect",
					type: "GET",
					data: mydata,
					dataType: "json",
					success: function(data, status, xhr) {
						$.each(data, function(index, element) {
							$('#cn_tbody').html("<tr>" +
								"<td>" + (index + 1) + "</td>" +
								"<td>" + element.order_code + " | " + element.manual_cn + "</td>" +
								"<td>" + element.on_route_id + " | " + element.on_route_date + "</td>" +
								"<td>" + element.origin_city_name + " | " + element.shipper_name + "</td>" +
								"<td>" + element.destination_city_name + " | " + element.consignee_name + " | " + element.consignee_mobile + "</td>" +
								"<td>" + element.pieces + " | " + element.weight.toLocaleString() + " KG | " + element.product_detail + "</td>" +
								"<td>" + element.order_status + " | Rs. " + element.cod_amount.toLocaleString() + "</td>" +
								"<td><input type='number' class='form-control' id='cod_" + element.order_id + "' name='cod_" + element.order_id + "' /></td>" +
								"<td><button class='btn btn-info cn-collect' id='btn_" + element.order_id + "' name='btn_" + element.order_id + "' value=" + element.order_id + "|" + element.order_code + ">Collect</button></td>" +
								"</tr>");								
						});					

						if (data.length != 0) {
							$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>You may proced for " + cn + " <strong>now</strong>.</div></div>");
						} else {
							$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + cn + " already has been <strong>collected</strong>.</div></div>");
						}
					},
					error: function(data, status, errmsg) {
						alert("Error: " + errmsg);
					},
				});
			}

		}

		$(document.body).on('click','.cn-collect',function() {
			var arr = $(this).val().split("|");
			var order_id = arr[0];
			var order_code = arr[1];
			var amt = parseFloat($('#cod_' + order_id).val());

			var mydata = {
				orderid: order_id,
				codamt: amt
			};

			$.ajax({
				url: "<?php echo base_url(); ?>Collection/cod_collection",
				type: "POST",
				data: mydata,
				success: function(data) {
					if (data > 0) {
						$("#btn_" + order_id).attr('disabled', true);
						$("#cod_" + order_id).prop("readonly", true);
						$("#cod_" + order_id).prop("class", "form-control text-success");

						$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Order " + order_code + " has been <strong>marked</strong> collected.</div></div>");
					} else {
						$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Order " + order_code + " <strong>can't</strong> can't marked collected.</div></div>");
					}
				},
				error: function(data, status, errmsg) {
					alert("Error: " + errmsg);
				},
			});

		});		
	</script>

	<?php
	$this->load->view('inc/footer');
	?>