<?php
session_start();

include 'conn.php';

$user_id = $_SESSION['id'];

$query = "SELECT p.plan_id, p.plan_end_date, pl.plan_name, pl.schedule, t.name 
           FROM purchases p 
           JOIN plans pl ON p.plan_id = pl.planid 
           JOIN trainers t ON pl.trainer_id = t.id 
           WHERE p.user_id = '$user_id' 
           AND p.plan_id = (SELECT MAX(planid) FROM purchases WHERE user_id = '$user_id')";
$result = mysqli_query($conn, $query);

$plan_details = mysqli_fetch_assoc($result);


?>

<!doctype html>
<html lang="en">
<head>
    <title>FlexFit Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/side.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-training-studio.css">
    <style>
        html{
            background-image: url('assets/images/fitness.jpg');
            background-size: cover;
        }

        body {
            background-image: url('assets/images/fitness.jpg');
            background-size: cover;
        }

        .card{
            text-align: center;
        }

        .email{
            text-align: left;
        }
        .email_1{
            
        }
    </style>
</head>

<body>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="ui.php" class="logo">FlexFit<em> Center</em></a>
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="ui.php" class="active">Home</a></li>
                        <li><a href="schedule copy.php?page=schedule" class="nav-item nav-schedule"><span class='icon-field'><i class="fa fa-calendar"></i></span> Schedule</a></li>
                        <li>
                            <form method="post" action="logout.php" id="logout">
                                <button type="button" class="btn btn-danger" onclick="confirmLogout()">Logout</button>
                            </form>
                        </li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<br><br><br>

<div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body bg-gradient">
                    <div class="card-body text-black">
                        <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                        <h4><b>My Profile</b></h4>
                        <?php
                        if (isset($_SESSION['fname'])) {
                            echo "<p>Email: " . $_SESSION['email'] . "</p>";
                            echo "<p>Phone: " . $_SESSION['phone'] . "</p>";
                            if (isset($_SESSION['user_plan_status'])) {
                                echo "<p>Plan Status: " . $_SESSION['user_plan_status'] ."</p>";
                            } else {
                                echo "<p>No active plan selected.</p>";
                            }
                            if (isset($plan_details)) {
                                echo "<p>Plan: ". $plan_details['plan_name']. "</p>";
                                echo "<p>Schedule: ". $plan_details['schedule']. "</p>";
                                echo "<p>Trainer: ". $plan_details['name']. "</p>";
                                echo "<p>Plan End Date: ". $plan_details['plan_end_date']. "</p>";
                            } else {
                                echo "<p>No active plan selected.</p>";
                            }
                        } else {
                            // Display login or signup form
                            echo "<p>Please login or signup to view your profile.</p>";
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <div class="card-body bg-gradient">
                    <div class="card-body text-black">
                        <span class="float-right summary_icon"><i class="fa fa-th-list"></i></span>
                        <h4><b>Purchase Plan</b></h4>
                        <button type="button" class="btn btn-primary" onclick="redirectToPurchase()">Purchase Plan</button>
                    </div>
                </div>
                <hr>
                <div class="card-body bg-gradient">
                    <div class="card-body text-black">
                        <p><strong>Costumer Service</strong></p>
                        <p class="email"><b>If you have any questions or need assistance, our support team is here to help. Reach out to us at <a href=https://mail.google.com>FlexFitCenter@gmail.com</a><br>         
                                    Thank you for choosing FlexFit Center! We’re here to support you on your fitness journey.</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<footer style="background-color: white; position: fixed; bottom: 0; width: 100%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>
                    Copyright &copy; 2024 FlexFit Center - Designed by
                    <a rel="nofollow" href="" class="tm-text-link" target="_parent">DeCode</a><br>
                    Distributed by
                    <a rel="nofollow" href="" class="tm-text-link" target="_blank">DeCode</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="assets/js/jquery-2.1.0.min.js"></script>
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="assets/js/popper.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Plugins -->
<script src="assets/js/scrollreveal.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/imgfix.min.js"></script>
<script src="assets/js/mixitup.js"></script>
<script src="assets/js/accordions.js"></script>

<!-- Global Init -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/side.js"></script>

<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            document.forms["logout"].submit();
        }
    }
</script>

<script>
    function redirectToPurchase() {
        window.location.href = "purchase.php";
    }
</script>



