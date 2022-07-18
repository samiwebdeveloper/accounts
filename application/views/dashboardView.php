<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.display').DataTable().destroy();
		$.ajax({
			type: "GET",
			url: "home/load_data",

			beforeSend: function() {
				$('tbody').html("<tr><td colspan='14'><img src='<?php echo base_url(); ?>assets/ajax-loader.gif'  width='130px'></td></tr>");
			},
			success: function(data) {

				$('tbody').html("");
				var js_obj = $.parseJSON(data)
				var cns = js_obj.cns;
				var chkd_cns = js_obj.chkd_cns;
				var data_arr = [];
				var data_arr_cns = [];
				for (var count = 0; count < cns.length; count++) {
					var sub_array = {
						'sr': (count + 1),
						'order_count': cns[count].order_count,
						'order_date': cns[count].order_date,
						'order_pay_mode': cns[count].order_pay_mode,
						'origin_city_name': cns[count].origin_city_name,
					};
					data_arr.push(sub_array);

				}

				for (var count = 0; count < chkd_cns.length; count++) {
					var sub_array_2 = {
						'sr': (count + 1),
						'order_count': chkd_cns[count].order_count,
						'order_date': chkd_cns[count].order_date,
						'order_pay_mode': chkd_cns[count].order_pay_mode,
						'origin_city_name': chkd_cns[count].origin_city_name,
					};
					data_arr_cns.push(sub_array_2);

				}
				var table = $('.display').DataTable({
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					dom: 'Blfrtip',
					buttons: [
						'colvis',
						{
							extend: 'excelHtml5',
							text: "<i class='fs-14 pg-form'></i> Excel",
							titleAttr: 'Excel',
							sheetName: 'Summary',
							exportOptions: {
								columns: ':visible'
							},

						},
						{
							extend: 'copyHtml5',
							footer: 'true',
							text: "<i class='fs-14 pg-note'></i> Copy",
							titleAttr: 'Copy',
							exportOptions: {
								columns: ':visible'
							},
						},
						{
							extend: 'print',
							text: "<i class='fs-14 pg-ui'></i> Print",
							titleAttr: 'Print',
							footer: 'true',
							title: 'Summary',
							exportOptions: {
								columns: ':visible'
							},

						},
					],
					data: data_arr,
					order: [],
					columns: [{
							data: "sr"
						},
						{
							data: "order_count"
						},
						{
							data: "order_date"
						},
						{
							data: "order_pay_mode"
						},
						{
							data: "origin_city_name"
						},
					]
				});
				var table = $('.display_2').DataTable({
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					dom: 'Blfrtip',
					buttons: [
						'colvis',
						{
							extend: 'excelHtml5',
							text: "<i class='fs-14 pg-form'></i> Excel",
							titleAttr: 'Excel',
							sheetName: 'Summary',
							exportOptions: {
								columns: ':visible'
							},

						},
						{
							extend: 'copyHtml5',
							footer: 'true',
							text: "<i class='fs-14 pg-note'></i> Copy",
							titleAttr: 'Copy',
							exportOptions: {
								columns: ':visible'
							},
						},
						{
							extend: 'print',
							text: "<i class='fs-14 pg-ui'></i> Print",
							titleAttr: 'Print',
							footer: 'true',
							title: 'Summary',
							exportOptions: {
								columns: ':visible'
							},

						},
					],
					data: data_arr_cns,
					order: [],
					columns: [{
							data: "sr"
						},
						{
							data: "order_count"
						},
						{
							data: "order_date"
						},
						{
							data: "order_pay_mode"
						},
						{
							data: "origin_city_name"
						},
					]
				});
			}
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
					<marquee class="font-montserrat fs-13 all-caps p-t-3">This Will Show TM Cargo & Logistics News Update. http://www.tmcargo.net</marquee>
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
								<a href="<?php echo base_url(); ?>Booking/Booking/select"><span class="small hint-text text-white">Click here select CNs for Correction</span></a>
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
							<div class="card-title">Corrected CNs</div>
							<!-- <div class="card-title"><h4>Corrected CNs</h4></div> -->
						</div>
						<div class="card-body">
							<div class='table-responsive'>
								<table width="100%" style="border-top:1px solid gray ;" class="table display nowrap compact table-bordered" id='chk_cns'>
									<thead>
										<tr>
											<th>No #</th>
											<th>Orders Count</th>
											<th>Booking Date</th>
											<th>Pay Mode</th>
											<th>Origin</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">

						</div>
					</div>
					<div class="card">
						<div class="card-header separator">
							<div class="card-title">CNs to Correct</div>
						</div>
						<div class="card-body">
							<div class='table-responsive'>
								<table width="100%" style="border-top:1px solid gray ;" class="table display_2 nowrap compact table-bordered" id='cns'>

									<thead>
										<tr>
											<th>No #</th>
											<th>Orders Count</th>
											<th>Booking Date</th>
											<th>Pay Mode</th>
											<th>Origin</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
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

		</script>

		<?php
		$this->load->view('inc/footer');
		?>