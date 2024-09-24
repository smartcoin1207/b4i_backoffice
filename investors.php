<?php

require_once "_conf.php";
require_once "_auth.php";

if(isset($_POST["cmd"]) && $_POST["cmd"] == "delete_investor") {
    $id = isset($_POST["id"]) ? $_POST["id"] : "";

    DB::delete('investors', 'id=%i', $id);
    echo "success"; exit;
}

if(isset($_POST["cmd"]) && $_POST["cmd"] == "update_investor") {
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $name = isset($_POST["investor_name"]) ? $_POST["investor_name"] : "";

    DB::update('investors', array(
		"name" => $name,
	), "id=%i", $id);
}

$investors_query = "SELECT i.id, i.name, COUNT(sp.id) as investors_count
    FROM investors i
    JOIN startup_portfolios sp
    ON sp.investor_ids LIKE CONCAT('%{', i.id, '}%')
    GROUP BY i.id, i.name
    HAVING investors_count > 0
    ORDER BY investors_count DESC;";

$investors = DB::query($investors_query);

$section = "investors";
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
							<h6 class="m-0 font-weight-bold text-primary d-inline-block">Investors</h6>
						</div>
						
						<div class="card-body">
							<?php if( isset($_GET["action"]) ) { ?>
							<div class="alert alert-success">
								<?php
								if( $_GET["action"]=="delete" ) echo "Utente eliminato.";
								?>
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
							</div>
							<?php } ?>
							<form class="table-responsive" id="investors-list">
								<table class="table table-bordered" id="investors_datatable" width="100%" cellspacing="0" data-order='[[ 2, "desc" ]]'>
									<thead>
										<tr>
											<th data-orderable="false">
												<input type="checkbox" name="set_all" id="set-all" value="1">
											</th>
											<th class="text-gray-500">Investors name</th>
											<th class="text-gray-500">Investments</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th data-orderable="false"></th>
											<th class="text-gray-500">Investors name</th>
											<th class="text-gray-500">Investments</th>
									</tfoot>
									<tbody>
									<?php
									foreach($investors as $investor) {
									?>
										<tr>
											<td>
												<input type="checkbox" name="investor_ids[]" value="<?php echo $investor["id"];?>">
											</td>
											<td>
                                                <?php echo htmlentities($investor["name"]);?>
                                                <div class="float-right">
                                                    <a class="btn btn-light btn-sm" onclick="showEditModal(<?php echo $investor['id']; ?>, '<?php echo $investor['name']; ?>')">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-light btn-sm" onclick="deleteInvestor(<?php echo $investor['id']; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
											</td>
											<td><?php echo htmlentities($investor["investors_count"]);?></td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<div style="margin-top: 50px;"></div>
				</div>
				<!-- /.container-fluid -->
				
			</div>
			
			<!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->
	
	<!-- Modal: Edit Investor -->
	<div class="modal fade" id="edit-investor-modal">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
            <form id="form-dismiss-device" method="post" action="<?= BASEURL . 'backoffice/investors.php' ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Investor</h5>
                </div>
                <div class="modal-body">
                    <p>Do you confirm to change the investor?</p>
                        <input type="hidden" name="id" value="" id="investor_id">
                        <input type="hidden" name="cmd" value="update_investor">
                        <input type="text" class="form-control" name="investor_name" id="investor_name" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-confirm">Change</button>
                </div>
          </form>

	    </div>
	  </div>
	</div>
<?php
include("_footer.php");
?>

<script>
    var _BASEURL = '<?php echo BASEURL;?>backoffice/';

    function showEditModal(id, name) {
        $('#edit-investor-modal').find('#investor_id').val(id);  // Use .val() as a method
        $('#edit-investor-modal').find('#investor_name').val(name);

        $('#edit-investor-modal').modal({
            backdrop: 'static',
            show: true
        });
    }

    function deleteInvestor(id) {
        if (confirm('Are you sure you want to delete this entry?')) {
            // User confirmed, proceed with AJAX request
            $.ajax({
                url:  _BASEURL+'investors/', // Change this to your server-side script
                type: 'POST',
                data: { 
                    cmd: 'delete_investor',
                    id: id 
                },
                success: function(response) {
                    // window.location.href = _BASEURL +  'startup_portfolios';
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting the entry.');
                }
            });
        } else {
            // User canceled, do nothing
            alert('Deletion canceled.');
        }
    }
</script>

</body>
</html>