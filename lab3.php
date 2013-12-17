<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="s/style.css">
</head>
<body>

<div class="bottom">

<ul>
<?php
$animal = array(
				"cat",
				"mouse",
				"horse",
				"dog",
				"hamster",
				"monkey",
				"camel",
				"cow",
				"lama",
				"goat"
				);
for($i = 0; $i<count($animal); $i++)
{
	if($i%2 == 0)
	{
		print "<li>
				<p class='red'>$animal[$i]</p>
				</li>\n";
	}
	else
	{
		print "<li>
				<p class='blue'>$animal[$i]</p>
				</li>\n";
	}
}
		


?>
</ul>	
</div>

</body>
</html>
