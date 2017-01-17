<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/reconocimiento.php');
include('../../modelo/url.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$arrjson['codigo'] 			= $objfunc->verificarDataPost('codigo');
$arrjson['rec_titulo'] 		= $objfunc->verificarDataPost('rec_titulo');
$arrjson['rec_descripcion'] = $objfunc->verificarDataPost('rec_descripcion');
$arrjson['rec_video'] 		= $objfunc->verificarDataPost('rec_video');

$arrjson['pre_campo1'] 		= $objfunc->verificarDataPost('pre_campo1');
$arrjson['pre_campo2'] 		= $objfunc->verificarDataPost('pre_campo2');
$arrjson['pre_campo3'] 		= $objfunc->verificarDataPost('pre_campo3');
$arrjson['pre_campo4'] 		= $objfunc->verificarDataPost('pre_campo4');
$arrjson['pre_campo5'] 		= $objfunc->verificarDataPost('pre_campo5');
$arrjson['pre_campo6'] 		= $objfunc->verificarDataPost('pre_campo6');
$arrjson['pre_campo7'] 		= $objfunc->verificarDataPost('pre_campo7');
$arrjson['pre_campo8'] 		= $objfunc->verificarDataPost('pre_campo8');
$arrjson['pre_campo9'] 		= $objfunc->verificarDataPost('pre_campo9');
$arrjson['pre_campo10'] 	= $objfunc->verificarDataPost('pre_campo10');
$arrjson['pre_campo11'] 	= $objfunc->verificarDataPost('pre_campo11');
$arrjson['pre_campo12'] 	= $objfunc->verificarDataPost('pre_campo12');
$arrjson['pre_campo13'] 	= $objfunc->verificarDataPost('pre_campo13');
$arrjson['pre_campo14'] 	= $objfunc->verificarDataPost('pre_campo14');
$arrjson['pre_campo15'] 	= $objfunc->verificarDataPost('pre_campo15');

$arrjson['rec_precio_monto']  			= $objfunc->verificarDataPost('rec_precio_monto');
$arrjson['rec_precio_exclusivo']  		= $objfunc->verificarDataPost('rec_precio_exclusivo');
$arrjson['rec_empdist_descripcion']   	= $objfunc->verificarDataPost('rec_empdist_descripcion');


$arrjson['act_img_logo']      		= $objfunc->verificarDataPost('act_img_logo');
$arrjson['act_fichainscripcion']    = $objfunc->verificarDataPost('act_fichainscripcion');
$arrjson['act_brochure']      		= $objfunc->verificarDataPost('act_brochure');
$arrjson['act_catalogo']      		= $objfunc->verificarDataPost('act_catalogo');
$arrjson['act_img_ejeimagen']      	= $objfunc->verificarDataPost('act_img_ejeimagen');
$arrjson['act_img_cronograma']      = $objfunc->verificarDataPost('act_img_cronograma');

$arrjson['rec_logo'] = "";
$arrjson['rec_fichainscripcion'] = "";
$arrjson['rec_brochure'] = "";
$arrjson['rec_catalogo'] = "";
$arrjson['rec_ejeimagen'] = "";
$arrjson['rec_cronograma_img'] = "";
/***Procesar Imagenes****/

$objfunc 	= new misFunciones();

$arrjson['ruta'] = "../../../resources/assets/image/reconocimiento/";


if (isset($_FILES['rec_logo'])){
	$arrjson['rec_logo'] = $objfunc->subirFoto('rec_logo',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_img_logo'],$arrjson['ruta']);
}
if (isset($_FILES['rec_fichainscripcion'])){
	$arrjson['rec_fichainscripcion'] = $objfunc->subirFoto('rec_fichainscripcion',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_fichainscripcion'],$arrjson['ruta']);
}
if (isset($_FILES['rec_brochure'])){
	$arrjson['rec_brochure'] = $objfunc->subirFoto('rec_brochure',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_brochure'],$arrjson['ruta']);
}
if (isset($_FILES['rec_catalogo'])){
	$arrjson['rec_catalogo'] = $objfunc->subirFoto('rec_catalogo',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_catalogo'],$arrjson['ruta']);
}
if (isset($_FILES['rec_ejeimagen'])){
	$arrjson['rec_ejeimagen'] = $objfunc->subirFoto('rec_ejeimagen',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_img_ejeimagen'],$arrjson['ruta']);
}
if (isset($_FILES['rec_cronograma_img'])){
	$arrjson['rec_cronograma_img'] = $objfunc->subirFoto('rec_cronograma_img',$arrjson['ruta']);
	$objfunc->eliminarFoto($arrjson['act_img_cronograma'],$arrjson['ruta']);
}

$bool_sql = false;
if ($arrjson['codigo'] > 0){
	/***Actualizamos dado que ya existe***/
	$objnot 	= new Reconocimiento();
	$bool_sql 	= $objnot->hacerActualizacion($arrjson);
	/***Agregamos Precio***/
	$objnot 	= new Reconocimiento();
	$arrjson['xxx'] = $objnot->prodeceActualizarPrecio($arrjson);

	//$arrjson['xxx'] = $bool_sql;
	
	$mensaje = "Se ha actualizado correctamente";
	$arrjson['cambiar_url'] = false;
}else{
	/***Agregamos***/
	$objnot 	= new Reconocimiento();
	$bool_sql = $objnot->prodeceAregar($arrjson);
	$arrjson['codigo'] = $bool_sql;	
	/***Agregamos Precio***/
	$objnot 	= new Reconocimiento();
	$objnot->prodeceAgregarPrecio($arrjson);
	
	if ($bool_sql > 0)
		$arrjson['codigo'] = $bool_sql;
	$mensaje = "Se añadió correctamente";
	$arrjson['cambiar_url'] = true;
}

if ($bool_sql){	
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