<?
include('functionlab.php');
?>
<html>
<head><title>Functions</title>
<style type="text/css">
.one {float: left; margin: 10px; padding: 20px; border-style: solid;}
td {vertical-align: top;}
</style>

</head>

<body>
<a href='lab5.php'>Reload Page</a><br>
<p>This page has 3 forms on it. All of them are processed by the single function called outputall() which you
will find in the functionlab.php file. This function is supposed to output any type of form regardless of the number of
fields in it  or what they are called. If you test this page out you will notice that it works correctly for
form 1 and form 2. But when you hit the submit button for form 3 something goes wrong. Instead of printing out the
choices on the checkboxes called 'animal', it just prints the word 'Array'.</p>
<p>Your assignment is to fix this function so that it works correctly. Here is an example of the working
script: <a href='http://power.arc.losrios.edu/~leeverc/php/functionassignment/functionlabsolution.php'>SCRIPT</a></p>

<div class="one"><form action="lab5.php">
<input type="text" name="Username" value="Bob">User name<br>
<input type="password" name="password" value="123">Password<br>
Favorite Animal<br>
<select name="animal">
<option value="cat" checked="checked">Cat</option>
<option value="dog">Dog</option>
<option value="horse">Horse</option>
<option value="bird">Bird</option>
</select><br>
What State are you From?<br>
<select name="state">
<option value="CA">California</option>
<option value="NV">Nevada</option>
<option value="TX" selected="selected">Texas</option>
<option value="NY">New York</option>
</select><br>
<input type="submit" ></form></div>


<div class="one"><form action="lab5.php">
<input type="text" name="food" value="Apples">Favorite Food<br>
<input type="text" name="color" value="red">Favorite Color<br>
<input type="text" name="car" value="Ford">Favorite Car<br>
<input type="radio" name="state" value="CA">CA<br>
<input type="radio" name="state" value="NV">NV<br>
<input type="radio" name="state" value="NY" checked="checked">NY<br>
<input type="radio" name="state" value="TX">TX<br>
Favorite Star Trek Series<br>
<select name="trek">
<option value="Original">Original</option>
<option value="Next Gen" selected="selected">Next Gen</opton>
<option value="DS9">DS9</option>
<option value="Voyager">Voyager</option>
<option value="Enterprise">Enterprise</option>
</select><br>
<input type="submit" ></form></div>



<div class="one"><form action="lab5.php">
<input type="text" name="fname" value="Bob">First name<br>
<input type="text" name="lname" value="Smith">Last name<br>
<input type="radio" name="color" value="red">Red<br>
<input type="radio" name="color" value="yellow" checked="checked">Yellow<br>
<input type="radio" name="color" value="blue">Blue<br>
<input type="radio" name="color" value="green">Green<br>
<input type="checkbox" name="animal[]" value="Cat" checked="checked">Cat<br>
<input type="checkbox" name="animal[]" value="Dog" checked="checked">Dog<br>
<input type="checkbox" name="animal[]" value="Horse" checked="checked">Horse<br>
<input type="submit" ></form></div>



<?php
if(!empty($_GET))
{
outputall();
}
?>





</body>
</html>