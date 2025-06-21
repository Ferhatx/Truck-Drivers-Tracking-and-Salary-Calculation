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
                        <h1>Tanımlamalar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Tanımlamalar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><a href="{{route('admin_tanimlamalar_add')}}" class="btn btn-block btn-success">Ekle</a></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>İşlemler</th>
                                    <th>Yıl</th>
                                    <th>Asgari Ücret 1. Dönem</th>
                                    <th>Asgari Ücret 2. Dönem</th>
                                    <th>Yılbaşı Tatili</th>
                                    <th>Ramazan Bayramı Arefe</th>
                                    <th>Ramazan Bayramı</th>
                                    <th>Kurban Bayramı Arefe</th>
                                    <th>Kurban Bayramı</th>
                                    <th>23 Nisan</th>
                                    <th>İşçi Bayramı</th>
                                    <th>19 Mayıs</th>
                                    <th>15 Temmuz</th>
                                    <th>30 Ağustos</th>
                                    <th>29 Ekim</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datalist as $rs)
                                <tr>
                                    <td><a title="Sil" href="{{route('admin_tanimlamalar_delete',['yil'=>$rs->yil])}}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                                    <td>{{$rs->yil}}</td>
                                    <td>{{$rs->asgari_ucret}} ₺</td>
                                    <td>{{$rs->asgari_ucret2}} ₺</td>
                                    <td>{{$rs->yilbasi}}</td>
                                    <td>@php $trh=new DateTime($rs->ramazan1); $trh->modify('-1 day') ; echo $trh->format('Y-m-d');@endphp</td>
                                    <td>{{$rs->ramazan1}} -- {{$rs->ramazan3}}</td>
                                    <td> @php $trh=new DateTime($rs->kurban1); $trh->modify('-1 day') ; echo $trh->format('Y-m-d');@endphp</td>
                                    <td>{{$rs->kurban1}} -- {{$rs->kurban4}}</td>
                                    <td>{{$rs->nisan23}}</td>
                                    <td>{{$rs->isci_bayrami}}</td>
                                    <td>{{$rs->mayis19}}</td>
                                    <td>{{$rs->temmuz15}}</td>
                                    <td>{{$rs->agusto30}}</td>
                                    <td>{{$rs->ekim29}}</td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
