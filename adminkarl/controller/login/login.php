<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);
$user 		= $data['username'];
$pass 		= $data['password'];
$token 		= $data['token'];
$nameform 	= $data['nameform'];
$captcha 	= $data['captcha'];
$verCaptcha = $_SESSION['captcha']['code'];
//$arrjson['message'] = $verCaptcha;
$_time 		= 300;

//Validación en el servidor
if ($verCaptcha == $captcha){
	$objfuncion = new misFunciones();
	if ($objfuncion->verifcarFormToken($nameform,$token,$_time)){
		if ($objfuncion->verficardatosAcceso($user) && $objfuncion->verficardatosAcceso($pass) ) {
			// Creamos el objeto usuario
			$objuser = new Usuario();
			$pass = $objfuncion->encriptar2($pass,'key@user_*');
			$datauser = $objuser->BuscarUsuario($user, $pass);
			$arrjson['ff'] = $datauser; 
			if (count($datauser) == 1){
				
				$arrjson['message'] 	= "Datos correctos";
				$arrjson['success'] 	= true;
				$arrjson['nombreUser']  = $datauser[0]['per_nombre']." ".$objfuncion->desencriptar2($datauser[0]['per_apellidopaterno'],'formUser01');
				$arrjson['photoUser']  = $datauser[0]['per_photo'];
				if ($datauser[0]['usu_tipousuario'] == 1)
					$arrjson['perfil'] = "Editor";
				if ($datauser[0]['usu_tipousuario'] == 2)
					$arrjson['perfil'] = "Administrador";	
				/******Cerramos las sessiones anteriores*****/
				$objuser = new Usuario();
				$objuser->CerrarSession($datauser[0]['usu_id']);
				//Generemos el token y lo guardamos en nuestra base de datos
				$cadenaLogin = $datauser[0]['usu_id']."-".$user.time();
				$tokenSession = $objfuncion->encriptar($cadenaLogin,"ses_user2021");
				//Agregamos nueva session
				$objuser = new Usuario();
				$ses_verificacion = $objuser->nuevaSession($datauser[0]['usu_id'],$tokenSession);
				if (is_int($ses_verificacion)){
					/*******Insertamos la nueva session**********/
					$_SESSION['CHECK_USER'] = $ses_verificacion;
					$_SESSION['COD_USER'] 	= $datauser[0]['usu_id'];
					$_SESSION['COD_PERFIL'] = $datauser[0]['usu_tipousuario'];
				}
				else{
					$arrjson['message'] 	= "Está intentado ingresar de manera ilegal";
					$arrjson['success'] 	= false;
					$arrjson['nombreUser']  = -1;
					$arrjson['totemUser']   = -1;
				}
			}else{
				$arrjson['message'] 	= "Sus credenciales no son correctas";
				$arrjson['success'] 	= false;
				$arrjson['nombreUser']  = -1;
				$arrjson['totemUser']   = -1;
			}
		}else{
			$arrjson['message'] 	= "Sus credenciales no son correctas";
			$arrjson['success'] 	= false;
			$arrjson['nombreUser']  = -1;
			$arrjson['totemUser']   = -1;
		}
	}else{
		$arrjson['message'] 	= "Su tiempo limíte ha caducado";
		$arrjson['success'] 	= false;
		$arrjson['nombreUser']  = -1;
		$arrjson['totemUser']   = -1;
	}
}else{
	$arrjson['message'] 	= "El Captcha ingresado no es correcto";
	$arrjson['success'] 	= false;
	$arrjson['nombreUser']  = -1;
	$arrjson['totemUser']   = -1;
}
echo json_encode($arrjson);

?>