<?php
include("blogfunctions.php");
$link = connect($host, $user, $pass, $db);
?>

<html>
<head><title>Blogger Assignment</title>
<link rel="stylesheet" type="text/css" href="../s/style.css">
<style>
b {color: red;}
</style>
</head>
<body>
<div class="topTable">
<?php









/* +++++++++++++++++++ADD NEW MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ####################### This is the Form to add a new Message. Notice it uses the function
 blognames() which creates the drop down menu listing who the blogger is.  ########## */

if(isset($_GET['addmessage']))
{
	messageForm();
}




/*  ####################### You have to write the second part of the add messages script.
 The steps are written out for you.  ####################### */

if(isset($_POST['addmessage2']))
{
/* Parse in the variables
	if the message has something in it
	fix all the quotes using fixstrings() function
	query to the database to see if the message already exists and get a result
		if the message does not exist
		add it to the table with the bloggerid and CURRENT_DATE, CURRENT_TIME
		else
		Error message for a double post
	else
	Error Message for a blank message field.
*/
	if(isset($_POST['bloggerid']))
	{
		$bloggerid = $_POST['bloggerid'];

		if(!empty($_POST['message']))
		{
			$message = $_POST['message'];
			if(preg_match("/^\s*\S+/", $message)) //a message has to have not only spaces
			{
				$message = trim($message); // delete spaces, tabs, etc.
				$message = fixstrings($message);
				$findTheSameMessagesQuerry = "SELECT * FROM blogposts WHERE message='$message'";
				 
				if(mysql_num_rows(mysql_query($findTheSameMessagesQuerry)) == 0) //
				{
					$insertMessageQuerry = "INSERT INTO blogposts VALUES('', '$message', '$bloggerid', CURDATE(), CURTIME())";
					# print "$insertMessageQuerry";
					mysql_query($insertMessageQuerry);
				}
				else
				{
					print "<p>Plagiat alert! Post an unique message</p>";
					messageForm($bloggerid, $message);
				}
				
			}
			else
			{
				print "<p>A message cannnot be blank</p>";
				messageForm($bloggerid, $message);
			}
		}
		else
		{
			print "<p>Add a message</p>";
			messageForm($bloggerid, $message);
		}
		
	}

}





/* +++++++++++++++++++ADD NEW BLOGGER +++++++++++++++++++++++++++++++++++++++++++++++++++++*/



/*  #######################  I wrote the first step in add a new blogger for you. Note
the field names.  ####################### */




if(isset($_GET['addblogger']))
{
bloggerForm();
}


/*  #######################  You have the write the second part to the ADD NEW BLOGGER script.
 The Steps are written out for you.  ####################### */


if(isset($_POST['addblogger2']))
{
/*
Parse in all variables
	if message isn't blank, and bloggername and bloggeremail pass Regular Expression tests
	fix the message and the bloggername with fixstrings()
	Query to see if bloggername already exists in blogger table and get result
		if bloggername doesn't exist
		insert blogger into blogger table
		query to get the new blogger's newly created bloggerid & get result
		parse out that bloggerid
		insert message into blogpost table with bloggerid, date and time
		else
		Error message for blogger already exists
	else
	Error message for form not filled out properly
*/
	if(!empty($_POST['bloggername']))
	{
		$blogger = $_POST['bloggername'];
		$message = $_POST['message'];
		$email = $_POST['bloggeremail'];

		$ifNameExistsQuerry = "SELECT * FROM bloggers WHERE bloggername='$blogger'";

		if(mysql_num_rows(mysql_query($ifNameExistsQuerry)) == 0)
		{
			if(!empty($email))
			{				
				if(preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email))
				{
					$checkIfEmailExistsQuerry = "SELECT * FROM bloggers WHERE bloggeremail='$email'";
					$result = mysql_query($checkIfEmailExistsQuerry);
						if(mysql_num_rows($result) == 0)
						{
							if(!empty($message))
							{								
								if(preg_match("/^\s*\S+/", $message))
								{
									$message = trim($message);
									$message = fixstrings($message);
									$repeatQ = "SELECT * FROM blogposts WHERE message='$message'";
									 
									if(mysql_num_rows(mysql_query($repeatQ)) == 0)
									{
										$addBloggerQ = "INSERT INTO bloggers VALUES('', '$blogger', '$email')";
										mysql_query($addBloggerQ);
										$bloggeridQ = "SELECT bloggerid FROM bloggers WHERE bloggername='$blogger' AND bloggeremail='$email'";
										# print 
										$row = mysql_fetch_row(mysql_query($bloggeridQ)) ;
										$bloggerid =$row[0];

										$addMessageQ = "INSERT INTO blogposts VALUES('', '$message', '$bloggerid', CURDATE(), CURTIME())";
										# print "$addMessageQ";
										mysql_query($addMessageQ);
									}
									else
									{
										print "<p>Plagiat alert! Post an unique message</p>";
										bloggerForm($blogger, $email, $message);
									}
								}
								else
								{
									print "<p>Nothing to post! Replace spaces with some words!</p>";
									bloggerForm($blogger, $email, $message);
								}
									
							}
							else
							{
								print "<p>A message cannot be empty</p>";
								bloggerForm($blogger, $email, $message);
							}
						}
						else
						{
							print "<p>A blogger with this email <strong>$email</strong> already exists</p>";
							bloggerForm($blogger, $email, $message);
						}
					
				}
				else
				{
					print "<p>Check email format!</p>";
					bloggerForm($blogger, $email, $message);
				}
			}
			else
			{
			print "<p>Email cannto be empty</p>";
			bloggerForm($blogger, $email, $message);
			}
		}
		else
		{
			print "<p>Name has to be unique</p>";
			bloggerForm($blogger, $email, $message);		
		}

	}	
	else
	{
		print "<p>Name is empty</p>";
		bloggerForm($blogger, $email, $message);
	}
	
}


