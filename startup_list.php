<?php

require_once "_conf.php";
require_once "_auth.php";

$field = "activation_date";
$listLabel = "Utenti confermati";

if( DEV ) DB::query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

if( !empty($_GET) ) {
	$q = "";
	if( !empty($_GET["q"]) ) {
		$q = "AND (startups.startup_name LIKE '%".$_GET["q"]."%' OR startups.application_request LIKE '%".$_GET["q"]."%' OR startups.grant_application LIKE '%".$_GET["q"]."%' OR startups.company_country LIKE '%".$_GET["q"]."%')";
	}
	$date_start = "";
	if( !empty($_GET["date_start"]) ) {
		$date_start = "AND startups.created_on >= '".$_GET["date_start"]."'";
	}
	$date_end = "";
	if( !empty($_GET["date_end"]) ) {
		$date_end = "AND startups.created_on <= '".$_GET["date_end"]."' + INTERVAL 1 DAY";
	}
	$call_name = "";
	if( !empty($_GET["call_name"]) ) {
		$call_name = "AND startups.call_name = '".$_GET["call_name"]."'";
	}
	$application_request = "";
	if( !empty($_GET["application"]) ) {
		$application_request = "AND startups.application_request = '".$_GET["application"]."'";
	}
	$grant_application = "";
	if( !empty($_GET["grant_application"]) ) {
		$grant_application = "AND startups.grant_application = '".$_GET["grant_application"]."'";
	}
	$acc_track_1 = "";
	if( !empty($_GET["acceleration_track_1"]) ) {
		$acc_track_1 = "AND startups.acceleration_track LIKE '%".$_GET["acceleration_track_1"]."%'";
	}
	$acc_track_2 = "";
	if( !empty($_GET["acceleration_track_2"]) ) {
		$acc_track_2 = "AND startups.acceleration_track LIKE '%".$_GET["acceleration_track_2"]."%'";
	}
	$acc_track_3 = "";
	if( !empty($_GET["acceleration_track_3"]) ) {
		$acc_track_3 = "AND startups.acceleration_track LIKE '%".$_GET["acceleration_track_3"]."%'";
	}
	$country = "";
	if( !empty($_GET["country"]) ) {
		$country = "AND startups.company_country = '".$_GET["country"]."'";
	}
	$incorporated = "";
	if( !empty($_GET["incorporated"]) ) {
		$incorporated = "AND startups.incorporated = 'Yes'";
	}
	$status = "";
	if( !empty($_GET["status_active"]) && !empty($_GET["status_inactive"]) ) {
		$status = "AND (startups.status = '1' OR startups.status = '0')";
	}
	if( !empty($_GET["status_active"]) && empty($_GET["status_inactive"]) ) {
		$status = "AND startups.status = '1'";
	}
	if( empty($_GET["status_active"]) && !empty($_GET["status_inactive"]) ) {
		$status = "AND startups.status = '0'";
	}
	
	$query = "SELECT startups.*, main_founders.startup_ids, main_founders.nationality, main_founders.metabeta_code FROM startups LEFT JOIN main_founders ON main_founders.startup_ids LIKE CONCAT('%{',startups.id,'}%') WHERE startups.status<>'-1' $q $date_start $date_end $call_name $application_request $grant_application $acc_track_1 $acc_track_2 $acc_track_3 $country $incorporated $status GROUP BY startups.id ORDER BY startups.created_on DESC ";
	// export
	if( !empty($_GET["action"]) && $_GET["action"]=="export" ) {
		$query = "SELECT startups.*, main_founders.startup_ids, main_founders.nationality, main_founders.metabeta_code FROM startups LEFT JOIN main_founders ON main_founders.startup_ids LIKE CONCAT('%{',startups.id,'}%') WHERE startups.status='1' $q $date_start $date_end $call_name $application_request $grant_application $acc_track_1 $acc_track_2 $acc_track_3 $country $incorporated $status GROUP BY startups.id ORDER BY startups.created_on DESC ";
		$startups = DB::query($query);
		include("_export_startups.php");
	}
	$startups = DB::query($query);
} else {
	$query = "SELECT startups.*, main_founders.metabeta_code FROM startups LEFT JOIN main_founders ON main_founders.startup_ids LIKE CONCAT('%{',startups.id,'}%') GROUP BY startups.id ORDER BY created_on DESC";
	$startups = DB::query($query);
}

