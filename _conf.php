<?php


/* DEV & DEBUG
----------------- */

define('DEBUG', true);
define('DEV', false);

if( DEBUG ) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}


/* SETTINGS
----------------- */

ini_set('session.gc_maxlifetime', 60*60*24);


/* CONSTANTS
----------------- */

if( DEV ) {
	define('BASEURL', "http://127.0.0.1/B4I/www/");
} else {
	define('BASEURL', "http://localhost/b4i/");
}


/* MAIL SETTINGS
----------------- */
define('MAIL_HOST', "smtp.office365.com");
define('MAIL_PORT', 587);
define('MAIL_USER', "b4iprograms@unibocconi.it");
define('MAIL_PWD', 'zU$A8kZ3MaN-Y7Zq');
define('MAIL_FROM', "b4iprograms@unibocconi.it");
define('MAIL_FROM_LABEL', "B4i - Bocconi for Innovation");
define('MAIL_ADMIN', "infob4i@unibocconi.it");


/* MYSQL DB
----------------- */

require_once "../_app/lib/meekrodb.2.3.class.php";
DB::$encoding = "utf8mb4";
DB::$error_handler = false;
DB::$throw_exception_on_error = true;

if( DEV ) {
	DB::$user = "root";
	DB::$password = "root";
	DB::$dbName = "b4i";
} else {
	DB::$user = "root";
	DB::$password = "";
	DB::$dbName = "admin_b4i";
}

if( DEBUG ) {
	DB::$error_handler = 'my_error_handler'; // runs on mysql query errors
	DB::$nonsql_error_handler = 'my_error_handler'; // runs on library errors (bad syntax, etc)
	function my_error_handler($params) {
		echo "Error: " . $params['error'] . "<br>\n";
		echo "Query: " . $params['query'] . "<br>\n";
		die; // don't want to keep going if a query broke
	}
}


/* UTILS
----------------- */

// OLD $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

