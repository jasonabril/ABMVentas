<?php
include_once("config.php");
include_once("entidades/venta.php");
include_once("entidades/cliente.php");
include_once("entidades/producto.php");

$entidadVenta = new Venta();
$aVentas = $entidadVenta->obtenerTodos();
$ventas = $entidadVenta->cargarGrilla();

$enitidadCliente = new Cliente();
$aClientes = $enitidadCliente->obtenerTodos();

$title = "Listado de ventas";
?>

<?php include_once "head.php" ?>

<?php include_once("menu.php") ?>

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
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["nombre"] ?></span>
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
        <!-- End of Topbar -->        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Listado de ventas</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                </div>
            </div>
            <table class="table table-hover border">
                <tr>
                    <th style="width: 170px;">Fecha</th>
                    <th style="width: 130px;">Cantidad</th>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th style="width: 150px;">Total</th>
                    <th style="width: 110px;">Acciones</th>
                </tr>

                    <?php foreach ($aVentas as $venta): ?>
                    <tr>
                        <td><?php echo date_format(date_create($venta->fecha), "d/m/Y H:m"); ?></td>
                        <td><?php echo $venta->cantidad; ?></td>
                        <td> <?php echo $venta->nombre_producto ;?> </td>
                        <td>  <?php echo $venta->nombre_cliente; ?></td>
                        <td><?php echo number_format($venta->total, 2,',','.'); ?></td>
                        <td style="width: 110px;">
                            <a href="venta-formulario.php?id=<?php echo $venta->idventa; ?>"><i
                                        class="fas fa-search"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

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
