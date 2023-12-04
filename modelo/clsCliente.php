<?php
require_once('conexion.php');

class clsCliente{

	function listarCliente($codigo, $estado){
		$sql = "SELECT cli.*, cli.id as 'idcliente', pro.nombre as 'expedido', ba.nombre as 'barrio' 
		FROM cliente cli 
		INNER JOIN procedencia_ci pro 
		ON cli.id_procedencia_ci=pro.id
		INNER JOIN barrio ba
		ON cli.id_barrio=ba.id 
		WHERE cli.estado<2 AND pro.estado<2 AND ba.estado<2";
		$parametros = array();

		if($codigo!=""){
			$sql .= " AND cli.nro_ci LIKE :codigo ";
			$parametros[':codigo'] = "%".$codigo."%";
		}

		if($estado!=""){
			$sql .= " AND cli.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY pro.nombre ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarBarrio(){
		$sql = "SELECT * FROM barrio WHERE estado=1 ";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarProcedenciaCI(){
		$sql = "SELECT * FROM procedencia_ci";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarCliente($nombre,$apepat,$apemat,$cedula,$expedido,$barrio,$calle,$nrocasa,$telefono,$estado){
		$sql = "INSERT INTO cliente(nombre,apepat,apemat,nro_ci,id_procedencia_ci,id_barrio,d_calle,d_nrocasa,telefono,estado) VALUES(:nombre,:apepat,:apemat,:cedula,:expedido,:barrio,:calle,:nrocasa,:telefono,:estado)";
		$parametros = array(
			":nombre"=>$nombre, 
			":apepat"=>$apepat, 
			":apemat"=>$apemat, 
			":cedula"=>$cedula, 
			":expedido"=>$expedido, 
			":barrio"=>$barrio, 
			":calle"=>$calle, 
			":nrocasa"=>$nrocasa, 
			":telefono"=>$telefono, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($cedula, $idcliente=0){
		$sql = "SELECT * FROM cliente WHERE estado<2 AND nro_ci=:cedula AND id<>:idcliente";
		$parametros = array(":cedula"=>$cedula, ":idcliente"=>$idcliente);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarCliente($idcliente){
		$sql = "SELECT * FROM cliente WHERE id=:idcliente ";
		$parametros = array(":idcliente"=>$idcliente);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarCliente($idcliente,$nombre,$apepat,$apemat,$cedula,$expedido,$barrio,$calle,$nrocasa,$telefono){
		$sql = "UPDATE cliente SET nombre=:nombre,apepat=:apepat,apemat=:apemat,nro_ci=:cedula,id_procedencia_ci=:expedido,id_barrio=:barrio,d_calle=:calle,d_nrocasa=:nrocasa,telefono=:telefono WHERE id=:idcliente";
		$parametros = array(
			":idcliente"=>$idcliente, 
			":nombre"=>$nombre, 
			":apepat"=>$apepat, 
			":apemat"=>$apemat, 
			":cedula"=>$cedula, 
			":expedido"=>$expedido, 
			":barrio"=>$barrio, 
			":calle"=>$calle, 
			":nrocasa"=>$nrocasa, 
			":telefono"=>$telefono
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoProducto($idproducto, $estado){
		$sql = "UPDATE cliente SET estado=:estado WHERE id=:idproducto";
		$parametros = array(":estado"=>$estado, ":idproducto"=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}
?>