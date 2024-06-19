<?php
$f = fopen('php://memory', 'w'); 

$data = array();

array_push($data, array(
	"Startup ID",
	"Other Starups ID",
	"How many startups",
	"Pre-acceleration program",
	"Acceleration program",
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
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$file.'";');
fpassthru($f);

exit();
?>