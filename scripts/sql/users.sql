CREATE TABLE users (
  id int auto_increment,
  loginName varchar(255),
  passwd varchar(255),
  loginType varchar(20),
  landHere text,
  primary key (id),
  unique key loginName (loginName)
);
