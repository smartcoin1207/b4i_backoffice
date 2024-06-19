<?php

require_once "_conf.php";
require_once "_auth.php";

if( isset($_GET["id"]) && $_GET["id"]!="" ) {
	$id = str_ireplace("/", "", $_GET["id"]);
} else {
	die("No ID");
}

$startup = DB::queryFirstRow("SELECT * FROM startups WHERE id=%i", $id);
if( empty($startup) ) die("Startup not found");

$country = false;
if( !empty($startup["company_country"]) ) $country = $startup["company_country"];

$startup_country = false;
if( !empty($startup["startup_country"]) ) $startup_country = $startup["startup_country"];

$main_founder = DB::queryFirstRow("SELECT * FROM main_founders WHERE startup_ids LIKE %ss", "{".$id."}");
$co_founders = DB::query("SELECT * FROM co_founders WHERE startup_ids LIKE %ss", "{".$id."}");

$section = "startup_list";
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
						<a href="javascript:history.back();" class="btn btn-light btn-sm"><i class="fas fa-angle-left fa-sm"></i>&nbsp;&nbsp;back</a>
					</div>

					<!-- Content Row -->
					<div class="row">

						<div class="col-xl-10 offset-xl-1 mb-4">
							
							<div class="card shadow mb-4">
								<div class="card-header d-sm-flex align-items-center justify-content-between py-3">
									<h6 class="m-0 font-weight-bold text-primary">Startup data</h6>
									<?php
									$status_label = 'Active';
									$style = 'style="opacity: 1"';
									if( $startup["status"]=='0' ) {
										$status_label = 'Inactive';
										$style = 'style="opacity: .5"';
									}
									?>
									<div class="custom-control custom-switch" style="float: right">
										<input type="checkbox" class="custom-control-input" id="status" name="status" value="1" <?php if( $startup["status"]=='1' ) echo 'checked';?>>
										<label class="custom-control-label" for="status"><?php echo $status_label;?></label>
									</div>
								</div>
								<div class="card-body" id="card-body" <?php echo $style;?>>
									<table class="table table-bordered mt-2 table-form">
										<tbody>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Startup name</td>
												<td>
													<div class="show-data">
														<b class="text-gray-900 data-value"><?php echo htmlentities($startup["startup_name"]);?></b>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="startup_name" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
<!--
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Startup country</td>
												<td>
													<div class="show-data">
														<b class="text-gray-900 data-value"><?php echo htmlentities($startup["startup_country"]);?></b>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="startup_country" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
