<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donor Assignment List</title>
    <link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
    <style type="text/css">
        td {
            width: 200px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div id="full">
        <div id="inner_full">
            <div id="header">
                <h2 class="header-title">Blood Bank Management System</h2>
                <div class="header-right">
                    <a href="admin-home.php" class="home">Home</a>
                    <a href="logout.php" class="logout-button">Logout</a>
                </div>
            </div>
            <div id="body">
                <br>
                <?php
                $un = $_SESSION['un'];
                if (!$un) {
                    header("Location:index.php");
                    exit();
                }
                ?>
                <h1 style="color: #980002;">Donor Assignment List</h1><br>
                <div id="alist">
                    <table>
                        <tr id="ttitle">
                            <td>Donor Name</td>
                            <td>Recipient Name</td>
                            <td>Blood Group</td>
                            <td>Assigned Quantity</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <?php
                        try {
                            $q = $db->query("SELECT donor.name AS donor_name, recipient.name AS recipient_name, recipient.bgroup, donor_recipient_assignment.assigned_quantity, donor_recipient_assignment.id, donor_recipient_assignment.status
                                             FROM donor_recipient_assignment
                                             JOIN donor_registration AS donor ON donor.id = donor_recipient_assignment.donor_id
                                             JOIN recipent_registration AS recipient ON recipient.id = donor_recipient_assignment.recipient_id");
                            while ($row = $q->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>
                                    <td>{$row->donor_name}</td>
                                    <td>{$row->recipient_name}</td>
                                    <td>{$row->bgroup}</td>
                                    <td>{$row->assigned_quantity}</td>
                                    <td>{$row->status}</td>";

                                if ($row->status == 'pending') {
                                    echo "<td>
                                            <a href='assign_list.php?action=done&id={$row->id}'>Done</a> | 
                                            <a href='assign_list.php?action=cancel&id={$row->id}&bgroup={$row->bgroup}&quantity={$row->assigned_quantity}'>Cancel</a>
                                          </td>";
                                } 
                                
                                echo "<td><a href='delete_assign_list.php?id={$row->id}' onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='6'>Error: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div id="footer">
                <h4 align="center">&copy; EHETISUM SHARIF</h4>
            </div>
        </div>
    </div>

    <?php
    // Handle Done and Cancel actions
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $assignment_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$assignment_id) {
            echo "<script>alert('Invalid assignment ID.'); window.location='assign_list.php';</script>";
            exit();
        }

        try {
            $db->beginTransaction();

            if ($action == 'done') {
                // Mark assignment as completed
                $stmt = $db->prepare("UPDATE donor_recipient_assignment SET status = 'completed' WHERE id = :id");
                $stmt->bindParam(':id', $assignment_id);
                $stmt->execute();
                $db->commit();

                echo "<script>alert('Assignment marked as completed.'); window.location='assign_list.php';</script>";

            } elseif ($action == 'cancel') {
                $bgroup = filter_input(INPUT_GET, 'bgroup', FILTER_SANITIZE_STRING);
                $quantity = filter_input(INPUT_GET, 'quantity', FILTER_VALIDATE_INT);

                if (!$bgroup || !$quantity) {
                    echo "<script>alert('Invalid blood group or quantity.'); window.location='assign_list.php';</script>";
                    exit();
                }

                // Mark assignment as canceled
                $stmt = $db->prepare("UPDATE donor_recipient_assignment SET status = 'canceled' WHERE id = :id");
                $stmt->bindParam(':id', $assignment_id);
                $stmt->execute();

                // Restock the blood group
               $updateStock = $db->prepare("UPDATE blood_stock SET quantity = quantity + :quantity WHERE bgroup = :bgroup");
			   $updateStock->bindValue(':quantity', $quantity, PDO::PARAM_INT);  
			   $updateStock->bindValue(':bgroup', $bgroup, PDO::PARAM_STR);     
			   $updateStock->execute();


                $db->commit();

                echo "<script>alert('Assignment canceled and blood restocked.'); window.location='assign_list.php';</script>";

            } else {
                $db->rollBack();
                echo "<script>alert('Invalid action.'); window.location='assign_list.php';</script>";
            }

        } catch (Exception $e) {
            $db->rollBack();
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location='assign_list.php';</script>";
        }
    }
    ?>
</body>
</html>
