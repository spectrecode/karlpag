<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/noticia.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$arrjson['codigo'] 				= $objfunc->verificarDataPost('codigo');
$arrjson['titulo'] 				= $objfunc->verificarDataPost('titulo');
$arrjson['frase'] 				= $objfunc->verificarDataPost('frase');
$arrjson['url_seo'] 			= $objfunc->verificarDataPost('url_seo');
$arrjson['order'] 				= $objfunc->verificarDataPost('order',1);
$arrjson['f_publicacion'] 		= $objfunc->verificarDataPost('f_publicacion',2);
$arrjson['descrip_superior'] 	= $objfunc->verificarDataPost('descrip_superior');
$arrjson['descrip_inferior'] 	= $objfunc->verificarDataPost('descrip_inferior');
$arrjson['tip_multimedia']      = "";
$arrjson['categoria']      		= 8; // categoria = bibliografia
$arrjson['mul_fileImagen']      = "";
$arrjson['mul_video']           = "";
$arrjson['act_img_portada']     = $objfunc->verificarDataPost('act_img_portada');
$arrjson['act_mul_imagen']      = $objfunc->verificarDataPost('act_mul_imagen');


$arrjson['estado'] 			= 1;

/***Procesar Imagenes****/
$objfunc 	= new misFunciones();

$arrjson['ruta'] = "../../resources/assets/image/bibliografia/";

if (isset($_POST['tip_multimedia'])) {
	$arrjson['tip_multimedia'] 		= $_POST['tip_multimedia'];
	if ($arrjson['tip_multimedia'] == 1){
		if (isset($_FILES['mul_fileImagen']))
			if (!empty($_FILES['mul_fileImagen'])){
				$arrjson['mul_fileImagen'] = $objfunc->subirFoto('mul_fileImagen',$arrjson['ruta']);
				$objfunc->eliminarFoto($arrjson['act_mul_imagen'],$arrjson['ruta']);
			}
	}
	if ($arrjson['tip_multimedia'] == 2){
		$arrjson['mul_video'] = $_POST['mul_video'];
	}	
}

$arrjson['file_portada'] = "";
if (isset($_FILES['file_portada']))
	if (!empty($_FILES['file_portada'])){
		//if ($arrjson['tmp_file_portada'] != $_FILES['file_portada']['name']){
		$arrjson['file_portada'] = $objfunc->subirFoto('file_portada',$arrjson['ruta']);
		$objfunc->eliminarFoto($arrjson['act_img_portada'],$arrjson['ruta']);		
		//}
	}

$objnot 	= new Noticia();
$bool_sql = false;
if ($arrjson['codigo'] > 0){
	/***Actualizamos dado que ya existe la noticia***/
	$bool_sql 	= $objnot->hacerActualizacion($arrjson);
	$objnot 	= new Noticia();
	$arrjson['sql_seo'] = $objnot->actualizarUrlSeo($arrjson);
	$mensaje = "Se ha actualizado correctamente";
	$arrjson['cambiar_url'] = false;
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