<?php
include_once("config.php");
include_once("entidades/venta.php");
include_once("entidades/cliente.php");
include_once("entidades/producto.php");

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);

if ($_POST) {
    //print_r($_POST);exit;
    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {

            $venta->actualizar();
            header("Location: ventas-listado.php");
        } else {
            $venta->insertar();
            header("Location: ventas-listado.php");

        }
    } else if (isset($_POST["btnBorrar"])) {
        $venta->eliminar();
        header("Location: ventas-listado.php");
    }
}

$clientes = new Cliente();
$aClientes = $clientes->obtenerTodos();
$ventas = new Venta();
$aVentas = $ventas->obtenerTodos();
$productos = new Producto();
$aProductos = $productos->obtenerTodos();
//print_r($ventas);exit;
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $venta->obtenerPorId();
}

$title = "Formulario de ventas";
?>

<?php include_once "head.php" ?>

<?php include_once "menu.php" ?>

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
                <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..."
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
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["nombre"] ?> </span>
                        <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
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
            <h1 class="h3 mb-4 text-gray-800">Venta</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="ventas-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar
                    </button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtFecha">Fecha y hora:</label>
                    <div class="row">
                        <div class="col-sm-3 col-3">
                            <select class="form-control" name="txtDia" id="txtDia">
                                <option selected="" disabled="">DD</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option><?php echo $i; ?> </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-3">
                            <select type="number" class="form-control" name="txtMes" id="txtMes">
                                <option selected="" disabled="">MM</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option><?php echo $i; ?> </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-3">
                            <select type="number" class="form-control" name="txtAnio" id="txtAnio">
                                <option selected="" disabled="">YYYY</option>
                                <?php for ($i = 2010; $i <= date('Y'); $i++): ?>
                                    <option><?php echo $i; ?> </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-3">
                            <input type="datetime" required="" class="form-control d-inline" name="txtHora" id="txtHora"
                                   value="<?php echo date( "H:i"); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-6 form-group">
                    <label for="lstCliente">Cliente:</label>
                    <select required="" class="form-control selectpicker" data-live-search="true" name="lstCliente"
                            id="lstCliente">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php
                        foreach ($aClientes as $cliente): ?>
                            <?php if ($ventas->fk_idcliente == $cliente->idcliente): ?>
                                <option selected
                                        value="<?php  $ventas->fk_idcliente ?>"> <?php echo $cliente->nombre ?></option>
                            <?php else: ?>
                                <option value="<?php  $ventas->fk_idcliente; ?>"> <?php echo $cliente->nombre ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="lstProducto">Producto:</label>
                    <select required="" class="form-control selectpicker" data-live-search="true" name="lstProducto"
                            id="lstProducto" onchange="fBuscarPrecio();">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php
                        foreach ($aProductos as $producto): ?>
                            <?php if ($ventas->fk_idproducto == $producto->idproducto): ?>
                                <option selected
                                        value="<?php echo $producto->idproducto ?>"> <?php echo $producto->nombre ?></option>
                            <?php else: ?>
                                <option value="<?php echo $producto->idproducto; ?>"> <?php echo $producto->nombre ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="txtPrecioUni">Precio unitario:</label>
                    <input type="text" class="form-control" id="txtPrecioUniCurrency"
                           value="<?php echo $venta->preciounitario ?>">

                    <input type="hidden" class="form-control" name="txtPrecioUni" id="txtPrecioUni"
                           value="<?php echo $venta->preciounitario ?>" onchange="fBuscarPrecio()">

                </div>
                <div class="col-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="number" class="form-control" name="txtCantidad" id="txtCantidad"
                           value="<?php echo $venta->cantidad; ?>"
                           onchange="fCalcularTotal();">
                    <span id="msgStock" class="text-danger" style="display:none;">No hay stock suficiente</span>
                </div>
                <div class="col-6 form-group">
                    <label for="txtTotal">Total:</label>
                    <input type="text" class="form-control" name="txtTotal" id="txtTotal"
                           value="<?php echo $venta->total; ?>">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>

        function fBuscarPrecio() {
            var idProducto = $("#lstProducto option:selected").val();
            $.ajax({
                type: "GET",
                url: "venta-formulario.php?do=buscarProducto",
                data: {id: idProducto},
                async: true,
                dataType: "json",
                success: function (respuesta) {
                    strResultado = Intl.NumberFormat("es-AR", {
                        style: 'currency',
                        currency: 'ARS'
                    }).format(respuesta.precio);
                    $("#txtPrecioUniCurrency").val(strResultado);
                    $("#txtPrecioUni").val(respuesta.precio);
                }
            });

        }

        function fCalcularTotal() {
            var idProducto = $("#lstProducto option:selected").val();
            var precio = parseFloat($('#txtPrecioUni').val());
            var cantidad = parseInt($('#txtCantidad').val());

            $.ajax({
                type: "GET",
                url: "venta-formulario.php?do=buscarProducto",
                data: {id: idProducto},
                async: true,
                dataType: "json",
                success: function (respuesta) {
                    let resultado = 0;
                    if (cantidad <= parseInt(respuesta.cantidad)) {
                        resultado = precio * cantidad;
                        $("#msgStock").hide();
                    } else {
                        $("#msgStock").show();
                    }
                    strResultado = Intl.NumberFormat("es-AR", {style: 'currency', currency: 'ARS'}).format(resultado);
                    $("#txtTotal").val(strResultado);
                }
            });

        }


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
<form action="" method="POST">>
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

</html>
