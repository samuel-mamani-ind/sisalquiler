<?php
require_once('../modelo/clsReportes.php');

controlador($_POST['accion']);

function controlador($accion){
	$objRep = new clsReportes();

	switch ($accion) {
		case 'NUEVO':
			break;

		case 'CONSULTAR_PRODUCTO':
			break;

		case 'CONSULTAR_CLIENTE':
			break;

		case 'ACTUALIZAR':
			break;

		case 'CAMBIAR_ESTADO_PRODUCTO':
			break;

		default:
			echo "No ha definido una accion";
			break;
	}

}

?>