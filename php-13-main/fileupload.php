<?php
// Hibakeresés engedélyezése
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_FILES["fileToUpload"]["tmp_name"])) {
    $target_dir = "uploads/profilePictures/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        echo "Hiba: Nem képfájl.";
        exit;
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Hiba: Csak JPG, JPEG, PNG és GIF fájlokat lehet feltölteni.";
        exit;
    }

    if ($_FILES["fileToUpload"]["size"] > 2000000) { // 2 MB
        echo "Hiba: A fájl túl nagy.";
        exit;
    }

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true); 
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "A " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " fájl sikeresen feltöltve.";
    } else {
        echo "Hiba történt a fájl feltöltése során.";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File feltöltés</title>
</head>

<body>
    <h2>Fájl feltöltése</h2>
    <form action="fileupload.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Válasszon egy képet a feltöltéshez:</label><br>
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
        <input type="submit" value="Kép feltöltése" class="btn btn-success">
    </form>
</body>

</html>
