<?php
session_start();

$host = 'localhost';
$dbname = 'gym';
$username = 'admin';
$password = '2003';

$conn = mysqli_connect($host, $username, $password, $dbname);

$id = $_GET['id'];

$query = $conn->query("SELECT * FROM users WHERE id = $id");
$row = $query->fetch_assoc();

echo json_encode($row);
?>