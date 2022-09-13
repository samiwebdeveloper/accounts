<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
	.alert .close {
    top: 4.5px;
    left: 10px;
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
						<li class="breadcrumb-item">Administraion</li>
						<li class="breadcrumb-item">Add User</li>
						<li class="breadcrumb-item">User</li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:a'); ?></mark></li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="row ">
							<div class="col-md-8 offset-2">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">Add New User</div>
									</div>
									<div class="card-body">
									
									<?php echo $error;?>
										
										<form action="upload_single_image" id="myForm" role="form" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group form-group-default required">
														<label>Upload Image</label>
														<input type="file" class="form-control" name="upload_file_1" required="">
													</div>
												</div>

											</div>
											<button class="btn btn-primary" type="submit">Register</button>
										</form>
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- END PLACE PAGE CONTENT HERE -->
				</div>
				<!-- END CONTAINER FLUID -->
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<?php $this->load->view('inc/footer'); ?>

	<script>
		$(document).ready(function() {
			$('#myForm').validate();
		});
	</script>