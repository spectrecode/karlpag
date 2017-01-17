<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/blog.php');
include('../../modelo/url.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$arrjson['codigo'] 				= $objfunc->verificarDataPost('codigo');
$arrjson['titulo'] 				= $objfunc->verificarDataPost('titulo');
$arrjson['url_seo'] 			= $objfunc->verificarDataPost('url_seo');
$arrjson['order'] 				= $objfunc->verificarDataPost('order',1);
$arrjson['frase'] 				= $objfunc->verificarDataPost('frase');
$arrjson['f_publicacion'] 		= $objfunc->verificarDataPost('f_publicacion',2);
$arrjson['descrip_superior'] 	= $objfunc->verificarDataPost('descrip_superior');
$arrjson['descrip_inferior'] 	= $objfunc->verificarDataPost('descrip_inferior');
$arrjson['tag'] 	 			= $objfunc->verificarDataPost('tag');
$arrjson['tip_multimedia']      = "";
$arrjson['mul_fileImagen']      = "";
$arrjson['mul_video']           = "";
$arrjson['act_img_autor']     	= $objfunc->verificarDataPost('act_img_autor');
$arrjson['nom_autor']     		= $objfunc->verificarDataPost('nom_autor');
$arrjson['act_mul_imagen']      = $objfunc->verificarDataPost('act_mul_imagen');

if ($_POST['estado'] == "true")
	$arrjson['estado'] 			= 1;
else
	$arrjson['estado'] 			= 0;

if ($_POST['destacado'] == "true")
	$arrjson['destacado'] 			= 1;
else
	$arrjson['destacado'] 			= 0;

/***Procesar Imagenes****/
$arrjson['ruta'] = "../../../resources/assets/image/blog/";

if (isset($_POST['tip_multimedia'])) {
	$arrjson['tip_multimedia'] 		= $_POST['tip_multimedia'];
	if ($arrjson['tip_multimedia'] == 1){
		if (isset($_FILES['mul_fileImagen'])){
			$arrjson['mul_fileImagen'] = $objfunc->subirFoto('mul_fileImagen',$arrjson['ruta']);
			$objfunc->eliminarFoto($arrjson['act_mul_imagen'],$arrjson['ruta']);
		}
	}
	if ($arrjson['tip_multimedia'] == 2){
		$arrjson['mul_video'] = $_POST['mul_video'];
	}	
}

$arrjson['file_autor'] = "";
if (isset($_FILES['file_autor']))
	if (!empty($_FILES['file_autor'])){
		$arrjson['file_autor'] = $objfunc->subirFoto('file_autor',$arrjson['ruta']);
		$objfunc->eliminarFoto($arrjson['act_img_autor'],$arrjson['ruta']);	
	}
$objnot 	= new Blog();
$bool_sql = false;
if ($arrjson['codigo'] > 0){
	/***Actualizamos dado que ya existe la noticia***/
	$bool_sql  = $objnot->hacerActualizacion($arrjson);
	$objnot 	= new Blog();
	$arrjson['sql_seo'] = $objnot->actualizarUrlSeo($arrjson);
	//***Agregamos el tag
	$objnot 			 = new Blog();
	$arrjson['tagcod'] = $objnot->AgregarTag($arrjson);	
}else{
	/***Agregamos una noticia***/
	$bool_sql = $objnot->prodeceAregar($arrjson);
	$arrjson['codigo'] = $bool_sql;
	//***Agregamos el tag
	$objnot 			 = new Blog();
	$arrjson['tagcod'] = $objnot->AgregarTag($arrjson);
	$objnot 	= new Blog();
	$arrjson['sql_seo'] = $objnot->agregarUrlSeo($arrjson);
	if ($bool_sql > 0)
		$arrjson['codigo'] = $bool_sql;
}

if ($bool_sql){	
	$mensaje = "Se agrego el Tag correctamente";
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