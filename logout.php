<?php

require_once "_conf.php";

session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();

session_write_close();

header("Location: ".BASEURL."backoffice/");

?>