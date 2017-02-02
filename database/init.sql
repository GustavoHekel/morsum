CREATE SCHEMA `my_disks` ;

CREATE TABLE `my_disks`.`bands` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`));

CREATE TABLE `my_disks`.`disks` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `band_id` INT NULL,
    `name` VARCHAR(255) NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_disks_band_id_idx` (`band_id` ASC),
    CONSTRAINT `fk_disks_band_id`
      FOREIGN KEY (`band_id`)
      REFERENCES `my_disks`.`bands` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);

INSERT INTO `my_disks`.`bands` (`name`) VALUES ('RADIOHEAD');
INSERT INTO `my_disks`.`bands` (`name`) VALUES ('OASIS');
INSERT INTO `my_disks`.`bands` (`name`) VALUES ('THE ROLLING STONES');
INSERT INTO `my_disks`.`bands` (`name`) VALUES ('THE BEATLES');

INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('1', 'OK COMPUTER');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('1', 'IN RAINBOWS');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('2', 'BE HERE NOW');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('2', 'THE MASTERPLAN');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('3', 'FLOWERS');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('3', 'STICKY FINGERS');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('3', 'SOME GIRLS');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('4', 'ABBEY ROAD');
INSERT INTO `my_disks`.`disks` (`band_id`, `name`) VALUES ('4', 'LET IT BE');
