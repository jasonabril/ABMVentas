<?php
include_once("config.php");
include_once("entidades/producto.php");
include_once("entidades/tipoproducto.php");



$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

if ($_POST) {


    if (isset($_POST["btnGuardar"])) {
        $nuevoNombre = "";
        if ($_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["imagen"]["tmp_name"];
            $nombreArchivo = $_FILES["imagen"]["name"];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nuevoNombre = "$nombreAleatorio.$extension";
            if ($extension == ".jpg" || $extension == ".jpeg" || $extension == ".png") {}
                move_uploaded_file($archivo_tmp, "img/".$nuevoNombre);

        }
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            $prductoAnterior = new Producto();
            $prductoAnterior->idproducto = $_GET["id"];
            $prductoAnterior->obtenerPorId();
            $imagenAnterior = $prductoAnterior->imagen;

            if ($_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
                if ($imagenAnterior != "") {
                    unlink($imagenAnterior);
                }
            } else {
                $nuevoNombre = $imagenAnterior;
            }
            $producto->imagen = $nuevoNombre;
            $producto->actualizar();
            header("location: productos-listado.php");
        } else {

            $producto->imagen = $nuevoNombre;
            $producto->insertar();
            header("location: productos-listado.php");

        }
    } else if (isset($_POST["btnBorrar"])) {

        if ($imagenAnterior != ""){
            unlink($imagenAnterior);
        }
        $producto->eliminar();
        header("location: productos-listado.php");

    }
}


if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $producto->obtenerPorId();
}

$tipo = new Tipoproducto();
$tipo->cargarFormulario($_REQUEST);


$title = "Edicion de producto";
?>

<?php include_once "head.php" ?>
<?php include_once("menu.php"); ?>


<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                           aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["nombre"] ?></span>
                            <img class="img-profile rounded-circle"
                                 src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cuenta
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Configuración
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Log de actividad
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Productos</h1>
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="productos-listado.php" class="btn btn-primary mr-2">Listado</a>
                        <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                        <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">
                            Guardar
                        </button>
                        <a href="id=<?php $producto->idproducto ?>?&accion=eliminar">
                            <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                        </a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-6 form-group">
                        <label for="txtNombre">Nombre:</label>
                        <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre"
                               value="<?php echo $producto->nombre ?>">
                    </div>
                    <div class="col-6 form-group">
                        <label for="lstTipoProducto">Tipo de producto:</label>
                        <select name="lstTipoProducto" id="lstTipoProducto" class="form-control selectpicker"
                                data-live-search="true">
                            <option selected disabled>Seleccionar</option>
                            <?php
                            $tipo = (new Tipoproducto())->obtenerTodos();
                            foreach ($tipo as $value): ?>
                                <?php if ($value->idtipoproducto == $producto->fk_idtipoproducto): ?>
                                    <option selected
                                            value="<?php echo $value->idtipoproducto; ?>"> <?php echo $value->nombre ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $value->idtipoproducto; ?>"> <?php echo $value->nombre ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-6 form-group">
                        <label for="txtCantidad">Cantidad:</label>
                        <input type="number" required="" class="form-control" name="txtCantidad" id="txtCantidad"
                               value="<?php echo $producto->cantidad ?>">
                    </div>
                    <div class="col-6 form-group">
                        <label for="txtPrecio">Precio:</label>
                        <input type="number" class="form-control" name="txtPrecio" id="txtPrecio"
                               value="<?php echo $producto->precio; ?>">
                    </div>
                    <div class="col-12 form-group">
                        <label for="txtDescripcion">Descripción:</label>
                        <textarea type="text" name="txtDescripcion"
                                  id="txtDescripcion"><?php echo $producto->descripcion ?></textarea>
                    </div>
                    <div class="col-6 form-group">
                        <label for="imagen">Imagen:</label>
                        <input type="file" class="form-control-file" name="imagen" id="imagen"
                               accept=".jpg, .jpeg, .png" value="<?php echo $producto->imagen ?>">
                        <small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>

        <!-- End of Main Content -->
        <!-- editor de texto -->
        <script>
            ClassicEditor
                .create(document.querySelector('#txtDescripcion'))
                .catch(error => {
                    console.error(error);
                });
        </script>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span><a href="https://depcsuite.com" target="_blank">Patrocinado por DePC Suite</a></span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<form action="" method="POST">
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desea salir del sistema?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Hacer clic en "Cerrar sesión" si deseas finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="btnCerrar">Cerrar sesión</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
</form>
</body>


