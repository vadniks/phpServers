CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,INSERT ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;
USE appDB;

CREATE TABLE IF NOT EXISTS users (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) NOT NULL,
  password VARCHAR(40) NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS valuables (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    title VARCHAR(32) NOT NULL,
    description VARCHAR(256) NOT NULL,
    cost INT(6) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO users (name, password)
SELECT * FROM (SELECT 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997') AS temp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'admin' AND password = 'd033e22ae348aeb5660fc2140aec35850c4da997'
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
