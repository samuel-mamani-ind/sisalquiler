<?php
require_once('../modelo/clsCliente.php');

controlador($_POST['accion']);

function controlador($accion){
	$objCli = new clsCliente();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$nombre = $_POST['nombre'];
				$apepat = $_POST['apepat'];
				$apemat = $_POST['apemat'];
				$cedula = $_POST['nroci'];
				$expedido = $_POST['expedido'];
				$barrio = $_POST['barrio'];
				$calle = $_POST['dcalle'];
				$nrocasa = $_POST['nrocasa'];
				$telefono = $_POST['telefono'];
				$estado = $_POST['estado'];

				$existeProducto = $objCli->verificarDuplicado($cedula);
				if($existeProducto->rowCount()>0){
					throw new Exception("Existe un Cliente Registrado con la misma cedula", 1);
					
				}
					
				$objCli->insertarCliente($nombre,$apepat,$apemat,$cedula,$expedido,$barrio,$calle,$nrocasa,$telefono,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Cliente Registrado de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_PRODUCTO':
			try {
				$idcliente = $_POST['idproducto'];

				$resultado = $objCli->consultarCliente($idcliente);
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
				$idcliente = $_POST['idcliente'];
				$nombre = $_POST['nombre'];
				$apepat = $_POST['apepat'];
				$apemat = $_POST['apemat'];
				$cedula = $_POST['nroci'];
				$expedido = $_POST['expedido'];
				$barrio = $_POST['barrio'];
				$calle = $_POST['dcalle'];
				$nrocasa = $_POST['nrocasa'];
				$telefono = $_POST['telefono'];

				$existeProducto= $objCli->verificarDuplicado($cedula, $idcliente);
				if($existeProducto->rowCount()>0){
					throw new Exception("Existe un Cliente Registrado con la misma cedula", 1);
					
				}

				$objCli->actualizarCliente($idcliente,$nombre,$apepat,$apemat,$cedula,$expedido,$barrio,$calle,$nrocasa,$telefono);

				$resultado['correcto']=1;
				$resultado['mensaje']="Cliente actualizado de forma satisfactoria.";
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
				$idproducto = $_POST['idproducto'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADO','ACTIVADO','ELIMINADO');

				$objCli->actualizarEstadoProducto($idproducto, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El cliente ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

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