CREATE SCHEMA usuarios;
USE usuarios;
CREATE TABLE usuarios (
	usuario VARCHAR(8) PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    apellidos VARCHAR(40) NOT NULL,
    fecha_nacimiento DATE NOT NULL
);

DROP TABLE usuarios;
SELECT * FROM usuarios;

CREATE SCHEMA db_videojuegos;
USE db_videojuegos;

CREATE TABLE videojuegos (
	id_videojuego NUMERIC(8), -- comprobar que es un número entero de max 8 dígitos
    titulo VARCHAR(100) NOT NULL, -- comprobar que tiene 100 o menos caracteres
    pegi VARCHAR(2) NOT NULL,  -- comprobar que es uno de los valores válidos 
    compania VARCHAR(50) NOT NULL, -- comprobar que tiene 50 caracteres o menos
	CONSTRAINT chk_pegi CHECK (pegi IN ('3', '7', '12', '16', '18'))
);

DROP TABLE videojuegos;
SELECT * FROM videojuegos;
ALTER TABLE videojuegos
	ADD COLUMN imagen VARCHAR(100);
DELETE FROM videojuegos WHERE pegi = 3;
SET SQL_SAFE_UPDATES = 0;




