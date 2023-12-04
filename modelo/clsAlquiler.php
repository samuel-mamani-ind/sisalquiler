<?php
require_once('conexion.php');

class clsAlquiler{

	function listarAlquiler($matricula, $fecha,$estado){
		$sql = "SELECT alq.*, alq.id as 'idalquiler', CONCAT_WS(' ',cli.nombre,cli.apepat,cli.apemat) as 'cliente' , usu.nombre as 'encargado', mot.n_placa as 'motocicleta' 
		FROM alquiler alq 
		INNER JOIN cliente cli 
		ON alq.id_cliente=cli.id
		INNER JOIN usuario usu 
		ON alq.id_encargado=usu.idusuario
		INNER JOIN motocicleta mot 
		ON alq.id_motocicleta=mot.id  
		WHERE alq.estado<2 AND usu.estado<2 AND mot.estado<2";
		$parametros = array();

		if($matricula!=""){
			$sql .= " AND mot.n_placa LIKE :matricula ";
			$parametros[':matricula'] = "%".$matricula."%";
		}

		if($fecha!=""){
			$sql .= " AND alq.fecha = :fecha ";
			$parametros[':fecha'] = $fecha; 
		}

		if($estado!=""){
			$sql .= " AND alq.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY alq.id ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarAlquiler($fecha,$hora,$tiempo,$costo,$observacion,$idencargado,$idcliente,$idmotocicleta,$estado){
		$sql = "INSERT INTO alquiler(fecha, h_inicio, tiempo,ingreso, observacion, id_encargado, id_cliente, id_motocicleta, estado) VALUES(:fecha,:hora,:tiempo,:costo,:observacion,:idencargado,:idcliente,:idmotocicleta,:estado)";
		$parametros = array(
			":fecha"=>$fecha, 
			":hora"=>$hora, 
			":tiempo"=>$tiempo, 
			":costo"=>$costo, 
			":observacion"=>$observacion, 
			":idencargado"=>$idencargado, 
			":idcliente"=>$idcliente, 
			":idmotocicleta"=>$idmotocicleta, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($nombre, $idproducto=0){
		$sql = "SELECT * FROM producto WHERE estado<2 AND nombre=:nombre AND idproducto<>:idproducto";
		$parametros = array(":nombre"=>$nombre, ":idproducto"=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarAlquiler($idalquiler){
		$sql = "SELECT alq.*, CONCAT_WS(' ',cli.nombre,cli.apepat,cli.apemat) as 'cliente'
		FROM alquiler alq
		INNER JOIN cliente cli
		ON alq.id_cliente=cli.id
		WHERE alq.id=:idalquiler";
		$parametros = array(":idalquiler"=>$idalquiler);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarCliente($cedula){
		$sql = "SELECT CONCAT_WS(' ',nombre,apepat,apemat) as 'nombre', cliente.id as 'id_cli' FROM cliente WHERE nro_ci=:cedula";
		$parametros = array(":cedula"=>$cedula);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarAlquiler($idalquiler,$fecha,$hora,$tiempo,$costo,$observacion,$idmotocicleta){
		$sql = "UPDATE alquiler SET fecha=:fecha, h_inicio=:hora, tiempo=:tiempo, ingreso=:costo, observacion=:observacion,id_motocicleta=:idmotocicleta WHERE id=:idalquiler";
		$parametros = array(
			":idalquiler"=>$idalquiler, 
			":fecha"=>$fecha, 
			":hora"=>$hora, 
			":tiempo"=>$tiempo, 
			":costo"=>$costo, 
			":observacion"=>$observacion, 
			":idmotocicleta"=>$idmotocicleta 
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoProducto($idalquiler, $estado){
		$sql = "UPDATE alquiler SET estado=:estado WHERE id=:idalquiler";
		$parametros = array(":estado"=>$estado, ":idalquiler"=>$idalquiler);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}
?>