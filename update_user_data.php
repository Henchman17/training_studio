<?php
session_start();

include 'conn.php';

$id = $_POST['id'];
$fname = $_POST['fname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$planid = $_POST['planid'];

$query = $conn->query("UPDATE users SET fname = '$fname', email = '$email', phone = '$phone', planid = '$planid' WHERE id = $id");

if ($query) {
    echo 'User data updated successfully!';
} else {
    echo 'Error updating user data: '. $conn->error;
}
?>