<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipient</title>
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
                <h1 style="color: #980002;">Recipient List</h1><br>
                <div id="list">
                   <table>
                    <tr id="ttitle">
                        <td>Name</td>
                        <td>Age</td>
                        <td>Patient Problems</td>
                        <td>Blood Group</td>
                        <td>Required Quantity</td>
                        <td>Blood Received</td>
                        <td>Status</td>
                        <td>Place of Blood Donation</td>
                        <td>Time</td>
                        <td>Phone No</td>
                        <td>Action</td>
                    </tr>
                    <?php
                    try {
                        $q = $db->query("
                            SELECT rr.*, 
                                COALESCE(SUM(dra.assigned_quantity), 0) AS blood_received
                            FROM recipent_registration rr
                            LEFT JOIN donor_recipient_assignment dra 
                                ON rr.id = dra.recipient_id AND dra.status = 'completed'
                            GROUP BY rr.id
                        ");

                        while ($r1 = $q->fetch(PDO::FETCH_OBJ)) {
                           
                            $status = ($r1->blood_received >= $r1->quantity) ? 'Completed' : 'Pending';

                            echo "<tr>
                                <td>{$r1->name}</td>
                                <td>{$r1->age}</td>
                                <td>{$r1->problems}</td>
                                <td>{$r1->bgroup}</td>
                                <td>{$r1->quantity}</td>
                                <td>{$r1->blood_received}</td>
                                <td>{$status}</td>
                                <td>{$r1->place}</td>
                                <td>{$r1->time}</td>
                                <td>{$r1->pno}</td>
                                <td><a href='delete_recipient.php?id={$r1->id}' onclick='return confirm(\"Are you sure you want to delete this recipient?\");'>Delete</a></td>
                            </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='11'>Error: " . $e->getMessage() . "</td></tr>";
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
