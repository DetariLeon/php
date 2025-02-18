<?php

require "db.req.php";

$resp = array();

$sql = "SELECT sor, oszlop, nev FROM osztaly ORDER BY sor, oszlop";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $resp[] = array(
            "sor" => $row["sor"],
            "oszlop" => $row["oszlop"],
            "nev" => ($row["nev"] != '-' && $row["nev"] != 'Tanári Asztal') ? $row["nev"] : "Üres"
        );
    }
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($resp, JSON_UNESCAPED_UNICODE);
?>