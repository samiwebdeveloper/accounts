<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<div class="container-fluid">
	
	<nav class="navbar navbar-dark bg-light"></nav>
	
	<nav class="navbar navbar-dark bg-dark">
		<button id="cancel" name="cancel" class="btn btn-outline-danger my-2 my-sm-0 pull-right" >Cancel</button>
		<h1><span class="navbar-brand mb-0 h1">Franchise Profile</span></h1>
		<button id="save" name="save" class="btn btn-outline-success my-2 my-sm-0 pull-right" >Save</button>
	</nav>
	
	<form>
	<div class="card">
		<div class="card-header pe-auto" data-toggle="collapse" data-target="#section_general" aria-expanded="true" >
			<h5 class="card-title user-select-none">
				<i class="fa fa-angle-down"></i>
				<span>Franchise Information</span>
			</h5>
		</div>
		<div id="section_general" class="card-body collapse show">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group"> 
								<div class="input-group-prepend"><span class="input-group-text" for="name">Name</span></div>
								<input type="text" class="form-control" id="name" placeholder="Name" name="name"></input>
							
								<div class="input-group-append"><span for="name" class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span for="name" class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>
							</div>
						</div>
						<div class="form-group col-md-6"> 
							<div class="input-group"> 	
							<div class="input-group-prepend"><span class="input-group-text" for="franchisee_status">Franchisee status</span></div>
							  <select class="form-control" id="franchisee_status" placeholder="Franchisee status" name="franchisee_status">
								<option value="1">Open</option>
								<option value="2">Close</option>
								<option value="3">Freeze</option>
							  </select>
								<div class="input-group-append hidden"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

							</div>	  
							
						</div>
					</div>
					<div class="row">
						
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="manual_number">Manual Number</span></div>
						  <input type="text" class="form-control nic" id="manual_number" name="manual_number" placeholder="Manual Number" ></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="cnic">CNIC #</span></div>
						  <input type="text" class="form-control nic" id="cnic" placeholder="00000-0000000-0" name="cnic"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						
						

					</div>
					<div class="row">

						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="ntn">NTN #</span></div>
						  <input type="text" class="form-control tax-no" id="ntn" placeholder="0000000-0" name="ntn"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="gst_no">GST #</span></div>
						  <input type="text" class="form-control tax-no" id="gst_no" placeholder="0000000-0" name="gst_no"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>

					
					
					</div>
					<div class="row">
						<div class="form-group col-md-6">
								<div class="input-group"> 
								  <div class="input-group-prepend"><span class="input-group-text" for="location">Company Email</span></div>
								  <input type="text" class="form-control" id="company_email" name="company_email" placeholder="Company Email" ></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

								</div>
						</div>
						<div class="form-group col-md-6"> 
								<div class="input-group"> 
								  <div class="input-group-prepend"><span class="input-group-text" for="location">Personal Email</span></div>
								  <input type="text" class="form-control" id="personal_email" name="personal_email" placeholder="Personal Email" ></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

								</div>
						</div>
					</div>
					<div class="row">
					<div class="form-group col-md-6">
								<div class="input-group"> 
								  <div class="input-group-prepend"><span class="input-group-text" for="service_area">Service Area</span></div>
								  <select class="form-control" id="service_area" placeholder="Service Area" name="service_area"></select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

								</div>
						</div>
					<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="land_line">Phone #</span></div>
						  <input type="text" class="form-control land-line" id="land_line" placeholder="000-00000000" name="land_line"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
					</div>
					<div class="row">
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="mobile_no">Cell #</span></div>
						  <input type="text" class="form-control mobile-no" id="mobile_no" placeholder="0000-0000000" name="mobile_no"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="mobile_no">Other Cell #</span></div>
						  <input type="text" class="form-control mobile-no" id="other_mobile_no" placeholder="0000-0000000" name="other_mobile_no"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						
					</div>
					<div class="row">
						
						
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="province">Province</span></div>
						  <select class="form-control" id="province" placeholder="Province" name="province">
							<option value="1">Azad Jammu and Kashmir</option>
							<option value="2">Balochistan</option>
							<option value="3">Gilgit-Baltistan</option>
							<option value="4">Islamabad Capital Territory</option>
							<option value="5">Khyber Pakhtunkhwa</option>
							<option value="6">Punjab</option>
							<option value="7">Sindh</option>
						  </select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						<div class="form-group col-md-6"><div class="input-group"> 
						  <div class="input-group-prepend"><span class="input-group-text" for="city">City</span></div>
						  <select class="form-control" id="city" placeholder="City" name="city"></select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						</div></div>
						
						
					</div>
				</div>
				
				<div class="form-group col-md-4">
					<input accept="image/*" type="file" id="imgInp" />
					<a asp-area="" asp-controller="Galerie" asp-action="FotoNunta">
						<img id="blah" class="image-card img-fluid img-thumbnail" src="" alt="" />
					</a>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<div class="input-group"> 
						<div class="input-group-prepend">
							<span class="input-group-text" for="address">Address</span>
						</div>
						<textarea class="form-control" maxlength="256" id="address" placeholder="Postal Address" name="address"></textarea>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	
		
	
	<div class="card">
		<div class="card-header pe-auto" data-toggle="collapse" data-target="#section_business_type" aria-expanded="true" >
			<h5 class="card-title user-select-none">
				<i class="fa fa-angle-down"></i>
				<span>Business Type</span>
			</h5>
		</div>
		<div id="section_business_type" class="card-body collapse show">
			<div class="row">
				<div class="form-group col-md-4">
					
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="franchisee_type">Franchisee Type</span></div>
							<select class="form-control" id="franchisee_type" placeholder="Franchisee Type" name="franchisee_type">
								<option value="0" selected>Permanent</option>
								<option value="1">Temp</option>
								<option value="2">3rd party</option>
							</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="service">Service</span></div>
						<select class="form-control" id="service" placeholder="Service" name="service">
							<option value="0">Over Night</option>
							<option value="1">COD</option>
							<option value="2">Detain</option>
						</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="route">Route</span></div>
						<select class="form-control" id="route" placeholder="Route" name="route"></select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="product">Product</span></div>
						<select class="form-control" id="product" placeholder="Product" name="product">
							<option value="0">Warehouse</option>
							<option value="1">Express</option>
							<option value="2">Air Services</option>
						</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				<div class="form-group col-md-4">

					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="billing_period">Billing Period</span></div>
							<select class="form-control" id="billing_period" placeholder="Billing Period" name="billing_period">
								<option value="0" selected>Monthly</option>
								<option value="1">Weekly</option>
								<option value="2">Forthnihtky</option>
							</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>

				</div>
				<div class="form-group col-md-4">

					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="sales_territory">Sales Territory</span></div>
						<input type="text" class="form-control" maxlength="100" id="sales_territory" placeholder="Individual Name" name="sales_territory"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>

				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="payment_method">Payment Method</span></div>
						<select class="form-control" id="payment_method" placeholder="Payment Method" name="payment_method">
							<option value="0" selected>Cash</option>
							<option value="1">Cheque</option>
							<option value="2">Jazz Cash</option>
						</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				<div class="form-group col-md-4">
					
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="date_of_registration">Date of Registration</span></div>
						<input type="date" class="form-control" id="date_of_registration" placeholder="Date of Registration" name="date_of_registration">
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
					
				</div>
				<div class="form-group col-md-4">
					
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text" for="agreement_expiry">Agreement Expiry</span></div>
						<input type="date" class="form-control" id="agreement_expiry" placeholder="Agreement Expiry" name="agreement_expiry">
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header pe-auto" data-toggle="collapse" data-target="#section_billing_info" aria-expanded="true" >
			<h5 class="card-title user-select-none">
				<i class="fa fa-angle-down"></i>
				<span>Billing Info</span>
			</h5>
		</div>
		<div id="section_billing_info" class="card-body collapse show">
		
			<div class="row">
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="payment_terms">Payment Terms(in days)</span></div>
						<input type="number" min="10" max="120" value="10" class="form-control" id="payment_terms" placeholder="Payment Terms(in days)" name="payment_terms"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="hr_services">HR Services</span></div>
						<input type="number" min="10" max="120" class="form-control" id="hr_services" placeholder="HR Services Charges per KG in Rupee(Rs)" name="hr_services"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
				  
						<div class="input-group-prepend"><span class="input-group-text" for="osa">OSA</span></div>
						<input type="number" min="10" max="120" class="form-control" id="osa" placeholder="Out of Service Charges in Rupee(Rs)" name="osa"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

						
					</div>
				
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4">
					
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="transit_adjustment">Transit Adjustment</span></div>
						<input type="number" min="10" max="120" class="form-control" id="transit_adjustment" placeholder="Transit Adjustment in Rupee(Rs)" name="transit_adjustment"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">

					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="incoming_material">Incoming  Material</span></div>
						<input type="number" min="10" max="120" class="form-control" id="incoming_material" placeholder="Incoming  Material in Rupee(Rs)" name="incoming_material"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>

				</div>
				
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="out_going_material">Out Going Material</span></div>
						<input type="number" min="10" max="120" class="form-control" id="out_going_material" placeholder="Out Going Material Charges per KG in Rupee(Rs)" name="out_going_material"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="gst">GST</span></div>
						<select class="form-control" id="gst" placeholder="GST" name="gst">
							<option value="0">0%</option>
							<option value="13">13%</option>
							<option value="16">16%</option>
						</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">
					
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="withhold">Tax Withhold</span></div>
						<select class="form-control" id="withhold" placeholder="Tax Withhold" name="withhold">
							<option value="0">0%</option>
							<option value="3">3%</option>
							<option value="6">6%</option>
						</select>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">
				
				<div class="input-group"> 
					<div class="input-group-prepend"><span class="input-group-text" for="bottomline">Bottomline</span></div>
					<input type="number" min="10" max="120" class="form-control" id="bottomline" placeholder="Bottomline in Percentage(%)" name="bottomline"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

				</div>
				
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4">
					<div class="input-group"> 
						
						<div id="special_pay_off_charges_group" class="input-group repeatable removeable">
							<div class="input-group-prepend">
								<span class="input-group-text" for="special_pay_off_charges" class="card-title user-select-none" >Special Pay Off Charges</span>
							</div>
							<input type="text" class="form-control" id="special_pay_off_title" placeholder="Special Pay Off Title" name="special_pay_off_title"></input>
							<div class="input-group-append">
								<span class="input-group-text"> : </span>
							</div>
							<input type="number" min="10" max="120" class="form-control" id="special_pay_off_charges" placeholder="per Consigment in Rupee(Rs)" name="special_pay_off_charges"></input>
							<div class="input-group-append">
								<span class="input-group-text btn repeat-target" repeatable-target="special_pay_off_charges_group" ><i class="fa fa-plus "></i></span>
								<span class="input-group-text btn remove-target" remove-target="special_pay_off_charges_group" ><i class="fa fa-close "></i></span>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

							</div>
						</div>
						
					</div>
				</div>
				
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div class="input-group-prepend"><span class="input-group-text" for="weight_charges">Weight Charges</span></div>
						<input type="number" min="10" max="120" class="form-control" id="weight_charges" placeholder="Weight Charges per KG in Rupee(Rs)" name="weight_charges"></input>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

					</div>
				
				</div>
				
				<div class="form-group col-md-4">
				
					<div class="input-group"> 
						<div id="delivery_group" class="input-group repeatable removeable">
							<div class="input-group-append">
								<span class="input-group-text" for="delivery_charges" class="card-title user-select-none" >Delivery Charges</span>
							</div>
							<select class="form-control" id="delivery_location" placeholder="Location" name="location"></select>
							<div class="input-group-append">
								<span class="input-group-text"> : </span>
							</div>
							<input type="number" min="10" max="120" class="form-control" id="delivery_charges" placeholder="per Consigment in Rupee(Rs)" name="delivery_charges"></input>
							<div class="input-group-prepend">
								<span class="input-group-text btn repeat-target" repeatable-target="delivery_group" ><i class="fa fa-plus "></i></span>
								<span class="input-group-text btn remove-target" remove-target="delivery_group" ><i class="fa fa-close "></i></span>
								<div class="input-group-append"><span class="input-group-text btn on-page-view"><i class="fa fa-pencil"></i></span></div>
								<div class="input-group-append"><span class="input-group-text btn on-page-edit"><i class="fa fa-floppy-o"></i></span></div>

							</div>
						</div>
					</div>
				
				</div>
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
<script src="<?php echo base_url();?>assets/js/module_franchises/fbv2.js"></script>

