<?php

#FUNCTION 1

function threecolumntable()
{
	print "<div class='one'>\n";

	# which form has been sent? -- assign its value to $caption
	if(isset($_GET['title']))
	{
		$caption = $_GET['title'];
	}
	# if any checkbox/es of any form checked - return a table with its values
	if(is_array($_GET['choice']))
	{
		$choice = $_GET['choice'];
		print "\t<table border='1'>" . 
			"<caption>$caption</caption>\n";
		# outer loop controls rows of the table and runs while there are elements in the array
		while($choice)
		{
			print "\t\t<tr>\n";
			$i=0; # 
			# inner loop controls the number of columns in a row
			while($i<3)
			{
				# shift first element from $choice array and assign it to $item
				$item = array_shift($choice); 
				# do not print a cell if there are no elements in the array
				if(!empty($item))
				{
					print "\t\t\t<td>$item</td>\n";
					
				}
				$i++; 
			}
			print "\t\t</tr>\n";		
		}
		print "\t</table>\n";

	}
	# if nothing checked -- give a warning
	else
	{
		print "$caption was left empty.\n";
	}
	print "</div>\n";	
}

# FUNCTION 2

function stringtable()
{
	print "<div class='two'>\n";
	# which form has been sent? -- assign its value to $title
	if(isset($_GET['title']))
	{
		$title = $_GET['title'];
	}
	# proceed if a form has been sent
	if(!empty($_GET['mystring']))
	{
		print "\t<table border='1' class='two'>" . 
			"<caption>$title</caption>\n";
		# get the value from sent form and assign to $mystring
		$mystring = $_GET['mystring'];
		# outer loop controls rows of the table
			# split the sent string on semicolons and form a row
		foreach(preg_split("/;/", $mystring) as $row)
		{
			print "\t\t<tr>\n";
			# inner loop controls columns
				# split row on commas 
			foreach(preg_split("/,/", $row) as $cell)
			{
				print "\t\t\t<td>$cell</td>\n";
			}
			print "\t\t</tr>";
		}
	}
	# if nothing has been sent, notify the user
	else
	{
		print "$title was left empty.";
	}

	print "</div>";


}
?>
