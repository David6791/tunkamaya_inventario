<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>App Start | </title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="{{ asset('vendor/asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendor/asset/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendor/asset/css/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendor/asset/css/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendor/asset/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendor/asset/css/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendor/asset/css/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('vendor/asset/css/custom.min.css') }}" rel="stylesheet">
    <style>
        .er {
            position: relative;
            top: -12px;
        }

        .tchna tr {
            height: 10px !important;
        }

        .spinner-border-custom {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 0.2em;
            border-color: #ccc;
            border-top-color: #007bff;
        }

        input[type="text"] {
            min-width: 100px;
            padding-right: 5px;
        }
    </style>
    @livewireStyles
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella
                                Alela!</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ auth()->user() ? asset('storage/usuarios/' . auth()->user()->imagen) : 'dasd' }}"
                                alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ auth()->user() ? Auth()->user()->name : 'asdsad' }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                @canany(['aUsuarios', 'aRoles', 'aPermisos', 'aAsignacionPermisos', 'aAsignacionRoles'])
                                    <li><a><i class="fa fa-user"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            @can('aUsuarios')
                                                <li><a href="{{ route('users') }}">Lista Usuarios</a></li>
                                            @endcan
                                            @can('aRoles')
                                                <li><a href="{{ route('roles') }}">Roles</a></li>
                                            @endcan
                                            @can('aPermisos')
                                                <li><a href="{{ route('permisos') }}">Permisos</a></li>
                                            @endcan
                                            @can('aAsignacionPermisos')
                                                <li><a href="{{ route('asignar') }}">Asignacion Permisos</a></li>
                                            @endcan
                                            @can('aAsignacionRoles')
                                                <li><a href="{{ route('asignar_roles') }}">Asignacion Roles</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany
                                <li><a><i class="fa fa-edit"></i> Configuraciones <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('grupos') }}">Grupo Contable</a></li>
                                        <li><a href="{{ route('tipos') }}">Tipo Activos</a></li>
                                        <li><a href="{{ route('subtipos') }}">SubTipo Activos</a></li>
                                        <li><a href="{{ route('activos') }}">Activos</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-map-marker"></i> Localización <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('departamentos') }}">Departamentos</a></li>
                                        <li><a href="{{ route('provincias') }}">Provincias</a></li>
                                        <li><a href="{{ route('municipios') }}">Municipios</a></li>
                                        <li><a href="{{ route('localidades') }}">Localidades</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-table"></i> Infraestructura <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('instituciones') }}">Instituciones</a></li>
                                        <li><a href="{{ route('bloques') }}">Bloques</a></li>
                                        <li><a href="{{ route('areas') }}">Areas</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> RR. HH. <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('responsables') }}">Responsables</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-clone"></i>Instituciones <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                            </ul>
                        </div>


                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Cambiar de Institucion">
                            <span class="glyphicon glyphicon-cosg" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                            <span class="glyphicon glyphicon-cosg" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                            <span class="glyphicon glyphicon-cosg" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                            <span class="glyphicon glyphicon-cosg" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                    id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ auth()->user() ? asset('storage/usuarios/' . auth()->user()->imagen) : 'asdasdsa' }}"
                                        alt="">{{ auth()->user() ? Auth()->user()->name : 'asdsad' }}
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}"> Perfil</a>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="dropdown-item">
                                        Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="" id="navbarDropdown1" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-institution"></i> {{ session('nombre_institucion') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->
                {{ $slot }}
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('vendor/asset/js/plugins/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendor/asset/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendor/asset/js/plugins/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendor/asset/js/plugins/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('vendor/asset/js/plugins/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('vendor/asset/js/plugins/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendor/asset/js/plugins/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('vendor/asset/js/plugins/custom.min.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        function Noty(msg, option = 1) {
            Snackbar.show({
                text: msg.toUpperCase(),
                actionText: 'CERRAR',
                actionTextColor: '#fff',
                backgroundColor: option == 1 ? '#3b3f5c' : '$e7515a',
                pos: 'top-right'
            });
        }
    </script>
    @livewireScripts
</body>

</html>
