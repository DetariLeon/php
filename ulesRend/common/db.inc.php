<?php
$servername = "localhost";
$username = "php_teszter";
$password = "lbIT-tP_@(Fc5cI@";
$dbname = "php_teszt";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>