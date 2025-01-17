<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donor Registration</title>
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
                $un = $_SESSION['un'];
                if (!$un) {
                    header("Location:index.php");
                    exit();
                }
                ?>
                <h1 style="color: #980002;">Donor Registration</h1><br><br>
                <div id="form">
                   <form action="" method="post">
                   <table>
                      <tr>
                         <td width="200px" height="50px">Name</td>
                         <td width="200px" height="50px"><input type="text" name="name" placeholder="Enter Name"></td>
                         <td width="200px" height="50px">Father's Name</td>
                         <td width="200px" height="50px"><input type="text" name="fname" placeholder="Enter Father's Name"></td>
                      </tr>
                      <tr>
                         <td width="200px" height="50px">Address</td>
                         <td width="200px" height="50px"><textarea name="address"></textarea></td>
                         <td width="200px" height="50px">Gender</td>
                         <td width="200px" height="50px"><input type="text" name="gender" placeholder="Enter Gender"></td>
                      </tr>
                      <tr>
                         <td width="200px" height="50px">Age</td>
                         <td width="200px" height="50px"><input type="text" name="age" placeholder="Enter Age"></td>
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
                         <td width="200px" height="50px">E-Mail</td>
                         <td width="200px" height="50px"><input type="text" name="email" placeholder="Enter E-Mail"></td>
                         <td width="200px" height="50px">Phone No</td>
                         <td width="200px" height="50px"><input type="text" name="pno" placeholder="Enter Phone No"></td>
                      </tr>
                      <tr>
                         <td><input type="submit" name="sub" value="Save"  style="width: 70px; height: 30px; border-radius: 4px; background-color: #980002; color: white; font-weight: bold; cursor: pointer;"></td>
                      </tr>
                   </table>
                   </form>
                   <?php
                    if (isset($_POST['sub'])) {
                        $name = $_POST['name'];
                        $fname = $_POST['fname'];
                        $address = $_POST['address'];
                        $gender = $_POST['gender']; 
                        $age = $_POST['age'];
                        $bgroup = $_POST['bgroup'];
                        $email = $_POST['email'];
                        $pno = $_POST['pno'];
                        
                        $q = $db->prepare("INSERT INTO donor_registration(name, fname, address, gender, age, bgroup, email, pno) VALUES(:name, :fname, :address, :gender, :age, :bgroup, :email, :pno)");
                        $q->bindValue(':name', $name);
                        $q->bindValue(':fname', $fname);
                        $q->bindValue(':address', $address);
                        $q->bindValue(':gender', $gender); 
                        $q->bindValue(':age', $age);
                        $q->bindValue(':bgroup', $bgroup); 
                        $q->bindValue(':email', $email);
                        $q->bindValue(':pno', $pno);

                        if ($q->execute()) {
                            $stockQuery = $db->prepare("SELECT * FROM blood_stock WHERE bgroup = :bgroup");
                            $stockQuery->bindValue(':bgroup', $bgroup);
                            $stockQuery->execute();

                            if ($stockQuery->rowCount() > 0) {
                                $updateStock = $db->prepare("UPDATE blood_stock SET quantity = quantity + 1 WHERE bgroup = :bgroup");
                                $updateStock->bindValue(':bgroup', $bgroup);
                                $updateStock->execute();
                            } else {
                                $insertStock = $db->prepare("INSERT INTO blood_stock (bgroup, quantity) VALUES (:bgroup, 1)");
                                $insertStock->bindValue(':bgroup', $bgroup);
                                $insertStock->execute();
                            }
                            echo "<script>alert('Donor Registration Successful')</script>";
                        } else {
                            echo "<script>alert('Error in Registration')</script>";
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
