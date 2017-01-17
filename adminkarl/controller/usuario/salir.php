<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');

$arrjson['id']    = $_SESSION['COD_USER'];
$objuser = new Usuario();
$objuser->CerrarSession($arrjson['id']);


echo json_encode($arrjson);
?>