<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = $_POST['id'];
    $trainer_name = $_POST['trainer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rate = $_POST['rate'];
    $certification = $_POST['certification'];
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("INSERT INTO trainers (id, name, email, phone, rate, certification, specialization) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiiss", $trainer_id, $trainer_name, $email, $phone, $rate, $certification, $specialization);

    if ($stmt->execute()) {
        header('Location: trainer.php');
        exit();
    } else {
        echo "Error adding new trainer: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
