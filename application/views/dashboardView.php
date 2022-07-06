<?php
	error_reporting(0);
	$this->load->view('inc/header');
?>
<script type="text/javascript">
	$(document).ready(function(){ 
		var table =$('#cns').DataTable( {
			lengthMenu: [[ 25, 50, -1], [ 25, 50, "All"]],
			//order: [[ 10 "desc" ]],
			fixedHeader: true,
			searching: true,			
			paging:   true,
			ordering: true,
			bInfo: true,
			dom: 'Blfrtip',
			buttons: [
			'colvis', 
			
			{
				extend: 'excelHtml5',
				text:"<i class='fs-14 pg-form'></i> Excel",
				titleAttr: 'Excel',
				sheetName:'To Be corrected CN Summary',
				className: 'btn-info',
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
				title:"Pendings",
				message:"TM Cargo <br> System Developer TM IT <br>  Pending Report<br>"
			}
			]       
		});
		
		var tbl =$('#chk_cns').DataTable( {
			lengthMenu: [[ 25, 50, -1], [ 25, 50, "All"]],
			//order: [[ 10 "desc" ]],
			fixedHeader: true,
			searching: true,			
			paging:   true,
			ordering: true,
			bInfo: true,
			dom: 'Blfrtip',
			buttons: [
			'colvis', 
			
			{
				extend: 'excelHtml5',
				text:"<i class='fs-14 pg-form'></i> Excel",
				titleAttr: 'Excel',
				sheetName:'Corrected CN Summary',
				className: 'btn-info',
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
				title:"Pendings",
				message:"TM Cargo <br> System Developer TM IT <br>  Pending Report<br>"
			}
			]       
		});
		
	});
