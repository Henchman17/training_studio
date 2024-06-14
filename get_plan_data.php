<?php

// Include the database connection file
include 'conn.php';

// Get the plan ID from the query string
$id = $_GET['id'];

// Fetch the plan data from the database
$query = "SELECT * FROM plans WHERE planid = '$id' AND archived = 0";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $plan = $result->fetch_assoc();
    $response = array('id' => $plan['planid'], 'name' => $plan['plan_name'], 'schedule' => $plan['schedule'], 'plan_validity' => $plan['plan_validity'], 'amount' => $plan['amount'], 'description' => $plan['description'], 'trainer_id' => $plan['trainer_id']);
} else {
    $response = array('error' => 'Plan not found');
}

// Close the database connection
$conn->close();

// Send the response back to the client
echo json_encode($response);

?>