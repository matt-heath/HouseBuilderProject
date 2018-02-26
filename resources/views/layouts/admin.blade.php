<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> {{--looks for app.css--}}

    <link href="{{asset('css/libs.css')}}" rel="stylesheet"> {{--looks for minified libs.css--}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" />

    <style>
        body {
            font-family: 'Raleway', sans-serif !important;
        }
    </style>

</head>

<body id="admin-page">

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">House Building Portal</a>
        </div>
        <!-- /.navbar-header -->



        <ul class="nav navbar-top-links navbar-right">

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user" style="height:100px !important">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                    {{--<li class="divider"></li>--}}
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->


        </ul>


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    @if(Auth::user()->isAdmin())

                        <li>
                            <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.users.index')}}">All Users</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.users.create')}}">Create User</a>
                                </li>
                                <li>
                                    <a href="#">Users By Role <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{route('admin.viewuserbyrole', ['id' => 1])}}">Administrators</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.viewuserbyrole', ['id' => 2])}}">Estate Agents</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.viewuserbyrole', ['id' => 3])}}">Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.viewuserbyrole', ['id' => 4])}}">Buyers</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.viewuserbyrole', ['id' => 5])}}">External Consultants</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-home fa-fw"></i> Developments<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.developments.index')}}">All Developments</a>
                                </li>

                                <li>
                                    <a href="{{route('admin.developments.create')}}">Create a Development</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>


                        <li>
                            <a href="#"><i class="fa fa-map-marker fa-fw"></i> Plots<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.plots.index')}}">All Plots</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.plots.create')}}">Add Plots to development</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.consultants.index')}}">Assign Consultant to phase in development</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>


                        <li>
                            <a href="#"><i class="fa fa-building fa-fw"></i>House Types<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.housetypes.index')}}">All House Types</a>
                                </li>

                                <li>
                                    <a href="{{route('admin.housetypes.create')}}">Create House Types</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-certificate fa-fw"></i>Certificate Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.certificates.index')}}">All Certificates</a>
                                </li>
                                {{--<li>--}}
                                    {{--<a href="{{route('admin.certificates.create')}}">Create Required Certificates</a>--}}
                                {{--</li>--}}
                                <li>
                                    <a href="#">Certificate Categories <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{route('admin.certificatecategories.index')}}">All Categories</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.certificatecategories.create')}}">Create Categories</a>
                                        </li>
                                    </ul>
                                </li>

                                {{--<li>--}}
                                    {{--<a href="{{route('admin.housetypes.create')}}">Create House Types</a>--}}
                                {{--</li>--}}

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-building fa-fw"></i>Bookings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.booking.index')}}">All Bookings</a>
                                </li>

                                {{--<li>--}}
                                    {{--<a href="{{route('admin.housetypes.create')}}">Create House Types</a>--}}
                                {{--</li>--}}

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    @elseif (Auth::user()->isEstateAgent())
                        <li>
                            <a href="/estateagent"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('estateagent.users.index')}}">All Users</a>
                                </li>

                                <li>
                                    <a href="{{route('estateagent.users.create')}}">Create User</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-home fa-fw"></i> Developments<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('estateagent.developments.index')}}">All Developments</a>
                                </li>
                                <li>
                                    {{--<a href="{{route('estateagent.booking.create')}}">Booking Form</a>--}}
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-home fa-fw"></i> Bookings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('estateagent.booking.index')}}">All Bookings</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-envelope fa-fw"></i> Messages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="">All Chats</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    @elseif(Auth::user()->isExternalConsultant())

                        <li>
                            <a href="/estateagent"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-map-marker fa-fw"></i> Plots<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('externalconsultant.plots.index')}}">All Plots</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    @endif



                    {{--<li>--}}
                    {{--<a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>--}}
                    {{--<ul class="nav nav-second-level">--}}
                    {{--<li>--}}
                    {{--<a href="panels-wells.html">Panels and Wells</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="buttons.html">Buttons</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="notifications.html">Notifications</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="typography.html">Typography</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="icons.html"> Icons</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="grid.html">Grid</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.nav-second-level -->--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>--}}
                    {{--<ul class="nav nav-second-level">--}}
                    {{--<li>--}}
                    {{--<a href="#">Second Level Item</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="#">Second Level Item</a>--}}
                    {{--</li>--}}

                    {{--<li class="active">--}}
                    {{--<a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>--}}
                    {{--<ul class="nav nav-second-level">--}}
                    {{--<li>--}}
                    {{--<a class="active" href="blank.html">Blank Page</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="login.html">Login Page</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.nav-second-level -->--}}
                    {{--</li>--}}
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>





    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            {{--<ul class="nav" id="side-menu">--}}
            {{--<li>--}}
            {{--<a href="/profile"><i class="fa fa-dashboard fa-fw"></i>Profile</a>--}}
            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="#"><i class="fa fa-wrench fa-fw"></i> Posts<span class="fa arrow"></span></a>--}}
            {{--<ul class="nav nav-second-level">--}}
            {{--<li>--}}
            {{--<a href="">All Posts</a>--}}
            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="">Create Post</a>--}}
            {{--</li>--}}

            {{--</ul>--}}
            {{--<!-- /.nav-second-level -->--}}
            {{--</li>--}}

            {{--</ul>--}}
        </div>
    </div>
</div>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        @yield('title')
        <hr>
        <div class="row">

            <div class="col-lg-12">
                

                @yield('content')
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{asset('js/libs.js')}}"></script>
@include('includes.alerts')
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>


@yield('script')

@yield('footer')

</body>

</html>
