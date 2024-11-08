<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fájl feltöltése</title>
</head>
<body>
    <form action="info.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Válassz egy képet:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Feltöltés" name="submit">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["fileToUpload"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "A " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " fájl feltöltésre került";
        } else {
            echo "Hiba történt a fájl feltöltése során.";
        }
    }
    ?>
</body>
</html>
