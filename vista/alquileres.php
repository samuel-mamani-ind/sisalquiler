<?php
    require_once('../modelo/clsProducto.php');
  require_once('../modelo/clsAlquiler.php');

    $objPro = new clsProducto();
  $objAlq = new clsAlquiler();

    $listaProducto = $objPro->listarProducto('','','1');
    $listaProducto = $listaProducto->fetchAll(PDO::FETCH_NAMED);


?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-success collapsed-card shadow"">
      <div class="card-header">
        <h3 class="card-title">Listado de Alquileres</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
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
          <div class="col-md-3">
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
          <div class="col-md-3">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-outline card-danger">
    <div class="card-body">
    <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Cedula de cliente</span>
              </div>
              <input type="text" class="form-control" name="cedula_cli" id="cedula_cli" placeholder="Numero de carnet"  onkeyup="if(event.keyCode=='13'){ buscarCliente(); }" >
            </div>
          </div>
          <div class="col-md-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nombre del cliente</span>
              </div>
              <input type="text" class="form-control" name="nombre_cli" id="nombre_cli" placeholder="Nombre del cliente buscado" disabled>
              <input type="hidden" name="id_cli" id="id_cli">
            </div>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-danger" onclick="buscarCliente()"><i class="fa fa-street-view"></i> Buscar</button>
            <button type="button" class="btn btn-success" onclick="abrirModalProducto()" id="nuevo" disabled><i class="fa fa-plus"></i> Nuevo Alquiler</button>
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
<div class="modal fade" id="modalProducto">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-primary">
              <h4 class="modal-title">Datos de Alquiler</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formProducto" id="formProducto">
                <input type="hidden" name="idalquiler" id="idalquiler" value="">
                <input type="hidden" name="idcliente" id="idcliente" value="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre_cliente">Nombre de Cliente</label>
                      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" disabled>
                    </div>
                    <div class="form-group">
                      <div class="form-group">
                        <label for="hora">Hora Inicio</label>
                        <input type="time" class="form-control" id="hora" name="hora">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="motocicleta">Motocicleta</label>
                      <select name="motocicleta" id="motocicleta" class="form-control">
                        <option value="">- Seleccione -</option>
                        <?php foreach($listaProducto as $k=>$v){ ?>
                          <option value="<?= $v['idmotocicleta'] ?>"><?= $v['matricula'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha">Fecha</label>
                      <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                    <div class="form-group">
                      <label for="tiempo">Tiempo(Horas)</label>
                      <input type="number" class="form-control" id="tiempo" name="tiempo" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="costo">Costo(Bs)</label>
                      <input type="number" class="form-control" id="costo" name="costo" placeholder="">
                    </div>
                    <div class="form-group d-none">
                      <label for="estado">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="1">ACTIVO</option>
                        <option value="0">ANULADO</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacion">Observacion</label>
                        <input type="text" class="form-control" id="observacion" name="observacion">
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProducto()"><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    
function verListado(){
    $.ajax({
      method: "POST",
      url: "vista/alquileres_listado.php",
      data:{
        estado: $('#cboBusquedadEstado').val(),
        matricula: $('#BusquedaMatricula').val(),
        fecha: $('#BusquedaFecha').val()
      }
    })
    .done(function(resultado){
      $('#divListadoProducto').html(resultado);
    })
  }


  function buscarCliente(){
    if(validarBusquetaCliente()){
      $.ajax({
          method: "POST",
          url: "controlador/contAlquiler.php",
          data: {
            accion: 'CONSULTAR_CLIENTE',
            cedula: $('#cedula_cli').val()
          },
          dataType: "json"
        })
        .done(function(resultado){
          $('#nombre_cli').val(resultado.nombre);
          $('#id_cli').val(resultado.id_cli);
          if(resultado==false){
            toastError('El cliente no existe en la base de datos');
            $("#nuevo").prop("disabled", true);
          }else{
            $("#nuevo").prop("disabled", false);
          }
        });
    }    
  }

  function validarBusquetaCliente(){
    let correcto = true;
    let cedula = $('#cedula_cli').val();

    if(cedula==""){
      toastError('Ingrese un número de carnet para la busqueda');
      correcto = false;
    }

    return correcto;
  }

  verListado();

  function guardarProducto(){
    if(validarFormulario()){
      var datos = $('#formProducto').serializeArray();
      var idalquiler = $('#idalquiler').val();
      if(idalquiler!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contAlquiler.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalProducto').modal('hide');
          $('#formProducto').trigger('reset');

          $('#nombre_cli').val('');
          $('#cedula_cli').val('');
          $('#id_cli').val('');
          $("#nuevo").prop("disabled", true);
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
    let correcto = true;
    let nombre = $('#nombre_cliente').val();

    $('.obligatorio').removeClass('is-invalid');

    if(nombre==""){
      toastError('El nombre de cliente no puede ser vacio');
      $('#nombre').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

  function abrirModalProducto(){
        $('#formProducto').trigger('reset');
        $("#nombre_cliente").val($("#nombre_cli").val());
        $("#idcliente").val($("#id_cli").val());
        $('#idproducto').val("");
        $('#modalProducto').modal('show');
        $('.obligatorio').removeClass('is-invalid');
  }

</script>