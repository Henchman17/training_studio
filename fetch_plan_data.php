<?php
include 'conn.php';

// Check connection
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Get the currently logged-in user's ID
$user_id = $_SESSION['id'];

// Get the plan ID from the form value
$plan_id = $_POST['plan_id'];

// Check if the plan ID is valid
$plan_query = "SELECT * FROM plans WHERE id = '$plan_id'";
$plan_result = mysqli_query($conn, $plan_query);
if (mysqli_num_rows($plan_result) > 0) {
    $plan_row = mysqli_fetch_assoc($plan_result);
    $plan_validity = $plan_row['validity']; // Get the plan validity
} else {
    echo "Invalid plan ID";
    exit;
}

// Get the number of months from the form value
$num_months = $_POST['num_months'];

// Compute the purchase amount
$purchase_amount = $plan_validity * $num_months;

// Generate a unique purchase ID
$purchase_id = uniqid();

// Get the current date and time
$purchase_date = date("Y-m-d H:i:s");

// Compute the start and end dates
$plan_start_date = date("Y-m-d", strtotime($purchase_date));
$plan_end_date = date("Y-m-d", strtotime($purchase_date. " + $num_months months"));

// Insert the new purchase record
$query = "INSERT INTO purchases (purchase_id, user_id, plan_id, purchase_date, purchase_amount, payment_method, plan_start_date, plan_end_date)
          VALUES ('$purchase_id', '$user_id', '$plan_id', '$purchase_date', '$purchase_amount', '$_POST[payment_method]', '$plan_start_date', '$plan_end_date')";
if (mysqli_query($conn, $query)) {
    echo "Purchase record created successfully";
} else {
    echo "Error: ". mysqli_error($conn);
}

mysqli_close($conn);
?>