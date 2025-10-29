<?php
require("config/conexion.php");
require("config/datos-empresa.php");
?>
<!doctype html>
<html lang="en">

<head>

    <?php require("config/cabecera-web.php"); ?>
    <meta http-equiv="refresh" content="3;url=index.php">
    <!-- App favicon -->
    <?php
    if ($xIconoWeb == '') {
        echo '
        <link rel="shortcut icon" href="assets/images/favicon.ico">';
    } else {
        echo '
        <link rel="shortcut icon" href="assets/images/' . $xIconoWeb . '">';
    }
    ?>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="bg-overlay"></div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-6 col-md-8">
                    <div class="card">
                        <div class="card-body p-3 border-bottom border-primary cabeceralogin">
                            <div class="text-center">
                                <a href="index.php" class="">
                                    <?php
                                    if ($xLogoApp == '') {
                                        echo '
                                        <img src="assets/images/logo.png" alt="" height="70" class="auth-logo logo-dark mx-auto">
                                        <img src="assets/images/logo.png" alt="" height="70" class="auth-logo logo-light mx-auto">';
                                    } else {
                                        echo '
                                        <img src="assets/images/' . $xLogoApp . '" alt="" height="70" class="auth-logo logo-dark mx-auto">
                                        <img src="assets/images/' . $xLogoApp . '" alt="" height="70" class="auth-logo logo-light mx-auto">';
                                    }
                                    ?>
                                </a>
                            </div>
                            <!-- end row -->
                            <h4 class="font-size-14 text-muted text-center tituloblanco">El Usuario o La Contraseña no Coincide</h4>
                        </div>
                        <div class="card-body p-4">
                            <form class="form-horizontal" action="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="user-thumb text-center m-b-30">
                                            <img src="assets/images/error.svg" class="mx-auto d-block avatar-xxl" alt="thumbnail">
                                        </div>
                                        <div class="d-grid mt-4">
                                            <a href="index.php" class="btn btn-primary waves-effect waves-light">Volver a Ingresar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php require("config/piepagina-externo.php"); ?>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end Account pages -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>