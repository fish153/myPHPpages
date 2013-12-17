DROP TABLE admin;
CREATE TABLE admin (
	adminid INT NOT NULL auto_increment, primary key(adminid),
	fname varchar(80) NOT NULL,
	lname VARCHAR(80) NOT NULL,
	password VARCHAR(15) NOT NULL,
	level INT NOT NULL
	);
	
INSERT INTO admin VALUES('', 'Bob', 'Smith', 123, 1);
INSERT INTO admin VALUES('', 'Mary', 'Jones', 'abc', 2);

DESCRIBE admin;

SELECT * FROM admin;