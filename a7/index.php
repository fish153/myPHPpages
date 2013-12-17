<?php
include("books.php");
$link = connect($host, $user, $pass, $db);
?>
<html lang="en">

<head>
	<title>Books</title>
	<link rel="stylesheet" type="text/css" href="../s/style.css">
</head>

<body>
<div class="topTable">
<?php

	// show a form to edit book
	if(isset($_GET['editbook']))
	{
		if(!empty($_GET['bid']) & !empty($_GET['aid']))
		{
			$bid = $_GET['bid'];
			$aid = $_GET['aid'];
		}
		EditBook($bid, $aid);
	}

	// process edit book form and make changes in the database
	if(isset($_POST['edbook']))
	{
		$bid = $_POST['bid'];
		$aid = $_POST['aid'];
		$aidold = $_POST['aidold'];
		$title = trim($_POST['title']);
		$genre = $_POST['genre'];
		$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
		// check title
		if(preg_match($re, $title))
		{
			$title = fixstrings($title);
			$cheickUniqueTitleQuery =  "SELECT books.title
										FROM books, publish 
										WHERE books.title='$title' 
											AND publish.authorid='$aid'
											AND books.bookid<>'$bid'";
			// check if title is unique
			if(mysql_num_rows(mysql_query($cheickUniqueTitleQuery)) == 0)
			{
				$setNewTitleQuery = "UPDATE books SET title='$title', genre='$genre' WHERE bookid='$bid' ";
				$setNewAuthorQuery = "UPDATE publish SET authorid='$aid' WHERE bookid='$bid' ";
				// check if user changed author
				if($aid == $aidold)
				{
					// if not change only title
					mysql_query($setNewTitleQuery);
				}
				else
				{
					// if author is new -- change author and title
					mysql_query($setNewTitleQuery); 
					mysql_query($setNewAuthorQuery);
					$checkAuthorQuery = "SELECT * FROM publish WHERE authorid=$aidold";
					// if author has no books -- delet this author from the database
					if(mysql_num_rows(mysql_query($checkAuthorQuery)) == 0)
					{
						mysql_query("DELETE FROM authors WHERE authorid='$aidold'");

					}
				}
				
			}
			else
			{
				print "<p>Title already exists</p>";
				EditBook($bid, $aid);
			}
		}
		else
		{
			print "<p>Check title</p>";
			EditBook($bid, $aid);
		}

	}

	// delete a book form the tables
	if(isset($_GET['delbook']))
	{
		if(!empty($_GET['bookid']) & !empty($_GET['authorid']))
		{
			$bid = $_GET['bookid'];
			$aid = $_GET['authorid'];
			$deleteBookFromBooksQuery = "DELETE FROM books WHERE bookid='$bid'";
			$deleteBookFromPublishQuery = "DELETE FROM publish WHERE authorid='$aid' AND bookid='$bid'";
			$findBooksByAuhtorID = "SELECT publish.bookid FROM publish WHERE authorid='$aid'";
			mysql_query($deleteBookFromBooksQuery);
			mysql_query($deleteBookFromPublishQuery);
			// if author has no book in the tables -- delete the author
			if(mysql_num_rows(mysql_query($findBooksByAuhtorID)) == 0)
			{
				mysql_query("DELETE FROM authors WHERE authorid='$aid'");
			}
		}
	}

	// show a form to add a book to the database
	if(!empty($_GET['addbook']))
	{
		AddBookForm();
	}

	// add new book
	if(isset($_POST['insertbook']))
	{
		$aid = $_POST['authorid'];
		$genre = $_POST['genre'];
		if(!empty($_POST['title']))
		{
			$title = $_POST['title'];
			if(preg_match("/^\s*\S+/", $title))
			{
				$title = trim($title);
				$ifTitleExistsQuerry = "SELECT * FROM books WHERE title='$title'";
			
				if(mysql_num_rows(mysql_query($ifTitleExistsQuerry)) == 0)
				{
					
					AddBook($aid, $title, $genre);
				}
				else
				{
					print "<p>Title alredy exists</p>";
					AddBookForm($aid, $title, $genre);
				}
			}
			else
			{
				print "<p>Title cannot be empty</p>";
				AddBookForm($aid, $title, $genre);
			}

		}
		else
		{
			print "<p>Title cannot be empty</p>";
			AddBookForm($aid, $title, $genre);
		}
	
	
	}
	// show add author form
	if(isset($_GET['addauthor']))
	{
		AddAuthorForm();
	}

	// check fields of the form and insert into tables
	if(isset($_POST['insertauthor']))
	{
			$lname = trim($_POST['lname']);
			$fname = trim($_POST['fname']);
			$country = trim($_POST['country']);
			$title = trim($_POST['title']);
			$genre = $_POST['genre'];

			$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
		// check every field in nested if statements	
		if(preg_match($re, $fname))
		{
			// check  first name
    		$fname = fixstrings($fname);
    		// check last name
    		if(preg_match($re, $lname)) 
    		{
    			$lname = fixstrings($lname);
    			$checkUniqueNameQuery = "SELECT * FROM authors WHERE fname='$fname' AND lname='$lname' ";
    			// check if the new name is an unique name
    			if(mysql_num_rows(mysql_query($checkUniqueNameQuery)) == 0)
    			{
    				// check country
    				if(preg_match($re, $country))
    				{
    					$country = fixstrings($country);
    					// check new title
    					if (preg_match("/^\s*\S+/", $title)) 
    					{
    						$title = fixstrings($title);
    						// chekc if the new title is an unique title
    						$cheickUnequeTitleQuery =  "SELECT * 
    													FROM books, authors 
    													WHERE books.title='$title' 
    														AND authors.fname='$fname' 
    														AND authors.lname='$lname'";
    						if(mysql_num_rows(mysql_query($cheickUnequeTitleQuery)) == 0)
    						{
    							// eventualy add author to the table
    							AddAuthor($fname, $lname, $country, $title, $genre);
    						}
    						else
    						{
    							print "<p>Title is alredy exists. Please enter an unique title";
    							AddAuthorForm($fname, $lname, $country, $title, $genre);
    						}
    						
    					}
    					else
    					{
    						print "<p>Check title";
    						AddAuthorForm($fname, $lname, $country, $title, $genre);
    					}
    				}
    				else
    				{
    					print "<p>Check country</p> ";
    					AddAuthorForm($fname, $lname, $country, $title, $genre);
    				}
    			}
    			else
    			{
    				print "<p>The same  first and last names exist in the database. 
    						Please insert an unique name";
    				AddAuthorForm($fname, $lname, $country, $title, $genre);
    			}
    		}
    		else
    		{
    			print "<p>Check last name</p>";
    			AddAuthorForm($fname, $lname, $country, $title, $genre);
    		}			
		}
		else
		{
			print "<p>Check first name</p>";
			AddAuthorForm($fname, $lname, $country, $title, $genre);
		}
		
	}
	// show edit author form when an author's lin clicked
	if(isset($_GET['editauthor']))
	{
		$aid = $_GET['aid'];	
		$query = "SELECT fname, lname, country  FROM authors WHERE authorid='$aid'";
		$result = 	mysql_query($query);
		$row = mysql_fetch_row($result);
		list($fname, $lname, $country) = $row;

		EditAuthorForm($aid, $fname, $lname, $country);

	}

	// Edit author
	if(isset($_POST['ChangeAuthor']))
	{
		$aid = $_POST['authorid'];
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$country = trim($_POST['country']);
		$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
		// check every field of the form
		// check first name
		if(preg_match($re, $fname))
		{
    			$fname = fixstrings($fname);
    			// check last name
    			if(preg_match($re, $lname)) 
    			{
    				$lname = fixstrings($lname);
    				$checkUniqueNameQuery = "SELECT * FROM authors WHERE fname='$fname' AND lname='$lname' AND authorid<>$aid";
    				// check if the new name is an unique name
				if(mysql_num_rows(mysql_query($checkUniqueNameQuery)) == 0)
    			{
    				// check country
    				if(preg_match($re, $country))
    				{
    					$country = fixstrings($country);
    					// update the authors table with new values
    					$updateAuthorNameQuery = "UPDATE authors SET 
    																fname='$fname', 
    																lname='$lname', 
    																country='$country' 
    															WHERE authorid='$aid' ";

    					mysql_query($updateAuthorNameQuery);

    				}
    				else
    				{
    					print "<p>Check country</p>";
    					EditAuthorForm($aid, $fname, $lname, $country);
    				}
    			}
    			else
    			{
    				print "<p>The name is already in the database, please enter an unique name</p>";
    				EditAuthorForm($aid, $fname, $lname,$country);

    			}
			}
			else
			{
				print "<p>Check last name</p>";
				EditAuthorForm($aid, $fname, $lname,$country);
			}
		}
		else
		{
			print "<p>Check first name</p>";
				EditAuthorForm($aid, $fname, $lname,$country);
		}
	  }
	
	// delete an author and the author's books	
	if(isset($_GET['delauthor']))	
	{		
	$aid = $_GET['authorid'];
	$findBookIDByAuhtorID = "SELECT publish.bookid FROM publish WHERE authorid='$aid'";
		while($row = mysql_fetch_row(mysql_query($findBookIDByAuhtorID)))		
		{			
			list($bid)= $row;
			$findTitleByBookIDQuery = "SELECT title FROM books WHERE bookid='$bid' ";
			$titleRow = mysql_query($findTitleByBookIDQuery);
			list($title) = mysql_fetch_row($titleRow);
			print "<p>The book &#171; $title &#187; has been deleted</p>";	
			$deleteAuthorFromPublish = "DELETE FROM publish WHERE authorid='$aid' AND bookid='$bid' ";
			//print $deleteAuthorFromPublish;
			$deleteAuthorFromBooks = "DELETE FROM books WHERE bookid='$bid'";
			//print $deleteAuthorFromBooks;
			mysql_query($deleteAuthorFromBooks);
			mysql_query($deleteAuthorFromPublish);
			
		}
	$findAuthorByID = "SELECT fname, lname FROM authors WHERE authorid='$aid'";
	list($fname, $lname)	= mysql_fetch_row(mysql_query($findAuthorByID));

	mysql_query("DELETE FROM authors WHERE authorid='$aid'");
	print "Author  &#171; $fname $lname &#187; has been deleted from the database";
	}

	ShowBooks()
?>
</div>
</body>
</html>

