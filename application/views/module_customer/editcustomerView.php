<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#pay_mode').select2();
		$('#service_type').select2({
			tags: true,
			tokenSeparators: [',', ' ']
		});
		$('#reference_by').select2();
		$('#secondary_reference_by').select2();
		$('#operating_type').select2();
		$('#calculation_type').select2();
		$('#brand_city').select2();
		$('#bunits').select2();
		$('#Country').select2();
		$('#data_panel').saimtech();
		$('#pending_panel').saimtech();
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
						<li class="breadcrumb-item">Customer</li>
						<li class="breadcrumb-item">Edit Customer</li>
						<li class="breadcrumb-item"><mark><?php echo $customer_data[0]['customer_name'] . " > " . date('Y-m-d h:i:s'); ?></mark></li>
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
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-12">
										<div class="card m-t-10">
											<div class="card-header separator">
												<div class="card-title">FAF</div>
												<div class="card-controls"></div>
											</div>
											<div class="card-body">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>FAF</th>
															<th>Start Date</th>
															<th>End Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php if (!empty($customer_faf)) {
															foreach ($customer_faf as $rows) {
																$min_date = $rows->end_date;
																echo ("<tr>");
																echo ("<td>" . $rows->faf * 100 . "%</td>");
																echo ("<td>" . $rows->start_date . "</td>");
																echo ("<td>" . $rows->end_date . "</td>");
																echo ("<td style='display: none;'>" . $rows->acc_cf_id . "</td>");
																echo ("<td><button type='button' onclick='editfaf(this);' class='btn btn-primary btn-xs'>Edit</button>");
																if ($rows->is_enable == 1) {
																	echo ("<button type='button' onclick='susfaf(this);' class='btn btn-warning btn-xs'>Suspend</button>");
																} else {
																	echo ("<button type='button' onclick='enfaf(this);' class='btn btn-success btn-xs'>Enable</button>");
																}
																echo ("<button type='button' onclick='delfaf(this);' class='btn btn-danger btn-xs'>Delete</button></td>");
																echo ("</tr>");
															}
														} ?>
													</tbody>
												</table>
											</div>
											<div class="card-footer">
												<form role="form" id="form_faf" method="post" action="<?php echo base_url(); ?>Customer/add_faf">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-12">
																		<div class="form-group form-group-default" id="faf_div">
																			<label>Percentage</label>
																			<input type="hidden" id="faf_id" name="faf_id" value="0" />
																			<input type="hidden" id="c_id" name="c_id" value="<?php echo $customer_data[0]['customer_id']; ?>" />
																			<input type="number" class="form-control" id='faf' name='faf' placeholder="Enter F.A.F like 10.00" tabindex=1>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default" id="faf_start_div">
																			<label>Start Date</label>
																			<input type="date" class="form-control" id='faf_start_date' name='faf_start_date' placeholder="Pick a date" tabindex=2 min="<?php echo date('Y-m-01', strtotime(' - 1 month')); ?>" value="<?php echo date('Y-m-01', strtotime($min_date . ' - 1 month')); ?>">
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default" id="faf_end_div">
																			<label>End Date</label>
																			<input type="date" class="form-control" id='faf_end_date' name='faf_end_date' placeholder="Pick a date" tabindex=3 min="<?php echo date('Y-m-01', strtotime( ' - 1 month')); ?>" value="<?php echo date('Y-m-t', strtotime(' - 1 month')); ?>">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-6">
															<button type="reset" class='btn btn-danger pull-right'>Reset</button>
															<button type="submit" class='btn btn-primary pull-left'>Save</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">Data Panel</div>
										<div class="card-controls">
										</div>
									</div>
									<div class="card-body">
										<div class=" container-fluid   container-fixed-lg">
											<div class="row row-same-height">
												<!--<div class="col-md-4 b-r b-dashed b-grey ">
												<div class="padding-30 sm-padding-5 sm-m-t-15 m-t-50">
												<?php if (!empty($message)) {
													echo ("<p class='alert alert-success'>" . $message . "</p>");
												} ?>    
												<h2>Your Information is safe with us!</h2>
												<p>We respect your privacy and protect it with strong encryption, plus strict policies . Two-step verification, which we encourage all our customers to use.</p>
												<p class="small hint-text">Below is a sample page for your cart , Created using pages design UI Elementes</p>
												</div>
											</div>-->
												<div class="col-md-12">
													<div class="padding-30 sm-padding-5">
														<?php if (!empty($message)) {
															echo ("<p class='alert alert-success'>" . $message . "</p><br>");
														} ?>
														<form role="form" method="post" action="<?php echo base_url(); ?>Customer/edit_customer">
															<p>Brand Details</p>
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Name</label>
																			<input type="text" placeholder="Enter Brand Name" class="form-control" value="<?php echo $customer_data[0]['customer_name']; ?>" id="brand_name" name="brand_name" required="" tabindex=1>
																			<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_data[0]['customer_id']; ?>">
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default">
																			<label>CNIC</label>
																			<input type="text" class="form-control" value="<?php echo $customer_data[0]['customer_cnic']; ?>" placeholder="Enter Brand Name" class="form-control" id="brand_cnic" name="brand_cnic" tabindex=2>
																		</div>
																	</div>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Payment Mode</label>
																			<select class="form-control" required id="pay_mode" name="pay_mode" tabindex=3>
																				<option value='1' <?php echo $customer_data[0]['pay_mode_id'] == '1' ? "selected='selected'" : ""; ?>>Account</option>
																				<option value='2' <?php echo $customer_data[0]['pay_mode_id'] == '2' ? "selected='selected'" : ""; ?>>FOD</option>
																				<option value='3' <?php echo $customer_data[0]['pay_mode_id'] == '3' ? "selected='selected'" : ""; ?>>Account & FOD</option>
																				<option value='4' <?php echo $customer_data[0]['pay_mode_id'] == '4' ? "selected='selected'" : ""; ?>>Cash</option>
																				<option value='5' <?php echo $customer_data[0]['pay_mode_id'] == '5' ? "selected='selected'" : ""; ?>>FOC</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Operating type</label>
																			<select class="form-control" required id="operating_type" name="operating_type" tabindex=4>
																				<option value='LW' <?php echo $customer_data[0]['customer_account_type'] == 'LW' ? "selected='selected'" : ""; ?>>Same City</option>
																				<option value='NW' <?php echo $customer_data[0]['customer_account_type'] == 'NW' ? "selected='selected'" : ""; ?>>Different City</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default">
																			<label>URL</label>
																			<input type="text" class="form-control" placeholder="Enter URL" value="<?php echo $customer_data[0]['customer_url']; ?>" name="brand_url" id="brand_url" tabindex=5>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Service Type</label>
																			<input type="hidden" name="services_type" id="services_tpye" value="<?php echo $customer_data[0]['services']; ?>">
																			<select class="form-control" name="service_type" id="service_type" multiple="multiple" onchange="services()" required>
																				<option value='0' <?php echo strpos($customer_data[0]['services'], '0') !== false ? "selected='selected'" : ''; ?>>Select Service</option>
																				<option value='1' <?php echo strpos($customer_data[0]['services'], '1') !== false ? "selected='selected'" : ''; ?>>Over Night</option>
																				<option value='2' <?php echo strpos($customer_data[0]['services'], '2') !== false ? "selected='selected'" : ''; ?>>Over Land</option>
																				<option value='3' <?php echo strpos($customer_data[0]['services'], '3') !== false ? "selected='selected'" : ''; ?>>Detain</option>
																				<option value='4' <?php echo strpos($customer_data[0]['services'], '4') !== false ? "selected='selected'" : ''; ?>>Air Frieght</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="form-group form-group-default">
																	<label>NTN</label>
																	<input type="text" class="form-control" placeholder="Enter NTN" value="<?php echo $customer_data[0]['customer_ntn']; ?>" name="brand_ntn" id="brand_ntn" tabindex=5>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Product Type</label>
																			<input type="text" class="form-control" required="" value="<?php echo $customer_data[0]['customer_product_type']; ?>" id="brand_product" name="brand_product" tabindex=6>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required">
																			<label>Select Calculation Type</label>
																			<select class='form-control' required name="calculation_type" id="calculation_type" tabindex=10>
																				<option value='Addition' <?php echo $customer_data[0]['cal_type'] == 'Addition' ? "selected='selected'" : ''; ?>>Addition</option>
																				<option value='Multiplication' <?php echo $customer_data[0]['cal_type'] == 'Multiplication' ? "selected='selected'" : ''; ?>>Multiplication</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="form-group form-group-default required">
																	<label>Slip Name</label>
																	<input type="text" class="form-control" required id="brand_note" name="brand_note" value="<?php echo $customer_data[0]['customer_note']; ?>" tabindex=6>
																</div>
															</div>
															<br>
															<p>Address Detail</p>
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-12">
																		<div class="form-group form-group-default required">
																			<label>Address</label>
																			<input type="text" class="form-control" id="brand_address" name="brand_address" value="<?php echo $customer_data[0]['customer_address']; ?>" placeholder="Current address" required tabindex=7>
																		</div>
																	</div>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-12">
																		<div class="form-group form-group-default required">
																			<label>Contact Person Name</label>
																			<input type="text" class="form-control" placeholder="Enter Contact Person Name" value="<?php echo $customer_data[0]['customer_contact_person']; ?>" name="pickup_points" id="pickup_points" tabindex=8 required="">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row clearfix">
																<div class="col-sm-6">
																	<div class="form-group form-group-default required">
																		<label>City</label>
																		<select class="form-control" name='brand_city' id='brand_city' required tabindex=8>
																			<?php
																			if (!empty($cities_data)) {
																				foreach ($cities_data as $rows) {
																					if ($rows->city_id == $customer_data[0]['customer_city']) {
																						echo ("<option value='" . $rows->city_id . "'>" . $rows->city_full_name . "</option>");
																					}
																					echo ("<option value='" . $rows->city_id . "'>" . $rows->city_full_name . "</option>");
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group form-group-default">
																		<label>Country</label>
																		<select class="form-control" name='Country' id='Country'>
																			<option value=''>Pakistan</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="row clearfix">
																<div class="col-sm-6">
																	<div class="form-group form-group-default">
																		<label>Email</label>
																		<input type='email' class="form-control" name='brand_email' id='brand_email' value="<?php echo $customer_data[0]['customer_contact2']; ?>" placeholder="Enter Email" tabindex=9>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group form-group-default">
																		<label>Phone</label>
																		<input type='text' class="form-control" name='brand_phone' id='brand_phone' value="<?php echo $customer_data[0]['customer_contact']; ?>" placeholder="Enter Phone" tabindex=10>
																	</div>
																</div>
															</div>
															<br>
															<p>Bank Detail</p>
															<div class="form-group-attached">
																<div class="form-group form-group-default">
																	<label>Name</label>
																	<input type="text" class="form-control" placeholder="Enter Bank Name" id="bank_name" value="<?php echo $customer_data[0]['customer_bank']; ?>" name="bank_name" tabindex=11>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default">
																			<label>Account Title</label>
																			<input type="text" class="form-control" id='account_title' name='account_title' value="<?php echo $customer_data[0]['customer_bank_account_title']; ?>" placeholder="Enter Bank Account Title" tabindex=12>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default">
																			<label>Account Number</label>
																			<input type="text" class="form-control" id='account_no' name='account_no' value="<?php echo $customer_data[0]['customer_bank_account_no']; ?>" placeholder="Enter Bank Account Number" tabindex=13>
																		</div>
																	</div>

																</div>
																<div class="form-group form-group-default">
																	<label>IBAN</label>
																	<input type="text" class="form-control" id='account_iban' name='account_iban' value="<?php echo $customer_data[0]['customer_iban']; ?>" placeholder="Enter IBAN" required="" tabindex=14>
																</div>
															</div>
															<br>
															<p>Surcharges</p>
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default" id="gst_div">
																			<label>G.S.T</label>
																			<input type="number" class="form-control" id='gst' name='gst' value="<?php echo $customer_data[0]['is_gst'] == 1 ? ($customer_data[0]['gst'] * 100) : '0.00'; ?>" placeholder="Enter G.S.T like 16.00" tabindex=15>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default" id="fuel_div">
																			<label>Fuel Surcharge</label>
																			<input type="number" class="form-control" id='fuel' name='fuel' value="<?php echo $customer_data[0]['is_fuel_surcharge'] == 1 ? ($customer_data[0]['fuel_surcharge'] * 100) : '0.00'; ?>" placeholder="Enter Fuel Surcharge like 5.00" tabindex=16>
																		</div>
																	</div>
																</div>
																<div class="row clearfix">
																	<div class="col-sm-12">
																		<div class="form-group form-group-default" id="others_div">
																			<label>Others</label>
																			<input type="number" class="form-control" id='others' name='others' value="<?php echo $customer_data[0]['is_others_charges'] == 1 ? ($customer_data[0]['others_charges'] * 100) : '0.00'; ?>" placeholder="Enter G.S.T like 16.00" tabindex=17>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<p>Units</p>
															<div class="row clearfix">
																<div class="col-sm-12">
																	<div class="form-group form-group-default required" id="bunit_div">
																		<label>Billable Units</label>
																		<select class='form-control' required name="bunits" id="bunits" tabindex=20>
																			<option value='W' <?php echo $customer_data[0]['billable_unit'] == 'W' ? "selected='selected'" : ''; ?>>Weight</option>
																			<option value='P' <?php echo $customer_data[0]['billable_unit'] == 'P' ? "selected='selected'" : ''; ?>>Piece</option>
																		</select>
																	</div>
																</div>
															</div>
															<br>
															<p>Reference Detail</p>
															<div class="form-group-attached">
																<div class="row clearfix">
																	<div class="col-sm-6">
																		<div class="form-group form-group-default required" id="user_name_div">
																			<label>Reference By</label>
																			<select class="form-control" name='reference_by' id='reference_by' required tabindex=21>
																				<?php
																				if (!empty($reference_data)) {
																					foreach ($reference_data as $rows) {
																						if ($rows->reference_id == $customer_data[0]['reference_by']) {
																							echo ("<option selected value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
																						} else if ($rows->reference_id != $customer_data[0]['reference_by']) {
																							echo ("<option value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
																						}
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group form-group-default">
																			<label>Freelancer Reference By</label>
																			<select class="form-control" name='secondary_reference_by' id='secondary_reference_by' tabindex=22>
																				<?php
																				if (!empty($freelancer_data)) {
																					foreach ($freelancer_data as $rows) {
																						if ($rows->reference_id == $customer_data[0]['secondary_reference_by']) {
																							echo ("<option selected value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
																						} else if ($rows->reference_id != $customer_data[0]['secondary_reference_by']) {
																							echo ("<option value=''>Select Freelancer</option>");
																							echo ("<option value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
																						}
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<button type="submuit" class='btn btn-primary pull-right'>Update Customer Account</button>
														</form>
													</div>
												</div>
											</div>
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
		<script>
			function check_username() {
				var username = $("#user_name").val();
				var mydata = {
					username: username
				};
				$.ajax({
					url: "<?php echo base_url(); ?>Customer/check_username",
					type: "POST",
					data: mydata,
					success: function(data) {
						//  alert(data);
						if (data == 0) {
							$("#user_name_div").css("border-color", "green");
						} else if (data != 0) {
							$("#user_name_div").css("border-color", "red");
							$("#user_name").focus();
						}
					}
				});
			}

			function services() {
				var st = $("#service_type").val();
				if (st.length > 1) {
					for (var i = 0; i < st.length; i++) {
						if (st[i] === '0') {
							st.splice(i, 1);
						}
					}
				}
				console.log(st);

				$("input[name=services_type]:hidden").val(st.join(","));
			}

			function editfaf(ctl) {
				var row = $(ctl).parents("tr");
				var cols = row.children("td");
				var faf = $(cols[0]).text().split("%")[0];
				var fid = $(cols[3]).text();

				$('#faf_id').val(fid);
				$('#c_id').val($('#customer_id').val());

				if (faf > 0) {
					$('#faf').val(faf);
				}

				if ($(cols[1]).text().length > 0) {
					$('#faf_start_date').val($(cols[1]).text());
					$('#faf_start_date').removeAttr('min');
				}

				if ($(cols[2]).text().length > 0) {
					$('#faf_end_date').val($(cols[2]).text());
					$('#faf_end_date').removeAttr('min');
				}

				$('#faf').focus();
			}

			function susfaf(ctl) {
				var row = $(ctl).parents("tr");
				var cols = row.children("td");
				var cf_id = $(cols[3]).text();
				var customer_id = $('#customer_id').val();

				var mydata = {
					cf_id: cf_id
				};

				$.ajax({
					url: "<?php echo base_url(); ?>Customer/suspend_faf",
					type: "POST",
					data: mydata,
					success: function(data) {
						if (data > 0) {
							window.location = "<?php echo base_url(); ?>customer/edit_customer_view/" + customer_id;
						} else {
							$('#msg_div').text("Error");
						}
					}
				});

			}

			function enfaf(ctl) {
				var row = $(ctl).parents("tr");
				var cols = row.children("td");
				var cf_id = $(cols[3]).text();
				var customer_id = $('#customer_id').val();

				var mydata = {
					cf_id: cf_id
				};

				$.ajax({
					url: "<?php echo base_url(); ?>Customer/enable_faf",
					type: "POST",
					data: mydata,
					success: function(data) {
						if (data > 0) {
							window.location = "<?php echo base_url(); ?>customer/edit_customer_view/" + customer_id;
						} else {
							$('#msg_div').text("Error");
						}
					}
				});

			}

			function delfaf(ctl) {
				var row = $(ctl).parents("tr");
				var cols = row.children("td");
				var cf_id = $(cols[3]).text();
				var customer_id = $('#customer_id').val();

				var mydata = {
					cf_id: cf_id
				};

				$.ajax({
					url: "<?php echo base_url(); ?>Customer/delete_faf",
					type: "POST",
					data: mydata,
					success: function(data) {
						window.location = "<?php echo base_url(); ?>customer/edit_customer_view/" + customer_id;
					}
				});

			}
		</script>
	</div>
</div>
<?php
$this->load->view('inc/footer');
?>