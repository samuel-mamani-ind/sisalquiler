<?php
require_once('../modelo/clsProducto.php');

controlador($_POST['accion']);

function controlador($accion){
	$objPro = new clsProducto();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$nombre = $_POST['nombre'];
				$marca = $_POST['marca'];
				$estado = $_POST['estado'];

				$existeProducto = $objPro->verificarDuplicado($nombre);
				if($existeProducto->rowCount()>0){
					throw new Exception("Existe una motocicleta Registrada con el mismo nombre", 1);
					
				}
					
				$objPro->insertarProducto($nombre,$marca,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Motocicleta Registrada de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_PRODUCTO':
			try {
				$idproducto = $_POST['idproducto'];

				$resultado = $objPro->consultarProducto($idproducto);
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
				$idproducto = $_POST['idproducto'];
				$nombre = $_POST['nombre'];
				$marca = $_POST['marca'];

				$existeProducto= $objPro->verificarDuplicado($nombre, $idproducto);
				if($existeProducto->rowCount()>0){
					throw new Exception("Existe una moticleta Registrada con el mismo nombre", 1);
					
				}

				$objPro->actualizarProducto($idproducto, $nombre,$marca);

				$resultado['correcto']=1;
				$resultado['mensaje']="Motocicleta actualizado de forma satisfactoria.";
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
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objPro->actualizarEstadoProducto($idproducto, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El Motocicleta ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

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