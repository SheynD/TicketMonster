<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel = 'stylesheet' type = 'text/css' href = 'css/forgotpword.css' />
<link href='http://fonts.googleapis.com/css?family=Raleway:700,400' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ticketmonster, Inc.</title>
</head>
<body>
<?php
	$con = mysqli_connect("localhost","root","scootingly19934","ticketmonster");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(isset($_REQUEST['username']) and isset($_REQUEST['emailbox']) and isset($_REQUEST['newpass'])){
		$username = $_REQUEST['username'];
		$username = trim($username);
		
		$email = $_REQUEST['emailbox'];
		$email = trim($email);
		
		$password = $_REQUEST['newpass'];
		$password = trim($password);
		
		$sql = "SELECT * FROM user WHERE username = '$username'";
		$result = mysqli_query($con, $sql);
		if($row = mysqli_fetch_array ($result, MYSQL_ASSOC)){
			if(strcmp($email, $row['email'])==0){
				$password = password_hash($password, PASSWORD_BCRYPT);
				$sql = "UPDATE user SET password = '$password' WHERE username = '$username'";
				$result = mysqli_query($con, $sql);
				echo "<script>alert('Your password has been successfully reset!');</script>";
				header("Location: index.php");
				die();
			}
			else{
				echo "<script>alert('The email you entered is incorrect.  Try again.');</script>";
			}
		}
		else{
			echo "<script>alert('Invalid username.  Please try again.');</script>";
		}
	}
?>
<h2>Forget your password?  Verify you are a member, and then enter your new password</h2>
<p></p>
<div id = "forgot">
	<form method = "post">
    	<input type = "text" class = "user" id = "usernme" name = "username" placeholder = "Username"/>
        <br />
        <p></p>
        <input type = "text" class = "mail" id = "email" name = "emailbox" placeholder = "Email Address" />
        <br />
        <p></p>
        <input type = "password" class = "newpword" id = "pword" name = "newpass" placeholder = "New Password"/>
        <br/>
        <p></p>
        <input type = "submit" class = "remail" id = "enter" name = "entermail" value = "Enter" OnClick = "return checkValues();"/>
    </form>
</div>
<footer>&copy;2014 SYD-FRG Productions</footer>
</body>
<script type= "text/javascript">
	function checkValues(){
		if(document.getElementById('usernme').value == "" 
		|| document.getElementById('email').value == "" 
		|| document.getElementById('pword') == ""){
			   alert("You didn't type in anything for one of the boxes.  Please try again.");
			   return false;
		   }
		   return true;
	}
</script>
</html>