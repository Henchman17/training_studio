<?php
session_start();

include('conn.php');

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
   
            $sql = "SELECT * FROM admin WHERE adname =?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['adname'] = $row['adname'];

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
                    $_SESSION['purchase_amount'] = $purchase_row['purchase_amount'];
                }

                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: login.html?error=Incorrect User name or password");
                exit();
            }
        }
    } else {
    header("Location: index.html");
    exit();
}