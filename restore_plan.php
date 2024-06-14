<?php
session_start();
include 'conn.php';

// Get plan ID from URL
$plan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Restore plan
$sql = "UPDATE plans SET archived = 0 WHERE planid = $plan_id";

if ($conn->query($sql) === TRUE) {
    header("Location: plans.php");
} else {
    echo "Error restoring plan: " . $conn->error;
}

// Close connection
$conn->close();
?>