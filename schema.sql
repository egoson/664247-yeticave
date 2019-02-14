CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email CHAR(128) NOT NULL UNIQUE,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name CHAR(50) NOT NULL,
	contacts CHAR(11) NOT NULL,
	avatar TINYTEXT,
	lot_id INT(20),
	rate_id INT(20)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128)
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name CHAR(128),
	description TEXT,
	image TINYTEXT,
	start_price INT(20),
	dt_close TIMESTAMP,
	step_price INT(20),
	users_id INT(20),
	win_id INT(20),
	categories_id INT(20)
);

CREATE TABLE rate (
	id INT AUTO_INCREMENT PRIMARY KEY,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	amount INT(20),
	users_id INT(20),
	lot_id INT(20)
);
