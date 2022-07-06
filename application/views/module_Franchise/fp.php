<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<div class="container">
  <h2 class="text-center">Franchise Profile</h2>
  <form action="">
	<button class="btn btn-danger">Back</button>
    <button class="btn btn-success pull-right">Save</button>
	<div class="form-group">
	
		<div class="card">
			<div class="card-header pe-auto" data-toggle="collapse" data-target="#section_general" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> General Information<h5></div>
			<div id="section_general" class="card-body collapse show">
				<div class="form-group">
				  <label for="name">Name:</label>
				  <input type="text" class="form-control" id="name" placeholder="Franchise Name" name="name"></input>
				</div>
				<div class="form-group">
				  <label for="franchisee_type">Franchisee Type:</label>
				  <select class="form-control" id="franchisee_type" placeholder="Franchisee Type" name="franchisee_type">
					<option value="0" selected>Permanent</option>
					<option value="1">Temp</option>
					<option value="2">3rd party</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="franchisee_status">Franchisee status:</label>
				  <select class="form-control" id="franchisee_status" placeholder="Franchisee status" name="franchisee_status">
					<option value="1">Open</option>
					<option value="2">Close</option>
					<option value="3">Freeze</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="location">Location:</label>
				  <select class="form-control" id="location" placeholder="Location" name="location"></select>
				</div>
				<div class="form-group">
				  <label for="date_of_registration">Date of Registration:</label>
				  <input type="date" class="form-control" id="date_of_registration" placeholder="Date of Registration" name="date_of_registration" onkeydown="return false">
				</div>
				<div class="form-group">
				  <label for="agreement_expiry">Agreement Expiry:</label>
				  <input type="date" class="form-control" id="agreement_expiry" placeholder="Agreement Expiry" name="agreement_expiry" onkeydown="return false">
				</div>
			</div>
			
			<div class="card-header" data-toggle="collapse" data-target="#section_contact" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> Contact Inforamtion<h5></div>
			<div id="section_contact" class="card-body collapse show">
				<div class="form-group">
				  <label for="land_line">Land Line No:</label>
				  <input type="text" class="form-control land-line" id="land_line" placeholder="000-00000000" name="land_line"></input>
				</div>
				<div class="form-group">
				  <label for="mobile_no">Mobile No:</label>
				  <input type="text" class="form-control mobile-no" id="mobile_no" placeholder="0000-0000000" name="mobile_no"></input>
				</div>
				<div class="form-group">
				  <label for="sales_territory">Sales Territory:</label>
				  <input type="text" class="form-control" maxlength="100" id="sales_territory" placeholder="Individual Name" name="sales_territory"></input>
				</div>
				<div class="form-group">
				  <label for="address">Address:</label>
				  <textarea class="form-control" maxlength="256" id="address" placeholder="Postal Address" name="address"></textarea>
				</div>
			</div>
			
			<div class="card-header" data-toggle="collapse" data-target="#section_tax" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> Tax Inforamtion<h5></div>
			<div id="section_tax" class="card-body collapse show">
				<div class="form-group">
				  <label for="cnic">CNIC:</label>
				  <input type="text" class="form-control nic" id="cnic" placeholder="00000-0000000-0" name="cnic"></input>
				</div>
				<div class="form-group">
				  <label for="ntn">NTN:</label>
				  <input type="text" class="form-control tax-no" id="ntn" placeholder="0000000-0" name="ntn"></input>
				</div>
				<div class="form-group">
				  <label for="gst_no">GST NO:</label>
				  <input type="text" class="form-control tax-no" id="gst_no" placeholder="0000000-0" name="gst_no"></input>
				</div>
				<div class="form-group">
				  <label for="gst">GST:</label>
				  <select class="form-control" id="gst" placeholder="GST" name="gst">
					<option value="0">0%</option>
					<option value="13">13%</option>
					<option value="16">16%</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="withhold">Tax Withhold:</label>
				  <select class="form-control" id="withhold" placeholder="Tax Withhold" name="withhold">
					<option value="0">0%</option>
					<option value="3">3%</option>
					<option value="6">6%</option>
				  </select>
				</div>
			</div>
			
			<div class="card-header" data-toggle="collapse" data-target="#section_operation" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> Operation Inforamtion<h5></div>
			<div id="section_operation" class="card-body collapse show">
				<div class="form-group">
				  <label for="route">Route:</label>
				  <select class="form-control" id="route" placeholder="Route" name="route"></select>
				</div>
				<div class="form-group">
				  <label for="parent">Parent:</label>
				  <select class="form-control" id="parent" placeholder="Parent" name="parent"></select>
				</div>
				<div class="form-group">
				  <label for="child">Child:</label>
				  <select class="form-control fb-allow-multi-select" id="child" placeholder="Child" name="child" multiple></select>
				</div>
				<div class="form-group">
				  <label for="product">Product:</label>
				  <select class="form-control" id="product" placeholder="Product" name="product">
					<option value="0">Warehouse</option>
					<option value="1">Express</option>
					<option value="2">Air Services</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="service">Service:</label>
				  <select class="form-control" id="service" placeholder="Service" name="service">
					<option value="0">Over Night</option>
					<option value="1">COD</option>
					<option value="2">Detain</option>
				  </select>
				</div>
			</div>	
			
			<div class="card-header" data-toggle="collapse" data-target="#section_billing" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> Billing Inforamtion<h5></div>
			<div id="section_billing" class="card-body collapse show">
				<div class="form-group">
				  <label for="billing_period">Billing Period:</label>
				  <select class="form-control" id="billing_period" placeholder="Billing Period" name="billing_period">
					<option value="0" selected>Monthly</option>
					<option value="1">Weekly</option>
					<option value="2">Forthnihtky</option>
				  </select>
				</div>
				<div class="form-group">
				  <label for="payment_terms">Payment Terms(in days):</label>
				  <input type="number" min="10" max="120" value="10" class="form-control" id="payment_terms" placeholder="Payment Terms(in days)" name="payment_terms"></input>
				</div>
				<div class="form-group">
				  <label for="payment_method">Payment Method:</label>
				  <select class="form-control" id="payment_method" placeholder="Payment Method" name="payment_method">
					<option value="0" selected>Cash</option>
					<option value="1">Cheque</option>
					<option value="2">Jazz Cash</option>
				  </select>
				</div>
			</div>	
			
			<div class="card-header" data-toggle="collapse" data-target="#section_charges" aria-expanded="true" ><h5 class="card-title user-select-none"><i class='fa fa-angle-down'></i> Charges Inforamtion<h5></div>
			<div id="section_charges" class="card-body collapse show">
				<div class="form-group">
				  <label for="delivery_charges" class="card-title user-select-none" >Delivery Charges by location:</label>
				  <div id="delivery_group" class="input-group repeatable removeable">
					<select class="form-control" id="delivery_location" placeholder="Location" name="location"></select>
					<div class="input-group-prepend">
						<span class="input-group-text"> : </span>
					</div>
					<input type="number" min="10" max="120" class="form-control" id="delivery_charges" placeholder="per Consigment in Rupee(Rs)" name="delivery_charges"></input>
					<div class="input-group-prepend">
						<span class="input-group-text btn repeat-target" repeatable-target="delivery_group" ><i class='fa fa-plus '></i></span>
						<span class="input-group-text btn remove-target" remove-target="delivery_group" ><i class='fa fa-close '></i></span>
					</div>
				  </div>
				</div>
				<div class="form-group">
				  <label for="osa">OSA:</label>
				  <input type="number" min="10" max="120" class="form-control" id="osa" placeholder="Out of Service Charges in Rupee(Rs)" name="osa"></input>
				</div>
				<div class="form-group">
				  <label for="bottomline">Bottomline:</label>
				  <input type="number" min="10" max="120" class="form-control" id="bottomline" placeholder="Bottomline in Percentage(%)" name="bottomline"></input>
				</div>
				<div class="form-group">
				  <label for="weight_charges">Weight Charges:</label>
				  <input type="number" min="10" max="120" class="form-control" id="weight_charges" placeholder="Weight Charges per KG in Rupee(Rs)" name="weight_charges"></input>
				</div>
				<div class="form-group">
				  <label for="additional_weight_charges">Additional Weight Charges:</label>
				  <input type="number" min="10" max="120" class="form-control" id="additional_weight_charges" placeholder="Additional Weight Charges per KG in Rupee(Rs)" name="additional_weight_charges"></input>
				</div>
				<div class="form-group">
				  <label for="hr_services">HR Services:</label>
				  <input type="number" min="10" max="120" class="form-control" id="hr_services" placeholder="HR Services Charges per KG in Rupee(Rs)" name="hr_services"></input>
				</div>
				<div class="form-group">
				  <label for="special_pay_off_charges" class="card-title user-select-none" >Special Pay Off Charges:</label>
				  <div id="special_pay_off_charges_group" class="input-group repeatable removeable">
					<input type="text" class="form-control" id="special_pay_off_title" placeholder="Special Pay Off Title" name="special_pay_off_title"></input>
					<div class="input-group-prepend">
						<span class="input-group-text"> : </span>
					</div>
					<input type="number" min="10" max="120" class="form-control" id="special_pay_off_charges" placeholder="per Consigment in Rupee(Rs)" name="special_pay_off_charges"></input>
					<div class="input-group-prepend">
						<span class="input-group-text btn repeat-target" repeatable-target="special_pay_off_charges_group" ><i class='fa fa-plus '></i></span>
						<span class="input-group-text btn remove-target" remove-target="special_pay_off_charges_group" ><i class='fa fa-close '></i></span>
					</div>
				  </div>
				</div>
				<div class="form-group">
				  <label for="incoming_material">Incoming  Material:</label>
				  <input type="number" min="10" max="120" class="form-control" id="incoming_material" placeholder="Incoming  Material in Rupee(Rs)" name="incoming_material"></input>
				</div>
				<div class="form-group">
				  <label for="out_going_material">Out Going Material:</label>
				  <input type="number" min="10" max="120" class="form-control" id="out_going_material" placeholder="Out Going Material Charges per KG in Rupee(Rs)" name="out_going_material"></input>
				</div>
			</div>	
		</div>
  </form>
</div>
<?php
$this->load->view('inc/footer');
?>
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2-bootstrap.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select2/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/module_invoices/invoicecreateView.js"></script>
<script src="<?php echo base_url();?>assets/js/module_franchises/fb.js"></script>

