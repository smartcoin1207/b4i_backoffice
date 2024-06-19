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

if( !empty($_POST["ids"]) && !empty($_POST["type"]) ) {
	
	$list_ids = array();
	foreach( $_POST["ids"] as $item ) {
		$list_ids[] = $item["value"];
	}
	
	$table = $_POST["type"];
	
	DB::query("UPDATE $table SET status='".$_POST["status"]."' WHERE id IN (".implode(',', $list_ids).")");
	
	echo 'OK';
	
} else {
	
	die("Missing params");
	
}

?>