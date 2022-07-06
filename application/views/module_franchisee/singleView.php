<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#franchisee_type').select2({
			placeholder: "Select Type"
		});

		$('#franchisee_status').select2({
			placeholder: "Select Status"
		});

		$('#location').select2({
			placeholder: "Select Location"
		});

		/*$('#parent').select2({
			placeholder:"Select Location"	
		});*/

		$('#child').select2({
			placeholder: "Select Locations"
		});

		$('#sales_person').select2({
			placeholder: "Select Sales Officer"
		});

		$('#service').select2({
			placeholder: "Select Services"
		});

		$('#billing_period').select2({
			placeholder: "Select a Billing Period"
		});

		$('#payment_method').select2({
			placeholder: "Select a Payment Method"
		});

		<?php
		if (isset($fran_data)) {
			echo ("$('#franchisee_type').val(" . $fran_data[0]['type_id'] . ").trigger('change');");
			echo ("$('#franchisee_status').val(" . $fran_data[0]['sts'] . ").trigger('change');");
			echo ("$('#location').val(" . $fran_data[0]['city_id'] . ").trigger('change');");
			echo ("$('#sales_person').val(" . $fran_data[0]['person_id'] . ").trigger('change');");
			echo ("$('#billing_period').val(" . $fran_data[0]['b_cycle'] . ").trigger('change');");
			echo ("$('#payment_method').val(" . $fran_data[0]['pay_method'] . ").trigger('change');");
		}

		if (isset($fran_services)) {
			$a = array_column($fran_services, 'services_id');
			$b = implode(",", $a);

			echo ("$('#service').val([" . $b . "]).trigger('change');");
		}

		if (isset($fran_locs_data)) {
			$a = array_column($fran_locs_data, 'city_id');
			unset($a[$fran_data[0]['city_id']]);
			$b = implode(",", $a);

			echo ("$('#child').val([" . $b . "]).trigger('change');");
		}

		if (isset($fran_rates)) {
			$a = array_column($fran_rates, 'min', 'loc_id');
			foreach ($a as $id => $value) {
				if ($id == $fran_data[0]['city_id']) {
					echo ("$('#delivery_charges').val(" . $value . ");");
				} else {
					echo ("if ($('#child_charges_" . $id . "').length) { $('#child_charges_" . $id . "').val(" . $value . "); }");
				}
			}
		}
		?>
	});
