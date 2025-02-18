<?php
require("common/db.req.php");
include("common/head.inc.php");
include("common/nav.inc.php");

// Bejelentkezés ellenőrzés
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

$target_dir = "uploads/profilePictures/";
$jpegExt = ['jpg', 'jpeg', 'JPG', 'JPEG'];

$valasz = "";

// Profilkép feltöltése bejelentkezett felhasználók számára
if (isset($_FILES["profilePicture"]["tmp_name"])) {
    $filename = basename($_FILES["profilePicture"]["name"]);
    $filenameArr = explode(".", $filename);
    $fileExt = strtolower(end($filenameArr));

    // Ellenőrzés a fájl típusra
    if (!in_array($fileExt, $jpegExt)) {
        $valasz = "Hiba történt! Csak jpg fájlok tölthetők fel.";
    }

    if (empty($valasz)) {
        $target_file = $target_dir . $_SESSION["id"] . ".jpg";

        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            $valasz = "A " . htmlspecialchars($filename) . " fájl sikeresen feltöltésre került.";
        } else {
            $valasz = "Sajnos hiba történt a fájl feltöltése során.";
        }
    }
}

?>

<section>
    <form action="profil.php" method="post" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
        <p>Válaszd ki a feltöltendő képet</p>
        <input type="file" name="profilePicture" id="profilePicture" required>
        <input type="submit" value="Kép feltöltése" class="btn btn-outline-success">
    </form>

    <div>
        <?php
        $profileImage = "uploads/profilePictures/-1.jpg";
        if (file_exists($target_dir . $_SESSION["id"] . ".jpg")) {
            $profileImage = $target_dir . $_SESSION["id"] . ".jpg";
        }
        echo "<img src=\"$profileImage\" class=\"profile\">";
        ?>
    </div>
    <?php if ($valasz) { echo "<p>$valasz</p>"; } ?>
</section>

<?php include("common/footer.inc.php"); ?>
