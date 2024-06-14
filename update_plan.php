<?php

// Include the database connection file
include 'conn.php';

// Get the form data
$id = $_POST['id'];
$planname = $_POST['planname'];
$schedule = $_POST['schedule'];
$planvalidity = $_POST['planvalidity'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$trainerid = $_POST['trainerid'];

// Update the plan in the database
$query = "UPDATE plans SET plan_name = '$planname', schedule = '$schedule', plan_validity = '$planvalidity', amount = '$amount', description = '$description', trainer_id = '$trainerid' WHERE planid = '$id'";

if ($conn->query($query) === TRUE) {
    $response = array('success' => true);
} else {
    $response = array('error' => 'Error updating plan data: ' . $conn->error);
}

// Close the database connection
$conn->close();

// Send the response back to the client
echo json_encode($response);

?>