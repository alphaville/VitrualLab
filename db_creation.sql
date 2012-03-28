DROP DATABASE IF EXISTS `vlab`;
CREATE DATABASE `vlab` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `vlab`;

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'First Name',
  `fn` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'First Name',
  `ln` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Last Name',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Email',
  `pwd_hash_md5` varchar(255) COLLATE utf8_bin DEFAULT 'no pass' COMMENT 'The MD5 fingerprint of the password',
  `role` TINYINT(1) DEFAULT 0 NOT NULL,
  `class` VARCHAR(255) DEFAULT NULL,
  `semester` INTEGER(10) NOT NULL DEFAULT 8,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_method` VARCHAR(40) NOT NULL DEFAULT 'vlab',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
LOCK TABLE `people` WRITE;
 INSERT INTO `people` (`id`,`fn`,`ln`,`email`,`pwd_hash_md5`,`role`) VALUES ('admin','Haralambos','Sarimveis','hsarimv@central.ntua.gr','4297f44b13955235245b2497399d7a93',10),('chung','Pantelis','Sopasakis','chvng@mail.ntua.gr','4206676c5dbf6287a9ee578b0211bb84',10);
UNLOCK TABLE ;