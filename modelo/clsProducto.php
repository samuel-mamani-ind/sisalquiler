<?php
require_once('conexion.php');

class clsProducto{

	function listarProducto($nombre,$marca,$estado){
		$sql = "SELECT mot.id as 'idmotocicleta', mot.n_placa as 'matricula', mot.estado, mar.nombre as 'marca' 
		FROM motocicleta mot 
		INNER JOIN marca_mo mar 
		ON mot.id_marca_mo=mar.id WHERE mot.estado<2 AND mar.estado<2";
		$parametros = array();

		if($nombre!=""){
			$sql .= " AND mot.n_placa LIKE :nombre ";
			$parametros[':nombre'] = "%".$nombre."%";
		}

		if($marca!=""){
			$sql .= " AND mot.id_marca_mo = :idcategoria ";
			$parametros[':idcategoria'] = $marca; 
		}

		if($estado!=""){
			$sql .= " AND mot.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY mot.n_placa ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarProducto($nombre,$marca,$estado){
		$sql = "INSERT INTO motocicleta(n_placa, id_marca_mo, estado) VALUES(:nombre, :marca, :estado)";
		$parametros = array(
			":nombre"=>$nombre, 
			":marca"=>$marca, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($nombre, $idproducto=0){
		$sql = "SELECT * FROM motocicleta WHERE estado<2 AND n_placa=:nombre AND id<>:idproducto";
		$parametros = array(":nombre"=>$nombre, ":idproducto"=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarProducto($idproducto){
		$sql = "SELECT * FROM motocicleta WHERE id=:idproducto ";
		$parametros = array(":idproducto"=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarProducto($idproducto, $nombre,$marca){
		$sql = "UPDATE motocicleta SET n_placa=:nombre, id_marca_mo=:marca WHERE id=:idproducto";
		$parametros = array(
			":idproducto"=>$idproducto, 
			":nombre"=>$nombre, 
			":marca"=>$marca
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoProducto($idproducto, $estado){
		$sql = "UPDATE motocicleta SET estado=:estado WHERE id=:idproducto";
		$parametros = array(":estado"=>$estado, ":idproducto"=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}
?>