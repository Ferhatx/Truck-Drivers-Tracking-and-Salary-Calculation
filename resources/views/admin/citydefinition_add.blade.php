@extends('layouts.admin')

@section('title', 'ERP')

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Puantaj Sefer Şehir Listesi Ekle</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Puantaj Sefer Şehir Listesi Ekle</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- general form elements disabled -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Puantaj Sefer Şehir Listesi Ekle</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{route('admin_citydefinition_store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Çıkış İli</label>
                                <select name="cikis_iller" id="Iller" class="form-control">
                                    <option value="0">Lütfen Çıkış İlini Seçiniz.</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Çıkış İlçesi</label>
                                <select name="cikis_ilcesi" id="Ilceler" disabled="disabled" class="form-control">
                                    <option value="0">Lütfen Önce Çıkış İlini Seçiniz.</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Varış İli</label>
                                <select name="varis_iller" id="varis_Iller" class="form-control">
                                    <option value="0">Lütfen Varış İlini Seçiniz.</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Varış İlçesi</label>
                                <select name="varis_ilcesi" id="varis_Ilceler" disabled="disabled" class="form-control">
                                    <option value="0">Lütfen Önce Çıkış İlini Seçiniz.</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sefer Harcırah Ücreti</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₺</span>
                                    </div>
                                    <input type="text" name="sefer_harcirah" required class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Ekle</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/admin/dist/js/adminlte.min.js"></script>
    <script src="{{ asset('assets') }}/admin/js/cikis.js"></script>
    <script src="{{ asset('assets') }}/admin/js/varis.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/toastr/toastr.min.js"></script>
    <script>
        @if(Session::has('message'))
        var type="{{Session::get('alert-type','info')}}"
        toastr.options={
            "progressBar":true,
            "closeButton":true,
        }
        switch(type){
            case 'info':
                toastr.info("{{Session::get('message')}}");
                break;
            case 'success':
                toastr.success("{{Session::get('message')}}");
                break;
            case 'error':
                toastr.error("{{Session::get('message')}}");
                break;
            case 'warning':
                toastr.warning("{{Session::get('message')}}");
                break;
        }
        @endif
    </script>

@endsection()

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/toastr/toastr.min.css">
@endsection
