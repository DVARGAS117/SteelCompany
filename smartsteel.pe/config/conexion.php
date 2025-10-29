<?php
$conexion = mysqli_connect('localhost', 'roque192_Us5020x', 'RTE340lasd129X9', 'roque192_XXNEO2050');
if (mysqli_connect_errno()) {
    echo "Fallo la conexion MySQL " . mysqli_connect_error();
}
mysqli_set_charset($conexion, "utf8");
