<?php
error_reporting(0);
$this->load->view('inc/header');
?>
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
						<li class="breadcrumb-item">Edit cusotmer User</li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:a'); ?></mark></li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="row">
							<div class="col-md-6">
								<div class="card ">
									<div class="card-header  separator">
										<div class="card-title">Edit Customer User</div>
									</div>
									<div class="card-body">
										<?php echo  $this->session->flashdata('msg'); ?>
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
																	$selected = "";
																	if ($customer->customer_id == $user_data_by_id[0]->customer_id) {
																		$selected = "selected";
																	}
																	echo "<option $selected value='$customer->customer_id'>$customer->customer_name</option>";
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
																	$selected = "";
																	if ($city->city_id == $user_data_by_id[0]->user_city) {
																		$selected = "selected";
																	}
																	echo "<option  $selected value='$city->city_id'> (" . $city->city_code . ") [ (" . $city->city_short_code . ") " . $city->city_name . "]</option>";
																} ?>
															</select>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-default required">
															<label>Select Type </label>
															<select name="customer" id="customer_type" class="form-control" style="width: 100%">
																<option value="">Select Type</option>
																<?php
																if ("AGENT" == $user_data_by_id[0]->user_power) {
																	echo '<option selected value="AGENT">AGENT</option>';
																	echo '<option value="SUB AGENT">SUB AGENT</option>';
																} else {
																	echo '<option  value="AGENT">AGENT</option>';
																	echo '<option  selected value="SUB AGENT">SUB AGENT</option>';
																} ?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group form-group-default required">
															<label>Account Title</label>
															<input type="text" class="form-control" name="account_title" value="<?php echo $user_data_by_id[0]->account_no ?>" id="account_title">
														</div>
													</div>
													<!-- <div class="col-md-5">
														<div class="form-group form-group-default required">
															<label>Password</label>
															<input type="text" hidden readonly class="form-control" value="123" name="password" id="password">
														</div>
													</div> -->
												</div>
												<input type="text" hidden name="user_id" value="<?php echo $user_data_by_id[0]->user_id ?>" id="user_id">
												<div class="row" style="border-bottom: 1px solid rgba(95, 51, 51, 0.25);">
													<div class="col-md-12">
														<div class="form-group-default checkbox check-primary  ">
															<?php if (is_null($user_data_by_id[0]->consignor_name)) {
																echo '<input type="checkbox" checked="checked" id="checkbox2">';
															} else {
																echo '<input type="checkbox"  id="checkbox2">';
															} ?>
															<label for="checkbox2">Same as Customer</label>
														</div>
													</div>
												</div>
												<div class="row row_c">
													<div class="col-md-6">
														<div class="form-group form-group-default required">
															<label>Consignor Name</label>
															<input type="text" class="form-control" value="<?php echo $user_data_by_id[0]->consignor_name ?>" name="c_name" id="c_name">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group form-group-default required">
															<label>Consignor Phone</label>
															<input type="tel" class="form-control" value="<?php echo $user_data_by_id[0]->consignor_phone ?>" name="c_phone" id="c_phone">
														</div>
													</div>
												</div>
												<div class="row row_c">
													<div class="col-md-12">
														<div class="form-group form-group-default required">
															<label>Consignor Email</label>
															<input type="text" class="form-control" value="<?php echo $user_data_by_id[0]->consignor_email ?>" name="c_email" id="c_email">
														</div>
													</div>
												</div>
												<div class="row row_c">
													<div class="col-md-12">
														<div class="form-group form-group-default required">
															<label>Consignor Address</label>
															<input type="tel" class="form-control" value="<?php echo $user_data_by_id[0]->consignor_add ?>" name="c_add" id="c_add">
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
		$('#checkbox2 ').click(function() {
			if ($('#checkbox2').is(":checked")) {
				$(".row_c").hide()
			} else {
				$(".row_c").show()
			}
		});
	</script>
	<script>
		$(document).on('click', '#save_user', function() {
			$(".msg_div2").html("")
			var customer = $("#customer").val();
			var customer_type = $("#customer_type").val();
			var city = $("#city").val();
			var account_title = $("#account_title").val();
			var password = $("#password").val();
			var c_name = $("#c_name").val();
			var c_phone = $("#c_phone").val();
			var c_email = $("#c_email").val();
			var user_id = $("#user_id").val();
			var c_add = $("#c_add").val();
			var mydata = {};
			if (account_title.indexOf(' ') >= 0) {
				$(".msg_div2").html('<div class="  col-lg-12 alert alert-warning" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Successfully!: </strong> Space is not allowed (Account title) . </div>')
			} else {
				if (customer != "" && customer_type != "" && city != "" && account_title != "") {
					if ($('#checkbox2').is(":checked")) {
						var check = 1;
						mydata = {
							check: check,
							customer: customer,
							customer_type: customer_type,
							city: city,
							account_title: account_title,
							user_id: user_id,
						};
					} else {
						if (c_name != "" && c_phone != "" && c_email != "" && c_add != "") {
							var check = 0;
							mydata = {
								check: check,
								customer: customer,
								customer_type: customer_type,
								city: city,
								account_title: account_title,
								c_name: c_name,
								c_phone: c_phone,
								c_email: c_email,
								c_add: c_add,
								user_id: user_id,
							};
						} else {
							$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
						}
					}
					// console.log(check);
					if (check == 0 || check == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>customer/edit_customer_user_data",
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
									$(".msg_div2").html(data);
									$("#save_user").html('Save')
									setTimeout(() => {
										$(location).prop('href', '<?php echo base_url() ?>customer/add_customer_user')
									}, 1000);
								}
							},
							error: function(data, sts, errmsg) {
								$(".msg_div2").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>" + errmsg + "</div></div>");
							}
						});
					} else {
						console.log("chechk is empty");
					}
				} else {
					$(".msg_div2").html('<div class="  col-lg-12 alert alert-danger" role="alert"> <button class="close "  data-dismiss="alert"></button><strong>Alert!: </strong> * fileds is reuqired</div>')
				}
			}
		})
	</script>
	<script>
		$(document).ready(function() {
			if ($('#checkbox2').is(":checked")) {
				$(".row_c").hide()
			} else {
				$(".row_c").show()
			}
			data_array()
			$(".payment_mode").select2();
			$("#city").select2();
			$("#customer").select2();
			$("#customer_type").select2();
		})

		function data_array() {
			$('#myTable').DataTable()
		}
	</script>