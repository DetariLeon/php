<?php
session_start();
require "common/db.inc.php";

$name = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST["keresett_nev"])) {
        $nameErr = "Nem írtál be nevet!";
    } else if (strlen($_POST["keresett_nev"]) < 2) {
        $nameErr = "Írj be legalább két karaktert!";
    } else {
        $name = $_POST["keresett_nev"];
    }
}

include "common/head.inc.php";
?>

<p><?php if (isset($nameErr)) echo $nameErr ?></p>

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

                $profileImagePath = "uploads/" . $row["id"] . ".jpg";
                if (!file_exists($profileImagePath)) {
                    $profileImagePath = "uploads/default.png"; 
                }

                $class = "";
                if ($name != '') {
                    if (strpos($row["nev"], $name) !== FALSE) {
                        $class = "class=\"bg-danger\"";
                    }
                }

                if (isset($_SESSION["id"]) && $_SESSION["id"] == $row["id"]) {
                    echo "<td $class><img src='$profileImagePath' alt='Profile' class='img-thumbnail' style='width: 50px; height: 50px;'> <a href='#'>" . $row["nev"] . "</a></td>";
                } else {
                    echo "<td $class>" . $row["nev"] . "</td>";
                }

                if ($row["oszlop"] == 1 || $row["oszlop"] == 3) {
                    echo("<td></td>");
                }
            }
        } else {
            echo "nincs adat";
        }
        ?>
        </tr>
    </tbody>
</table>
</body>
</html>

<?php
$conn->close();
?>
