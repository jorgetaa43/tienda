<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/claseProductos.php" ?>
    <?php require 'base_datos/base_datos_supermercado.php' ?>

    <style>
        td {
            text-align: center;
            vertical-align: middle;
        }
        #carrito {
            float: right;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        $usuario = $_SESSION["usuario"];

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
        
        
    ?>

<div class="container">
        <h1>Listado de Productos</h1>
        <table class="table table-striped" style="border: 1px solid black">
        <a id="carrito" href="cestas_usuario.php"><button><img src="imagenes/carrito.png" alt="carrito de la compra" width="100%" height="40px"></button></a> 
            <thead class="table table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th></th>
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
                <td>
                    <form action="" method="post">
                        <?php
                        $sql = "SELECT id_cesta FROM cestas WHERE cestas_usuario = '$usuario'";
                        $resultado = $conexion -> query($sql);
                        while($fila = $resultado -> fetch_assoc()) {
                        ?>
                        <select name="cantidad">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <?php
                        }?>
                        <input class="btn btn-warning" name="anadir" type="submit" value="Añadir a cesta">
                        <input type="hidden" name="idProducto" value="<?php echo $producto->idProducto ?>">
                    </form>
                </td>
                <?php
                echo "</tr>";
            }?>
            </tbody> 
        </table>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $idProducto = $_POST["idProducto"];

            $sql = "SELECT id_cesta FROM cestas WHERE cestas_usuario = '$usuario'";
            $resultado = $conexion -> query($sql);
            while($fila = $resultado -> fetch_assoc()) {
                $idCesta = $fila["id_cesta"];
                echo "<p>$idCesta</p>";
            }

            $sql = "INSERT INTO productos_cestas(idProducto, idCesta, cantidad) Values('$idProducto', '$idCesta', '".$_POST["cantidad"]."')";
            $conexion -> query($sql);
        }
        $rol = $_SESSION["rol"];
        if($rol == "admin") {?>
           <a href="productos.php"><button class="btn btn-primary" name="registro">Agregar</button></a> 
        <?php
        }?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>