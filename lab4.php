<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="s/style.css">
</head>
<body>

<div class="bottom">
	<div class="botLeft">
	<a href="lab4.php">Reload</a></br>
	<form action="lab4.php" method="get">
	First name: <input type="text" name="fname"></br>
	Last name: <input teyp="text" name="lname"></br>
	Your favorite aircompany:</br>
	<input type="radio" name="air" value="Delta">Delta</br>
	<input type="radio" name="air" value="United">United</br>
	<input type="radio" name="air" value="Alaska">Alaska</br>
	<input type="radio" name="air" value="Blue Jet">Blue Jet</br>
	<input type="radio" name="air" value="Virgin America">Virgin America</br>
	You want to travel in:</br>
	<input type="checkbox" name="country[]" value="Greek">Greek</br>
	<input type="checkbox" name="country[]" value="Uruguay">Uruguay</br>
	<input type="checkbox" name="country[]" value="Australia">Australia</br>
	<input type="checkbox" name="country[]" value="India">India</br>
	<input type="submit" value="Submit">
	</form>
	</div>
<div class="botRight">
<?php
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$air = $_GET['air'];
$country = $_GET['country'];

if(!empty($fname) && !empty($lname) && !empty($air) && is_array($country))
{

	print "<p>Hi, there: $fname $lname</p>
			<p>You want to fly in </p>
				<ul>";
			foreach($country as $tem)
			{
				print "<li>$tem</li>";
				
			}
	print " </ul>
			<p>by $air</p>";
}
else
{
	print "<p>You left something empty</p>";
}
?>
</div>	
</div>

</body>
</html>
