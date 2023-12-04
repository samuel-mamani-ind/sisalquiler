<?php
    require_once('../modelo/clsCategoria.php');
  require_once('../modelo/clsProducto.php');

    $objCat = new clsCategoria();
  $objPro = new clsProducto();

    $listaCategoria = $objCat->listarCategoria('','1');
    $listaCategoria = $listaCategoria->fetchAll(PDO::FETCH_NAMED);


?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Listado de Motocicletas</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Matricula</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaNombre" id="txtBusquedaNombre" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Marca</span>
              </div>
              <select class="form-control" name="cboBusquedadCategoria" id="cboBusquedadCategoria" onchange="verListado()">
                <option value="">- Todos -</option>
                <?php foreach($listaCategoria as $k=>$v){ ?>
                <option value="<?= $v['id'] ?>"><?= $v['nombre'] ?></option>
                <?php } ?>
              </select>
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
  <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header bg-primary">
              <h4 class="modal-title">Motocicleta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formProducto" id="formProducto">
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <div class="form-group">
                  <label for="nombre">Matricula</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de Marca">
                  <input type="hidden" name="idproducto" id="idproducto" value="">
                </div>
                <div class="form-group">
                  <label for="nombre">Marca</label>
                  <select class="form-control" name="marca" id="marca">
                    <option value="">- Todos -</option>
                    <?php foreach($listaCategoria as $k=>$v){ ?>
                    <option value="<?= $v['id'] ?>"><?= $v['nombre'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              <div class="form-group" style="display: none;">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                  <option value="1">ACTIVO</option>
                  <option value="0">ANULADO</option>
                </select>
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

<script>
    
function verListado(){
    $.ajax({
      method: "POST",
      url: "vista/productos_listado.php",
      data:{
        nombre: $('#txtBusquedaNombre').val(),
        estado: $('#cboBusquedadEstado').val(),
        marca: $('#cboBusquedadCategoria').val(),
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
      var idproducto = $('#idproducto').val();
      if(idproducto!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
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
    let nombre = $('#nombre').val();

    $('.obligatorio').removeClass('is-invalid');

    if(nombre==""){
      toastError('Ingrese el nombre del Producto');
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