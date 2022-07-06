<?php error_reporting(0);$this->load->view('inc/header');
?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/query-builder/css/query-builder.default.css" id="qb-theme"/>


<script>

<?php 
	  $i=0;
	  if(!empty($invoice_rule_details)){
	      foreach($invoice_rule_details as $rows){
	          
	          $customer_id = $rows->customer_id;
	          $invoice_rule_id= $rows->invoice_rule_id;
	          $version_no= $rows->version_no;
	          $invoice_rule_name= $rows->invoice_rule_name;
	          $invoice_rule_json= $rows->invoice_rule_json;
	          $invoice_rule_sql= $rows->invoice_rule_sql;
	          $modified_by= $rows->modified_by;
	            
	          $i=$i+1;
	      }
	 }
?>
//debugger;
var customer_name = "<?php echo (empty($customer_name)) ? ("") : ($customer_name)?>";
var	customer_id = <?php echo (empty($customer_id)) ? ('""') : ($customer_id)?>;
var	invoice_rule_id= <?php echo (empty($invoice_rule_id)) ? ('""') : ($invoice_rule_id)?>;
var	version_no= <?php echo (empty($version_no)) ? (0) : ($version_no)?>;
var invoice_rule_name= "<?php echo (empty($invoice_rule_name)) ? ("") : ($invoice_rule_name)?>";
var invoice_rule_json= <?php echo (empty($invoice_rule_json)) ? ('""') : ($invoice_rule_json)?>;
var invoice_rule_sql= <?php echo (empty($invoice_rule_sql)) ? ('""') : ($invoice_rule_sql)?>;
var modified_by= <?php echo (empty($modified_by)) ? ('""') : ($modified_by)?>;
        
        	

 
$( document ).ready(function() {
    //debugger;
	//console.log( "ready!" );
	//setRuleJSON(defaultRule, !isRuleEditable);
		//$("#rule_form").validate();
	//alert(customer_name);
	//debugger;
	if(invoice_rule_id == -1)
	{
		$( "#lbl-customer_name" ).text(customer_name);
		$( "#invoice_rule_name" ).removeAttr('readonly');
        $( "#customer_id").val(customer_id);
		$( "#invoice_rule_id").val(invoice_rule_id);
		$( "#version_no").val(version_no);
		$( "#btn-back" ).addClass( "hide" );
		$( "#btn-edit" ).addClass( "hide" );
        $( "#btn-save" ).removeClass( "hide" );
        $( "#btn-cancel" ).removeClass( "hide" );
		loadedRule = defaultInvoiceRule;
	}
	else
	{
		$( "#lbl-customer_name" ).text(customer_name);
		$( "#invoice_rule_name").val(invoice_rule_name);
		$( "#customer_id").val(customer_id);
		$( "#invoice_rule_id").val(invoice_rule_id);
		$( "#version_no").val(version_no);
		loadedRule = invoice_rule_json;
		  ruleRowCounter=0;
		$( "#query-builder").queryBuilder('setRules', invoice_rule_json);
	}//JSON.parse(nresult)
	

	
	//test();
});	  
</script>

<div class="page-content-wrapper">
	<div class="content">
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
		<div class="container-fluid container-fixed-lg">
			<div class="row">
				<div class="card">
					<div style="text-align: center;"><h5><span id="lbl-customer_name"></span></h5></div>
					<div class="card-header">
					<button id="btn-back" class="btn btn-success" >back</button>
					<button id="btn-edit" class="btn btn-danger ">edit</button>
					<button id="btn-cancel" class="btn btn-warning hide ">cancel</button>
					<button id="btn-save" class="btn btn-success hide">save</button>
				<!--</div>
				<div class="row">-->
					<form id="rule_form" action="<?php echo base_url();?>InvoiceRules/save_customer_invoice_rule_details" method="post">
						<div class="form-group">
							<label for="invoice_rule_name" > Rule Name : </label>
							<input type="text" id="invoice_rule_name" name="invoice_rule_name" maxlength="100" placeholder="Enter Rule Name" class="form-control" required readonly />
							<span id="invoice_rule_name_error" class="error hide">Please enter valid Customer Invoice Rule Name</span>
						</div>
						<input type="hidden" id="customer_id" name="customer_id"/>
						<input type="hidden" id="invoice_rule_id" name="invoice_rule_id"/>
						<input type="hidden" id="version_no" name="version_no"/>
						<input type="hidden" id="invoice_rule_json" name="invoice_rule_json"/>
						<input type="hidden" id="invoice_rule_sql" name="invoice_rule_sql"/>
						<input type="hidden" id="is_cancel" name="is_cancel"/>
						<!--<input type="submit" name="submit" name="submit"/>-->
					</form>
					<div/>
				<!--</div>
				<div class="row">-->
				<div class="card-body">
					<div id="query-builder" style="width:100%;display:block;" ></div>
				<div class="card-body"/>
				<div class="card">
			</div>
		</div>
	</div>
</div>





<?php $this->load->view('inc/footer');
?>

<script src="<?php echo base_url();?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/query-builder/js/query-builder.standalone.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/query-builder/js/query-builder.standalone.min.js"></script>
<script src="<?php echo base_url();?>assets/js/query-builder/query-builder-extension.js"></script>
<script src="<?php echo base_url();?>assets/js/query-builder/query-builder-invoice-rule-defaults.js"></script>