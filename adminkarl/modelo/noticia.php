<?php
class Noticia extends Conexion{
	function dameListado($page=NULL,$filtro=NULL,$inicio=NULL,$TAMANO_PAGINA=NULL){
		$page = $this->limpiacadena($page);
		$filtro = $this->limpiacadena($filtro);

		$sql = "Select art_id, tca_cat_id, art_nombre, art_descripsuperior, art_descripinferior,art_frase, ";
		$sql.= "(Select tmp_cat.cat_nombre From tca_categoria as tmp_cat Where tmp_cat.cat_id = tca_cat_id Limit 0,1) as namecategoria, ";
		$sql.= "art_imgportada, art_tipomultimedia, art_imggrande, art_video, art_fechapublicacion, ";
		$sql.= "art_estado,art_destacado,art_fechacreacion,art_fechamodificacion,art_order ";
		$sql.= "From tar_articulo ";
		$sql.= "Where art_borrado = 1 ";
		$sql.= "and tca_cat_id != 8 ";
		//$sql.= "and tca_cat_id = 2 ";
		if (!empty($filtro)){
			$sql.= "and art_nombre like('%".$filtro."%') ";
		}
		$sql.= "Order by art_estado DESC, art_destacado DESC, art_order ASC, art_fechacreacion DESC ";
		if ($TAMANO_PAGINA > 0)
			$sql.= "LIMIT ".$inicio."," . $TAMANO_PAGINA;
		return $this->Sqlfetch_assoc($sql);	
	}
	function dameDetalle($codigo=NULL){
		$page = $this->limpiacadena($codigo);

		$sql = "Select art_id, tca_cat_id, art_nombre, art_descripsuperior, art_descripinferior,art_frase, ";
		$sql.= "(Select tmp_cat.cat_nombre From tca_categoria as tmp_cat Where tmp_cat.cat_id = tca_cat_id Limit 0,1) as namecategoria, ";
		$sql.= "art_imgportada, art_tipomultimedia, art_imggrande, art_video, art_fechapublicacion, ";
		$sql.= " (Select tmp_seo.seo_url From tseo_seo as tmp_seo Where tmp_seo.tar_art_id = art_id Limit 0,1) as nameurl_seo, ";
		$sql.= "art_estado,art_destacado,art_fechacreacion,art_fechamodificacion,art_order ";
		$sql.= "From tar_articulo ";
		$sql.= "Where art_id = ".$codigo;
		return $this->Sqlfetch_assoc($sql);	
	}
	function prodeceAregar($data=NULL){
		$loguedo        = $_SESSION['COD_USER'];
		$codigo 		= $this->limpiacadena($data['codigo']);
		$titulo 		= $this->limpiacadena($data['titulo']);
		$frase 			= $this->limpiacadena($data['frase']);
		$order          = $this->limpiacadena($data['order']);
		if (empty($order)) $order = 1;
		$f_publicacion 	= $this->limpiacadena($data['f_publicacion']);
		if (empty($f_publicacion)) $f_publicacion = date("Y-m-d");
		$descrip_superior = $this->limpiacadena($data['descrip_superior']);
		$descrip_inferior = $this->limpiacadena($data['descrip_inferior']);
		$estado 		= $this->limpiacadena($data['estado']);
		$tip_multimedia = $this->limpiacadena($data['tip_multimedia']);
		$cod_categoria = $this->limpiacadena($data['categoria']);
		$destacado 		= $this->limpiacadena($data['destacado']);
		if (empty($tip_multimedia)) $tip_multimedia = 0;
		$mul_video		= $this->limpiacadena($data['mul_video']);
		$mul_fileImagen	= $this->limpiacadena($data['mul_fileImagen']);
		$file_portada 	= $this->limpiacadena($data['file_portada']);
		
		$fecha = date("Y-m-d H:m:s");

		$sql = "Insert into tar_articulo ";
		$sql.= "(tus_usu_id, tca_cat_id,art_nombre,art_frase, art_order, art_descripsuperior,art_descripinferior, ";
		$sql.= "art_imgportada,art_imggrande,art_video,art_tipomultimedia,  ";
		$sql.= "art_fechapublicacion,art_estado,art_destacado,art_fechacreacion,art_fechamodificacion ) ";
		$sql.= "Values ";
		$sql.= "('$loguedo',$cod_categoria,'$titulo','$frase',$order, '$descrip_superior', '$descrip_inferior', ";
		$sql.= "'$file_portada','$mul_fileImagen','$mul_video','$tip_multimedia', ";
		$sql.= "'$f_publicacion','$estado','$destacado','$fecha','$fecha' ) ";
		//return $sql;
		return $this->insert_id($sql);
	}
	function hacerActualizacion($data=NULL){
		$loguedo        = $_SESSION['COD_USER'];
		$codigo 		= $this->limpiacadena($data['codigo']);
		$titulo 		= $this->limpiacadena($data['titulo']);
		$order          = $this->limpiacadena($data['order']);
		$frase 			= $this->limpiacadena($data['frase']);
		$f_publicacion 	= $this->limpiacadena($data['f_publicacion']);
		$descrip_superior = $this->limpiacadena($data['descrip_superior']);
		$descrip_inferior = $this->limpiacadena($data['descrip_inferior']);
		$estado 		= $this->limpiacadena($data['estado']);
		$destacado 		= $this->limpiacadena($data['destacado']);
		$tip_multimedia = $this->limpiacadena($data['tip_multimedia']);
		$cod_categoria = $this->limpiacadena($data['categoria']);
		$mul_video		= $this->limpiacadena($data['mul_video']);
		$mul_fileImagen	= $this->limpiacadena($data['mul_fileImagen']);
		$file_portada 	= $this->limpiacadena($data['file_portada']);

		$fecha = date("Y-m-d H:m:s");

		$sql = "UPDATE tar_articulo ";
		$sql.= "SET tus_usu_id = ".$loguedo.", ";
		$sql.= "tca_cat_id = ".$cod_categoria.", ";
		$sql.= "art_nombre = '".$titulo."', ";
		$sql.= "art_order = ".$order.", ";
		$sql.= "art_descripsuperior = '".$descrip_superior."', ";
		$sql.= "art_descripinferior = '".$descrip_inferior."', ";
		if (!empty($file_portada))
			$sql.= "art_imgportada = '".$file_portada."', ";
		
		if (($tip_multimedia == 1) and (!empty($mul_fileImagen)))
			$sql.= "art_imggrande = '".$mul_fileImagen."', ";
		if (($tip_multimedia == 2) and (!empty($mul_video)))
			$sql.= "art_video = '".$mul_video."', ";
		
		$sql.= "art_frase = '".$frase."', ";
		$sql.= "art_tipomultimedia = '".$tip_multimedia."', ";
		$sql.= "art_fechapublicacion = '".$f_publicacion."', ";
		$sql.= "art_estado = '".$estado."', ";
		$sql.= "art_destacado = '".$destacado."', ";
		$sql.= "art_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE art_id = ".$codigo ;
		return $this->update_sql($sql);
	}
	function actualizarUrlSeo($arrjson = NULL){
		$url_seo = $this->limpiacadena($arrjson['url_seo']);
		$id  	 = $this->limpiacadena($arrjson['codigo']);
		$sql = "UPDATE tseo_seo ";
		$sql.= "SET seo_url = '".$url_seo."' ";
		$sql.= "WHERE tar_art_id = '".$id."'";
		return $this->update_sql($sql);
	}
	function actualizarDatosListado($arrjson = NULL){
		$id  	  = $this->limpiacadena($arrjson['codigo']);
		$valor    = $this->limpiacadena($arrjson['valor']);
		$variable = $this->limpiacadena($arrjson['variable']);
		$fecha = date("Y-m-d H:m:s");
		$sql = "UPDATE tar_articulo ";
		$sql.= "SET art_".$variable." = '".$valor."', ";
		$sql.= "art_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE art_id = '".$id."'";
		return $this->update_sql($sql);
	}
	function agregarUrlSeo($arrjson=NULL){
		$borrado = 1;
		$id = $this->limpiacadena($arrjson['codigo']);
		$url_seo = $this->limpiacadena($arrjson['url_seo']);

		$sql = "Insert into tseo_seo ";
		$sql.= "(tar_art_id, seo_url)";
		$sql.= "Values ";
		$sql.= "($id,'$url_seo') ";
		return $this->insert_id($sql);
	}
	function AgregarTag($arrjson=NULL){
		$borrado = 1;
		$id = $this->limpiacadena($arrjson['codigo']);
		$tag = $this->limpiacadena($arrjson['tag']);

		$sql = "Insert into tta_tag ";
		$sql.= "(tar_art_id, tag_nombre,tag_borrado )";
		$sql.= "Values ";
		$sql.= "($id,'$tag',$borrado ) ";
		return $this->insert_id($sql);
	}
	function ListTag($arrjson=NULL){
		$id = $this->limpiacadena($arrjson['codigo']);

		$sql = "Select * ";
		$sql.= "From tta_tag ";
		$sql.= "Where tar_art_id = ".$id. " ";
		$sql.= "and tag_borrado = 1 ";
		$sql.= "Order by tag_id Desc";
		return $this->Sqlfetch_assoc($sql);	
	}
	function eliminar($arrjson){
		$id = $this->limpiacadena($arrjson['codigo']);
		$fecha = date("Y-m-d H:m:s");
		$sql = "UPDATE tar_articulo ";
		$sql.= "SET art_borrado = 0, ";
		$sql.= "art_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE art_id = ".$id ;

		return $this->update_sql($sql);	
	}
	function eliminarTag($arrjson){
		$id = $this->limpiacadena($arrjson['codigo']);
		$sql = "UPDATE tta_tag ";
		$sql.= "SET tag_borrado = 0 ";
		$sql.= "WHERE tag_id = ".$id ;

		return $this->update_sql($sql);	
	}
}
?>