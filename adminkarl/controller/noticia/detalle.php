<?php
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');
include('../../modelo/noticia.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);

$arrjson[0]['titulo'] 	= "";
$arrjson[0]['order'] 	= "";
$arrjson[0]['url_seo'] = "";
$arrjson[0]['descrip_superior'] = "";
$arrjson[0]['descrip_inferior'] = "";
$arrjson[0]['frase'] 			 = "";
$arrjson[0]['file_portada'] 	 = ""; // limpiamos
$arrjson[0]['act_img_portada']  = "blanco.jpg";
$arrjson[0]['tip_multimedia'] 	 = "1";
$arrjson[0]['categoria'] 	 	 = "0";
$arrjson[0]['namecategoria'] 	 = "Categoría";
$arrjson[0]['name_tip_multimedia']  = "Imágen";
$arrjson[0]['act_mul_imagen'] 	 = "blanco.jpg";
$arrjson[0]['mul_video'] 		 = "";
$arrjson[0]['f_publicacion'] 	 = "";
$arrjson[0]['estado'] 	= false;
$arrjson[0]['destacado'] 	= false;
$arrjson[0]['f_creacion'] 		= "";
$arrjson[0]['f_modificacion'] 	= "";
if (isset($data['codigo'])) {
	if (($data['codigo'] > 0)) {
		$codigo 	= $data['codigo'];
		$objnot 	= new Noticia();
		$objfunc 	= new misFunciones();
		$datanot 	= $objnot->dameDetalle($codigo);
		$item 		= count($datanot) - 1;
		for($i=0; $i<=$item; $i++){
			$data 	= $datanot[$i];
			$arrjson[$i]['codigo'] 	= $data['art_id'];
			$arrjson[$i]['titulo'] 	= $objfunc->convertir_html($data['art_nombre']);
			$arrjson[$i]['order'] 	= $data['art_order'];
			$arrjson[$i]['url_seo'] = $data['nameurl_seo'];
			$arrjson[$i]['descrip_superior'] = $objfunc->convertir_html($data['art_descripsuperior']);
			$arrjson[$i]['descrip_inferior'] = $objfunc->convertir_html($data['art_descripinferior']);
			$arrjson[$i]['frase'] 			 = $objfunc->convertir_html($data['art_frase']);
			//$arrjson[$i]['img_portada'] 	 = $data['art_imgportada'];
			$arrjson[$i]['act_img_portada']  = $data['art_imgportada'];
			if (empty($data['art_imgportada']))
				$arrjson[$i]['act_img_portada']  = "blanco.jpg";
			$arrjson[$i]['tip_multimedia'] 	 = $data['art_tipomultimedia'];
			$arrjson[$i]['categoria'] 	 	 = $data['tca_cat_id'];
			$arrjson[$i]['namecategoria'] 	 = $data['namecategoria'];
			if ($data['art_tipomultimedia'] == 0)
				$arrjson[$i]['name_tip_multimedia']  = "Tipo de Multimedia";
			if ($data['art_tipomultimedia'] == 1)
				$arrjson[$i]['name_tip_multimedia']  = "Imágen";
			if ($data['art_tipomultimedia'] == 2)
				$arrjson[$i]['name_tip_multimedia']  = "Video (Youtube)";
			$arrjson[$i]['act_mul_imagen'] 	 = $data['art_imggrande'];
			if (empty($data['art_imggrande']))
				$arrjson[$i]['act_mul_imagen']  = "blanco.jpg";
			$arrjson[$i]['mul_video'] 		 = $data['art_video'];
			$arrjson[$i]['f_publicacion'] 	 = $data['art_fechapublicacion'];
			if ($data['art_estado']== 1) 
				$arrjson[$i]['estado'] 	= true;
			else
				$arrjson[$i]['estado'] 	= false;
			if ($data['art_destacado']== 1) 
				$arrjson[$i]['destacado'] 	= true;
			else
				$arrjson[$i]['destacado'] 	= false;
			$arrjson[$i]['f_creacion'] 		= $data['art_fechacreacion'];
			$arrjson[$i]['f_modificacion'] 	= $data['art_fechamodificacion'];
		}
	}else{
		$arrjson[0]['codigo'] 	= -1;
	}
}else{
	$arrjson[0]['codigo'] 	= -1;
}
echo json_encode($arrjson);
?>