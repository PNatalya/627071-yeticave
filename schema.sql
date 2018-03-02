CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE ='utf8_general_ci';

USE yeticave;

CREATE TABLE `Category` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` CHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)	
);
CREATE TABLE `Lots` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME NOT NULL,
	`name` CHAR(255) NOT NULL,
	`description` TEXT NULL,
	`img` CHAR(255) NOT NULL,
	`rate` INT(11) NOT NULL,
	`dt_close` DATE NOT NULL,
	`step` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`winner_id` INT(11) NULL DEFAULT NULL,
	`category_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `user_id` (`user_id`),
	INDEX `winner_id` (`winner_id`),
	INDEX `category_id` (`category_id`),
	FULLTEXT INDEX `lot_ft_search` (`name`, `description`)
);

CREATE TABLE `Rates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME  NOT NULL,
	`summa` FLOAT  NOT NULL,
	`lot_id` FLOAT  NOT NULL,
	`user_id` FLOAT  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `lot_id` (`lot_id`),
	INDEX `user_id` (`user_id`)
);

CREATE TABLE `Users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`dt_add` DATETIME NULL DEFAULT NULL,
	`name` CHAR(255) NOT NULL,
	`password` CHAR(64) NOT NULL,
	`avatar_path` CHAR(255) NULL DEFAULT NULL,
	`contacts` TEXT NOT NULL,
	`email` CHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
)
;

