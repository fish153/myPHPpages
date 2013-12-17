<?php
//Functions for final project CISW410

$host = 'localhost';
$user = 'kubrakk';
$pass = '1186601';
$db = 'kubrakk';
$tb = 'employees';





function condb($host, $user, $pass, $db)
{
	$link = mysql_connect($host, $user, $pass) or die('Check server name or password');
	$dbase = mysql_select_db($db) or die();
}

function GrabUser()
{
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$userid = $_SESSION['userid'];

	return array($fname, $lname, $userid);
}
// append a sting into the logfile
function Logger($info)
{
	$filename = "logfile.txt";

	$fp = fopen($filename, 'a') or die("Upss, seems there is a problem with the log file");  
	flock($fp, LOCK_EX); 
	fwrite($fp, "$info\n");  
	flock($fp, LOCK_UN); 
	fclose($fp); 

}
// return a string which contains user's name, date, time, and IP address
function LogInInfo()
{
	list($fname, $lname, $userid) = GrabUser();
	$day = date("l, F d ");
	$time = date("H:i:s");
	$info = 	$fname . ' ' . 
				$lname  . ' ' . 
				'logged IN on ' .
				$day . ' at ' .
				$time . 
				' client IP: ' . $_SERVER['REMOTE_ADDR'] ;
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$info .= ' forwarded from IP ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	return $info;
}
// print content of the logfile.txt
function ReadLogFile()
{
	$filename = "logfile.txt";
	$fp = fopen($filename, "r") or die("Sorry2"); 
	while(!feof($fp)) 
	{
		  $line = fgets($fp, 1000);
		  print "$line<br>";
	}


}
// authenthicate a user
function AuthOn($fname, $lname, $password)
{
	//$fname = trim($_POST['fname']);
	//$lname = trim($_POST['lname']);
	//$password = trim($_POST['password']);



$query = 	"SELECT * 
			FROM 	users 
			WHERE 
					fname='$fname' 
				AND 
					lname='$lname'
				AND 
					password='$password'
			";


$result = mysql_query($query);
	if(mysql_num_rows($result) != 0)
	{
	$_SESSION['authenticLog322a'] = "validUser324b";
	
	$row = mysql_fetch_row($result);
	list($userid, $fname, $lname, $password) = $row;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['userid'] = $userid;
	unset($_SESSION['pageN']);
	unset($_SESSION['totalPages']);
	$info = LogInInfo();
	Logger($info);
	return True;
	}
	else
	{
	$_SESSION['authenticLog322a'] = "NotValidUser";
	return False;
	}
}

function LogOut()
{
	session_start();
	list($fname, $lname, $userid) = GrabUser();
	$day = date("l, F d ");
	$time = date("H:i:s");
	$info = 	$fname . ' ' . 
				$lname  . ' ' . 
				'logged OUT '   . 'on ' .
				$day . ' at' .
				$time ;
	Logger($info);
	session_destroy();
	unset($_SESSION['pageN']);
	unset($_SESSION['totalPages']);
	print "<p>You are logged out</p>
			<p>Please <a href='login.php'>log in</a> or <a href='index.php'>go to the home page</a></p>";
}
// print log in form; if $logInType = 1, generates the same form for a new user
function LogInForm($logInType='', $fname='', $lname='')
{

	if(isset($_GET['user'])){
		if($_GET['user'] == 'new'){
			$button = "new";
			$buttonText = "Create Account";
			$headerLine ="<h2><a href='login.php?user=exist'>Returning User</a> | New User </h2> ";
		}
		elseif ($_GET['user'] == 'exist' ) {
			# 
			$button = "old";
			$buttonText = "Log In";
			$headerLine = "<h2>Returning user | <a href='login.php?user=new'> New User</a>";
		}	
	}
	else{
		if($logInType == '1'){
			$button = "new";
			$buttonText = "Create Account";
			$headerLine ="<h2><a href='login.php?user=exist'>Returning User</a> | New User </h2> ";
		}
		elseif ($logInType == 2) {
			# 
			$button = "old";
			$buttonText = "Log In";
			$headerLine = "<h2>Returning user | <a href='login.php?user=new'> New User</a>";
		}
		else{
			$button = "old";
			$buttonText = "Log In";
			$headerLine = "<h2>Returning user | <a href='login.php?user=new'> New User</a>";
		}
	}


	print "
	$headerLine\n
	<form method='post' action='login.php'>
	<table>
		<tr>
			<td>
				First Name:
			</td>
			<td> 
				<input type='text' name='fname' value=\"$fname\" />
			</td>
		<tr>
			<td>
				Last Name: 
			</td>
			<td>
				<input type='text' name='lname' value=\"$lname\"/>
			</td>
		<tr>
			<td>
			Password:
			</td>
			<td> 
				<input type='password' name='password'>
			</td>
		<tr>
			<td colspan=2>
				<input type='submit' name='$button' value='$buttonText'>
			</td>

		<tr>
	</table>

	</form>
	";
}

