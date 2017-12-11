<?php 
class db{
	private $host='localhost';
	private $usuario='root';
	private $password='';
	private $base='apirest-slimphp'; //NOMBRE DE LA BASE CREADA 

	//conectar a la BD
	public function conectar(){
		//la conexion al host sera la variable host
		$conexion_mysql="mysql:host=$this->host;dbname=$this->base";
		$conexionBD=new PDO($conexion_mysql,$this->usuario,$this->password);
		$conexionBD->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		//esta linea arregla la condificacion de caracteres UTF-8
		$conexionBD->exec("set names utf8");
		return $conexionBD;
	}
}



?>