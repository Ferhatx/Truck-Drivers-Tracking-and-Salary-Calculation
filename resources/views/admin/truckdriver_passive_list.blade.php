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
                        <h1>Ayrılan Şoför Listesi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Ayrılan Şoför Listesi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    @include('admin.message')
    <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <!-- general form elements disabled -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Ayrılan Şoför Listesi</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Telefon</th>
                            <th>Doğum Tarihi</th>
                            <th>T.C Kimlik No</th>
                            <th>İşe Ayrılma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datalist as $rs)
                            <tr>
                                <td>{{$rs->id}}</td>
                                <td>{{$rs->ad}}</td>
                                <td>{{$rs->soyad}}</td>
                                <td>{{$rs->telefon}}</td>
                                <td>{{$rs->dogum_tarihi}}</td>
                                <td>{{$rs->tc_no}}</td>
                                <td>{{$rs->isten_ayrilma_tarihi}}</td>
                                <td>
                                    <a title="Aktif" href="{{route('admin_truckdriver_active',['id'=>$rs->id,'ad'=>$rs->ad,'soyad'=>$rs->soyad,'tc_no'=>$rs->tc_no,'dogum_tarihi'=>$rs->dogum_tarihi])}}" class="btn btn-sm btn-success"><i class='fa fa-user-check'></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Telefon</th>
                            <th>Doğum Tarihi</th>
                            <th>T.C Kimlik No</th>
                            <th>İşe Ayrılma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                        </tfoot>
                    </table>
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
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy","excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

@endsection()

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
