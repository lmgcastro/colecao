<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "colecao";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, 'utf8');