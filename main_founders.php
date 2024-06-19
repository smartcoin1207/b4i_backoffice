<?php

require_once "_conf.php";
require_once "_auth.php";

$field = "activation_date";
$listLabel = "Utenti confermati";

$universities = array(
	'Università degli Studi di Bari',
	'Politecnico di Bari',
	'Università LUM &quot;Jean Monnet&quot;',
	'Università degli Studi della Basilicata',
	'Università degli Studi di Bergamo',
	'Università degli Studi di Bologna',
	'Libera Università di Bolzano',
	'Università degli Studi di Brescia',
	'Università degli Studi di Cagliari',
	'Università degli Studi della Calabria',
	'Università degli Studi di Camerino',
	'Università degli Studi di Cassino e Lazio Meridionale',
	'Università Cattaneo - LIUC Castellanza',
	'Università degli Studi di Catania',
	'Università degli Studi di Catanzaro',
	'Università degli Studi di Chieti e Pescara',
	'Università Kore di Enna',
	'Università degli Studi di Ferrara',
	'Università degli Studi di Firenze',
	'Università degli Studi di Foggia',
	'Università degli Studi di Genova',
	'Università degli Studi dell&rsquo;Insubria',
	'Università degli Studi dell&rsquo;Aquila',
	'Università degli Studi di Macerata',
	'Università degli Studi di Messina',
	'Università Cattolica del Sacro Cuore Milano',
	//'Politecnico di Milano',
	//'Università Bocconi di Milano',
	'Humanitas University Milano',
	'Università IULM Milano',
	'San Raffaele Milano',
	'Università degli Studi di Modena e Reggio Emilia',
	'Università degli Studi del Molise',
	'Università degli Studi di Napoli Federico II',
	'Università degli Studi della Campania Vanvitelli',
	'Università degli Studi L Orientale di Napoli',
	'Università degli Studi Suor Orsola Benincasa Napoli',
	'Università degli Studi di Padova',
	'Università degli Studi di Palermo',
	'Università degli Studi di Parma',
	'Università degli Studi di Pavia',
	'Università degli Studi di Perugia',
	'Università degli Studi Stranieri Perugia',
	'Università degli Studi del Piemonte Orientale',
	'Università degli Studi di Pisa',
	'Scuola Superiore Normale di Pisa',
	'Scuola Superiore Sant Anna di Pisa',
	'Politecnica delle Marche',
	'Università Mediterranea di Reggio Calabria',
	'Università degli Stranieri di Reggio Calabria',
	'Università Europea di Roma',
	'Università del Foro Italico di Roma',
	'Università degli Studi La Sapienza di Roma',
	'Università degli Studi di Tor Vergata di Roma',
	'Università degli Studi Roma Tre',
	'Università Campus Bio-Medico di Roma',
	'Università degli Studi LUISS Guido Carli di Roma',
	'Università degli Studi Internazionali di Roma UNINT',
	'Libera Università Maria SS Assunta LUMSA Roma',
	'UniCamillus',
	'Link Campus',
	'Università degli Studi del Salento',
	'Università degli Studi di Salerno',
	'Università degli Studi del Sannio di Benevento',
	'Università degli Studi di Sassari',
	'Università degli Studi di Siena',
	'Università degli Studi degli Stranieri di Siena',
	'Università Telematica Leonardo Da Vinci',
	'Università Telematica E-Campus',
	'Università Telematica Giustino Fortunato',
	'Università Telematica Guglielmo Marconi',
	'Università Telematica San Raffaele Roma',
	'Università Telematica UniNettuno',
	'Università Telematica IUL',
	'Università Telematica Pegaso',
	'Università Telematica Unitelma Sapienza',
	'Università Telematica Unicusano',
	'Università Telematica Universitas Mercatorum',
	'Università degli Studi di Teramo',
	'Università degli Studi di Torino',
	'Politecnico di Torino',
	'Università degli Studi di Trento',
	'Università degli Studi di Trieste',
	'Università degli Studi Sissa Trieste',
	'Università degli Studi della Tuscia',
	'Università degli Studi di Udine',
	'Università degli Studi di Urbino Carlo Bo',
	'Università degli Studi della Valle d&rsquo;Aosta',
	'Università degli Studi Cà Foscari di Venezia',
	'Università degli Studi di Verona',
	'Scuola IMT di Lucca',
	'IUSS di Pavia',
);
sort($universities);

