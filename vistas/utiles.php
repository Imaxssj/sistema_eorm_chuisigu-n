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
                <h1 class="box-title">Entrega de útiles</h1>
                <div class="box-tools pull-right">
                  <a href="../vistas/vista_grupo.php?idgrupo=<?php echo $_GET["idgrupo"]; ?>"><button class="btn btn-success"><i class='fa fa-arrow-circle-left'></i> Volver</button></a>
                  <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $_GET["idgrupo"]; ?>">
                  <input type="hidden" id="alumn_id" name="alumn_id" value="">
                </div>
              </div>
              <!--box-header-->
              <!--centro-->
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
                    <th>Fecha entrega</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Fecha entrega</th>
                    <th>Estado</th>
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
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/utiles.js"></script>
<?php
}

ob_end_flush();
?>