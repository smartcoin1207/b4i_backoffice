<?php
require_once "_conf.php";

session_start();

if( isset($_SESSION["adminId"]) ) {

	$adminID        = $_SESSION["adminId"];
	$adminUsername  = $_SESSION["adminUsername"];
	$adminFirstName = $_SESSION["adminFirstName"];
	$adminLastName  = $_SESSION["adminLastName"];
	$adminEmail     = $_SESSION["adminEmail"];

	session_write_close();

} else {

	header($_SERVER["SERVER_PROTOCOL"]." 401 Unauthorized", true, 401);
	session_write_close();
	exit();

}

if( !empty($_POST["id"]) && !empty($_POST["type"]) && !empty($_POST["field"]) && isset($_POST["data"]) ) {
	
	$table = $_POST["type"];
	if( $table!="startups" && $table!="main_founders" && $table!="co_founders" ) die("$table - Wrong type param");
	
	DB::update($table, array(
		$_POST["field"] => $_POST["data"]
	), "id=%i", $_POST["id"]);
	
	echo 'OK';
	
} else {
	
	die("Missing params");
	
}

?>