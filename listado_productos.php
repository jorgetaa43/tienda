<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "claseProductos.php" ?>
    <?php require 'base_datos/base_datos_supermercado.php' ?>

    <style>
        td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <?php
        $sql = "SELECT * FROM productos";
        $resultado = $conexion -> query($sql);
        $productos = [];
        while($fila = $resultado -> fetch_assoc()) {
            $idProducto = $fila["id_producto"];
            $nombre = $fila["nombreProducto"];
            $precio = $fila["precio"];
            $descripcion = $fila["descripcion"];
            $cantidad = $fila["cantidad"];
            $imagen = $fila["imagen"];

            $nuevo_producto = new Productos($idProducto,$nombre,$precio,$descripcion,$cantidad,$imagen);
            array_push($productos, $nuevo_producto);
        }

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Agregar") {
            header("location: productos.php");
        }
    ?>

<div class="container">
        <h1>Listado de Productos</h1>
        <table class="table table-striped" style="border: 1px solid black">
            <thead class="table table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($productos as $producto) {
                    echo "<tr>";
                    echo "<td>" . $producto->idProducto . "</td>";
                    echo "<td>" . $producto->nombreProducto . "</td>";
                    echo "<td>" . $producto->precio . "</td>";
                    echo "<td>" . $producto->descripcion . "</td>";
                    echo "<td>" . $producto->cantidad . "</td>";?>
                    <td>
                        <img width="80px" height="80px" src="<?php echo $producto->imagen ?>">
                    </td>
                    <?php
                    echo "</tr>";
                }
            ?>
            </tbody> 
        </table>
        <form action="" method="post">
        <input type="submit" class="btn btn-primary" id="boton" name="registro" value="Agregar">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>