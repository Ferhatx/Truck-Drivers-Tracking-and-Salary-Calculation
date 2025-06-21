<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">

                <div class="d-flex justify-content-center"><h1 class="page-header">

                        @if($prnt_ay==1)
                            OCAK {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==2)
                            ŞUBAT {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==3)
                            MART {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==4)
                            NİSAN {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==5)
                            MAYIS {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==6)
                            HAZİRAN {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==7)
                            TEMMUZ {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==8)
                            AĞUSTOS {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==9)
                            EYLÜL {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==10)
                            EKİM {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @elseif($prnt_ay==11)
                            KASIM {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @else
                            ARALIK {{$prnt_yil}} PERSONEL PUANTAJ KARTI
                        @endif

                    </h1></div>
                <h2 class="page-header">
                    <small class="float-right">Tarih: @php echo date('d/m/Y');@endphp</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Eflogica Uluslararası Taşımacılık Tic.Ltd.Şti</strong><br/>
                    İsmet İnönü Blv. Kültür Mah. Nakkaş Apt. No.136 K.1/1<br/>
                    Telefon:+90 (324) 238-6865<br/>
                    Email: info@eflogica.com.tr
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                @foreach($datalist as $rs)
                <address>

                        <strong>{{$rs->ad}} {{$rs->soyad}}</strong><br>
                        <b>T.C Kimlik No:</b> {{$rs->tc_no}}<br/>
                    <b>Telefon No:</b> {{$rs->telefon}}<br/>

                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Görevi: {{$rs->departman}}</b><br/>
                <br/>
                <b>İşe Başlama Tarihi:</b> {{$rs->start_date}}<br/>
            </div>
        @endforeach
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Giriş Tarihi</th>
                        <th>Giriş Saati</th>
                        <th>Çıkış Saati</th>
                        <th>Çıkış Tarihi</th>
                        <th>Çalıştığı Süre</th>
                        <th>Mola Saati</th>
                        <th>Sefer Sayısı</th>
                        <th>Açıklama</th>
                    </tr>
                    </thead>
                    <tbody>
                @php $i=1; @endphp
                    @foreach($sort as $rs2)
                        @if($rs2->calisma_durumu==="mazaret_izini")

                            <tr>
                                <td>{{$i++}}</td>
                                <td colspan="7" style="color:#f37749;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Mazaret İzni</td>
                                <td>{{$rs2->aciklama}}</td>
                            </tr>
                        @elseif($rs2->calisma_durumu==="raporlu")
                            <tr>
                                <td>{{$i++}}</td>
                                <td colspan="7" style="color:#10a5cb;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Raporlu </td>
                                <td>{{$rs2->aciklama}}</td>
                            </tr>
                        @elseif($rs2->calisma_durumu==="hafta_tatil" && $rs2->saat_farki==="00:00")
                            <tr>
                                <td>{{$i++}}</td>
                                <td colspan="7" style="color:#6767f3;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Haftalık Tatil </td>
                                <td>{{$rs2->aciklama}}</td>
                            </tr>
                        @elseif($rs2->calisma_durumu==="yillik_izni")
                            <tr>
                                <td>{{$i++}}</td>
                                <td colspan="7" style="color:#008080;text-align: center;">{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}} Yıllık İzinde </td>
                                <td>{{$rs2->aciklama}}</td>
                            </tr>
                        @else
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$rs2->giris_gun}}/{{$rs2->giris_ay}}/{{$rs2->giris_yil}}</td>
                            <td>{{$rs2->giris_saati}}</td>
                            <td>{{$rs2->cikis_saati}}</td>
                            <td>{{$rs2->cikis_gun}}/{{$rs2->cikis_ay}}/{{$rs2->cikis_yil}}</td>
                            <td>{{$rs2->saat_farki}}</td>
                            <td>{{$rs2->mola_saati}}</td>
                            <td>{{$rs2->sefer_sayisi}}</td>
                            <td>{{$rs2->aciklama}}</td>
                    </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6 col-sm-3">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Ay Toplamı</th>
                            <td>
                                @php
                                echo $yazdir_haftaici+$yazdir_pazar+$yazdir_ozelgunler;
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>Cari Ay Hafta İçi </th>
                            <td>{{$yazdir_haftaici}}</td>
                        </tr>
                        <tr>
                            <th>Cari Ay Hafta Tatili </th>
                            <td>{{$yazdir_pazar}}</td>
                        </tr>
                        <tr>
                            <th>Cari Ay Resmi Tatil </th>
                            <td>{{$yazdir_ozelgunler}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th colspan="6" >Yapılan</th>
                        </tr>
                        <tr>
                            <th>H.İçi</th><th>H.Tatili</th><th>R.Tatil</th><th>İzin</th><th>Rapor</th><th>Y.İzin</th>
                        </tr>
                        <tr>
                            <td>{{$dtlst14}}</td><td>{{$dtlst15}}</td><td>{{$dtlst16}}</td><td>{{$dtlst17}}</td><td>{{$dtlst18}}</td><td>{{$dtlst19}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- /.col -->
            <div class="col-xs-6 col-sm-3">

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Olması Gereken:</th>
                            <td>{{$aylik_saat}}:@php if($aylik_dakika==0){
                                    echo "00";
                                   }else{ echo $aylik_dakika;
                                     }@endphp</td>
                        </tr>
                        <tr>
                            <th>Yapılan:</th>
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
                        <th>Yapılan Mola :</th>
                            <td>
                                @php if(empty($datalist13)){
                                         echo "00:00";
                                           }else{
                                              echo $datalist13;
                                                 }
                                @endphp
                                </td>
                        </tr>
                        <tr>
                            <th>Sefer Sayısı :</th>
                            <td>{{$dtlst12}}</td>
                        </tr>
                        <tr>
                            <th>Fazla Çalışma:</th>
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
        </div>

        <div class="row">
            <div class="col-12">
            <p><strong>Cari ay puantaj kartına işlenen ve karşılarında belirtilen gün, mesai saatleri ve fazla mesai saatlerimin doğru olduğunu aşağıdaki imzamla beyan eder ve cari aya ait tahakkuk edecek yukarıdaki çalışma dışında başka bir çalışmam olmadığını kabul ederim.</strong></p>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-around">
                  <strong>KART SAHİBİNİN İMZASI</strong>

                    <strong>PUANTAJ SORUMLUSU</strong>

                    <strong>BİRİM AMİRİNİN İMZASI</strong>
                </div>

                <div class="d-flex justify-content-around">
                    @foreach($datalist as $rs)
                       <strong> {{$rs->ad}} {{$rs->soyad}}</strong>
                    @endforeach

                    <strong></strong>

                    <strong></strong>
                </div>

            </div>

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
    window.addEventListener("load", window.print());
</script>
</body>
</html>
