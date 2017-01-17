<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/captcha.php');

$arrjson 	= "";
$data 		= json_decode(file_get_contents('php://input'), true);
$nameform 	= $data['nameform'];
$_SESSION['captcha'] = simple_php_captcha();
//Validación en el servidor
$objfuncion = new misFunciones();

$arrjson['token'] = $objfuncion->generarFormToken($nameform);
$arrjson['captcha'] = $_SESSION['captcha']['image_src'];

echo json_encode($arrjson);

?>