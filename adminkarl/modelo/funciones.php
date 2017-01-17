<?php
class misFunciones {
	function __construct() {}
	function __destruct() {}
	function elminarSession(){
		if (isset($_SESSION))
			unset($_SESSION);
	}
	function verificarDataPost($nombre=NULL,$_type=NULL){
		$valor = "";
		if (isset($_POST[$nombre])){
			if ((!empty($_POST[$nombre])) and ($_POST[$nombre]!="undefined")){
				return $_POST[$nombre];
			}else{
				if ($_type==1)
					$valor = 0;
				if ($_type==2)
					$valor = date("Y-m-d");
				return $valor;
			}
		}else{
			if ($_type==1)
				$valor = 0;
			if ($_type==2)
				$valor = date("Y-m-d");
			return $valor;
		}
	}
	function convertir_html($dato=null){
		return htmlspecialchars_decode($dato);
	}
	function generarCodigo($longitud=NULL,$cadena=NULL) { 
		$key = ''; $pattern = '1234567890abcdefghijklmnopqrstuvwxyz'; 
		$max = strlen($pattern)-1; for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)}; 
		return time()."-".$key."-".$cadena; 
	}
	function generarNombreImagen($cadena) {
		$cadena = (ereg_replace('[^ A-Za-z0-9 .]', '', $cadena));
		$cadena = $this->generarCodigo(6,$cadena);
		$cadena = str_replace(' ', '', $cadena);
		return str_replace(':', '-', $cadena);
	}
	function subirFoto($nameFile=NULL,$ruta=NULL){
		if ((!empty($_FILES[$nameFile]['tmp_name'])) && (!empty($_FILES[$nameFile]['name']))) {
			// Capturando la imagen
			$tmp_name_file = $_FILES[$nameFile]["tmp_name"];
			$name_file_img = $this->generarNombreImagen($_FILES[$nameFile]["name"]);
			// Moviendo la imagen a un directorio
			if (move_uploaded_file($tmp_name_file,$ruta.$name_file_img))
				return $name_file_img;
			else
				return false;
		}else{
			return false;
		}
	}
	function eliminarFoto($nameFile=NULL,$ruta=NULL){
		if ((!empty($nameFile)) && ($nameFile!="blanco.jpg")){
			// verificamos si la imagen existe
			if (file_exists($ruta.$nameFile)){			
				// procedemos a eliminar la imagen
				unlink($ruta.$nameFile);
				return true;
			}else
				return false;
		}else
			return false;
	}
	function encriptar($string, $key){
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}

	function desencriptar($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
	}
	function encriptar2($cadena, $key){
		$encrypted = "";
		if (!empty($cadena))
			$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
		return $encrypted;
	}

	function desencriptar2($cadena, $key) {
		$decrypted = "";
		if (!empty($cadena))
			$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		return $decrypted;
	}
	
	function borrarVariableSession($nameSession=NULL){
		unset($_SESSION[$nameSession]);
	}
	function borrarToken($form=NULL){
		unset($_SESSION['csrf'][$form.'_token']);
	}
	function generarFormToken($form =NULL){
		// generar token de forma aleatoria
		$token = md5(uniqid(microtime(), true));

		// generar fecha de generación del token
		$token_time = time();
		// escribir la información del token en sesión para poder
		// comprobar su validez cuando se reciba un token desde un formulario
		$_SESSION['csrf'][$form.'_token'] = array('token'=>$token, 'time'=>$token_time);
		
		return $token;
	}
	function verficardatosAcceso($dato =NULL){
		/*
			Está función se encarga de verficar tanto el usuario como pass.
			En el caso del usuario debe cumplir con un mínimo de 3 y máximo de 20 caracteres
		*/

		if (ereg("^[a-zA-Z0-9.\-_@]{3,20}$", $dato)) {
			return true;
		}else{
			return false;
		}
	}
	function verifcarFormToken($form, $token, $delta_time=0) {
		// comprueba si hay un token registrado en sesión para el formulario
		
		$_SESSION['csrf'][$form.'_token'];
		if(!isset($_SESSION['csrf'][$form.'_token'])) {
		   return false;
		}

		// compara el token recibido con el registrado en sesión
		if ($_SESSION['csrf'][$form.'_token']['token'] !== $token) {
		   return false;
		}

		// si se indica un tiempo máximo de validez del ticket se compara la
		// fecha actual con la de generación del ticket
		if($delta_time > 0){
		   $token_age = time() - $_SESSION['csrf'][$form.'_token']['time'];
		   if($token_age >= $delta_time){
		  return false;
		   }
		}
	 
	   return true;
	}
}
?>