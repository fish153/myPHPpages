<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>
<body>


<?php
# initiate an array for the dices
$dice = array(
				"",
				"dice/dice1.png", 
				"dice/dice2.png", 
				"dice/dice3.png", 
				"dice/dice4.png", 
				"dice/dice5.png",
				"dice/dice6.png"
			);
# outer FOR loop controls the number of games (three)
for ($times3 = 1; $times3<4; $times3++)
{	
	$total = array(0, 0); # initialize an array for the totals
	print "<div class='bottom'>
		<h1>GAME $times3</h1>";

	# middle FOR loop controls the number of rolls in a game. There are 2 rolls - first for the player, second for the house
	for ($roll = 1; $roll<3; $roll++)
	{	
	
		if($roll == 1)
		{$player = "YOU";}
		else
		{$player = "HOUSE";}

		print "<div class='bot$roll'><h1>$player</h1>";

		# inner FOR loop controls the number of dices in a roll (two for each rool)
		for($i=1; $i<3; $i++)
		{
			$r = rand(1,6); # assign a random number to an element( 1 or 2) of $r array
			print "<img class='dice' " . "src='" . $dice[$r] ."'>"; # print html tag for the image of the dice 
			# elements of $total array keep the totals of two dices
			$total[$roll] += $r; # add the random number to the respective element of $total array

		}

		print "</div>";
	
	}

	# IF statements compares two elements of $total array: $total[1] is for the player, $total[2] is for the house
	if($total[1] > $total[2])
	{
		print "<h1>You won!</h1>";
	}
	elseif($total[1] < $total[2])
	{
		print "<h1>House won</h1>";
	}
	else
	{
		print "<h1>Tie</h1>";
	}
	print "<p>$total[1] against $total[2]</p>";
	print "<a href='index.php'><img class='repeat' src='../i/repeat.png' title='Roll again'></a>";
	print "</div>";

}
?>
	


</body>
</html>