/* +++++++++++++++++++DELETE MESSAGE  +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* #######################  Write the DELETE MESSAGE script. You must follow one basic 
rule with this. If it is the bloggers ONLY message, then you can not delete it.
 You'll need to check to see if mysql_num_rows($result) == 1
to determine this. If it equals 1 then don't delete the message. Otherwise
 go ahead and delete.  ####################### */

if(isset($_GET['deletemessage']))
{
	if(isset($_GET['messageid']) and isset($_GET['bloggerid']))
	{
		$mid = $_GET['messageid']; //message ID
		$bid = $_GET['bloggerid']; // blogger ID
		# querry to delete a post 
		$querryIfMoreThanOne = "DELETE FROM blogposts WHERE bloggerid='$bid' and messageid='$mid'";
		$alertIfOne = "<p>The only post of the author cannot be deleted</p>";
		$alertIfMoreThanOne = "<p>The post has been deleted.</p>";
		# delete post only if author has more than one post
		IfItLastPost($bid, '', $querryIfMoreThanOne, $alertIfOne, $alertIfMoreThanOne);
	}




}





/* +++++++++++++++++++EDIT MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/


/*  #######################  Write the two parts of the EDIT MESSAGE SCRIPT. The user should be able
 to change the actual message, and the name of the person who posted it. BUT YOU MUST 
 FOLLOW THIS RULE: if the message is the only message belonging to a user, you can not 
 change the name of the blogger. If you changed the name that would leave you with a user that 
 has no messages. The steps are written out for you below.  ####################### */




if(isset($_GET['editmessage']))
{
/*
Parse in variables
Query for the message using messageid and get result
Parse out message
Reverse the fix on the message using revfixstrings();
Create form with textarea with the message inside
The form should also hide the messageid inside it
Use the select menu function bloggnames() with bloggerid to create the drop down menu for bloggernames
The form should also hide the ORIGINAL bloggerid inside it (just in case the user changes the blogger)
Submit button needs trigger for part2
*/

	if(isset($_GET['messageid']))
	{
		$mid = $_GET['messageid'];
	}
	if(isset($_GET['bloggerid']))
	{
		$id = $_GET['bloggerid'];
	}
	if(!empty($mid) && !empty($id))
	{
		EditMessage($mid, $id);

	}
	
}


	/*  ####################### part 2  ####################### */

if(isset($_POST['editmessage2']))
{

/*


Parse in the variables
	if message is not empty
	fix message with fixstrings()
	query blogposts to get all messages for the ORIGINAL bloggerid and get result
		if there is only 1 message AND the ORIGINAL bloggerid does not equal the NEW bloggerid
		Update the MESSAGE only. Do not change the bloggerid and Tell user
		the message was changed, but the blogger's name was not changed as
		it would violate the rule of all bloggers must have at least 1 message.
		else
		update the message and bloggerid
				
	else
	error message for blank message field

*/
	if(isset($_POST['messageid']) && isset($_POST['bloggerid']))
	{
		$mid = $_POST['messageid'];
		$id = $_POST['bloggeridold'];
		$nid = $_POST['bloggerid'];
		if(!empty($_POST['message']))
		{
			$message = $_POST['message'];
			if(preg_match("/^\s*\S+/", $message))
			{
				$message = trim($message);
				$message = fixstrings($message);
				$repeatQ = "SELECT * FROM blogposts WHERE message='$message' and messageid<>$mid";
				# querry to update the table with new message, new date, new time, the same author
				$querry = "UPDATE blogposts SET message='$message', date=CURDATE(), time=CURTIME() WHERE messageid='$mid'";
				if(mysql_num_rows(mysql_query($repeatQ)) == 0)
				{
					
					if($nid == $id) // check if author left the same
					{
						
						mysql_query($querry);
						print "<p>The post has been updated.</p>";
					}
					else //check if author changed
					{
						# Querry to update the post with new author
						$querryElse = "UPDATE blogposts SET message='$message', date=CURDATE(), time=CURTIME(), bloggerid=$nid WHERE messageid='$mid'";
						$alertIf = "<p>The post has been updated. <br/>The author remains the same - has only one post. </p>";
						$alertElse = "<p>The post and author have been updated.</p>";
						# change ownership of the post only if author has more than one post
						IfItLastPost($id, $querry, $querryElse, $alertIf, $alertElse);
						
					}
				}
				else
				{
					print "<p>Plagiat alert! Make an unique post. Reedit again</p>";
					EditMessage($mid, $id);
				}
				
			}
			else
			{
				print "<p>Nothing to post. Add a few words between spaces</p>";
				EditMessage($mid, $id);
			}
		}
		else
		{
			print "<p>Textarea is empty. Emptiness is not allowed</p>";
			EditMessage($mid, $id);

		}
	}
	
}









/*  ####################### This line right here calls the function that is displaying the 
table to the screen with all the triggers to EDIT, DELETE, ADD POST, ADD Blogger  #######################  */


showblogtable();


?>

</div>
</body>
</html>
