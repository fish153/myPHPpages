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
		if(c[i].type == "text")
		{
		c[i].value = "";
		}
	}
return false;
}
</script>
<title>Functions</title>
<style type="text/css">
.one {float: left; margin-bottom: 10px;}
.two {clear: both; border-style: solid; width: 50%;}
.link {clear: both;}
.link a {display: block;}
caption {color: red; font-size: 18pt;}

</style>

</head>

<body>
<div class='link'>
<a href='./'>HOME</a>
<a href='stringtable.php'>Reload Page</a>
<a href='#' onclick='uncheckall()'>Clear Fields</a>
</div>
<div class="one">
<form action="stringtable.php">
<input type="hidden" name="title" value="Animal Table">
<input type="text" name="mystring" size="130" value="Cat, Dog, Horse, Bird; Lion, Tiger, Bear, Seal; Eagle, Hawk,
Falcon, Sparrow; Ant, Bee, Spider, Rat"><input type="submit" name="trigger1" value="Create Animal Table">
</form>
</div>

<div class="one">
<form action="stringtable.php">
<input type="hidden" name="title" value="Color Table">
<input type="text" name="mystring" size="130" value="Red, Blue, Green; Orange, Purple, Silver; Gold, 
Brown, Khaki"><input type="submit" name="trigger2" value="Create Color Table">
</form>
</div>


<div class="one">
<form action="stringtable.php">
<input type="hidden" name="title" value="Food Table">
<input type="text" name="mystring" size="170" value="Apples, Bananas, Bread, Chicken, Beef; Rice, Flour, Cookies, Cake, 
Cherries; Tacos, Pizza, Ice Cream, Noodles, Soup; Pears, Crackers, Oranges, Berries, Lettuce">
<input type="submit" name="trigger3" value="Create Food Table">
</form>
</div>

<?php
if(!empty($_GET))
{
stringtable();
}
?>
</body>
</html>
