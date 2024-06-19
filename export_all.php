<?php

require_once "_conf.php";

if( isset($_GET["token"]) && isset($_GET["action"]) ) {
	if( $_GET["token"]!="Uuo8laKLP3qejoaXSsnxma1293910i4ka2313ad" ) die("Wrong token");
} else {
	require_once "_auth.php";
}

//$query = "SELECT * FROM main_founders WHERE status='1' UNION ALL SELECT * FROM co_founders WHERE status='1' ORDER BY created_on DESC";
$query = "SELECT startups.grant_application as grant_application, main_founders.*
						FROM main_founders
						JOIN startups ON FIND_IN_SET(startups.id, REPLACE(REPLACE(REPLACE(main_founders.startup_ids, '}{', ','), '{', ''), '}', '')  ) > 0
						WHERE main_founders.status='1' 
						GROUP BY main_founders.id
						ORDER BY main_founders.created_on DESC";
$main_founders = DB::query($query);

$query = "SELECT startups.grant_application as grant_application, co_founders.*
						FROM co_founders
						JOIN startups ON FIND_IN_SET(startups.id, REPLACE(REPLACE(REPLACE(co_founders.startup_ids, '}{', ','), '{', ''), '}', '')  ) > 0
						WHERE co_founders.status='1' 
						GROUP BY co_founders.id
						ORDER BY co_founders.created_on DESC";
$co_founders = DB::query($query);

$founders = array_merge($main_founders, $co_founders);
$file = "main_founders.csv"; // all_founders.csv

$f = fopen('php://memory', 'w'); 

$data = array();

array_push($data, array(
	"Startup ID",
	"Other Starups ID",
	"How many startups",
	"Pre-acceleration program",
	"Acceleration program",
	"Founder",
	"Name",
	"Surname",
	"Nationality",
	"Age",
	"Fiscal code",
	"Birth date",
	"Place of birth",
	"E-mail",
	"Phone",
	"City",
	"Zip code",
	"Address",
	"Region",
	"Gender",
	"University",
	"Degree",
	"Alumnus",
	"Alumnus year",
	"IIT Researcher",
	"Job title",
	"Current Company",
	"Developer",
	"Privacy",
	"Permissions",
	"Metabeta Code",
	"Call",
	"Created on",
	"Updated on"
));

