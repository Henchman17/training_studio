<?php

function getTotalUsers() {
    include 'conn.php';
    // Query to get the total number of users
    $query = "SELECT COUNT(*) as total_users FROM users";
    $result = mysqli_query($conn, $query);

    // Get the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_users = $row['total_users'];

    // Close the database connection
    mysqli_close($conn);

    return $total_users;
}

function getTotalActivePlans() {

    include 'conn.php';
    // Query to get the total number of users with active plans
    $query = "SELECT COUNT(*) as total_active_plans FROM plans";
    $result = mysqli_query($conn, $query);

    // Get the total number of users with active plans
    $row = mysqli_fetch_assoc($result);
    $total_active_plans = $row['total_active_plans'];

    // Close the database connection
    mysqli_close($conn);

    return $total_active_plans;
}

function getTotalTrainers() {


    include 'conn.php';
    $query = "SELECT COUNT(*) as total_trainers FROM trainers";
    $result = mysqli_query($conn, $query);

    // Get the total number of users with active plans
    $row = mysqli_fetch_assoc($result);
    $total_trainers = $row['total_trainers'];

    // Close the database connection
    mysqli_close($conn);

    return $total_trainers;
}

function getTotalPurchaseAmount() {

    include 'conn.php';

    // Current month
    $current_month_start = date('Y-m-01');
    $current_month_end = date('Y-m-t');
    $query = "SELECT SUM(purchase_amount) as total_amount 
              FROM purchases 
              WHERE DATE(purchase_date) BETWEEN '$current_month_start' AND '$current_month_end'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $current_month_total = $row['total_amount'];

    // Current quarter
    $current_quarter = ceil(date('n') / 3);
    $current_quarter_start = date('Y-m-d', mktime(0, 0, 0, ($current_quarter - 1) * 3 + 1, 1, date('Y')));
    $current_quarter_end = date('Y-m-t', mktime(0, 0, 0, $current_quarter * 3, 1, date('Y')));
    $query = "SELECT SUM(purchase_amount) as total_amount 
          FROM purchases 
          WHERE DATE(purchase_date) BETWEEN '$current_quarter_start' AND '$current_quarter_end'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $current_quarter_total = $row['total_amount'];

    // Current year
    $current_year_start = date('Y-01-01');
    $current_year_end = date('Y-12-31');
    $query = "SELECT SUM(purchase_amount) as total_amount 
              FROM purchases 
              WHERE DATE(purchase_date) BETWEEN '$current_year_start' AND '$current_year_end'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $current_year_total = $row['total_amount'];

    // All time
    $query = "SELECT SUM(purchase_amount) as total_amount 
              FROM purchases";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $all_time_total = $row['total_amount'];

    // Close the database connection
    mysqli_close($conn);

    return array(
        'current_month' => $current_month_total,
        'current_quarter' => $current_quarter_total,
        'current_year' => $current_year_total,
        'all_time' => $all_time_total
    );
}

function getPurchasesData() {

    include 'conn.php';

    // Get all purchases data
    $query = "SELECT * FROM purchases";
    $result = mysqli_query($conn, $query);

    $purchases_data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $purchases_data[] = $row;
    }

    // Close the database connection
    mysqli_close($conn);

    return $purchases_data;
}

function getTotalPurchaseAmountByDateRange($conn, $start_date, $end_date) {
    $query = "SELECT SUM(purchase_amount) as total_amount
              FROM purchases
              WHERE purchase_date >= '$start_date' AND purchase_date <= '$end_date'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}
?>