<?php 
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donor</title>
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
                <h1 style="color: #980002;">Donor List</h1><br>
                <div id="list">
                    <table>
                        <tr id="ttitle">
                            <td>Name</td>
                            <td>Father's Name</td>
                            <td>Address</td>
                            <td>Gender</td>
                            <td>Age</td>
                            <td>Blood Group</td>
                            <td>E-Mail</td>
                            <td>Phone no</td>
                            <td>Donation Status</td>
                            <td>Action</td>
                        </tr>
                        <?php
                        try {
                            $q = $db->query("SELECT donor_registration.*, 
                                            (CASE 
                                                WHEN EXISTS (SELECT 1 FROM donor_recipient_assignment WHERE donor_recipient_assignment.donor_id = donor_registration.id AND donor_recipient_assignment.status = 'completed') 
                                                THEN 'Donated' 
                                                ELSE 'Not Donated' 
                                            END) AS donation_status
                                            FROM donor_registration");
                            while ($r1 = $q->fetch(PDO::FETCH_OBJ)) {
                                // Check donation status and update blood stock if needed
                                if ($r1->donation_status == 'Donated') {
                                    // Remove blood from stock (example: decrease the count of blood for the donor's blood group)
                                    $updateStock = $db->prepare("UPDATE blood_stock SET quantity = quantity - 1 WHERE bgroup = ?");
                                    $updateStock->execute([$r1->bgroup]);
                                }
                                
                                echo "<tr>
                                    <td>{$r1->name}</td>
                                    <td>{$r1->fname}</td>
                                    <td>{$r1->address}</td>
                                    <td>{$r1->gender}</td>
                                    <td>{$r1->age}</td>
                                    <td>{$r1->bgroup}</td>
                                    <td>{$r1->email}</td>
                                    <td>{$r1->pno}</td>
                                    <td>{$r1->donation_status}</td>
                                    <td><a href='delete_donor.php?id={$r1->id}' onclick='return confirm(\"Are you sure you want to delete this donor?\");'>Delete</a></td>
                                </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='10'>Error: " . $e->getMessage() . "</td></tr>";
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
</body>
</html>
