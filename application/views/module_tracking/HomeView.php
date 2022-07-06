<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Track Shipment</title>
		<!-- Bootstrap core CSS -->
        <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap1.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			function chkanimal(cid){   	
				if(event.keyCode==13 || event.keyCode==11){
					if(cid!=""){
						$("#data-load").html("<img src='<?php echo base_url(); ?>Assets/cowcard.gif");
						$.ajax({
							url: "<?php echo base_url(); ?>Tracking/Search/"+cid,
							type: "POST",       
							success: function(data) {
								$("#data-load").html(data);
								$("#animal_id").focus();
								$("#animal_id").select();
							}
						});
					}	
				}
			}
			function resizeIframe(obj) {
			obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px'; }
		</script>
		
	</head>
	<body>		
		<div class="container p-3">
			<div class="row">				
				<div class="col">
					<?php
						if($Shipment_id!=0){
							$Shipment_id = $Shipment_id;
						?>
						<script>
							$.ajax({
								url: "<?php echo base_url(); ?>Tracking/Search/"+<?php echo $Shipment_id; ?>,
								type: "POST",       
								success: function(data) {
									$("#data-load").html(data);
									$("#animal_id").val(<?php echo $Shipment_id; ?>);
									$("#animal_id").focus();
									$("#animal_id").select();
								}
							});
						</script>
						
					<input style="background-color:#fff;border:1px solid #009a66" type="number" name="animalid"  id="animal_id" class="form-control" placeholder="Enter CN And Press Tab" onkeyup="return chkanimal(this.value);" ></center>
					<?php }else{ ?>
					<input style="background-color:#fff;border:1px solid #009a66"  onkeyup="return chkanimal(this.value);"  placeholder="Track your shipment" type="number" name="animalid"  id="animal_id" class="form-control">
				<?php } ?>						
				
				<div id="data-load"></div>
			</div>					
		</div>
	</div>
	
	<script> 
		$( document ).ready(function() {
			$( "#animal_id" ).focus();
		});
	</script>
	
	<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
	
	
	
	<!-- END VENDOR JS -->
	<!-- BEGIN CORE TEMPLATE JS -->
	
	<!-- END CORE TEMPLATE JS -->
	
</body>
</html>					