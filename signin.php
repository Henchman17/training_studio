<?php
session_start();

require_once "config.php";
include 'conn.php';

if (isset($_POST['send'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $pass = htmlspecialchars($_POST['pass']);

    // Check if all fields are complete
    if (!empty($name) &&!empty($email) &&!empty($phone) &&!empty($pass)) {
        // Hash the password
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, "INSERT INTO users (fname, email, phone, pass) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $phone, $hash);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.html");
        } else {
            echo "Error: ". mysqli_stmt_error($stmt);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        header("Location: signup-form-20/signup.html");
    }
}

// Close MySQL connection
mysqli_close($conn);

?>