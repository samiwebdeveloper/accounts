<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#myTable').DataTable({
			"lengthMenu": [
				[-1, 10, 25, 50],
				["All", 10, 25, 50]
			],
			fixedHeader: true,
			"searching": true,
			"paging": true,
			"ordering": true,
			"bInfo": true,
			dom: 'Blfrtip',
			buttons: [{
					extend: 'pdfHtml5',
					orientation: 'Portrait',
					pageSize: 'A4',
					footer: 'true',
					title: "Customer List",
					text: "<i class='fs-14 pg-download'></i> PDF",
					titleAttr: 'PDF',
					message: "Delivery Express\n  Powered By SaimTech \n Date:<?php echo '' . date('Y-m-d'); ?> \n Customer Lists \n "
				},
				{
					extend: 'excelHtml5',
					text: "<i class='fs-14 pg-form'></i> Excel",
					titleAttr: 'Excel',
					sheetName: 'Customer List',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'copyHtml5',
					footer: 'true',
					text: "<i class='fs-14 pg-note'></i> Copy",
					titleAttr: 'Copy'
				},
				{
					extend: 'print',
					text: "<i class='fs-14 pg-ui'></i> Print",
					titleAttr: 'Print',
					footer: 'true',
					title: "Customer List",
					message: "Delivery Express <br> System Developer M.Saim <br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>Customer List<br>"
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
			<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
				<div class="inner">
					<!-- START BREADCRUMB -->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Manage</li>
						<li class="breadcrumb-item">Franchisee</li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
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
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid container-fixed-lg bg-gray">
						<div class="row">
							<div class="col-md-12">
								<div class="card m-t-10">
									<div class="card-header separator">
										<div class="card-title">
											<h2>All Franchises</h2>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12 m-t-10 text-right">
												<a href="<?php echo base_url(); ?>Franchisee/add_franchisee_view/" class="btn btn-primary text-right">Add New Franchisee</a>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive m-t-10">
													<table class="table table-bordered" id="myTable">
														<thead>
															<th>Sr</th>
															<th>Code</th>
															<th>Name</th>
															<th>Location</th>
															<th>Contact</th>
															<th>Status</th>
															<th>Action</th>
														</thead>
														<tbody>
															<?php
															$i = 0;
															if (!empty($franchises_data)) {
																foreach ($franchises_data as $rows) {
																	$i = $i + 1;
																	echo ("<tr>");
																	echo ("<td>" . $i . "</td>");
																	echo ("<td>" . $rows->fran_code . "</td>");
																	echo ("<td>" . $rows->fran_name . "</td>");
																	echo ("<td>" . $rows->city_full_name . "</td>");
																	echo ("<td>" . $rows->reference_name . "</td>");
																	if ($rows->is_enable == 1) {
																		echo ("<td class='bg-success text-white'>Active</td>");
																	} else {
																		echo ("<td class='bg-danger text-white'>Suspended</td>");
																	}
																	echo ("<td>");
																	echo ("<center>");
																	if ($_SESSION['user_power'] == 'SE' || $_SESSION['user_power'] == 'Admin') {
																		// echo ("<a href='" . base_url() . "customer/edit_customer_view/" . $rows->fr_id . "' class='btn btn-primary btn-xs' style=' margin-right:3px;'>Edit</a>");
																		// echo ("<a href='" . base_url() . "customer/zone_wise_rate_view/" . $rows->fr_id . "' class='btn btn-primary btn-xs' style=' margin-right:3px;'>Rate</a>");
																		if ($rows->is_enable == 1) {
																			echo ("<a href='" . base_url() . "Franchisee/update_status/" . $rows->fr_id . "/0'   class='btn btn-danger btn-xs'  style=' margin-right:3px;'>Suspend</a>");
																		} else {
																			echo ("<a href='" . base_url() . "Franchisee/update_status/" . $rows->fr_id . "/1'   class='btn btn-success btn-xs'  style=' margin-right:3px;'>Re Active</a>");
																		}
																	}
																	echo ("<a href='" . base_url() . "Franchisee/view_franchisee/" . $rows->fr_id . "' class='btn btn-info btn-xs'>View</a>");
																	echo ("</center>");
																	echo ("</td>");
																	echo ("</tr>");
																}
															} ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END Card -->
				</div>
				<!-- END CONTAINER FLUID -->
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<?php
	$this->load->view('inc/footer');
	?>