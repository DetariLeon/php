<?php
session_start();
require "common/db.inc.php";
require "common/head.inc.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$target_dir = "./uploads/";
$default_image = "default.png";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["fileToUpload"])) {
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($filetype, $allowed_extensions)) {
        $target_file = $target_dir . $_SESSION["id"] . ".jpg";
        
        if ($filetype !== 'jpg' && $filetype !== 'jpeg') {
            $image = imagecreatefromstring(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
            imagejpeg($image, $target_file);
            imagedestroy($image);
        } else {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        }

        echo "A fájl sikeresen feltöltve!";
    } else {
        echo "Hiba: Csak JPG, JPEG, PNG és GIF formátumok engedélyezettek.";
    }
} elseif (isset($_GET["action"]) && $_GET["action"] == 'deleteimg') {
    $target_file = $target_dir . $_SESSION["id"] . ".jpg";
    if (file_exists($target_file)) {
        unlink($target_file);
        echo "A profilkép törlésre került.";
    }
}

$profileImagePath = file_exists($target_dir . $_SESSION["id"] . ".jpg") ? $target_dir . $_SESSION["id"] . ".jpg" : $target_dir . $default_image;
?>

<div class="mt-5 text-center">
    <h1>Profil</h1>
    <img src="<?php echo $profileImagePath; ?>" alt="Profile" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
    <p><a href="profil.php?action=deleteimg" class="btn btn-danger">Kép törlése</a></p>

    <form action="profil.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload" class="form-label">Válassz egy új képet:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control mb-3">
        <input type="submit" value="Feltöltés" name="submit" class="btn btn-primary">
    </form>
</div>

<?php
$conn->close();
?>