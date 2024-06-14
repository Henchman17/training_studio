<?php
session_start();
include 'conn.php';

if (isset($_GET['id'])) {
    $trainerId = $_GET['id'];

    $sql = "UPDATE trainers SET archived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trainerId);

    if ($stmt->execute()) {
        echo "<script>alert('Trainer archived successfully!'); window.location.href = 'trainer.php?page=trainer';</script>";
    } else {
        echo "<script>alert('Error archiving trainer: " . $conn->error . "'); window.location.href = 'trainer.php?page=trainer';</script>";
    }

    $stmt->close();
}
?>
