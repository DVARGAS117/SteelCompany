<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="dashboard.php" class="waves-effect">
                        <i class="mdi mdi-home-variant-outline"></i><span class="badge rounded-pill bg-primary float-end">3</span>
                        <span>Escritorio</span>
                    </a>
                </li>
                <?php
                $sqlMenuModulos     = mysqli_query($conexion, "SELECT * FROM modulos WHERE estado='A' ORDER BY orden ASC");
                while ($fmmods      = mysqli_fetch_array($sqlMenuModulos)) {
                    $cod_modulo     = $fmmods['cod_modulo'];
                    $nombre_modulo  = $fmmods['nombre_modulo'];
                    $icono          = $fmmods['icono'];
                    /*******************************************************/
                    $sqlAccesos     = mysqli_query($conexion, "SELECT * FROM accesos_usuarios WHERE cod_modulo='$cod_modulo' AND cod_personal='$xCodPer' AND (consultar='SI' OR insertar='SI' OR editar='SI' OR eliminar='SI')");
                    $numAccs        = mysqli_num_rows($sqlAccesos);
                    if ($numAccs > 0) {
                        echo "
                        <li>
                            <a href='javascript: void(0);' class='has-arrow waves-effect'>
                                <i class='$icono'></i>
                                <span>$nombre_modulo</span>
                            </a>
                            <ul class='sub-menu' aria-expanded='false'>";
                        $sqlMenuSubModulos  = mysqli_query($conexion, "SELECT * FROM sub_modulos WHERE cod_modulo='$cod_modulo'");
                        while ($fsmmod      = mysqli_fetch_array($sqlMenuSubModulos)) {
                            $sub_modulo     = $fsmmod['sub_modulo'];
                            $enlace         = $fsmmod['enlace'] . '?sub_modulo=' . $sub_modulo;
                            /***********************************************/
                            $xsqlAccesos     = mysqli_query($conexion, "SELECT * FROM accesos_usuarios WHERE cod_modulo='$cod_modulo' AND cod_personal='$xCodPer' AND modulo='$sub_modulo' AND (consultar='SI' OR insertar='SI' OR editar='SI' OR eliminar='SI')");
                            $xnumAccs        = mysqli_num_rows($xsqlAccesos);
                            /***********************************************/
                            if ($xnumAccs > 0) {
                                echo "
                               <li><a href='$enlace'>$sub_modulo</a></li>";
                            }
                        }
                        echo "
                            </ul>
                        </li>";
                    }
                }
                ?>
                <li>
                    <a href="config/cerrar-sesion.php" class="waves-effect">
                        <i class="mdi mdi-logout"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>