<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
	<link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
</head>
<body>
    <div id="full">
        <div id="inner_full">
            <div id="header">
                 <h2 class="header-title">Blood Bank Management System</h2>
                <div class="header-right">
                    <a href="logout.php" class="logout-button">Logout</a>
                </div>
            </div>
            <div id="body">
                <br>
				<?php
				$un=$_SESSION['un'];
				if(!$un)
				{
					header("Location:index.php");
					exit();
				}
				?>
				<h1 class="welcome-text"> WELCOME ADMIN </h1>
				<br><br><br>
				 <ul class="menu">
				    <li><a href="Donor_reg.php">Donor Registration</a></li>
                    <li><a href="Donor.php">Donor List</a></li>
					<li><a href="Recipient_reg.php"> Recipient Registration</a></li>
                    <li><a href="Recipient.php">Recipient List</a></li>
				    <li><a href="assign_donor.php">Assign Donor</a></li>
					<li><a href="assign_list.php">Donor Assigment List</a></li>
					<li><a href="#"></a></li>
					<li><a href="Blood_Stock.php">Blood Stock List</a></li>
					<li><a href="#"></a></li>
                </ul>
            </div>
            <div id="footer">
				     <h4 align="center">&copy; EHETISUM SHARIF</h4>
            </div>
        </div>
    </div>
</body>
</html>
