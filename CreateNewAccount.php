<!DOCTYPE html>
<html>
	<head>
		<title>Create a New Account |  TicketMonster, Inc.</title>
		<link rel = 'stylesheet' type = 'text/css' href = 'css\CreateNewAccount.css' />
		<link href = 'http://fonts.googleapis.com/css?family=Raleway:700,400' rel = 'stylesheet' type = 'text/css'>
	</head>
	<body>
    <?php
	$logincount = 0;
	$con = mysqli_connect("localhost","root","scootingly19934","ticketmonster");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(isset($_REQUEST['firstname']) and isset($_REQUEST['lastname']) and isset($_REQUEST['email']) and 
	isset($_REQUEST['username']) and isset($_REQUEST['passwd']) and isset($_REQUEST['conpasswd'])){
		$firstname = $_REQUEST['firstname'];
		$firstname = trim($firstname);
		
		$lastname = $_REQUEST['lastname'];
		$lastname = trim($lastname);
		
		$email = $_REQUEST['email'];
		$email = trim($email);
		
		$username = $_REQUEST['username'];
		$username = trim($username);
		
		$password = $_REQUEST['passwd'];
		$password = trim($password);
		
		$conpasswd = $_REQUEST['conpasswd'];
		$conpasswd = trim($conpasswd);
		
		$sql = "SELECT * FROM user WHERE username = '$username';";
		$result = mysqli_query($con, $sql);
		if($row = mysqli_fetch_array ($result, MYSQL_ASSOC)){
			echo "<script>alert('That username already exists.  Please try again.');</script>";
			$query = "INSERT INTO loginattempts(address, datetime) VALUES("."'".$_SERVER['REMOTE_ADDR']."'".", CURRENT_TIMESTAMP)";
			$result = mysqli_query($con, $query);
		}
		else if(!strcmp($password, $conpasswd)==0){
			echo "<script>alert('The password does not match the confirm password.  Please try again.');</script>";
			$query = "INSERT INTO loginattempts(address, datetime) VALUES("."'".$_SERVER['REMOTE_ADDR']."'".", CURRENT_TIMESTAMP)";
			$result = mysqli_query($con, $query);
		}
		else{
			$password = password_hash($password, PASSWORD_BCRYPT);
			$sql = "INSERT INTO user(username, password, email, firstname, lastname) VALUES('$username', '$password', '$email', '$firstname', '$lastname');";
			$result = mysqli_query($con, $sql);
			echo "<script>alert('Your account has successfully been created!  Welcome $username');</script>";
		}
	}
	$result = $con->query("SELECT COUNT(*) FROM loginattempts WHERE (datetime > now() - INTERVAL 5 MINUTE) AND address = '".$_SERVER['REMOTE_ADDR']."'");
	$logincount = $result->fetch_row();
	$logincount = $logincount[0];
	?>
    <?php
	if($logincount > 9){
		header("Location: Lockout.php");
		die();
	}
	?>
	<script type = 'text/javascript'>
	</script>
		<div id = "wrapper">
			<div id = "inputs">
				<form name = "input" action = "#" method = "post">
				<p>
					First name: <input type = "text" name = "firstname" placeholder = "Your first name here..."><br/>
					Last name: <input type = "text" name = "lastname" placeholder = "Your last name here..."><br/>
					E-mail: <input type = "email" name = "email" placeholder = "Your e-mail address here..."><br/>
					Username: <input type = "username" name = "username" placeholder = "Your desired username here..."><br/>
					Password: <input type = "password" name = "passwd" class = "pass" placeholder = "Password"><br/>
					Confirm Password: <input type = "password" name = "conpasswd" class = "pass" placeholder = "Password">
                    <br></br>
                    <input type = "submit" value = "Submit" class = "submit">
                    <br></br>
					<input type = "reset" onclick = 'reset()' value = "Reset Form">
				</p>
				</form>
			</div>
		</div>
		<footer>&copy;2014 SYD-FRG Productions</footer>
	</body>
</html>