// SELECT startups.id as startup_id, startups.startup_name, main_founders.* FROM main_founders LEFT JOIN startups ON main_founders.startup_ids LIKE CONCAT('%{', startups.id, '}%')

if( !empty($_GET) ) {
	$q = "";
	if( !empty($_GET["q"]) ) {
		$q = $_GET["q"];
		$q = "AND (main_founders.name LIKE '%$q%' OR main_founders.surname LIKE '%$q%' OR main_founders.nationality LIKE '%$q%' OR main_founders.university LIKE '%$q%' OR main_founders.degree LIKE '%$q%')";
	}
	$date_start = "";
	if( !empty($_GET["date_start"]) ) {
		$date_start = "AND main_founders.created_on >= '".$_GET["date_start"]."'";
	}
	$date_end = "";
	if( !empty($_GET["date_end"]) ) {
		$date_end = "AND main_founders.created_on <= '".$_GET["date_end"]."' + INTERVAL 1 DAY";
	}
	$call_name = "";
	if( !empty($_GET["call_name"]) ) {
		$call_name = "AND main_founders.call_name = '".$_GET["call_name"]."'";
	}
	/*
	$application_request = "";
	if( !empty($_GET["application"]) ) {
		$application_request = "AND startups.application_request = '".$_GET["application"]."'";
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
	*/
	$country = "";
	if( !empty($_GET["country"]) ) {
		$country = "AND main_founders.nationality = '".$_GET["country"]."'";
	}
	if( !empty($_GET["stranger"]) ) {
		$country = "AND main_founders.nationality <> 'IT'";
	}
	$gender = "";
	if( !empty($_GET["gender"]) ) {
		$gender = "AND main_founders.gender = '".$_GET["gender"]."'";
	}
	$university = "";
	if( !empty($_GET["university"]) ) {
		if( $_GET["university"]=="other" ) {
			$university = "AND main_founders.university NOT IN ('".implode("', '", $universities)."')";
		} else {
			$university = "AND main_founders.university = '".$_GET["university"]."'";
		}
	}
	$alumnus = "";
	if( !empty($_GET["alumnus"]) ) {
		$alumnus = "AND main_founders.alumnus = 'Yes'";
	}
	$iit_researcher = "";
	if( !empty($_GET["iit_researcher"]) ) {
		$iit_researcher = "AND main_founders.iit_researcher = 'Yes'";
	}
	$developer = "";
	if( !empty($_GET["developer"]) ) {
		$developer = "AND main_founders.developer = 'Yes'";
	}
	$status = "main_founders.status<>'-1'";
	if( !empty($_GET["status_active"]) && !empty($_GET["status_inactive"]) ) {
		$status = "(main_founders.status = '1' OR main_founders.status = '0')";
	}
	if( !empty($_GET["status_active"]) && empty($_GET["status_inactive"]) ) {
		$status = "main_founders.status = '1'";
	}
	if( empty($_GET["status_active"]) && !empty($_GET["status_inactive"]) ) {
		$status = "main_founders.status = '0'";
	}
	$grant_application = "";
	if( !empty($_GET["grant_application"]) ) {
		$grant_application = "AND startups.grant_application = '".$_GET["grant_application"]."'";
	}
	//$query = "SELECT main_founders.* FROM main_founders WHERE $status $q $date_start $date_end $call_name $country $gender $university $alumnus $iit_researcher $developer ORDER BY created_on DESC";
	$query = "SELECT startups.grant_application as grant_application, main_founders.*
						FROM main_founders
						JOIN startups ON FIND_IN_SET(startups.id, REPLACE(REPLACE(REPLACE(main_founders.startup_ids, '}{', ','), '{', ''), '}', '')  ) > 0
						WHERE $status $q $date_start $date_end $call_name $country $gender $university $alumnus $iit_researcher $developer $grant_application
						GROUP BY main_founders.id
						ORDER BY main_founders.created_on DESC";
	// export
	if( !empty($_GET["action"]) && $_GET["action"]=="export" ) {
		//$query = "SELECT main_founders.* FROM main_founders WHERE $status $q $date_start $date_end $call_name $country $gender $university $alumnus $iit_researcher $developer ORDER BY created_on DESC";
		$query = "SELECT startups.grant_application as grant_application, main_founders.*
							FROM main_founders
							JOIN startups ON FIND_IN_SET(startups.id, REPLACE(REPLACE(REPLACE(main_founders.startup_ids, '}{', ','), '{', ''), '}', '')  ) > 0
							WHERE $status $q $date_start $date_end $call_name $country $gender $university $alumnus $iit_researcher $developer $grant_application
							GROUP BY main_founders.id
							ORDER BY main_founders.created_on DESC";
		$founders = DB::query($query);
		$file = "main_founders.csv";
		include("_export_founders.php");
	}
	$main_founders = DB::query($query);
} else {
	$query = "SELECT * FROM main_founders ORDER BY created_on DESC";
	$main_founders = DB::query($query);
}

