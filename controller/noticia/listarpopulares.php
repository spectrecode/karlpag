<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/noticia.php');
include('../../modelo/globales.php');


$arrjson = false;
$data = json_decode(file_get_contents('php://input'), true);
$page 		= $data['page'];
$filtro 	= $data['filtro'];

$objnot 	= new Noticia();
$datanot 	= $objnot->dameListado2($page,$filtro,0,0);
$num_total_registros = count($datanot);
$arrjson['paginado']['num_total_registros'] = $num_total_registros;
//Limito la busqueda
$TAMANO_PAGINA = 4;
$cantidadCte = 4;
$arrjson['paginado']['TAMANO_PAGINA'] = $TAMANO_PAGINA;

$pagina = $page;

if (!$pagina) {
   $inicio = 0;
   $pagina = 1;
}
else {
   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}
 
 
$arrjson['paginado']['pagina'] = $pagina;
$arrjson['paginado']['inicio'] = $inicio;


//calculo el total de páginas
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

$arrjson['paginado']['total_paginas'] = $total_paginas;
// setearon que todo empieze desde  0
$inicio = 0;
$TAMANO_PAGINA = $pagina * $cantidadCte;
$arrjson['paginado']['TAMANO_PAGINA'] = $TAMANO_PAGINA;
//**************************************************************
// Imprimimos
$objnot 	= new Noticia();
$datanot 	= $objnot->dameListado2($page,$filtro,$inicio,$TAMANO_PAGINA);

$item 		= count($datanot) - 1;
$contItem   = $inicio; 
$objfunc 	= new misFunciones();
for($i=0; $i<=$item; $i++){
	$contItem++;
	$data 	= $datanot[$i];
	$arrjson['listado'][$i]['items'] 		= $contItem;
	$arrjson['listado'][$i]['id'] 		= $data['art_id'];
	$arrjson['listado'][$i]['titulo'] 	= $data['art_nombre'];
	$arrjson['listado'][$i]['nameurl_seo'] 	= $data['nameurl_seo'];
	$data['art_descripsuperior'] = $objfunc->convertir_html($data['art_descripsuperior']);
	$arrjson['listado'][$i]['descripsuperior'] = $data['art_descripsuperior'];
	$arrjson['listado'][$i]['descripinferior'] = $data['art_descripinferior'];
	$arrjson['listado'][$i]['frase'] 			= $data['art_frase'];
	$arrjson['listado'][$i]['imgportada'] 		= $data['art_imgportada'];
	$arrjson['listado'][$i]['tipomultimedia'] 	= $data['art_tipomultimedia'];
	$arrjson['listado'][$i]['categoria'] 		= $data['tca_cat_id'];
	if ($data['tca_cat_id'] == 1)
		$arrjson['listado'][$i]['urlcategoria'] 		= "innovacion.html";
	if ($data['tca_cat_id'] == 2)
		$arrjson['listado'][$i]['urlcategoria'] 		= "industria-del-gas.html";
	if ($data['tca_cat_id'] == 3)
		$arrjson['listado'][$i]['urlcategoria'] 		= "actualidad.html";
	if ($data['tca_cat_id'] == 5)
		$arrjson['listado'][$i]['urlcategoria'] 		= "seguridad.html";

	$arrjson['listado'][$i]['namecategoria'] 	= $data['namecategoria'];
	$arrjson['listado'][$i]['imggrande'] 		= $data['art_imggrande'];
	$arrjson['listado'][$i]['video'] 			= $data['art_video'];
	$arrjson['listado'][$i]['f_publicacion'] 	= $data['art_fechapublicacion'];
	$arrjson['listado'][$i]['estado'] 	= $data['art_estado'];
	if ($contItem%2==0){
		$arrjson['listado'][$i]['class'] = "par";
		$arrjson['listado'][$i]['backgroundimage'] = "";
	}else{
		$arrjson['listado'][$i]['class'] = "";
		$arrjson['listado'][$i]['backgroundimage'] = "background-image:url("._URL_."adminkarl/resources/assets/image/noticias/".$data['art_imgportada'];
	}
	if ($data['art_estado']==0){
		$arrjson['listado'][$i]['classestado'] 			= "icon-cross";
		$arrjson['listado'][$i]['estado'] = 1;
	}
	else{
		$arrjson['listado'][$i]['classestado'] 			= "icon-checkmark";
		$arrjson['listado'][$i]['estado'] = 0;
	}
	$arrjson['listado'][$i]['f_creacion'] 		= $data['art_fechacreacion'];
	$arrjson['listado'][$i]['f_modificacion'] 	= $data['art_fechamodificacion'];
}
echo json_encode($arrjson);
?>