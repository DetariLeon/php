<?php
$servername = "localhost";
$username = "php_teszter";
$password = "lbIT-tP_@(Fc5cI@";
$dbname = "php_teszt";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name = '';

print_r($_REQUEST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST["keresett_nev"])) {
        $nameErr = "Nem írtál be nevet!";
    } else {
        $name = $_POST["keresett_nev"];
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülésrend (adatbázis)</title>
</head>


<body class="p-5 text-center bg-secondary-subtle">
    <h1>13.i 1. csoport</h1>
    <h2 class="mb-4">Ülésrend</h2>
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Első oszlop</th>
                <th scope="col">Második oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Harmadik oszlop</th>
                <th scope="col">Negyedik oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Ötödik oszlop</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, nev, sor, oszlop FROM osztaly ORDER BY sor, oszlop ASC";
            $result = $conn->query($sql);

            $sor = NULL;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($sor !== $row["sor"]) {
                        if ($sor !== NULL) echo "</tr>";
            ?>
                        <tr>
                            <th scope="row"><?php echo $row["sor"] + 1 ?></th>
                <?php
                        $sor = $row["sor"];
                    }

                    $class = "";
                    if ($name != '') {
                        if (strpos($row["nev"], $name) !== false) {
                            $class = "class=\"bg-danger\"";
                        }
                    }

                    echo "<td $class>" . $row["nev"] . "</td>";

                    if ($row["oszlop"] == 1 || $row["oszlop"] == 3) {
                        echo ("<td></td>");
                    };
                }
            } else {
                echo "nincs adat";
            }
                ?>
                        </tr>
        </tbody>
    </table>


    <form method="post" action="index.php">
        <div class="input-group w-25 mb-3 mx-auto">
            <input type="text" class="form-control" placeholder="Keresés név alapján..." name="keresett_nev" autocomplete="off" aria-label="Keresés név alapján..." value="<?php echo $name ?>" aria-describedby="searchBtn">
            <button class="btn btn-primary" type="submit" id="searchBtn">Keresés</button>
        </div>
    </form>
</body>

</html>
<?php
$conn->close();
?>