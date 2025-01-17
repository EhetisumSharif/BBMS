<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipient Registration</title>
	<link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
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
				$un=$_SESSION['un'];
				if(!$un)
				{
					header("Location:index.php");
					exit();
				}
				?>
				<h1 style="color: #980002;">Recipient Registration</h1><br><br>
				<div id="form">
				   <form action="" method="post">
				   <table>
				      <tr>
                         <td width="200px" height="50px">Name</td>
                         <td width="200px" height="50px"><input type="text" name="name" placeholder="Enter Name"></td>
                         <td width="200px" height="50px">Age</td>
                         <td width="200px" height="50px"><input type="text" name="age" placeholder="Enter Age"></td>
                      </tr>
                      <tr>
                         <td width="200px" height="50px">Patient Problems</td>
                         <td width="200px" height="50px"><textarea name="problems" placeholder="Describe Patient's Problems"></textarea></td>
                         <td width="200px" height="50px">Blood Group</td>
                         <td width="200px" height="50px">
                            <select name="bgroup">
                                 <option> A+ </option>
                                 <option> A- </option>
                                 <option> B+ </option>
                                 <option> B- </option>
                                 <option> O+ </option>
                                 <option> O- </option>
                                 <option> AB+ </option>
                                 <option> AB- </option>
                            </select>
                         </td>
                      </tr>
                      <tr>
                         <td width="200px" height="50px">Quantity</td>
                         <td width="200px" height="50px"><input type="text" name="quantity" placeholder="Enter Quantity (e.g., in units)"></td>
                         <td width="200px" height="50px">Place of Blood Donation</td>
                         <td width="200px" height="50px"><textarea name="place" placeholder="Enter Place Address"></textarea></td>
                      </tr>
                      <tr>
                         <td width="200px" height="50px">Time</td>
                         <td width="200px" height="50px"><input type="datetime-local" name="time"></td>
                         <td width="200px" height="50px">Phone No</td>
                         <td width="200px" height="50px"><input type="text" name="pno" placeholder="Enter Phone No"></td>
                      </tr>
                      <tr>
                         <td><input type="submit" name="sub" value="Save" style="width: 70px; height: 30px; border-radius: 4px; 
                               background-color: #980002; color: white; font-weight: bold; cursor: pointer;"></td>
                      </tr>
				   </table>
				   </form>
				   <?php
                   if (isset($_POST['sub'])) {
                       $name = $_POST['name'];
                       $age = $_POST['age'];
                       $problems = $_POST['problems'];
                       $bgroup = $_POST['bgroup'];
                       $quantity = $_POST['quantity'];
                       $place = $_POST['place'];
                       $time = $_POST['time'];
                       $pno = $_POST['pno'];

                       $q = $db->prepare("INSERT INTO recipent_registration(name, age, problems, bgroup, quantity, place, time, pno) 
                           VALUES(:name, :age, :problems, :bgroup, :quantity, :place, :time, :pno)");
                       $q->bindValue('name', $name);
                       $q->bindValue('age', $age);
                       $q->bindValue('problems', $problems);
                       $q->bindValue('bgroup', $bgroup);
                       $q->bindValue('quantity', $quantity);
                       $q->bindValue('place', $place);
                       $q->bindValue('time', $time);
                       $q->bindValue('pno', $pno);

                       if ($q->execute()) {
                           echo "<script>alert('Recipient Registration Successful')</script>";
                       } else {
                           echo "<script>alert('Recipient Registration Failed')</script>";
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
