<?php
include('functionfile.php');
?>
<html>
<head>
<script type='text/javascript'>
function uncheckall()
{
var c = document.getElementsByTagName('input');
	for(i=0; i<c.length; i++)
	{
	c[i].checked = false;
	}
return false;
}
</script>
<title> Tables</title>
<style type="text/css">
	table {float: left;}
	caption {color: red; font-size: 18pt;}
	.one {float: right; margin: 10px; padding: 20px; border-style: solid;}
	td {vertical-align: top;}
	.link {clear: both;}
	.link a {display: block;}
</style>

</head>

<body>
<div class='link'>
<a href='./'>HOME</a>
<a href='threecolumntable.php'>Reload Page</a>
<a href='#' onclick='uncheckall()'>UnCheck All</a>
</div>
<table border='1'>
<tr>
<td>
<form action="threecolumntable.php" method="get">
<input type='hidden' name='title' value='Animal Form'>
<input type="checkbox" name="choice[]" value="cat" checked='checked'>Cat<br>
<input type="checkbox" name="choice[]" value="dog" checked='checked'>Dog<br>
<input type="checkbox" name="choice[]" value="horse" checked='checked'>Horse<br>
<input type="checkbox" name="choice[]" value="bird" checked='checked'>Bird<br>
<input type="checkbox" name="choice[]" value="pig" checked='checked'>Pig<br>
<input type="checkbox" name="choice[]" value="monkey">Monkey<br>
<input type="checkbox" name="choice[]" value="mouse" checked='checked'>Mouse<br>
<input type="checkbox" name="choice[]" value="frog">Frog<br>
<input type="checkbox" name="choice[]" value="elephant" checked='checked'>Elephant<br>
<input type="checkbox" name="choice[]" value="rat">Rat<br>
<input type="checkbox" name="choice[]" value="whale">Whale<br>
<input type="checkbox" name="choice[]" value="shark">Shark<br>
<input type="checkbox" name="choice[]" value="fish">Fish<br>
<input type="checkbox" name="choice[]" value="lion">Lion<br>
<input type="checkbox" name="choice[]" value="spider" checked='checked'>Spider<br>
<input type="checkbox" name="choice[]" value="bat" checked='checked'>Bat<br>
<input type="checkbox" name="choice[]" value="bear" checked='checked'>Bear<br>
<input type="checkbox" name="choice[]" value="tiger" checked='checked'>Tiger<br>
<input type="checkbox" name="choice[]" value="wolf" checked='checked'>Wolf<br>
<input type="checkbox" name="choice[]" value="puma">Puma<br>
<input type="checkbox" name="choice[]" value="bobcat">Bobcat<br>
<input type="submit" name="trigger1" value="Submit">
</form>
</td>

<td>
<form action="threecolumntable.php" method="get">
<input type='hidden' name='title' value='Color Form'>
<input type="checkbox" name="choice[]" value="red">Red<br>
<input type="checkbox" name="choice[]" value="blue" checked='checked'>Blue<br>
<input type="checkbox" name="choice[]" value="green" checked='checked'>Green<br>
<input type="checkbox" name="choice[]" value="orange" checked='checked'>Orange<br>
<input type="checkbox" name="choice[]" value="pink" checked='checked'>Pink<br>
<input type="checkbox" name="choice[]" value="purple" checked='checked'>Purple<br>
<input type="checkbox" name="choice[]" value="silver">Silver<br>
<input type="checkbox" name="choice[]" value="teal">Teal<br>
<input type="checkbox" name="choice[]" value="brown" checked='checked'>Brown<br>
<input type="checkbox" name="choice[]" value="black" checked='checked'>Blacdk<br>
<input type="checkbox" name="choice[]" value="white" checked='checked'>White<br>
<input type="checkbox" name="choice[]" value="gold" checked='checked'>Gold<br>
<input type="checkbox" name="choice[]" value="yellow" checked='checked'>Yellow<br>
<input type="checkbox" name="choice[]" value="gray" checked='checked'>Gray<br>
<input type="checkbox" name="choice[]" value="khaki" checked='checked'>Khaki<br>
<input type="checkbox" name="choice[]" value="beige" checked='checked'>Beige<br>
<input type="submit" name="trigger2" value="Submit">
</form>
</td>

<td>
<form action="threecolumntable.php" method="get">
<input type='hidden' name='title' value='Food Form'>
<input type="checkbox" name="choice[]" value="apples" checked='checked'>Apples<br>
<input type="checkbox" name="choice[]" value="bananas" checked='checked'>Bananas<br>
<input type="checkbox" name="choice[]" value="cherries" checked='checked'>Cherries<br>
<input type="checkbox" name="choice[]" value="plums" checked='checked'>Plums<br>
<input type="checkbox" name="choice[]" value="bread" checked='checked'>Bread<br>
<input type="checkbox" name="choice[]" value="chicken" checked='checked'>Chicken<br>
<input type="checkbox" name="choice[]" value="beef" checked='checked'>Beef<br>
<input type="checkbox" name="choice[]" value="fish" checked='checked'>Fish<br>
<input type="checkbox" name="choice[]" value="lettuce" checked='checked'>Lettuce<br>
<input type="checkbox" name="choice[]" value="almonds" checked='checked'>Almonds<br>
<input type="checkbox" name="choice[]" value="cookies" checked='checked'>Cookies<br>
<input type="checkbox" name="choice[]" value="cake" >Cake<br>
<input type="submit" name="trigger3" value="Submit">
</form>
</td>

</tr>
</table>
<?php
	if(!empty($_GET))
	{
	threecolumntable();
	}
?>
</body>
</html>