// check up information from login form; 
// if everything is correct -- authenticate user user AuthOn function
function LogIn($logInType, $fname, $lname, $password)
{


	$status = array("fname" => 0, "lname" => 0, "pass" => 0);
	$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	// check every field in nested if statements	
	if(preg_match($re, $fname)){
		//$fname = html_entity_decode($fname,  ENT_QUOTES);
		//$lname = html_entity_decode($lname, ENT_QUOTES);

		$fname = htmlentities($fname, ENT_QUOTES);
		$status['fname'] = 1;
		

		}
	else
	{
		$message = "<span class='alert' >Check first name</span>\n";

	}

	if(preg_match($re, $lname)){
			$lname = htmlentities($lname, ENT_QUOTES);
			$status['lname'] = 1;

		}
		else
		{
			$message .= "<span class='alert'>Check last name</span>\n";
	
		}

	$repass = "/\S+/";
	if(preg_match($repass, $password)){
		$status['pass'] = 1;

	}
	else
	{
		$message .= "<span class='alert'>Password cannot be empty</span>\n";


	}

	if($status['fname'] == 1 and $status['lname'] == 1 and $status['pass'] == 1){
		if($logInType == 2){
			if(AuthOn($fname, $lname, $password)){

				header( 'Location: index.php' ) ;
			}
			else
			{
				print "<p class='alert'>Entered Combination First name/Last name/ Password does not match.<br>
						Try again</p> ";
				$day = date("l, F d ");
				$time = date("H:i:s");
				$info = 	'Unsuccessful attempt to authorize ' . 
							$fname . ' ' .
							$lname . ' on ' .
							$day . ' at' .
							$time . 
							' client IP: ' . $_SERVER['REMOTE_ADDR'] ;
				if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
					$info .= ' forwarded from IP ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
				}
				Logger($info);
				LogInForm($logInType, $fname, $lname);
			}
   			
		}
		elseif ($logInType == 1) {
			# 

			$checkNewUserNameQuery = "SELECT fname, lname FROM users WHERE fname='$fname' and lname='$lname'";

			if(mysql_num_rows(mysql_query($checkNewUserNameQuery)) == 0){
				$newUserQuery = "INSERT INTO users VALUES('','$fname', '$lname', '$password')";
				mysql_query($newUserQuery);
							AuthOn($fname, $lname, $password);
				   			header( 'Location: index.php' ) ;
			}
			else
			{
				$message .= "<span class='alert'>User &#171; $fname $lname &#187; already exists</span>\n";
				print $message;
				LogInForm($logInType, $fname, $lname);
			}


		}
	}
	else
	{
		$message .= "<span class='alert'>Make necessary changes in the form</span>\n";
		print $message;
		LogInForm($logInType, $fname, $lname);
	}

}
// print upload form
function UploadForm()
{
	print "
	<div class='topTable'>
	<form enctype='multipart/form-data' action='index.php' method='post' >
	<input type='hidden' name='MAX_FILE_SIZE' value='900000'>
	<table>
		<tr>
			<td>
				Choose a picutre:
			</td>
			<td>
				<input type='file' name='image' >
			</td>
			<td>
				<input type='submit' name='imageup' value='Upload Picture'>
			</td>
		</tr>
	</table>
	</form>
	</div>
	";
}