-->
											<tr>
												<td class="text-right text-gray-500">Startup country</td>
												<td>
													<div class="show-data">
														<span class="data-value" hidden><?php echo htmlentities($startup["startup_country"]);?></span>
														<?php if($startup_country) { ?>
														<img src="<?php echo BASEURL."images/flags/".strtolower($startup_country);?>.svg" data-src="<?php echo BASEURL."images/flags/";?>" class="flag" title="<?php echo $startup_country;?>">
														<?php } ?>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="startup_country" class="form-control d-inline">
														<?php include("_inc_countries_opt.php"); ?>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Startup city</td>
												<td>
													<div class="show-data">
														<b class="text-gray-900 data-value"><?php echo htmlentities($startup["startup_city"]);?></b>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="startup_city" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Incorporated</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["incorporated"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="incorporated" class="form-control d-inline">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Company name</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["company_name"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="company_name" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Tax code</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["company_tax_code"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="company_tax_code" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Country</td>
												<td>
													<div class="show-data">
														<span class="data-value" hidden><?php echo htmlentities($startup["company_country"]);?></span>
														<?php if($country) { ?>
														<img src="<?php echo BASEURL."images/flags/".strtolower($country);?>.svg" data-src="<?php echo BASEURL."images/flags/";?>" class="flag" title="<?php echo $country;?>">
														<?php } ?>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="company_country" class="form-control d-inline">
														<?php include("_inc_countries_opt.php"); ?>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">E-mail</td>
												<td class="bg-gray-100">
													<?php echo htmlentities($startup["company_email"]);?>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Address</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["company_address"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="company_address" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									
									<table class="table table-bordered mt-4 table-form">
										<tbody>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Program request</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["application_request"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="application_request" class="form-control d-inline">
															<option value="Acceleration program">Acceleration program</option>
															<option value="Pre-acceleration program">Pre-acceleration program</option>
															<option value="Acceleration or pre-acceleration program">Acceleration or pre-acceleration program</option>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Sustainability</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($startup["sustainability"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="sustainability" class="form-control d-inline">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											
											<tr>
												<td class="text-right text-gray-500">Acceleration track</td>
												<td>
													<div class="show-data">
														<span class="data-value multi"><?php echo str_replace(" | ", ", ", $startup["acceleration_track"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<div class="d-inline-block">
															<div class="custom-control custom-checkbox mb-2">
																<input type="checkbox" name="acceleration_track[]" id="acceleration_track_1" class="custom-control-input" value="Digital tech">
																<label class="custom-control-label" for="acceleration_track_1">Digital tech</label>
															</div>
															<div class="custom-control custom-checkbox mb-2">
																<input type="checkbox" name="acceleration_track[]" id="acceleration_track_2" class="custom-control-input" value="Made in Italy">
																<label class="custom-control-label" for="acceleration_track_2">Made in Italy</label>
															</div>
															<div class="custom-control custom-checkbox mb-2">
																<input type="checkbox" name="acceleration_track[]" id="acceleration_track_3" class="custom-control-input" value="Sustainability">
																<label class="custom-control-label" for="acceleration_track_3">Sustainability</label>
															</div>
														</div>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									
									<table class="table table-borderless table-form">
										<tbody>
											<tr>
												<td class="text-right text-gray-800" style="width: 30%; vertical-align: middle;">
													<?php
													if( empty($startup["grant_application"]) ) {
													?>
													Grant application
													<?php } ?>
												</td>
												<td>
													<?php
													if( empty($startup["grant_application"]) ) {
													?>
													<a href="#grant" id="grant-now" class="btn btn-primary">Grant now</a>
													<div class="edit-data" style="display: none; line-height: 38px;">
														<select id="grant_application" name="grant_application" class="form-control d-inline" style="max-width: 50%;">
															<option value="" disabled selected>Choose</option>
															<option value="Acceleration program">Grant ACCELERATION</option>
															<option value="Pre-acceleration program">Grant PRE-ACCELERATION</option>
														</select>
														<a href="#cancel" id="cancel-grant" class="float-right">Cancel</a>
														<a href="#save" id="save-grant" class="btn btn-success float-right mr-3"><i class="fas fa-check"></i> Confirm</a>
													</div>
													<div class="spinner-border text-primary" style="display: none"></div>
													<?php
													} else {
														echo '<b class="text-primary mr-2">🎉 '.strtoupper($startup["grant_application"]).' 🎉</b> granted on '.date("d F Y", strtotime($startup["granted_on"]));
													}
													?>
												</td>
											</tr>
										</tbody>
									</table>
									
									<table class="table table-bordered mt-4">
										<tbody>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Created on</td>
												<td class="bg-gray-100"><?php echo date("d F Y", strtotime($startup["created_on"]));?></td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Last update</td>
												<td class="bg-gray-100"><?php if( !empty($startup["updated_on"]) ) echo date("d F Y", strtotime($startup["updated_on"]));?></td>
											</tr>
										</tbody>
									</table>
									
								</div><!-- .card-body -->
							</div><!-- .card -->
							
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Main founder</h6>
									<?php
									if( $main_founder["status"]=='0' ) $style = 'style="opacity:.5; text-decoration: line-through;"';
									else $style = '';
									?>
								</div>
								<div class="card-body">
									<table class="table table-bordered mt-2">
										<tbody>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Full name</td>
												<td class="bg-gray-100" <?php echo $style;?>>
													<a href="<?php echo BASEURL;?>backoffice/main_founder/<?php echo $main_founder["id"];?>/">
														<?php echo htmlentities($main_founder["name"]." ".$main_founder["surname"]);?>
													</a>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">E-mail</td>
												<td class="bg-gray-100" <?php echo $style;?>><?php echo htmlentities($main_founder["email"]);?></td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Metabeta Code</td>
												<td class="bg-gray-100"><?php echo $main_founder["metabeta_code"];?></td>
											</tr>
										</tbody>
									</table>
								</div><!-- .card-body -->
							</div><!-- .card -->
							
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Co-founders</h6>
								</div>
								<div class="card-body">
									<?php
									if( !empty($co_founders) ) {
									?>
									<table class="table table-bordered mt-2">
										<tbody>
											<?php
											$i = 0;
											foreach( $co_founders as $co_founder ) {
												$i++;
												if( $co_founder["status"]=='0' ) $style = 'style="opacity:.5; text-decoration: line-through;"';
												else $style = '';
											?>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Co-founder <?php echo $i;?></td>
												<td class="bg-gray-100" <?php echo $style;?>>
													<a href="<?php echo BASEURL;?>backoffice/co_founder/<?php echo $co_founder["id"];?>/">
														<?php echo htmlentities($co_founder["name"]." ".$co_founder["surname"]);?>
													</a>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php } else { ?>
									<p>There are no co-founders.</p>
									<?php } ?>
								</div><!-- .card-body -->
							</div><!-- .card -->
							
						</div><!-- .col -->
						
					</div>
					<!-- End of Content Row -->

					<!-- Content Row -->
					<div class="row">

					</div>
					<!-- End of Content Row -->

					<!-- Page End -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<a href="javascript:history.back();" class="btn btn-light btn-sm"><i class="fas fa-angle-left fa-sm"></i>&nbsp;&nbsp;back</a>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Modal: dismiss device -->
	<div class="modal fade" id="change-status-modal">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Change status</h5>
	      </div>
	      <div class="modal-body">
	        <p>Do you confirm to change the status?</p>
	        <form id="form-dismiss-device" method="post">
		        <input type="hidden" name="id" value="<?php echo $startup["id"];?>">
		        <input type="hidden" name="table" value="startups">
		      </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-light" id="btn-dismiss-modal" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" id="btn-confirm-modal">Confirm</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>
	var _BASEURL = '<?php echo BASEURL;?>backoffice/';
	var _ID = '<?php echo $startup["id"];?>';
	var _TYPE = 'startups';
	</script>
<?php
include("_footer.php");
?>

</body>
</html>