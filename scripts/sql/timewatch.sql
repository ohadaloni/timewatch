create table timewatch (
  id int auto_increment,
  user varchar(255),
  month varchar(8),
  date date,
  timein datetime,
  timeout datetime,
  timein2 datetime,
  timeout2 datetime,
  timein3 datetime,
  timeout3 datetime,
  totaltime int,
  primary key (id),
  unique key user (user,date)
);
