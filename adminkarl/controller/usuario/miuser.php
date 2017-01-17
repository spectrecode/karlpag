<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');

$arrjson['id']    = $_SESSION['COD_USER'];

echo json_encode($arrjson);
?>