<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/noticia.php');


$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 		= $data['codigo'];
$arrjson['valor']		= $data['valor'];
$arrjson['variable'] 	= $data['variable'];

$objnot 	= new Noticia();
$bool_sql 	= false;
$bool_sql 	= $objnot->actualizarDatosListado($arrjson);

if ($bool_sql){	
	$arrjson['message'] 	= "Se actualizado correctamente";
	$arrjson['success'] 	= true;
	$arrjson['class_mess']  = "exito";
}else{
	$arrjson['message'] 	= "No se ha podido, vuelva a intentarlo más tarde";
	$arrjson['success'] 	= false;
	$arrjson['class_mess']  = "error";
}
echo json_encode($arrjson);
?>