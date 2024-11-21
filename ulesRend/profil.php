<?php
session_start();
require "common/db.inc.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;

$target_dir = "uploads/";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload']) && isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $file = $_FILES['fileToUpload'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
        $target_file = $target_dir . $userId . ".jpg";

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $message = "Kép sikeresen feltöltve!";
        } else {
            $message = "Hiba a kép feltöltése közben.";
        }
    } else {
        $message = "Csak JPG, JPEG, PNG vagy GIF fájlok engedélyezettek.";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'deleteimg' && isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $target_file = $target_dir . $userId . ".jpg";

    if (file_exists($target_file)) {
        if (unlink($target_file)) {
            $message = "A kép törölve.";
        } else {
            $message = "Hiba a kép törlésekor.";
        }
    } else {
        $message = "Nincs kép törlésre.";
    }
}

include "common/head.inc.php";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Admin profilkezelés</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container mt-5">
    <h1>Profilkép kezelése</h1>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <h2>Adminisztrátor: Felhasználók képeinek kezelése</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Név</th>
                    <th>Profilkép</th>
                    <th>Új kép feltöltése</th>
                    <th>Kép törlése</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, nev FROM osztaly";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $profileImagePath = $target_dir . $row['id'] . ".jpg";

                        if (!file_exists($profileImagePath)) {
                            $profileImagePath = $target_dir . "default.png";
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['nev']); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($profileImagePath); ?>" alt="Profilkép" class="img-thumbnail" style="width: 50px; height: 50px;">
                            </td>
                            <td>
                                <form action="profil.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                                    <input type="file" name="fileToUpload" required>
                                    <button type="submit" class="btn btn-primary">Feltöltés</button>
                                </form>
                            </td>
                            <td>
                                <a href="profil.php?action=deleteimg&userId=<?php echo $row['id']; ?>" class="btn btn-danger">Törlés</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>Nincsenek felhasználók.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <h2>Saját profilkép kezelése</h2>
        <?php
        $userId = $_SESSION['id'];
        $profileImagePath = $target_dir . $userId . ".jpg";

        if (!file_exists($profileImagePath)) {
            $profileImagePath = $target_dir . "default.png";
        }
        ?>
        <img src="<?php echo htmlspecialchars($profileImagePath); ?>" alt="Profilkép" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
        <form action="profil.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
            <input type="file" name="fileToUpload" required>
            <button type="submit" class="btn btn-primary">Feltöltés</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$conn->close();
?>