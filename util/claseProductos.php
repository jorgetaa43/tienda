<?php
    class Productos{
        public int $idProducto;
        public string $nombreProducto;
        public float $precio;
        public string $descripcion;
        public float $cantidad;
        public string $imagen;

        function __construct(int $idProducto, string $nombreProducto,float $precio,string $descripcion,float $cantidad,string $imagen) {
            $this -> idProducto = $idProducto;
            $this -> nombreProducto = $nombreProducto;
            $this -> precio = $precio;
            $this -> descripcion = $descripcion;
            $this -> cantidad = $cantidad;
            $this -> imagen = $imagen;
        }
    }
?>