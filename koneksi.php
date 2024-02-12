<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "properti";

// Deklarasi variabel global untuk koneksi
global $conn;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>