</script>

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
	<!-- START PAGE CONTENT -->
	<div class="content">
		<!-- START CONTAINER FLUID -->
		<div class="jumbotron" data-pages="parallax">
			<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
				<div class="inner">
					<!-- START BREADCRUMB -->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Franchisee</li>
						<li class="breadcrumb-item">Add New Franchisee</li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid container-fixed-lg bg-gray">
						<div class="row">
							<!--------------Right Side End----------->
							<div class="col-md-12">
								<div class="card m-t-10">
									<?php print_r($fran_locs_data) ?>
									<form role="form" id="add_fran" name="add_forn" action="<?php echo isset($fran_data[0]['fr_id']) ? base_url() . "Franchisee/update_franchisee" : base_url() . "Franchisee/add_new_franchisee" ?>" method="POST">
										<input type="hidden" id="fr_id" name="fr_id" value="<?php echo isset($fran_data[0]['fr_id']) ? $fran_data[0]['fr_id'] : "" ?>" />
										<div class="card-body">
											<div class="card-header pe-auto" data-toggle="collapse" data-target="#section_general" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> General Information<h4>
											</div>
											<div id="section_general" class="card-body collapse show">
												<div class="form-group">
													<label for="name">Name:</label>
													<input type="text" class="form-control" id="name" placeholder="Franchise Name" name="name" value="<?php echo isset($fran_data[0]['fran_name']) ? $fran_data[0]['fran_name'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="code">Code:</label>
													<input type="text" class="form-control" id="code" placeholder="Franchise Code" name="code" value="<?php echo isset($fran_data[0]['fran_code']) ? $fran_data[0]['fran_code'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="franchisee_type">Franchisee Type:</label>
													<select class="form-control" id="franchisee_type" name="franchisee_type">
														<option></option>
														<?php if (!empty($fran_type)) {
															foreach ($fran_type as $types) {
																echo ("<option value='" . $types->acc_types_short . "'>" . $types->acc_types_full . "</option>");
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="franchisee_status">Franchisee status:</label>
													<select class="form-control" id="franchisee_status" name="franchisee_status">
														<option></option>
														<?php if (!empty($fran_status)) {
															foreach ($fran_status as $types) {
																echo ("<option value='" . $types->acc_types_short . "'>" . $types->acc_types_full . "</option>");
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="location">Location:</label>
													<select class="form-control" id="location" name="location" onchange="location_change()">
														<option></option>
														<?php if (!empty($locs)) {
															foreach ($locs as $types) {
																echo ("<option value='" . $types->city_id . "'>" . $types->city_short_code . " : " . $types->city_full_name . "</option>");
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="date_of_registration">Date of Registration:</label>
													<input type="date" class="form-control" id="date_of_registration" placeholder="Date of Registration" name="date_of_registration" onkeydown="return false" value="<?php echo isset($fran_data[0]['reg_date']) ? $fran_data[0]['reg_date'] : date('Y-m-01') ?>">
												</div>
												<div class="form-group">
													<label for="agreement_expiry">Agreement Expiry:</label>
													<input type="date" class="form-control" id="agreement_expiry" placeholder="Agreement Expiry" name="agreement_expiry" onkeydown="return false" value="<?php echo isset($fran_data[0]['arg_exp']) ? $fran_data[0]['arg_exp'] : date('Y-m-t', strtotime('next year')); ?>">
												</div>
											</div>

											<div class="card-header" data-toggle="collapse" data-target="#section_contact" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> Contact Inforamtion<h5>
											</div>
											<div id="section_contact" class="card-body collapse show">
												<div class="form-group">
													<label for="land_line">Land Line No:</label>
													<input type="text" class="form-control land-line" id="land_line" placeholder="000-00000000" name="land_line" value="<?php echo isset($fran_data[0]['fran_ll']) ? $fran_data[0]['fran_ll'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="mobile_no">Mobile No:</label>
													<input type="text" class="form-control mobile-no" id="mobile_no" placeholder="0000-0000000" name="mobile_no" value="<?php echo isset($fran_data[0]['fran_mob']) ? $fran_data[0]['fran_mob'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="sales_person">Sales Territory Officer:</label>
													<select class="form-control" id="sales_person" name="sales_person">
														<option></option>
														<?php if (!empty($sales_team)) {
															foreach ($sales_team as $person) {
																echo ("<option value='" . $person->reference_id . "'>" . $person->reference_name . "</option>");
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="address">Address:</label>
													<textarea class="form-control" maxlength="512" id="address" placeholder="Postal Address" name="address"><?php echo isset($fran_data[0]['fran_address']) ? $fran_data[0]['fran_address'] : "" ?></textarea>
												</div>
											</div>

											<div class="card-header" data-toggle="collapse" data-target="#section_tax" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> Tax Inforamtion<h5>
											</div>
											<div id="section_tax" class="card-body collapse show">
												<div class="form-group">
													<label for="cnic">CNIC:</label>
													<input type="text" class="form-control nic" id="cnic" placeholder="00000-0000000-0" name="cnic" value="<?php echo isset($fran_data[0]['cnic']) ? $fran_data[0]['cnic'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="ntn">NTN:</label>
													<input type="text" class="form-control tax-no" id="ntn" placeholder="0000000-0" name="ntn" value="<?php echo isset($fran_data[0]['ntn']) ? $fran_data[0]['ntn'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="gst_no">GST NO:</label>
													<input type="text" class="form-control tax-no" id="gst_no" placeholder="0000000-0" name="gst_no" value="<?php echo isset($fran_data[0]['gst_no']) ? $fran_data[0]['gst_no'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="gst">GST:</label>
													<input type="number" class="form-control tax-no" id="gst" placeholder="16" name="gst" value="<?php echo isset($fran_data[0]['gst']) ? $fran_data[0]['gst'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="withhold">Tax Withhold:</label>
													<input type="number" class="form-control tax-no" id="withhold" placeholder="10" name="withhold" value="<?php echo isset($fran_data[0]['wht']) ? $fran_data[0]['wht'] : "" ?>" />
												</div>
											</div>

											<div class="card-header" data-toggle="collapse" data-target="#section_operation" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> Operation Inforamtion<h5>
											</div>
											<input type="hidden" id="fr_rt_id" name="fr_rt_id" value="<?php echo isset($fran_route_data[0]['fran_route_id']) ? $fran_route_data[0]['fran_route_id'] : 0 ?>" />
											<div id="section_operation" class="card-body collapse show">
												<div class="form-group">
													<label for="route">Route:</label>
													<input class="form-control" type="text" id="route" placeholder="Route" name="route" value="<?php echo isset($fran_route_data[0]['route_id']) ? $fran_route_data[0]['route_id'] : "" ?>" />
												</div>
												<!--<div class="form-group">
												<label for="parent">Parent:</label>
												<select class="form-control" id="parent" placeholder="Parent" name="parent">
												<option></option>
												<?php if (!empty($locs)) {
													foreach ($locs as $types) {
														echo ("<option value='" . $types->city_id . "'>" . $types->city_short_code . " : " . $types->city_full_name . "</option>");
													}
												}
												?>
												</select>												
											</div> -->
												<div class="form-group">
													<label for="child">Child:</label>
													<select class="form-control" id="child" placeholder="Child" name="child" multiple onchange="child_change()">
														<option></option>
														<?php if (!empty($locs)) {
															foreach ($locs as $types) {
																echo ("<option value='" . $types->city_id . "'>" . $types->city_short_code . " : " . $types->city_full_name . "</option>");
															}
														}
														?>
													</select>
												</div>
												<!-- <div class="form-group">
												<label for="product">Product:</label>
												<select class="form-control" id="product" placeholder="Product" name="product">
													<option value="0">Warehouse</option>
													<option value="1">Express</option>
													<option value="2">Air Services</option>
												</select>
											</div> -->
												<div class="form-group">
													<input type="hidden" id="services" name="services" value="" />
													<label for="service">Service:</label>
													<select class="form-control" id="service" placeholder="Service" name="service" multiple>
														<option></option>
														<?php if (!empty($services)) {
															foreach ($services as $types) {
																echo ("<option value='" . $types->service_id . "'>" . $types->service_code . " : " . $types->service_name . "</option>");
															}
														}
														?>
													</select>
												</div>
											</div>

											<div class="card-header" data-toggle="collapse" data-target="#section_billing" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> Billing Inforamtion<h5>
											</div>
											<div id="section_billing" class="card-body collapse show">
												<div class="form-group">
													<label for="billing_period">Billing Period:</label>
													<select class="form-control" id="billing_period" placeholder="Billing Period" name="billing_period">
														<option></option>
														<?php if (!empty($fran_bill_perd)) {
															foreach ($fran_bill_perd as $types) {
																echo ("<option value='" . $types->acc_types_short . "'>" . $types->acc_types_full . "</option>");
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="payment_terms">Payment Terms(in days):</label>
													<input type="number" class="form-control" id="payment_terms" placeholder="Payment Terms(in days)" name="payment_terms" value="<?php echo isset($fran_data[0]['pay_terms_days']) ? $fran_data[0]['pay_terms_days'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="payment_method">Payment Method:</label>
													<select class="form-control" id="payment_method" placeholder="Payment Method" name="payment_method">
														<option></option>
														<?php if (!empty($fran_pay_meth)) {
															foreach ($fran_pay_meth as $types) {
																echo ("<option value='" . $types->acc_types_short . "'>" . $types->acc_types_full . "</option>");
															}
														}
														?>
													</select>
												</div>
											</div>

											<div class="card-header" data-toggle="collapse" data-target="#section_charges" aria-expanded="true">
												<h4 class="user-select-none"><i class='fa fa-angle-down'></i> Charges Inforamtion<h5>
											</div>
											<input type="hidden" id="loc_chrg" name="loc_chrg" value="" />
											<div id="section_charges" class="card-body collapse show">
												<div class="form-group">
													<label for="delivery_charges" class="card-title user-select-none">Delivery Charges by location:</label>
													<div id="delivery_group" class="input-group repeatable removeable">
														<input class="form-control" id="delivery_location" placeholder="Location" name="delivery_location" readonly></input>
														<div class="input-group-prepend">
															<span class="input-group-text"> : </span>
														</div>
														<input type="number" class="form-control" id="delivery_charges" placeholder="per Consigment in Rupee(Rs)" name="delivery_charges"></input>
														<!--<div class="input-group-prepend">
														<span class="input-group-text btn repeat-target" repeatable-target="delivery_group"><i class='fa fa-plus '></i></span>
														<span class="input-group-text btn remove-target" remove-target="delivery_group"><i class='fa fa-close '></i></span>
													</div>-->
													</div>
													<div id="child_charges" class="input-group repeatable removeable">

													</div>
												</div>
												<div class="form-group">
													<label for="osa">OSA:</label>
													<input type="number" class="form-control" id="osa" placeholder="Out of Service Charges in Rupee(Rs)" name="osa" value="<?php echo isset($fran_data[0]['osa']) ? $fran_data[0]['osa'] : "" ?>">
												</div>
												<div class="form-group">
													<label for="bottomline">Bottomline:</label>
													<input type="number" class="form-control" id="bottomline" placeholder="Bottomline in Percentage(%)" name="bottomline" value="<?php echo isset($fran_data[0]['btm_rev']) ? $fran_data[0]['btm_rev'] : "" ?>" />
												</div>
												<input type="hidden" id="fr_wt_id" name="fr_wt_id" value="<?php echo isset($fran_wt_chrg_data[0]['fran_rates_id']) ? $fran_wt_chrg_data[0]['fran_rates_id'] : 0 ?>" />
												<div class="form-group">
													<label for="weight_charges_min">Weight Charges:</label>
													<div class="row">
														<div class="col-6">
															<input type="number" class="form-control" id="weight_charges_min" placeholder="Min Weight Charges per KG in Rupee(Rs)" name="weight_charges_min" value="<?php echo isset($fran_wt_chrg_data[0]['min']) ? $fran_wt_chrg_data[0]['min'] : "" ?>" />
														</div>
														<div class="col-6">
															<input type="number" class="form-control" id="weight_charges_max" placeholder="Max Weight Charges per KG in Rupee(Rs)" name="weight_charges_max" value="<?php echo isset($fran_wt_chrg_data[0]['max']) ? $fran_wt_chrg_data[0]['max'] : "" ?>" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="additional_weight_charges">Additional Weight Charges:</label>
													<input type="number" class="form-control" id="additional_weight_charges" placeholder="Additional Weight Charges per KG in Rupee(Rs)" name="additional_weight_charges" value="<?php echo isset($fran_wt_chrg_data[0]['additional']) ? $fran_wt_chrg_data[0]['additional'] : "" ?>" />
												</div>
												<div class="form-group">
													<label for="hr_services">HR Services:</label>
													<input type="number" class="form-control" id="hr_services" placeholder="3rd Party Salary" name="hr_services" value="<?php echo isset($fran_data[0]['hr_srv']) ? $fran_data[0]['hr_srv'] : "" ?>" />
												</div>
												<!-- <div class="form-group">
												<label for="special_pay_off_charges" class="card-title user-select-none">Special Pay Off Charges:</label>
												<div id="special_pay_off_charges_group" class="input-group repeatable removeable">
													<input type="text" class="form-control" id="special_pay_off_title" placeholder="Special Pay Off Title" name="special_pay_off_title"></input>
													<div class="input-group-prepend">
														<span class="input-group-text"> : </span>
													</div>
													<input type="number" min="10" max="120" class="form-control" id="special_pay_off_charges" placeholder="per Consigment in Rupee(Rs)" name="special_pay_off_charges"></input>
													<div class="input-group-prepend">
														<span class="input-group-text btn repeat-target" repeatable-target="special_pay_off_charges_group"><i class='fa fa-plus '></i></span>
														<span class="input-group-text btn remove-target" remove-target="special_pay_off_charges_group"><i class='fa fa-close '></i></span>
													</div>
												</div>
											</div> -->
												<div class="form-group">
													<label for="special_pay_off_charges" class="card-title user-select-none">Special Pay Off Charges:</label>
													<input type="number" class="form-control" id="special_pay_off_charges" placeholder="Special Pay Off Charges" name="special_pay_off_charges" value="<?php echo isset($fran_data[0]['sp_payoff']) ? $fran_data[0]['sp_payoff'] : "" ?>" />
												</div>
												<!-- <div class="form-group">
												<label for="incoming_material">Incoming Material:</label>
												<input type="number" min="10" max="120" class="form-control" id="incoming_material" placeholder="Incoming  Material in Rupee(Rs)" name="incoming_material"></input>
											</div>
											<div class="form-group">
												<label for="out_going_material">Out Going Material:</label>
												<input type="number" min="10" max="120" class="form-control" id="out_going_material" placeholder="Out Going Material Charges per KG in Rupee(Rs)" name="out_going_material"></input>
											</div> -->
											</div>
										</div>
										<div class="card-footer">
											<div class="form-group-attached">
												<div class="row clearfix">
													<div class="col-6 text-right">
														<input type="button" class="btn btn-info m-r-5" onclick="final_call();" tabindex="35" value="<?php echo isset($fran_data[0]['fr_id']) ? "Update" : "Save" ?>" />
													</div>
													<div class="col-6">
														<input type="reset" class="btn btn-default m-l-5" value="Clear" />
													</div>
												</div>
											</div>
										</div>
								</div>
								</form>
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

<script type="text/javascript">
	function location_change() {
		var data = $('#location').select2('data');
		$('#delivery_location').val(data[0].text);
	}

	function child_change() {
		var data = $('#child').select2('data');
		var parent = $('#location').select2('data');
		var innerhtml = "";
		data.forEach(function(item) {
			if (parent[0].id != item.id) {
				innerhtml = innerhtml + "<div id='delivery_group_" + item.id + "' class='input-group repeatable removeable'>" +
					"<input class='form-control' id='child_location_" + item.id + "' placeholder='Location' name='child_location_" + item.id + "' value = '" + item.text + "' readonly></input> " +
					"<div class='input-group-prepend'> " +
					"<span class='input-group-text'> : </span> " +
					"</div> " +
					"<input type='number' min='10' max='120' class='form-control' id='child_charges_" + item.id + "' placeholder='per Consigment in Rupee(Rs)' name='child_charges_" + item.id + "'></input> " +
					/*"<div class='input-group-prepend'> " +
					"<span class='input-group-text btn repeat-target' repeatable-target='delivery_group'><i class='fa fa-plus '></i></span> " +
					"<span class='input-group-text btn remove-target' remove-target='delivery_group'><i class='fa fa-close '></i></span> " +
					"</div>" +*/
					"</div>";
			}
		})
		$('#child_charges').html(innerhtml);
	}

	/*function parent_chrgs() {
		var dlv_chrgs = $('#delivery_charges').val();
		var parent = $('#location').select2('data');
		if ((dlv_chrgs.length > 0) && (parent.length > 0)) {
			var chrgs = $('#loc_chrg').val();
			var new_chrgs = chrgs + parent[0].id + "," + dlv_chrgs + "|";
			$('#loc_chrg').val(new_chrgs);
			console.log(new_chrgs);
		} else {
			alert("Either select a location or enter valid charges");
		}
	}

	function child_chrgs(elm) {
		var dlv_chrgs = $(elm).val();
		if (dlv_chrgs.length > 0) {
			var chrgs = $('#loc_chrg').val();
			var c_loc = ($(elm).attr('id')).split('child_charges_')[1];
			var new_chrgs = chrgs + c_loc + "," + dlv_chrgs + "|";
			$('#loc_chrg').val(new_chrgs);
			console.log(new_chrgs);
		} else {
			alert("Enter valid charges");
		}
	}*/

	function final_call() {
		const charges = {};
		var chk = true;
		var focus_control = "";

		var parent_id = $('#location').select2('data')[0].id;
		var parent_chrgs = $('#delivery_charges').val();

		if (parent_chrgs.length > 0 && parent_id.length > 0) {
			charges[parent_id] = parent_chrgs;
		} else {
			chk = false;
			focus_control = "#delivery_charges";
			alert("Either enter valild location of charges");
		}

		var child_data = $('#child').select2('data');
		var c_val = "";
		child_data.forEach(function(item) {
			c_val = $('#child_charges_' + item.id).val();
			if (c_val.length > 0) {
				charges[item.id] = c_val;
			} else {
				chk = false;
				focus_control = "#child_charges_" + item.id;
				alert("Enter valid charges");
			}
		})

		if (chk) {
			$('#services').val($('#service').select2('val'));
			$('#loc_chrg').val(JSON.stringify(charges));
			$('#add_fran').submit(function() {
				this.submit();
			});
			$('#add_fran').submit();
		} else {
			$(focus_control).focus();
			$('#add_fran').submit(function(e) {
				e.preventDefault(e);
			});
		}
	}
</script>

<?php
$this->load->view('inc/footer');
?>