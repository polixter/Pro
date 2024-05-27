<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

include '../utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deleta a planta do banco de dados
    $sql = "DELETE FROM plants WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_plants.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID";
}
?>
