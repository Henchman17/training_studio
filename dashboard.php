<?php
session_start();

include 'functions.php';
include 'conn.php';

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

    <link rel="stylesheet" href="assets/css/low.css">

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

        .name{
            text-align: center;
        }

        .card{
            text-align: center;
        }

        .text-color {
        color: black;
        font-size: 18px;
        text-align: center;
        } 
        .color {
            color: black;
        }
    </style>
	</head>
<header class="header-area header-sticky">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <nav class="main-nav">
                  <a href="index.html" class="logo">FlexFit<em> Center</em></a>
                  <ul class="nav">
                      <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                      <li><a href="manage_member.php?page=members" class="nav-item nav-members"><span class='icon-field'><i class="fa fa-users"></i></span> Members</a></li>
                      <li><a href="schedule.php?page=schedule" class="nav-item nav-schedule"><span class='icon-field'><i class="fa fa-calendar"></i></span> Schedule</a></li>
                      <li><a href="plans.php?page=plans" class="nav-item nav-plans"><span class='icon-field'><i class="fa fa-th-list"></i></span> Plans</a></li>
                      <li><a href="trainer.php?page=trainer" class="nav-item nav-trainer"><span class='icon-field'><i class="fa fa-user"></i></span> Trainers</a></li>
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
<body>
   <!-- <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
     <span class="dot"></span>
          <div class="dots">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
      </div> -->
      <div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-md-10 mx-auto">
            <br><br><br><br><br>
            <div class="card">
                <div class="card-body">
                    <?php
                    $username = $_SESSION['adname'];
                   ?>
                    <h3 class="name"><strong>Welcome back </strong> <?php echo $username;?></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-danger">
                                        <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                        <h4><b>Member Profiles</b></h4>
                                        <p class="text-color"><b>Active Members: <?php echo getTotalUsers();?> </b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-danger">
                                        <span class="float-right summary_icon"><i class="fa fa-th-list"></i></span>
                                        <h4><b>Membership Plans</b></h4>
                                        <p class="text-color"><b>Active Plans: <?php echo getTotalActivePlans();?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-danger">
                                        <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                        <h4><b>Trainers Profiles</b></h4>
                                        <p class="text-color"><b>Active Trainers: <?php echo getTotalTrainers();?> </b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-10 mx-auto mb-4"> 
                        <div class="card">
                            <div class="card-body bg-info">
                                <div class="card-body text-danger">
                                    <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                    <h4><b>General Reports</b></h4>
                                    <br>
                                    <p class="text-color">Current Month: <b><?php echo date('F');?></b></p>
                                    <p class="text-color">Total Purchases: <br>


                                  <!--  <form method="post">
                                        <div class="form-group">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Get Report</button>
                                    </form> -->


                                    <?php
                                    $results = getTotalPurchaseAmount();

                                 

                                    echo "<strong>Current Month: ". htmlspecialchars($results['current_month'] ?? 'Not available'). "</strong><br>";
                                    echo "<strong>Current Quarter: ". htmlspecialchars($results['current_quarter'] ?? 'Not available'). "</strong><br>";
                                    echo "<strong>Current Year: ". htmlspecialchars($results['current_year'] ?? 'Not available'). "</strong><br>";
                                    echo "<strong>All Time: ". htmlspecialchars($results['all_time'] ?? 'Not available'). "</strong><br>";

                                    ?>
                                    <br>
                                    <h4><b> Get Your Report History</b> </h4>

                                        <form method="post">
                                        <div class="form-group">
                                            <label class="color" for="start_date"><b>Start Date:</b></label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="color" for="end_date"><b>End Date:</b></label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Get Report</button>
                                    </form>

                                    <?php
                                    $results = getTotalPurchaseAmount();


                                    $start_date = $_POST['start_date'] ?? null; // Get start date from date picker
                                    $end_date = $_POST['end_date'] ?? null; // Get end date from date picker

                                    if ($start_date && $end_date) {
                                        $specific_date_range_results = getTotalPurchaseAmountByDateRange($conn, $start_date, $end_date);
                                        echo "<strong>Total Amount ({$start_date} - {$end_date}): ". htmlspecialchars($specific_date_range_results['total_amount'] ?? 'Not available'). "</strong>";
                                    } else {
                                        echo "Total Amount ( - ): Not available";
                                    }
                                    ?>


                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	       
                </div>
            </div>
        </div>
    </div>   			

</body>

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

	</body>
</html>