foreach( $founders as $founder ) {
	$list_ids = $founder["startup_ids"];
	$list_ids = str_ireplace("}{", ",", $list_ids);
	$list_ids = str_ireplace("}",  "", $list_ids);
	$list_ids = str_ireplace("{",  "", $list_ids);
	$list_ids = explode(",", $list_ids);
	$count = count($list_ids);
	$last_id = array_pop($list_ids);
	$age = "";
	if( !empty($founder["fiscal_code"]) ) {
		$year_birth = substr($founder["fiscal_code"], 6, 2);
		if( is_numeric($year_birth) ) {
			if( $year_birth<date("y") ) $year_birth = 2000 + $year_birth;
			else $year_birth = 1900 + $year_birth;
			$age = date("Y") - $year_birth;
		}
	}
	if( empty($age) && !empty($founder["birth_date"]) ) {
		$age = date("Y") - date("Y", strtotime($founder["birth_date"]));
	}
	$region = "-";
	if( !empty($founder["zip_code"]) ) {
		
		$zip = (int)$founder["zip_code"];
		
		if( $zip>=10 && $zip<=2011 ) {
			$region = "Lazio";
		}
		if( $zip>=3010 && $zip<=3100 ) {
			$region = "Lazio";
		}
		if( $zip>=4010 && $zip<=4100 ) {
			$region = "Lazio";
		}
		
		if( $zip>=5010 && $zip<=6135 ) {
			$region = "Umbria";
		}
		
		if( $zip>=7010 && $zip<=9170 ) {
			$region = "Sardegna";
		}
		
		if( $zip>=10010 && $zip<=15100 ) {
			$region = "Piemonte";
		}
		
			if( $zip>=11010 && $zip<=11100 ) {
				$region = "Valle d'Aosta";
			}
		
		if( $zip>=16010 && $zip<=19137 ) {
			$region = "Liguria";
		}
		
		if( $zip>=20010 && $zip<=27100 ) {
			$region = "Lombardia";
		}
		
		if( $zip>=30010 && $zip<=37142 ) {
			$region = "Veneto";
		}
		
			if( $zip>=33010 && $zip<=34170 ) {
				$region = "Friuli Venezia Giulia";
			}
		
		if( $zip>=38010 && $zip<=39100 ) {
			$region = "Trentino-Alto Adige";
		}
		
		if( $zip>=40010 && $zip<=48100 ) {
			$region = "Emilia Romagna";
		}
		
		if( $zip>=50010 && $zip<=59100 ) {
			$region = "Toscana";
		}
		
		if( $zip>=60010 && $zip<=63900 ) {
			$region = "Marche";
		}
		
		if( $zip>=64010 && $zip<=67100 ) {
			$region = "Abruzzo";
		}
		
		if( $zip>=70010 && $zip<=76125 ) {
			$region = "Puglia";
		}
		
		if( $zip>=80010 && $zip<=84135 ) {
			$region = "Campania";
		}
		
		if( $zip>=85010 && $zip<=85100 ) {
			$region = "Basilicata";
		}
		
		if( $zip>=86010 && $zip<=86170 ) {
			$region = "Molise";
		}
		
		if( $zip>=87010 && $zip<=89900 ) {
			$region = "Calabria";
		}
		
		if( $zip>=90010 && $zip<=98168 ) {
			$region = "Sicilia";
		}
		
		// Small ranges
		if( $zip>=28010 && $zip<=28925 ) {
			$region = "Piemonte";
		}
		if( $zip>=29010 && $zip<=29100 ) {
			$region = "Emilia Romagna";
		}
		if( $zip>=38059 && $zip<=38060 ) {
			$region = "Piemonte";
		}
		if( $zip>=45010 && $zip<=45100 ) {
			$region = "Veneto";
		}
		if( $zip>=61010 && $zip<=61019 ) {
			$region = "Emilia Romagna";
		}
		if( $zip>=75010 && $zip<=75100 ) {
			$region = "Basilicata";
		}
		
		// Singles zip
		if( $zip==8020 ) {
			$region = "Sicilia";
		}
		if( $zip==12071 ) {
			$region = "Liguria";
		}
		if( $zip==16192 ) {
			$region = "Lombardia";
		}
		if( $zip==38083 ) {
			$region = "Lombardia";
		}
		if( $zip==73030 ) {
			$region = "Lombardia";
		}
		if( $zip==95028 ) {
			$region = "Lombardia";
		}
		if( $zip==95047 ) {
			$region = "Basilicata";
		}
	}
	
	$date_on = date("Y-m-d", strtotime($founder["created_on"]));
	$call_name = $founder["call_name"];
	if( $date_on>="2019-11-01" && $date_on<="2020-01-31" ) $call_name = "Batch 1";
	if( $date_on>="2020-06-01" && $date_on<="2020-07-31" ) $call_name = "Batch 2";
	if( $date_on>="2020-11-01" && $date_on<="2021-01-31" ) $call_name = "Batch 3";
	if( $date_on>="2021-05-01" && $date_on<="2021-07-31" ) $call_name = "Batch 4";
	if( $date_on>="2022-05-01" && $date_on<="2022-07-31" ) $call_name = "Batch 6";
	
	$grant_pre_acc = $founder["grant_application"]=="Pre-acceleration program" ? "Yes" : "No";
	$grant_acc = $founder["grant_application"]=="Acceleration program" ? "Yes" : "No";
	
	array_push($data, array(
		$last_id,
		implode(", ", $list_ids),
		$count,
		$grant_pre_acc,
		$grant_acc,
		$founder["type"],
		$founder["name"],
		$founder["surname"],
		getCountry($founder["nationality"]),
		$age,
		$founder["fiscal_code"],
		$founder["birth_date"],
		$founder["place_of_birth"],
		$founder["email"],
		$founder["phone"],
		$founder["city"],
		'="'.$founder["zip_code"].'"',
		$founder["address"],
		$region,
		$founder["gender"],
		$founder["university"],
		$founder["degree"],
		$founder["alumnus"],
		$founder["alumnus_year"],
		$founder["iit_researcher"],
		$founder["job_title"],
		$founder["current_company"],
		$founder["developer"],
		$founder["privacy"],
		$founder["permissions"],
		$founder["metabeta_code"],
		$call_name,
		$founder["created_on"], //date("j m Y", strtotime($founder["created_on"]))
		$founder["updated_on"]
		/*
		(date("Y") - $founder["birthdate_year"]),
		*/
	));
}

foreach( $data as $line ) {
	fputcsv($f, $line, ";");
}
fseek($f, 0);

if( isset($_GET["action"]) && $_GET["action"]=="download" ) {
	
	$save = file_put_contents("export/$file", $f, LOCK_EX);
	if( !$save ) {
		echo "File $file not saved!<br>";
	}else{
		echo "File $file saved!<br>";
	}
	
	// ADD TO QUEUE STARTUP LIST
	$f = fopen('php://memory', 'w'); 
	$file = "startup_list.csv";
	$query = "SELECT startups.*, main_founders.startup_ids, main_founders.nationality FROM startups LEFT JOIN main_founders ON main_founders.startup_ids LIKE CONCAT('%{',startups.id,'}%') WHERE startups.status='1' GROUP BY startups.id ORDER BY startups.created_on DESC ";
	$startups = DB::query($query);
	$data = array();
	array_push($data, array(
		"ID",
		"Startup name",
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
		"Call",
		"Created on",
		"Updated on"
	));
	foreach( $startups as $startup ) {
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
	$save = file_put_contents("export/$file", $f, LOCK_EX);
	if( !$save ) {
		echo "File $file not saved!";
	}else{
		echo "File $file saved!";
	}
	
} else {

	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename="'.$file.'";');
	fpassthru($f);
	exit();
	
}

?>