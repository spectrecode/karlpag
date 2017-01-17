<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/reconocimiento.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);

$arrjson[0]['rec_titulo'] 		= "";
$arrjson[0]['rec_descripcion'] 	= "";
$arrjson[0]['rec_video'] 	= "";
$arrjson[0]['pre_campo1'] 	= "";
$arrjson[0]['pre_campo2'] 	= "";
$arrjson[0]['pre_campo3'] 	= "";
$arrjson[0]['pre_campo4'] 	= "";
$arrjson[0]['pre_campo5'] 	= "";
$arrjson[0]['pre_campo6'] 	= "";
$arrjson[0]['pre_campo7'] 	= "";
$arrjson[0]['pre_campo8'] 	= "";
$arrjson[0]['pre_campo9'] 	= "";
$arrjson[0]['pre_campo10'] 	= "";
$arrjson[0]['pre_campo11'] 	= "";
$arrjson[0]['pre_campo12'] 	= "";
$arrjson[0]['pre_campo13'] 	= "";
$arrjson[0]['pre_campo14'] 	= "";
$arrjson[0]['pre_campo15'] 	= "";

$arrjson[0]['rec_precio_monto']  		= "";
$arrjson[0]['rec_precio_exclusivo']  	= "";
$arrjson[0]['rec_empdist_descripcion']  = "";


$arrjson[0]['act_img_logo']      		= "";
$arrjson[0]['act_fichainscripcion']    	= "";
$arrjson[0]['act_brochure']      		= "";
$arrjson[0]['act_catalogo']      		= "";
$arrjson[0]['act_img_ejeimagen']      	= "";
$arrjson[0]['act_img_cronograma']      	= "";

$arrjson[0]['rec_logo']					= "";
$arrjson[0]['rec_fichainscripcion']		= "";
$arrjson[0]['rec_brochure']				= "";	
$arrjson[0]['rec_catalogo']				= "";
$arrjson[0]['rec_ejeimagen']			= "";
$arrjson[0]['rec_cronograma_img']		= "";
$arrjson[0]['descrip_asistir'] 			= "";

if (isset($data['codigo'])) {
	if (($data['codigo'] > 0)) {
		$codigo 	= $data['codigo'];
		$objnot 	= new Reconocimiento();
		$objfunc 	= new misFunciones();
		$datanot 	= $objnot->dameDetalle($codigo);
		$item 		= count($datanot) - 1;
		for($i=0; $i<=$item; $i++){
			$data 	= $datanot[$i];
			$arrjson[$i]['codigo'] 			= $data['rec_id'];
			$arrjson[$i]['rec_titulo'] 		= $objfunc->convertir_html($data['rec_titulo']);
			$arrjson[$i]['rec_logo'] 		= $data['rec_logo'];
			$arrjson[$i]['rec_descripcion'] = $objfunc->convertir_html($data['rec_descripcion']);
			$arrjson[$i]['rec_video'] 		= $data['rec_video'];
			$arrjson[$i]['rec_brochure'] 	= $data['rec_brochure'];
			$arrjson[$i]['rec_fichainscripcion'] 	= $data['rec_fichainscripcion'];
			$arrjson[$i]['rec_catalogo'] 			= $data['rec_catalogo'];
			$arrjson[$i]['rec_imgcronograma'] 		= $data['rec_imgcronograma'];
			$arrjson[$i]['rec_ejeimagen'] 			= $data['rec_ejeimagen'];

			$arrjson[0]['act_img_logo']      		= $data['rec_logo'];
			$arrjson[0]['act_fichainscripcion']    	= $data['rec_fichainscripcion'];
			$arrjson[0]['act_brochure']      		= $data['rec_brochure'];
			$arrjson[0]['act_catalogo']      		= $data['rec_catalogo'];
			$arrjson[0]['act_img_ejeimagen']      	= $data['rec_ejeimagen'];
			$arrjson[0]['act_img_cronograma']      	= $data['rec_imgcronograma'];

			$arrjson[$i]['rec_precio_exclusivo'] 	= $objfunc->convertir_html($data['rec_precio_exclusivo']);
			$arrjson[$i]['rec_precio_monto'] 		= $objfunc->convertir_html($data['rec_precio_monto']);
			$arrjson[$i]['rec_empdist_descripcion'] = $objfunc->convertir_html($data['rec_empdist_descripcion']);
		}
	}else{
		$arrjson[0]['codigo'] 	= -1;
	}
}else{
	$arrjson[0]['codigo'] 	= -1;
}
echo json_encode($arrjson);
?>