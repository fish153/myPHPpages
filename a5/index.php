<?php
session_start();
include('function.php');
condb($host, $user, $pass, $db);
if($_SESSION['authenticLog322a'] != "validId333")
{
	AuthOn();
}
?>

<html>
<head><title>Employees table</title>
<link rel="stylesheet" type="text/css" href="../s/style.css">


</head>

<body>
<div class="topTable">
<?php
if(isset($_GET['logout']))
{
	LogOut();

}
else
{



	if($_SESSION['authenticLog322a'] != 'validId333')
	{
		LogInForm();
	}
	else
	{

		list($fname, $lname, $level) = GrabUser();

		print "<h2>Welcome $fname $lname!</h2>"; 
		print "<p><a href='index.php?logout=yes'>Log out</a><p>";
		print "<p>Security level: $level</p>";




		
		$add = $_POST['add'];# when add button clicked
		$new = $_POST['new'];# new employee button 
		$employeeid = $_GET['employeeid'];




					
					
		# ###### DELETE a record ####################				
		if(isset($_GET['delete']) and $_GET['delete'] == 'yes')
		{
			if($_SESSION['level'] == 1)
			{
				######
				$deleteQ = "DELETE FROM $tb WHERE employeeid='$employeeid'";
				mysql_query($deleteQ);
				######
			}
			else
			{
				print "<p>You do not have enougth credetials to delete any records in the table<p>";
			}

		}


		# ################ EDIT a record #################
		if(isset($_GET['edit'])) // check if edit link clicked
		{
			
			if($_SESSION['level'] == 1)
			{
				
				$getRowQ= "SELECT * FROM $tb  WHERE employeeid='$employeeid'";
				list($employee, $fname1, $lname1, $email1, $zip1) =  mysql_fetch_row( mysql_query($getRowQ));
				
				editform($employee, $fname1, $lname1, $email1, $zip1); // show edit form				
			}
			else
			{
				print "<p>You do not have enougth credetials to edit any records in the table<p>";
			}
			
		}
		if(isset($_POST['edit2'])) // check if 'edit employee' button of edit form is clicked
		{
			
			if($_SESSION['level'] == 1)
			{
					####################################################################################
					$id = $_POST['employeeid'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$email = $_POST['email'];
					$zip = $_POST['zip'];
					# checks if the form filled correctly
					if(
						preg_match("/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/", $fname) && 
						preg_match("/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/", $lname) && 
						preg_match("/^\d{5}$/", $zip) && 
						preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email)
					)
					{
						# querry the database to find if there is other records with the same email and/or name
						$checkQ = 	"SELECT * 
										FROM $tb 
										WHERE employeeid<>$id AND 
																((fname='$fname' and lname='$lname')
																OR
																email='$email')";
						$resultcheck = mysql_query($checkQ);
						# update the record if no other records with the same name and/or email exists
						if(mysql_num_rows($resultcheck) == 0)
						{
						$updateQ =	"UPDATE $tb 
										SET 
											fname='$fname', 
											lname='$lname', 
											email='$email', 
											zip='$zip' 
										WHERE
											employeeid='$id'";
						mysql_query($updateQ);
						}
						#  show form again for correcting
						else
						{
							print "An employee  with matching name and/or email $email already exists";
							editform($id, $fname, $lname, $email, $zip);
						}

					}
					else
					{
						// show the form again for insering missing fields
						print "<p>No updates have been made.<br>
							Please, update every field correctly</p>";
						editform($id, $fname, $lname, $email, $zip);
					}
				    #############################################################
			}
			else
			{
				print "<p>You do not have enougth credetials to edit any records in the table<p>";
			}
			
		}
		############### ADD a new employee #######################
		if(isset($new)) // check if 'New employee' button is pressed
		{
			if($_SESSION['level'] == 0)
			{
				addform("", "", "", ""); // show the form with no value
			}
			else
			{
				print "<p>You do not have enougth credetials to add new employees<p>";
			}

		}
		if(!empty($add)) // check if 'Add employee' of the form is pressed
		{

			if($_SESSION['level'] == 0)
			{
				
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$zip = $_POST['zip'];
				if(
					preg_match("/^[a-zA-Z]+$/", $fname) && 
					preg_match("/^[a-zA-Z]+$/", $lname) && 
					preg_match("/^\d{5}$/", $zip) && 
					preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email)
				)
				{
				$checkQ = "SELECT * FROM $tb 
							WHERE (fname='$fname' and lname='$lname')
									OR
									email='$email'";
				$resultcheck = mysql_query($checkQ);
					if(mysql_num_rows($resultcheck) == 0)
					{
						$addQ = "INSERT INTO $tb VALUES('','$fname','$lname','$email','$zip')";
						mysql_query($addQ);
					}
					else
					{
						//show the prefilled form  again for correcting
						print "An employee with matching name and/or email $email already exists";
						addform($fname, $lname, $email, $zip);
					}
				
				
				}
				else
				{
					// show the form for inserting missing fields
					print "<p>No updates have been made.<br>
						Please, fill every field correctly</p>";
					addform($fname, $lname, $email, $zip);
				}
					
			}
			else
			{
				print "<p>You do not have enougth credetials to add new employees<p>";
			}

		}




		# show the employee table
		showemp();
	}
}
?>
</div>

</body>
</html>
