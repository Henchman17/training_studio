<?php
session_start();
include 'conn.php';

$plan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Archive plan
$sql = "UPDATE plans SET archived = 1 WHERE planid = $plan_id";

if ($conn->query($sql) === TRUE) {
    header("Location: plans.php");
} else {
    echo "Error archiving plan: " . $conn->error;
}

// Close connection
$conn->close();
?>