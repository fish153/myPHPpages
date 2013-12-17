<?php
// initialization of the variables
if(isset($_POST['cookies']))
{
    $cookies = $_POST['cookies']; // get the previus amount stored in the hidden field
}
else
{
    $cookies = 100; // first time a user gets 100 cookies
}
if(!empty($_POST['bet']))
{
    $bet = $_POST['bet'];
   if($bet>$cookies)
   {
    $bet = 0; // if a user's bet exceeds the amount of cookies, the bet dissmissed
   }
}
else
{
    $bet = 20; // default value of a bet
}
?>
<!DOCTYPE html>
<html>
<head>
<title>CISW410 Middleware Scripting</title>
<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>
<body>


<?php
// the game continues if the user has positive amount of cookies

if($cookies>0)
{
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
	
	    $total = array(0, 0); # initialize an array for the totals
	    print "<div class='bottom'>
		    <h1>GAME $times3</h1>";

	    #  FOR loop controls the number of rolls in a game. There are 2 rolls - first for the player, second for the house
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
        print "<h2>You had $cookies cookies</h2>";
	    # IF statements compares two elements of $total array: $total[1] is for the player, $total[2] is for the house
	    if($total[1] > $total[2])
	    {
		    print "<h1>You won!<br> You earned $bet cookies</h1>";
            $cookies += $bet;
	    }
	    elseif($total[1] < $total[2])
	    {
		    print "<h1>House won.<br> You lost $bet cookies</h1>";
            $cookies -= $bet;
	    }
	    else
	    {
		    print "<h1>Tie. You neither earned or lost any cookies</h1>";
	    }
	    print "<p>$total[1] against $total[2]</p>";

        # text box to insert the bet
        # hidden field keeps previes total of cookies
        print "<form method='post'>
                    <span >How many cookies do you want to bet?</span>
                    <input type='text' name='bet' placeholder='20' >
                    <input type='hidden' name='cookies' value=$cookies >
                    <input type='submit'  name='roll' value='Roll Dice' >
                </form>";
                
        if($bet==0) // show warning if the bet is more than the user has
        {
            print "<span>Bet again. Your bet may not be more than $cookies.</span>";
        }
        print "<h2>Finally, you have $cookies cookies</h2>";
        print "</div>";
        // calculate ones, tens and hundreds in the final number of cookies to show grathic representation of the total
        $ones = $cookies%10;
        $tens = (($cookies - $ones)%100);
        $hundreds = ($cookies - $tens - $ones)/100;
        
        // loop to print hundreds cookies which are the biggest
        while($hundreds>0)
        {    
            print "<div class='cookie100'><span class='dig'>100 </span><img class='cookie100' src='dice/cookie.png'></div>";  
            $hundreds -=1;
        }
        // while loop outputs tens cookies images which are smaller
        while($tens>0)
        {
            print "<div class='cookie10'><span class='dig'>10</span><img class='cookie10' src='dice/cookie.png'></div>"; 
            $tens -= 10;
        }
        // eventually a loop for ones cookies images, the smallest
        while($ones>0)
        {
            print "<div class='cookie'><span class='dig'>1</span><img class='cookie' src='dice/cookie.png'></div>"; 
            $ones -= 1;
        }

}
// if the user loses all the cookies there is nothin to bbet  - game is over
else
{
    print "<div class='bottom'>
            <h1>You lost. Game is over :-{( </h1>";
   print "<a href='index.php'><img class='repeat' src='../i/repeat.png' title='Roll again'></a>
           </div>";
}
    
?>
	


</body>
</html>
