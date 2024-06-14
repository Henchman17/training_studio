<?php
session_start();    
include 'conn.php';
include 'functions.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Validate required POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['plan_id']) || !isset($_POST['num_months']) || !isset($_POST['payment_method'])) {
        die("Error: Missing required form data.");
    }

    // Your purchase logic here...
    $plan_id = $_POST['plan_id'];
    $num_months = $_POST['num_months'];
    $payment_method = $_POST['payment_method'];

    // Get the currently logged-in user's ID
    $query = "SELECT id FROM users WHERE fname = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['fname']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    } else {
        echo "Error: Unable to retrieve user ID";
        exit;
    }

    $stmt->close();

    // Check if the plan ID is valid
    $plan_query = "SELECT * FROM plans WHERE planid = ?";
    $stmt = $conn->prepare($plan_query);
    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    if ($plan_result->num_rows > 0) {
        $plan_row = $plan_result->fetch_assoc();
        $plan_Amount = $plan_row['amount'];
    } else {
        echo "Invalid plan ID";
        exit;
    }

    $stmt->close();

    $purchase_amount = $plan_Amount * $num_months;

    // Generate a unique purchase ID
    $purchase_id = uniqid();

    // Check if the generated purchase ID already exists
    $query_check_duplicate = "SELECT purchase_id FROM purchases WHERE purchase_id = ?";
    $stmt_check_duplicate = $conn->prepare($query_check_duplicate);
    $stmt_check_duplicate->bind_param("s", $purchase_id);
    $stmt_check_duplicate->execute();
    $result_check_duplicate = $stmt_check_duplicate->get_result();
    
    // If a duplicate purchase ID is found, regenerate the ID
    while ($result_check_duplicate->num_rows > 0) {
        $purchase_id = uniqid();
        $stmt_check_duplicate->bind_param("s", $purchase_id);
        $stmt_check_duplicate->execute();
        $result_check_duplicate = $stmt_check_duplicate->get_result();
    }
    
    $stmt_check_duplicate->close();

    $purchase_date = date("Y-m-d H:i:s");

    // Compute the start and end dates
    $plan_start_date = date("Y-m-d", strtotime($purchase_date));
    $plan_end_date = date("Y-m-d", strtotime($purchase_date . " + $num_months months"));

    // Insert the new purchase record
    $query = "INSERT INTO purchases (purchase_id, user_id, plan_id, purchase_date, purchase_amount, payment_method, plan_start_date, plan_end_date)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siisdsss", $purchase_id, $user_id, $plan_id, $purchase_date, $purchase_amount, $payment_method, $plan_start_date, $plan_end_date);

    if ($stmt->execute()) {
        $purchase_info = "Purchase record created successfully";
        // Generate the modal HTML
        $modal_html = '<br><br><br><br><div id="modal" style="display: block; background-color: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
            <h2 style="text-align: center;">Purchase Confirmation</h2>
            <p style="text-align: center;">Purchase ID: '. $purchase_id. '</p>
            <p style="text-align: center;">Plan ID: '. $plan_id. '</p>
            <p style="text-align: center;">Purchase Amount: '. $purchase_amount. '</p>
            <p style="text-align: center;">Purchase Date: '. $purchase_date. '</p>
            <p style="text-align: center;">Plan End Date: '. $plan_end_date. '</p>
            <button id="close-modal" onclick="closeModalAndRedirect();">Close</button>
        </div>';
    
        // Output the modal HTML
        echo $modal_html;
    } else {
        echo "Error: ". $stmt->error;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Plan</title>
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
<body>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="ui.php" class="logo">FlexFit<em> Center</em></a>
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="ui.php" class="active">Home</a></li>
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
<br><br><br><br>

<div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body bg-gradient">
                    <div class="card-body text-black">
    <h1>Purchase Plan</h1>
    <form id="purchase-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="plan_id">Plan ID:</label>
    <select id="plan_id" name="plan_id" required>
    <?php
    // Query the plans database
    $plans_query = "SELECT planid, plan_name, amount FROM plans";
    $plans_result = mysqli_query($conn, $plans_query);

    // Loop through the results and generate options
    while ($plan = mysqli_fetch_assoc($plans_result)) {
        echo "<option value='". $plan['planid']. "'>". $plan['planid']. " - ". $plan['plan_name']. " - ". $plan['amount']."</option>";
    }
   ?>
</select>
    <br><br>
    <label for="num_months">Number of Months:</label>
    <input type="number" id="num_months" name="num_months" required>
    <br><br>
    <label for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method" required>
        <option value="Credit Card">Credit Card</option>
        <option value="Debit Card">Debit Card</option>
        <option value="Cash">Cash</option>
    </select>
    <br><br>
    <button type="submit">Confirm Purchase</button>
</form>
    </div>
    </div>
    </div>
    </div>
    </div>


</body>
<footer style="position: fixed; bottom: 0; width: 100%; background-color: white;">
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

<script>
    // Get the modal element
    var modal = document.getElementById('modal');

    // Add an event listener to the close button
    document.getElementById('close-modal').addEventListener('click', function() {
        // Close the modal
        modal.style.display = 'none';
    });

    // Show the modal
    modal.style.display = 'block';
</script>

<script>
  function closeModalAndRedirect() {
    // Close the modal
    document.getElementById('modal').style.display = 'none';
    // Redirect to ui.php
    window.location.href = 'ui.php';
  }
</script>



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

</html>