<?php
session_start();
	include('pro.php');
	condb($host, $user, $pass, $db);
	if($_SESSION['authenticLog322a'] == "validUser324b")
	{
		list($fname, $lname, $userid) = GrabUser();
	}
?>
<html>
<head>
	<title>
		Edit Image
	</title>
	<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>
<body>
	<div class="topTable">

			
<?php
	if($_POST['editImg']){

		$ownerId = $_POST['ownerInfo'];
		$userId = $_POST['imageInfo'];
		$imName = $_POST['imageShortName'];
		$imDescript =$_POST['imageDescript'];
		$imFile = $_POST['imageFile'];


	print "<div class='topTable' >";
	AddImageForm($imFile, $imName, $imDescript,  1);
	print "<input type='hidden' name='ownerInfo' value='$ownerId'>";
	print "<input type='hidden' name='imageInfo' value='$userId'> ";

	print "</div>";

	}

	if($_POST['update']){
		$ownerId = $_POST['ownerInfo'];
		$fileId = $_POST['imageInfo'];
		$imName = $_POST['shortname'];
		$imDescript =$_POST['description'];
		$imFile = $_POST['filename'];
		print $_POST['imageInfo'];
		if(EditImage($imName, $imFile, $imDescript,  $fileId)){
			header( 'Location: index.php' ) ;
		}

	}
	
	if($_POST['deleteAll']){
		$ownerId = $_POST['ownerInfo'];
		$fileId = $_POST['imageInfo'];
		$imFile = $_POST['filename'];
		if(DeleteImageAll($fileId, $imFile, $ownerId)){
			
			header( 'Location: index.php' );
		}
			
	}
	

?>
		</div>

	</div>

</body>
</html>
