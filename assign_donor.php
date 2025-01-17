<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Donor</title>
    <link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
    <style type="text/css">
        td {
            width: 200px;
            height: 30px;
            text-align: center;
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
                <h1 style="text-align: center; color: #980002;">Assign Donor to Recipient</h1>
                <div class="form-container">
                    <form action="assign_donor.php" method="post">
                        <label for="donor_id">Select Donor:</label>
                        <select name="donor_id" required>
                            <option value="">Select Donor</option>
                            <?php
                            // Include donors with canceled assignments
                            $donors = $db->query(
                                "SELECT * FROM donor_registration 
                                WHERE id NOT IN (
                                    SELECT donor_id FROM donor_recipient_assignment WHERE status = 'completed'
                                )"
                            );
                            while ($donor = $donors->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='{$donor->id}'>{$donor->name} ({$donor->bgroup})</option>";
                            }
                            ?>
                        </select>

                        <label for="recipient_id">Select Recipient:</label>
                        <select name="recipient_id" required>
                            <option value="">Select Recipient</option>
                            <?php
                            // Include recipients with canceled assignments
                            $recipients = $db->query(
                                "SELECT rr.* 
                                 FROM recipent_registration rr
                                 LEFT JOIN (
                                     SELECT recipient_id, SUM(assigned_quantity) AS total_assigned 
                                     FROM donor_recipient_assignment 
                                     WHERE status IN ('pending', 'completed')
                                     GROUP BY recipient_id
                                 ) dra ON rr.id = dra.recipient_id
                                 WHERE dra.total_assigned IS NULL OR dra.total_assigned < rr.quantity"
                            );
                            while ($recipient = $recipients->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='{$recipient->id}'>{$recipient->name} ({$recipient->bgroup})</option>";
                            }
                            ?>
                        </select>

                        <label for="quantity">Assign Quantity (in units):</label>
                        <input type="number" name="quantity" min="1" required>

                        <button type="submit" name="assign">Assign</button>
                    </form>

                    <?php
                    if (isset($_POST['assign'])) {
                        $donor_id = $_POST['donor_id'];
                        $recipient_id = $_POST['recipient_id'];
                        $quantity = $_POST['quantity'];

                        $donor = $db->query("SELECT * FROM donor_registration WHERE id = $donor_id")->fetch(PDO::FETCH_OBJ);
						$recipient = $db->query("SELECT * FROM recipent_registration WHERE id = $recipient_id")->fetch(PDO::FETCH_OBJ);

						if (!$donor || !$recipient) {
							echo "<p style='color: red; text-align: center;'>Invalid donor or recipient selection.</p>";
						} elseif ($donor->bgroup == $recipient->bgroup) {
							// Store the donor's blood group to use in the stock update
							$bgroup = $donor->bgroup;

							$stmt = $db->prepare("INSERT INTO donor_recipient_assignment (donor_id, recipient_id, assigned_quantity, status) 
									VALUES (:donor_id, :recipient_id, :quantity, 'pending')");
							$stmt->bindParam(':donor_id', $donor_id);
							$stmt->bindParam(':recipient_id', $recipient_id);
							$stmt->bindParam(':quantity', $quantity);

							if ($stmt->execute()) {
								// Now the blood group is correctly passed in the update query
								$updateStock = $db->prepare("UPDATE blood_stock SET quantity = quantity + :quantity WHERE bgroup = :bgroup");
								$updateStock->bindValue(':quantity', $quantity, PDO::PARAM_INT);  
								$updateStock->bindValue(':bgroup', $bgroup, PDO::PARAM_STR);      
								$updateStock->execute();

								echo "<script>alert('Donor Assignment Successful');</script>";
							} else {
								echo "<script>alert('Donor Assignment Failed');</script>";
							}
						} else {
							echo "<p style='color: red; text-align: center;'>Blood group mismatch between donor and recipient.</p>";
						}
                    }
                    ?>
                </div>
            </div>
            <div id="footer">
                <h4 align="center">&copy; EHETISUM SHARIF</h4>
            </div>
        </div>
    </div>
</body>
</html>
