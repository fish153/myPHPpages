
<html>
<head><title>Functions</title>
<style type="text/css">
.one {float: left; margin: 10px; padding: 20px; border-style: solid;}
td {vertical-align: top;}
</style>

</head>

<body>


<?php

//hi
$link = mysql_connect('localhost', 'kubrakk', '1186601') or die('Check server name or password');
$db = mysql_select_db('kubrakk') or die();
$employees = mysql_query("SELECT * FROM employees");
print "<table class='one'>";
while($row = mysql_fetch_row($employees))
{ 
	print "<tr>";
	foreach($row as $item)
	{
		print "<td>
					$item
				</td>";
	}
	print "</tr>";
}
print "</table>";
?>





</body>
</html>