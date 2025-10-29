<?php
$conexion = mysqli_connect('localhost', 'root', '', 'smartsteel');
if (mysqli_connect_errno()) {
    echo "Fallo la conexion MySQL " . mysqli_connect_error();
}
mysqli_set_charset($conexion, "utf8");
