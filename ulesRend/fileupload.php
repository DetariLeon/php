<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']);
    $fileType = mime_content_type($_FILES['fileToUpload']['tmp_name']);
    $fileSize = $_FILES['fileToUpload']['size'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($fileType, $allowedTypes)) {
        echo "Csak JPG, PNG és GIF fájlok tölthetők fel.";
    } elseif ($fileSize > 2000000) {
        echo "A fájl mérete nem haladhatja meg a 2 MB-ot.";
    } elseif (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
        echo "Sikeres feltöltés: " . htmlspecialchars(basename($_FILES['fileToUpload']['name']), ENT_QUOTES, 'UTF-8');
    } else {
        echo "Hiba történt a fájl feltöltésekor.";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fájl feltöltése</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Válassz egy fájlt:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <button type="submit">Feltöltés</button>
    </form>
</body>
</html>