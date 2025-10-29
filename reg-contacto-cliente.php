<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_cliente = $_REQUEST['cod_cliente'] ?? '';
$cod_cliente = intval($cod_cliente);
$query = "SELECT * FROM clientes WHERE cod_cliente = ".$cod_cliente;
$sqlConsulta = mysqli_query($conexion, $query);
$rs = mysqli_fetch_array($sqlConsulta, MYSQLI_ASSOC);
$nombreCliente = $rs['nombres'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("config/cabecera-web.php"); ?>
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- New DataTables -->
    <link href="assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/js/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />   
</head>

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" name="fapps" id="fapps">
                        <div class="mb-3 row">
                            <?php echo '<h3>'.$nombreCliente.'</h3>'; ?>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Contacto</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_contacto" id="id_tipo_contacto">
                                    <option value="0">Seleccionar Tipo Contato</option>
                                    <?php
                                    $sqlTipoCont            = mysqli_query($conexion, "SELECT * FROM tipo_contactos");
                                    while ($tcont           = mysqli_fetch_array($sqlTipoCont)) {
                                        $id_tipo_contacto   = $tcont['id_tipo_contacto'];
                                        $tipo_contacto      = $tcont['tipo_contacto'];
                                        echo "<option value='$id_tipo_contacto'>$tipo_contacto</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre del Contacto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="persona_contacto" id="persona_contacto" maxlength="255" onkeypress="return validarle(event);">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Telefonía</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_telefonia" id="id_tipo_telefonia">
                                    <option value="0">Seleccionar Tipo de Telefonía</option>
                                    <?php
                                    $sqlTipoTelf            = mysqli_query($conexion, "SELECT * FROM tipo_telefonia");
                                    while ($ttelf           = mysqli_fetch_array($sqlTipoTelf)) {
                                        $id_tipo_telefonia  = $ttelf['id_tipo_telefonia'];
                                        $tipo_telefonia     = $ttelf['tipo_telefonia'];
                                        echo "<option value='$id_tipo_telefonia'>$tipo_telefonia</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Telefono</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="numero_telefono" id="numero_telefono" maxlength="9" onkeypress="return validarnu(event);">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" maxlength="30" onkeyup="javascript:validateMail('email','emailOK_1');">
                                <span id="emailOK_1"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Estado</label>
                            <div class="col-md-10">
                                <input type="radio" name="estado" value="A" checked> Activo
                                <input type="radio" name="estado" value="I"> Inactivo
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> REGISTRAR CONTACTO
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_cliente" id="cod_cliente" value="<?= $cod_cliente ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_contactos" class="table table-striped table-bordered dt-responsive wrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th><center>N°</center></th>
                                <th><center>Tipo</center></th>
                                <th><center>Nombres</center></th>
                                <th><center>Telefonía</center></th>
                                <th><center>N° Teléfono</center></th>
                                <th><center>Email</center></th>
                                <th><center>Estado</center></th>
                                <th width="8%"><center>Accion</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </p>

    <div class="modal fade bs-example-modal-xl" id="mod-contacto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Contacto</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="OpenCloseModal('mod-contacto','c');"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" onclick="OpenCloseModal('mod-contacto','c');">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- apexcharts js -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    
    <!-- New DataTables -->
    <script src="assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatables/dataTables.buttons.min.js"></script>

    <!-- jquery.vectormap map -->
    <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="assets/js/pages/dashboard.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/general.js"></script>

    <script>
        $(function() {
            function ListarContactos() {
                $.ajax({
                    data: {
                        cod_cliente : $('#cod_cliente').val()
                    },
                    url: "config/listar-contactos.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {},
                    success: function(data) {
                        let tabla = "tbl_contactos";
                        $('#'+tabla+' tbody').remove();
                        $('#'+tabla).append('<tbody>');
                        if (data.success) {
                            $.each(data.data,function(i,item){
                                let acciones = '';
                                acciones += '<a href="javascript:void(0)" class="btn btn-outline-success btn-sm" title="Editar Contacto" onClick="EditarContacto(\''+item.cod_contacto+'\');">'+
                                                '<i class="ri-edit-fill align-middle"></i>'+
                                            '</a>&nbsp;';
                                acciones += '<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm borrarReg" title="Eliminar Contacto" onClick="EliminarContacto(\''+item.cod_contacto+'\');">'+
                                                '<i class="ri-delete-bin-fill align-middle"></i>'+
                                            '</a>&nbsp;';
                                let estado = '';
                                if (item.estado == 'A') {
                                    estado = '<span class="badge rounded-pill bg-success">Activo</span>';
                                } else {
                                    estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
                                }
                                $('#'+tabla).append(
                                    "<tr>"+
                                        "<td align='center'>"+parseInt(i+1)+"</td>"+
                                        "<td align='center'>"+item.tipo_contacto+"</td>"+
                                        "<td align='center'>"+item.persona_contacto+"</td>"+
                                        "<td align='center'>"+(item.tipo_telefonia ?? '-')+"</td>"+
                                        "<td align='center'>"+(item.numero_telefono ?? '-')+"</td>"+
                                        "<td align='center'>"+(item.email ?? '-')+"</td>"+
                                        "<td align='center'>"+estado+"</td>"+
                                        "<td align='center'>"+acciones+"</td>"+
                                    "</tr>"
                                );
                            });
                        }
                        $('#'+tabla).dataTable().fnDestroy();
                        $('#tbl_contactos').DataTable({
                            'paging': true,
                            //'pagingType': 'full_numbers',
                            'lengthChange': false,
                            'searching': true,
                            'ordering': false,
                            'info': false,
                            'autoWidth': false,
                            'language': {
                                'url': ('assets/js/datatables/Spanish.json')
                            }
                        });
                        $('#tbl_contactos th').removeClass('sorting_asc');
                    }
                });
            }
            /************************************************************/
            /************************************************************/
            $("#benviar").click(function() {
                if ($("#id_tipo_contacto").val() == 0) {
                    alert("Falta seleccionar el tipo de contacto");
                    $("#id_tipo_contacto").focus();
                    return false;
                }
                if ($("#persona_contacto").val() == '') {
                    alert("Falta ingresar los nombres del contacto");
                    $("#persona_contacto").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('RegistrarContactoCliente');
                $("#modulo").val('Clientes');
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/proceso-guardar.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").html("PROCESANDO...");
                    },
                    success: function(data) {
                        if (data.respuesta == 'SI') {
                            alert("El contacto se registro con exito.");
                            $("#benviar").html("REGISTRAR CONTACTO");
                            ListarContactos();
                        } else {
                            alert(data.msj_err);
                        }
                    }
                });
            });
            /**************************************************/
            /**************************************************/
            setTimeout(function(){
                ListarContactos();
            },1000);

            function EditarContacto(cod_contacto){
                alert(cod_contacto);
                OpenCloseModal('mod-contacto','o');
            }
        });
    </script>
</body>

</html>