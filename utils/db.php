<?php
$servername = "31.170.160.1";
$username = "u613351590_krupp";
$password = "fc51g13+Ms";
$dbname = "u613351590_flowersv2";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
