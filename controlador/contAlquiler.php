<?php
require_once('../modelo/clsAlquiler.php');

controlador($_POST['accion']);

function controlador($accion){
	$objAlq = new clsAlquiler();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$idcliente = $_POST['idcliente'];
				$hora = $_POST['hora'];
				$idmotocicleta = $_POST['motocicleta'];
				$fecha = $_POST['fecha'];
				$tiempo = $_POST['tiempo'];
				$costo = $_POST['costo'];
				$observacion = $_POST['observacion'];
				$idencargado = $_SESSION['idusuario'];
				$estado = $_POST['estado'];
					
				$objAlq->insertarAlquiler($fecha,$hora,$tiempo,$costo,$observacion,$idencargado,$idcliente,$idmotocicleta,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Alquiler Registrado de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_PRODUCTO':
			try {
				$alquiler = $_POST['idalquiler'];

				$resultado = $objAlq->consultarAlquiler($alquiler);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_CLIENTE':
			try {
				$cedula = $_POST['cedula'];

				$resultado = $objAlq->consultarCliente($cedula);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		case 'ACTUALIZAR':
			$resultado = array();
			try {
				$idalquiler = $_POST['idalquiler'];
				$fecha = $_POST['fecha'];
				$hora = $_POST['hora'];
				$tiempo = $_POST['tiempo'];
				$costo = $_POST['costo'];
				$observacion = $_POST['observacion'];
				$idmotocicleta = $_POST['motocicleta'];

				$objAlq->actualizarAlquiler($idalquiler,$fecha,$hora,$tiempo,$costo,$observacion,$idmotocicleta);

				$resultado['correcto']=1;
				$resultado['mensaje']="Alquiler actualizado de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_PRODUCTO':
			$resultado = array();
			try {
				$idalquiler = $_POST['idalquiler'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADO','ACTIVADO','ELIMINADO');

				$objAlq->actualizarEstadoProducto($idalquiler, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El Alquiler ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		
		default:
			echo "No ha definido una accion";
			break;
	}

}

?>