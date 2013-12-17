<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="s/style.css">
</head>
<body>

<div class="bottom">


<ul>
	<li>
		<a href="lab2.php">Home</a>
	</li>
	<li>
		<a href="lab2.php?b=1">Firefox</a>
	</li>
	<li>
		<a href="lab2.php?b=2">Safari</a>
	</li>
	<li>
		<a href="lab2.php?b=3">Opera</a>
	</li>
	<li>
		<a href="lab2.php?b=4">Internet Explorer</a>
	</li>
	<li>
		<a href="lab2.php?b=5">Google Chrome</a>
	</li>
</ul>
<?php
$name = $_GET['b'];
if (empty($name))
{
	print "<p>Click a link</p>";
}
if ($name == 1)
{
	print "<img src='i/image1.png'>";
}
if ($name == 2)
{
	print "<img src='i/image2.png'>";
}
if ($name == 3)
{
	print "<img src='i/image3.png'>";
}
if ($name == 4)
{
	print "<img src='i/image4.png'>";
}
if ($name == 5)
{
	print "<img src='i/image5.png'>";
}
?>
	
</div>

</body>
</html>
