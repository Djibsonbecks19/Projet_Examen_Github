<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "nsa";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}
?>
