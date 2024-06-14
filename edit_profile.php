<?php
session_start();

?>

<?php include 'conn.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM users where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

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
    </style>


	</head>

<header class="header-area header-sticky">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <nav class="main-nav">
                  <a href="ui.php" class="logo">FlexFit<em> Center</em></a>
                  <ul class="nav">
                      <li class="scroll-to-section"><a href="ui.php" class="active">Go Back</a></li>
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
                <h4><b>
                    Edit Profile
                </b></h4>
                <?php
                if (isset($_SESSION['fname'])) {
                    // Display user's profile information in editable form fields
                    echo "<form action='edit_profile.php' method='post'>";
                    echo "<label for='email'>Name:</label>";
                    echo "<input type='text' id='' name='name' value='" . $_SESSION['fname'] . "'><br><br>";
                    echo "<label for='email'>Email:</label>";
                    echo "<input type='email' id='email' name='email' value='" . $_SESSION['email'] . "'><br><br>";
                    echo "<label for='phone'>Phone:</label>";
                    echo "<input type='tel' id='phone' name='phone' value='" . $_SESSION['phone'] . "'><br><br>";
                    echo "<label for='planid'>Plan:</label>";
                    echo "<select id='planid' name='planid'>";
                    // Assuming you have a list of plans in an array or database
                    $plans = array('Plan 1', 'Plan 2', 'Plan 3');
                    foreach ($plans as $plan) {
                        echo "<option value='" . $plan . "'" . ($_SESSION['planid'] == $plan ? ' selected' : '') . ">" . $plan . "</option>";
                    }
                    echo "</select><br><br>";
                    echo "<input type='submit' class='btn btn-primary' value='Save Changes'>";
                    echo "</form>";
                } else {
                    // Display login or signup form
                    echo "<p>Please login or signup to view your profile.</p>";
                }
                ?>
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



<footer>
    <br><br><br>
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <p>Copyright &copy; 2024 FlexFit Center

                  - Designed by <a rel="nofollow" href="https://templatemo.com" class="tm-text-link"
                                   target="_parent">DeCode</a><br>

                  Distributed by <a rel="nofollow" href="https://themewagon.com" class="tm-text-link"
                                    target="_blank">DeCode</a>

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
	</body>
</html>