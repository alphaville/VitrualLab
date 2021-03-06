SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `vlab` ;
CREATE SCHEMA IF NOT EXISTS `vlab` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `vlab` ;

-- -----------------------------------------------------
-- Table `vlab`.`people`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`people` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`people` (
  `id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Username' ,
  `fn` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'First Name' ,
  `ln` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Last Name' ,
  `email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Email' ,
  `pwd_hash_md5` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT 'no pass' COMMENT 'The MD5 fingerprint of the password' ,
  `role` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=user, 10=admin, 11=root-admin' ,
  `class` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  `semester` INT(10) NOT NULL DEFAULT '8' ,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `login_method` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT 'vlab' ,
  `authorization_key` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'deprecated.' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `authorization_key` (`authorization_key` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `vlab`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`message` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`message` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `from` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Sender' ,
  `rcpt_to` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Reciever' ,
  `subject` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `body` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Body of the message (HTML)' ,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `inreplyto` INT(10) NULL DEFAULT NULL ,
  `isRead` TINYINT(1) NULL DEFAULT FALSE COMMENT 'whether the user has read the msg' ,
  PRIMARY KEY (`id`) ,
  INDEX `from_fk` (`from` ASC) ,
  INDEX `rcpt_to_fk` (`rcpt_to` ASC) ,
  INDEX `subject_key` USING BTREE (`subject` ASC) ,
  INDEX `fk_reply` (`inreplyto` ASC) ,
  CONSTRAINT `from_fk`
    FOREIGN KEY (`from` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `rcpt_to_fk`
    FOREIGN KEY (`rcpt_to` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_reply`
    FOREIGN KEY (`inreplyto` )
    REFERENCES `vlab`.`message` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 74
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `vlab`.`rss`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`rss` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`rss` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'RSS FEED TITLE' ,
  `link` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'LINK' ,
  `guid` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'GUID' ,
  `author` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'RSS FEED AUTHOR' ,
  `description` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'DESCRIPTION (HTML)' ,
  `pubDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `lang` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT 'en' ,
  `user_id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `title_key` USING BTREE (`title` ASC) ,
  INDEX `lang_key` USING BTREE (`lang` ASC) ,
  INDEX `fk_rss_people1` (`user_id` ASC) ,
  CONSTRAINT `fk_rss_people1`
    FOREIGN KEY (`user_id` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `vlab`.`exercise`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`exercise` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`exercise` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID of the exercise' ,
  `content` TEXT NULL COMMENT 'Actual Content' ,
  `creation_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of first creation' ,
  `mark` INT(11) NULL COMMENT 'Mark of the evaluated exercise' ,
  `user_id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL COMMENT 'Creator of the exercise' ,
  `status` INT NULL DEFAULT 0 COMMENT 'Draft or Sumbitted or Under Review etc' ,
  `comments` MEDIUMTEXT CHARACTER SET 'big5' NULL COMMENT 'Accompanying text' ,
  `submission_time` TIMESTAMP NULL COMMENT 'Timestamp of first submission' ,
  `type` VARCHAR(45) NULL COMMENT 'type of the exercise (tuning, etc)' ,
  `last_update_time` TIMESTAMP NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_exercise_people1` (`user_id` ASC) ,
  CONSTRAINT `fk_exercise_people1`
    FOREIGN KEY (`user_id` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vlab`.`token`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`token` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`token` (
  `token_id` VARCHAR(255) NOT NULL ,
  `people_id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `creation_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`token_id`) ,
  INDEX `fk_token_people1` (`people_id` ASC) ,
  CONSTRAINT `fk_token_people1`
    FOREIGN KEY (`people_id` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Every user has a set of tokens (multi-login allowed)';


-- -----------------------------------------------------
-- Table `vlab`.`haveReadAnnouncement`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vlab`.`haveReadAnnouncement` ;

CREATE  TABLE IF NOT EXISTS `vlab`.`haveReadAnnouncement` (
  `people_id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `message_id` INT(10) NOT NULL ,
  `read_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  INDEX `fk_HaveReadAnnouncement_people1` (`people_id` ASC) ,
  INDEX `fk_HaveReadAnnouncement_message1` (`message_id` ASC) ,
  PRIMARY KEY (`people_id`, `message_id`) ,
  CONSTRAINT `fk_HaveReadAnnouncement_people1`
    FOREIGN KEY (`people_id` )
    REFERENCES `vlab`.`people` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_HaveReadAnnouncement_message1`
    FOREIGN KEY (`message_id` )
    REFERENCES `vlab`.`message` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- procedure count_unread
-- -----------------------------------------------------

USE `vlab`;
DROP procedure IF EXISTS `vlab`.`count_unread`;

DELIMITER $$
USE `vlab`$$
CREATE PROCEDURE count_unread(OUT number_unread_msg INT, IN user_identifier VARCHAR(255))
    BEGIN
        -- Check if user exists
        DECLARE n INT;
        SET n = (SELECT COUNT(*) FROM `people` WHERE `people`.`id`=user_identifier);
        IF n=0 THEN
            -- If user does not exist return 0...
            SELECT 0 INTO number_unread_msg;
        ELSE 
            -- If user exists calculate the number of unread messages
            SELECT (SELECT COUNT(`id`) FROM `message` WHERE `rcpt_to`=user_identifier AND `isRead`=0)+(SELECT COUNT(`id`) FROM `message` WHERE `rcpt_to`='everybody')-(SELECT COUNT(`message_id`) FROM `haveReadAnnouncement` WHERE `people_id`=user_identifier) AS `unread` INTO number_unread_msg;
        END IF;        
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- function count_users
-- -----------------------------------------------------

USE `vlab`;
DROP function IF EXISTS `vlab`.`count_users`;

DELIMITER $$
USE `vlab`$$



CREATE FUNCTION count_users()
    RETURNS INT DETERMINISTIC
    BEGIN
        RETURN (SELECT COUNT(`id`) FROM `people` WHERE `id`!='everybody');
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- function count_rss
-- -----------------------------------------------------

USE `vlab`;
DROP function IF EXISTS `vlab`.`count_rss`;

DELIMITER $$
USE `vlab`$$



CREATE FUNCTION count_rss()
    RETURNS INT DETERMINISTIC
    BEGIN
        RETURN (SELECT COUNT(`id`) FROM `rss`);
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- function count_exercises
-- -----------------------------------------------------

USE `vlab`;
DROP function IF EXISTS `vlab`.`count_exercises`;

DELIMITER $$
USE `vlab`$$



CREATE FUNCTION count_exercises()
    RETURNS INT DETERMINISTIC
    BEGIN
        RETURN (SELECT COUNT(`id`) FROM `exercise`);
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- function count_local_users
-- -----------------------------------------------------

USE `vlab`;
DROP function IF EXISTS `vlab`.`count_local_users`;

DELIMITER $$
USE `vlab`$$



CREATE FUNCTION count_local_users()
    RETURNS INT DETERMINISTIC
    BEGIN
        RETURN (SELECT COUNT(`id`) FROM `people` where `login_method`='vlab' AND `id`!='everybody');
    END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
