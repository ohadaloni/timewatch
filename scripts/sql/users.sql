CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginName` varchar(20) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `loginType` varchar(20) DEFAULT NULL,
  `landHere` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginName` (`loginName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
