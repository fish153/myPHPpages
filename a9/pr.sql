drop table users;
drop table files;
drop table owners;
create table users(
	userid int not null auto_increment, 
	fname varchar(200),
	lname varchar(200),
	password varchar(200),
	primary key(userid)
	);
create table files(
	fileid int not null auto_increment,
	shortname varchar(200),
	filename varchar(200),
	description text,
	date date,
	time time,
	primary key(fileid)
	);
create table owners(
	ownerid int not null auto_increment,
	fileid int,
	userid int,
	primary key(ownerid)
	);
INSERT INTO users VALUES('1','Mary' , 'Smith', '123');
INSERT INTO users VALUES('2','Bob' , 'Jones', '321');
INSERT INTO users VALUES('3','Tom' , 'Black', '456');
INSERT INTO users VALUES('4','Kathy' , 'Brown', '654');
INSERT INTO files VALUES('100','flower', 'flower.jpg', 'Red Flower on field', CURDATE(),  CURTIME());
INSERT INTO files VALUES('101','cat', 'cat.jpg', 'Kitten sleeping on pillow', CURDATE(),  CURTIME());
INSERT INTO files VALUES('102','dog', 'dog.jpg', 'Dog playing in park', CURDATE(),  CURTIME());
INSERT INTO files VALUES('103','car', 'car.jpg', 'New electric off road vehicle', CURDATE(),  CURTIME());
INSERT INTO files VALUES('104','house', 'house.jpg', 'Brick House in the Woods', CURDATE(),  CURTIME());
INSERT INTO files VALUES('105','mountain', 'mountain.jpg', 'Mount Rainer in Washington', CURDATE(),  CURTIME());
INSERT INTO owners VALUES(200, 100, 1);
INSERT INTO owners VALUES(201, 101, 1);
INSERT INTO owners VALUES(202, 102, 2);
INSERT INTO owners VALUES(203, 103, 3);
INSERT INTO owners VALUES(204, 104, 4);
INSERT INTO owners VALUES(205, 105, 4);