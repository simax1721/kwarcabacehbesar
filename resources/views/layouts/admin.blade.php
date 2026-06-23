
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/b69e31cf66.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ url('adminvendor/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('adminvendor/vendor/toastr/toastr.min.css') }}">

    <!-- Favicon -->
    <link href="mamba/assets/img/logombky2.png" rel="icon">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

    <style>
        #map { height: 600px; }
    </style>

    @stack('css')
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #004C3F">

         <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <img style="width: 60px" class="" src="{{ url('SIG-PUTIH.png') }}" alt="">
            </div>
            {{-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> --}}
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">
        
        @if (Auth::guard('admin')->check())
        <div class="sidebar-heading">DASHBOARD</div>
            <li class="nav-item ">
            <a class="nav-link pb-2" href="{{ url('/admin/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li>
            
            {{-- <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/profile') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>PROFILE</span></a>
            </li> --}}
            
            <hr class="sidebar-divider">
            <div class="sidebar-heading">DATA KWARCAB</div>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/admin/data/kegiatan') }}">
                    <i class="fas fa-fw fa-newslater"></i>
                    <span>Data Kegiatan</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/admin/data/ranting') }}">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Data Ranting</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/admin/data/gudep') }}">
                    <i class="fas fa-fw fa-map-marked-alt"></i>
                    <span>Data Gugus Depan</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/admin/data/user') }}">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Data User</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pendaftaran</div>
        @else 
        
            <div class="sidebar-heading">DASHBOARD</div>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">DATA KWARCAB</div>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/user/data/gudep') }}">
                    <i class="fas fa-fw fa-map-marked-alt"></i>
                    <span>Data Gugus Depan</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pendaftaran</div>
            <li class="nav-item ">
                <a class="nav-link pb-2" href="{{ url('/user/pendaftaran') }}">
                    <i class="fas fa-fw fa-user-tag"></i>
                    <span>Partisipan Kegiatan</span>
                </a>
            </li>



        @endif
        

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

              <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                  

                  <div class="topbar-divider d-none d-sm-block"></div>

                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown no-arrow">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         @if (Auth::guard('admin')->check())
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ Auth::guard('admin')->user()->name }}
                            </span>

                            <figure class="img-profile rounded-circle avatar font-weight-bold"
                                data-initial="{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}"
                                style="background-color: #004C3F">
                            </figure>
                         @endif
                         
                         @if (Auth::guard('web')->check())
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ Auth::user()->name }}
                            </span>

                            <figure class="img-profile rounded-circle avatar font-weight-bold"
                                data-initial="{{ substr(Auth::user()->name, 0, 1) }}"
                                style="background-color: #004C3F">
                            </figure>
                         @endif
                         
                      </a>
                      <!-- Dropdown - User Information -->
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="#">
                              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Profile') }}
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Logout') }}
                          </a>
                      </div>
                  </li>

              </ul>

          </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

                @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success border-left-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; simax1721 2023 - {{ now()->year }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ url('adminvendor/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('adminvendor/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('adminvendor/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ url('adminvendor/js/sb-admin-2.min.js') }}"></script>
<script src="{{ url('adminvendor/vendor/toastr/toastr.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ url('adminvendor/vendor/ckeditor/ckeditor.js') }}"></script>

@stack('scripts')
</body>
</html>
