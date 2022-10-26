CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;
USE appDB;

CREATE TABLE IF NOT EXISTS users (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) CHARACTER SET ascii NOT NULL,
    password VARCHAR(45) CHARACTER SET ascii NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS valuables (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    title VARCHAR(32) NOT NULL,
    description VARCHAR(256) NOT NULL,
    cost INT(6) NOT NULL,
    PRIMARY KEY (ID)
);

-- htpasswd -bns admin admin
INSERT INTO users (name, password)
SELECT * FROM (SELECT 'admin', '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc=') AS temp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'admin' AND password = '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc='
) LIMIT 1;

INSERT INTO valuables (title, description, cost)
SELECT * FROM (SELECT 'Vase', 'Antique chinese flower vase from XIX century', 1000) AS temp
WHERE NOT EXISTS (
    SELECT title FROM valuables WHERE title = 'Vase' AND description = 'Antique chinese flower vase from XIX century' AND cost = 1000
) LIMIT 1;

INSERT INTO valuables (title, description, cost)
SELECT * FROM (SELECT 'Chair', 'Cheap wooden chair', 50) AS temp
WHERE NOT EXISTS (
    SELECT title FROM valuables WHERE title = 'Chair' AND description = 'Cheap wooden chair' AND cost = 50
) LIMIT 1;
