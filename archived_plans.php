<?php
session_start();
include 'conn.php';

$query = $conn->query("SELECT * FROM plans WHERE archived = 1");
?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Plan Name</th>
            <th>Schedule</th>
            <th>Plan Validity</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Trainer ID</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $query->fetch_assoc()):?>
        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['plan_name'];?></td>
            <td><?php echo $row['schedule'];?></td>
            <td><?php echo $row['plan_validity'];?></td>
            <td><?php echo $row['amount'];?></td>
            <td><?php echo $row['description'];?></td>
            <td><?php echo $row['trainer_id'];?></td>
        </tr>
        <?php endwhile;?>
    </tbody>
</table>

<form>
    <input type="button" value="Go Back" onclick="window.location.href='plans.php'">
</form>
