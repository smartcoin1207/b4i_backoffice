<?php
$f = fopen('php://memory', 'w'); 

// Define headers for the new CSV file
$data = array();
array_push($data, array(
    "Investor",
    "Investments"
));

// Loop through the startup portfolios and filter by investors_count > 0
foreach( $investors_exports as $investors_export ) {
    // Only include records where investors_count is greater than 0
        array_push($data, array(
            $investors_export['name'],      // Startup Name
            $investors_export['portfolio_count'],   // Investor Count
        ));
}

// Write new data to the CSV
foreach( $data as $line ) {
    fputcsv($f, $line, ";");
}

// Reset memory pointer to the beginning of the file
fseek($f, 0);

// Output headers for browser download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="investor_data.csv";');

// Output all the data in CSV format
fpassthru($f);

exit();
?>