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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../_app/lib/PHPMailer/src/PHPMailer.php';
require_once '../_app/lib/PHPMailer/src/SMTP.php';
require_once '../_app/lib/PHPMailer/src/Exception.php';


if( !empty($_POST["id"]) && !empty($_POST["type"]) && !empty($_POST["grant"]) ) {
	
	$table = $_POST["type"];
	if( $table!="startups" ) die("$table - Wrong type param");
	
	DB::update($table, array(
		"grant_application" => $_POST["grant"],
		"granted_on"        => date("Y-m-d H:i")
	), "id=%i", $_POST["id"]);
	
	echo 'OK';
	
	
	// SEND MAIL
	$startup = DB::queryFirstRow("SELECT * FROM startups WHERE id=%i", $_POST["id"]);
	$mail             = new PHPMailer();
	$mail->CharSet    = "UTF-8";
	$mail->SMTPDebug  = 0; // 1 = errors and messages | 2 = messages only
	$mail->IsSMTP();
	$mail->SMTPAuth   = true; 
	$mail->SMTPSecure = "tls";
	$mail->SMTPAutoTLS = false;
	$mail->Host       = MAIL_HOST;
	$mail->Port       = MAIL_PORT;
	$mail->Username   = MAIL_USER;
	$mail->Password   = MAIL_PWD;
	$mail->SetFrom(MAIL_FROM, MAIL_FROM_LABEL);
	if( !DEV ) {
		$mail->AddAddress("infob4i@unibocconi.it", "B4i");
		$mail->AddAddress("ferruccio.martinelli@unibocconi.it", "Ferruccio Martinelli");
		$mail->AddAddress("sasha.komarevych@unibocconi.it", "Sasha Komarevych");
		//$mail->AddBCC("aureliano@man-super.com", "Aureliano");
	} else {
		$mail->AddAddress("karlo@capekode.com", "K.");
	}
	$mail->ClearReplyTos();
	$mail->addReplyTo(MAIL_ADMIN, MAIL_FROM_LABEL);
	$mail->Subject = "Grant application notice";
	$html  = "Startup: <b>".htmlentities($startup["startup_name"])."</b><br><br>";
	$html .= "Grant application: <b>".$_POST["grant"]."</b><br><br>";
	$mail->MsgHTML($html);
	$mail->Send();
	
} else {
	
	die("Missing params");
	
}

?>