<?php
session_start();

include 'conn.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['name']) && isset($_POST['adpass'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['name']);
    $pass = validate($_POST['adpass']);

    if (empty($uname)) {
        header("Location: login.html?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: login.html?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE fname =?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashed_pass = $row['pass'];

            if (password_verify($pass, $hashed_pass)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['planid'] = $row['planid'];
                $_SESSION['user_plan_status'] = $row['user_plan_status'];

                $purchase_sql = "SELECT * FROM purchases WHERE user_id =?";
                $purchase_stmt = mysqli_prepare($conn, $purchase_sql);
                mysqli_stmt_bind_param($purchase_stmt, "i", $row['purchase_id']);
                mysqli_stmt_execute($purchase_stmt);
                $purchase_result = mysqli_stmt_get_result($purchase_stmt);

                if (mysqli_num_rows($purchase_result) > 0) {
                    $purchase_row = mysqli_fetch_assoc($purchase_result);
                    $_SESSION['purchase_id'] = $purchase_row['purchase_id'];
                    $_SESSION['purchase_plan_id'] = $purchase_row['plan_id'];
                    $_SESSION['purchase_date'] = $purchase_row['purchase_date'];
                    $_SESSION['plan_end_date'] = $purchase_row['plan_end_date'];
                }

                // Retrieve data from plans table
                $plans_sql = "SELECT * FROM plans WHERE planid =?";
                $plans_stmt = mysqli_prepare($conn, $plans_sql);
                mysqli_stmt_bind_param($plans_stmt, "i", $row['planid']);
                mysqli_stmt_execute($plans_stmt);
                $plans_result = mysqli_stmt_get_result($plans_stmt);

                if (mysqli_num_rows($plans_result) > 0) {
                    $plans_row = mysqli_fetch_assoc($plans_result);
                    $_SESSION['plan_name'] = $plans_row['plan_name'];
                    $_SESSION['plan_description'] = $plans_row['description'];
                    $_SESSION['schedule'] = $plans_row['schedule'];
                    $_SESSION['trainer_id'] = $plans_row['trainer_id'];
                }

                $trainer_sql = "SELECT * FROM trainers WHERE id =?";
                $trainer_stmt = mysqli_prepare($conn, $trainer_sql);
                mysqli_stmt_bind_param($trainer_stmt, "i", $row['id']);
                mysqli_stmt_execute($trainer_stmt);
                $trainer_result = mysqli_stmt_get_result($trainer_stmt);

                if (mysqli_num_rows($trainer_result) > 0) {
                    $_SESSION['name'] = $trainer_row['name'];

                }

                header("Location: ui.php");
                exit();
            } else {
                header("Location: login.html?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: login.html?error=User not found");
            exit();
        }
    }
} else {
    header("Location: index.html");
    exit();
}
