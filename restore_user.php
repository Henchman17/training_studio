<?php
// Include the database connection file
include 'conn.php';

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
  // Get the user ID from the URL
  $userId = $_GET['id'];

  // Prepare the SQL query to update the archived status to 0
  $sql = "UPDATE users SET archived = 0 WHERE id = $userId";

  // Execute the query
  if ($conn->query($sql) === TRUE) {
    // If the query was successful, return success
    echo "success";
  } else {
    // If the query failed, return an error message
    echo "Error: " . $conn->error;
  }
} else {
  // If the user ID is not provided, return an error message
  echo "User ID is missing.";
}

// Close the database connection
$conn->close();
?>