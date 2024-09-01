<?php
$f = fopen('php://memory', 'w'); 

$data = array();

array_push($data, array(
	"Startup Portfolio ID",
	"Startup Id",
	"Startup Name",
	"Batch",
	"Type",
	"Raised",
	"Funding Stage",
	"Announced Date",
	"Year",
	"Investors",
	"Notes",
	"Created on",
));

foreach( $startup_portfolios_exports as $startup_portfolio ) {
	array_push($data, array(
		$startup_portfolio['id'],
		$startup_portfolio['startup_id'],
		$startup_portfolio['startup_name'],
		$startup_portfolio['call_name'],
		$startup_portfolio['acceleration_type'],
		$startup_portfolio['raised'],
		$startup_portfolio['staged'],
		$startup_portfolio['announced_date'],
		date("Y", strtotime($startup_portfolio["announced_date"])),
		$startup_portfolio['investor_names'],
		$startup_portfolio['notes'],
		$startup_portfolio['created_on']
	));
}

foreach( $data as $line ) {
	fputcsv($f, $line, ";");
}

fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$file.'";');
fpassthru($f);

exit();
?>