</script> 
<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
	<!-- START PAGE CONTENT -->
	<div class="content">
		<!-- START JUMBOTRON -->
		<div class="jumbotron" data-pages="parallax">
			<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-color: #575757 !important; color:white">
				<div class="inner">
					<marquee  class="font-montserrat fs-13 all-caps p-t-3">This Will Show TM Cargo & Logistics News Update. http://www.tmcargo.net</marquee>
				</div>
			</div>
		</div>
		<!-- END JUMBOTRON -->
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-md-3 m-b-10">
					<div class="widget-9 card no-border bg-primary no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #6d5eac)">
						<div class="full-height d-flex flex-column">
							<div class="card-header ">
								<div class="card-title text-white">
									<span class="font-montserrat fs-11 all-caps">CN <i class="fa fa-chevron-right"></i>
									</span>
								</div>
								<div class="card-controls">
									<ul>
										<li><a href="#" class="card-refresh text-black" data-toggle="refresh"><i class="card-icon card-icon-refresh"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="p-l-20">
								<h3 class="no-margin p-b-5 text-white">Correction</h3>
								<a href="#" class="btn-circle-arrow text-white"><i class="pg-arrow_right"></i>
								</a>
								<a href="<?php echo base_url();?>Booking/Booking/select"><span class="small hint-text text-white">Click here select CNs for Correction</span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 m-b-10">
					<div class="widget-9 card no-border bg-info no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #949AEF)">
						<div class="full-height d-flex flex-column">
							<div class="card-header ">
								<div class="card-title text-white">
									<span class="font-montserrat fs-11 all-caps">Manage Your Mail <i class="fa fa-chevron-right"></i>
									</span>
								</div>
								<div class="card-controls">
									<ul>
										<li><a href="#" class="card-refresh text-black" data-toggle="refresh"><i class="card-icon card-icon-refresh"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="p-l-20">
								<h3 class="no-margin p-b-5 text-white">Inbox</h3>
								<a href="#" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i>
								</a>
								<a href="https://tmcargo.net:2096/" target="_blank"><span class="small hint-text text-white">Click here for more detail</span></a>
							</div>
						</div>
					</div>					
					
				</div>				
			</div>
			
			<div class="row">
				<div class="col-md-12 m-b-10"> 
					<div class="card">							
						<div class="card-header separator">
							<div class="card-title"><h4>Corrected CNs</h4></div>
						</div>
						<div class="card-body">
							<?php $cns; if(!empty($chkd_cns)){ ?>									
								<div class='table-responsive'>										
									<table class="table table-bordered" id='chk_cns'>
										<thead>
											<tr>
												<th>No #</th>
												<th>Booking Date</th>
												<th>Origin</th>
												<th>Pay Mode</th>
												<th>Orders Count</th>
											</tr>  
										</thead>
										<tbody>
											<?php if(!empty($chkd_cns)){
												$i=0;  
												foreach($chkd_cns as $rows){
													$i=$i+1; 
													echo("<tr class=".$rows['manual_cn'].">");
													echo("<td>".$i."</td>");
													echo("<td>".$rows['order_date']."</td>");
													echo("<td>".$rows['origin_city_name']."</td>");
													echo("<td>".$rows['order_pay_mode']."</td>");
													echo("<td>".$rows['order_count']."</td>");													
													echo("</tr>"); 
												}}?>
												
										</tbody>  
									</table>         									
								</div>
								
							<?php } ?>
						</div>
						<div class="card-footer">
							
						</div>
					</div>
					<div class="card">												
						<div class="card-header separator">
							<div class="card-title"><h4>CNs to Correct</h4></div>
						</div>
						<div class="card-body">
							<?php $cns; if(!empty($cns)){ ?>									
								<div class='table-responsive'>										
									<table class="table table-bordered" id='cns'>
										<thead>
											<tr>
												<th>No #</th>
												<th>Booking Date</th>
												<th>Origin</th>
												<th>Pay Mode</th>
												<th>Orders Count</th>
											</tr>  
										</thead>
										<tbody>
											<?php if(!empty($cns)){
												$i=0;  
												foreach($cns as $rows){
													$i=$i+1; 
													echo("<tr class=".$rows['manual_cn'].">");
													echo("<td>".$i."</td>");
													echo("<td>".$rows['order_date']."</td>");
													echo("<td>".$rows['origin_city_name']."</td>");
													echo("<td>".$rows['order_pay_mode']."</td>");
													echo("<td>".$rows['order_count']."</td>");													
													echo("</tr>"); 
												}}?>
												
										</tbody>  
									</table>         									
								</div>								
							<?php } ?>
						</div>
						<div class="card-footer">
							
						</div>
					</div>					
				</div>
				<!-- END PLACE PAGE CONTENT HERE -->
			</div>
			<!-- END CONTAINER FLUID -->
		</div>
		<!-- END PAGE CONTENT -->
		<script type="text/javascript">		
			$(".cn-edit").click(function(){						
				var cn = $(this).attr("value");
				var mydata={cn_edit: cn};			
				$.ajax({
					url: "<?php echo base_url(); ?>Booking/Booking/set_cn_to_edit",
					type: "POST",
					data: mydata,        
					success: function(data) {				
						if (data == 1) {
							window.open('<?php echo base_url(); ?>Booking/Booking/edit_booking_view');
							} else {
							$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-dangerous'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Manual CN "+ val +" <strong>can't</strong> be open for correction now.</div></div>");    
						}
					},
					error: function(data) {					
						alert("Error: "+data);					
					},
				});
			});	
			
			$(".cn-okay").click(function(){
				var val = $(this).attr("value");
				$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait Manual CN <strong>"+ val +"</strong> is getting processed.</div></div>");
				var mydata={order_id: val};			
				$.ajax({
					url: "<?php echo base_url(); ?>Booking/Booking/mark_cn_corrected",
					type: "POST",
					data: mydata,        
					success: function(data) {				
						if (data == 1) {
							$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Manual CN "+ val +" has been marked as <strong>corrected</strong>.</div></div>");    
							$("."+val).prop("hidden",true);
							} else {
							$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-dangerous'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Manual CN "+ val +" <strong>can't</strong> be marked as corrected now.</div></div>");    
						}
					},
					error: function(data) {					
						alert("Error: "+data);					
					},
				});
			});	
		</script>
		
		<?php
			$this->load->view('inc/footer');
		?>      																																	