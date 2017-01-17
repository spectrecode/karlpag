<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');//-->definimos la zona horaria
include('../../config/conexion.php');
include('../../modelo/funciones.php');
include('../../modelo/usuario.php');

$arrjson = "";
$data = json_decode(file_get_contents('php://input'), true);

$arrjson[0]['codigo'] 		= $data['codigo'];
$arrjson[0]['nombre'] 		= "";
$arrjson[0]['a_paterno'] 	= "";
$arrjson[0]['a_materno'] 	= "";
$arrjson[0]['email'] 		= "";
$arrjson[0]['movil'] 		= "";
$arrjson[0]['telefono'] 	= "";
$arrjson[0]['usuario'] 	= "";
$arrjson[0]['password'] 	= "";
$arrjson[0]['password2'] 	= "";
$arrjson[0]['file_portada'] =  "";
$arrjson[0]['act_img_portada']	= "blanco.jpg";
$arrjson[0]['tipouser'] 		= "";
$arrjson[0]['nametipouser']     = "Tipo de Usuario";

if (isset($data['codigo'])) {
	if (($data['codigo'] > 0)) {
		$codigo 	= $data['codigo'];
		$objuser 	= new Usuario();
		$objfunc 	= new misFunciones();
		$datanot 	= $objuser->dameDetalle($codigo);
		//$arrjson['dd'] = $datanot;
		$item 		= count($datanot) - 1;
		for($i=0; $i<=$item; $i++){
			$data 	= $datanot[$i];
			$arrjson[$i]['codigo'] 	= $data['usu_id'];
			$nombre = $objfunc->convertir_html($data['per_nombre']);
			$arrjson[$i]['nombre'] 		= $nombre;
			//$arrjson[$i]['nombre'] 		= $objfunc->desencriptar2($nombre,'formUser01');
			$a_paterno 	= $objfunc->convertir_html($data['per_apellidopaterno']);
			$arrjson[$i]['a_paterno'] 		= $objfunc->desencriptar2($a_paterno,'formUser01');
			$a_materno 	= $objfunc->convertir_html($data['per_apellidomaterno']);
			$arrjson[$i]['a_materno'] 		= $objfunc->desencriptar2($a_materno,'formUser01');
			$arrjson[$i]['sexo'] = $data['per_sexo'];
			$arrjson[$i]['telefono'] = $data['per_telefono'];
			$email  = $data['per_correo'];
			$arrjson[$i]['email'] 		= $objfunc->desencriptar2($email,'formUser01');
			$arrjson[$i]['act_img_portada']  = $data['per_photo'];
			$movil  = $data['per_movil'];
			$arrjson[$i]['movil'] 		= $objfunc->desencriptar2($movil,'formUser01');
			$arrjson[$i]['usuario']  = $data['usu_usuario'];
			$arrjson[$i]['password']  = "";
			$arrjson[$i]['tipouser']  = $data['usu_tipousuario'];
			if ($data['usu_tipousuario'] == 1){
				$arrjson[$i]['nametipouser'] = "Editor";
				$arrjson[$i]['rutaBrench'] = "javascript:void(0)";
			}
			if ($data['usu_tipousuario'] == 2){
				$arrjson[$i]['nametipouser'] = "Administrador"; 
				$arrjson[$i]['rutaBrench'] = "#/usuario"; 
			}
			$arrjson[$i]['acceso'] = $data['usu_acceso'];
			$arrjson[$i]['f_creacion']  = $data['usu_fechacreacion'];
			$arrjson[$i]['f_modificacion']  = $data['usu_fechamodificacion'];
		}
	}else{
		$arrjson[0]['codigo'] 	= -1;
	}
}else{
	$arrjson[0]['codigo'] 	= -1;
}
echo json_encode($arrjson);
?>