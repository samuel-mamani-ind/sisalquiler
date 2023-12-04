<?php
    require_once('../modelo/clsProducto.php');

    $objPro = new clsProducto();

    $listaProducto = $objPro->listarProducto('','','1');
    $listaProducto = $listaProducto->fetchAll(PDO::FETCH_NAMED);


?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-success collapsed-card shadow"">
      <div class="card-header">
        <h3 class="card-title">Listado de reportes</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
        <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Cedula</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="number" class="form-control" name="BusquedaCedula" id="BusquedaCedula" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Motocicleta</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="text" class="form-control" name="BusquedaMatricula" id="BusquedaMatricula" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha</span>
              </div>
              <input type="date" class="form-control" name="BusquedaFecha" id="BusquedaFecha" onchange="verListado()" >
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Estado</span>
              </div>
              <select class="form-control" name="cboBusquedadEstado" id="cboBusquedadEstado" onchange="verListado()">
                <option value="">- Todos -</option>
                <option value="1">Activos</option>
                <option value="0">Anulados</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoProducto">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    
function verListado(){
    $.ajax({
      method: "POST",
      url: "vista/reportes_listado.php",
      data:{
        estado: $('#cboBusquedadEstado').val(),
        matricula: $('#BusquedaMatricula').val(),
        cedula: $('#BusquedaCedula').val(),
        fecha: $('#BusquedaFecha').val()
      }
    })
    .done(function(resultado){
      $('#divListadoProducto').html(resultado);
    })
  }

  verListado();


</script>