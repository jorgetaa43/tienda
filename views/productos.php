<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "base_datos/base_datos_supermercado.php" ?>
</head>
<body>
    <?php 
        session_start();
        $rol = $_SESSION["rol"];
        if($rol == "cliente") {
           header("location: listado_productos.php");
        }

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Ver listado") {
            header("location: listado_productos.php");
        } else if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Agregar") {
            $temp_nombre = $_POST["nombre"];
            $temp_precio = $_POST["precio"];
            $temp_descripcion = $_POST["descripcion"];
            $temp_cantidad = $_POST["cantidad"];
            $temp_imagen = $_FILES["imagen"];
            /* Insercción de imágenes */
            $nombre_fichero = $_FILES["imagen"]["name"];
            $ruta_temporal = $_FILES["imagen"]["tmp_name"];
            $formato = $_FILES["imagen"]["type"];
            $ruta_final = "imagenes/" . $nombre_fichero;
            $tamano = $_FILES["imagen"]["size"];


            /* Validación nombre */
            if(strlen($temp_nombre) == 0) {
                $error_nombre = "Este campo es obligatorio";
            } else {
                $regex1 = "/^[A-Za-z0-9 ]*$/";
                if(!preg_match($regex1, $temp_nombre)) {
                    $error_nombre = "Error, el nombre solo puede contener letras, número y espacios en blanco";
                } else {
                    if(strlen($temp_nombre) > 40) {
                        $error_nombre = "Error, el nombre debe tener menos de 41 carácteres.";
                    } else {
                        $nombre = $temp_nombre;
                    }
                }
            }

            /* Validación precio */
            if(strlen($temp_precio) == 0) {
                $error_precio = "Este campo es obligatorio";
            } else {
                if(filter_var($temp_precio, FILTER_VALIDATE_FLOAT) === false) {
                    $error_precio = "Debes introducir un número decimal.";
                } else {
                    $temp_precio = (float) $temp_precio;
                    if($temp_precio > 99999.99) {
                        $error_precio = "Error, el precio debe ser menor de 100000.00";
                    } else {
                        if($temp_precio < 0) {
                            $error_precio = "Error, el precio debe ser mayor a 0.";
                        } else {
                            $precio = $temp_precio;
                        }
                    }
                }
            }

            /* Validación descripción */
            if(strlen($temp_descripcion) == 0) {
                $error_descripcion = "Este campo es obligatorio";
            } else {
                if(strlen($temp_descripcion) > 255) {
                    $error_descripcion = "Error, el nombre debe tener menos de 256 carácteres.";
                } else {
                    $descripcion = $temp_descripcion;
                }
            }

            /* Validación cantidad */
            if(strlen($temp_cantidad) == 0) {
                $error_cantidad = "Este campo es obligatorio";
            } else {
                if(filter_var($temp_cantidad, FILTER_VALIDATE_INT) === false) {
                    $error_cantidad = "Error, la cantidad debe ser un número entero.";
                } else {
                    $temp_cantidad = (int) $temp_cantidad;
                    if($temp_cantidad < 0 || $temp_cantidad > 99999) {
                        $error_cantidad = "Error, la cantidad debe estar entre 0 y 1000000";
                    } else {
                        $cantidad = $temp_cantidad;
                    }
                }
            }

            /* Validación imagen */
            if(strlen($nombre_fichero) == 0) {
                $error_imagen = "Este campo es obligatorio";
            } else {
                if($formato != "image/jpg" && $formato != "image/jpeg" && $formato != "image/png") {
                    $error_imagen = "Error, el formato de la imagen no es válido.";
                } else {
                    if($tamano > 1*1024*1024) {
                        $error_imagen = "Error, el tamaño de la imagen no es válido.";
                    } else {
                        move_uploaded_file($ruta_temporal, $ruta_final);
                    }
                }
            }
        }
    ?>

    <div class="container mt-3">
        <h1 class="h1">Productos</h1>
        
        <form action="" method="post" enctype="multipart/form-data">
            <label for="" class="form-label">Nombre: </label>
            <input type="text" class="form-control" name="nombre" placeholder="Introduzca el nombre">
            <?php
                if (isset($error_nombre)) {
                    echo $error_nombre;
                }
            ?>

            <br>

            <label for="" class="form-label">Precio: </label>
            <input type="text" class="form-control" name="precio" placeholder="Introduzca el precio">
            <?php
                if (isset($error_precio)) {
                    echo $error_precio;
                }
            ?>

            <br>

            <label for="" class="form-label">Descripción: </label>
            <input type="text" class="form-control" name="descripcion" placeholder="Introduzca una descripción">
            <?php
                if (isset($error_descripcion)) {
                    echo $error_descripcion;
                }
            ?>

            <br>

            <label for="" class="form-label">Cantidad: </label>
            <input type="text" class="form-control" name="cantidad" placeholder="Introduzca la cantidad">
            <?php
                if (isset($error_cantidad)) {
                    echo $error_cantidad;
                }
            ?>

            <br>

            <label for="" class="form-label">Imagen: </label>
            <input type="file" class="form-control" name="imagen">
            <?php
                if (isset($error_imagen)) {
                    echo $error_imagen;
                }
            ?>

            <br>

            <div id="button">
                <input type="submit" class="btn btn-primary" id="boton" name="registro" value="Agregar">
                <input type="submit" class="btn btn-primary" name="registro" value="Ver listado">
            </div>
        </form>
    </div>

    <?php
        if (isset($nombre) && isset($precio) && isset($descripcion) && isset($cantidad)) {
            echo "<h3>Nombre: " . $nombre . "</h3>";
            echo "<h3>Precio: " . $precio . "</h3>";
            echo "<h3>Descripción: " . $descripcion . "</h3>";
            echo "<h3>Cantidad: " . $cantidad . "</h3>";

            $sql = "INSERT INTO productos(nombreProducto, precio, descripcion, cantidad, imagen)
                Values('$nombre', '$precio', '$descripcion', '$cantidad', '$ruta_final')";
            $conexion -> query($sql);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>