// thumbnail generator; takes type of image - [jpeg, jpg, gif, png ] and file name
function TumbImage($type, $file)
{
ini_set ("memory_limit", "100M");
$mydir = getcwd();
$tempDir = '../ui/t/';
$filePath = '../ui/'.$file;

switch ($type)
{
	case "jpeg": $tempbig = imagecreatefromjpeg($filePath);
		break;
	case "jpg":  $tempbig = imagecreatefromjpeg($filePath);
		break;
	case "png": $tempbig = imagecreatefrompng($filePath);
		break;
	case "gif": $tempbig = imagecreatefromgif($filePath);
		break;
	

}

	 

		$imageSize = getimagesize($filePath);
		$imW = $imageSize[0];
		$imH = $imageSize[1];
		$proportion = $imW/$imH;
		$width = 200;
		$height = 200/$proportion;
		$tempsmall = imagecreatetruecolor(200, $height); 

	imagecopyresized($tempsmall, $tempbig, 0, 0, 0, 0, $width, $height, $imW, $imH); 
	$path = '../'.$file;
	chdir($tempDir);
	switch ($type)
	{
		case "jpeg": imagejpeg($tempsmall, $file, 95);
				break;
		case "jpg":  imagejpeg($tempsmall, $file, 95);
				break;
		case "png": imagepng($tempsmall, $file);
				break;
		case "gif": copy($path, $file);//imagegif($tempsmall, $file);
				break;                  ### GD cannot work properly with animated GIF wich makes tumbnails of Gifs 
							### unuseful; so let just copy gifs into t folder :-) just for now
		

	}

	ImageDestroy($tempbig); 
	ImageDestroy($tempsmall); 
	chdir($mydir);
}


// print a form to add uploaded image to the database; 
//if $action = 0, add a new image; 
//if action something else -- edit image
function AddImageForm($fileName, $shortname='', $description='', $action='0')
{
	if($action == 0){
		$title = 'Add Image';
		$editButtonName = 'insert';
		$deleteButtonName = 'deleteImage';
		$actionLink = 'index.php';
		$deleteButtonTag ="<input type='submit' name='$deleteButtonName' value='Delete'>";


	}
	else
	{
		$title = 'Edit Entry';
		$editButtonName = 'update';
		$deleteButtonName = 'deleteAll';
		$actionLink = 'editImage.php';
		$deleteButtonTag ="<input type='submit' name='$deleteButtonName' value='Delete'>";
	}
	print "
	<form method='post' action='$actionLink'>

		<h2>
			$title
		</h2>

		<table border=1>
			<tr>				
				<td rowspan=4>
					<img alt='Image to upload' src='../ui/t/$fileName' >
					<input type='hidden' name='filename' value='$fileName'>
					
				</td>
			</tr>
			<tr>
				<th>
					Name
				</th>
				<td>
					<input type='text' name='shortname' 
					placeholder='Give this picture a short name' 
					value='$shortname' >
				</td>
			</tr>
			<tr>
				<th>
					Description:
				</th>
				<td>
					<textarea placeholder='Describe your image...' name='description'  
					rows='4' cols='50' >$description</textarea>
				</td>
			</tr>
			<tr>
				<td >
					<input type='submit' name='$editButtonName' value='$title'>
				</td>	
				<td>
					$deleteButtonTag
			</tr>
		</table>

	";
}

