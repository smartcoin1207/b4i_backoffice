<?php

$founder_count = 47;

// Open the input CSV file for reading
$inputFile = fopen('main_founders.csv', 'r');

// Open a new CSV file for writing
$outputFile = fopen('b4i-universities.csv', 'w');

// Specify the column names you want to filter
$university = 'University';
$founders = 'Founders';

// Write headers to the output CSV file
fputcsv($outputFile, array($university, $founders));

// Initialize an array to store rows with the specified column values
$filteredRows = array();

// Read the header row to get the column indexes
$header = fgetcsv($inputFile, 1000, ";");
$university_index = array_search($university, $header);

if ($inputFile !== false) {
    $universities = [];

    while (($data = fgetcsv($inputFile, 2000, ";")) !== false) {       
        $universities[] = $data[$university_index];
    }
    
    // Get the count of each unique string
    $universities_counts = array_count_values($universities);
    arsort($universities_counts);

    // Get the unique strings
    $uniqueUniversitiesStrings = array_keys($universities_counts);

    $other_universities_count = 0;
    // Output the unique strings and their counts
    foreach ($uniqueUniversitiesStrings as $unique_university) {

        if(isset($founder_count) && $founder_count) {
            if($universities_counts[$unique_university] > $founder_count - 1) {
                $newData = array(
                    $university => $unique_university,
                    $founders => $universities_counts[$unique_university]
                );
                $filteredRows[] = $newData;
            } else {
                $other_universities_count += $universities_counts[$unique_university];
            }
        } else {
            $newData = array(
                $university => $unique_university,
                $founders => $universities_counts[$unique_university]
            );
            $filteredRows[] = $newData;
        }
    }

    if((isset($founder_count) && $founder_count)) {
        $otehrData = array(
            $university => "Other University",
            $founders => $other_universities_count
        );
    
        $filteredRows[] = $otehrData;
    }
}

// Write the filtered rows to the output CSV file
foreach ($filteredRows as $row) {
    fputcsv($outputFile, $row);
}

// Close the files
fclose($inputFile);
fclose($outputFile);

echo "Rows with University, Founders column data and headers have been written to output.csv.";
?>
