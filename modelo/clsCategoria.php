<?php
require_once('conexion.php');

class clsCategoria{

	function listarCategoria($nombre, $estado){
		$sql = "SELECT * FROM marca_mo WHERE estado<2";
		$parametros = array();

		if($nombre!=""){
			$sql .= " AND nombre LIKE :nombre ";
			$parametros[':nombre'] = "%".$nombre."%";
		}

		if($estado!=""){
			$sql .= " AND estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY nombre ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarCategoria($nombre, $estado){
		$sql = "INSERT INTO marca_mo VALUES(null,:nombre,:estado)";
		$parametros = array(":nombre"=>$nombre, ":estado"=>$estado);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($nombre, $idcategoria=0){
		$sql = "SELECT * FROM marca_mo WHERE estado<2 AND nombre=:nombre AND id<>:idcategoria";
		$parametros = array(":nombre"=>$nombre, ":idcategoria"=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarCategoria($idcategoria){
		$sql = "SELECT * FROM marca_mo WHERE id=:idcategoria ";
		$parametros = array(":idcategoria"=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarCategoria($idcategoria, $nombre){
		$sql = "UPDATE marca_mo SET nombre=:nombre WHERE id=:idcategoria";
		$parametros = array(':idcategoria'=>$idcategoria, ':nombre'=>$nombre);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoCategoria($idcategoria, $estado){
		$sql = "UPDATE marca_mo SET estado=:estado WHERE id=:idcategoria";
		$parametros = array(":estado"=>$estado, ":idcategoria"=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}


?>