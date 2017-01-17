<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');

$arrjson = false;
$data = json_decode(file_get_contents('php://input'), true);
$page 		= $data['page'];
$filtro 	= $data['filtro'];

$objnot 	= new Usuario();
$datanot 	= $objnot->dameListado($page,$filtro,0,0);
$num_total_registros = count($datanot);
$arrjson['paginado']['num_total_registros'] = $num_total_registros;
//Limito la busqueda
$TAMANO_PAGINA = 10;
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


// Imprimimos
$objnot 	= new Usuario();
$datanot 	= $objnot->dameListado($page,$filtro,$inicio,$TAMANO_PAGINA);
$arrjson['cc'] = $datanot; 
$item 		= count($datanot) - 1;
$contItem   = $inicio; 
$objfunc 	= new misFunciones();
for($i=0; $i<=$item; $i++){
	$contItem++;
	$data 	= $datanot[$i];
	$arrjson['usuario'][$i]['items'] 	= $contItem;
	$arrjson['usuario'][$i]['id'] 		= $data['usu_id'];
	$arrjson['usuario'][$i]['user'] 	= $data['usu_usuario'];
	$arrjson['usuario'][$i]['nombre'] 	= $data['per_nombre'];
	//$arrjson['usuario'][$i]['nombre'] 	= $objfunc->desencriptar2($data['per_nombre'],'formUser01');
	$app_paterno 						= $data['per_apellidopaterno'];
	$arrjson['usuario'][$i]['app_paterno'] 	= $objfunc->desencriptar2($app_paterno,'formUser01');
	$app_materno 						= $data['per_apellidomaterno'];
	$arrjson['usuario'][$i]['app_materno'] 	= $objfunc->desencriptar2($app_materno,'formUser01');
	$arrjson['usuario'][$i]['acceso'] 	= $data['usu_acceso'];
	if ($data['usu_acceso']==0){
		$arrjson['usuario'][$i]['classestado'] 			= "icon-cross";
		$arrjson['usuario'][$i]['estado'] = 1;
	}
	else{
		$arrjson['usuario'][$i]['classestado'] 			= "icon-checkmark";
		$arrjson['usuario'][$i]['estado'] = 0;
	}
	$arrjson['usuario'][$i]['tipousuario'] 	= $data['usu_tipousuario'];

	if ($data['usu_tipousuario'] == 1)
		$arrjson['usuario'][$i]['name_tipouser'] 	= "Editor";
	if ($data['usu_tipousuario'] == 2)
		$arrjson['usuario'][$i]['name_tipouser'] 	= "Administrador";

	$arrjson['usuario'][$i]['f_creacion'] 		= $data['usu_fechacreacion'];
}
echo json_encode($arrjson);
?>