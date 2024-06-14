<?php
session_start();
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $qry = $conn->prepare("UPDATE trainers SET archived = 0 WHERE id = ?");
    $qry->bind_param("i", $id);

    if ($qry->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit();
}
?>