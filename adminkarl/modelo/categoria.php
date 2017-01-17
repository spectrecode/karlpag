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
}
?>