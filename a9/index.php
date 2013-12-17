<?php
session_start();
	include('pro.php');
	condb($host, $user, $pass, $db);

	if($_SESSION['authenticLog322a'] == "validUser324b")
	{
		list($fname, $lname, $userid) = GrabUser();
	}
	else
	{
		$fname = 'Guest';
	}
$today = date("M-d");
?>

<html lang="en">

<head>
	<title>Pictures</title>
	<link rel="stylesheet" type="text/css" href="../s/style.css">
	<script type="text/javascript" src="script.js"></script>
</head>

<body>
<div class="top">
	<div class="topLeft">
		
<?php
			echo "<span class='date'>";
			echo date("l, F d ");
			echo "</span>
				<span class='time'>";
			echo date("H:i:s");
			echo "</span>";
?>
	</div>
	<div class="topRight">
		<ul>
<?php
			

			// print $userid;
			if($fname == 'Guest'){
				print "<li><a href='login.php'>Log in | Sign in</a></li>";
			}
			else
			{
				print "<li><a href='logout.php'>Log Out</a></li> ";
				print "<li><a href='logfile.php' target='_blank'>View Logs</a></li>";
			}
			print "<h1 class='name' >Hello $fname  $lname</h1>\n";
?>
		</ul>
	</div>
</div>

<?php

	//print "<div class='topTable'>";
if($_POST['imageup']){
	$imgName = UploadImage();
	if(!empty($imgName)){
		AddImageForm($imgName);
	}

}
if($_POST['deleteImage']){
	$imFile = $_POST['filename'];
	if(DeleteImage($imFile)){
		print "<span class='alert'>Your image has been deleted</span>";
	}
}
	// print "</div>";
if($_POST['insert']){
	$imShortName = trim($_POST['shortname']);
	$imDesript = trim($_POST['description']);
	$imFile = $_POST['filename'];
	AddImage($imShortName, $imDesript, $imFile, $userid, 0);
}



$pictures = ShowPictures($userid);
$totalPages = $_SESSION['totalPages'];

$page = $_SESSION['pageN'];

$order  = $_SESSION['order'];

$nextPage = $page + 1;
$prevPage = $page -1;

$pageNav = "<div class='topTable'>
		<table>
			<tr>
				";
if($prevPage > 0){	
			
			$pageNav .= "
				<td>
					<a href='index.php?page=$prevPage&$order'>Previous</a>
				</td>";
	}
if($page == 1){
	$firstPageLink = 'First page';
}
else
{
	$firstPageLink = "<a href='index.php?page=1&$order'>First page</a>";
}

if($page == $totalPages){
	$lastPageLink = 'Last Page';

}
else
{
	$lastPageLink = "<a href='index.php?page=$totalPages&$order'>Last Page</a>";
}
$pageNav .= "
			<td>
				$firstPageLink
			</td>
			<td>
			";
for($i = 2; $i <= ($totalPages - 1); $i++){
	if($i != $page){
		$pageNav .= "<a href='index.php?page=$i&$order'>$i</a>
					";
	}
	else
	{
		$pageNav .= "$i
						";
	}
		$pageNav .= "</td>
					<td>
					";
}


	$pageNav .= "<td>
						$lastPageLink
					</td>
				";
	if($page != $totalPages){
		$pageNav .= "<td>
					<a href='index.php?page=$nextPage&$order'>Next</a>
				</td>
			";
	}
	$pageNav .= "</tr>
		</table>
	</div>
	";
	print $pageNav;
	print $pictures;
	print $pageNav;
?>



</body>
</html>
