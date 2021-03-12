<?php
include_once("config.php");
include_once("entidades/cliente.php");

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

if ($_POST) {

    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {

            $cliente->actualizar();
            header("Location: clientes-listado.php");
        } else {
            $cliente->insertar();
            header("location: clientes-listado.php");

        }
    } else if (isset($_POST["btnBorrar"])) {
        $cliente->eliminar();
        header("location: clientes-listado.php");
    }
}


if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $cliente->obtenerPorId();
}
$title = "Formulario de clientes";
?>

<?php include_once "head.php" ?>

<?php include_once("menu.php") ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column" xmlns="http://www.w3.org/1999/html">

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
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $_SESSION["nombre"] ?></span>
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
            <h1 class="h3 mb-4 text-gray-800">Cliente</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="clientes-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar
                    </button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre"
                           value="<?php echo $cliente->nombre ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCuit">CUIT:</label>
                    <input type="text" required class="form-control" name="txtCuit" id="txtCuit"
                           value="<?php echo $cliente->cuit ?>"
                           maxlength="11">
                </div>

                <div class="col-6 form-group">

                    <label for="txtFechaNac">Fecha de nacimiento:</label>
                    <div class="row">
                        <div class="col-sm-4 col-4">
                            <select class="form-control d-inline" name="txtDiaNac" id="txtDiaNac" style="width: 80px">
                                <option selected="" disabled="">DD</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <?php if ($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "d")): ?>
                                        <option selected><?php echo $i; ?></option>
                                    <?php else: ?>
                                        <option><?php echo $i; ?></option>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </select>

                        </div>
                        <div class="col-sm-4 col-4">
                            <select type="number" class="form-control" name="txtMesNac" id="txtMesNac">
                                <option selected="" disabled="">MM</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <?php if ($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "m")): ?>
                                        <option selected><?php echo $i; ?></option>
                                    <?php else: ?>
                                        <option><?php echo $i; ?> </option>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-sm-4 col-4">
                            <select type="number" class="form-control" name="txtAnioNac" id="txtAnioNac">
                                <option selected="" disabled="">YYYY</option>
                                <?php for ($i = 1900; $i <= date('Y'); $i++): ?>
                                    <?php if ($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "Y")): ?>
                                        <option selected><?php echo $i; ?></option>
                                    <?php else: ?>
                                        <option><?php echo $i; ?> </option>
                                    <?php endif; ?>
                                    <option><?php echo $i; ?> </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-6 form-group">
                    <label for="txtTelefono">Teléfono:</label>
                    <input type="number" class="form-control" name="txtTelefono" id="txtTelefono"
                           value="<?php echo $cliente->telefono ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCorreo">Correo:</label>
                    <input type="" class="form-control" name="txtCorreo" id="txtCorreo" required
                           value="<?php echo $cliente->correo ?>">
                </div>
            </div>


            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        </form>
        </body>