<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
	<link rel="icon" type="image/jpeg" href="pic/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/s1.css">
</head>
<body>
    <div id="full">
        <div id="inner_full">
            <div id="header">
                <h2 class="header-title">Blood Bank Management System</h2>
            </div>
            <div id="body1">
                <br><br><br><br>
				<form action="" method="post">
                    <table align="center" cellpadding="10">
                        <tr>
                            <td width="100px" height="60px"><b>Username</b></td>
                            <td width="200px" height="60px">
                                <input type="text" name="un" placeholder="Enter Username" 
                                style="width: 150px; height: 25px; border-radius: 6px; padding: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td width="100px" height="60px"><b>Password</b></td>
                            <td width="200px" height="60px">
                                <input type="password" name="ps" placeholder="Enter Password" 
                                style="width: 150px; height: 25px; border-radius: 6px; padding: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" name="sub" value="Login" 
                                style="width: 70px; height: 30px; border-radius: 4px; 
                                background-color: #980002; color: white; font-weight: bold; cursor: pointer;">
                            </td>
                        </tr>
                    </table>
					</form>
					<?php
					if(isset($_POST['sub']))
					{
						 $un=$_POST['un'];
						 $ps=$_POST['ps'];
						 $q=$db-> prepare("SELECT* FROM admin WHERE u_name='$un' AND password='$ps'");
						 $q-> execute();
						 $res= $q-> fetchAll(pdo:: FETCH_OBJ);
						 if($res)
						 {
							 $_SESSION['un']=$un;
                             header("Location:admin-home.php");
						 }
						 else
						 {
							echo "<script>alert('Wrong Username or Password')</script>";
						 }
					}
					?>
            </div>
            <div id="footer">
				 <h4 align="center">&copy; EHETISUM SHARIF</h4>
            </div>
        </div>
    </div>
</body>
</html>
