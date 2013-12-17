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

// function prints drop down menu with all the authors registered in the database
// and preselects author's name which id is passed as an argumnent
function Authors($aid='')
{
	$query = 	"SELECT  fname, lname, authorid FROM authors";
	$result = 	mysql_query($query);
		while($row = mysql_fetch_row($result))
	{
		list($fname, $lname, $id) = $row;
		if($id == $aid)
		{
			$select = "selected='selected'";
		}
		else
		{
			$select = "";
		}
		print "
							<option value='$id' $select>
								$fname $lname
							</option>
		";
	}
}
// print genres as drop-down menu and preselects a genre passed as the argumnet
function Genre($genre)
{
	$genres = array(
					'Biography',
					'Fantasy',
					'Fiction',
					'History',
					'Horror',
					'Mystery',
					'Non-Fiction',
					'Romance',
					'Science Fiction',
					'Western'
					);
	foreach($genres as $item)
	{

		if($genre == $item)
		{
			$select = "selected='selected'";
		}
		else
		{
			$select = "";
		}
		print "<option value='$item' $select>
					$item
				</option>
		";
	}

}
// print a form to add a new book
function AddBookForm($aid='', $title='', $genre='')
{
	
	print "
		<form method='post' action='index.php'>
		<table border='1' style='float: left'>
			<caption>ADD BOOK</caption>
			<tr>
				<td width='300'>
					<b>RULE: All books must have an author. If you want to add a new author and new book to the list use 'Add Author' link.</b>
				</td>
			</tr>
			<tr>
				<td>
				Author:
					<select name='authorid'>
	";
	Authors($aid);
	print "
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Title: <input type='text' name='title' value=\"$title\" />
				</td>
			</tr>
			<tr>
				<td>Genre:
					<select name='genre'>
			";
	Genre($genre); 
	print "
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type='submit' name='insertbook' value='Add Book'/>
				</td>
			</tr>
		</table>
		</form>
	";


// apply changes to the tables to add a new book
}
function AddBook($aid, $title, $genre)
{
	$title = fixstrings($title);
	$addBookIntoBooksQuerry = "INSERT INTO books VALUES('', '$title', '$genre')";
	$findBookIdQuerry = "SELECT bookid FROM books WHERE title='$title' AND genre='$genre'";

	mysql_query($addBookIntoBooksQuerry);
	list($bid) = mysql_fetch_row(mysql_query($findBookIdQuerry));
	$addBookIntoPublshQuerry = "INSERT INTO publish VALUES('', '$bid', '$aid')";
	mysql_query($addBookIntoPublshQuerry);

}
// show edit book form
function EditBook($bid, $aid)
{

	$findTitleByBookIdQuery = "SELECT books.title FROM books, authors WHERE books.bookid='$bid' and authors.authorid='$aid' ";

	list($title) = mysql_fetch_row(mysql_query($findTitleByBookIdQuery)) ;
	$title = revfixstrings(stripslashes($title));
	print "
	<form method='post' action='index.php'>
		<table border='1' style='float: left'>
			<caption>
				EDIT BOOK
			</caption>
				<tr>
					<td>
					
						<input type='hidden' name='bid' value='$bid'>
						<input type='hidden' name='aidold' value='$aid'>
					Title: 
						<input type='text' name='title' value=\"$title\">
					</td>
				</tr>
				<tr>
					<td>Author:
						<select name='aid'>
	";
	Authors($aid);
	print "
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<select name='genre'>
	";
	$findGenreByBookIDQuery = "SELECT books.genre FROM books WHERE books.bookid='$bid'";
	list($bookGenre) = mysql_fetch_row(mysql_query($findGenreByBookIDQuery));
	Genre($bookGenre);
	print "
					</td>
				</tr>
				<tr>
					<td>
						<input type='submit' name='edbook' value='Edit Book'>
					</td>
				</tr>
				<tr>
					<td>
						<a href='index.php?delbook=yes&bookid=$bid&authorid=$aid' onclick='return confirm(\"Are you sure\")''>
							Delete This Book
						</a>
					</td>
				</tr>
			</table>
	</form>
	";
}
// prints the form to add a new author and a new book
function AddAuthorForm($fname='', $lname='', $country='', $title='', $genre='')
{
	$fname = revfixstrings($fname);
	$lname = revfixstrings($lname);
	$country = revfixstrings($country);
	$title = revfixstrings($title);
	print "
	<form method='post' action='index.php'>
		<table border='1' style='float: left'>
		<caption>ADD Author</caption>
			<tr>
				<td width='300'>
					<b>RULE: All authors must have at least 1 book listed. 
					So when a 	new author is added, so is the first book.</b>
				</td>
			</tr>
			<tr>
				<td>First Name: 
				<input type='text' name='fname' value=\"$fname\"/>
				</td>
			</tr>
			<tr>
				<td>Lirst Name: 
					<input type='text' name='lname' value=\"$lname\" />
				</td>
			</tr>
			<tr>
				<td>Country of Origin: 
					<input type='text' name='country' value=\"$country\" />
				</td>
			</tr>
			<tr>
				<td>Book Title: 
					<input type='text' name='title' value=\"$title\" />
				</td>
			</tr>
			<tr>
				<td>Genre: <select name='genre'>
	";
	Genre($genre);
	print "			
			<tr>
				<td>
					<input type='submit' name='insertauthor' value='Add'/>
				</td>
			<tr>
		</table>
	</form>
	";

}
// add a new author and a new book to the database
function AddAuthor($fname, $lname, $country, $title, $genre)
{
	// $fname = fixstrings($fname);
	// $lname = fixstrings($lname);
	// $country = fixstrings($country);
	// $title = fixstrings($title);
	$addAuthorQuery = "INSERT INTO authors VALUES('', '$fname', '$lname', '$country')";
	// print $addAuthorQuery;
	mysql_query($addAuthorQuery);
	$findAuhorIdQuery = "SELECT authorid FROM authors WHERE fname='$fname' AND lname='$lname' ";
	// print $findAuhorIdQuery;
	list($aid) = mysql_fetch_row(mysql_query($findAuhorIdQuery));
	AddBook($aid, $title, $genre);
}

