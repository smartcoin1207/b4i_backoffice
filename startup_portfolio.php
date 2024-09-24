<?php

require_once "_conf.php";
require_once "_auth.php";

/** -------------- Add New Startup Portfolio. ------------------- */
if(isset($_POST["cmd"]) && $_POST["cmd"] == "new_startup") {
    $startup_id = isset($_POST["startup_id"]) ? $_POST["startup_id"] : "";
    $raised = isset($_POST["raised"]) ? $_POST["raised"] : 0;
    $cleanedRaised = str_replace('.', '', $raised);
    $raised = is_numeric($cleanedRaised) ? floatval($cleanedRaised) : 0;

    $staged = isset($_POST["staged"]) ? $_POST["staged"] : "";
    $announced_date = isset($_POST["announced_date"]) && $_POST['announced_date'] ? $_POST["announced_date"] : date('Y-m-d');
    $investors = isset($_POST["investor_ids"]) ? $_POST["investor_ids"] : [];
    $notes = isset($_POST["notes"]) ? $_POST["notes"] : "";
    $acceleration_type = isset($_POST['acceleration_type']) ? $_POST['acceleration_type'] : "";

    if(!is_numeric($raised)) {
        $raised = 0;
    }

    $investor_ids = '{' . implode('}{', $investors) . '}';

    if($startup_id) {
        DB::insert("startup_portfolios", array("startup_id" => $startup_id, "raised" => $raised, "acceleration_type" => $acceleration_type, "staged" => $staged, "announced_date" => $announced_date, "investor_ids" => $investor_ids, "notes" => $notes));
        $insert_id = DB::insertId();
        header("location: ".BASEURL."backoffice/startup_portfolio/$insert_id/");
        exit;
    }
}
/** -------------------------------------------------------- */

/** -------------- Delete Startup Portfolio. ------------------- */
if(isset($_POST["cmd"]) && $_POST["cmd"] == "delete_startup") {
    $id = $_POST["id"];

    if($id) {
        try {
            $startup_portfolio = DB::queryFirstRow('SELECT * FROM startup_portfolios WHERE id = %i', $id);
            if ($startup_portfolio) {
                DB::delete('startup_portfolios', 'id=%i', $id);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No entry found with the given ID.']);
            }
            
            exit;
        } catch (MeekroDBException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete the entry: ' . $e->getMessage()]);
            exit;
        }
    }
}
/** -------------------------------------------------------- */

/** --------------- New Investor --------------- */
if(isset($_POST["cmd"]) && $_POST["cmd"] == "new_investor") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    if($name) {
        $existingInvestor = DB::queryFirstRow("SELECT * FROM investors WHERE name = %s", $name);

        if($existingInvestor) {
            $response = array(
                'status' => 'error',
                'message' => 'Investor with this name already exist.'
            );
        } else {
            DB::insert("investors", array("name" => $name));
            $insert_id = DB::insertId();
            $response = array(
                'status' => 'success',
                'id' => $insert_id,
                'name' => $name
            );
        }

        echo json_encode($response);
    }

    exit;
}
/** ------------------------------------------- */


/** Thousand Three Comma Number */
function formatThousandComma($number) {
    $sanitizeNumber = sanitizeNumber($number);
    return number_format($sanitizeNumber, 0, '.', '.');
}

function sanitizeNumber($input) {
    // Remove non-numeric characters except for the decimal point
    return preg_replace('/[^\d.]/', '', $input);
}


$isNew = isset($_GET['new']) && $_GET['new'] == '1';

if(!$isNew) {
    if( isset($_GET["id"]) && $_GET["id"]!="") {
        $id = str_ireplace("/", "", $_GET["id"]);
    } else {
        die("No ID");
    }
}