// 
function AddImageSQLCore($imName, $imFile, $imDescript, $userid)
{
	$addImageQuery = "INSERT INTO 
							files 
						VALUES('', 
								'$imName', 
								'$imFile', 
								'$imDescript', 
								CURDATE(),  
								CURTIME()) ";
	// print $addImageQuery;
	$findImgIdQuery = "SELECT 
							fileid 
						FROM 
							files 
						WHERE 
							shortname='$imName' 
							AND 
							filename='$imFile'";
	// print $findImgIdQuery;

	if(mysql_query($addImageQuery)){
		if($row = mysql_query($findImgIdQuery)){
			list($fileId) = mysql_fetch_row($row);
			$addToOwnersQuery = "INSERT INTO owners VALUES('', '$fileId', '$userid') ";
			// print $addToOwnersQuery;
			if(mysql_query($addToOwnersQuery)){
				print "<p>The image has been added to the database</p>";
			}
			else
			{
				$message .= "Upss - was not able to add to owners";
			}
		}
		else
		{
			$message .= "Upss... was not able to find file's ID";
		}

	}
	else
	{
		$message .= "Upss... was not able to add to files";

	}
}

function UpdateImageSQLCore($imName, $imDescript,  $fileId)
{
	$editImageQuery = "UPDATE   
							files 
						SET  
							shortname='$imName', 							 
							description='$imDescript', 
							date=CURDATE(),  
							time=CURTIME()
						WHERE
							fileid='$fileId'
						";
	print $editImageQuery;

		if(mysql_query($editImageQuery)){

			return True;
		}
		else
		{
			$message .= "Upss... was not able to update the tables";
			return False;
		}


}

function AddImage($imName, $imDescript, $imFile, $userid, $action)
{
	//$status = array("name" => False, "descr" => False, "file" => False);
	$status = array("name" => False, "description" => False, "file" => False, "user" => True);
	if(!empty($imName))
	{
		$imName = htmlentities($imName, ENT_QUOTES);
		$status{'name'} = True;

	}
	else
	{
		$message = "Check picture's name\n";
	}

	if(!empty($imDescript)){
		
		$imDescript = htmlentities($imDescript, ENT_QUOTES);
		$status{'description'} = True;
	}
	else
	{
		$message .= "Check picture's description.\n";
	}

	if(file_exists("../ui/$imFile")){
		$status{'file'} = True;
	}
	else
	{
		$message .= "Picture does not exists. Upload again.";
	}

	$checkUserQuery = "SELECT * FROM users WHERE userid='$userid'";
	if(mysql_num_rows(mysql_query($checkUserQuery)) == 1){
		$status{'user'} = True;
	}


	if($status{'name'} && $status{'description'} &&  $status{'file'} && $status{'user'}){



			AddImageSQLCore($imName, $imFile, $imDescript, $userid);
			



	}
	else
	{
		print "<p class='alert'> $message </p>";
		AddImageForm($imFile, $imName, $imDescript, $action);
	}
}

