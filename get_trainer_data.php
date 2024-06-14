<?php
include 'conn.php';

if(isset($_GET['id'])){
    $trainerId = $_GET['id'];
    $qry = $conn->prepare("SELECT * FROM trainers WHERE id=?");
    $qry->bind_param("i", $trainerId);
    $qry->execute();
    $result = $qry->get_result();
    
    if($result->num_rows > 0){
        $trainerData = $result->fetch_assoc();
        echo json_encode($trainerData);
    } else {
        echo json_encode(['error' => 'No record found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>
