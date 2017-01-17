<?php
class Usuario extends Conexion{
	function CerrarSession($id){
		$fecha = date("Y-m-d H:m:s");
		$sql = "UPDATE tsu_sessusuario ";
		$sql.= "SET ses_activo = 0, ";
		$sql.= "ses_finsession = '".$fecha."' ";
		$sql.= "WHERE usu_id_usuario = ".$id ;

		return $this->update_sql($sql);	
	}
	function verificarUser($data){
		$user = $data['usuario'];
		$sql = "Select usu_usuario ";
		$sql.= "From tus_usuario ";
		$sql.= "WHERE usu_usuario = '$user' " ;

		$dato = $this->Sqlfetch_assoc($sql);
		$item = count($dato) - 1;
		if ($item >= 0)
			return false; // no inserta
		else
			return true; // inserta
	}
	function eliminar($arrjson){
		$id = $this->limpiacadena($arrjson['codigo']);
		$fecha = date("Y-m-d H:m:s");
		$sql = "UPDATE tus_usuario ";
		$sql.= "SET usu_borrado = 0, ";
		$sql.= "usu_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE usu_id = ".$id ;

		return $this->update_sql($sql);	
	}
	function actualizarDatosListado($arrjson = NULL){
		$id  	  = $this->limpiacadena($arrjson['codigo']);
		$valor    = $this->limpiacadena($arrjson['valor']);
		$variable = $this->limpiacadena($arrjson['variable']);
		$fecha = date("Y-m-d H:m:s");
		$sql = "UPDATE tus_usuario ";
		$sql.= "SET usu_".$variable." = '".$valor."', ";
		$sql.= "usu_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE usu_id = '".$id."'";
		return $this->update_sql($sql);
	}
	function dameDetalle($codigo=NULL){
		$page = $this->limpiacadena($codigo);

		$sql = "Select tmp1.usu_id, tmp1.usu_usuario, tmp1.usu_contrasena, tmp1.usu_acceso, tmp1.usu_tipousuario, ";
		$sql.= "tmp2.per_nombre, tmp2.per_apellidopaterno, tmp2.per_apellidomaterno, tmp2.per_sexo, tmp2.per_telefono, ";
		$sql.= "tmp2.per_correo, tmp2.per_photo, tmp2.per_movil, ";
		$sql.= "tmp1.usu_fechacreacion, tmp1.usu_fechamodificacion ";

		$sql.= "From tus_usuario tmp1 inner join tpe_persona tmp2 ";
		$sql.= "on tmp1.per_id_persona = tmp2.per_id ";
		$sql.= "Where tmp1.usu_id = ".$codigo;
		//return $sql;
		return $this->Sqlfetch_assoc($sql);	
	}
	function dameListado($page=NULL,$filtro=NULL,$inicio=NULL,$TAMANO_PAGINA=NULL){
		$page = $this->limpiacadena($page);
		$filtro = $this->limpiacadena($filtro);

		$sql = "Select tmp1.usu_id, tmp1.usu_usuario,  ";
		$sql.= "tmp2.per_nombre, tmp2.per_apellidopaterno, tmp2.per_apellidomaterno, tmp1.usu_tipousuario, ";
		$sql.= "tmp1.usu_fechacreacion, tmp1.usu_acceso ";
		$sql.= "From tus_usuario tmp1 inner join tpe_persona tmp2 ";
		$sql.= "on tmp1.per_id_persona = tmp2.per_id ";
		$sql.= "Where tmp1.usu_borrado = 1 ";
		if (!empty($filtro)){
			$sql.= "and tmp2.per_nombre like('%".$filtro."%') ";
		}
		$sql.= "Order by tmp1.usu_tipousuario DESC, tmp2.per_nombre ASC, tmp1.usu_fechacreacion DESC ";
		if ($TAMANO_PAGINA > 0)
			$sql.= "LIMIT ".$inicio."," . $TAMANO_PAGINA;

		//return $sql;
		return $this->Sqlfetch_assoc($sql);	
	}
	function BuscarUsuario($user=NULL,$pass=NULL){
		$user = $this->limpiacadena($user);
		$pass = $this->limpiacadena($pass);

		$sql = "Select tmp1.usu_id, tmp1.usu_usuario, tmp1.usu_contrasena, ";
		$sql.= "tmp2.per_nombre, tmp2.per_apellidopaterno, tmp1.usu_tipousuario, tmp2.per_photo ";
		$sql.= "From tus_usuario tmp1 inner join tpe_persona tmp2 ";
		$sql.= "on tmp1.per_id_persona = tmp2.per_id ";
		$sql.= "Where tmp1.usu_usuario = '".$user."' ";
		$sql.= "and tmp1.usu_contrasena = '".$pass."' ";
		$sql.= "and (tmp1.usu_tipousuario = 1 ";
		$sql.= "or tmp1.usu_tipousuario = 2) ";
		$sql.= "and tmp1.usu_acceso = 1 ";
		$sql.= "and tmp1.usu_borrado = 1 ";

		//return $sql;
		return $this->Sqlfetch_assoc($sql);	
	}
	function nuevaSession($id=NULL,$token=NULL){
		$ses_activo = 1;
		$ses_remoteaddr = $_SERVER['REMOTE_ADDR'];
		$ses_useragent = $_SERVER['HTTP_USER_AGENT'];
		$ses_serveraddr = $_SERVER['SERVER_ADDR'];
		$ses_scriptname = $_SERVER['SCRIPT_NAME'];
		$ses_requesturi = $_SERVER['REQUEST_URI'];
		$ses_iniciosession = date("Y-m-d H:m:s");
		$ses_finsession = date("Y-m-d H:m:s");
		
		$sql = "Insert into tsu_sessusuario ";
		$sql.= "(usu_id_usuario, ses_llavesession,ses_activo, ses_remoteaddr, ses_useragent, ";
		$sql.= "ses_serveraddr,ses_scriptname,ses_requesturi, ses_iniciosession,ses_finsession) ";
		$sql.= "Values ";
		$sql.= "('$id','$token',$ses_activo, '$ses_remoteaddr', '$ses_useragent', ";
		$sql.= "'$ses_serveraddr','$ses_scriptname','$ses_requesturi','$ses_iniciosession','$ses_finsession') ";
		return $this->insert_id($sql);
	}
	function buscarIdPersona($id=NULL){
		$sql = "Select per_id_persona ";
		$sql.= "From tus_usuario ";
		$sql.= "Where usu_id = ".$id;
		$data = $this->Sqlfetch_assoc($sql); 
		return $data[0]['per_id_persona'];	
	}
	function hacerActualizacionPersona($data=NULL){
		$loguedo        = $_SESSION['COD_USER'];
		$codigo 		= $this->limpiacadena($data['idperson']);
		$nombre 	= $this->limpiacadena($data['nombre']);
		$a_paterno 	= $this->limpiacadena($data['a_paterno']);
		$a_materno  = $this->limpiacadena($data['a_materno']);
		$email     	= $this->limpiacadena($data['email']);
		$movil     	= $this->limpiacadena($data['movil']);
		$telefono   = $this->limpiacadena($data['telefono']);
		$file_portada 	= $this->limpiacadena($data['file_portada']);
		$sexo 		= $this->limpiacadena($data['sexo']);;

		$fecha = date("Y-m-d H:m:s");

		$sql = "UPDATE tpe_persona ";
		$sql.= "SET per_nombre = '".$nombre."', ";
		$sql.= "per_apellidopaterno = '".$a_paterno."', ";
		$sql.= "per_apellidomaterno = '".$a_materno."', ";
		$sql.= "per_sexo = '".$sexo."', ";
		$sql.= "per_telefono = '".$telefono."', ";
		$sql.= "per_correo = '".$email."', ";
		if (!empty($file_portada))
			$sql.= "per_photo = '".$file_portada."', ";
		$sql.= "per_movil = '".$movil."' ";
		$sql.= "WHERE per_id = ".$codigo ;
		//return $sql;
		return $this->update_sql($sql);
	}
	function hacerActualizacionUsuario($data=NULL){
		$loguedo        = $_SESSION['COD_USER'];
		$codigo 		= $this->limpiacadena($data['codigo']);
		//$usuario    = $this->limpiacadena($data['usuario']);
		$password   = $this->limpiacadena($data['password']);

		$tipouser   = $this->limpiacadena($data['tipouser']);
		$acceso     = $this->limpiacadena($data['acceso']);

		$fecha = date("Y-m-d H:m:s");

		$sql = "UPDATE tus_usuario ";
		//$sql.= "SET usu_usuario = '".$usuario."', ";
		$sql.= "SET usu_contrasena = '".$password."', ";
		$sql.= "usu_fk_id_usuario = ".$loguedo.", ";
		$sql.= "usu_tipousuario = ".$tipouser.", ";
		$sql.= "usu_acceso = '".$acceso."', ";
		$sql.= "usu_fechamodificacion = '".$fecha."' ";
		$sql.= "WHERE usu_id = ".$codigo;
		//return $sql;
		return $this->update_sql($sql);
	}
	function prodeceAregarPersona($data=NULL){
		$loguedo   	= $_SESSION['COD_USER'];
		$nombre 	= $this->limpiacadena($data['nombre']);
		$a_paterno 	= $this->limpiacadena($data['a_paterno']);
		$a_materno  = $this->limpiacadena($data['a_materno']);
		$email     	= $this->limpiacadena($data['email']);
		$movil     	= $this->limpiacadena($data['movil']);
		$telefono   = $this->limpiacadena($data['telefono']);
		$file_portada 	= $this->limpiacadena($data['file_portada']);
		$sexo 		= $this->limpiacadena($data['sexo']);

		$sql = "Insert into tpe_persona ";
		$sql.= "(per_nombre, per_apellidopaterno,per_apellidomaterno,per_sexo, per_telefono,per_movil, per_correo,per_photo) ";
		$sql.= "Values ";
		$sql.= "('$nombre','$a_paterno','$a_materno','$sexo','$telefono','$movil', '$email', '$file_portada')";
		//return $sql;
		return $this->insert_id($sql);
	}
	function prodeceAregarUser($data=NULL){
		$loguedo   	= $_SESSION['COD_USER'];
		$codigo 	= $this->limpiacadena($data['codigopersona']);
		$usuario    = $this->limpiacadena($data['usuario']);
		$password   = $this->limpiacadena($data['password']);

		$tipouser   = $this->limpiacadena($data['tipouser']);
		$acceso     = $this->limpiacadena($data['acceso']);

		$fecha = date("Y-m-d H:m:s");

		$sql = "Insert into tus_usuario ";
		$sql.= "(per_id_persona, usu_fk_id_usuario,usu_usuario,usu_contrasena, usu_tipousuario, usu_acceso, ";
		$sql.= "usu_fechacreacion, usu_fechamodificacion)";
		$sql.= "Values ";
		$sql.= "('$codigo','$loguedo','$usuario','$password','$tipouser', '$acceso', '$fecha' , '$fecha')";
		//return $sql;
		return $this->insert_id($sql);
	}
}
?>