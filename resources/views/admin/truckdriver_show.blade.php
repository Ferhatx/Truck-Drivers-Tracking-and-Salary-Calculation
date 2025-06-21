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
                        <h1>Şoför Detay ve Puantajlar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Şoför Detay ve Puantajlar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    @include('admin.message')
        <!-- Main content -->
        <section class="content">
            <!-- general form elements disabled -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Şoför Bilgileri</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{route('admin_truckdriver_shows')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                @foreach($datalist as $rs)
                                    <h3 class="profile-username text-center">{{$rs->ad}} {{$rs->soyad}}</h3>
                                    <p class="text-muted text-center">{{$rs->departman}}</p>
                                        <input type="hidden" name="id_s" value="{{$rs->id}}"/>


                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Adres </strong>

                                    <p class="text-muted">{{$rs->adres}}</p>

                                    <hr>

                                    <strong><i class="fa fa-phone"></i>  Telefon Numarası </strong>

                                    <p class="text-muted">+90 {{$rs->telefon}}</p>

                                    <hr>

                                    <strong><i class="fa fa-wallet mr-1"></i> Maaş </strong>

                                    <p class="text-muted">{{$rs->maas}}</p>

                                    <hr>

                                    <strong><i class="fa fa-calendar-check"></i> Yıllık İzin </strong>

                                    <p class="text-muted">
                                        <span class="tag tag-danger">{{$rs->yillik_izin_hakedis}}</span>
                                    </p>

                                    <hr>

                                        <strong><i class="fa fa-hourglass-start"></i> Kıdem Süresi </strong>

                                        <p class="text-muted">
                                            <span class="tag tag-danger">
                                            @php
                                                $bugun = new DateTime();
                                                $cikarilanTarih = new DateTime($rs->start_date);
                                                $fark = $bugun->diff($cikarilanTarih);
                                                echo $fark->y . " yıl " . $fark->m . " ay " . $fark->d . " gün";
                                            @endphp



                                            </span>
                                        </p>

                                        <hr>

                                    <strong><i class="fa fa-user"></i> Durumu </strong>

                                    <p class="text-success" >{{$rs->status}} </p>

                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>


                    @include('admin.message')
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Puantaj Listesi</a></li>
                                </ul>
                                <ul class="nav justify-content-end">
                                    <li class="nav-item"><a href="{{route('admin_truckdriver_yazdir',['prnt_id'=>$prnt_id,'prnt_ay'=>$prnt_ay,'prnt_yil'=>$prnt_yil])}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Yazdır</a></li>
                                </ul>






                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <!-- Post -->
                                        <div class="post">
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="form-group">
                                                                <label>Puantaj Yıl</label>
                                                                <select name="pntj_yil" id="pntj_yil" class="form-control">
                                                                    <option value="">Yıl Seçiniz</option>
                                                                    @php  for ($i=2024;$i<=2050;$i++)
															{
														  echo   "<option value=$i>$i</option>";
															}
                                                                    @endphp
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="form-group">
                                                                <label>Puantaj Ay</label>
                                                                <select name="pntj_ay" id="pntj_ay" class="form-control">
                                                                    <option value="">Ay Seçiniz</option>
                                                                    <option value="1">Ocak</option>
                                                                    <option value="2">Şubat</option>
                                                                    <option value="3">Mart</option>
                                                                    <option value="4">Nisan</option>
                                                                    <option value="5">Mayıs</option>
                                                                    <option value="6">Haziran</option>
                                                                    <option value="7">Temmuz</option>
                                                                    <option value="8">Ağustos</option>
                                                                    <option value="9">Eylül</option>
                                                                    <option value="10">Elim</option>
                                                                    <option value="11">Kasım</option>
                                                                    <option value="12">Aralık</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="form-group">
                                                                <label>İşlem</label>
                                                                <input type="submit" value="Puantaj Göster" class="btn btn-warning"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Giriş Tarihi</th>
                                                    <th>Giriş Saati</th>
                                                    <th>Çıkış Saati</th>
                                                    <th>Çıkış Tarihi</th>
                                                    <th>Çalıştığı Süre</th>
                                                    <th>Mola Saati</th>
                                                    <th>Sefer Sayısı</th>
                                                    <th>Açıklama</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($datalist2 as $rs2)
                                                    @if($rs2->calisma_durumu==="mazaret_izini")
                                                     <tr>
                                                         <td colspan="7" style="color:#f37749;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Mazaret İzni</td>
                                                         <td>{{$rs2->aciklama}}</td>
                                                         <td><a title="Sil" href="{{route('admin_scorecard_delete',['id'=>$rs2->id,'id2'=>$rs2->sub_id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Silmek İstediğinizden Emin Misiniz?')"><i class="fas fa-trash"></i></a></td>
                                                     </tr>
                                                    @elseif($rs2->calisma_durumu==="raporlu")
                                                        <tr>
                                                            <td colspan="7" style="color:#10a5cb;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Raporlu </td>
                                                            <td>{{$rs2->aciklama}}</td>
                                                            <td><a title="Sil" href="{{route('admin_scorecard_delete',['id'=>$rs2->id,'id2'=>$rs2->sub_id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Silmek İstediğinizden Emin Misiniz?')"><i class="fas fa-trash"></i></a></td>
                                                        </tr>
                                                    @elseif($rs2->calisma_durumu==="hafta_tatil" && $rs2->saat_farki==="00:00")
                                                        <tr>
                                                            <td colspan="7" style="color:#6767f3;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Haftalık Tatil </td>
                                                            <td>{{$rs2->aciklama}}</td>
                                                            <td><a title="Sil" href="{{route('admin_scorecard_delete',['id'=>$rs2->id,'id2'=>$rs2->sub_id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Silmek İstediğinizden Emin Misiniz?')"><i class="fas fa-trash"></i></a></td>
                                                        </tr>
                                                    @elseif($rs2->calisma_durumu==="yillik_izni")
                                                        <tr>
                                                            <td colspan="7" style="color:#008080;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Yıllık İzinde </td>
                                                            <td>{{$rs2->aciklama}}</td>
                                                            <td><a title="Sil" href="{{route('admin_scorecard_delete',['id'=>$rs2->id,'id2'=>$rs2->sub_id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Silmek İstediğinizden Emin Misiniz?')"><i class="fas fa-trash"></i></a></td>
                                                        </tr>
                                                    @else
                                                    <tr>
                                                        <td>{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}}</td>
                                                        <td>{{$rs2->giris_saati}}</td>
                                                        <td>{{$rs2->cikis_saati}}</td>
                                                        <td>{{$rs2->cikis_gun}}/{{$rs2->cikis_ay}}/{{$rs2->cikis_yil}}</td>
                                                        <td>{{$rs2->saat_farki}}</td>
                                                        <td>{{$rs2->mola_saati}}</td>
                                                        <td>{{$rs2->sefer_sayisi}}</td>
                                                        <td>{{$rs2->aciklama}}</td>
                                                        <td><a title="Sil" href="{{route('admin_scorecard_delete',['id'=>$rs2->id,'id2'=>$rs2->sub_id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Silmek İstediğinizden Emin Misiniz?')"><i class="fas fa-trash"></i></a></td>
                                                    </tr>
                                                     @endif
                                                @endforeach
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th>Giriş Tarihi</th>
                                                    <th>Giriş Saati</th>
                                                    <th>Çıkış Saati</th>
                                                    <th>Çıkış Tarihi</th>
                                                    <th>Çalıştığı Süre</th>
                                                    <th>Mola Saati</th>
                                                    <th>Sefer Sayısı</th>
                                                    <th>Açıklama</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                                </tfoot>
                                            </table>


                                            <!-- HESAP KİTAP OLDUĞU BÖLÜM-->
                                            <div class="invoice p-3 mb-3">
                                                <div class="row">
                                                    <!-- accepted payments column -->
                                                    <div class="col-6">
                                                        <p class="lead"><br/></p>
                                                        <div class="table-responsive">
                                                            <table class="table">

                                                                <tr>
                                                                    <th style="width:50%">Aylık Çalışması Gereken Saat :</th>

                                                                    <td>
                                                                        {{$aylik_saat}}:@php if($aylik_dakika==0){
                                                                            echo "00";
                                                                        }else{ echo $aylik_dakika;
                                                                        }@endphp
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Aylık Çalışılan Saat :</th>
                                                                    <td>
                                                                        @php if(empty($datalist3)){
                                                                                echo "00:00";
                                                                            }else{
                                                                            echo $datalist3;
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Aylık Çalışılan Sefer Sayısı:</th>
                                                                    <td>{{$dtlst12}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Fazla Çalışma :</th>
                                                                    <td>
                                                                        @php
                                                                            if ($ekstra_kazanc_ekran==0){
                                                                                 echo '00:00';
                                                                                }else{
                                                                                    $ekstra_kazanc_ekran_saat= floor($ekstra_kazanc_ekran);
                                                                                    $ekstra_kazanc_ekran_dakika=round(($ekstra_kazanc_ekran-$ekstra_kazanc_ekran_saat)*60);
                                                                                    echo $ekstra_kazanc_ekran_saat.":".$ekstra_kazanc_ekran_dakika;
                                                                                }

                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>


                                                    <!-- /.col -->
                                                    <div class="col-6">
                                                        <p class="lead"><br/></p>
                                                        <div class="table-responsive">
                                                            <table class="table">

                                                                <tr>
                                                                    <th style="width:50%">Aylık Saatlik Kazancı :</th>
                                                                    <td>{{$dtlst11}} ₺</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Aylık Sefer Kazancı :</th>
                                                                    <td>{{$total_sefer_kazanc}} ₺</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Fazla Çalışma Kazancı :</th>
                                                                    <td>{{$fazla_ekstra_kazanc}} ₺</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Aylık Toplam Kazanç :</th>
                                                                    <td>{{$aylik_total_kazanc}} ₺</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <!-- HESAP KİTAP OLDUĞU BÖLÜM  BİTİŞ-->





                                        </div>
                                        <!-- /.post -->


                                    </div>





                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

@endsection
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
