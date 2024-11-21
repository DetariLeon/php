<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülésrend (Fájlfeltöltés)</title>
</head>

<body class="text-center bg-secondary-subtle">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Menü</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Főoldal</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION["id"])) {
                            echo '<a class="nav-link" href="logout.php">Kilépés</a>';
                        } else {
                            echo '<a class="nav-link" href="login.php">Belépés</a>';
                        }
                        ?>
                    </li>
                </ul>
                <form class="d-flex" role="search" method="post" action="index.php">
                    <input type="text" class="form-control me-2" placeholder="Keresés név alapján..." name="keresett_nev" autocomplete="off" aria-label="Keresés név alapján..." value="<?php echo $name ?>" aria-describedby="searchBtn">
                    <button class="btn btn-outline-success" type="submit" id="searchBtn">Keresés</button>
                </form>
            </div>
        </div>
    </nav>