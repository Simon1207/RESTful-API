<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app=new \Slim\App;

//***Obtener todos los clientes
// Para consultarlo ejemplo: http://localhost/APIREST-SlimPHP/public/index.php/api/clientes
	//Realiza una petición get
	$app->get('/api/clientes',function(Request $request,Response $response){
		$consulta='SELECT * FROM clientes';
		try{
			//Instancia de base de datos
			$db=new db();

			//conexion
			//manda llamar a la función conectar de db.php
			$db=$db->conectar();
			$ejecutar=$db->query($consulta);
			$clientes=$ejecutar->fetchAll(PDO::FETCH_OBJ);
			$db=null;

			//Exportar y mostrar en JSON
			echo json_encode($clientes);


		}catch (PDOException $e){
			echo '{"Error":{"Text: '.$e->getMessage().'}';
		}
	});



//***Obtener un solo cliente
// Para consultarlo ejemplo : http://localhost/APIREST-SlimPHP/public/index.php/api/clientes/1
	$app->get('/api/clientes/{id}',function(Request $request,Response $response){
		$id=$request->getAttribute('id');

		$consulta="SELECT * FROM clientes WHERE id='$id'";
		try{
			//Instancia de base de datos
			$db=new db();

			//conexion
			//manda llamar a la función conectar de db.php
			$db=$db->conectar();
			$ejecutar=$db->query($consulta);
			$cliente=$ejecutar->fetchAll(PDO::FETCH_OBJ);
			$db=null;

			//Exportar y mostrar en JSON
			echo json_encode($cliente);


		}catch (PDOException $e){
			echo '{"Error":{"Text: '.$e->getMessage().'}';
		}
	});

//***Agregar un cliente
//Para hacer el POST // http://localhost/APIREST-SlimPHP/public/index.php/api/clientes/agregar


	$app->post('/api/clientes/agregar',function(Request $request,Response $response){
		$nombre=$request->getParam('nombre');
		$apellidos=$request->getParam('apellidos');
		$telefono=$request->getParam('telefono');
		$email=$request->getParam('email');
		$direccion=$request->getParam('direccion');
		$ciudad=$request->getParam('ciudad');
		$departamento=$request->getParam('departamento');


		$consulta="INSERT INTO clientes(nombre,apellidos,telefono,email,direccion,ciudad,departamento) VALUES (:nombre,:apellidos, :telefono,:email,:direccion,:ciudad,:departamento)";
		try{
			//Instancia de base de datos
			$db=new db();

			//conexion
			//manda llamar a la función conectar de db.php
			$db=$db->conectar();
			$stmt=$db->prepare($consulta);
			//Se asocia la variable con la variable temporal de la consulta
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':apellidos', $apellidos);
			$stmt->bindParam(':telefono', $telefono);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':direccion', $direccion);
			$stmt->bindParam(':ciudad', $ciudad);
			$stmt->bindParam(':departamento', $departamento);
			$stmt->execute();
			echo '{"notice":{"text: "cliente agregado"}';


		}catch (PDOException $e){
			echo '{"Error":{"Text: '.$e->getMessage().'}';
		}
	});	

/* Ejemplo de JSON que se enviara por POST 

{
	"nombre":"Tu_nombre",
	"apellidos":"Tu_Apellido",
	"telefono":"numero_telefono",
	"email":"prueba@gmail.com",
	"direccion":"tu_direccion",
	"ciudad":"la_ciudad",
	"departamento":"5"
}

*/

//ACTUALIZAR Cliente
//Para hacer el PUT // http://localhost/APIREST-SlimPHP/public/index.php/api/clientes/actualizar/TU ID
$app->put('/api/clientes/actualizar/{id}',function(Request $request,Response $response){
		$id=$request->getAttribute('id');

		$nombre=$request->getParam('nombre');
		$apellidos=$request->getParam('apellidos');
		$telefono=$request->getParam('telefono');
		$email=$request->getParam('email');
		$direccion=$request->getParam('direccion');
		$ciudad=$request->getParam('ciudad');
		$departamento=$request->getParam('departamento');


		$consulta="UPDATE clientes SET 
					nombre 		 = :nombre,
					apellidos 	 = :apellidos,
					telefono 	 = :telefono,
					email 		 = :email,
					direccion 	 = :direccion,
					ciudad 		 = :ciudad,
					departamento = :departamento

					WHERE id = $id";
		try{
			//Instancia de base de datos
			$db=new db();

			//conexion
			//manda llamar a la función conectar de db.php
			$db=$db->conectar();
			$stmt=$db->prepare($consulta);
			//Se asocia la variable con la variable temporal de la consulta
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':apellidos', $apellidos);
			$stmt->bindParam(':telefono', $telefono);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':direccion', $direccion);
			$stmt->bindParam(':ciudad', $ciudad);
			$stmt->bindParam(':departamento', $departamento);
			$stmt->execute();
			echo '{"notice":{"text: "cliente actualizado"}';


		}catch (PDOException $e){
			echo '{"Error":{"Text: '.$e->getMessage().'}';
		}
	});	


//ELIMINAR usuario 
//EJEMPLO : http://127.0.0.1/APIREST-SlimPHP/public/index.php/api/clientes/eliminar/6
$app->delete('/api/clientes/eliminar/{id}',function(Request $request,Response $response){
		$id=$request->getAttribute('id');

		$consulta="DELETE FROM clientes WHERE id=$id";
		try{
			//Instancia de base de datos
			$db=new db();

			//conexion
			//manda llamar a la función conectar de db.php
			$db=$db->conectar();
			$stmt=$db->prepare($consulta);
			$result=$stmt;
			$result->execute();
			$db=null;

			echo '{"notice": {"text": "Cliente ELIMINADO"}';


		}catch (PDOException $e){
			echo '{"Error":{"Text: '.$e->getMessage().'}';
		}
	});