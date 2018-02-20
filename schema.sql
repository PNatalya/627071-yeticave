CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE ='utf8_general_ci';

USE yeticave;

CREATE TABLE `Category` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` CHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE `Lots` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME NULL DEFAULT NULL,
	`name` CHAR(255) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`img` CHAR(255) NULL DEFAULT NULL,
	`rate` INT(11) NULL DEFAULT NULL,
	`dt_close` DATE NULL DEFAULT NULL,
	`step` INT(11) NULL DEFAULT NULL,
	`user_id` INT(11) NULL DEFAULT NULL,
	`winner_id` INT(11) NULL DEFAULT NULL,
	`category_id` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `user_id` (`user_id`),
	INDEX `winner_id` (`winner_id`),
	INDEX `category_id` (`category_id`)
);
CREATE TABLE `Rates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME NULL DEFAULT NULL,
	`summa` FLOAT NULL DEFAULT NULL,
	`lot_id` FLOAT NULL DEFAULT NULL,
	`user_id` FLOAT NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `lot_id` (`lot_id`),
	INDEX `user_id` (`user_id`)
);

CREATE TABLE `Users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME NULL DEFAULT NULL,
	`name` CHAR(255) NULL DEFAULT NULL,
	`password` CHAR(64) NULL DEFAULT NULL,
	`avatar_path` CHAR(255) NULL DEFAULT NULL,
	`contacts` TEXT NULL,
	`email` CHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
;

