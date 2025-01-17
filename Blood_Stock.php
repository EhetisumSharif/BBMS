<?php
include('connection.php');
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bgroup'], $_POST['quantity'], $_POST['action'])) {
    $bgroup = $_POST['bgroup'];
    $quantity = (int) $_POST['quantity'];
    $action = $_POST['action'];

    // Check if quantity is negative
    if ($quantity < 0) {
        echo "<script>alert('Quantity cannot be negative!');</script>";
    } else {
        try {
            $query = $db->prepare("SELECT quantity FROM blood_stock WHERE bgroup = :bgroup");
            $query->bindParam(':bgroup', $bgroup);
            $query->execute();
            $stock = $query->fetch(PDO::FETCH_OBJ);

            if ($stock) {
                if ($action == 'add') {
                    // Add to stock
                    $newQuantity = $stock->quantity + $quantity;
                } elseif ($action == 'reduce') {
                    // Reduce from stock, but ensure quantity doesn't go negative
                    $newQuantity = max(0, $stock->quantity - $quantity);
                } else {
                    throw new Exception("Invalid action specified.");
                }

                // Update the stock based on the action
                $updateStock = $db->prepare("UPDATE blood_stock SET quantity = :quantity WHERE bgroup = :bgroup");
                $updateStock->bindValue(':quantity', $newQuantity, PDO::PARAM_INT);  
                $updateStock->bindValue(':bgroup', $bgroup, PDO::PARAM_STR);      
                $updateStock->execute();
            } else {
                echo "<script>alert('Invalid blood group selected!');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Stock</title>
    <link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
    <style type="text/css">
        td {
            width: 200px;
            height: 20px;
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
                <h1 style="color: #980002;">Blood Stock</h1><br>
                <div id="st_list">
                   <table>
                    <tr id="ttitle">
                        <td>Blood Group</td>
                        <td>Quantity</td>
                    </tr>
                    <?php
                    $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                    foreach ($bloodGroups as $bgroup) {
                        $stockQuery = $db->prepare("SELECT quantity FROM blood_stock WHERE bgroup = :bgroup");
                        $stockQuery->bindParam(':bgroup', $bgroup);
                        $stockQuery->execute();
                        $stock = $stockQuery->fetch(PDO::FETCH_OBJ);
                        $quantity = $stock && $stock->quantity > 0 ? $stock->quantity : "Empty";
                        echo "<tr>
                                <td>{$bgroup}</td>
                                <td>{$quantity}</td>
                              </tr>";
                    }
                    ?>
                </table>
                </div>

                <!-- Common Form for Adding or Removing Stock -->
                <div class="update-form">
                    <h2 style="color: #980002;">Update Blood Stock</h2>
                    <form method="POST">
                        <label for="bgroup">Select Blood Group:</label>
                        <select name="bgroup" id="bgroup" required>
                            <?php
                            foreach ($bloodGroups as $bgroup) {
                                echo "<option value='{$bgroup}'>{$bgroup}</option>";
                            }
                            ?>
                        </select>

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" min="1" required>

                        <label for="action">Action:</label>
                        <select name="action" id="action" required>
                            <option value="add">Add</option>
                            <option value="reduce">Remove</option>
                        </select>

                        <button type="submit">Update Stock</button>
                    </form>
                </div>
            </div>
            <div id="footer">
                <h4 align="center">&copy; EHETISUM SHARIF</h4>
            </div>
        </div>
    </div>
</body>
</html>