// function print a form to edit an author from the database
function EditAuthorForm($aid='', $fname='', $lname='', $country='' )
{

	$lname = revfixstrings($lname);
	$fname = revfixstrings($fname);
	print "
		<table border='1' style='float: left'>
			<caption>EDIT Author</caption>
				<tr>
					<td>
						<form method='post' action='index.php'>
							<input type='hidden' name='authorid' value='$aid'/>
						Fname: 
							<input type='text' name='fname' value=\"$fname\"/>
					</td>
				</tr>
				<tr>
					<td>
						Lname: 
							<input type='text' name='lname' value=\"$lname\"/>
					</td>
				</tr>
				<tr>
					<td>
						Country: 
							<input type='text' name='country' value=\"$country\"/>
					</td>
				</tr>
				<tr>
					<td>
							<input type='submit' name='ChangeAuthor' value='Edit Author' />
						</form>
					</td>
				</tr>
				<tr>
					<td>
						<a href='index.php?delauthor=yes&authorid=$aid'
						onclick='return confirm(\"Are you sure\")'>Delete This Author</a>
					</td>
				</tr>
		</table>
	";
}


// Print a table compiled from all 3 tables from the database
function ShowBooks()
{
	// assign default values to variables of every column in the table
	// 1 meand ascending, 2 means descending order
	$orderT = 2; //  descending order for book titles column
	$orderN = 1; // ascending order for  author names column
	$orderG = 1; // ascending order for genre column
	$orderC = 1; // ascending order for cauntry column
	// variable controls ORDER BY part  in the query; 
	// it ordered by titles by default -- because titles are third in the query
	$choice = 3; 	/* 
	every time the user clicks on a link in the header of the table
	if statements check in which column  a header has been clicked and 
	assign a certain value to the $choice  variable to change ORDER BY part of the query
	and assigns opposit value to the link in this column's header
	s
	*/
	if(isset($_GET['title']))
	{
		$title = $_GET['title'];
		if($title == 2)
		{
			$choice = "3 DESC"; //ORDER BY is going to be "title DESCENDING" because title is third in the query
			$orderT = 1; // the next order will be ascending
		}
		else
		{
			$choice = "3"; //
		}
	}
	// order by name column
	if(isset($_GET['name']))
	{
		$lfname = $_GET['name'];
		if($lfname == 1)
		{
			$choice = 5;
			$orderN = 2;
		}
		else
		{
			$choice = "5 DESC";
		}
	}
	// order by genre column
	if(isset($_GET['genre']))
	{
		$genre = $_GET['genre'];
		if($genre == 1)
		{
			$choice = 6; // genre is sixth in the query
			$orderG = 2; 
		}
		else
		{
			$choice = "6 DESC";
		}
	}	
	// order by country column
	if(isset($_GET['country']))
	{
		$country = $_GET['country'];
		if($country == 1)
		{
			$choice = 7;
			$orderC = 2;
		}
		else
		{
			$choice = "7 DESC";
		}
	}
// the query 
$query = 	"SELECT 
				books.bookid,
				authors.authorid,
				books.title, 
				authors.fname,  
				authors.lname,
				books.genre, 
				authors.country
			FROM 
				books, 
				authors, 
				publish 
			WHERE 
					publish.bookid=books.bookid 
				AND 
					authors.authorid=publish.authorid 
			ORDER BY 
					$choice";

$result = mysql_query($query);

print "<p>To edit a book(title  or author) in the table -- click on the corresponding link</p> ";
print "
	<table border='1'>
		<tr>
				<th colspan='4'>
					<a href='index.php?addbook=yes'>Add Book</a> | 
					<a href='index.php?addauthor=yes'>Add Author</a>
				</th>
		</tr>
		<tr>
				<th>
					<a href='index.php?title=$orderT'>Title </a>
				</th>
				<th>
					<a href='index.php?name=$orderN'>Author Name</a>
				</th>
				<th>
					<a href='index.php?genre=$orderG'>Genre</a>
				</th>
				<th>
					<a href='index.php?country=$orderC'>Country</a>
				</th>
		</tr>
	";
	// fetch data from 3 tables
	while($row = mysql_fetch_row($result))
	{
		list($bookID, $authorID, $title, $fname, $lname, $genre, $country) = $row;
		$lname = stripslashes($lname) ;
		$fname = stripslashes($fname);
		$title = stripslashes($title);
		$country = stripcslashes($country);
		print "
		<tr>
			<td>
				<a href='index.php?editbook=yes&bid=$bookID&aid=$authorID'>
					$title
				</a>
			</td>
			<td>
				<a href='index.php?editauthor=yes&aid=$authorID'>
					$fname $lname
				</a>
			</td>
			<td>
				$genre
			</td>
			<td>
				$country
			</td>
		</tr>
	";
	}
print "</table>";
}


?>