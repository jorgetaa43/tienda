<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cestas del usuario</title>
    <link rel="stylesheet" href="CSS/cestas_usuario.css">
    <?php require "base_datos/base_datos_supermercado.php" ?>
</head>
<body> 
    <?php
    session_start();
    $usuario = $_SESSION["usuario"];
    ?>
    <table >
        <caption>Cestas de <?php echo $usuario ?></caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT p.nombreProducto, p.imagen, p.precio, pc.cantidad FROM productos p JOIN productos_cestas pc ON(p.id_producto = pc.idProducto) INNER JOIN cestas c ON(c.id_cesta = pc.idCesta) WHERE c.cestas_usuario = '$usuario'";
        $resultado = $conexion -> query($sql);
        while($fila = $resultado -> fetch_assoc()) {?>
            <tr>
                <td><?php echo $fila["nombreProducto"]; ?></td>
                <td><img width="80px" height="80px" src="<?php echo $fila["imagen"]; ?>"></td>
                <td><?php echo $fila["precio"]; ?></td>
                <td><?php echo $fila["cantidad"]; ?></td>
            </tr>
        <?php
        }?>
        </tbody>
    </table>
</body>
</html>