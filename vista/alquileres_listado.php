<?php
	require_once('../modelo/clsAlquiler.php');

	$objAlq = new clsAlquiler();

	$estado = $_POST['estado'];
	$matricula = $_POST['matricula'];
	$fecha = $_POST['fecha'];

	$listaAlquiler = $objAlq->listarAlquiler($matricula, $fecha,$estado);
	$listaAlquiler = $listaAlquiler->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableProducto" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>COD</th>
			<th>FECHA</th>
			<th>CLIENTE</th>
			<th>MOTOCICLETA</th>
			<th>HORA INICIO</th>
			<th>TIEMPO(H)</th>
			<th>COSTO(BS)</th>
			<th>OBSERVACION</th>
			<th>ENCARGADO</th>
			<th>ESTADO</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaAlquiler as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['idalquiler'] ?></td>
			<td><?= $value['fecha'] ?></td>
			<td><?= $value['cliente'] ?></td>
			<td><?= $value['motocicleta'] ?></td>
			<td><?= $value['h_inicio'] ?></td>
			<td><?= $value['tiempo'] ?></td>
			<td><?= $value['ingreso'] ?></td>
			<td><?= $value['observacion'] ?></td>
			<td><?= $value['encargado'] ?></td>
			<td class="<?= $tdclass; ?>">
				<?php
					if($value['estado']==1){
						echo "Activo";
					}else{
						echo "Anulado";
					}
				?>		
			</td>
			<td>
				<div class="btn-group">
                    <button type="button" class="btn btn-info btn-flat btn-sm">Opciones</button>
                    <button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">
                    	<span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                    	<a class="dropdown-item" href="#" onclick="editarProducto(<?= $value['idalquiler'] ?>)"><i class="fa fa-edit"></i> Editar</a>
                    	<?php if($value['estado']==1){ ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idalquiler'] ?>,0)"><i class="fa fa-trash"></i> Anular</a>
                    	<?php }else{ ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idalquiler'] ?>,1)"><i class="fa fa-check"></i> Activar</a>
                    	<?php } ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idalquiler'] ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
                    </div>
                </div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	$("#tableProducto").DataTable({
    	"responsive": true, 
    	"lengthChange": true, 
    	"autoWidth": false,
    	"searching": false,
    	"ordering": true,
			"order": [[0, "desc"]],
    	//Mantener la Cabecera de la tabla Fija
    	// "scrollY": '200px',
        // "scrollCollapse": true,
        // "paging": false,
    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    	"language": {
			"decimal":        "",
		    "emptyTable":     "Sin datos",
		    "info":           "Del _START_ al _END_ de _TOTAL_ filas",
		    "infoEmpty":      "Del 0 a 0 de 0 filas",
		    "infoFiltered":   "(filtro de _MAX_ filas totales)",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "Ver _MENU_ filas",
		    "loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
		    "zeroRecords":    "No se encontraron resultados",
		    "paginate": {
		        "first":      "Primero",
		        "last":       "Ultimo",
		        "next":       "Siguiente",
		        "previous":   "Anterior"
		    },
		    "aria": {
		        "sortAscending":  ": orden ascendente",
		        "sortDescending": ": orden descendente"
		    }
		},
    	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tableProducto_wrapper .col-md-6:eq(0)');

    function editarProducto(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contAlquiler.php",
    		data: {
    			accion: 'CONSULTAR_PRODUCTO',
    			idalquiler: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		$('#nombre_cliente').val(resultado.cliente);
    		$('#hora').val(resultado.h_inicio);
    		$('#motocicleta').val(resultado.id_motocicleta);
    		$('#fecha').val(resultado.fecha);
    		$('#tiempo').val(resultado.tiempo);
    		$('#costo').val(resultado.ingreso);
    		$('#observacion').val(resultado.observacion);

	    	$('#idalquiler').val(id);
	    	$('#modalProducto').modal('show');
    	});    	
    }

    function cambiarEstadoProducto(idproducto, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el alquiler?";
    	accion = "EjecutarCambiarEstadoProducto("+idproducto+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoProducto(idalquiler,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contAlquiler.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_PRODUCTO',
    			'idalquiler': idalquiler,
    			'estado': estado
    		},
    		dataType: 'json'
    	})
    	.done(function(resultado){
    		if(resultado.correcto==1){
    			toastCorrecto(resultado.mensaje);
    			verListado();
    		}else{
    			toastError(resultado.mensaje);
    		}
    	});
    }


</script>