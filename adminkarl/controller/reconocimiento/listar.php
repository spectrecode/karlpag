<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/reconocimiento.php');


$arrjson = false;
$data = json_decode(file_get_contents('php://input'), true);
$page 		= $data['page'];
$filtro 	= $data['filtro'];

$objnot 	= new Reconocimiento();
$datanot 	= $objnot->dameListado($page,$filtro,0,0);
$num_total_registros = count($datanot);
$arrjson['paginado']['num_total_registros'] = $num_total_registros;
//Limito la busqueda
$TAMANO_PAGINA = 4;
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
$objnot 	= new Reconocimiento();
$datanot	= $objnot->dameListado($page,$filtro,$inicio,$TAMANO_PAGINA);
//$datanot	= $objnot->dameListado();

$item 		= count($datanot) - 1;
//$contItem   = $inicio; 
$contItem   = 0; 
$objfunc 	= new misFunciones();
for($i=0; $i<=$item; $i++){
	$contItem++;
	$data 	= $datanot[$i];
	$arrjson['listado'][$i]['items'] 		= $contItem;
	$arrjson['listado'][$i]['id'] 			= $data['rec_id'];
	$arrjson['listado'][$i]['rec_titulo'] 	= $data['rec_titulo'];
	$data['rec_descripcion'] 			= $objfunc->convertir_html($data['rec_descripcion']);
	$arrjson['listado'][$i]['rec_descripcion'] 		= substr($data['rec_descripcion'],0,100);
}
echo json_encode($arrjson);
?>