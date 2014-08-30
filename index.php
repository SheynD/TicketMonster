<html>
<title>TicketMonster, Inc.</title>
<head>
<link rel = 'stylesheet' type = 'text/css' href = 'css/Login.css'/>
<!--<link href='http://fonts.googleapis.com/css?family=Raleway:700,400' rel='stylesheet' type='text/css'>
-->
<link rel = 'stylesheet' type = 'text/css' href = 'bootstrap-3.2.0-dist/css/bootstrap.css'/>
</head>
<body>
<?php
	$con = mysqli_connect("localhost","root","scootingly19934","ticketmonster");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result = $con->query("SELECT COUNT(*) FROM loginattempts WHERE (datetime > now() - INTERVAL 5 MINUTE) AND address = '".$_SERVER['REMOTE_ADDR']."'");
	$logincount = $result->fetch_row();
	$logincount = $logincount[0];
	if(isset($_REQUEST['passwrd']) and isset($_REQUEST['usernm'])){
		$username = $_REQUEST['usernm'];
		$username = trim($username);
		
		$password = $_REQUEST['passwrd'];
		$password = trim($password);
		
		$sql = "SELECT * FROM user WHERE username = '$username';";
		$result = mysqli_query($con, $sql);
		if($row = mysqli_fetch_array ($result, MYSQL_ASSOC))
			if(password_verify($password, $row['password'])){
				echo "<script>alert('Login successful.  Welcome $username');</script>";
			}
			else{
				echo "<script>alert('Incorrect password.  Please try again.');</script>";
				$query = "INSERT INTO loginattempts(address, datetime) VALUES("."'".$_SERVER['REMOTE_ADDR']."'".", CURRENT_TIMESTAMP)";
				$result = mysqli_query($con, $query);
			}
		else{
			echo "<script>alert('The username/password combination is incorrect.  Please try again');</script>";
			$query = "INSERT INTO loginattempts(address, datetime) VALUES("."'".$_SERVER['REMOTE_ADDR']."'".", CURRENT_TIMESTAMP)";
			$result = mysqli_query($con, $query);
		}
	}
?>
<img src = "TicketMonster.jpg" class = "Monster" />
<p></p>
<?php
if($logincount > 9){
	header("Location: Lockout.php");
	die();
}
?>
<div id = "login">
  <h5>For returning users, enter your username and password</h5>
  <form method = "post">
    <input class = "user" type = "text" id="username" name = "usernm" placeholder = "Username">
    <br/>
    <p></p>
    <input type = "password" id = "passwd" class = "pass" name = "passwrd" placeholder = "Password">
    <br/>
    <p></p>
    <input class = "log" type = "submit" id = "login" value = "Login" OnClick = "return checkValues();">
    <p></p>
  </form>
  <h5>Don't have an account with us?</h5>
  <input class = "create" type="submit" value="Create Account" onClick = "location.href = 'CreateNewAccount.php'">
  <h5>Forgot your password?  <a href = "ForgotPassword.php">Click here to create a new one.</a></h5>
  <h5><a href = "Help.php">Click here to contact the Web administrator</a></h5>
</div>
<footer>&copy;2014 SYD-FRG Productions</footer>
</body>
<script type= "text/javascript">
	function checkValues(){
		if(document.getElementById('username').value == "" 
		|| document.getElementById('passwd').value == ""){
			   alert("You didn't type in anything for your username/password.  Please try again.");
			   return false;
		   }
		   return true;
	}
</script>
</html>