<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
	.table thead tr th {
		text-transform: capitalize;
		font-weight: 600;
		font-family: apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
		font-size: 10.5px;
		letter-spacing: 0.05em;
		padding-top: 3px;
		padding-bottom: 3px;
		vertical-align: middle;
		border-bottom: 1px solid rgb(57, 44, 40);
		color: #6d5eac;
		border-top: none;
		border-top: 1px solid gray !important;
	}

	.summary tbody tr td {
		font-size: 13px;
		font-weight: 500;
	}

	.dataTables_wrapper {
		padding: 3px 24px;
	}

	.card-title {
		margin: 10px 0px;
		font-weight: 600;
		margin-left: 29px;
	}

	.card {
		margin-bottom: 13px;
	}
</style>
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
						<li class="breadcrumb-item">CN Book</li>
						<li class="breadcrumb-item">CN Book (<?php echo $this->uri->segment(3) ?>) Usage </li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>
		<?php
     	$total=explode('-',$this->uri->segment(3));
		$total_cn=$total[1]-$total[0]+1;
		$is_issue = 0;
		foreach ($detail as $key => $rows) {
			if ($rows->book_status == "Is Issued") {
				$is_issue = $is_issue + 1;
			}
		}
		$total_avialable_cn=count($detail);
		$missing_cn=$total_cn-$total_avialable_cn;
		?>
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<div class="pgn-wrapper" data-position="top" style="top: 10px;"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="card ">
							<div class="card-title">CN Book Usage Summary</div>
							<table class=" text-center table  summary table-bordered compact wrap dataTable no-footer" id="emp_table" width="99%">
								<thead>
									<tr>
										<th> CN Range</th>
										<th> Total CN </th>
										<th> Booked CN </th>
										<th> Available CN </th>
									</tr>
								</thead>
								<tbody>
									<tr>
									    <td><?php echo $this->uri->segment(3) ?></td>
										<td><?php echo $total_cn;  ?></td>
										<td><?php echo $is_issue  ?></td>
										<td><?php echo ($total_cn - $is_issue) ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row mb-1 mt-10">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-title">CN Book Usage Detail</div>
									<div class="table-responsive ">
										<table class="table display  table-bordered compact nowrap dataTable no-footer" id="emp_table" width="99%">
											<thead>
												<tr>
													<th>Sr#</th>
													<th>Book Code</th>
													<th>manual cn</th>
													<th>order date</th>
													<th>arrival date</th>
													<th>origin</th>
													<th>Destination</th>
													<th>shipper </th>
													<th>Consignee </th>
													<th>service </th>
													<th>pay mode </th>
													<th>Weight</th>
													<th>Pieces</th>
													<th>book status</th>
													<th>Order status</th>
													<th>issue date</th>
													<th>rider name</th>
													<th>created By</th>
												</tr>
											</thead>
											<tbody id="pendingtable">
												<?php
												foreach ($detail as $key => $rows) {
													if ($rows->book_status == "Is issued") {
														$not_issue = $not_issue + 1;
													}
													echo "<tr>";
													echo "<td>" . ($key + 1) . "</td>";
													echo "<td>" . $rows->book_code . "</td>";
													echo "<td>" . $rows->manual_cn . "</td>";
													echo "<td>" . $rows->order_date . "</td>";
													echo "<td>" . $rows->order_arrival_date . "</td>";
													echo "<td>" . $rows->origin_city_name . "</td>";
													echo "<td>" . $rows->destination_city_name . "</td>";
													echo "<td>" . $rows->shipper_name . "</td>";
													echo "<td>" . $rows->consignee_name . "</td>";
													echo "<td>" . $rows->service_name . "</td>";
													echo "<td>" . $rows->order_pay_mode . "</td>";
													echo "<td>" . $rows->weight . "</td>";
													echo "<td>" . $rows->pieces . "</td>";
													echo "<td>" . $rows->book_status . "</td>";
													echo "<td>" . $rows->order_status . "</td>";
													echo "<td>" . $rows->issue_date . "</td>";
													echo "<td>" . $rows->rider_name . "</td>";
													echo "<td>" . $rows->oper_user_name . "</td>";
													echo "</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- END card -->
						</div>
					</div>
					<!-- END PLACE PAGE CONTENT HERE -->
				</div>
				<!-- END CONTAINER FLUID -->
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<?php
	$this->load->view('inc/footer');
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.summary').DataTable({
				"fixedHeader": false,
				"proccessing": false,
				"searching": false,
				"paging": false,
				"ordering": false,
				"bInfo": false,
				dom: 'Blfrtip',
				buttons: [
					'colvis',
					{
						extend: 'excelHtml5',
						text: "<i class='fs-14 pg-form'></i> Excel",
						titleAttr: 'Excel',
						sheetName: 'CN Book Summary',
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
						title: 'CN Book Summary',
						exportOptions: {
							columns: ':visible'
						},
					},
				],
				"fixedHeader": false,
				"searching": false,
				"paging": false,
				"ordering": false,
				"bInfo": false,
			});
			var table = $('.display').DataTable({
				"fixedHeader": true,
				"proccessing": true,
				"searching": true,
				"paging": true,
				"ordering": true,
				"bInfo": true,
				"lengthMenu": [
					[50],
					[50]
				],
				"fixedHeader": true,
				"searching": true,
				"paging": true,
				"ordering": true,
				"bInfo": true,
				dom: 'Blfrtip',
				buttons: [
					'colvis',
					{
						extend: 'excelHtml5',
						messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.',
						text: "<i class='fs-14 pg-form'></i> Excel",
						titleAttr: 'Excel',
						sheetName: 'CN Book Detail',
						exportOptions: {
							columns: ':visible'
						},
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
						title: 'CN Book Detail',
						exportOptions: {
							columns: ':visible'
						},
					},
				]
			});
		});
	</script>