$calls = DB::query("SELECT DISTINCT(call_name) FROM startups WHERE call_name<>'' ORDER BY call_name ASC");

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

					<!-- Startups Card > Table -->
					<div class="card shadow mb-4">
						<div class="card-header d-sm-flex align-items-center justify-content-between py-3">
							<h6 class="m-0 font-weight-bold text-primary d-inline-block">Startup list</h6>
							<div>
								<a id="search" href="#search" class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm mr-1">
									<i class="fas fa-search fa-sm"></i>&nbsp;&nbsp;advanced search
								</a>
								<a id="export" href="<?php echo $actual_link;?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
									<i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;export csv
								</a>
							</div>
						</div>
						
						<!-- SEARCH FORM -->
						<form id="search_form" class="card-header py-4" method="get" style="min-width: 1120px; <?php if( empty($_GET) ) echo "display: none;";?>">
							<div class="form-inline">
								<label for="date_start" class="mr-3">Date range</label>
								<input type="date" class="form-control" name="date_start" id="date_start" value="<?php if( !empty($_GET["date_start"]) ) echo $_GET["date_start"];?>">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; 
								<input type="date" class="form-control" name="date_end" id="date_end"  value="<?php if( !empty($_GET["date_end"]) ) echo $_GET["date_end"];?>">
							</div>
							<hr>
							<div class="form-inline">
								<label for="call_name" class="mr-3">Batch</label>
								<select class="form-control" name="call_name" id="call_name" style="width: 230px;">
									<option value="">Not set</option>
									<?php
									foreach( $calls as $call ) {
										$selected = "";
										if( !empty($_GET["call_name"]) && $call["call_name"]==$_GET["call_name"] ) $selected = "selected";
										echo "<option value=\"".$call["call_name"]."\" $selected>".$call["call_name"]."</option>";
									}
									?>
								</select>
								
								<label for="application" class="ml-4 mr-3">Grant application</label>
								<select class="form-control" name="application" id="application" style="width: 230px;">
									<option value="">Not set</option>
									<option value="Pre-acceleration program" <?php if( !empty($_GET["application"]) && $_GET["application"]=="Pre-acceleration program") echo "selected";?>>Pre-acceleration program</option>
									<option value="Acceleration program" <?php if( !empty($_GET["application"]) && $_GET["application"]=="Acceleration program" ) echo "selected";?>>Acceleration program</option>
									<option value="Acceleration or pre-acceleration program" <?php if( !empty($_GET["application"]) && $_GET["application"]=="Acceleration or pre-acceleration program" ) echo "selected";?>>Acceleration or pre-acceleration program</option>
								</select>
								
								<label for="grant_application" class="ml-4 mr-3">Program granted</label>
								<select class="form-control" name="grant_application" id="grant_application" style="width: 230px;">
									<option value="">Not set</option>
									<option value="Pre-acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Pre-acceleration program") echo "selected";?>>Pre-acceleration program</option>
									<option value="Acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Acceleration program" ) echo "selected";?>>Acceleration program</option>
									<!-- <option value="Acceleration or pre-acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Acceleration or pre-acceleration program" ) echo "selected";?>>Acceleration or pre-acceleration program</option> -->
								</select>
							</div>
							<hr>
							<div class="form-inline">
								<label for="country" class="mr-3">Country</label>
								<select class="form-control" name="country" id="country" style="width: 230px;">
									<?php
									if( !empty($_GET["country"]) ) echo '<option value="'.$_GET["country"].'" selected>'.getCountry($_GET["country"]).'</option>';
									include("_inc_countries_opt.php");
									?>
								</select>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="incorporated" id="incorporated" class="custom-control-input" value="1" <?php if( !empty($_GET["incorporated"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="incorporated">Incorporated</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="status_active" id="status_active" class="custom-control-input" value="1" <?php if( !empty($_GET["status_active"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="status_active">Status active</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="status_inactive" id="status_inactive" class="custom-control-input" value="1" <?php if( !empty($_GET["status_inactive"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="status_inactive">Status inactive</label>
								</div>
							</div>
							<hr>
							<div class="form-inline">
								<div class="custom-control custom-checkbox d-inline-block mr-2">
									<input type="checkbox" name="acceleration_track_1" id="acceleration_track_1" class="custom-control-input" value="Digital tech" <?php if( !empty($_GET["acceleration_track_1"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="acceleration_track_1">Digital tech</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="acceleration_track_2" id="acceleration_track_2" class="custom-control-input" value="Made in Italy" <?php if( !empty($_GET["acceleration_track_2"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="acceleration_track_2">Made in Italy</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-3">
									<input type="checkbox" name="acceleration_track_3" id="acceleration_track_3" class="custom-control-input" value="Sustainability" <?php if( !empty($_GET["acceleration_track_3"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="acceleration_track_3">Sustainability</label>
								</div>
							</div>
							<hr>
							<div class="text-right">
								<a class="btn btn-sm btn-light" href="<?php echo BASEURL;?>backoffice/startup_list/">Reset</a>
								<input class="btn btn-sm btn-primary ml-5" type="submit" value="Search">
							</div>
						</form>
						
						<div class="card-body">
							<?php if( isset($_GET["action"]) ) { ?>
							<!--
							<div class="alert alert-success">
								<?php
								if( $_GET["action"]=="delete" ) echo "Utente eliminato.";
								?>
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							</div>
							-->
							<?php } ?>
							<form class="table-responsive" id="startups-list">
								<table class="table table-bordered" id="dataTable-startups" width="100%" cellspacing="0" data-order='[[ 7, "desc" ]]'>
									<thead>
										<tr>
											<th data-orderable='false'>
												<input type="checkbox" name="set_all" id="set-all" value="1">
											</th>
											<th class="text-gray-500">Startup&nbsp;name</th>
											<th class="text-gray-500">Inc.</th>
											<th class="text-gray-500">Country</th>
											<th class="text-gray-500">Program&nbsp;requested</th>
											<th class="text-gray-500">Program&nbsp;granted</th>
											<th class="text-gray-500">Acceleration track</th>
											<th class="text-gray-500">Date</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th class="text-gray-500">Startup&nbsp;name</th>
											<th class="text-gray-500">Inc.</th>
											<th class="text-gray-500">Country</th>
											<th class="text-gray-500">Program&nbsp;requested</th>
											<th class="text-gray-500">Program&nbsp;granted</th>
											<th class="text-gray-500">Acceleration track</th>
											<th class="text-gray-500">Date</th>
										</tr>
									</tfoot>
									<tbody>
									<?php
									foreach($startups as $startup) {
										$date = date("d/m/Y", strtotime($startup["created_on"]));
										$country = false;
										if( !empty($startup["company_country"]) ) $country = $startup["company_country"];
										if( $startup["status"]=='0' ) $style = 'style="opacity:.5"';
										else $style = '';
									?>
										<tr <?php echo $style;?>>
											<td>
												<input type="checkbox" name="status[]" value="<?php echo $startup["id"];?>" data-status="<?php echo $startup["status"];?>">
											</td>
											<td>
												<a href="<?php echo BASEURL;?>backoffice/startup/<?php echo $startup["id"];?>/"><?php echo htmlentities($startup["startup_name"]);?></a>
											</td>
											<td><?php echo htmlentities($startup["incorporated"]);?></td>
											<td data-order="<?php if($country) echo $country;?>">
												<?php if($country) { ?><img src="<?php echo BASEURL."images/flags/".strtolower($country);?>.svg" class="flag" title="<?php echo $country;?>"><?php } ?>
											</td>
											<td><?php echo htmlentities($startup["application_request"]);?></td>
											<td><span class="text-gray-900"><?php echo htmlentities($startup["grant_application"]);?></span></td>
											<td><?php echo htmlentities($startup["acceleration_track"]);?></td>
											<td data-order="<?php echo $startup["created_on"];?>" data-search="<?php echo $startup["metabeta_code"];?>"><?php echo $date;?></td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
							</form>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->
	
	<!-- Modal: change status -->
	<div class="modal fade" id="multi-change-status-modal">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Change status</h5>
	      </div>
	      <div class="modal-body">
	        <p>Do you confirm to change the status to <b id="status-label"></b> for <span id="list-items"></span>?</p>
	        <form id="form-dismiss-device" method="post">
		        <input type="hidden" name="id" value="2833">
		        <input type="hidden" name="table" value="startups">
		      </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" id="btn-confirm-change">Confirm</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>
	var _BASEURL = '<?php echo BASEURL;?>backoffice/';
	var _TYPE = 'startups';
	</script>
<?php
include("_footer.php");
?>

</body>
</html>