<?php
if (isset($_FILES["fileToUpload"]["tmp_name"])) {
    $target_dir = "uploads/profilePictures/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "A ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " fájl sikeresen feltöltve.";
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
    <form action="fileupload.php" method="post" enctype="multipart/form-data">
        Select image to upload
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Kép feltöltése">
    </form>
</body>

</html>