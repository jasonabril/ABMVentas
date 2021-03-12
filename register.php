<?php
include_once "config.php";
include_once "entidades/usuario.php";

$entidadUsuario = new Usuario();
$aUsusarios = $entidadUsuario->cargarFormulario($_REQUEST);

if ($_POST){

    $entidadUsuario->insertar();

}



$title = "Registro";
?>
<?php include_once "head.php" ?>


<body class="bg-gradient-primary">

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Crea tu Cuenta!</h1>
                        </div>
                        <form class="user" method="post" action="register.php">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="txtUsuario"
                                           name="txtUsuario"
                                           placeholder="Nombre de usuario">
                                </div>
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="txtNombre"
                                           name="txtNombre"
                                           placeholder="Nombre">
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <input type="text" class="form-control form-control-user" id="txtApellido"
                                           name="txtApellido"
                                           placeholder="Apellido">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="txtCorreo"
                                       name="txtCorreo"
                                       placeholder="Email">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="txtClave" name="txtClave" placeholder="Contraseña">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                           id="txtclave" placeholder="Repetir contraseña">
                                </div>
                            </div>
                            <a href="login.php" class="btn btn-primary btn-user btn-block">
                                <button type="submit" class="btn btn-primary btn-user" id="btnGuardar"
                                        name="btnGuardar">Registrar Cuenta
                                </button>
                            </a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.php">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>