CREATE SCHEMA supermercado;
USE supermercado;

CREATE TABLE productos (
	id_producto INT(1) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- Autogenerado
	nombreProducto VARCHAR(40) NOT NULL, -- Solo acepta números, letras y barrabaja
    precio NUMERIC(5,2) NOT NULL, -- Máximo 99999,99 y tiene que ser mayor o igual que 0
    descripcion VARCHAR(255) NOT NULL,  -- Máximo 255 carácteres
    cantidad NUMERIC(5) NOT NULL, -- Mínimo 0 y máximo 99999
    imagen VARCHAR(100) 
);

DROP TABLE productos;
SELECT * FROM productos;
DELETE FROM productos WHERE (id_producto = 2);


CREATE TABLE usuarios (
	usuario VARCHAR(12) NOT NULL PRIMARY KEY, -- Solo acepta letras y barrabaja
	contrasena VARCHAR(255) NOT NULL, -- Máximo 255 carácteres
    fecha_nacimiento DATE NOT NULL -- Tiene que estar no menos de -120 años y no más de 12 años
);

DROP TABLE usuarios;
SELECT * FROM usuarios;
UPDATE usuarios SET rol = "admin" WHERE usuario = "juanjo";

ALTER TABLE usuarios ADD COLUMN rol VARCHAR(10) DEFAULT 'cliente';
ALTER TABLE usuarios DROP COLUMN rol;
/* El rol será o admin o cliente */
/* Cuando se registre un usuario, su rol será siempre cliente */
/* Manualmente modificareis un usuario para que sea admin y unicamente ese usuario con rol admin podra ver la pag de crear productos */
/* IDEA: Cuando se logee un usuario, almacenar en $_SESSION el rol. Preguntaremos en la página
         de crear usuario si $_SESSION["rol"] == admin, si lo dejamos ver la página, sino, redigiremos a la página principal */ 

CREATE TABLE cestas (
	id_cesta INT(1) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- Autogenerado
    precioTotal NUMERIC(5,2) NOT NULL, -- Tiene que ser menor de 99999,99 y va a estar por defecto en 0
	cestas_usuario VARCHAR(12),
    FOREIGN KEY(cestas_usuario) REFERENCES usuarios(usuario)
);

DROP TABLE cestas;
SELECT * FROM cestas;


CREATE TABLE productos_cestas (
	idProducto INT(1) NOT NULL PRIMARY KEY, -- Autogenerado
    idCesta INT(1) NOT NULL, -- Autogenerado
	cantidad INT(2),
    FOREIGN KEY(idProducto) REFERENCES productos(id_producto),
    FOREIGN KEY(idCesta) REFERENCES cestas(id_cesta)
);

DROP TABLE productos_cestas;
SELECT * FROM productos_cestas;
DELETE FROM productos_cestas;
SET SQL_SAFE_UPDATES = 0;