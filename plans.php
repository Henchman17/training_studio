<?php
session_start();
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
        html, body {
            background-image: url('assets/images/fitness.jpg');
            background-size: cover;
        }
        table {
                margin: auto; /* Center the table */
                width: 100%;
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
                    <th>Plan Name</th>
                    <th>Schedule</th>
                    <th>Plan Validity</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Trainer ID</th>
                    <th>Action</th>
                </tr>
                <?php
                include 'conn.php'; 
                $query = $conn->query("SELECT * FROM plans WHERE archived = 0");
                while($row = $query->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['planid']; ?></td>
                    <td><?php echo $row['plan_name']; ?></td>
                    <td><?php echo $row['schedule']; ?></td>
                    <td><?php echo $row['plan_validity']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['trainer_id']; ?></td>
                    <td>
                        <button class="edit-btn" data-id="<?php echo $row['planid']; ?>" data-toggle="modal" data-target="#edit-modal">Edit</button>
                        <button><a href="archive_plan.php?id=<?php echo $row['planid']; ?>" onclick="return confirm('Are you sure you want to archive this plan?')">Archive</a></button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <button class="btn btn-success" data-toggle="modal" data-target="#add-modal">Add Plan</button> 

<!-- Modal window for editing -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-plan-form" action="update_plan.php" method="post">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-planname">Plan Name:</label>
                        <input type="text" class="form-control" name="planname" id="edit-planname">
                    </div>
                    <div class="form-group">
                        <label for="edit-schedule">Schedule:</label>
                        <textarea class="form-control" name="schedule" id="edit-schedule"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-planvalidity">Plan Validity:</label>
                        <input type="text" class="form-control" name="planvalidity" id="edit-planvalidity">
                    </div>
                    <div class="form-group">
                        <label for="edit-rate">Amount:</label>
                        <input type="number" class="form-control" name="amount" id="edit-amount">
                    </div>
                    <div class="form-group">
                        <label for="edit-description">Description:</label>
                        <textarea class="form-control" name="description" id="edit-description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-trainerid">Trainer ID:</label>
                        <input type="text" class="form-control" name="trainerid" id="edit-trainerid">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

            <!-- Modal window for adding a new plan -->
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="add_plan.php" method="post">
                            <div class="form-group">
                                <label for="add-planid">Plan ID:</label>
                                <input type="number" class="form-control" name="planid" id="add-planid" required>
                            </div>
                            <div class="form-group">
                                <label for="add-planname">Plan Name:</label>
                                <input type="text" class="form-control" name="planname" id="add-planname" required>
                            </div>
                            <div class="form-group">
                                <label for="add-schedule">Schedule:</label>
                                <textarea class="form-control" name="schedule" id="add-schedule" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="add-planvalidity">Plan Validity:</label>
                                <input type="text" class="form-control" name="planvalidity" id="add-planvalidity" required>
                            </div>  
                            <div class="form-group">
                                <label for="add-amount">Amount:</label>
                                <input type="number" class="form-control" name="amount" id="add-amount" required>
                            </div>
                            <div class="form-group">
                                <label for="add-description">Description:</label>
                                <textarea class="form-control" name="description" id="add-description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="add-trainerid">Trainer ID:</label>
                                <input type="text" class="form-control" name="trainerid" id="add-trainerid" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page for archived plans -->
        <div class="container">
            <h2>Archived Plans</h2>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Plan Name</th>
                    <th>Schedule</th>
                    <th>Plan Validity</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Trainer ID</th>
                    <th>Action</th>
                </tr>
                <?php
                include 'conn.php'; 
                $query = $conn->query("SELECT * FROM plans WHERE archived = 1");
                while($row = $query->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['planid']; ?></td>
                    <td><?php echo $row['plan_name']; ?></td>
                    <td><?php echo $row['schedule']; ?></td>
                    <td><?php echo $row['plan_validity']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['trainer_id']; ?></td>
                    <td>
                        <button><a href="restore_plan.php?id=<?php echo $row['planid']; ?>" onclick="return confirm('Are you sure you want to restore this plan?')">Restore</a></button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
  var editBtns = document.querySelectorAll('.edit-btn');

  editBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var planId = this.getAttribute('data-id');

      fetch('get_plan_data.php?id=' + planId)
        .then(response => response.json())
        .then(planData => {
          if (planData.error) {
            alert(planData.error);
          } else {
            document.getElementById('edit-id').value = planData.id;
            document.getElementById('edit-planname').value = planData.name;
            document.getElementById('edit-schedule').value = planData.schedule;
            document.getElementById('edit-planvalidity').value = planData.plan_validity;
            document.getElementById('edit-amount').value = planData.amount;
            document.getElementById('edit-description').value = planData.description;
            document.getElementById('edit-trainerid').value = planData.trainer_id;
          }
        })
        .catch(error => {
          console.error('Error fetching plan data:', error);
        });

      $('#edit-modal').modal('show');
    });
  });

  document.getElementById('edit-plan-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('update_plan.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Plan data updated successfully!');
        $('#edit-modal').modal('hide');
        location.reload();
      } else {
        alert('Error updating plan data: ' + data.error);
      }
    })
    .catch(error => {
      console.error('Error updating plan:', error);
    });
  });
});
        

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                document.forms["logout"].submit();
            }
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
    
    <!-- GlobalInit -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/side.js"></script>
</body>
</html>