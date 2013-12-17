drop table authors;
drop table books;
drop table publish;
create table books(bookid int not null auto_increment, primary key(bookid),
title varchar(150),genre varchar(70));

create table authors(authorid int not null auto_increment, primary key(authorid),
fname varchar (70),
lname varchar (70),
country varchar(70));

create table publish(pubid int not null auto_increment, primary key(pubid), bookid int, authorid int);


insert into books values('100', 'The Adventures of Huckleberry Finn', 'Fiction');
insert into books values('101', 'Emma', 'Fiction'); 
insert into books values('102', 'The Stand', 'Horror');
insert into books values('103', 'The Green Mile', 'Horror');
insert into books values('104', 'The Call of the Wild', 'Fiction');
insert into books values('105', 'White Fang', 'Fiction');
insert into books values('106', 'Pride and Prejudice', 'Fiction');

insert into authors values('20', 'Mark', 'Twain', 'USA');
insert into authors values('21', 'Jane', 'Austen', 'England');
insert into authors values('22', 'Stephen', 'King', 'USA');
insert into authors values('23', 'Jack', 'London', 'USA');

insert into publish values('1', '100', '20');
insert into publish values('2', '101', '21');
insert into publish values('3', '102', '22');
insert into publish values('4', '103', '22');
insert into publish values('5', '104', '23');
insert into publish values('6', '105', '23');
insert into publish values('7', '106', '21');

SELECT 	books.title, CONCAT(authors.fname, ' ', authors.lname) Authors, books.genre, authors.country FROM books, authors, publish WHERE publish.bookid=books.bookid AND authors.authorid=publish.authorid ORDER BY 1;