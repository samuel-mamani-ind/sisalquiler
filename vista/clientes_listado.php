<?php
	require_once('../modelo/clsCliente.php');

	$objCli = new clsCliente();

	$estado = $_POST['estado'];
	$codigo = $_POST['codigo'];

	$listaProducto = $objCli->listarCliente($codigo, $estado);
	$listaProducto = $listaProducto->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableProducto" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>COD</th>
			<th>NOMBRE</th>
			<th>A.PATERNO</th>
			<th>A.MATERNO</th>
			<th>CEDULA</th>
			<th>L.EXPEDICION</th>
			<th>BARRIO</th>
			<th>CALLE</th>
			<th>N. CASA</th>
			<th>TELEFONO</th>
			<th>ESTADO</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaProducto as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['idcliente'] ?></td>
			<td><?= $value['nombre'] ?></td>
			<td><?= $value['apepat'] ?></td>
			<td><?= $value['apemat'] ?></td>
			<td><?= $value['nro_ci'] ?></td>
			<td><?= $value['expedido'] ?></td>
			<td><?= $value['barrio'] ?></td>
			<td><?= $value['d_calle'] ?></td>
			<td><?= $value['d_nrocasa'] ?></td>
			<td><?= $value['telefono'] ?></td>
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
                    	<a class="dropdown-item" href="#" onclick="editarProducto(<?= $value['idcliente'] ?>)"><i class="fa fa-edit"></i> Editar</a>
                    	<?php if($value['estado']==1){ ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idcliente'] ?>,0)"><i class="fa fa-trash"></i> Anular</a>
                    	<?php }else{ ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idcliente'] ?>,1)"><i class="fa fa-check"></i> Activar</a>
                    	<?php } ?>
                    	<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?= $value['idcliente'] ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
                    </div>
                </div>
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
    		url: "controlador/contCliente.php",
    		data: {
    			accion: 'CONSULTAR_PRODUCTO',
    			idproducto: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		$('#nombre').val(resultado.nombre);
    		$('#apepat').val(resultado.apepat);
    		$('#apemat').val(resultado.apemat);
    		$('#nroci').val(resultado.nro_ci);
    		$('#expedido').val(resultado.id_procedencia_ci);
    		$('#barrio').val(resultado.id_barrio);
    		$('#dcalle').val(resultado.d_calle);
    		$('#nrocasa').val(resultado.d_nrocasa);
    		$('#telefono').val(resultado.telefono);

	    	$('#idcliente').val(id);
	    	$('#modalProducto').modal('show');
    	});    	
    }

    function cambiarEstadoProducto(idproducto, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el cliente?";
    	accion = "EjecutarCambiarEstadoProducto("+idproducto+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoProducto(idproducto,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contCliente.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_PRODUCTO',
    			'idproducto': idproducto,
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