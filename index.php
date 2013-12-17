<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="s/style.css">
</head>
<body>
<!--======== HEADER STARTS HERE ==============-->
<div class="top">
<!-- ///////////////  Header Left block  /////////////////// -->
	<div class="topLeft">
		
<!-- !!!!!!FIRST PART OF THE HOMEWORK ASSIGNMENT 1 !!!!!!! start-->
<!-- php code shows the date and time -->
		<?php
			echo "<span class='date'>";
			echo date("l, F d ");
			echo "</span>
				<span class='time'>";
			echo date("H:i:s");
			echo "</span>";
		?>
	</div>
<!-- //////////////////Header right block////////////////////// -->
	<div class="topRight">
<!-- php code shows the name -->
		<?php
			$lname = "Kubrak";
			$fname = "Kanstantsin";
			print "<h1 class='name' title='The very person who is in charge of the page'>" . $fname ." ". $lname . "</h1>";
		?>
<!-- !!!!!!FIRST PART OF THE HOMEWORK ASSIGNMENT 1 !!!!!!! end-->

	</div>
</div>
<!-- ============HEADER ENDS HERE ========== -->
<!-- ============MIDDLE BLOCK STARTS HERE =========-->
<div class="middle">
<!-- //////////////Middle left block ////////////-->
	<div class="midLeft">
	<h1>Homework assignments</h1>
<!-- !!!!!!SECOND PART OF THE HOMEWORK ASSIGNMENT 1  !!!!!!!start-->
<!-- The table includes the list of homework assignments for the semester -->
		<table title="The situation is hopeless but not serious"> 
			<thead>
				<tr>
					<th class="column1">
						Assignments
					</th>					
				
					<th class="column2">
						Due Date
					</th>
				</tr>
			</thead>
			<tr>
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/index.php">Index Page</a>
				</td>
				<td>
					September 5
				</td>
			</tr>
			<tr class="contrast">
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a1/">Include Assignment</a>
				</td>
				<td>
					Septempber 12
				</td>
			</tr>

			<tr>
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a2/">Dice Game</a>
				</td>
				<td>
					September 19
				</td>
			</tr>

			<tr class="contrast">
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a3/">Funcitons</a>
				</td>
				<td>
					September 26
				</td>
			</tr>

			<tr>
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a4/">Dice Cookie</a>
				</td>
				<td>
					October 3
				</td>
			</tr>

			<tr class="contrast">
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a5/">Employees Table</a>
				</td>
				<td>
					October 17
				</td>
			</tr>

			<tr>
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a6/">Blog Tables</a>
				</td>
				<td>
					October 31
				</td>
			</tr>

			<tr class="contrast">
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a7/">Books</a>
				</td>
				<td>
					November 14
				</td>
			</tr>

			<tr>
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a8/">Password</a>
				</td>
				<td>
					November 21
				</td>
			</tr>

			<tr class="contrast">
				<td>
					<a href="http://power.arc.losrios.edu/~kubrakk/cisw410/a9/">Project</a>
				</td>
				<td>
					December 19
				</td>
			</tr>
		</table>
<!--!!!!!! SECOND PART OF THE HOMEWORK ASSIGNMENT 1 !!!!!!! end-->

	</div>
<!-- ============ LEFT MIDDLE BLOCK ENDS HERE  ============-->
<!-- ============ RIGHT MIDDLE BLOCK STARTS HERE ============ -->

	<div class="midRight">
<!-- just a pictur of a camel -->
			<img src="http://camel.jpg.to/png" alt="A picture of a camel" title="Trust God but tie your camel">
	</div>
<!-- ============ RIGHT MIDDLE BLOCK ENDS HERE ============ -->	
</div>
<!-- ============ BOTTOM BLOCK STARTS HERE ============ -->
<div class="bottom">
<!-- !!!!!!THIRD PART OF THE HOMEWORK ASSIGNMENT 1  !!!!!!!start-->
<!-- php code shows a random image of a web browser and some other pictures-->
			<?php
				$num = rand(1,5);                # assign a random number to variable $num
				$pict = "i/image".$num.".png";   # form the filename of a picture
#  switch block assigns the name of a web browser to the variable $text to show it in the header.
#  depends of value of $num
#  also assigns the name of a pet to the variable $pet to show a picture of this pet in the right block
#  TOTALLY UNNECESERY FOR THIS HOMEWORK but JFF

				switch ($num)
				{
					case 1: $text = "FireFox";
						$pet = "dog";
					break;
					case 2: $text = "Safari";
						$pet = "cat";
					break;
					case 3: $text = "Opera";
						$pet = "humster";
					break;
					case 4: $text = "Internet Explorer";
						$pet = "robot";
					break;
					case 5: $text = "Google Chrome";
						$pet = "frog";
					break;
				}
# make a link for a picture for a search, assign to the variable $randompage
				$randompage = $pet .".jpg.to/r";
# <!-- ============ here starts left block============ -->
# print left block
				print "<div class='botLeft'><h2> A random browser is $text</h2>"; # create the header
				print "<img src='$pict' alt='funny picture'                       
				title='Web browsers compatibility is a nightmare for web developers'>\n</div>\n"; # print image tag
# <!-- ============ here starts right block ============ -->
# print right block				
				print "<div class='botRight'>
						<h2 title='In some cases, search on the Internet  gives
						unexpected results. If so, close your eyes and 
						press F5 or Ctrl-R'>
						An i-am-feeling-lucky  picture of a $pet</h2>";
# print html tag to show a pet's image				
				print "<img src='http://$randompage' alt='a picture of a $pet'
					 title='The search of a $pet provided by http://jpg.to/'>\n</div>";
		?>

<!-- !!!!!!THIRD PART OF THE HOMEWORK ASSIGNMENT 1  !!!!!!! End-->		
</div>
<!-- //////////// THE BOTTOM BLOCK ENDS HERE /////// -->
</body>
</html>
