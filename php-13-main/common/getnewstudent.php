<?php

require "db.req.php";

$resp = array();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT sor, oszlop, nev FROM osztaly ORDER BY sor, oszlop";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ures = ($row["nev"] == '-' || $row["nev"] == 'Tanári Asztal');
            $resp[] = array(
                "sor" => $row["sor"],
                "oszlop" => $row["oszlop"],
                "nev" => $ures ? "Üres" : $row["nev"],
                "foglalhato" => $ures ? true : false
            );
        }
    }

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($resp, JSON_UNESCAPED_UNICODE);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["sor"], $data["oszlop"], $data["nev"])) {
        $sor = $conn->real_escape_string($data["sor"]);
        $oszlop = $conn->real_escape_string($data["oszlop"]);
        $nev = $conn->real_escape_string($data["nev"]);

        $check_sql = "SELECT nev FROM osztaly WHERE sor = '$sor' AND oszlop = '$oszlop'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $row = $check_result->fetch_assoc();
            if ($row["nev"] == '-' || $row["nev"] == 'Tanári Asztal') {
                $update_sql = "UPDATE osztaly SET nev = '$nev' WHERE sor = '$sor' AND oszlop = '$oszlop'";
                if ($conn->query($update_sql) === TRUE) {
                    http_response_code(200);
                    echo json_encode(["message" => "Tanuló sikeresen hozzáadva!"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Hiba történt a frissítés során."]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Ez a hely már foglalt."]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "A megadott hely nem található."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó adatok."]);
    }
}

?>
