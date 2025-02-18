<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Menü</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>

                    <?php
                    if (!isset($_SESSION["id"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Belépés</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?php echo $_SESSION["nev"]; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="login.php">Kijelentkezés</a></li>
                            </ul>
                        </li>
                    <?php }
                    if (isset($_SESSION["isAdmin"]) and $_SESSION["isAdmin"] == "1") { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin panel</a>
                        </li>
                    <?php } ?>
                </ul>
                <?php if (isset($searchBar) && $searchBar === true) { ?>
                    <form class="d-flex" role="search" action="index.php" method="POST">
                        <input onkeyup="showHint(this.value)" class="form-control me-2" type="search" placeholder="Keresés" aria-label="Search"
                            name="keresett_nev" value="<?php echo $name; ?>">
                        <button class="btn btn-outline-success" type="submit">Keresés</button>
                    </form>
                    <div id="txtHint">
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>