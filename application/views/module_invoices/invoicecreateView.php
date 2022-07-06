<?php
error_reporting(0);
$this->load->view('inc/header');
?>
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
						<li class="breadcrumb-item">Invoice</li>
						<li class="breadcrumb-item">Create Invoices</li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>



		<div class=" container-fluid   container-fixed-lg bg-gray">
			<div class="row justify-content-center">

				<div id="section_filters" class="col-md-3">
					<div class="card m-t-10">
						<div class="card-header  separator bg-light">
							<span>Invoices Criteria</span>
							<button id="apply" name="apply"
								class='pull-right btn btn-primary' value="apply">Fetch</button>
						</div>
						<div class="card-body">
							<!--<form role="form"> -->

							<div class="form-group" id="invoice_date_div">
								<label>From Date</label> <!--<span class="help">e.g. "2019-08-23"</span>-->
								<input type="date" id="invoice_date" name="invoice_date" onkeydown="return false"
									value="<?php echo date('Y-m-d'); ?>" class="form-control"
									tabindex="1">
							</div>
							<div class="form-group" id="invoice_date_f_div">
								<label>To Date</label> <!--<span class="help">e.g. "2019-08-23"</span>-->
								<input type="date" id="invoice_date_f" name="invoice_date_f" onkeydown="return false"
									value="<?php echo date('Y-m-d'); ?>" class="form-control"
									tabindex="2">
							</div>


							<div class="form-group hide" id="origin_div">
								<label>Origin</label> <!--<span class="help">Eatbunny</span> --> 
								<select
									multiple class="form-control allow-multi-select" id="origin"
									name="origin" tabindex="3">
									<!-- <option value="" disabled selected>Select Origin</option> -->
<?php

if (! empty($city_data)) {
    foreach ($city_data as $rows) {
        echo ("<option value='" . $rows->id . "' data-gst='" . $rows->is_gst . "' >" . $rows->name . "</option>");
    }
}
?>
</select>
							</div>

							<div class="form-group hide" id="destination_div">
								<label>Destination</label> <!-- <span class="help">Eatbunny</span> --> 
								<select
									multiple class="form-control allow-multi-select"
									id="destination" name="destination" tabindex="3">
									<!-- <option value="" disabled selected>Select Destination</option> -->
<?php

if (! empty($city_data)) {
    foreach ($city_data as $rows) {
        echo ("<option value='" . $rows->id . "'>" . $rows->name . "</option>");
    }
}
?>
</select>
							</div>


							<div class="form-group" id="customer_div">
								<label>Customer</label> <!-- <span class="help">Eatbunny</span> -->
								 <select
									multiple class="form-control allow-multi-select" id="customer"
									name="customer" tabindex="3">
									<!-- <option value="" disabled selected>Select Customer</option> -->
<?php

if (! empty($customer_data)) {
    foreach ($customer_data as $rows) {
        echo ("<option value='" . $rows->id . "' data-gst='" . $rows->is_gst . "' >" . $rows->name . " (" . $rows->city . ")</option>");
    }
}
?>
</select>
							</div>

						</div>
					</div>
				</div>
				<div id="section_optionals" class="col-md-2 hide" disabled>
					<div class="card m-t-10">
						<div class="card-header  separator bg-light">
							<button id="cancel" name="cancel"
								class='pull-left btn btn-danger' value="cancel">Back</button>
							<button id="save" name="save" class='pull-right btn btn-success'
								value="save">Save</button>
						</div>
						<div class="card-header  separator bg-secondary text-white"
							style="text-align: center;">
							<b><span>OPTIONAL CHARGES</span></b>
						</div>
						<div class="card-body">






							<div class="form-group">
								<label>Fuel Surcharge</label>
								<!--<span class="help">if any	(Optional)</span>-->
								<input type="number" min="0" name="fuel_amount" id="fuel_amount"
									class="form-control" tabindex="7">
							</div>

							<div class="form-group">
								<label>Discount Amount </label>
								<!-- <span class="help">if any (Optional)</span> -->
								<input type="number" min="0" name="discount_amount"
									id="discount_amount" class="form-control" tabindex="8">
							</div>
							<div class="form-group">
								<label>Other Type</label>
								<!--<span class="help">if any (Optional)</span>-->
								<select type="text" name="other" id="other" class="form-control"
									tabindex="5">
									<option value="">Other Option</option>
									<option value="Lifter Charges">Lifter Charges</option>
									<option value="Loading / Unloading Charge">Loading/Unloading
										Charge</option>
									<option value="Driver Charge">Driver Charge</option>
								</select>
							</div>
							<div class="form-group">
								<label>Other Amount </label>
								<!--<span class="help">if any (Optional)</span>-->
								<input type="number" min="0" name="other_amount"
									id="other_amount" class="form-control" tabindex="6">
							</div>
							<div class="form-group">
								<label>Remark</label>
								<!-- <span class="help">if any (Optional)</span> -->
								<textarea name="remark" id="remark" class="form-control"
									maxlength="256" tabindex="9" rows="6"></textarea>
							</div>

						</div>
					</div>
				</div>



				<div id="section_invoices" class="col hide">
					
					<div class="card m-t-10">
						<div class="card-header  separator">
							<div class=" bg-success" style="width: 0%;">
								<div class="card-title"><span>Invoices</span></div>
							</div>
							


						</div>
						
								<div class="progress" style="height:25px;">
  									<div id="pbar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
								</div>
							
						<!--<div id="customers_invoice" class="panel-group"></div>-->
						<div id="customers_invoice" class="accordion"></div>
						

					</div>
				</div>




				<!-- END card -->
			</div>

		</div>

	</div>
</div>
<?php
$this->load->view('inc/footer');
?>

<link
	href="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2.css"
	rel="stylesheet" />
<link
	href="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2-bootstrap.css"
	rel="stylesheet" />
<script
	src="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2.min.js"></script>
<script
	src="<?php echo base_url();?>assets/js/module_invoices/invoicecreateView.js"></script>