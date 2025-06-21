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
                        <h1>Şoförler Listesi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Şoförler</li>
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
                <a href="{{route('admin_truckdriver_add')}}" class="btn btn-success"><i class="fa fa-plus-circle mr-1"></i>Şoför Ekle</a>
                </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Şoför Listesi</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>İşe Başlama Tarihi</th>
                            <th>Telefon</th>
                            <th>Doğum Tarihi</th>
                            <th>T.C Kimlik No</th>
                            <th>Yıllık İzin Süresi</th>
                            <th>Maaş</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datalist as $rs)
                        <tr>
                            <td>{{$rs->id}}</td>
                            <td>{{$rs->ad}}</td>
                            <td>{{$rs->soyad}}</td>
                            <td>{{$rs->start_date}}</td>
                            <td>{{$rs->telefon}}</td>
                            <td>{{$rs->dogum_tarihi}}</td>
                            <td>{{$rs->tc_no}}</td>
                            <td>{{$rs->yillik_izin_hakedis}}</td>
                            <td>{{$rs->maas}}</td>
                            <td>
                               <!-- <a href="" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a>-->
                                <a title="Düzenle" href="{{route('admin_truckdriver_edit',['id'=>$rs->id])}}" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <a title="Puantaj" href="{{route('admin_truckdriver_show',['id'=>$rs->id])}}" class="btn btn-sm btn-primary"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                               <a title="Pasif" href="{{route('admin_truckdriver_update',['id'=>$rs->id,'ad'=>$rs->ad,'soyad'=>$rs->soyad,'tc_no'=>$rs->tc_no])}}" class="btn btn-sm btn-info" onclick="return confirm('Şoförü Pasif İstediğinizden Emin Misiniz?')"><i class="fa fa-user-lock"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>İşe Başlama Tarihi</th>
                            <th>Telefon</th>
                            <th>Doğum Tarihi</th>
                            <th>T.C Kimlik No</th>
                            <th>Yıllık İzin Süresi</th>
                            <th>Maaş</th>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy","excel", "pdf", "print"],
                columnDefs: [
                    { type: 'turkish', targets: '_all' }
                ],
                language: {
                    info: "_TOTAL_ kayıttan _START_ - _END_ kayıt gösteriliyor.",
                    infoEmpty:      "Gösterilecek hiç kayıt yok.",
                    loadingRecords: "Kayıtlar yükleniyor.",
                    lengthMenu: "Sayfada _MENU_ kayıt göster",
                    zeroRecords: "Tablo boş",
                    search: "Arama:",
                    infoFiltered:   "(toplam _MAX_ kayıttan filtrelenenler)",
                    buttons: {
                        copyTitle: "Panoya kopyalandı.",
                        copySuccess:"Panoya %d satır kopyalandı",
                        copy: "Kopyala",
                        print: "Yazdır",
                    },

                    paginate: {
                        first: "İlk",
                        previous: "Önceki",
                        next: "Sonraki",
                        last: "Son"
                    },
                }
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
