<?php

require_once "_conf.php";
require_once "_auth.php";

if( isset($_GET["id"]) && $_GET["id"]!="" ) {
	$id = str_ireplace("/", "", $_GET["id"]);
} else {
	die("No ID");
}

$type = $_GET["type"];

$founder = DB::queryFirstRow("SELECT * FROM $type WHERE id=%i", $id);

$nationality = false;
if( !empty($founder["nationality"]) ) $nationality = $founder["nationality"];

$startup_ids = $founder["startup_ids"];
$startup_ids = str_ireplace("}{", ",", $startup_ids);
$startup_ids = str_ireplace("}",  "", $startup_ids);
$startup_ids = str_ireplace("{",  "", $startup_ids);
//explode(",", $startup_ids);

$startups = DB::query("SELECT * FROM startups WHERE id IN ($startup_ids)");

$section = $type;
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
									<h6 class="m-0 font-weight-bold text-primary"><?php echo $type=="main_founders" ? "Main " : "Co-"; ?>founder data</h6>
									<?php
									$status_label = 'Active';
									$style = 'style="opacity: 1"';
									if( $founder["status"]=='0' ) {
										$status_label = 'Inactive';
										$style = 'style="opacity: .5"';
									}
									?>
									<div class="custom-control custom-switch" style="float: right">
										<input type="checkbox" class="custom-control-input" id="status" name="status" value="1" <?php if( $founder["status"]=='1' ) echo 'checked';?>>
										<label class="custom-control-label" for="status"><?php echo $status_label;?></label>
									</div>
								</div>
								<div class="card-body" id="card-body" <?php echo $style;?>>
									<table class="table table-bordered mt-2 table-form">
										<tbody>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Name</td>
												<td>
													<div class="show-data">
														<b class="text-gray-900 data-value"><?php echo htmlentities($founder["name"]);?></b>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="name" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Surame</td>
												<td>
													<div class="show-data">
														<b class="text-gray-900 data-value"><?php echo htmlentities($founder["surname"]);?></b>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="surname" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Startup</td>
												<td class="bg-gray-100">
													<?php
													foreach( $startups as $startup ) {
														if( $startup["status"]=='0' ) $style = 'style="opacity:.5; text-decoration: line-through;"';
														else $style = '';
													?>
													<a href="<?php echo BASEURL;?>backoffice/startup/<?php echo $startup["id"];?>/" <?php echo $style;?>><?php echo htmlentities($startup["startup_name"]);?></a>
													<br>
													<?php } ?>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Nationality</td>
												<td>
													<div class="show-data">
														<span class="data-value" hidden><?php echo htmlentities($founder["nationality"]);?></span>
														<?php if($nationality) { ?>
														<img src="<?php echo BASEURL."images/flags/".strtolower($nationality);?>.svg" data-src="<?php echo BASEURL."images/flags/";?>" class="flag" title="<?php echo $nationality;?>">
														<?php } ?>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="nationality" class="form-control d-inline">
														<?php include("_inc_countries_opt.php"); ?>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Fiscal code</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["fiscal_code"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="fiscal_code" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Birth date</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["birth_date"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="date" name="birth_date" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Place of birth</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["place_of_birth"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="place_of_birth" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">E-mail</td>
												<td class="bg-gray-100"><?php echo htmlentities($founder["email"]);?></td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Phone</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["phone"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="phone" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Address</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["address"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="address" class="form-control d-inline">
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
												<td class="text-right text-gray-500" style="width: 30%">University</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["university"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="university" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Degree</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["degree"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="degree" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Alumnus</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["alumnus"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="alumnus" class="form-control d-inline">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Alumnus year</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["alumnus_year"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="alumnus_year" class="form-control d-inline">
															<option value="">Not set</option>
															<?php
															for( $year=date("Y"); $year>=1960; $year--) {
																echo "<option value=\"$year\" >$year</option>";
															}
															?>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">IIT Researcher</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["iit_researcher"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="iit_researcher" class="form-control d-inline">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
														</select>
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
												<td class="text-right text-gray-500" style="width: 30%">Job title</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["job_title"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="job_title" class="form-control d-inline">
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Current company</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["current_company"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<input type="text" name="current_company" class="form-control d-inline">
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
												<td class="text-right text-gray-500" style="width: 30%">Privacy</td>
												<td>
													<div class="show-data">
														<span class="data-value"><?php echo htmlentities($founder["privacy"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<select name="privacy" class="form-control d-inline">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
														</select>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Permissions</td>
												<td>
													<div class="show-data">
														<span class="data-value multi"><?php echo str_replace(" | ", ", ", $founder["permissions"]);?></span>
														<a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
													</div>
													<div class="edit-data">
														<div class="d-inline-block">
															<div class="custom-control custom-checkbox mb-2">
																<input type="checkbox" name="permissions[]" id="type_promotion_1" class="custom-control-input" value="Promotion">
																<label class="custom-control-label" for="type_promotion_1">Promotion</label>
															</div>
															<div class="custom-control custom-checkbox mb-2">
																<input type="checkbox" name="permissions[]" id="type_promotion_2" class="custom-control-input" value="International data transfer">
																<label class="custom-control-label" for="type_promotion_2">International data transfer</label>
															</div>
														</div>
														<a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
														<a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									
									<table class="table table-bordered mt-4">
										<tbody>
											<?php if( $type=="main_founders" ) { ?>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Metabeta Code</td>
												<td class="bg-gray-100"><?php echo $founder["metabeta_code"];?></td>
											</tr>
											<?php } ?>
											<tr>
												<td class="text-right text-gray-500" style="width: 30%">Created on</td>
												<td class="bg-gray-100"><?php echo date("d F Y", strtotime($founder["created_on"]));?></td>
											</tr>
											<tr>
												<td class="text-right text-gray-500">Last update</td>
												<td class="bg-gray-100"><?php if( !empty($founder["updated_on"]) ) echo date("d F Y", strtotime($founder["updated_on"]));?></td>
											</tr>
										</tbody>
									</table>
									
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
	var _ID = '<?php echo $founder["id"];?>';
	var _TYPE = '<?php echo $type;?>';
	</script>
<?php
include("_footer.php");
?>

</body>
</html>