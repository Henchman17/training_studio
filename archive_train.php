<?php
session_start();
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $qry = $conn->prepare("UPDATE trainers SET archived = 1 WHERE id = ?");
    $qry->bind_param("i", $id);

    if ($qry->execute()) {
        header('Location: trainer.php');
        exit();
    } else {
        echo "Error archiving trainer: " . $conn->error;
    }
}
?>