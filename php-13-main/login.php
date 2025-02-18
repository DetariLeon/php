<?php
session_start();
require("common/db.req.php");
include("common/head.inc.php");
include("common/nav.inc.php");

$valasz = "";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $stmt = $conn->prepare("SELECT id, nev, jelszo, isAdmin FROM osztaly WHERE felhasznalonev = ?");
    if (!$stmt) {
        die("SQL hiba a prepare során: " . $conn->error);
    }

    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (hash_equals(hash('sha256', $_POST["password"]), $row["jelszo"])) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["nev"] = $row["nev"];
            $_SESSION["isAdmin"] = $row["isAdmin"];
            header("Location: index.php");
            exit;
        } else {
            $valasz = "Hibás jelszó!";
        }
    } else {
        $valasz = "Rossz felhasználónév!";
    }
} elseif (isset($_SESSION["id"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<section>
    <form method="POST" action="login.php" class="d-flex flex-column align-items-center">
        <input type="text" name="username" placeholder="Felhasználónév" required>
        <input type="password" name="password" placeholder="Jelszó" required>
        <input type="submit" value="Belépés" class="btn btn-success">
        <div><?php echo $valasz; ?></div>
    </form>
</section>

<?php include("common/footer.inc.php"); ?>
