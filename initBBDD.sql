drop database footstats;
CREATE DATABASE FOOTSTATS;

USE FOOTSTATS;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pwd VARCHAR(200),
    username VARCHAR(200),
    name VARCHAR(200),
    surname VARCHAR(200),
    age INT,
    gender ENUM('hombre', 'mujer', 'otro'),
    privilege INT
);

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT,
    name VARCHAR(200),
    surname VARCHAR(200),
    number INT,
    team VARCHAR(200),
    selection VARCHAR(200),
    goals INT,
    position ENUM('portero','defensa','mediocentro','delantero'),
    FOREIGN KEY (creator_id) REFERENCES users(id)
);