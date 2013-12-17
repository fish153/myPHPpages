<?php
	/* ADD IN YOUR PERSONAL INFORMATION*/

$host = "localhost";
$user = "kubrakk";
$pass = "1186601";
$db = "kubrakk";


/* CONNECT SCRIPT*/

function connect($host, $user, $pass, $db) 
{
$link = mysql_connect($host, $user, $pass) or die("Could not connect");
mysql_select_db($db) or die("Couldn't open database ".mysql_error());
return $link;
}



/* This fixes the strings. There are a bunch of textareas in this page that may have
 single quotes, double quotes, and returns where you'll want line breaks. This 
 changes the characters to the appropriate code.*/

function fixstrings($str)
{
$str = preg_replace("/\'/", '&#39;', $str);
$str = preg_replace("/\"/", '&#34;', $str);
$str = preg_replace("/\r/", '<br/>', $str);
$str = stripslashes($str);
return $str;
}




/* This reverses the fix for the 'EDIT' features. Otherwise you'll end up with strange 
characters in the form boxes.*/

function revfixstrings($str)
{
$str = preg_replace("/&#39;/", "'", $str);
$str = preg_replace("/&#34;/", '"', $str);
$str = preg_replace("/\<br\/\>/", "\r", $str);
return $str;
}






/*Select bloggers drop down menu.*/

function blognames($id='')
{
$query = "select * from bloggers order by bloggername";
$result = mysql_query($query);
print "<select name='bloggerid'>";
	while($row = mysql_fetch_row($result))
	{
	list($bloggerid, $bloggername, $bloggermail) = $row;
		if($id == $bloggerid)
		{
		print "<option value='$bloggerid' selected='selected'>$bloggername</option>";
		}
		else
		{
		print "<option value='$bloggerid'>$bloggername</option>";
		}
	}
print "</select>";
}




function messageForm($id='', $message='')
{
	print "<form method='post' action='index.php'>
	<table  style='float: left'>
	<caption>ADD MESSAGES</caption>
	<tr>
		<td>
		Name of Blogger<br/>";
		blognames($id);

	print "</td></tr><tr><td>
	<textarea name='message' cols='30' rows='6'>$message</textarea></td></tr><tr>
	<td><input type='submit' name='addmessage2' value='post'/></td></tr></table></form>";
	
}

function bloggerForm($name='',  $email='', $message='')
{
	print "<form method='POST' action='index.php'>
				<table style='float: left'>
				<caption>ADD BLOGGER</caption>
					<tr>
						<td width='300'>
							<b>RULE: All bloggers listed must have at least 1 message. 
							So when a new blogger is added, they must also post an inital message.</b>
						</td>
					</tr>
					<tr>
						<td>
							Blogger Name: <input type='text' name='bloggername' value='$name' />
						</td>
					</tr>
					<tr>
						<td>
							Blogger Email: <input type='text' name='bloggeremail' value='$email' />
						</td>
					</tr>
					<tr>
						<td>
							Inital Message: <br/><textarea cols='30' rows='6' name='message'>$message</textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='addblogger2' value='Add'/>
						</td>
					<tr>
				</table>
			</form>";
}

function editForm($id='', $mid='', $message)
{
	print "

	<form method='post' action='index.php'>
		<table  style='float: left'>
			<caption>EDIT MESSAGES</caption>
				<tr>
					<td>
					<input type='hidden' name='messageid' value='$mid'/>
						<textarea cols='40' rows='6' name='message'>$message</textarea>
					</td>
				</tr>
				<tr>
					<td width='150'>
						Written By:
			";
	blognames($id);
	print 	"	
						<input type='hidden' name='bloggeridold' value='$id'/>
							<br/>
							<b>RULE: </b> 
							You can only change the blogger's id if they have more than one message. 
							If they only have 1 message, changing their name would leave 
							you with a blogger in the database with no messages which is against our rules.
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align: right'/>
						<input type='submit' name='editmessage2' value='Edit Message' />					
					</td>
				</tr>
		</table>
	</form>
			";
}

function EditMessage($messageId, $bloggerId)
{
		$getMessageQuerry = "SELECT message  FROM blogposts WHERE messageid='$messageId' and bloggerid=$bloggerId";
		$result = mysql_query($getMessageQuerry);
		$row = mysql_fetch_row($result);
		$message = $row[0];
		$message = revfixstrings($message);
		editForm($bloggerId, $messageId, $message);

}

function IfItLastPost($bloggerId, $querryIf, $querryElse, $alertIf, $alertElse)
{
	$checkHowManyPostsHasBloggerId = "SELECT * FROM blogposts WHERE bloggerid='$bloggerId'";
	if(mysql_num_rows(mysql_query($checkHowManyPostsHasBloggerId)) == 1)
	{
		mysql_query($querryIf);
		print $alertIf;
	}
	else
	{
		mysql_query($querryElse);
		print $alertElse;
	}
}



/* Display the table with all information. The EDIT, DELETE, ADD BLOGGER, ADD POST 
triggers are listed here.*/

function showblogtable()
{
	if(isset($_GET['choice']))
	{
	$choice = $_GET['choice'];
	}
	else
	{
	$choice = "date desc, time desc";
	}

$query = "select bloggers.bloggerid, bloggername, bloggeremail, messageid, message, date, time from bloggers, blogposts where bloggers.bloggerid=blogposts.bloggerid order by $choice";
$result = mysql_query($query);


print "<table >
<tr><th colspan='7'><a href='index.php?addmessage=yes'>Post Message</a> | 
<a href='index.php?addblogger=yes'>Add New Blogger</a></td></tr>
<tr>
<th>Edit</th>
<th>Delete</th>
<th><a href='index.php?choice=bloggername, date, time'>Blogger Name</a></th>
<th><a href='index.php?choice=bloggeremail, date, time'>Email</a></th>
<th><a href='index.php?choice=message, date, time'>Message</a></th>
<th><a href='index.php?choice=date desc, time desc'>Timestamp</a></th>
</tr>";

	while($row = mysql_fetch_row($result))
	{
	list($bloggerid, $bloggername, $bloggeremail, $messageid, $message, $date, $time) = $row;
	print "<tr>
	<td><a href='index.php?editmessage=yes&messageid=$messageid&bloggerid=$bloggerid'>Edit</a></td>
	<td><a href='index.php?deletemessage=yes&messageid=$messageid&bloggerid=$bloggerid' 
	onclick='return confirm(\"Are you sure\")'>Delete</a></td>
	<td>$bloggername</td>
	<td>$bloggeremail</td>
	<td style='width: 200'>$message</td>
	<td>$date $time</td>
	</tr>";
	}
print "</table>";
}





?>
