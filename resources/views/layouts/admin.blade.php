<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('/css/template/bootadmin.css')}}">

    <title>MGR Techno</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
    <a class="navbar-brand" href="#">MGR Techno</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <!--<li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-envelope"></i> 5</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-bell"></i> 3</a></li>
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Doe</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </li>-->
        </ul>
    </div>
</nav>

<div class="d-flex">
    <div class="sidebar sidebar-dark bg-dark">
        <ul class="list-unstyled">
            <li><a href="/admin/inicio"><i class="fas fa-chart-line"></i> Menu Item</a></li>
            <li>
                <a href="#sm_expand_1" data-toggle="collapse">
                    <i class="fas fa-archive"></i> Gestionar stock
                </a>
                <ul id="sm_expand_1" class="list-unstyled collapse">
                    <li><a href="/admin/stock">Alta</a></li>
                    <li><a href="#">Submenu Item</a></li>
                </ul>
            </li>
            <li><a href="/admin/productos"><i class="fas fa-hdd"></i> Gestionar productos</a></li>
            <li><a href="/admin/proveedores"><i class="fas fa-users"></i> Gestionar proveedores</a></li>
            <li><a href="#"><i class="fab fa-instagram"></i> Menu Item</a></li>
        </ul>
    </div>

    <div class="content p-4">

        <div class="card mb-4" id="app">
            @yield('main-content')
        </div>
    </div>
</div>

<script src="{{mix('js/app.js')}}"></script>
<script src="/js/bootadmin.js"></script>

</body>
</html>

