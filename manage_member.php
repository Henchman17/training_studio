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

    <link rel="stylesheet" href="assets/css/low.css">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-training-studio.css">

    <style>
        html, body {
            background-image: url('assets/images/fitness.jpg');
            background-size: cover;
        }
        table {
                margin: auto; /* Center the table */
                width: 90%;
                border-collapse: collapse;
            }

        th, td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f57220;
            color: white;
        }
        tr {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
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
                      <li class="scroll-to-section"><a href="dashboard.php?page=home" class="active">Home</a></li>
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

<br><br><br><br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>
    <?php

    $query = $conn->query("SELECT * FROM users WHERE archived = 0");
    while($row = $query->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <button class="edit-btn" data-id="<?php echo $row['id']; ?>">Edit</button>
            <button><a href="archive.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to archive this user?')">Archive</a></button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<br><br>
<h3>Archived Users</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>
    <?php

    $query = $conn->query("SELECT * FROM users WHERE archived = 1");
    while($row = $query->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <button class="restore-btn" data-id="<?php echo $row['id']; ?>">Restore</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

    <!-- Modal window for editing -->
    <div class="modal" id="edit-modal">
        <div class="modal-content">
            <h2>Edit User</h2>
            <form action="" method="post" id="edit-form">
                <input type="hidden" name="id" id="edit-id">
                <label>First Name:</label>
                <input type="text" name="fname" id="edit-fname"><br><br>
                <label>Email:</label>
                <input type="email" name="email" id="edit-email"><br><br>
                <label>Phone:</label>
                <input type="text" name="phone" id="edit-phone"><br><br>
                <input type="submit" name="submit" value="Update">
            </form>
        </div>
    </div>

    <script>
  var modal = document.getElementById('edit-modal');

// Get the edit buttons
var editBtns = document.querySelectorAll('.edit-btn');

// Add event listener to each edit button
editBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Get the user ID from the button's data attribute
        var userId = this.getAttribute('data-id');

        // Populate the modal form with the user data
        fetch('get_user_data.php?id=' + userId)
         .then(response => response.json())
         .then(userData => {
            document.getElementById('edit-id').value = userData.id;
            document.getElementById('edit-fname').value = userData.fname;
            document.getElementById('edit-email').value = userData.email;
            document.getElementById('edit-phone').value = userData.phone;
        });

        // Show the modal
        modal.style.display = 'block';
    });
});

// Add event listener to the modal's close button
document.getElementById('edit-modal-close').addEventListener('click', function() {
    modal.style.display = 'none';
});

// Add event listener to the form's submit button
document.getElementById('edit-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get the form data
    var formData = new FormData(this);

    // Send the form data to the server
    fetch('update_user_data.php', {
        method: 'POST',
        body: formData
    })
     .then(response => response.json())
     .then(data => {
        if (data.success) {
            alert('User data updated successfully!');
            modal.style.display = 'none';
            // Refresh the page to reflect the changes
            location.reload();
        } else {
            alert('Error updating user data: ' + data.error);
        }
    });
});
</script>

    <script>
        // Get all the restore buttons
        const restoreBtns = document.querySelectorAll('.restore-btn');

        // Add event listener to each restore button
        restoreBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Get the user ID from the button's data attribute
                const userId = btn.getAttribute('data-id');

                // Send a request to restore the user
                fetch('restore_user.php?id=' + userId)
                    .then(response => {
                        if (response.ok) {
                            // Refresh the page to reflect the changes
                            location.reload();
                        } else {
                            alert('Error restoring user.');
                        }
                    });
            });
        });
    </script>


    </div>
    </div>

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