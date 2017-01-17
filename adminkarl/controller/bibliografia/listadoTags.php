<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/blog.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 	 = $data['codigo'];

$objnot 			 = new Blog();
$arrjson['listTag']  = $objnot->ListTag($arrjson);

echo json_encode($arrjson);
?>