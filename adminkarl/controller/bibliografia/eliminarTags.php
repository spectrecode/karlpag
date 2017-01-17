<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/blog.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$arrjson['codigo'] 	 = $data['codigo'];

$objnot 			 = new Blog();
$bool_sql = $objnot->eliminarTag($arrjson);
if ($bool_sql){	
	$arrjson['message'] 	= "Se elimino el Tag correctamente";
	$arrjson['success'] 	= true;
	$arrjson['class_mess']  = "exito";
}else{
	$arrjson['message'] 	= "No se ha podido, vuelva a intentarlo más tarde";
	$arrjson['success'] 	= false;
	$arrjson['class_mess']  = "error";
}

echo json_encode($arrjson);
?>