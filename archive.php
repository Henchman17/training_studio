

<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update the archived status to 1 for the given user
    $sql = "UPDATE users SET archived = 1 WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the member management page
        header("Location: manage_member.php?page=members");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