$calls = DB::query("SELECT DISTINCT(call_name) FROM main_founders WHERE call_name<>'' ORDER BY call_name ASC");
//$universities = DB::query("SELECT DISTINCT(university) FROM main_founders WHERE university<>'' ORDER BY university ASC");

$section = "main_founders";
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

					<!-- Users Card > Table -->
					<div class="card shadow mb-4">
						<div class="card-header d-sm-flex align-items-center justify-content-between py-3">
							<h6 class="m-0 font-weight-bold text-primary d-inline-block">Main founders</h6>
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
								<select class="form-control" id="call_name" name="call_name" style="width: 230px;">
									<option value="">Not set</option>
									<?php
									foreach( $calls as $call ) {
										$selected = "";
										if( !empty($_GET["call_name"]) && $call["call_name"]==$_GET["call_name"] ) $selected = "selected";
										echo "<option value=\"".$call["call_name"]."\" $selected>".$call["call_name"]."</option>";
									}
									?>
								</select>
								<label for="country" class="ml-4 mr-3">Country</label>
								<select class="form-control" id="country" name="country" style="width: 230px;">
									<?php
									if( !empty($_GET["country"]) ) echo '<option value="'.$_GET["country"].'" selected>'.getCountry($_GET["country"]).'</option>';
									include("_inc_countries_opt.php");
									?>
								</select>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="stranger" id="stranger" class="custom-control-input" value="1" <?php if( !empty($_GET["stranger"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="stranger">Not italian</label>
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
								<label for="gender" class="mr-3">Genre</label>
								<select class="form-control" id="gender" name="gender" style="width: 230px;">
									<option value="">Not set</option>
									<option value="male" <?php if( !empty($_GET["gender"]) && $_GET["gender"]=="male") echo "selected";?>>Male</option>
									<option value="female" <?php if( !empty($_GET["gender"]) && $_GET["gender"]=="female" ) echo "selected";?>>Female</option>
									<option value="undeclared" <?php if( !empty($_GET["gender"]) && $_GET["gender"]=="undeclared" ) echo "selected";?>>Undeclared</option>
								</select>
								<label for="university" class="ml-4 mr-3">University</label>
								<select class="form-control" id="university" name="university" style="width: 230px;">
									<option value="">Not set</option>
									<?php
									foreach( $universities as $university ) {
										$selected = "";
										if( !empty($_GET["university"]) && $university==$_GET["university"] ) $selected = "selected";
										echo "<option value=\"".$university."\" $selected>".$university."</option>";
									}
									?>
									<option value="other" <?php if( !empty($_GET["university"]) && $_GET["university"]=="other" ) echo "selected";?>>Other</option>
								</select>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="alumnus" id="alumnus" class="custom-control-input" value="1"<?php if( !empty($_GET["alumnus"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="alumnus">Alumni</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="iit_researcher" id="iit_researcher" class="custom-control-input" value="1"<?php if( !empty($_GET["iit_researcher"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="iit_researcher">IIT Researcher</label>
								</div>
								<div class="custom-control custom-checkbox d-inline-block ml-4 mr-2">
									<input type="checkbox" name="developer" id="developer" class="custom-control-input" value="1"<?php if( !empty($_GET["developer"]) ) echo "checked";?>>
									<label class="custom-control-label m-0" for="developer">Developer</label>
								</div>
							</div>
							<hr>
							<div class="form-inline">
								<label for="grant_application" class="mr-3">Program granted</label>
								<select class="form-control" name="grant_application" id="grant_application" style="width: 230px;">
									<option value="">Not set</option>
									<option value="Pre-acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Pre-acceleration program") echo "selected";?>>Pre-acceleration program</option>
									<option value="Acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Acceleration program" ) echo "selected";?>>Acceleration program</option>
									<!-- <option value="Acceleration or pre-acceleration program" <?php if( !empty($_GET["grant_application"]) && $_GET["grant_application"]=="Acceleration or pre-acceleration program" ) echo "selected";?>>Acceleration or pre-acceleration program</option> -->
								</select>
							</div>
							<hr>
							<div class="text-right">
								<a class="btn btn-sm btn-light" href="<?php echo BASEURL;?>backoffice/main_founders/">Reset</a>
								<input class="btn btn-sm btn-primary ml-5" type="submit" value="Search">
							</div>
						</form>
						
						<div class="card-body">
							<?php if( isset($_GET["action"]) ) { ?>
							<div class="alert alert-success">
								<?php
								if( $_GET["action"]=="delete" ) echo "Utente eliminato.";
								?>
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							</div>
							<?php } ?>
							<form class="table-responsive" id="founders-list">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-order='[[ 7, "desc" ]]'>
									<thead>
										<tr>
											<th data-orderable='false'>
												<input type="checkbox" name="set_all" id="set-all" value="1">
											</th>
											<th class="text-gray-500">Full name</th>
											<th class="text-gray-500">Country</th>
											<th class="text-gray-500">School</th>
											<th class="text-gray-500">Degree</th>
											<th class="text-gray-500">Alumnus</th>
											<th class="text-gray-500">IIT</th>
											<th class="text-gray-500">Date</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th class="text-gray-500">Full name</th>
											<th class="text-gray-500">Country</th>
											<th class="text-gray-500">School</th>
											<th class="text-gray-500">Degree</th>
											<th class="text-gray-500">Alumnus</th>
											<th class="text-gray-500">IIT</th>
											<th class="text-gray-500">Date</th>
										</tr>
									</tfoot>
									<tbody>
									<?php
									foreach($main_founders as $main_founder) {
										$date = date("d/m/Y", strtotime($main_founder["created_on"]));
										if( $main_founder["status"]=='0' ) $style = 'style="opacity:.5"';
										else $style = '';
									?>
										<tr <?php echo $style;?>>
											<td>
												<input type="checkbox" name="status[]" value="<?php echo $main_founder["id"];?>" data-status="<?php echo $main_founder["status"];?>">
											</td>
											<td>
												<a href="<?php echo BASEURL;?>backoffice/main_founder/<?php echo $main_founder["id"];?>/">
													<?php echo htmlentities($main_founder["name"]." ".$main_founder["surname"]);?>
												</a>
											</td>
											<td data-order="<?php echo $main_founder["nationality"];?>"><img src="<?php echo BASEURL."images/flags/".strtolower($main_founder["nationality"]);?>.svg" class="flag" title="<?php echo $main_founder["nationality"];?>"></td>
											<td><?php echo htmlentities($main_founder["university"]);?></td>
											<td><?php echo htmlentities($main_founder["degree"]);?></td>
											<td><?php echo htmlentities($main_founder["alumnus"]);?></td>
											<td><?php echo htmlentities($main_founder["iit_researcher"]);?></td>
											<td data-order="<?php echo $main_founder["created_on"];?>" data-search="<?php echo $main_founder["metabeta_code"];?>"><?php echo $date;?></td>
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
	var _TYPE = 'main_founders';
	</script>
<?php
include("_footer.php");
?>

</body>
</html>