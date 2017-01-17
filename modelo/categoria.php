<?php
class Categoria extends Conexion{
	function dameCategoria($id=NULL){
		$sql = "Select cat_id, cat_nombre, tca_fk_cat_id ";
		$sql.= "From tca_categoria ";
		$sql.= "Where cat_borrado = 1 ";
		$sql.= "and cat_id != 8 ";
		if ($id == 0)
			$sql.= "and tca_fk_cat_id is null ";
		else
			$sql.= "and tca_fk_cat_id = ".$id." ";
		$sql.= "Order by cat_nombre ASC ";
		return $this->Sqlfetch_assoc($sql);	
	}
	function dameListado($page=NULL,$filtro=NULL,$inicio=NULL,$TAMANO_PAGINA=NULL,$codcategoria=NULL){
		$page = $this->limpiacadena($page);
		$filtro = $this->limpiacadena($filtro);

		$sql = "Select art_id, tca_cat_id, art_nombre, art_descripsuperior, art_descripinferior,art_frase, ";
		$sql.= "(Select tmp_cat.cat_nombre From tca_categoria as tmp_cat Where tmp_cat.cat_id = tca_cat_id Limit 0,1) as namecategoria, ";
		$sql.= " (Select tmp_seo.seo_url From tseo_seo as tmp_seo Where tmp_seo.tar_art_id = art_id Limit 0,1) as nameurl_seo, ";
		$sql.= "art_imgportada, art_tipomultimedia, art_imggrande, art_video, art_fechapublicacion, ";
		$sql.= "art_estado,art_fechacreacion,art_fechamodificacion,art_order ";
		$sql.= "From tar_articulo ";
		$sql.= "Where art_borrado = 1 ";
		$sql.= "and tca_cat_id = $codcategoria ";
		$sql.= "Order by art_fechacreacion DESC ";
		if ($TAMANO_PAGINA > 0)
			$sql.= "LIMIT ".$inicio."," . $TAMANO_PAGINA;
		return $this->Sqlfetch_assoc($sql);	
	}
}
?>