<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin_home')}}" class="brand-link">
        <img src="{{ asset('assets') }}/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@yield('title')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets') }}/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                @auth
                    <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                @endauth
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Arama" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <ion-icon name="people-sharp" size="small"></ion-icon>
                        <p>
                            Personel Kartı
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_truckdriver')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Şoförler</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin_truckdriver_passive')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pasif Şoförler</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin_scorecard')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Yıllık izin Listesi</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-user-clock"></i>
                        <p>
                            Clock Cards
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>


                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_scorecard_add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clock Add</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_scorecard')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Total  Clock Card List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-cog"></i>
                        <p>
                            Tanımlamalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_tanimlamalar')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Genel Tanımlamalar</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_citydefinition')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Puantaj Şehri Tanımlama</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item fixed-bottom">
                    <a href="{{route('logout')}}" class="nav-link">
                        <i class="fa fa-power-off"></i>
                        <p>
                            Çıkış
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
