<?php
require_once('conexion.php');

class clsReportes{

	function listarReporte($cedula,$matricula, $fecha,$estado){
		$sql = "SELECT alq.*, alq.id as 'idalquiler', 
		CONCAT_WS(' ',cli.nombre,cli.apepat,cli.apemat) as 'cliente', CONCAT_WS(' ',cli.nro_ci,prci.nombre) as 'cedula',
		CONCAT_WS(', ',bar.nombre,cli.d_calle,cli.d_nrocasa) as 'direccion',
		usu.nombre as 'encargado', mot.n_placa as 'motocicleta' 
		FROM alquiler alq 
		INNER JOIN cliente cli 
		ON alq.id_cliente=cli.id
		INNER JOIN barrio bar
		ON cli.id_barrio=bar.id
		INNER JOIN procedencia_ci prci 
		ON cli.id_procedencia_ci=prci.id
		INNER JOIN usuario usu 
		ON alq.id_encargado=usu.idusuario
		INNER JOIN motocicleta mot 
		ON alq.id_motocicleta=mot.id  
		WHERE alq.estado<2 AND usu.estado<2 AND mot.estado<2";
		$parametros = array();

		if($cedula!=""){
			$sql .= " AND cli.nro_ci LIKE :cedula ";
			$parametros[':cedula'] = "%".$cedula."%";
		}

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

}
?>