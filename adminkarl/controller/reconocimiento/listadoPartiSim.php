<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/evento.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 	 = $data['codigo'];

$objnot 	= new Evento();
$datanot 	= $objnot->ListPartSimp($arrjson);
$item  		= count($datanot) - 1;
$objfunc 	= new misFunciones();
for($i=0; $i<=$item; $i++){
	$data 	= $datanot[$i];
	$arrjson['listParSimp'][$i]['psi_id'] 		= $data['psi_id'];
	$arrjson['listParSimp'][$i]['psi_titulo'] 		= $data['psi_titulo'];
	$arrjson['listParSimp'][$i]['psi_descripcion'] 	= $objfunc->convertir_html($data['psi_descripcion']);
}

echo json_encode($arrjson);
?>