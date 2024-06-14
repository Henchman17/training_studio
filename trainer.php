<?php
session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['trainer_id'];
    $name = $_POST['trainer_name'];
    $rate = $_POST['rate'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $certification = $_POST['certification'];
    $specialization = $_POST['specialization'];

    $qry = $conn->prepare("UPDATE trainers SET name=?, rate=?, email=?, phone=?, certification=?, specialization=? WHERE id=?");
    $qry->bind_param("sissssi", $name, $rate, $email, $phone, $certification, $specialization, $id);

    if ($qry->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit();
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
<body>
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
    <br><br><br><br>

    <div class="image-overlay header-text">
        <div class="container">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Trainer Name</th>
                        <th>Rate</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Certification</th>
                        <th>Specialization</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $conn->query("SELECT * FROM trainers WHERE archived = 0");
                    while ($row = $query->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['rate']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['certification']; ?></td>
                        <td><?php echo $row['specialization']; ?></td>
                        <td>
                            <button class="edit-btn" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#edit-modal">Edit</button>
                            <button><a href="archive_train.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to archive this Trainer?')">Archive</a></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button class="btn btn-success" data-toggle="modal" data-target="#add-modal">Add Trainers</button>  
        </div>
    </div>

    <br><br>
    <h3>Archived Trainers</h3>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Trainer Name</th>
        <th>Rate</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Certification</th>
        <th>Specialization</th>
        <th>Action</th>
    </tr>
    <?php

    $query = $conn->query("SELECT * FROM trainers WHERE archived = 1");
    while($row = $query->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['rate']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['certification']; ?></td>
        <td><?php echo $row['specialization']; ?></td>
        <td>
            <button class="restore-btn" data-id="<?php echo $row['id']; ?>">Restore</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>


    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Trainer Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-trainer-form" method="post">
                        <input type="hidden" name="trainer_id" id="edit-trainerid">
                        <div class="form-group">
                            <label for="edit-trainername">Trainer Name:</label>
                            <input type="text" class="form-control" name="trainer_name" id="edit-trainername">
                        </div>
                        <div class="form-group">
                            <label for="edit-rate">Rate:</label>
                            <input type="number" class="form-control" name="rate" id="edit-rate">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email:</label>
                            <input type="email" class="form-control" name="email" id="edit-email">
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" id="edit-phone">
                        </div>
                        <div class="form-group">
                            <label for="edit-certification">Certification:</label>
                            <textarea class="form-control" name="certification" id="edit-certification"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-specialization">Specialization:</label>
                            <textarea class="form-control" name="specialization" id="edit-specialization"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Trainer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_trainer.php" method="post">
                        <div class="form-group">
                            <label for="add-trainerid">Trainer ID:</label>
                            <input type="number" class="form-control" name="id" id="add-trainerid">
                        </div>
                        <div class="form-group">
                            <label for="add-trainername">Trainer Name:</label>
                            <input type="text" class="form-control" name="trainer_name" id="add-trainername">
                        </div>
                        <div class="form-group">
                            <label for="add-rate">Rate:</label>
                            <input type="number" class="form-control" name="rate" id="add-rate">
                        </div>
                        <div class="form-group">
                            <label for="add-email">Email:</label>
                            <input type="email" class="form-control" name="email" id="add-email">
                        </div>
                        <div class="form-group">
                            <label for="add-phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" id="add-phone">
                        </div>
                        <div class="form-group">
                            <label for="add-certification">Certification:</label>
                            <textarea class="form-control" name="certification" id="add-certification"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add-specialization">Specialization:</label>
                            <textarea class="form-control" name="specialization" id="add-specialization"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editBtns = document.querySelectorAll('.edit-btn');

                editBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var trainerId = this.getAttribute('data-id');

                        fetch('get_trainer_data.php?id=' + trainerId)
                            .then(response => response.json())
                            .then(trainerData => {
                                if (trainerData.error) {
                                    alert(trainerData.error);
                                } else {
                                    document.getElementById('edit-trainerid').value = trainerData.id;
                                    document.getElementById('edit-trainername').value = trainerData.name;
                                    document.getElementById('edit-rate').value = trainerData.rate;
                                    document.getElementById('edit-email').value = trainerData.email;
                                    document.getElementById('edit-phone').value = trainerData.phone;
                                    document.getElementById('edit-certification').value = trainerData.certification;
                                    document.getElementById('edit-specialization').value = trainerData.specialization;
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching trainer data:', error);
                            });

                        $('#edit-modal').modal('show');
                    });
                });

                document.getElementById('edit-trainer-form').addEventListener('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Trainer data updated successfully!');
                            $('#edit-modal').modal('hide');
                            location.reload();
                        } else {
                            alert('Error updating trainer data: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating trainer:', error);
                    });
                });
            });

        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout').submit();
            }
        }
    </script>
    <script>
    // Get all the restore buttons
    var restoreBtns = document.querySelectorAll('.restore-btn');

restoreBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        var trainerId = this.getAttribute('data-id');

        if (confirm('Are you sure you want to restore this trainer?')) {
            fetch('restore_trainer.php?id=' + trainerId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Trainer restored successfully!');
                        location.reload();
                    } else {
                        alert('Error restoring trainer: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error restoring trainer:', error);
                });
        }
    });
});
</script>
</body>
</html>
