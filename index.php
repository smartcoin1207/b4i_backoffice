<?php
	
require_once "_conf.php";

if( !empty($_POST["username"]) && !empty($_POST["password"]) ) {
	$admin = DB::queryFirstRow("SELECT * FROM admins WHERE username=%s AND pwd=%s", $_POST["username"], $_POST["password"]);
	$counter = DB::count();
	if( $counter>0 ) {
		session_start();
		$_SESSION["adminId"]        = $admin["id"];
		$_SESSION["adminUsername"]  = $admin["username"];
		$_SESSION["adminFirstName"] = $admin["first_name"];
		$_SESSION["adminLastName"]  = $admin["last_name"];
		$_SESSION["adminEmail"]     = $admin["email"];
		DB::update("admins", array(
			"last_access" => date("Y-m-d H:i:s")
		), "id=%i", $admin["id"]);
		session_write_close();
		if( !empty($_GET["redirect"]) ) {
			header("location: ".$_GET["redirect"]);
		} else {
			header("location: ".BASEURL."backoffice/dashboard/");
		}
		exit();
	} else {
		$error = "Authentication failed.";
	}
}

include("_head.php");

?>

<body class="bg-gradient-primary">
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<div class="row align-items-center">
							
							<div class="col-lg-6 d-none d-lg-block bg-login-image">
								<img src="<?php echo BASEURL;?>backoffice/images/splashscreen.png">
							</div>
							
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Back Office access</h1>
									</div>
									<form class="user" method="post" action="<?php if(isset($_GET["redirect"])) echo "?redirect=".urlencode($_GET["redirect"]);?>">
										<?php
										if( isset($error) ) echo "<div class=\"alert alert-danger text-center\">$error</div>";
										?>
										<div class="form-group">
											<input type="text" name="username" class="form-control form-control-user" autocomplete="false" placeholder="Username">
										</div>
										<div class="form-group">
											<input type="password" name="password" class="form-control form-control-user" autocomplete="new-password" placeholder="Password">
										</div>
										<input type="submit" class="btn btn-primary btn-user btn-block" value="Log in">
									</form>
								</div>
							</div>
							
						</div>
					</div> <!-- .card-body -->
				</div> <!-- .card -->

			</div> <!-- .col-xl-10 -->
		</div> <!-- .row -->
	</div> <!-- .container -->

	<script src="js/jquery.min.js"></script>

</body>
</html>