if(!$isNew) {
    $startup_portfolio = DB::queryFirstRow("
        SELECT 
            sp.*,
            s.startup_name as startup_name,
            s.call_name as call_name,
            GROUP_CONCAT(iv.id) AS investor_ids_list, 
            GROUP_CONCAT(iv.name SEPARATOR ', ') AS investor_names
        FROM startup_portfolios sp
        JOIN startups s ON s.id = sp.startup_id
        LEFT JOIN investors AS iv ON FIND_IN_SET(iv.id, REPLACE(REPLACE(REPLACE(sp.investor_ids, '}{', ','), '{', ''), '}', '')) > 0
        WHERE sp.id = %i
        GROUP BY sp.id
    ", $id);

    if( empty($startup_portfolio) ) die("Startup Portfolio not found");

    if($startup_portfolio) {
        if($startup_portfolio['staged'] == 'SeriesA') {
            $startup_portfolio['staged'] = "Series A";
        } else if($startup_portfolio['staged'] == 'SeriesB') {
            $startup_portfolio['staged'] = "Series B";
        } else if($startup_portfolio['staged'] == 'SeriesC') {
            $startup_portfolio['staged'] = "Series C";
        }
    }
}

$investors = DB::query("SELECT * FROM investors ORDER BY name ASC");

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

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<a href="<?php echo BASEURL;?>backoffice/startup_portfolios/" class="btn btn-light btn-sm"><i class="fas fa-angle-left fa-sm"></i>&nbsp;&nbsp;back</a>
					</div>

					<!-- Content Row -->
					<div class="row">
						<div class="col-xl-10 offset-xl-1 mb-4">
							<form id="startup_portfolio_form" method="POST">
                                <input type="hidden" name="cmd" value="new_startup">
                                <div class="card shadow mb-4">
                                    
                                    <div class="card-header d-sm-flex align-items-center justify-content-between py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Startup Portfolio Data</h6>
                                        <?php
                                        if (!$isNew) {
                                            $status_label = 'Active';
                                            $style = 'style="opacity: 1"';
                                            if( $startup_portfolio["status"]=='0' ) {
                                                $status_label = 'Inactive';
                                                $style = 'style="opacity: .5"';
                                            }
                                        ?>
                                        <div class="custom-control custom-switch" style="float: right">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" <?php if( $startup_portfolio["status"]=='1' ) echo 'checked';?>>
                                            <label class="custom-control-label" for="status"><?php echo $status_label;?></label>
                                        </div>
                                        <?php } else {
                                            $style="";
                                        } ?>
                                    </div>
                                    
                                    <div class="card-body" id="card-body" <?php echo $style;?>>
                                        <table class="table table-bordered mt-2 table-form">
                                            <tbody>
                                                <tr>
                                                    <td class="text-right text-gray-500">Startup Name</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                            include("_include/startup_selectoptions.php");
                                                            
                                                        } else { 
                                                        ?>
                                                            <div class="show-data">
                                                                <a href="<?php echo BASEURL;?>backoffice/startup/<?php echo $startup_portfolio["startup_id"];?>/" class="text-value" <?php echo $style;?>><?php echo htmlentities($startup_portfolio["startup_name"]);?></a>
                                                                <span class="data-value invisible"><?php echo $startup_portfolio["startup_id"];?></span>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <?php include("_include/startup_selectoptions.php"); ?>
                                                            
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500">Batch</td>
                                                    <td>
                                                        <div class="show-data">
                                                            <?php
                                                                $batch = ""; 
                                                                if(isset($startup_portfolio["call_name"])) {
                                                                    $batch = preg_replace('/Batch\s+/', '', $startup_portfolio["call_name"]);
                                                                }
                                                            ?>
                                                            <span class="call_name data-value" id="batch_number"><?php echo htmlentities($batch);?></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Raised €</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                        ?>
                                                            <div class="show-data">
                                                                <input type="text" name="raised" id="raisedInput" class="form-control d-inline">
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 data-value"><?php echo htmlentities(formatThousandComma($startup_portfolio["raised"]));?></b>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <input type="text" name="raised" id="raisedInput" class="form-control d-inline" style="width: calc(100% - 110px);">
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php  } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Program</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                        ?>
                                                            <div class="show-data">
                                                               <?php $selected_value=""; $all_acceleration_string="Select Acceleration"; include("_include/startup_acceleration_options.php"); ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 data-value"><?php echo htmlentities($startup_portfolio["acceleration_type"] ? $startup_portfolio['acceleration_type'] : '');?></b>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <?php $selected_value=""; $all_acceleration_string="Select Acceleration"; include("_include/startup_acceleration_options.php"); ?>
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php  } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Funding Stage</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                        ?>
                                                            <div class="show-data">
                                                               <?php $selected_value="";  include("_include/startup_stagedoptions.php"); ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 data-value"><?php echo htmlentities($startup_portfolio["staged"]);?></b>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <?php $selected_value=""; include("_include/startup_stagedoptions.php"); ?>
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php  } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Announced Date</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                        ?>
                                                            <div class="show-data">
                                                                <input type="date" class="form-control" name="announced_date" id="announced_date">
                                                            </div>
                                                        <?php } else {
                                                            $announced_date_value = date("yy-m-d", strtotime($startup_portfolio["announced_date"]));
                                                            $announced_date = date("d M Y", strtotime($startup_portfolio["announced_date"]));
                                                        ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 text-value"><?php echo $announced_date;?></b>
                                                                <span class="data-value invisible"><?php echo $announced_date_value; ?></span>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <input type="date" class="form-control d-inline" name="announced_date" id="announced_date" value="<?php $announced_date;?>">
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php  } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500">Year</td>
                                                    <td>
                                                        <div class="show-data">
                                                            <?php
                                                                $year = "";
                                                                if(isset($startup_portfolio["announced_date"])) {
                                                                    $year = date("Y", strtotime($startup_portfolio["announced_date"]));
                                                                }
                                                            ?>
                                                            <span class="announced_date_year data-value"><?php echo htmlentities($year);?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    
                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Investors</td>
                                                    <td>
                                                        <?php 
                                                    
                                                        if($isNew) {
                                                        ?>
                                                            <div class="flex direction-row" style="display: flex;">
                                                                <select name="investor_ids[]" id="investor_ids" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="10" onchange="console.log(this.selectedOptions)">
                                                                    <?php foreach ($investors as $investor): ?>
                                                                        <option value="<?php echo $investor['id']; ?>"><?php echo $investor['name']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                
                                                            </div>
                                                        <?php } else {
                                                            $investor_ids = ($startup_portfolio['investor_ids_list']) ? $startup_portfolio['investor_ids_list'] : '';
                                                            $investor_ids_array = array_map('trim', explode(',', $investor_ids));
                                                            $investor_ids_string = implode(', ', $investor_ids_array);
                                                        ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 text-value"><?php if($startup_portfolio['investor_names']) echo htmlentities(($startup_portfolio['investor_names']));?></b>
                                                                <span class="data-value multi invisible"><?php echo htmlentities($investor_ids_string); ?></span>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <div class="mb-2" style="display: flex;">
                                                                    <select name="investor_ids[]" id="investor_ids" class="form-control" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="10" onchange="console.log(this.selectedOptions)">
                                                                        <?php foreach ($investors as $investor): ?>
                                                                            <option value="<?php echo $investor['id']; ?>"  ><?php echo $investor['name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    
                                                                </div>

                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-right text-gray-500" style="width: 30%">Notes</td>
                                                    <td>
                                                        <?php 
                                                        if($isNew) {
                                                        ?>
                                                            <div class="show-data">
                                                                <textarea type="text" name="notes" rows="4" class="form-control d-inline"></textarea>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="show-data">
                                                                <b class="text-gray-900 data-value"><?php echo htmlentities($startup_portfolio["notes"]);?></b>
                                                                <a class="btn btn-light btn-sm float-right edit"><i class="fas fa-pencil-alt"></i></a>
                                                            </div>
                                                            <div class="edit-data">
                                                                <textarea type="text" name="notes" rows="4" class="form-control d-inline"></textarea>
                                                                <a class="btn btn-success float-right save"><i class="fas fa-check"></i></a>
                                                                <a class="btn btn-light float-right mr-2 cancel"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        <?php  } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- .card-body -->
                                </div><!-- .card -->
                            </form>
                            <?php if($isNew) { ?>
                                <button id="new_startup_btn" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float: right;">
                                    <i class="fas fa-plus-circle fa-sm text-white-50"></i>&nbsp;&nbsp; Save Startup
                                </button>
                            <?php } else { ?>
                                <!-- <a id="delete_startup_btn" data-id="<?php echo $startup_portfolio['id']; ?>" class="d-none d-sm-inline-block   " style="float: right; margin-right: 10px;">
                                    <i class="fas fa-trash fa-sm text-white-50"></i>&nbsp;&nbsp; Delete this entry
                                </a> -->
                                <a id="delete_startup_btn" data-id="<?php echo $startup_portfolio['id']; ?>" class="btn d-sm-inline-block mr-2 btn-light btn-sm" style="float:right; text-decoration: underline; text-decoration-thickness: 1.5px; color: red">
                                    <i class="fas fa-trash fa-lg mr-2"></i>Delete
                                </a>
                            <?php } ?>

						</div><!-- .col -->
					</div>
					<!-- End of Content Row -->
					<!-- Page End -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<a href="<?php echo BASEURL;?>backoffice/startup_portfolios/" class="btn btn-light btn-sm"><i class="fas fa-angle-left fa-sm"></i>&nbsp;&nbsp;back</a>
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
                <input type="hidden" name="id" value="<?php echo $startup_portfolio["id"];?>">
                <input type="hidden" name="table" value="startup_portfolios">
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
        var _ID = '<?php if(isset($startup_portfolio["id"])) echo $startup_portfolio["id"]; ?>';
        var _TYPE = 'startup_portfolios';
	</script>
    
<?php
include("_footer.php");
?>
<script src="<?php echo BASEURL;?>backoffice/js/startup_portfolio.js"></script>
</body>
</html>