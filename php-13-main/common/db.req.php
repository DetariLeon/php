<?php


$servername = "localhost";
$username = "c31detariL";
$password = "qktMM!S6";
$dbname = "c31detariL_db";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, 'utf8');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>