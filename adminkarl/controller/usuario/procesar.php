<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');

$objfunc 	= new misFunciones();

$arrjson = "";

$arrjson['codigo'] 				= $objfunc->verificarDataPost('codigo');
$nombre 		 				= $objfunc->verificarDataPost('nombre');
$arrjson['nombre']              = $nombre;
//$arrjson['nombre']              = $objfunc->encriptar2($nombre,'formUser01');
$a_paterno 						= $objfunc->verificarDataPost('a_paterno');
$arrjson['a_paterno']           = $objfunc->encriptar2($a_paterno,'formUser01');
$a_materno			   			= $objfunc->verificarDataPost('a_materno');
$arrjson['a_materno']           = $objfunc->encriptar2($a_materno,'formUser01');
$email 							= $objfunc->verificarDataPost('email');
$arrjson['email']           	= $objfunc->encriptar2($email,'formUser01');
$movil 							= $objfunc->verificarDataPost('movil');
$arrjson['movil']           	= $objfunc->encriptar2($movil,'formUser01');
$arrjson['telefono'] 			= $objfunc->verificarDataPost('telefono');
$arrjson['usuario'] 			= $objfunc->verificarDataPost('usuario');
$password 						= $objfunc->verificarDataPost('password');
$arrjson['password']           	= $objfunc->encriptar2($password,'key@user_*');
$password2 						= $objfunc->verificarDataPost('password2');
$arrjson['password2']           = $objfunc->encriptar2($password2,'key@user_*');
$arrjson['act_img_portada'] 	= $objfunc->verificarDataPost('act_img_portada');
$arrjson['tipouser'] 			= $objfunc->verificarDataPost('tipouser');

if ($_POST['acceso'] == "true")
	$arrjson['acceso'] 			= 1;
else
	$arrjson['acceso'] 			= 0;

if ($_POST['sexo'] == "true")
	$arrjson['sexo'] 			= 1;
else
	$arrjson['sexo'] 			= 0;
/***Procesar Imagenes****/
$objfunc 	= new misFunciones();

$arrjson['ruta'] = "../../resources/assets/image/usuario/";

$arrjson['file_portada'] = "";
if (isset($_FILES['file_portada']))
	if (!empty($_FILES['file_portada'])){
		//if ($arrjson['tmp_file_portada'] != $_FILES['file_portada']['name']){
		$arrjson['file_portada'] = $objfunc->subirFoto('file_portada',$arrjson['ruta']);
		$objfunc->eliminarFoto($arrjson['act_img_portada'],$arrjson['ruta']);		
		//}
	}


$bool_sql = false;
$bool_sqluser = false;
$mensaje = "No se ha podido, vuelva a intentarlo más tarde";
if ($arrjson['codigo'] > 0){
	$objuser 	= new Usuario();
	$idperson   = $objuser->buscarIdPersona($arrjson['codigo']);
	$arrjson['idperson'] = $idperson;
	/***Actualizamos dado que ya existe la Usuario***/
	$objuser 	= new Usuario();
	$bool_sql 	= $objuser->hacerActualizacionPersona($arrjson);
	$arrjson['xx'] = $bool_sql;
	$objuser 	= new Usuario();
	$bool_sqluser = $objuser->hacerActualizacionUsuario($arrjson);
	$arrjson['xxx'] = $bool_sqluser;
	$mensaje = "Se ha actualizado correctamente";
}else{
	$objuser 	= new Usuario();
	$bool_sqluser = $objuser->verificarUser($arrjson);
	//$arrjson['xxx'] = $bool_sqluser;
	//$bool_sqluser = false;
	// si es verdadero quiere decir que el nombre de usuario no 
	// existe en nuestra base de datos y se puede utilizar
	if ($bool_sqluser){	
		/***Agregamos una Usuario***/
		$objuser 	= new Usuario();
		$bool_sql = $objuser->prodeceAregarPersona($arrjson);
		$arrjson['codigopersona'] = $bool_sql;
		$objuser 	= new Usuario();
		$bool_sqluser = $objuser->prodeceAregarUser($arrjson);
		$arrjson['xxx'] = $bool_sqluser;
		if ($bool_sqluser > 0)
			$arrjson['codigo'] = $bool_sqluser;
		$mensaje = "Se añadió correctamente";
	}else{
		$mensaje = "El usuario ya existe, elija otro usuario";
	}
}

if ($bool_sqluser){	
	$arrjson['message'] 	= $mensaje;
	$arrjson['success'] 	= true;
	$arrjson['class_mess']  = "exito";
}else{
	$arrjson['message'] 	= $mensaje;
	$arrjson['success'] 	= false;
	$arrjson['class_mess']  = "error";
}


echo json_encode($arrjson);
?>