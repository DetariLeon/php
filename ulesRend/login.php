<?php
session_start();
require "common/db.inc.php";

if (isset($_SESSION["id"]) && isset($_SESSION["nev"])) {
    header("Location: index.php");
    exit();
}

$valasz = "";
$name = "";

if (isset($_POST["felhasznalonev"]) && isset($_POST["jelszo"])) {
    $sql = "SELECT id, nev, jelszo FROM osztaly WHERE felhasznalonev = \"" . $_POST["felhasznalonev"] . "\"";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['jelszo'] === hash('sha256', $_POST['jelszo'])) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["nev"] = $row["nev"];
            $valasz = "Üdv, " . $row["nev"] . "!";
            header("Location: index.php");
            exit();
        } else {
            $valasz = "Hibás jelszó";
        }
    } else {
        $valasz = "Nincs ilyen felhasználónév";
    }
} elseif (isset($_SESSION["id"])) {
    unset($_SESSION["id"]);
    unset($_SESSION["nev"]);
}

$conn->close();

include("common/head.inc.php");
?>

<div class="mt-5 d-flex flex-column align-items-center">
    <h1 class="mb-4">Bejelentkezés</h1>
    <p class="mb-3 fw-bold">
        <?php
        if (isset($valasz)) {
            echo $valasz;
        }
        ?>
    </p>
    <form class="w-50 form-group" action="login.php" method="post">
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="felhasznalonev" name="felhasznalonev" placeholder="Felhasználónév">
                <label for="felhasznalonev">Felhasználónév</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="jelszo" name="jelszo" placeholder="Jelszó">
                <label for="jelszo">Jelszó</label>
            </div>
        </div>
        <button type="submit" class="btn btn-success py-2 w-100">Bejelentkezés</button>
    </form>
</div>
</body>
</html>
