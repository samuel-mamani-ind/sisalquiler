<?php
	require_once('../modelo/clsReportes.php');

	$objRep = new clsReportes();

	$estado = $_POST['estado'];
	$matricula = $_POST['matricula'];
	$cedula = $_POST['cedula'];
	$fecha = $_POST['fecha'];

	$listaReporte = $objRep->listarReporte($cedula,$matricula, $fecha,$estado);
	$listaReporte = $listaReporte->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableProducto" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>COD</th>
			<th>FECHA</th>
			<th>CLIENTE</th>
			<th>CEDULA</th>
			<th>DIRECCION</th>
			<th>MOTOCICLETA</th>
			<th>HORA INICIO</th>
			<th>TIEMPO(HORAS)</th>
			<th>COSTO(BS)</th>
			<th>OBSERVACION</th>
			<th>ENCARGADO</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaReporte as $key => $value) { 
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
			<td><?= $value['cedula'] ?></td>
			<td><?= $value['direccion'] ?></td>
			<td><?= $value['motocicleta'] ?></td>
			<td><?= $value['h_inicio'] ?></td>
			<td><?= $value['tiempo'] ?></td>
			<td><?= $value['ingreso'] ?></td>
			<td><?= $value['observacion'] ?></td>
			<td><?= $value['encargado'] ?></td>
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


</script>