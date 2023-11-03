<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['grupos'] == 1) {

?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Seleciona un curso</h1>
                <div class="box-tools pull-right">
                  <a href="../vistas/vista_grupo.php?idgrupo=<?php echo $_GET["idgrupo"]; ?>"><button class="btn btn-success"><i class='fa fa-arrow-circle-left'></i> Volver</button></a>
                  <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $_GET["idgrupo"]; ?>">
                </div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <select name="curso" id="curso" class="form-control selectpicker" data-live-search="true" required>
                </select>
              </div>
              <div class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-12">

              </div>



              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Calificación</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Calificación</th>
                  </tfoot>
                </table>
              </div>

              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>


    <!--Modal-->
    <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Califique...</h4>
          </div>
          <div class="modal-body">
            <form action="" name="formulario" id="formulario" method="POST">
              <div class="form-group col-lg-12 col-md-12 col-xs-12">
                <input type="hidden" id="idcalificacion" name="idcalificacion">
                <input type="hidden" id="alumn_id" name="alumn_id">
                <input type="hidden" id="idcurso" name="idcurso">
                <div>
                  <label for="zona">Valor de zona(*):</label>
                  <input class="form-control" type="number" min="0.00" step="0.01" id="zona" name="zona" required>
                </div>
                <div>
                  <label for="final">Valor de final(*):</label>
                  <input class="form-control" type="number" min="0.00" step="0.01" id="final" name="final" required>
                </div>
                <div>
                  <label for="unidad">Unidad(*):</label>
                  <select class="form-control" name="unidad" id="unidad">
                    <option value="Unidad 1">Unidad 1</option>
                    <option value="Unidad 2">Unidad 2</option>
                    <option value="Unidad 3">Unidad 3</option>
                    <option value="Unidad 4">Unidad 4</option>
                  </select>
                </div>
                <div>
                  <label for="valor">Valor de calificación:</label>
                  <input class="form-control" type="text" id="valor" name="valor" readonly>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger pull-right" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

              </div>
            </form>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>


  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/calificaciones.js"></script>
<?php
}

ob_end_flush();
?>