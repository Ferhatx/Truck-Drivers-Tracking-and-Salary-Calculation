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
                        <h1>Puantaj Sefer Şehir Listesi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Puantaj Sefer Şehir Listesi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <!-- general form elements disabled -->
            <div class="d-flex justify-content-end mb-2">
                <a href="{{route('admin_citydefinition_add')}}" class="btn btn-success"><i class="fa fa-plus-circle mr-1"></i>Sefer Şehri Ekle</a>
            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Puantaj Sefer Şehir Listesi</h3>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Çıkış İli </th>
                                <th>Çıkış İlçesi</th>
                                <th>Varış İli</th>
                                <th>Varış İlçesi</th>
                                <th>Sefer Harcırah Ücreti</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>@php $i=1; @endphp
                            @foreach($datalist as $rs)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$rs->cikis_il}}</td>
                                <td>{{$rs->cikis_ilce}}</td>
                                <td>{{$rs->varis_il}}</td>
                                <td>{{$rs->varis_ilce}}</td>
                                <td>{{$rs->sefer_harcirah}} ₺</td>
                                <td><a title="Sil" href="{{route('admin_citydefinition_delete',['id'=>$rs->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>





                <div class="card-footer">
                </div>

                <!-- /.card-body -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

    <script src="{{ asset('assets') }}/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables/datatables.turkish.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/admin/dist/js/adminlte.min.js"></script>
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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/toastr/toastr.min.css">
@endsection
