<?php
$searchBar = true;
require("common/db.req.php");

$name = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["keresett_nev"])) {
    $nameErr = "Nem írtál be nevet 💀";
  } else if (strlen($_POST["keresett_nev"]) < 2) {
    $nameErr = "Írj be legalább két karaktert";
  } else {
    $name = $_POST["keresett_nev"];
  }
}

include("common/head.inc.php");
include("common/nav.inc.php");
?>

<section>
  <div>
    <h1> 13. I. 1. csoport</h1>
    <h2> Ülésrend</h2>
  </div>
  <?php if (isset($nameErr))
    echo $nameErr; ?>
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
          $class = '';
          if ($name != '' && stripos($row['nev'], $name) !== FALSE) {
            $class = ' class="border border-secondary"';
          }

          $profileImage = "<img class=\"img-thumbnail pfp\" src=\"uploads/profilePictures/-1.jpg\">";
          if(file_exists("uploads/profilePictures/".$row["id"].".jpg")){
            $profileImage = "<img class=\"img-thumbnail pfp\" src=\"uploads/profilePictures/".$row["id"].".jpg"."\">";
          } elseif (str_contains($row["nev"], "-")){
            $profileImage = "";
          }

          $nev = $row["nev"];
          if (isset($_SESSION["id"]) && $_SESSION["id"] == $row["id"]) {
            $nev = "<a href='profil.php'>".$row["nev"]."</a>";
          }
          echo "<td".$class.">".$profileImage."<br>".$nev."</td>";

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