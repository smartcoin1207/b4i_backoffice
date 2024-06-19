<?php

require_once "_conf.php";
require_once "_auth.php";

$confirmedMainFounders = DB::queryFirstRow("SELECT COUNT(id) as total FROM main_founders");
$unconfirmedMainFounders = DB::queryFirstRow("SELECT COUNT(id) as total FROM main_founders_tmp");

$confirmedStartups = DB::queryFirstRow("SELECT COUNT(id) as total FROM startups");
$unconfirmedStartups = DB::queryFirstRow("SELECT COUNT(id) as total FROM startups_tmp");

$section = "dashboard";
include("_head.php");

?>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php include("_sidebar.php"); ?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content" class="pt-4">

				<!-- Topbar (mobile only) -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top d-md-none shadow">
					<button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>
				</nav>

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
					</div>

					<!-- Content Row -->
					<div class="row mb-4">

						<!-- Confirmed Startups -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Confirmed Startups</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($confirmedStartups["total"],0,",",".");?></div>
										</div>
										<div class="col-auto">
											<i class="far fa-building fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Unconfirmed Startups -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unconfirmed Startups</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($unconfirmedStartups["total"],0,",",".");?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-hourglass-end fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Confirmed Main Founders -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Confirmed main founders</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($confirmedMainFounders["total"],0,",",".");?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-user-check fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Unconfirmed Main founders -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unconfirmed main founders</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($unconfirmedMainFounders["total"],0,",",".");?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-user-clock fa-2x text-gray-300"></i><!-- fa-calendar-times -->
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<!-- End of Content Row -->

					<!-- Content Row -->
					<div class="row">
						<div class="col-12 mb-4">
							<h4 class="h4 mb-3">Analytics</h4>
							<p>
								<a class="d-inline-block mb-2" href="https://analytics.zoho.eu/open-view/146995000000019641" target="_blank">B4i Analytics Dashboard<i class="ml-2 fas fa-external-link-alt" style="font-size: .85rem;"></i></a>
								<br>
								<a class="d-inline-block mb-2" href="https://www.b4i.unibocconi.it/_app/lib/dashboard/" target="_blank">Site contacts dashboard<i class="ml-2 fas fa-external-link-alt" style="font-size: .85rem;"></i></a>
							</p>
						</div>

					</div>
					<!-- End of Content Row -->

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

<?php
include("_footer.php");
?>

</body>
</html>