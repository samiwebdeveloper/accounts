<?php error_reporting(0);$this->load->view('inc/header');
?>
<script type="text/javascript">
var customer_name = "<?php echo (empty($customer_name)) ? ("") : ($customer_name)?>";
$(document).ready(function(){ 
	
	$( "#lbl-customer_name" ).text(customer_name);
	var customer_id = $("#customer").val();
	if(customer_id != ""){
		//debugger;
		$("#btn-new").removeAttr('disabled');
		$("#btn-show").attr("disabled","disabled");
		
		
		$(this).closest('form')
           .trigger('submit')
		//$('#customer_form').submit();
	}

	$("#customer").change(function() {
		$("#btn-new").removeAttr('disabled');
		$("#btn-show").removeAttr('disabled');

	});
   $('#invoice_rule_list_table thead span').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'"  />' );
    } );    
	var table =$('#invoice_rule_list_table').DataTable( {
		"lengthMenu": [[ -1, 10, 25, 50], [ "All", 10, 25, 50]],     
		"fixedHeader": true,
		"searching": false,
		"paging":   false,
		"ordering": false,
		"bInfo": true,
		dom: 'Blfrtip',
		buttons: []
        /*
		buttons: [
			 'colvis',  
		{
		extend: 'pdfHtml5',
		orientation: 'landscape',
		pageSize: 'A3',
		footer: 'true',
		title:"Invoices List",
		text:"<i class='fs-14 pg-download'></i> PDF",
		titleAttr: 'PDF',
		message:"T.M. Cargo\n  Date:<?php echo ''.date('Y-m-d'); ?> \n Invoices List \n "
		},
		{
		extend: 'excelHtml5',
		text:"<i class='fs-14 pg-form'></i> Excel",
		titleAttr: 'Excel',
		sheetName:'Invoices List',
		exportOptions: {
		modifier: { page: 'current'}
		}
		},
		{
		extend: 'copyHtml5',
		footer: 'true',
		text:"<i class='fs-14 pg-note'></i> Copy",
		titleAttr: 'Copy'
		},
		{
		extend: 'print',
		text:"<i class='fs-14 pg-ui'></i> Print",
		titleAttr: 'Print',
		footer: 'true',
		title:"Invoices List",
		message:"T.M. Cargo <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Invoices List<br>"
		}
		] */
	});

	table.columns().every( function () {
			var that = this;
	 
			$( 'input', this.header() ).on( 'keyup change clear', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			} );
		} );
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
						<li class="breadcrumb-item">Accounts</li>
						<li class="breadcrumb-item">Invoices Rules</li>
						<li class="breadcrumb-item">
							<mark>
								<?php echo date('Y-m-d H:i:s' ); ?></mark>
						</li>
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
				<!-- START card -->
				<!--<div class="col-xl-12 col-lg-12">-->
					<!-- START card -->
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="row">
							<div class="card">
								<div class="card-header">
									<form id="customer_form" name="customer_form" action="<?php echo base_url(); ?>InvoiceRules/get_customer_invoice_rules" method="post">
										<div class="row">
											<h5>Customers List</h5>
											<select  id="customer" class="form-control" name="customer" tabindex="3">
												<option value=""> Select Customer</option>
													<?php 
														if(!empty($customer_list)){
				    										foreach($customer_list as $rows){
	           												    echo("<option value='" .$rows->id."' ".(($rows->id == $customer_id) ? 'selected' : '').">".$rows->name." (".$rows->city.")</option>");
    														}
    													}
													?>
											</select>
											<!--<input type="hidden" id="customer_id" name="customer_id"/>
											<input type="hidden" id="customer_name" name="customer_name"/>-->
											<button type="submit" id="btn-show"   class="btn btn-primary" style="height:100%" disabled>Show Rules</button>
											<button type="submit" id="btn-new" class="btn btn-secondary" style="height:100%" disabled formaction="<?php echo base_url(); ?>InvoiceRules/new_customer_invoice_rule_details">New Rule</button>
										</div>
									</form>	
								</div>
								<div class="card-body">
									<h5 id="lbl-customer_name" style="text-align: center;">Customer Loaded Rules</h5>
									<div class="table-responsive m-t-10">
										 <table class="table table-bordered" id="invoice_rule_list_table">
											<thead>
												<th>Action</th>  
												<th>Invoice Rule Name</th>  
												<th>Version no</th>
												<th>Modified by</th>
												<th>Modification Date</th>
											</thead>
											<tbody>
											  <?php 
											  $i=0;
											  if(!empty($invoice_rule_list)){
											  foreach($invoice_rule_list as $rows){ 
											  $i=$i+1;  
											  
    											  echo("<tr>");
    											  echo("<td><a href='".base_url()."InvoiceRules/get_customer_invoice_rule_details/".$rows->customer_id."/".$rows->invoice_rule_id."' class='btn btn-info btn-xs'>View</a></td>");
    											  echo("<td>".$rows->invoice_rule_name."</td>");
    											  echo("<td><center>".number_format($rows->version_no)."</center></td>");
    											  echo("<td>".$rows->modified_by."</td>");
    											  $date=date_create($rows->modified_date);
    											  echo("<td><center>".date_format($date,"M-d-Y")."</center></td>");
											  
											     echo("</tr>");  
											  }} ?>
											</tbody> 
										 </table> 
									</div>
								</div>
							</div>
						</div>
					</div>
			
			<!-- </div> -->
			
			
			</div>
			<!-- END card -->
		</div>
	</div>
	<!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTENT WRAPPER -->
<?php $this->load->view('inc/footer');
?>