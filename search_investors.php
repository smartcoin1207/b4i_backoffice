<?php

require_once "_conf.php";
require_once "_auth.php";

$query = isset($_GET['query']) ? $_GET['query'] : '';

if($query) {
    $sql = "SELECT id, name FROM investors WHERE name LIKE %s LIMIT 10";

    // Use MeekroDB to execute the query and get results
    $results = DB::query($sql, "%$query%");

    echo json_encode($results);
} else {
    echo json_encode($results);
}
