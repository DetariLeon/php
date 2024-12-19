<?php
require("common/db.req.php");

if (!isset($_SESSION["isAdmin"]) or $_SESSION["isAdmin"] != "1") {
    header("Refresh:0; url=index.php");
    die();
}

if (isset($_REQUEST['action']) and isset($_REQUEST['id'])) {
    if ($_REQUEST['action'] == 'deleteimg') {
        if (file_exists("uploads/profilePictures/" . $_REQUEST["id"] . ".jpg")) {
            if (unlink("uploads/profilePictures/" . $_REQUEST["id"] . ".jpg")) {
                $valasz = "A profilkép törlésre került";
            }
        }
    }
}

$target_dir = "uploads/profilePictures/";
$jpegExt = array('jpg', 'jpeg', 'JPG', 'JPEG');

if (isset($_FILES["profilePicture"]["tmp_name"])) {
    if ($filename = basename($_FILES["profilePicture"]["name"])) {
        $filenameArr = preg_split("/\./", $filename);

        if (function_exists('mime_content_type')) {
            if (!mime_content_type($_FILES["profilePicture"]["tmp_name"])) {
                $valasz = "Hiba történt! Csak jpg fájlok tölthetők fel.";
            }
        } elseif (!in_array($filenameArr[1], $jpegExt)) {
            $valasz = "Hiba történt! Csak jpg fájlok tölthetők fel.";
        }
        if (!isset($valasz)) {
            $target_file = $target_dir . $_REQUEST["id"] . ".jpg";

            if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
                $valasz = "A " . htmlspecialchars(basename($_FILES["profilePicture"]["name"])) . " " . $mime . " fájl feltöltésre került";
            } else {
                $valasz = "Sajnos hiba történt a fájl feltöltése során.";
            }
        }
    } else {
        $valasz = "Nem jelöltél ki feltöltendő fájlt.";
    }
}

include("common/head.inc.php");
include("common/nav.inc.php");
?>

<section>
    <div>
        <h1> 13. I. 1. csoport</h1>
        <h2> Ülésrend - Admin</h2>
    </div>
    <?php
    if (isset($_REQUEST['action']) and isset($_REQUEST['id'])) {
        if ($_REQUEST['action'] == 'uploadimg') { ?>

            <form action="admin.php" method="post" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
                <p>Választott UserID:</p>
                <input type="number" name="id" readonly id="id" value="<?php echo $_REQUEST['id']; ?>">
                <p>Válaszd ki a feltöltendő képet</p>
                <input type="file" name="profilePicture" id="profilePicture">
                <input type="submit" value="Kép feltöltése" class="btn btn-outline-success">
            </form>

        <?php }
    } ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Első Oszlop</th>
                <th scope="col">Második Oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Harmadik Oszlop </th>
                <th scope="col">Negyedik Oszlop</th>
                <th scope="col">Folyosó</th>
                <th scope="col">Ötödik Oszlop</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, nev, sor, oszlop FROM osztaly ORDER BY sor, oszlop";
            $result = $conn->query($sql);

            $sor = NULL;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($sor !== $row["sor"]) {
                        if ($sor !== NULL)
                            echo "</tr>"; ?>
                        <tr>
                            <th scope="row"><?php echo $row["sor"] + 1; ?></th>
                            <?php
                            $sor = $row["sor"];
                    }

                    $profileImage = "<img class=\"img-thumbnail pfp\" src=\"uploads/profilePictures/-1.jpg\">";
                    if (file_exists("uploads/profilePictures/" . $row["id"] . ".jpg")) {
                        $profileImage = "<img class=\"img-thumbnail pfp\" src=\"uploads/profilePictures/" . $row["id"] . ".jpg" . "\">";
                    } elseif (str_contains($row["nev"], "-")) {
                        $profileImage = "";
                    }

                    $nev = $row["nev"] . "<p><a href=\"admin.php?action=uploadimg&id=" . $row["id"] . "\">Kép feltöltése</a>";
                    if (file_exists("uploads/profilePictures/" . $row["id"] . ".jpg")) {
                        $nev = "<p>" . $row["nev"] . "<p><a href=admin.php?action=uploadimg&id=" . $row["id"] . "\">Kép feltöltése</a>" . "</p> <a href=\"admin.php?action=deleteimg&id=" . $row["id"] . "\">Kép törlése</a>";
                    }
                    echo "<td" . $class . ">" . $profileImage . "<br>" . $nev . "</td>";

                    if ($row["oszlop"] == 1 or $row["oszlop"] == 3) {
                        echo "<td>  </td>";
                    }
                }
            } else {
                echo "0 results";
            }
            ?>
            </tr>
        </tbody>
    </table>
</section>

<?php include("common/footer.inc.php"); ?>