<!doctype html>
<html lang="en">

<head>

    <?php require("config/cabecera-web.php"); ?>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

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

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- ===================   CABECERA APP  ========================== -->
        <!-- ============================================================== -->
        <?php require("config/cabecera.php"); ?>
        <!-- ============================================================== -->
        <!-- ===================        MENU APP   ======================== -->
        <!-- ============================================================== -->
        <?php require("config/barra-navegacion.php"); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Listado de Registros</h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="formulario-modal.php" data-sb-backdrop="static" data-sb-keyboard="false">
                                            Registrar <i class="ri-arrow-right-line align-middle ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btn-success waves-effect waves-light">
                                            <i class="ri-check-line align-middle me-2"></i> Success
                                        </button>
                                        <button type="button" class="btn btn-warning waves-effect waves-light">
                                            <i class="ri-error-warning-line align-middle me-2"></i> Warning
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light">
                                            <i class="ri-close-line align-middle me-2"></i> Danger
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <th>Salary</th>
                                                <th>Estado</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <tr>
                                                <td>Tiger Nixon</td>
                                                <td>System Architect</td>
                                                <td>Edinburgh</td>
                                                <td>61</td>
                                                <td>2011/04/25</td>
                                                <td>$320,800</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Garrett Winters</td>
                                                <td>Accountant</td>
                                                <td>Tokyo</td>
                                                <td>63</td>
                                                <td>2011/07/25</td>
                                                <td>$170,750</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ashton Cox</td>
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>66</td>
                                                <td>2009/01/12</td>
                                                <td>$86,000</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cedric Kelly</td>
                                                <td>Senior Javascript Developer</td>
                                                <td>Edinburgh</td>
                                                <td>22</td>
                                                <td>2012/03/29</td>
                                                <td>$433,060</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Airi Satou</td>
                                                <td>Accountant</td>
                                                <td>Tokyo</td>
                                                <td>33</td>
                                                <td>2008/11/28</td>
                                                <td>$162,700</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Brielle Williamson</td>
                                                <td>Integration Specialist</td>
                                                <td>New York</td>
                                                <td>61</td>
                                                <td>2012/12/02</td>
                                                <td>$372,000</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Herrod Chandler</td>
                                                <td>Sales Assistant</td>
                                                <td>San Francisco</td>
                                                <td>59</td>
                                                <td>2012/08/06</td>
                                                <td>$137,500</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rhona Davidson</td>
                                                <td>Integration Specialist</td>
                                                <td>Tokyo</td>
                                                <td>55</td>
                                                <td>2010/10/14</td>
                                                <td>$327,900</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Colleen Hurst</td>
                                                <td>Javascript Developer</td>
                                                <td>San Francisco</td>
                                                <td>39</td>
                                                <td>2009/09/15</td>
                                                <td>$205,500</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sonya Frost</td>
                                                <td>Software Engineer</td>
                                                <td>Edinburgh</td>
                                                <td>23</td>
                                                <td>2008/12/13</td>
                                                <td>$103,600</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jena Gaines</td>
                                                <td>Office Manager</td>
                                                <td>London</td>
                                                <td>30</td>
                                                <td>2008/12/19</td>
                                                <td>$90,560</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Quinn Flynn</td>
                                                <td>Support Lead</td>
                                                <td>Edinburgh</td>
                                                <td>22</td>
                                                <td>2013/03/03</td>
                                                <td>$342,000</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Charde Marshall</td>
                                                <td>Regional Director</td>
                                                <td>San Francisco</td>
                                                <td>36</td>
                                                <td>2008/10/16</td>
                                                <td>$470,600</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Haley Kennedy</td>
                                                <td>Senior Marketing Designer</td>
                                                <td>London</td>
                                                <td>43</td>
                                                <td>2012/12/18</td>
                                                <td>$313,500</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tatyana Fitzpatrick</td>
                                                <td>Regional Director</td>
                                                <td>London</td>
                                                <td>19</td>
                                                <td>2010/03/17</td>
                                                <td>$385,750</td>
                                                <td><span class="badge rounded-pill bg-success">Activo</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ri-edit-fill align-middle"></i></a>
                                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="ri-delete-bin-fill align-middle"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- ============================================================== -->
            <!-- ===================   PIEPAGINA APP ========================== -->
            <!-- ============================================================== -->
            <?php require("config/piepagina.php"); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Extra Large Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script>
        $(function() {
            var remoto_href = '';
            jQuery('body').on('click', '[data-bs-toggle="modal"]', function() {
                if (remoto_href != jQuery(this).data("remote")) {
                    remoto_href = jQuery(this).data("remote");
                    jQuery(jQuery(this).data("bs-target")).find('.modal-body').empty();
                    jQuery(jQuery(this).data("bs-target") + ' .modal-body').load(remoto_href);
                    //$("#bs-example-modal-xl .modal-body").load(remoto_href);
                }
                return false
            });
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>