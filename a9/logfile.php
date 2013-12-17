<?php
session_start();
	include('pro.php');
	condb($host, $user, $pass, $db);
?>
<html>
<head>
	<title>
		Read Log file
	</title>
	<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>
<body>
	<div class="topTable">
		<div class="midLeft">

			
<?php
	if($_SESSION['authenticLog322a'] == "validUser324b")
	{
		ReadLogFile();
	}
	else
	{
		print "<p>Guest -- you have no crdentials to view logs</p>";
		print "<p>Please  <a href='login.php'>log in</a></p>";
	}

	

?>
		</div>

	</div>

</body>
</html>