<?php
//lbIT-tP_@(Fc5cI@
$servername = "localhost";
$username = "php_teszter";
$password = "lbIT-tP_@(Fc5cI@";
$dbname = "php_teszt";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " + $conn->connect_error);
}
//echo ("Success");

/*$osztaly = array(
    array(" - ", "Tanári asztal", "Gulyás Zsolt Máté", "Lénárt Áron", "-"),
    array("Mészáros Marcell", "Básti Domonkos", "Keindl Bercel", "Kiss Balázs", "-"),
    array("Csik Melinda", "Karakas Olivér Roland", "Ábrahám Dávid", "Détári Leon", "Togyeriska Viktor"),
    array(" - ", " - ", "Giczi Attila", "Preil Ákos", "Sivinger Miklós")
);
?>
<?php

foreach ($osztaly as $key => $sor) {

    foreach ($sor as $oszlop => $nev) {
        $sql = "INSERT INTO osztaly (nev, sor, oszlop) VALUES ('" . $nev . "', $key, $oszlop)";
        if ($conn->query($sql) === TRUE) {
          //  echo "cogany added"  . $nev . "\n";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

/*$sql = "SELECT id, nev, sor, oszlop FROM osztaly";
$result = $conn->query($sql);
$sor = NULL;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if($sor != $row["sor"])
        echo "id: " . $row["id"] . " - Name: " . $row["nev"] . " " . $row["sor"] . " " . $row["oszlop"] . "<br>";
    }
} else {
    echo "0 results";
}*/
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="padding: 10px;">
    <!-- <table class="table table-bordered border border-dark border-4">
        <thead>
            <tr>
                <th scope="col">1. sor</th>
                <th scope="col">2. sor</th>
                <th scope="col">3. sor</th>
                <th scope="col">4. sor</th>
                <th scope="col">5. sor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>Tanár</td>
                <td>Gulyás</td>
                <td>Áron</td>
                <td></td>
            </tr>
            <tr>
                <td>Pessi</td>
                <td>Básti</td>
                <td>Bercel</td>
                <td>Balu</td>
                <td></td>
            </tr>
            <tr>
                <td>Melinda</td>
                <td>Karakas</td>
                <td>Dávid</td>
                <td>LeonKirály</td>
                <td>Viki</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Ati</td>
                <td>Ákos</td>
                <td>Miki</td>
            </tr>
        </tbody>
    </table>-->



    <div>
        <h1> 13. I. 1. csoport</h1>
        <h2> Ülésrend</h2>

    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Első Oszlop</th>
                <th scope="col">Második Oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Harmadik Oszlop</th>
                <th scope="col">Negyedik Oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Ötödik Oszlop</th>
            </tr>
        </thead>
        <tbody>
        <?php                      
                    $sql = "SELECT id, nev, sor, oszlop FROM osztaly";
                    $result = $conn->query($sql);

                    $sor = NULL;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            if($sor !== $row["sor"]) {
                                ?>
                                <tr>
                                <th scope="row"><?php echo $row["sor"] + 1?></th>
                                <?php
                                $sor = $row["sor"];
                            }
                            echo "<td>" .$row["nev"]. "</td>";
                            if($row["oszlop"] == 1 || $row["oszlop"] == 3){
                                echo("<td></td>");
                            };
                        }
                        } else {
                            echo "0 results";
                        }
                ?>
        </tbody>
    </table>


    <style>
        body {
            padding: 60px;
            text-align: center;
            background-color: rgb(236, 232, 227);
        }

        h1 {
            padding: 20px auto;
            text-align: center;
        }

        h2 {
            padding: 20px auto;
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</body>

</html>
<?php

$conn->close();
?>