<?php
session_start();
	include('pro.php');
	condb($host, $user, $pass, $db);
?>
<html>
<head>
	<title>
		Log In | Sign In
	</title>
	<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>
<body>
	<div class="topTable">
		<div class="midLeft">

			
<?php
	if(isset($_POST['new'])){

			$logInType = 1;
			$fname = trim($_POST['fname']);
			$lname = trim($_POST['lname']);
			$password = trim($_POST['password']);
			LogIn($logInType, $fname, $lname, $password);
		}
	else
	{
		if(isset($_POST['old'])) {
			$logInType = 2;
			$fname = trim($_POST['fname']);
			$lname = trim($_POST['lname']);
			$password = trim($_POST['password']);
			LogIn($logInType, $fname, $lname, $password);
		}
		else
		{
			LogInForm();
		}

	}
	

	

?>
		</div>

	</div>

</body>
</html>