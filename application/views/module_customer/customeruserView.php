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

	.checkbox {
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.form-group-default label {
		display: inline;
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
						<li class="breadcrumb-item">Customer</li>
						<li class="breadcrumb-item">Add Customer Portal User</li>
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
			<div class="pgn-wrapper msg_div3" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="row">
							<div class="col-md-12">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title"><a data-toggle='modal' data-target='#add_user' href='javascript:void(0)' class='btn btn-primary'>Add Customer User</a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive m-t-10">
											<table class="table table-bordered compact nowrap" id="myTable" style="border-top:1px solid black ;">
												<thead>
													<th class="text-center">Action</th>
													<th>user name</th>
													<th>user power</th>
													<th>user status</th>
													<th>Customer Name</th>
													<th>user city</th>
													<th>Shipper name</th>
													<th>Shipper phone</th>
													<th>Shipper email</th>
													<th>Shipper address</th>
													<th>created by</th>
													<th>created date</th>
												</thead>
												<tbody>
													<?php
													$i = 0;
													if (!empty($user_data)) {
														foreach ($user_data as $rows) {
															$i = $i + 1;
															echo ("<tr>");
															if ($rows->is_enable == 1) {
																echo "<td> <a  href='javascript:void(0)' id='status_$rows->user_id'  onclick='change_status($rows->user_id,0)' class='btn btn-xs btn-danger'> Suspended </a>";
															} else {
																echo "<td>&nbsp; <a  href='javascript:void(0)' id='status_$rows->user_id'  onclick='change_status($rows->user_id,1)' class='btn btn-xs btn-success'> Re Active </a>";
															}
															echo (" &nbsp;<a    class='btn btn-xs btn-info' href='javascript:void(0)'  id='pass_$rows->user_id' onclick='reset_password($rows->user_id)' >Password Reset</a>");

															echo (" &nbsp;<a    class='btn btn-xs btn-primary' href='" . base_url() . "customer/edit_user/$rows->user_id' > Edit </a></td>");
															//--------------------------
															echo ("<td>" . $rows->account_no . "</td>");
															echo ("<td>" . $rows->user_power . "</td>");
															if ($rows->is_enable == 1) {
																echo ("<td class='bg-success text-white text-center' id='bg_color_$rows->user_id'> Re Active </td>");
															} else {
																echo ("<td class='bg-danger text-white text-center' id='bg_color_$rows->user_id'> Suspended </td>");
															}
															echo ("<td>" . $rows->customer_name . "</td>");
															echo ("<td>" . $rows->city_name . "</td>");
															echo ("<td>" . $rows->consignor_name . "</td>");
															echo ("<td>" . $rows->consignor_phone . "</td>");
															echo ("<td>" . $rows->consignor_email . "</td>");
															echo ("<td>" . $rows->consignor_add . "</td>");
															echo ("<td>" . $rows->oper_user_name  . "</td>");
															echo ("<td>" . $rows->created_date . "</td>");
															echo ("</tr>");
														} ?>
													<?php } ?>
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
	<div class="modal fade stick-up " id="add_user">
		<div class="modal-dialog">
			<div class="modal-dialog ">
				<div class="modal-content-wrapper">
					<div class="modal-content">
						<div class="modal-header clearfix text-left">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
							<h4><b>Add Customer User</b> </h4>
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
												<label>Select Customer </label>
												<select name="customer" id="customer" class="form-control" style="width: 100%">
													<option value="">Select customer</option>
													<?php foreach ($customer_data as $customer) {
														echo "<option value='$customer->customer_id'>$customer->customer_name</option>";
													} ?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-7">
											<div class="form-group form-group-default required">
												<label>Select City </label>
												<select name="city" id="city" class="form-control" style="width: 100%">
													<option value="">Select City</option>
													<?php foreach ($cities_data as $city) {
														echo "<option value='$city->city_id'> (" . $city->city_code . ") [ (" . $city->city_short_code . ") " . $city->city_name . "]</option>";
													} ?>
												</select>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group form-group-default required">
												<label>Select Type </label>
												<select name="customer" id="customer_type" class="form-control" style="width: 100%">
													<option value="">Select Type</option>
													<option value="AGENT">AGENT</option>
													<option value="SUB AGENT">SUB AGENT</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-default required">
												<label>User Name</label>
												<input type="text" class="form-control" name="account_title" id="account_title">
											</div>
										</div>
										<!-- <div class="col-md-5">
											<div class="form-group form-group-default required">
												<label>Password</label>
												<input type="text" hidden readonly class="form-control" value="123" name="password" id="password">
											</div>
										</div> -->
									</div>
									<div class="row" style="border-bottom: 1px solid rgba(95, 51, 51, 0.25);">
										<div class="col-md-12">
											<div class="form-group-default checkbox check-primary  ">
												<input type="checkbox" checked="checked" id="checkbox2">
												<label for="checkbox2">Same as Customer</label>
											</div>
										</div>
									</div>
									<div class="row row_c">
										<div class="col-md-6">
											<div class="form-group form-group-default required">
												<label>Consignor Name</label>
												<input type="text" class="form-control" name="c_name" id="c_name">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default required">
												<label>Consignor Phone</label>
												<input type="tel" class="form-control" name="c_phone" id="c_phone">
											</div>
										</div>
									</div>
									<div class="row row_c">
										<div class="col-md-12">
											<div class="form-group form-group-default required">
												<label>Consignor Email</label>
												<input type="text" class="form-control" name="c_email" id="c_email">
											</div>
										</div>
									</div>
									<div class="row row_c">
										<div class="col-md-12">
											<div class="form-group form-group-default required">
												<label>Consignor Address</label>
												<input type="tel" class="form-control" name="c_add" id="c_add">
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="row">
								<div class="col-md-8"></div>
								<div class="col-md-4 m-t-10 sm-m-t-10">
									<button type="button" class="btn btn-primary btn-block m-t-5" id="save_user">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('inc/footer'); ?>

	<script>
		function reset_password(a) {
			var mydata = {user_id: a};
			$.ajax({
				url: "<?php echo base_url() ?>customer/reset_user_pass",
				type: "POST",
				data: mydata,
				beforeSend: function() {
					$(".msg_div3").html('<div class="  col-lg-12 alert alert-warning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>please wait...</div>')
					$("#pass_" + a).html('please wait...')
				},
				success: function(data) {
					$(".msg_div3").html(data);
					setTimeout(() => {
						location.reload()
					}, 1000);
				},
				error: function(data, sts, errmsg) {
					$(".msg_div2").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
				}
			});
		}
	</script>

	<script>
		function change_status(a, b) {
			var mydata = {
				user_id: a,
				status: b
			};
			console.log(mydata);
			$.ajax({
				url: "<?php echo base_url() ?>customer/change_user_status",
				type: "POST",
				data: mydata,
				beforeSend: function() {
					$(".msg_div3").html('<div class="  col-lg-12 alert alert-warning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>please wait...</div>')
					$("#status_" + a).html('please wait...')
				},
				success: function(data) {
					$(".msg_div3").html(data);
					if (b) {
						$("#status_" + a).html("Suspended").addClass('btn-danger').removeClass('btn-success');
						$("#bg_color_" + a).html("Re Active").addClass('bg-success').removeClass('bg-danger');
					} else {
						$("#status_" + a).html("Re Active").addClass('btn-success').removeClass('btn-danger');
						$("#bg_color_" + a).html("Suspended").addClass('bg-danger').removeClass('bg-success');
					}
					setTimeout(() => {
						location.reload()
					}, 1000);
				},
				error: function(data, sts, errmsg) {
					$(".msg_div2").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
				}
			});
		}
	</script>
	<script>
		$('#checkbox2 ').click(function() {
			if ($('#checkbox2').is(":checked")) {
				$(".row_c").hide()
			} else {
				$(".row_c").show()
			}
		});
	</script>
	<script>
		$("#save_user").click(function() {
			$(".msg_div2").html("")
			var customer = $("#customer").val();
			var customer_type = $("#customer_type").val();
			var city = $("#city").val();
			var account_title = $("#account_title").val();
			var password = $("#password").val();
			var c_name = $("#c_name").val();
			var c_phone = $("#c_phone").val();
			var c_email = $("#c_email").val();
			var c_add = $("#c_add").val();
			var check = "";
			var mydata = {};
			if (account_title.indexOf(' ') >= 0) {
				$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> Space is not allowed (Account title) . </div>')
			} else {
				if (customer != "" && customer_type != "" && city != "" && account_title != "") {
					if ($('#checkbox2').is(":checked")) {
						check = 1;
						mydata = {
							check: check,
							customer: customer,
							customer_type: customer_type,
							city: city,
							account_title: account_title,
						};
					} else {
						check = 0;
						if (c_name != "" && c_phone != "" && c_email != "" && c_add != "") {
							mydata = {
								check: check,
								customer: customer,
								customer_type: customer_type,
								city: city,
								account_title: account_title,
								c_name: c_name,
								c_phone: c_phone,
								c_email: c_email,
								c_add: c_add
							};
						} else {
							$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
						}
					}
					if (check != "") {
						$.ajax({
							url: "<?php echo base_url() ?>customer/add_customer_user_data",
							type: "POST",
							data: mydata,
							beforeSend: function() {
								$(".msg_div2").html('<div class="  col-lg-12 alert alert-warning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>please wait...</div>')
								$("#save_user").html('please wait...')
							},
							success: function(data) {
								if (data == 0) {
									$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong>Account title must be unique </div>')
									$("#save_user").html('Save')
								} else {
									// $('#add_user').modal('hide');
									$(".msg_div2").html(data);
									$("#save_user").html('Save')
									setTimeout(() => {
										location.reload()
									}, 1000);
								}
							},
							error: function(data, sts, errmsg) {
								$(".msg_div2").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
							}
						});
					}
				} else {
					$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
				}
			}
		})
	</script>
	<script>
		$(document).ready(function() {
			data_array()
			$(".payment_mode").select2();
			$("#city").select2();
			$("#customer").select2();
			$("#customer_type").select2();
			$(".row_c").hide()
		})

		function data_array() {
			var groupColumn = 4;
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
						sheetName: 'Customer user List',
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
						message: "T.M. Cargo Customer user List<br>"
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