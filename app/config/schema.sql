CREATE TABLE IF NOT EXISTS Users(
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(30) UNIQUE NOT NULL,
	password VARCHAR(100) NOT NULL,
	date_register DATETIME NOT NULL
) ENGINE = MYISAM CHARACTER SET = utf8;
CREATE TABLE IF NOT EXISTS Statuses(
	id INT AUTO_INCREMENT,
	user_id VARCHAR(30),
	message VARCHAR(140),
	date_post DATETIME NOT NULL,
	client VARCHAR(100) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES Users(id)
) ENGINE = MYISAM CHARACTER SET = utf8;