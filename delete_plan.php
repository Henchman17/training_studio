<?php
include 'conn.php'; // Include the database connection

if (isset($_GET['id'])) {
    $planid = $_GET['id'];

    // Prepare the SQL statement to delete the plan
    $stmt = $conn->prepare("DELETE FROM plans WHERE planid = ?");
    $stmt->bind_param("i", $planid);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        // Redirect back to the plans page
        header('Location: plans.php');
        exit();
    } else {
        echo "Error deleting plan: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No plan ID provided.";
}

// Close the database connection
$conn->close();
?>