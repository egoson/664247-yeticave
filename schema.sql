CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE ussers (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email CHAR(128) NOT NULL UNIQUE,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name CHAR(50) NOT NULL,
	contacts CHAR(11) NOT NULL UNIQUE,
	avatar TINYTEXT,
	lot_id CHAR(20),
	rate_id CHAR(20)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128)
);

INSERT INTO categories (name) VALUES ("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное");

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name CHAR(128),
	description TINYTEXT,
	link TINYTEXT,
	start_price CHAR(20),
	dt_close TIMESTAMP,
	step_price CHAR(20),
	users_id CHAR(20),
	win_id CHAR(20),
	categories CHAR(20)
);

CREATE TABLE rate (
	id INT AUTO_INCREMENT PRIMARY KEY,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	amount CHAR(20),
	users_id CHAR(20),
	lot_id CHAR(20)
);
