<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/evento.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 	 = $data['codigo'];

$objnot 			 = new Evento();
$bool_sql = $objnot->eliminarParSimp($arrjson);
$arrjson['xxx'] = $bool_sql;
if ($bool_sql){	
	$arrjson['message'] 	= "Se elimino la imagén";
	$arrjson['success'] 	= true;
	$arrjson['class_mess']  = "exito";
}else{
	$arrjson['message'] 	= "No se ha podido, vuelva a intentarlo más tarde";
	$arrjson['success'] 	= false;
	$arrjson['class_mess']  = "error";
}

echo json_encode($arrjson);
?>