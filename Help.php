<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel = 'stylesheet' type = 'text/css' href = 'css/Help.css' />
<link rel = 'stylesheet' type = 'text/css' href = 'bootstrap-3.2.0-dist/css/bootstrap.css'/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Help | TicketMonster, Inc.</title>
<?php
	$con = mysqli_connect("localhost","root","scootingly19934","ticketmonster");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(isset($_REQUEST['message'])){
		$message = trim($_REQUEST['message']);
		if(strcmp($message, "")==0){
			echo "<script>alert('You didn't write anything in the message box.  Please type a message if you click submit');</script>";
		}
		else{
			$sql = "INSERT INTO web_comments(comments) VALUES('$message');";
			$result = mysqli_query($con, $sql);
			echo "<script>alert('Your comment has been submitted!  Thank you!');</script>";
		}
	}
?>
</head>
<body>
	<h2>Contact Us For Help, or Leave a comment!</h2>
    <form method = "post">
    	<textarea name = 'message' id = 'message' rows = '10' cols = '40'></textarea>
        <p></p>
        <input class = 'subm' type = 'submit' name = 'enter' onClick = 'return checkValues();'/>
    </form>
    <footer>&copy;2014 SYD-FRG Productions</footer>
</body>
<script type= "text/javascript">
	function checkValues(){
		var messge = document.getElementById('message').value;
		messge = messge.trim();
		if(messge == ""){
			   alert("You didn't type in anything for your comment.  Please try again.");
			   return false;
		   }
		   return true;
	}
</script>
</html>