<?php

session_start();

if( isset($_SESSION["adminId"]) ) {

	$adminID        = $_SESSION["adminId"];
	$adminUsername  = $_SESSION["adminUsername"];
	$adminFirstName = $_SESSION["adminFirstName"];
	$adminLastName  = $_SESSION["adminLastName"];
	$adminEmail     = $_SESSION["adminEmail"];

	session_write_close();

} else {

	header("Location: ".BASEURL."backoffice/?redirect=".urlencode($actual_link));
	session_write_close();
	exit();

}

?>