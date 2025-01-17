<?php
include('connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $db->beginTransaction();
        
        $stmt1 = $db->prepare("DELETE FROM donor_recipient_assignment WHERE recipient_id = :id");
        $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt1->execute();
        
        $stmt2 = $db->prepare("DELETE FROM recipent_registration WHERE id = :id");
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt2->execute();
        $db->commit();
        
        header("Location: Recipient.php");  
        exit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
