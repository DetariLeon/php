<?php
require "common/db.req.php";

$q = $_REQUEST["q"];

$resp = array();

if (strlen($q) > 1) {
    $sql = "SELECT nev,id FROM osztaly WHERE nev LIKE '%" . $q . "%' ORDER BY nev";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resp[] = array("id" => $row["id"], "nev" => $row["nev"]);
        }
        echo json_encode(array("nevek" => $resp));
    }
}
?>