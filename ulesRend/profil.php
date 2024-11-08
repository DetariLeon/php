<?php
session_start();
require "common/db.inc.php";
require "common/head.inc.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$valasz = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["fileToUpload"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . $_SESSION["id"] . ".jpg";  // Profile image is stored with user ID as filename
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $valasz = "A fájl képként van formázva - " . $check["mime"];
            $uploadOk = 1;
        } else {
            $valasz = "A fájl nem kép.";
            $uploadOk = 0;
        }
    }

    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $valasz = "A fájl túl nagy.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $valasz = "Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $valasz = "A fájl nem lett feltöltve.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $valasz = "A fájl ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " sikeresen feltöltve.";
        } else {
            $valasz = "Hiba történt a fájl feltöltésekor.";
        }
    }
}

$profileImagePath = "uploads/" . $_SESSION["id"] . ".jpg";
if (!file_exists($profileImagePath)) {
    $profileImagePath = "uploads/default.png"; 
}
?>

<div>
    <?php
    if (isset($valasz)) {
        echo $valasz;
    }
    ?>
    <h2>Profilkép módosítása</h2>
    <img src="<?php echo $profileImagePath; ?>" alt="Profilkép" class="img-thumbnail" style="width: 150px; height: 150px;">
    <form action="profil.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Válaszd ki a fájlt:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Feltöltés" name="submit">
    </form>
</div>

</body>
</html>
