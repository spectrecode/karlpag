<?php
session_start();
class Conexion{
	private $dbconn	    = null;
	private $stmt = ""; 
	private $dbhost 	= "internal-db.s77722.gridserver.com";
	private $database	= "db77722_blogkar2017";
	private $user 		= "db77722_sonrie";
    private $password 	= "50rie14n";

	function __construct($host=NULL, $db=NULL, $user=NULL, $pass=NULL){
		/****Pasamos los datos de conexion******/
		if(!empty($host) && !empty($db)){
			$this->dbhost 		= $host;
			$this->database 	= $db;
			$this->user 		= $user;
			$this->password 	= $pass;
		}
		$this->NewConexion();

	}
	function NewConexion(){
		// Conectarse a la base de datos
		$this->dbconn = new mysqli($this->dbhost,$this->user,$this->password,$this->database);
		$this->dbconn->set_charset("utf8");
		//mysqli_set_charset($this->dbconn,"utf8");
	}
	function cerrarconexion(){
		$this->stmt->close();
		$this->dbconn->close();
	}
	function limpiacadena($cadena = NULL){
		$cadena = trim($cadena);
		$cadena = stripcslashes($cadena);
		$cadena = htmlspecialchars($cadena);
		return mysqli_real_escape_string($this->dbconn,$cadena);
	}
	function cerrarconexionProceso(){
		$this->dbconn->close();
	}
	function SentenceParan($sql,$paran1){
		if ($this->stmt = $this->dbconn->prepare($sql)) {
		    /* ejecuto el  query */
		    $this->stmt->execute();
		    /* Por cada columna necesito un nombre de variable */
		    $this->stmt->bind_result("i",$paran1);
		    $this->cerrarconexion();
		}else
		{
			echo "No se procesar la información";
		}
	}
	function Sqlall($sql){
		$this->stmt = $this->dbconn->query($sql);
		$result = $this->stmt->fetch_all();
		$this->cerrarconexion();
		return $result;
	}
	function Sqlfetch_assoc($sql){
		$this->stmt = $this->dbconn->query($sql);
		$main_arr = null;
		while ($row = $this->stmt->fetch_assoc()) {
			foreach($row as $key => $value)
			{    
				$arr[$key] = $value; 
			}
			$main_arr[] = $arr;
		}
		$this->cerrarconexion();
		return $main_arr;
	}
	/*
	function insert_sql($sql){
		$this->dbconn->query($sql);
		$this->cerrarconexionProceso();
	}
	function update_sql($sql){
		$this->dbconn->query($sql);
		$this->cerrarconexionProceso();
	}
	*/
	function insert_id($sql){
		if (!($this->stmt = $this->dbconn->prepare($sql))){
			return false;
		}else{
			$this->stmt->execute();
			$newId = $this->stmt->insert_id;
			//printf ("New Record has id %d.\n", $mysqli->insert_id);
			$this->cerrarconexion();
			return $newId;
		}
	}
	function update_sql($sql){
		if (!($this->stmt = $this->dbconn->prepare($sql))){
			return false;
		}else{
			$this->stmt->execute();
			$this->cerrarconexion();
			return true;
		}
	}
	function deleted_sql($sql,$atributo, $valor){
		$this->stmt = $this->dbconn->prepare($sql);
		$stmt->bind_param('i', $valor);
		$this->stmt->execute();
		$this->cerrarconexion();
	}
}
?>