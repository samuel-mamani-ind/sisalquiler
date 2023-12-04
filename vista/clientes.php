<?php
  require_once('../modelo/clsCliente.php');

  $objCli = new clsCliente();

  $listaBarrio = $objCli->consultarBarrio();
  $listaBarrio = $listaBarrio->fetchAll(PDO::FETCH_NAMED);

  $listaProcedenciaCI = $objCli->consultarProcedenciaCI();

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Listado de Clientes</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Cedula</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="text" class="form-control" name="txtBusquedaCodigo" id="txtBusquedaCodigo" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-4">
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
          <div class="col-md-4">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
            <button type="button" class="btn btn-success" onclick="abrirModalProducto()"><i class="fa fa-plus"></i> Nuevo</button>
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
              <h4 class="modal-title">Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formProducto" id="formProducto">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre">
                      <input type="hidden" name="idcliente" id="idcliente" value="">
                    </div>
                    <div class="form-group">
                      <label for="nroci">Nro. Cedula</label>
                      <input type="number" class="form-control" id="nroci" name="nroci">
                    </div>
                    <div class="form-group">
                      <label for="dcalle">Calle</label>
                      <input type="text" class="form-control" id="dcalle" name="dcalle">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="apepat">Apellido Paterno</label>
                      <input type="text" class="form-control" id="apepat" name="apepat">
                    </div>
                    <div class="form-group">
                      <label for="expedido">Expedido</label>
                      <select name="expedido" id="expedido" class="form-control">
                      <option value="">- Seleccione -</option>
                        <?php while($fila = $listaProcedenciaCI->fetch(PDO::FETCH_NAMED)){ ?>
                        <option value="<?= $fila['id'] ?>"><?= $fila['nombre'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nrocasa">Nro. Casa</label>
                      <input type="text" class="form-control" id="nrocasa" name="nrocasa">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                    <label for="apemat">Apellido Materno</label>
                      <input type="text" class="form-control" id="apemat" name="apemat">
                    </div>
                    <div class="form-group">
                    <label for="barrio">Barrio</label>
                      <select name="barrio" id="barrio" class="form-control">
                        <option value="">- Seleccione -</option>
                        <?php foreach($listaBarrio as $k=>$v){ ?>
                          <option value="<?= $v['id'] ?>"><?= $v['nombre'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group d-none">
                      <label for="estado">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="1">ACTIVO</option>
                        <option value="0">ANULADO</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="telefono">Telefono</label>
                      <input type="number" class="form-control" id="telefono" name="telefono">
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProducto()" ><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modalProducto_Imagen">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary">
              <h4 class="modal-title">Subir Imagen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formProducto_imagen" id="formProducto_imagen" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="nombre_imagen" name="nombre_imagen" disabled placeholder="Nombre Producto">
                      <input type="hidden" name="idproducto_imagen" id="idproducto_imagen" value="">
                    </div>
                    <div class="form-group">
                      <label for="urlimagen">Imagen</label>
                      <input type="text" class="form-control" disabled id="urlimagen" name="urlimagen" placeholder="">
                    </div>
                     <input name="uploadFile" id="uploadFile" class="file-loading" type="file" multiple data-min-file-count="1">
                  </div>
                </div>
              </form>
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
      url: "vista/clientes_listado.php",
      data:{
        estado: $('#cboBusquedadEstado').val(),
        codigo: $('#txtBusquedaCodigo').val()
      }
    })
    .done(function(resultado){
      $('#divListadoProducto').html(resultado);
    })
  }

  verListado();

  function guardarProducto(){
    if(validarFormulario()){
      var datos = $('#formProducto').serializeArray();
      var idproducto = $('#idcliente').val();
      if(idproducto!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contCliente.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalProducto').modal('hide');
          $('#formProducto').trigger('reset');
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
    let correcto = true;
    let nombre = $('#cedula').val();

    $('.obligatorio').removeClass('is-invalid');

    if(nombre==""){
      toastError('Ingrese el numero del cedula');
      $('#nombre').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

  function abrirModalProducto(){
        $('#formProducto').trigger('reset');
        $('#idproducto').val("");
        $('#modalProducto').modal('show');
        $('.obligatorio').removeClass('is-invalid');
  }

</script>