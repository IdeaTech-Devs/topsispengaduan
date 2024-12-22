<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Pengaduan Satgas UNIB</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles for admin -->
    <link href="{{asset('assets/css/admin.css')}}" rel="stylesheet">
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{asset('assets/img/logo.png')}}" alt="Logo" style="width: 40px; height: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Proses Tindak Lanjut
            </div>

            <!-- Nav Item - Kasus Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKasus">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Status Kasus</span>
                </a>
                <div id="collapseKasus" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->routeIs('admin.tindak_lanjut.belum_selesai') ? 'active' : '' }}" 
                           href="{{ route('admin.tindak_lanjut.belum_selesai') }}">Kasus Belum Selesai</a>
                        <a class="collapse-item {{ request()->routeIs('admin.tindak_lanjut.selesai') ? 'active' : '' }}" 
                           href="{{ route('admin.tindak_lanjut.selesai') }}">Kasus Selesai</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Sistem
            </div>

            <!-- Nav Item - Data Master Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster"
                    aria-expanded="true" aria-controls="collapseDataMaster">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseDataMaster" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Data:</h6>
                        <a class="collapse-item {{ request()->routeIs('admin.satgas.*') ? 'active' : '' }}" 
                           href="{{ route('admin.satgas.index') }}">
                            <i class="fas fa-user-shield fa-fw mr-2"></i>Satgas
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.kemahasiswaan.*') ? 'active' : '' }}" 
                           href="{{ route('admin.kemahasiswaan.index') }}">
                            <i class="fas fa-users fa-fw mr-2"></i>Kemahasiswaan
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user fa-fw mr-2"></i>Users
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.pelapor.*') ? 'active' : '' }}" 
                           href="{{ route('admin.pelapor.index') }}">
                            <i class="fas fa-user-edit fa-fw mr-2"></i>Pelapor
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.kasus.*') ? 'active' : '' }}" 
                           href="{{ route('admin.kasus.index') }}">
                            <i class="fas fa-folder fa-fw mr-2"></i>Kasus
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.kasus_satgas.*') ? 'active' : '' }}" 
                           href="{{ route('admin.kasus_satgas.index') }}">
                            <i class="fas fa-tasks fa-fw mr-2"></i>Kasus Satgas
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.management.*') ? 'active' : '' }}" 
                            href="{{ route('admin.management.index') }}">
                             <i class="fas fa-user-shield fa-fw mr-2"></i>Kelola Admin
                        </a>
                        <a class="collapse-item {{ request()->routeIs('admin.topsis.*') ? 'active' : '' }}" 
                           href="{{ route('admin.topsis.index') }}">
                            <i class="fas fa-calculator fa-fw mr-2"></i>Kriteria TOPSIS
                        </a>
                        
                    </div>
                </div>
            </li>

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

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    @if(isset($admin) && $admin->nama)
                                        {{ $admin->nama }}
                                    @else
                                        {{ Auth::user()->email }}
                                    @endif
                                </span>
                                <img class="img-profile rounded-circle" 
                                     src="@if(isset($admin) && $admin->foto_profil)
                                            {{ asset('storage/'.$admin->foto_profil) }}
                                         @else
                                            {{ asset('assets/img/undraw_profile.svg') }}
                                         @endif"
                                     alt="Profile"
                                     style="width: 48px; height: 48px; object-fit: cover;">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profil') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title', 'Dashboard')</h1> <!-- Judul dinamis -->
                    </div>
                    @yield('content')
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Universitas Bengkulu 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script>

    <!-- Custom scripts for admin -->
    <script src="{{asset('assets/js/admin.js')}}"></script>

</body>

</html>