<?php

$host = 'localhost';
$user = 'kubrakk';
$pass = '1186601';
$db = 'kubrakk';
$tb = 'employees';

function GrabUser()
{
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$level = $_SESSION['level'];

	return array($fname, $lname, $level);
}

function AuthOn()
{
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$password = $_POST['password'];

$query = 	"SELECT * 
			FROM 	admin 
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
	$_SESSION['authenticLog322a'] = "validId333";
	
	$row = mysql_fetch_row($result);
	list($adminid, $fname, $lname, $password, $level) = $row;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['level'] = $level;

	}
	else
	{
	$_SESSION['authenticLog322a'] = "NotValidUser";
	}
}

function LogOut()
{
	session_start();
	session_destroy();
	print "<p>You are logged out</p>
			<p><a href='index.php'>Log In</a></p>";
}

function LogInForm()
{
	print "
	<form method='post' action='index.php'>
		First Name: 
			<input type='text' name='fname' /><br/>
		Last Name: 
			<input type='text' name='lname' /><br/>
		Password: 
			<input type='password' name='password'/><br/>
			<input type='submit'/>
	</form>
	";
	$query = "SELECT fname, lname, password, level FROM admin";
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
				Credentials
			</th>
		</tr>

	";
	while ( $row = mysql_fetch_row($result)) {
		list($fname, $lname, $pass, $level) = $row;
		if($level == 0)
		{
			$credent ="Add and view employees";	
		}
		if($level == 1)
		{
			$credent ="Delete, edit, view";
		}
		if($level == 2)
		{
			$credent = "View employees";
		}
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
					$credent
				</td>
			</tr>
		";
	}
	print "</table>";

}

function showemp()
{
	if(isset($_GET['choice']))
	{
	$choice = $_GET['choice'];
	}
	else
	{
	$choice = "lname";
	}
list($ufname, $ulname, $level) = GrabUser();
if($_SESSION['level'] == 1)
{
$query = "select employeeid, fname, lname, email, zip from employees order by $choice";
}
else
{
$query = "select '', fname, lname, email, zip from employees order by $choice";
}


$result = mysql_query($query);

print "<div class='botLeft'>
	<h1>Employees Table</h1>
	<table >

		<tr>
			<th class='column1'>Edit</th>
			<th>Delete</th>
			<th class='column2'>
				<a href='index.php?choice=fname'>FNAME</a>
			</th>
			<th class='column1'>
				<a href='index.php?choice=lname'>LNAME</a>
			</th>
			<th class='column2'>
				<a href='index.php?choice=email'>EMAIL</a>
			</th>
			<th class='column1'>
				<a href='index.php?choice=zip'>ZIP</a>
			</th>
		</tr>";

	while($row = mysql_fetch_row($result))
	{
	list($employeeid, $fname, $lname, $email, $zip) = $row;

		$editEmployeeLink = "<a href='index.php?edit=yes&employeeid=$employeeid'>Edit</a>";
		$deleteEmployeeLink = 	"<a href='index.php?delete=yes&employeeid=$employeeid' 
								onclick='return confirm(\"Are you sure\")'>
									Delete
								</a>";
	
	print "
		<tr>
			<td>
				$editEmployeeLink
			</td>
			<td>
				$deleteEmployeeLink
			</td>
			<td>
				$fname
			</td>
			<td>
				$lname
			</td>
			<td>
				$email
			</td>
			<td>
				$zip
			</td>
		</tr>
";
	}
	
	print "
	<tr>
		<td calspan=5>
			<form method='POST' action='index.php'>
				<input type='submit' name='new' value='New employee'>
			</form>
		</td>
	</tr>		
</table>
</div>
";
}


function condb($host, $user, $pass, $db)
{
	$link = mysql_connect($host, $user, $pass) or die('Check server name or password');
	$dbase = mysql_select_db($db) or die();
}

function editform($employee, $fname, $lname, $email, $zip)
{
print "
<div class='botLeft'>
	<form method='POST' action='index.php'><input type='hidden' name='employeeid' value='$employee'  />
		<table  style='float: left'>
			<tr>
				<td>
			
					<input type='text' name='fname' value='$fname' > Fname<br />
					<input type='text' name='lname' value='$lname' > Lname<br />
					<input type='text' name='email' value='$email' > Email<br />
					<input type='text' name='zip' value='$zip' /> Zip<br />
				</td>
			</tr>
			<tr>
				<td  style='text-align: right'/>
					<input type='submit' name='edit2' value='Edit Employee' />
			
				</td>
			</tr>
		</table>
	</form>	
</div>
";

}


function addform($fname, $lname, $email, $zip)
{
	print "
<div class='botLeft'
	<table border='1'>
		<tr>
			<td>
				<form method='POST' action='index.php'>
					<input type='text' name='fname' value='$fname'> Fname<br />
					<input type='text' name='lname' value='$lname'> Lname <br />
					<input type='text' name='email' value='$email'> Email<br />
					<input type='text' name='zip' value='$zip'> Zip<br />
			</td>
		</tr>
		<tr>
			<td style='text-align: right'>
					<input type='submit' name='add' value='Add Employee' />
				</form>
			</td>
		</tr>
	</table>
</div>
";

}
?>
