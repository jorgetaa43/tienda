CREATE SCHEMA db_login;
USE db_login;

CREATE TABLE usuarios (
	usuario VARCHAR(20) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL
);

SELECT * FROM usuarios;