<?php
// Adatbázis-alapú adatok lekérdezése
$sql = "SELECT Id, nev, sor, oszlop FROM".DB_PREFIX. "_osztaly ORDER BY sor, oszlop";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Sorok kiíratása
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["Id"] . " - Név: " . $row["nev"] . " - Sor: " . $row["sor"] . " - Oszlop: " . $row["oszlop"] . "<br>";
    }
} else {
    echo "0 results";
}
?>
