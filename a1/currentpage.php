<html>
<head>
        <title>Index Page</title>
<link rel="stylesheet" type="text/css" href="mystyles.css" />
</head>


<body>
<table border="0" cellpadding="0" cellspacing="0" class="maintb" >


<!-- ************ Round corners at top left and right ************ -->
<tr>
<td class="c"><img src="graphics/topleft.jpg" alt='left corner' /></td>
<td class="m"> &nbsp;</td>
<td class="c" width="28px"><img src="graphics/topright.jpg" alt='right corner' /></td>
</tr>



<!-- ********************** Logo ********************** -->
<tr>
<td colspan="3"  class="logobar">
	<img src="graphics/logo2.jpg" alt="Home Page"  />
</td>
</tr>



<!--  ********************** Menu Bar ********************** -->
<tr>
<td colspan="3">
<h5>
<?php
	include 'menu.php';
?>
</h5>
</td>
</tr>


<!-- 
******************************************************************
********************* START Body of Web Page *********
******************************************************************* -->
<?php
	$id = $_GET['p']; # assign global variable id to local id

	# if $id does not equal 2 or 3 or is empty, insert the content from page 1 
	if (($id != 2 and $id != 3) or empty($id))
	{
		include('1.php');
		}
	# insert   page 2 if $id equals 2
	if ($id == 2)
	{
		include('2.php');
		}
	# insert  page 3 if $id equals 3
	if ($id == 3)
	{
		include('3.php');
		}
?>


<!-- 
****************************************************************
***************** END Body of Web Page *************************
****************************************************** -->






<!-- *********** Rounded corners at bottom of page  *********** -->

<tr>
<td class="c"><img src="graphics/bottomleft.jpg" alt='left' /></td>
<td class="m"> &nbsp;</td>
<td class="c"><img src="graphics/bottomright.jpg" alt='right' /></td>
</tr>


</table>
</body>
</html>
