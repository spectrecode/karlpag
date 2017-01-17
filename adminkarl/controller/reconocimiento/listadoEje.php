<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/reconocimiento.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 	 = $data['codigo'];
$arrjson['catid'] 	 = $data['catid'];

$objnot 			 = new Reconocimiento();
$arrjson['listEje']  = $objnot->ListEje($arrjson);

echo json_encode($arrjson);
?>