function getCountry($iso) {
	$country = $iso;
	switch ($iso) {
		case "IT": $country = "Italy"; break;
		case "AF": $country = "Afghanistan"; break;
		case "AX": $country = "Åland Islands"; break;
		case "AL": $country = "Albania"; break;
		case "DZ": $country = "Algeria"; break;
		case "AS": $country = "American Samoa"; break;
		case "AD": $country = "Andorra"; break;
		case "AO": $country = "Angola"; break;
		case "AI": $country = "Anguilla"; break;
		case "AQ": $country = "Antarctica"; break;
		case "AG": $country = "Antigua & Barbuda"; break;
		case "AR": $country = "Argentina"; break;
		case "AM": $country = "Armenia"; break;
		case "AW": $country = "Aruba"; break;
		case "AU": $country = "Australia"; break;
		case "AT": $country = "Austria"; break;
		case "AZ": $country = "Azerbaijan"; break;
		case "BS": $country = "Bahamas"; break;
		case "BH": $country = "Bahrain"; break;
		case "BD": $country = "Bangladesh"; break;
		case "BB": $country = "Barbados"; break;
		case "BY": $country = "Belarus"; break;
		case "BE": $country = "Belgium"; break;
		case "BZ": $country = "Belize"; break;
		case "BJ": $country = "Benin"; break;
		case "BM": $country = "Bermuda"; break;
		case "BT": $country = "Bhutan"; break;
		case "BO": $country = "Bolivia"; break;
		case "BA": $country = "Bosnia & Herzegovina"; break;
		case "BW": $country = "Botswana"; break;
		case "BV": $country = "Bouvet Island"; break;
		case "BR": $country = "Brazil"; break;
		case "IO": $country = "British Indian Ocean Territory"; break;
		case "VG": $country = "British Virgin Islands"; break;
		case "BN": $country = "Brunei"; break;
		case "BG": $country = "Bulgaria"; break;
		case "BF": $country = "Burkina Faso"; break;
		case "BI": $country = "Burundi"; break;
		case "KH": $country = "Cambodia"; break;
		case "CM": $country = "Cameroon"; break;
		case "CA": $country = "Canada"; break;
		case "CV": $country = "Cape Verde"; break;
		case "BQ": $country = "Caribbean Netherlands"; break;
		case "KY": $country = "Cayman Islands"; break;
		case "CF": $country = "Central African Republic"; break;
		case "TD": $country = "Chad"; break;
		case "CL": $country = "Chile"; break;
		case "CN": $country = "China"; break;
		case "CX": $country = "Christmas Island"; break;
		case "CC": $country = "Cocos (Keeling) Islands"; break;
		case "CO": $country = "Colombia"; break;
		case "KM": $country = "Comoros"; break;
		case "CG": $country = "Congo - Brazzaville"; break;
		case "CD": $country = "Congo - Kinshasa"; break;
		case "CK": $country = "Cook Islands"; break;
		case "CR": $country = "Costa Rica"; break;
		case "CI": $country = "Côte d’Ivoire"; break;
		case "HR": $country = "Croatia"; break;
		case "CU": $country = "Cuba"; break;
		case "CW": $country = "Curaçao"; break;
		case "CY": $country = "Cyprus"; break;
		case "CZ": $country = "Czechia"; break;
		case "DK": $country = "Denmark"; break;
		case "DJ": $country = "Djibouti"; break;
		case "DM": $country = "Dominica"; break;
		case "DO": $country = "Dominican Republic"; break;
		case "EC": $country = "Ecuador"; break;
		case "EG": $country = "Egypt"; break;
		case "SV": $country = "El Salvador"; break;
		case "GQ": $country = "Equatorial Guinea"; break;
		case "ER": $country = "Eritrea"; break;
		case "EE": $country = "Estonia"; break;
		case "SZ": $country = "Eswatini"; break;
		case "ET": $country = "Ethiopia"; break;
		case "FK": $country = "Falkland Islands"; break;
		case "FO": $country = "Faroe Islands"; break;
		case "FJ": $country = "Fiji"; break;
		case "FI": $country = "Finland"; break;
		case "FR": $country = "France"; break;
		case "GF": $country = "French Guiana"; break;
		case "PF": $country = "French Polynesia"; break;
		case "TF": $country = "French Southern Territories"; break;
		case "GA": $country = "Gabon"; break;
		case "GM": $country = "Gambia"; break;
		case "GE": $country = "Georgia"; break;
		case "DE": $country = "Germany"; break;
		case "GH": $country = "Ghana"; break;
		case "GI": $country = "Gibraltar"; break;
		case "GR": $country = "Greece"; break;
		case "GL": $country = "Greenland"; break;
		case "GD": $country = "Grenada"; break;
		case "GP": $country = "Guadeloupe"; break;
		case "GU": $country = "Guam"; break;
		case "GT": $country = "Guatemala"; break;
		case "GG": $country = "Guernsey"; break;
		case "GN": $country = "Guinea"; break;
		case "GW": $country = "Guinea-Bissau"; break;
		case "GY": $country = "Guyana"; break;
		case "HT": $country = "Haiti"; break;
		case "HM": $country = "Heard & McDonald Islands"; break;
		case "HN": $country = "Honduras"; break;
		case "HK": $country = "Hong Kong SAR China"; break;
		case "HU": $country = "Hungary"; break;
		case "IS": $country = "Iceland"; break;
		case "IN": $country = "India"; break;
		case "ID": $country = "Indonesia"; break;
		case "IR": $country = "Iran"; break;
		case "IQ": $country = "Iraq"; break;
		case "IE": $country = "Ireland"; break;
		case "IM": $country = "Isle of Man"; break;
		case "IL": $country = "Israel"; break;
		case "JM": $country = "Jamaica"; break;
		case "JP": $country = "Japan"; break;
		case "JE": $country = "Jersey"; break;
		case "JO": $country = "Jordan"; break;
		case "KZ": $country = "Kazakhstan"; break;
		case "KE": $country = "Kenya"; break;
		case "KI": $country = "Kiribati"; break;
		case "KW": $country = "Kuwait"; break;
		case "KG": $country = "Kyrgyzstan"; break;
		case "LA": $country = "Laos"; break;
		case "LV": $country = "Latvia"; break;
		case "LB": $country = "Lebanon"; break;
		case "LS": $country = "Lesotho"; break;
		case "LR": $country = "Liberia"; break;
		case "LY": $country = "Libya"; break;
		case "LI": $country = "Liechtenstein"; break;
		case "LT": $country = "Lithuania"; break;
		case "LU": $country = "Luxembourg"; break;
		case "MO": $country = "Macao SAR China"; break;
		case "MG": $country = "Madagascar"; break;
		case "MW": $country = "Malawi"; break;
		case "MY": $country = "Malaysia"; break;
		case "MV": $country = "Maldives"; break;
		case "ML": $country = "Mali"; break;
		case "MT": $country = "Malta"; break;
		case "MH": $country = "Marshall Islands"; break;
		case "MQ": $country = "Martinique"; break;
		case "MR": $country = "Mauritania"; break;
		case "MU": $country = "Mauritius"; break;
		case "YT": $country = "Mayotte"; break;
		case "MX": $country = "Mexico"; break;
		case "FM": $country = "Micronesia"; break;
		case "MD": $country = "Moldova"; break;
		case "MC": $country = "Monaco"; break;
		case "MN": $country = "Mongolia"; break;
		case "ME": $country = "Montenegro"; break;
		case "MS": $country = "Montserrat"; break;
		case "MA": $country = "Morocco"; break;
		case "MZ": $country = "Mozambique"; break;
		case "MM": $country = "Myanmar (Burma)"; break;
		case "NA": $country = "Namibia"; break;
		case "NR": $country = "Nauru"; break;
		case "NP": $country = "Nepal"; break;
		case "NL": $country = "Netherlands"; break;
		case "NC": $country = "New Caledonia"; break;
		case "NZ": $country = "New Zealand"; break;
		case "NI": $country = "Nicaragua"; break;
		case "NE": $country = "Niger"; break;
		case "NG": $country = "Nigeria"; break;
		case "NU": $country = "Niue"; break;
		case "NF": $country = "Norfolk Island"; break;
		case "KP": $country = "North Korea"; break;
		case "MK": $country = "North Macedonia"; break;
		case "MP": $country = "Northern Mariana Islands"; break;
		case "NO": $country = "Norway"; break;
		case "OM": $country = "Oman"; break;
		case "PK": $country = "Pakistan"; break;
		case "PW": $country = "Palau"; break;
		case "PS": $country = "Palestinian Territories"; break;
		case "PA": $country = "Panama"; break;
		case "PG": $country = "Papua New Guinea"; break;
		case "PY": $country = "Paraguay"; break;
		case "PE": $country = "Peru"; break;
		case "PH": $country = "Philippines"; break;
		case "PN": $country = "Pitcairn Islands"; break;
		case "PL": $country = "Poland"; break;
		case "PT": $country = "Portugal"; break;
		case "PR": $country = "Puerto Rico"; break;
		case "QA": $country = "Qatar"; break;
		case "RE": $country = "Réunion"; break;
		case "RO": $country = "Romania"; break;
		case "RU": $country = "Russia"; break;
		case "RW": $country = "Rwanda"; break;
		case "WS": $country = "Samoa"; break;
		case "SM": $country = "San Marino"; break;
		case "ST": $country = "São Tomé & Príncipe"; break;
		case "SA": $country = "Saudi Arabia"; break;
		case "SN": $country = "Senegal"; break;
		case "RS": $country = "Serbia"; break;
		case "SC": $country = "Seychelles"; break;
		case "SL": $country = "Sierra Leone"; break;
		case "SG": $country = "Singapore"; break;
		case "SX": $country = "Sint Maarten"; break;
		case "SK": $country = "Slovakia"; break;
		case "SI": $country = "Slovenia"; break;
		case "SB": $country = "Solomon Islands"; break;
		case "SO": $country = "Somalia"; break;
		case "ZA": $country = "South Africa"; break;
		case "GS": $country = "South Georgia & South Sandwich Islands"; break;
		case "KR": $country = "South Korea"; break;
		case "SS": $country = "South Sudan"; break;
		case "ES": $country = "Spain"; break;
		case "LK": $country = "Sri Lanka"; break;
		case "BL": $country = "St. Barthélemy"; break;
		case "SH": $country = "St. Helena"; break;
		case "KN": $country = "St. Kitts & Nevis"; break;
		case "LC": $country = "St. Lucia"; break;
		case "MF": $country = "St. Martin"; break;
		case "PM": $country = "St. Pierre & Miquelon"; break;
		case "VC": $country = "St. Vincent & Grenadines"; break;
		case "SD": $country = "Sudan"; break;
		case "SR": $country = "Suriname"; break;
		case "SJ": $country = "Svalbard & Jan Mayen"; break;
		case "SE": $country = "Sweden"; break;
		case "CH": $country = "Switzerland"; break;
		case "SY": $country = "Syria"; break;
		case "TW": $country = "Taiwan"; break;
		case "TJ": $country = "Tajikistan"; break;
		case "TZ": $country = "Tanzania"; break;
		case "TH": $country = "Thailand"; break;
		case "TL": $country = "Timor-Leste"; break;
		case "TG": $country = "Togo"; break;
		case "TK": $country = "Tokelau"; break;
		case "TO": $country = "Tonga"; break;
		case "TT": $country = "Trinidad & Tobago"; break;
		case "TN": $country = "Tunisia"; break;
		case "TR": $country = "Turkey"; break;
		case "TM": $country = "Turkmenistan"; break;
		case "TC": $country = "Turks & Caicos Islands"; break;
		case "TV": $country = "Tuvalu"; break;
		case "UM": $country = "U.S. Outlying Islands"; break;
		case "VI": $country = "U.S. Virgin Islands"; break;
		case "UG": $country = "Uganda"; break;
		case "UA": $country = "Ukraine"; break;
		case "AE": $country = "United Arab Emirates"; break;
		case "GB": $country = "United Kingdom"; break;
		case "US": $country = "United States"; break;
		case "UY": $country = "Uruguay"; break;
		case "UZ": $country = "Uzbekistan"; break;
		case "VU": $country = "Vanuatu"; break;
		case "VA": $country = "Vatican City"; break;
		case "VE": $country = "Venezuela"; break;
		case "VN": $country = "Vietnam"; break;
		case "WF": $country = "Wallis & Futuna"; break;
		case "EH": $country = "Western Sahara"; break;
		case "YE": $country = "Yemen"; break;
		case "ZM": $country = "Zambia"; break;
		case "ZW": $country = "Zimbabwe"; break;
		default: $country = "Not set";
	}
	return $country;
}

?>