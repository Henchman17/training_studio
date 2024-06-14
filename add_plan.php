
<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $planid = $_POST['planid'];
    $plan_name = $_POST['planname'];
    $schedule = $_POST['schedule'];
    $amount = $_POST['amount'];
    $plan_validity = $_POST['planvalidity'];
    $description = $_POST['description'];
    $trainer_id = $_POST['trainerid'];

    $stmt = $conn->prepare("INSERT INTO plans (planid, plan_name, schedule,plan_validity, amount,  description, trainer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiss", $planid, $plan_name, $schedule, $plan_validity, $amount,  $description, $trainer_id);

    if ($stmt->execute()) {
        header('Location: plans.php');
        exit();
    } else {
        echo "Error adding new plan: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}


$conn->close();


?>