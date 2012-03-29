DROP DATABASE IF EXISTS `vlab`;
CREATE DATABASE `vlab` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `vlab`;

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Username',
  `fn` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'First Name',
  `ln` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Last Name',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Email',
  `pwd_hash_md5` varchar(255) COLLATE utf8_bin DEFAULT 'no pass' COMMENT 'The MD5 fingerprint of the password',
  `role` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '1=user, 10=admin, 11=root-admin',
  `class` VARCHAR(255) DEFAULT NULL,
  `semester` INTEGER(10) NOT NULL DEFAULT 8,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_method` VARCHAR(40) NOT NULL DEFAULT 'vlab',
  `authorization_key` VARCHAR(255) UNIQUE NOT NULL,
  `inreplyto` INT(10),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
LOCK TABLE `people` WRITE;
INSERT INTO `people` (`id`,`fn`,`ln`,`email`,`pwd_hash_md5`,`role`,`authorization_key`) VALUES 
 ('admin','Haralambos','Sarimveis','hsarimv@central.ntua.gr','4297f44b13955235245b2497399d7a93',11,md5(rand())),
 ('chung','Pantelis','Sopasakis','chvng@mail.ntua.gr','4206676c5dbf6287a9ee578b0211bb84',10,md5(rand())),
('everybody','EveryBody','','everybody@mail.vlab.org','no pass',-1,md5(rand()));
UNLOCK TABLE ;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` integer(10) COLLATE utf8_bin NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Sender',
  `rcpt_to` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Reciever',
  `subject` varchar(255) COLLATE utf8_bin NOT NULL,
  `body` TEXT COLLATE utf8_bin NOT NULL COMMENT 'Body of the message (HTML)',
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `from_fk` FOREIGN KEY (`from`)
    REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rcpt_to_fk` FOREIGN KEY (`rcpt_to`)
    REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  KEY `subject_key` (`subject`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;