function EditImage($imName, $imFile, $imDescript,  $fileId)
{
	//$status = array("name" => False, "descr" => False, "file" => False);
	$status = array("name" => False, "description" => False);
	if(!empty($imName))
	{
		$imName = htmlentities($imName, ENT_QUOTES);
		$status{'name'} = True;

	}
	else
	{
		$message .= "Check picture's name\n";
	}

	if(!empty($imDescript)){
		
		$imDescript = htmlentities($imDescript, ENT_QUOTES);
		$status{'description'} = True;
	}
	else
	{
		$message .= "Check picture's description.\n";
	}




	if($status{'name'} && $status{'description'} ){


		if(UpdateImageSQLCore($imName, $imDescript, $fileId)){
			return True;
			header( 'Location: index.php' ) ;
		}
		else
		{
			print $imFile;
			print $fileId;
		}



	}
	else
	{
		print "<p class='alert'> $message </p>";
		AddImageForm($imFile, $imName, $imDescript, 1);
	}
}
// remove image from the image folder using unling function
function DeleteImage($imFile)
{
	$image = '/home/kubrakk/public_html/cisw410/ui/'.$imFile;
	unlink($image);
	
	$image = '/home/kubrakk/public_html/cisw410/ui/t/'.$imFile;
	unlink($image);
	
	list($fname, $lname, $userid) = GrabUser();
	$info = $fname . ' ' . $lname . ' removed an image: ' . $imFile;
	Logger($info);
	return(True);

}
// delete image from tables and call DeleteImage function
function DeleteImageAll($fileId, $imFile, $ownerId)
{
	$deleteImageFromFiles = "DELETE FROM files WHERE fileid='$fileId' ";
	$deleteImageFromOwners = "DELETE FROM owners 
								WHERE 
									ownerid='$ownerid' 
									AND 
									fileid='$fileId' ";
	if(mysql_query($deleteImageFromFiles) && mysql_query($deleteImageFromOwners)){
		if(DeleteImage($imFile)){
			return True;
		}
		else
		{
			return False;
		}
		
	}
	else
	{
		return False;
	}
}

// 
function UploadImage()
{
	$image = $_FILES['image']['tmp_name'];
	$image_name = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_type = $_FILES['image']['type'];
	$image_error = $_FILES['image']['error'];
	$image_path = '/home/kubrakk/public_html/cisw410/ui/';
	$image_name = time().'_'.$image_name;
	$image_path = $image_path.$image_name;
	$allowedExt = array("gif", "jpeg", "jpg", "png");
	$allowedTypes = array(
							"image/gif", 
							"image/jpeg", 
							"image/jpg", 
							"image/pjpeg", 
							"image/x-png", 
							"image/png"
							);

	$exten = explode(".", $image_name);
	$exten =end($exten);
	if(in_array($image_type, $allowedTypes)) {
		if( in_array($exten, $allowedExt)){
			if( $image_size < 905500){

				if($image_error > 0){
					echo "<p class='alert'>ERROR $image_error</p>\n";
				}
				else
				{
					if(is_uploaded_file($image)){
						if(move_uploaded_file($image, $image_path)){
							list($fname, $lname, $userid) = GrabUser();
							$info = $fname . ' ' . $lname . ' uploaded an image: ' . $image_name;
							Logger($info);
							TumbImage($exten, $image_name);
							return $image_name;
						}
					}
					else
					{
						print "Upload error";
					}
				}
			}
			else
			{
				print "<p class='alert'>File is too big. Resize it using any image editor</p>";
			}
		}
		else
		{
			print "<p class='alert'>Check file extentions. Any other then .jpg, .jpeg, .png, .gif are not allowed</p>";
		}
	}
	else
	{
		print "<p class='alert'>This image format is not allowed</p>";
	}




}

