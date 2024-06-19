<?php
$f = fopen('php://memory', 'w'); 

$data = array();

array_push($data, array(
	"ID",
	"Startup name",
	"Startup country",
	"Startup city",
	"Incorporated",
	"Company name",
	"Tax code",
	"Country",
	"E-mail",
	"Address",
	"Not incorporated declaration",
	"Friends and family",
	"Searching the web",
	"Social media",
	"News sites",
	"Events",
	"Other",
	"Other (specify)",
	"Application request",
	"Digital tech",
	"Made in Italy",
	"Sustainability",
	"Grant application",
	"Granted on",
	"Metabeta Code",
	"Call",
	"Created on",
	"Updated on"
));

foreach( $startups as $startup ) {
	$startup_country = getCountry($startup["startup_country"]);
	if( $startup_country=="Not set" ) $startup_country = "";
	$startup_city = getCountry($startup["startup_city"]);
	if( $startup_city=="Not set" ) $startup_city = "";
	
	$country = getCountry($startup["company_country"]);
	if( $country=="Not set" ) $country = getCountry($startup["nationality"]);

	$how_friend = (strpos($startup["how_do_you_know"], "Friends and family") !== false) ? 1 : 0;
	$how_web    = (strpos($startup["how_do_you_know"], "Searching the web")  !== false) ? 1 : 0;
	$how_social = (strpos($startup["how_do_you_know"], "Social media")       !== false) ? 1 : 0;
	$how_sites  = (strpos($startup["how_do_you_know"], "News sites")         !== false) ? 1 : 0;
	$how_events = (strpos($startup["how_do_you_know"], "Events")             !== false) ? 1 : 0;
	$how_other  = (strpos($startup["how_do_you_know"], "Other")              !== false) ? 1 : 0;

	$track_digital = (strpos($startup["acceleration_track"], "Digital tech")   !== false) ? 1 : 0;
	$track_italy   = (strpos($startup["acceleration_track"], "Made in Italy")  !== false) ? 1 : 0;
	$track_sustain = (strpos($startup["acceleration_track"], "Sustainability") !== false) ? 1 : 0;
	if( $startup["sustainability"]=="Yes" ) $track_sustain = 1;


	$date_on = date("Y-m-d", strtotime($startup["created_on"]));
	$call_name = $startup["call_name"];
	if( $date_on>="2019-11-01" && $date_on<="2020-01-31" ) $call_name = "Batch 1";
	if( $date_on>="2020-06-01" && $date_on<="2020-07-31" ) $call_name = "Batch 2";
	if( $date_on>="2020-11-01" && $date_on<="2021-01-31" ) $call_name = "Batch 3";
	if( $date_on>="2021-05-01" && $date_on<="2021-07-31" ) $call_name = "Batch 4";
	if( $date_on>="2022-05-01" && $date_on<="2022-07-31" ) $call_name = "Batch 6";
	
	array_push($data, array(
		$startup["id"],
		$startup["startup_name"],
		$startup_country,
		$startup_city,
		$startup["incorporated"],
		$startup["company_name"],
		$startup["company_tax_code"],
		$country,
		$startup["company_email"],
		$startup["company_address"],
		$startup["not_incoprporated_declaration"],
		$how_friend,
		$how_web,
		$how_social,
		$how_sites,
		$how_events,
		$how_other,
		$startup["how_do_you_know_other"],
		$startup["application_request"],
		$track_digital,
		$track_italy,
		$track_sustain,
		$startup["grant_application"],
		$startup["granted_on"],
		$startup["metabeta_code"],
		$call_name,
		$startup["created_on"], //date("j m Y", strtotime($startup["created_on"]))
		$startup["updated_on"]
		/*
		(date("Y") - $startup["birthdate_year"]),
		*/
	));
}

foreach( $data as $line ) {
	fputcsv($f, $line, ";");
}

fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="startup_list.csv";');
fpassthru($f);

exit();
?>