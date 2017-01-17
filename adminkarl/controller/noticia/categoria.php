<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/categoria.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$data 		= json_decode(file_get_contents('php://input'), true);
$codigo 	= $data['codigo'];

$objcat 	= new Categoria();
$datacat 	= $objcat->dameCategoria(0);
//$arrjson['dd'] = $datacat; 
$item = count($datacat) - 1;
$count = 0;
for ($i=0; $i<=$item;$i++){
	$midata = $datacat[$i];
	$arrjson['categoria'][$count]['id'] 	= $midata['cat_id'];
	$arrjson['categoria'][$count]['nombre'] = $midata['cat_nombre'];
	$arrjson['categoria'][$count]['clase']  = "";

	$count++;

	$objcathij 	= new Categoria();
	$datacathij = $objcathij->dameCategoria($midata['cat_id']);
	$item2 = count($datacathij) - 1;
	
	for ($j=0; $j<=$item2;$j++){
		$midata2 = $datacathij[$j];
		$arrjson['categoria'][$count]['id'] 	= $midata2['cat_id'];
		$arrjson['categoria'][$count]['nombre'] = $midata2['cat_nombre'];
		$arrjson['categoria'][$count]['clase']  = "sub_option";
		$count++;
	}
}


echo json_encode($arrjson);
?>