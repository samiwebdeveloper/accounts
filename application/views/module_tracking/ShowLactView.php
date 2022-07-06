<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Tracking</title>
		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap1.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/search2.js" type="text/javascript"></script>
		
	</head>
	<script type="text/javascript">
		$(document).ready(function(){ 
			$("#myTable").saimtech();
		});
	</script>
	<body>
		<div class="table-responsive-md">
			<table class="table table-striped table-hover" id="myTable">		
				<?php if(!empty($tracking_data)){  				
					foreach($tracking_data as $rows){ ?>
					<tr>
						<th><?php echo $rows->order_event; ?></th>
						<td><?php echo $rows->order_message." ".$rows->order_reason; ?></td>
						<td><?php echo $rows->order_event_date; ?></td>
						<td><?php echo $rows->order_location_name; ?></td>						
						<?php 
							if($rows->order_event=="Order" ||  $rows->order_event=="Booking" ||  $rows->order_event=="Cancelled" || $rows->order_event=="Re-order" ){ ?>
							<td><a href='https://www.ip2location.com/<?php echo $rows->order_ip; ?>'><?php echo "Customer or ".$rows->oper_user_name; ?></a></td>
							<?php } else { ?>
							<td><a href='https://www.ip2location.com/<?php echo $rows->order_ip; ?>'><?php echo $rows->oper_user_name; ?></a></td>
						<?php } ?>
					</tr>					
				<?php }} ?>
			</table>
		</div>
	</body>
</html>	