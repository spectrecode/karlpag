<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/categoria.php');
include('../../modelo/globales.php');

$arrjson = false;
$data = json_decode(file_get_contents('php://input'), true);
$page 		= $data['page'];
$filtro 	= $data['filtro'];
$codcategoria 	= $data['codcategoria'];

$objnot 	= new Categoria();
$datanot 	= $objnot->dameListado($page,$filtro,0,0,$codcategoria);
$num_total_registros = count($datanot);
$arrjson['paginado']['num_total_registros'] = $num_total_registros;
//Limito la busqueda
$TAMANO_PAGINA = 8;
$cantidadCte = 8;
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
$inicio = 8;
$TAMANO_PAGINA = $pagina * $cantidadCte;
$arrjson['paginado']['TAMANO_PAGINA'] = $TAMANO_PAGINA;
//**************************************************************
//*************************Imprimimos***************************
$objnot 	= new Categoria();
$datanot 	= $objnot->dameListado($page,$filtro,$inicio,$TAMANO_PAGINA,$codcategoria);

$item 		= count($datanot) - 1;
$contItem   = $inicio; 
$objfunc 	= new misFunciones();
$classrow = "";
$itemrow = 1;
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
	$arrjson['listado'][$i]['namecategoria'] 	= $data['namecategoria'];
	$arrjson['listado'][$i]['imggrande'] 		= $data['art_imggrande'];
	$arrjson['listado'][$i]['video'] 			= $data['art_video'];
	$arrjson['listado'][$i]['f_publicacion'] 	= $data['art_fechapublicacion'];
    $arrjson['listado'][$i]['for_f_publica']    = $objfunc->postFecha($data['art_fechapublicacion']);
	$arrjson['listado'][$i]['estado'] 	= $data['art_estado'];
	if ($itemrow > 2){
        $classrow = $classrow;
        $itemrow = 1;
        if ($classrow!="blanco")
            $arrjson['listado'][$i]['backgroundimage'] = "background-image:url("._URL_."adminkarl/resources/assets/image/noticias/".$data['art_imgportada'];
    }else{
        if ($classrow == ""){
            $classrow = "blanco";
            $arrjson['listado'][$i]['backgroundimage'] = "";
        }else{
            $classrow = "";
            $arrjson['listado'][$i]['backgroundimage'] = "background-image:url("._URL_."adminkarl/resources/assets/image/noticias/".$data['art_imgportada'];
        }
    }
    $itemrow++;
	$arrjson['listado'][$i]['classrow'] 		= $classrow;
	if ($data['art_estado']==0){
		$arrjson['listado'][$i]['classestado'] 	= "icon-cross";
		$arrjson['listado'][$i]['estado'] = 1;
	}
	else{
		$arrjson['listado'][$i]['classestado'] 	= "icon-checkmark";
		$arrjson['listado'][$i]['estado'] = 0;
	}
	$arrjson['listado'][$i]['f_creacion'] 		= $data['art_fechacreacion'];
	$arrjson['listado'][$i]['f_modificacion'] 	= $data['art_fechamodificacion'];
}
echo json_encode($arrjson);
?>