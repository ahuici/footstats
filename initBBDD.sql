drop database FOOTSTATS;
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

INSERT INTO users (pwd, name, surname, age, gender, privilege) VALUES
('hash1', 'Admin', 'Master', 35, 'hombre', 0),
('hash2', 'Iker', 'Etxeberria', 22, 'hombre', 1),
('hash3', 'Ane', 'Goikoetxea', 24, 'mujer', 1),
('hash4', 'Unai', 'Aguirre', 21, 'hombre', 1),
('hash5', 'Nahia', 'Aramburu', 23, 'mujer', 1),
('hash6', 'Gaizka', 'Larrain', 28, 'hombre', 1),
('hash7', 'Maialen', 'Olabarrieta', 26, 'mujer', 1),
('hash8', 'Asier', 'Otegi', 27, 'hombre', 1),
('hash9', 'Irati', 'Urrutia', 25, 'mujer', 1),
('hash10', 'Jon', 'Zabala', 30, 'hombre', 1);

INSERT INTO players (creator_id, name, surname, number, team, selection, goals, position) VALUES
(1, 'Sergio', 'Herrera', 1, 'CA Osasuna', 'España', 0, 'portero'),
(2, 'Aitor', 'Fernández', 13, 'CA Osasuna', 'España', 0, 'portero'),
(3, 'David', 'García', 5, 'CA Osasuna', 'España', 10, 'defensa'),
(4, 'Nacho', 'Vidal', 2, 'CA Osasuna', 'España', 3, 'defensa'),
(5, 'Alejandro', 'Catena', 24, 'CA Osasuna', 'España', 5, 'defensa'),
(6, 'Unai', 'García', 4, 'CA Osasuna', 'España', 4, 'defensa'),
(7, 'Lucas', 'Torró', 6, 'CA Osasuna', 'España', 7, 'mediocentro'),
(8, 'Moi', 'Gómez', 10, 'CA Osasuna', 'España', 9, 'mediocentro'),
(9, 'Joshua', 'Kimmich', 6, 'Bayern', 'Alemania', 25, 'mediocentro'),
(10, 'Kevin', 'De Bruyne', 17, 'Manchester City', 'Bélgica', 60, 'mediocentro'),
(1, 'Luka', 'Modric', 10, 'Croatia FC', 'Croacia', 40, 'mediocentro'),
(2, 'Pedri', 'González', 8, 'FC Barcelona', 'España', 15, 'mediocentro'),
(3, 'Rodri', 'Hernández', 16, 'Manchester City', 'España', 18, 'mediocentro'),
(4, 'Lionel', 'Messi', 10, 'Inter Miami', 'Argentina', 800, 'delantero'),
(5, 'Kylian', 'Mbappé', 7, 'PSG', 'Francia', 300, 'delantero'),
(6, 'Erling', 'Haaland', 9, 'Manchester City', 'Noruega', 250, 'delantero'),
(7, 'Robert', 'Lewandowski', 9, 'FC Barcelona', 'Polonia', 500, 'delantero'),
(8, 'Bukayo', 'Saka', 7, 'Arsenal', 'Inglaterra', 60, 'delantero'),
(9, 'Antoine', 'Griezmann', 7, 'Atlético de Madrid', 'Francia', 250, 'delantero'),
(10, 'Chimy', 'Ávila', 9, 'CA Osasuna', 'Argentina', 30, 'delantero');

select * from users;
select * from players;
