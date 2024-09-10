<?php

require_once "_conf.php";
require_once "_auth.php";

/** Thousand Three Comma Number */
function formatThousandComma($number) {
    $sanitizeNumber = sanitizeNumber($number);
    return number_format($sanitizeNumber, 0, '.', ',');
}

function sanitizeNumber($input) {
    // Remove non-numeric characters except for the decimal point
    return preg_replace('/[^\d.]/', '', $input);
}

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

if( !empty($_GET) ) {

	$date_start = "";
	if( !empty($_GET["date_start"]) ) {
		$date_start = "AND sp.announced_date >= '".$_GET["date_start"]."'";
	}
	$date_end = "";
	if( !empty($_GET["date_end"]) ) {
		$date_end = "AND sp.announced_date <= '".$_GET["date_end"]."'";
	}

	$year = "";
	if( !empty($_GET["year"]) ) {
		$year = "AND YEAR(sp.announced_date) = '".$_GET["year"]."'";
	}

	$startup_name = "";
	if( !empty($_GET["startup_name"]) ) {
		$startup_name = "AND s.startup_name LIKE '%".$_GET["startup_name"]."%'";
	}

	$acceleration_type = "";
	if( !empty($_GET["acceleration_type"]) ) {
		$acceleration_type = "AND sp.acceleration_type =  '".$_GET["acceleration_type"]."'";
	}

	$call_name = "";
	if( !empty($_GET["call_name"]) ) {
		$call_name = "AND s.call_name = '".$_GET["call_name"]."'";
	}

	$raised_min = "";
	if( !empty($_GET["raised_min"]) ) {
		$raised_min = "AND sp.raised >= '".$_GET["raised_min"]."'";
	}

	$raised_max = "";
	if( !empty($_GET["raised_max"]) ) {
		$raised_max = "AND sp.raised <= '".$_GET["raised_max"]."'";
	}

	$staged = "";
	if( !empty($_GET["staged"]) ) {
		$staged = "AND sp.staged = '".$_GET["staged"]."'";
	}

	$investors = "";
	if( !empty($_GET["investor_ids"]) ) {
		$investors = "HAVING investor_names LIKE '%".$_GET["investor_ids"]."%'";
	}

	$query = "SELECT sp.*, s.call_name as call_name, s.startup_name as startup_name, GROUP_CONCAT(iv.id) AS investor_ids_list, GROUP_CONCAT(iv.name SEPARATOR ', ') AS investor_names
						FROM startup_portfolios as sp
						JOIN startups as s ON s.id = sp.startup_id
						LEFT JOIN investors AS iv ON FIND_IN_SET(iv.id, REPLACE(REPLACE(REPLACE(sp.investor_ids, '}{', ','), '{', ''), '}', '')) > 0
						WHERE 1=1 $date_start $date_end $startup_name $acceleration_type $call_name $raised_min $raised_max $staged $year
						GROUP BY sp.id
						$investors
						ORDER BY sp.created_on DESC";
			// export
	if( !empty($_GET["action"]) && $_GET["action"]=="export" ) {
		$query = "SELECT sp.*, s.call_name as call_name, s.startup_name as startup_name, GROUP_CONCAT(iv.id) AS investor_ids_list, GROUP_CONCAT(iv.name SEPARATOR ', ') AS investor_names, 
						COUNT(iv.id) AS investors_count,
						(SELECT COUNT(*) 
							FROM main_founders AS mf
							WHERE FIND_IN_SET(sp.startup_id, REPLACE(REPLACE(REPLACE(mf.startup_ids, '}{', ','), '{', ''), '}', '')) > 0 )
							+
							(SELECT COUNT(*) 
							FROM co_founders AS cf
							WHERE FIND_IN_SET(sp.startup_id, REPLACE(REPLACE(REPLACE(cf.startup_ids, '}{', ','), '{', ''), '}', '')) > 0 )
						 AS founders_count
						FROM startup_portfolios as sp
						JOIN startups as s ON s.id = sp.startup_id
						LEFT JOIN investors AS iv ON FIND_IN_SET(iv.id, REPLACE(REPLACE(REPLACE(sp.investor_ids, '}{', ','), '{', ''), '}', '')) > 0
						WHERE 1=1 $date_start $date_end $startup_name $acceleration_type $call_name $raised_min $raised_max $staged $year
						GROUP BY sp.id
						$investors
						ORDER BY sp.created_on DESC";
						
		$startup_portfolios_exports = DB::query($query);

		if ($_GET['file'] === 'startup_portfolios') {
			$file = "startup_portfolios.csv";
			include("_startup_portfolios.php");
		} elseif ($_GET['file'] === 'investor_data') {
			include("_investors_csv.php");
		}
		exit;
	}

	// var_dump($query); die();
	$startup_portfolios = DB::query($query);
} else {
	$query = "SELECT 
    sp.*, 
	s.call_name AS call_name,
    s.startup_name AS startup_name,
    GROUP_CONCAT(iv.id) AS investor_ids_list, 
    GROUP_CONCAT(iv.name SEPARATOR ', ') AS investor_names 
	FROM startup_portfolios AS sp
	JOIN startups as s ON s.id = sp.startup_id 
	LEFT JOIN investors AS iv ON FIND_IN_SET(iv.id, REPLACE(REPLACE(REPLACE(sp.investor_ids, '}{', ','), '{', ''), '}', '')) > 0
	GROUP BY sp.id
	ORDER BY sp.created_on DESC;";

	$startup_portfolios = DB::query($query);
}

