SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cnd9351
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cnd9351
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cnd9351` DEFAULT CHARACTER SET utf8 ;
USE `cnd9351` ;

-- -----------------------------------------------------
-- Table `cnd9351`.`games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cnd9351`.`games` (
  `gameid` INT NOT NULL,
  `turn` VARCHAR(45) NULL,
  PRIMARY KEY (`gameid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cnd9351`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cnd9351`.`users` (
  `userid` INT NOT NULL,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `gameid` INT NOT NULL,
  `isAuthenticated` TINYINT NULL,
  PRIMARY KEY (`userid`, `gameid`),
  INDEX `fk_users_games1_idx` (`gameid` ASC),
  CONSTRAINT `fk_users_games1`
    FOREIGN KEY (`gameid`)
    REFERENCES `cnd9351`.`games` (`gameid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cnd9351`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cnd9351`.`messages` (
  `messageid` INT NOT NULL,
  `gameid` INT NOT NULL,
  `userid` INT NOT NULL,
  PRIMARY KEY (`messageid`, `gameid`, `userid`),
  INDEX `fk_messages_games_idx` (`gameid` ASC),
  INDEX `fk_messages_users1_idx` (`userid` ASC),
  CONSTRAINT `fk_messages_games`
    FOREIGN KEY (`gameid`)
    REFERENCES `cnd9351`.`games` (`gameid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users1`
    FOREIGN KEY (`userid`)
    REFERENCES `cnd9351`.`users` (`userid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
