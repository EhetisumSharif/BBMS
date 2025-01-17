<?php
include('connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Prepare the delete query
        $stmt = $db->prepare("DELETE FROM donor_recipient_assignment WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirect back to the assignment list after deletion
        header("Location: assign_list.php"); 
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