$calls = DB::query("SELECT DISTINCT(call_name) FROM startups WHERE call_name<>'' ORDER BY call_name ASC");
$section = "startup_portfolios_list";
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
							<h6 class="m-0 font-weight-bold text-primary d-inline-block">Startup Portfolio</h6>
							<div>
								<a id="search" href="#search" class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm mr-1">
									<i class="fas fa-search fa-sm"></i>&nbsp;&nbsp;advanced search
								</a>
								<button onclick="exportCsv()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
									<i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;export csv
								</button>
							</div>
						</div>
						
						<!-- SEARCH FORM -->
						<form id="search_form" class="card-header py-4" method="get" style="min-width: 1120px; <?php if( empty($_GET) ) echo "display: none;";?>">
							<div class="form-inline">
								<label for="date_start" class="mr-3">Announced Date Range</label>
								<input type="date" class="form-control" name="date_start" id="date_start" value="<?php if( !empty($_GET["date_start"]) ) echo $_GET["date_start"];?>">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; 
								<input type="date" class="form-control" name="date_end" id="date_end"  value="<?php if( !empty($_GET["date_end"]) ) echo $_GET["date_end"];?>">

								<label for="date" class="mr-3 ml-3">Year</label>
								<select name="year" class="form-control d-inline">
									<option value="">Not set</option>
									<?php
									for( $year=date("Y"); $year>=1960; $year--) {
										$selected = $year == $_GET['year'] ? "selected" : "";
										echo "<option value=\"$year\" $selected>$year</option>";
									}
									?>
								</select>
							</div>
							<hr>
							<div class="form-inline">

								<label for="call_name" class="mr-3 ml-3">Program</label>
								<?php $selected_value=$_GET['acceleration_type'] ?? ''; $all_acceleration_string="All"; include("_include/startup_acceleration_options.php"); ?>
								
								<label for="call_name" class="mr-3 ml-3">Batch</label>
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

								<label class="m-3 ml-4" for="startup_name">Startup Name</label>
								<input type="text" name="startup_name" id="startup_name" class="form-control" value="<?php if( !empty($_GET["startup_name"]) ) echo $_GET["startup_name"];?>">
							</div>
					
							<hr>
							<div class="form-inline">
								<label for="raised" class="mr-3">Raised Range €</label>
								<input type="text" class="form-control" name="raised_min" id="raised_min" value="<?php if( !empty($_GET["raised_min"]) ) echo $_GET["raised_min"];?>">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; 
								<input type="text" class="form-control" name="raised_max" id="raised_max"  value="<?php if( !empty($_GET["raised_max"]) ) echo $_GET["raised_max"];?>">
							</div>

							<hr>
							<div class="form-inline">
								<label class="m-3" for="staged">Stage</label>
								<?php $selected_value = !empty($_GET["staged"]) ? $_GET["staged"]: "";  include("_include/startup_stagedoptions.php"); ?>

								<label class="m-3" for="investor_ids">Investors</label>
								<div style="position:relative;">
									<input type="text" name="investor_ids" id="investor_ids" class="form-control" value="<?php if( !empty($_GET["investor_ids"]) ) echo $_GET["investor_ids"];?>">
									<ul id="suggestions" class="dropdown-menu" style="display: none;"></ul>
								</div>
								

							</div>
							<hr>
							<div class="text-right">
								<a class="btn btn-sm btn-light" href="<?php echo BASEURL;?>backoffice/startup_portfolios/">Reset</a>
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
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-order='[[ 5, "desc" ]]'>
									<thead>
										<tr>
											<th data-orderable='false'>
												<input type="checkbox" name="set_all" id="set-all" value="1">
											</th>
											<th class="text-gray-500">Startup name</th>
											<th class="text-gray-500">Batch</th>
											<th class="text-gray-500">Raised</th>
											<th class="text-gray-500">Funding Stage</th>
											<th class="text-gray-500">Announced Date</th>
											<th class="text-gray-500">Year</th>
											<th class="text-gray-500" data-orderable="false">Investors</th>
											<th class="text-gray-500" data-orderable="false">Notes</th>
											<th class="text-gray-500" style="display: none;" data-orderable="false">Acceleration Type</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th class="text-gray-500">Startup name</th>
											<th class="text-gray-500">Batch</th>
											<th class="text-gray-500">Raised</th>
											<th class="text-gray-500">Funding Stage</th>
											<th class="text-gray-500">Announced Date</th>
											<th class="text-gray-500">Year</th>
											<th class="text-gray-500">Investors</th>
											<th class="text-gray-500">Notes</th>
											<th class="text-gray-500" style="display: none;" data-orderable="false">Acceleration Type</th>
										</tr>
									</tfoot>
									<tbody>
									<?php
									foreach($startup_portfolios as $startup_portfolio) {
										$announced_date = (isset($startup_portfolio['announced_date']) && $startup_portfolio['announced_date']) ? date("d M Y", strtotime($startup_portfolio["announced_date"])) : '';
										$year = (isset($startup_portfolio['announced_date']) && $startup_portfolio['announced_date']) ? date("Y", strtotime($startup_portfolio["announced_date"])) : '';

										if( $startup_portfolio["status"]=='0' ) $style = 'style="opacity:0.5"';
										else $style = '';
									?>
										<tr <?php echo $style;?>>
											<td>
												<input type="checkbox" name="status[]" value="<?php echo $startup_portfolio["id"];?>" data-status="<?php echo $startup_portfolio["status"];?>">
											</td>
											<td>
												<a href="<?php echo BASEURL;?>backoffice/startup_portfolio/<?php echo $startup_portfolio["id"];?>/">
													<?php echo htmlentities($startup_portfolio["startup_name"]);?>
												</a>
											</td>
											<td><?php echo htmlentities($startup_portfolio["call_name"]);?></td>
											<td style="text-wrap: nowrap;"><?php echo htmlentities("€ " . formatThousandComma($startup_portfolio["raised"]));?></td>
											<td><?php echo htmlentities($startup_portfolio["staged"]);?></td>
											<td data-order="<?php echo $startup_portfolio["announced_date"];?>"><?php  echo $announced_date;?></td>
											<td><?php echo $year;?></td>
											<td><?php echo htmlentities($startup_portfolio["investor_names"] ? $startup_portfolio["investor_names"] : '');?></td>
											<td style="min-width: 200px;"><?php echo htmlentities($startup_portfolio["notes"]);?></td>
											<td style="display: none;"><?php echo htmlentities($startup_portfolio["acceleration_type"]);?></td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<a id="new" href="<?php echo BASEURL;?>backoffice/startup_portfolio/new" class="d-none d-sm-inline-block mr-2 btn-link btn-sm" style="text-decoration: underline; text-decoration-thickness: 1.5px;">
						<i class="fas fa-plus-circle fa-lg mr-2"></i>Add Startup Portfolio
					</a>
					<div style="margin-top: 50px;"></div>
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
		var _TYPE = 'startup_portfolios';
	
		// Function to download a file
		function downloadFile(url, filename) {
			const link = document.createElement('a');
			link.href = url;
			link.download = filename;
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
		}

		function exportCsv() {
			downloadFile(_BASEURL + 'startup_portfolios.php?file=startup_portfolios&action=export', 'startup_portfolios.csv');

			setTimeout(() => {
				downloadFile(_BASEURL + 'startup_portfolios.php?file=investor_data&action=export', 'investor_data.csv');
			}, 2000);
		}
	</script>
<?php
include("_footer.php");
?>

</body>
</html>