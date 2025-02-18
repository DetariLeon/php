<?php

require "db.req.php";


$resp = array();

    $sql = "SELECT COUNT(*) as count FROM osztaly WHERE nev != '-' AND nev != 'Tanári asztal'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resp = array("count" => $row["count"]);
    } else {
        $resp = array("count" => 0);
    }

header("Content-Type: application/json; charset=UTF-8");

echo json_encode(array("nevek" => $resp), JSON_UNESCAPED_UNICODE);
?>


