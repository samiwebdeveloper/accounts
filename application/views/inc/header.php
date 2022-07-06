<!DOCTYPE html>
<?php date_default_timezone_set('Asia/Karachi'); ?>
<html>

<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<title>TM Cargo | Accounts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/favicon.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicon.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicon.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicon.png">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />

	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>

	<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo base_url(); ?>assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>

	<link href="<?php echo base_url(); ?>assets/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
	<link class="main-stylesheet" href="<?php echo base_url(); ?>assets/pages/css/themes/corporate.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datatables.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<style>
		.themebtn {

			background-image: linear-gradient(45deg, #6d5eac, #949AEF);
			color: white;
		}
	</style>
	<style>
		#more {
			display: none;
		}
	</style>
</head>
<?php if ($_SESSION['user_name'] == "" && $_SESSION['portal'] != "ops") {
	redirect('Login');
} ?>

<body class="fixed-header windows desktop pace-done">
	<!-- BEGIN SIDEBAR -->
	<!-- BEGIN SIDEBPANEL-->
	<nav class="page-sidebar" data-pages="sidebar">
		<!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
		<div class="sidebar-overlay-slide from-top" id="appMenu">

		</div>
		<!-- END SIDEBAR MENU TOP TRAY CONTENT-->
		<!-- BEGIN SIDEBAR MENU HEADER-->
		<div class="sidebar-header">
			TM Cargo & Logistics Accounts
			<div class="sidebar-header-controls">
				<button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
				</button>
				<button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
				</button>
			</div>
		</div>
		<!-- END SIDEBAR MENU HEADER-->
		<!-- START SIDEBAR MENU -->
		<div class="sidebar-menu">
			<!-- BEGIN SIDEBAR MENU ITEMS-->

			<!------------------------Accounts Power Start-------------------------->


			<ul class="menu-items">
				<li class="m-t-30">
					<a href="<?php echo base_url(); ?>home" class="detailed">
						<span class="title">Dashboard</span>
						<span class="details">Account Information</span>
					</a>
					<span class="icon-thumbnail themebtn"><i class="pg-thumbs"></i></span>
				</li>
				<li class="m-t-10">
					<a href="<?php echo base_url(); ?>Tracking" target='Blank' class="detailed">
						<span class="title">Track Order</span>
						<span class="details">Order Tracking</span>
					</a>
					<span class="icon-thumbnail themebtn"><i class="pg-search"></i></span>
				</li>

				<li class="m-t-10">
					<a href="javascript:;">
						<span class="title">Booking</span>
						<span class=" arrow "></span>
					</a>
					<span class="bg-success icon-thumbnail themebtn"><i class="pg-cupboard"></i></span>
					<ul class="sub-menu">
						<li class="">
							<a href="<?php echo base_url(); ?>Booking/Booking">Single Booking</a>
							<span class="icon-thumbnail">SBG</span>
						</li>
						<li class="">
							<a href="<?php echo base_url(); ?>Booking/Booking/select">Select Booking</a>
							<span class="icon-thumbnail">SLB</span>
						</li>
					</ul>
				</li>
				<?php if ($_SESSION['is_supervisor'] == 1) { ?>
					<li class="m-t-10">
						<a href="javascript:;">
							<span class="title">Collection</span>
							<span class=" arrow "></span>
						</a>
						<span class="bg-success icon-thumbnail themebtn"><i class="pg-cupboard"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="<?php echo base_url(); ?>Collection">FOD to Collect</a>
								<span class="icon-thumbnail">FDC</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Collection/collected">Submit Collection</a>
								<span class="icon-thumbnail">SCL</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Collection/submitted">Submitted Collection</a>
								<span class="icon-thumbnail">SCV</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Collection/discrepancy">Discrepancy Report</a>
								<span class="icon-thumbnail">DCR</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Collection/delivered">Delivered & Collected</a>
								<span class="icon-thumbnail">DNC</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Collection/undelivered">Undelivered or Not Collected</a>
								<span class="icon-thumbnail">UNC</span>
							</li>
						</ul>
					</li>

					<li class="m-t-10">
						<a href="javascript:;">
							<span class="title">Invoice</span>
							<span class=" arrow "></span>
						</a>
						<span class="bg-success icon-thumbnail themebtn"><i class="pg-signals"></i></span>
						<ul class="sub-menu">

							<li class="">
								<a href="<?php echo base_url(); ?>Invoice">Manage Invoice</a>
								<span class="icon-thumbnail">INV</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Invoice/zero_cn">Zero Rated CN</a>
								<span class="icon-thumbnail">ZRC</span>
							</li>
							<!--<li class="">
									<a href="<?php echo base_url(); ?>invoice/unpaid_cn_all">UnInvoiced</a>
									<span class="icon-thumbnail">UIN</span>
									</li>
									<li class="">
									<a href="<?php echo base_url(); ?>invoice/uninvoiced_cn_all">UnInvoiced cn</a>
									<span class="icon-thumbnail">UNC</span>
									</li>
									<li class="">
									<a href="<?php echo base_url(); ?>invoiceRules">(BETA)Invoice Rules</a>
									<span class="icon-thumbnail">INR</span>
								</li>-->
						</ul>
					</li>
					<!--<li class="m-t-10">
							<a href="javascript:;">
							<span class="title">(BETA)Invoices</span>
							<span class=" arrow "></span>
							</a>
							<span class="bg-success icon-thumbnail themebtn"><i class="pg-calender"></i></span>
							<ul class="sub-menu">
							
							<li class="">
							<a href="<?php echo base_url(); ?>invoices/create_invoice">(BETA)Create Invoices</a>
							<span class="icon-thumbnail">CIN</span>
							</li>
						</ul>
						</li>-->

					<li class="m-t-10">
						<a href="javascript:;">
							<span class="title">Customer Account</span>
							<span class=" arrow "></span>
						</a>
						<span class="bg-success icon-thumbnail themebtn"><i class="pg-bag"></i></span>
						<ul class="sub-menu">

							<li class="">
								<a href="<?php echo base_url(); ?>Customer">Manage Customer Accounts</a>
								<span class="icon-thumbnail">MCA</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Customer/rate">Manage Customer Rates</a>
								<span class="icon-thumbnail">MCR</span>
							</li>
						</ul>
					</li>

					<li class="m-t-10">
						<a href="javascript:;">
							<span class="title">Franchisee Account</span>
							<span class=" arrow "></span>
						</a>
						<span class="bg-success icon-thumbnail themebtn"><i class="pg-bag"></i></span>
						<ul class="sub-menu">

							<li class="">
								<a href="<?php echo base_url(); ?>Franchisee">Manage Franchisee Accounts</a>
								<span class="icon-thumbnail">MFA</span>
							</li>
							
						</ul>
					</li>

				<?php } ?>

				<li class="m-t-10">
						<a href="javascript:;">
							<span class="title">CN Book</span>
							<span class=" arrow "></span>
						</a>
						<span class="bg-success icon-thumbnail themebtn"><i class="pg-calender"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="<?php echo base_url(); ?>CnBook/default_load">CN Book</a>
								<span class="icon-thumbnail">CNB</span>
							</li>
						</ul>
					</li>
				
				<li class="m-t-10">
					<a href="javascript:;">
						<span class="title">Tools</span>
						<span class=" arrow "></span>
					</a>
					<span class="bg-success icon-thumbnail themebtn"><i class="pg-settings_small"></i></span>
					<ul class="sub-menu">
						<?php if ($_SESSION['is_supervisor'] == 1) { ?>
							<li class="">
								<a href="<?php echo base_url(); ?>Rider">Rider</a>
								<span class="icon-thumbnail">MR</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Route">Route</a>
								<span class="icon-thumbnail">MR</span>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>Direct/cs_index">Power Tools</a>
								<span class="icon-thumbnail">TOL</span>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>Route/file">Attach File</a>
								<span class="icon-thumbnail">AF</span>
							</li>
						<?php } ?>
						<li class="">
							<a href="<?php echo base_url(); ?>Home/setting_view">Change Password</a>
							<span class="icon-thumbnail">CP</span>
						</li>
					</ul>
				</li>
			</ul>
			<!---Accounts Powers ---->


			<div class="clearfix"></div>
		</div>
		<!-- END SIDEBAR MENU -->
	</nav>
	<!-- END SIDEBAR -->
	<!-- END SIDEBAR -->
	<!-- START PAGE-CONTAINER -->
	<div class="page-container">
		<!-- START PAGE HEADER WRAPPER -->
		<!-- START HEADER -->
		<div class="header ">
			<!-- START MOBILE SIDEBAR TOGGLE -->
			<a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
			</a>
			<!-- END MOBILE SIDEBAR TOGGLE -->
			<div class="">
				<div class="brand inline  m-l-10 ">
					<img src="<?php echo base_url(); ?>assets/img/tmlogo1.png" alt="logo" data-src="<?php echo base_url(); ?>assets/img/tmlogo1.png" data-src-retina="<?php echo base_url(); ?>assets/img/tmlogo1.png" width="120" height="80">
				</div>


			</div>
			<div class="d-flex align-items-center">
				<!-- START User Info-->
				<div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
					<span class="semi-bold"><?php echo $_SESSION['user_name']; ?> </span>
				</div>
				<div class="dropdown pull-right d-lg-block d-none">
					<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="thumbnail-wrapper d32 circular inline">
							<img src="https://cdn.iconscout.com/icon/free/png-256/laptop-user-1-1179329.png" alt="" data-src="https://cdn.iconscout.com/icon/free/png-256/laptop-user-1-1179329.png" data-src-retina="<?php echo base_url(); ?>assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
						</span>
					</button>
					<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
						<a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
						<a href="<?php echo base_url(); ?>Login/logout" class="clearfix bg-master-lighter dropdown-item">
							<span class="pull-left">Logout</span>
							<span class="pull-right"><i class="pg-power"></i></span>
						</a>
					</div>
				</div>
				<!-- END User Info-->

			</div>
		</div>
		<!-- END HEADER -->
		<!-- END PAGE HEADER WRAPPER -->