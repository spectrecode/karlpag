<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/evento.php');
include('../../modelo/url.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$arrjson['codigo'] 		= $objfunc->verificarDataPost('codigo');
$arrjson['titulo'] 		= $objfunc->verificarDataPost('titulo');
$arrjson['fecha'] 		= $objfunc->verificarDataPost('fecha');
$arrjson['dia'] 		= $objfunc->verificarDataPost('dia');
$arrjson['hora'] 		= $objfunc->verificarDataPost('hora');
$arrjson['lugar'] 		= $objfunc->verificarDataPost('lugar');
$arrjson['mapa'] 		= $objfunc->verificarDataPost('mapa');
$arrjson['link'] 		= $objfunc->verificarDataPost('link');
$arrjson['email'] 		= $objfunc->verificarDataPost('email');
$arrjson['telefono'] 	= $objfunc->verificarDataPost('telefono');
$arrjson['contacto'] 	= $objfunc->verificarDataPost('contacto');

$arrjson['descrip_superior']  = $objfunc->verificarDataPost('descrip_superior');
$arrjson['descrip_inferior']  = $objfunc->verificarDataPost('descrip_inferior');
$arrjson['descrip_asistir']   = $objfunc->verificarDataPost('descrip_asistir');

$arrjson['eve_tema']  = $objfunc->verificarDataPost('eve_tema');


$bool_sql = false;
if ($arrjson['codigo'] > 0){
	/***Actualizamos dado que ya existe la noticia***/
	$objnot 	= new Evento();
	$bool_sql  	= $objnot->hacerActualizacion($arrjson);
	//***Agregamos Galeria
	$objnot 			 	= new Evento();
	$arrjson['galcod'] 		= $objnot->AgregarTemaEvento($arrjson);	
}else{
	/***Agregamos una noticia***/
	$objnot 	= new Evento();
	$bool_sql = $objnot->prodeceAregar($arrjson);
	$arrjson['codigo'] = $bool_sql;
	//***Agregamos el tag
	$objnot 			 	= new Evento();
	$arrjson['galcod'] 		= $objnot->AgregarTemaEvento($arrjson);
	if ($bool_sql > 0)
		$arrjson['codigo'] = $bool_sql;
}

if ($bool_sql){	
	$mensaje = "Se agrego un nuevo tema de evento correctamente";
	$arrjson['message'] 	= $mensaje;
	$arrjson['success'] 	= true;
	$arrjson['class_mess']  = "exito";
}else{
	$arrjson['message'] 	= "No se ha podido, vuelva a intentarlo más tarde";
	$arrjson['success'] 	= false;
	$arrjson['class_mess']  = "error";
}

echo json_encode($arrjson);
?>