function ShowUsers()
{	
	$query = "SELECT fname, lname, password, userid FROM users";
	$result = mysql_query($query);
	print "
	<table>
		<tr>
			<th>
				Fname
			</th>
			<th>
				Lname
			</th>
			<th>
				Password
			</th>
			<th>
				UserID
			</th>
		</tr>

	";
	while ( $row = mysql_fetch_row($result)) {
		list($fname, $lname, $pass, $userid) = $row;

		print "
			<tr>
				<td>
					$fname
				</td>
				<td>
					$lname
				</td>
				<td>
					$pass
				</td>
				<td>
					$userid
				</td>
			</tr>
		";
	}
	print "</table>";

}
// the most dangerous and complicated 
function ShowPictures($userid='')
{
//	unset($_POST);

	$nameOrder[0] = "4 ASC";
	$nameOrder[1] = "4 DESC";
	$ownerOrder[0] = "3, 2"; 
	$ownerOrder[1] = "3 DESC, 2 DESC";
	$timeOrder[0] = "date DESC, time DESC";
	$timeOrder[1] = "date, time ASC";

	$checkUserQuery = "SELECT * FROM users WHERE userid='$userid'";
	$userStatus = False;
	if(mysql_num_rows(mysql_query($checkUserQuery)) == 1){
		$userPart = "AND users.userid='$userid' ";

		UploadForm();
		$userStatus = True;
	}
	else
	{
		$userPart = '';
	}


	// page navigation
		$entriesPerPage = 4;
		$page = 1;
		$countQuery = "SELECT 
							COUNT(users.userid)
						FROM
							users, 
							owners, 
							files 
						WHERE 
							users.userid=owners.userid and 
							files.fileid=owners.fileid ";
		$countQuery .= $userPart;

		//print $countQuery;
		if(isset($_SESSION['pageN']))
		{
			
			if(isset($_GET['page'])){
				$page = $_GET['page'];
				$_SESSION['pageN'] = $page;
			}
			else
			{
				
				$page = $_SESSION['pageN'];
			}
			
		}
		else
		{
			$row = mysql_fetch_row(mysql_query($countQuery));
			list($numberEntries) = $row;
			$totalPages = ceil($numberEntries/$entriesPerPage);
			
			unset($_SESSION['totalPages']);
			$_SESSION['totalPages']	 = $totalPages;	
			$_SESSION['pageN'] = $page;
		}
		$offset = ($page - 1) * $entriesPerPage;
		$limit = "LIMIT $offset, $entriesPerPage ";

		

// ORDER BY part of the function
	$orderBy = "ORDER BY ";
/*	
	if(isset($_SESSION['sort'])){
		$sorter = $_SESSION['sort'];

	}
	else
	{
		$sorter = $nameOrder[0];
	}
*/
	$sorter = $nameOrder[0];
	$first = 1;
	$second = 0;
	$third = 0;
	$stringDirection = "Newest First";
	$_SESSION['order'] = 'name=0';
	if(isset($_GET['name'])){
		$_SESSION['order'] = 'name=' . $_GET['name'];
		if($_GET['name'] == 1){
			$sorter = $nameOrder[1];
			$first = 0;
		}
		else
		{
			$sorter = $nameOrder[0];
		}
	}


	if(isset($_GET['owner'])){
		$_SESSION['order'] = 'owner=' . $_GET['owner'];
		if($_GET['owner'] == 0){
			$sorter = $ownerOrder[0];
			$second = 1;
		}
		else
		{
			$sorter = $ownerOrder[1];
		}

	}

	if(isset($_GET['time'])){
		$_SESSION['order'] = 'time=' . $_GET['time'];
		if($_GET['time'] == 0){
			$sorter = $timeOrder[0];
			$third = 1;
			$stringDirection = "Oldest First";	
		}
		else
		{
			$sorter = $timeOrder[1];
		}
	}





// THE QUERY
	$grabPicturesAndDataQuery = "SELECT 
					users.userid, 
					users.fname, 
					users.lname, 
					files.shortname, 
					files.filename, 
					files.description,
					DATE_FORMAT(files.date, ' %b %d %Y'),
					TIME_FORMAT(files.time, '%H : %i'),
					files.fileid,
					owners.ownerid
				FROM
					users, 
					owners, 
					files 
				WHERE 
					users.userid=owners.userid and 
					files.fileid=owners.fileid ";
	$grabPicturesAndDataQuery .= $userPart;
	$grabPicturesAndDataQuery .= $orderBy;
	$grabPicturesAndDataQuery .= $sorter;
	$grabPicturesAndDataQuery .= ' ';
	$grabPicturesAndDataQuery .= $limit;
	//print $grabPicturesAndDataQuery;
	$result = mysql_query($grabPicturesAndDataQuery);


	$linkSortByName = "<a href=\"index.php?name=$first\">Name 
						<img class='ico' src=\"i/$first.png\" ></a>";
	
	$linkSortByOwner = "<a href=\"index.php?owner=$second\">Owner 
						<img class='ico' src=\"i/$second.png\" ></a>";

	$linkSortByDate = "<a href=\"index.php?time=$third\">$stringDirection</a>";

	$linkVeiwAllImages = "<a href=\"index.php?view=1\">View All pictures</a>";
	$linkVeiwMine = "<a href=\"index.php?view=0\">View my pictures only</a>";
	$picturesTable = "<div class='topTable'> 
				<span class=''>Sort by: 
					$linkSortByName | 
					$linkSortByOwner | 
					$linkSortByDate
				</span>
			</div>
			";

	if(mysql_num_rows($result) == 0){
	
		$picturesTable .= "<div class='topTable'>
				<span>You do not have any pictures</span>
		</div>
		";
		}

/*
	if($userStatus){
	$grabUsersPicsQuery = 	"SELECT 
								files.fileid 
							FROM 
								files, 
								owners, 
								users
							WHERE
									owners.fileid=files.fileid
								AND 
									users.userid=owners.userid
								AND
									users.userid='$userid'
						";
 //select files.fileid from files, owners, users where owners.fileid=files.fileid and users.userid=owners.userid and users.userid=1;


	$grabUsersPicsQuery .= $userPart;
	// print $grabUsersPicsQuery;

	$usersPicsArray = mysql_fetch_array(mysql_query($grabUsersPicsQuery));
	}
	print_r ($usersPicsArray);
*/
while($myrow = mysql_fetch_row($result))
	{
	

	list($userId, 
		$fname, 
		$lname, 
		$shortname, 
		$filename, 
		$description, 
		$date, 
		$time,
		$fileId,
		$ownerId
		) = $myrow;

	
	if($userId == $userid){

			$formTagStart = "<form method='post' action='editImage.php'>";
			$editButton = "<input type='submit' name='editImg' value='Edit'>";
			$hiddenImageField = "<input type='hidden' name='imageInfo' value='$fileId'>";
			$hiddenOwnerField = "<input type='hidden' name='ownerInfo' value='$ownerId'>";
			$hiddenNameField = "<input type='hidden' name='imageShortName'  value='$shortname'> ";
			$hiddenDescrField = "<input type='hidden' name='imageDescript' value='$description'> ";
			$hiddenFile = "<input type='hidden' name='imageFile' value='$filename' >";
			$tableAddition = "
			<tr>
				<th>
					Actions:
				</th>
				<td>
					
					$editButton 
					$hiddenImageField
					$hiddenOwnerField
					$hiddenNameField
					$hiddenDescrField
					$hiddenFile
		
				</td>
			</tr>
			";
			$formTagEnd = "</form>";


		
	}
	else
	{

			$formTagStart = '';
			$editButton = '';
			$hiddenImageField = '';
			$hiddenOwnerField = '';
			$hiddenNameField = '';
			$hiddenDescrField = '';
			$hiddenFile = '';
			$tableAddition = '';
			$formTagEnd = '';
	};


	$picturesTable .=" 
		
		<div class=\"topTable\">
			<h2>
				$shortname 
			</h2>

			<table border=1>

				<tr>

					<th>
						Owner: 
					</th>
					<td>
						$fname $lname
					</td>				
					<td rowspan=4>
						<a href='../ui/$filename' class=\"newWin\"><img alt=\"$shortname\" src='../ui/t/$filename' ></a>
						
					</td>
				</tr>
				<tr>
					<th>
						Date:
					</th>
					<td>
						$date
					</td>
				</tr>
				<tr>
					<th>
						Time:
					</th>
					<td>
						$time
					</td>
				</tr>
				<tr>
					<th>
						Description
					</th>
					<td>
						$description
					</td>
				</tr>
				$formTagStart
				$tableAddition
				$formTagEnd
			</table>
		</div>
		
		";
	
	}

	return $picturesTable;
	
}
?>
