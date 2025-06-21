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
                        <h1>Clock Card Add</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Clock Card Add</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- general form elements disabled -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Clock Card Add</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{route('admin_scorecard_store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Şoför Adı Soyadı</label>
                                <select name="adsoyad" class="form-control">
                                    @foreach($datalist as $rs)
                                        <option value="{{$rs->ad}} {{$rs->soyad}} {{$rs->id}} {{$rs->tc_no}}">{{$rs->ad}} {{$rs->soyad}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Çalışma Durumu</label>
                                <select name="calisma_durum" id="calisma_durum" class="form-control">
                                    <option value="calisti" selected>Çalıştı</option>
                                    <option value="resmi_tatil">Resmi Tatil</option>
                                    <option value="hafta_tatil">Haftalık Tatili</option>
                                    <option value="mazaret_izini">Mazaret İzni</option>
                                    <option value="raporlu">Raporlu</option>
                                    <option value="yillik_izni">Yıllık İzin</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-check">
                                <input type="checkbox" name="tatil_calis" class="form-check-input" id="tatil_calis" style="display: none;"/>
                                <label class="form-check-label"  for="tatil_calis" id="tatil_calis_lbl" style="display: none;color: green;">İzinli Günde Çalıştı</label>
                            </div>
                        </div>

                  <!--      <div class="col-sm-6">
                            <div class="form-check">
                                <input type="radio" name="tatil_calis1" class="form-check-input" id="tatil_calis2" style="display: none;"/>
                                <label class="form-check-label"  for="tatil_calis2" id="tatil_calis_lbl2" style="display: none;color: red;">İzinli Günde Çalışmadı</label>
                            </div>
                        </div>

!-->



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Giriş Tarihi ve Saati</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" name="timestart" id="timestart" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Çıkış Tarihi ve Saati</label>
                                <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                    <input type="text" name="timestop" id="timestop" class="form-control datetimepicker-input" data-target="#reservationdatetime2"/>
                                    <div class="input-group-append" data-target="#reservationdatetime2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Mola Saati</label>
                                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                                        <input type="text" name="molaSaat" id="molaSaat" class="form-control datetimepicker-input" data-target="#timepicker"/>
                                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sefer Şehri</label>
                                <select name="sfrhrch" id="sfrhrch" class="form-control select2bs4" style="width: 100%;">
                                    <option value="0">Sefer Şehrini Seçiniz</option>
                                    @foreach($datalist2 as $rs2)
                                        <option value="{{$rs2->sefer_harcirah}} {{$rs2->cikis_il}} {{$rs2->cikis_ilce}} {{$rs2->varis_il}} {{$rs2->varis_ilce}}">{{$rs2->cikis_il}} {{$rs2->cikis_ilce}} - {{$rs2->varis_il}} {{$rs2->varis_ilce}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ad">Sefer Sayısı</label>
                                <input type="text" name="sefer_sayisi" id="sefer_sayisi" class="form-control" id="ad" placeholder="Sefer Sayısı" required>
                            </div>
                        </div>





                     @section("css")
                         <!-- Select2 -->
                             <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/select2/css/select2.min.css">
                             <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"> </script>
                            <script>
                                $(document).ready(function() {
                                    // İki tarih ve saat arasındaki farkı hesapla ve ekranda göster
                                    function hesaplaVeGoster() {

                                        var date1 = $('#timestart').val()+ ":00";
                                        var date2 = $('#timestop').val() + ":00";
                                        var molaSaat = $('#molaSaat').val();

                                        var selectedOption = $('#calisma_durum').val();


                       //burada Hafta tatili ilgili işlem var birinci if seçildiğinde 2 si checkbox seçildiğinde
                                    if(selectedOption==="hafta_tatil"){
                                        $('#tatil_calis').show();
                                        $('#tatil_calis_lbl').show();
                                        $('#tatil_calis').prop('disabled',false);
                                        $('#sfrhrch').prop('disabled', true);
                                    //buraya koyacaksın

                                    if($('#tatil_calis').is(':checked')) {
                                        $('#timestop').prop('disabled',false);
                                        $('#molaSaat').prop('disabled', false);
                                        $('#sefer_sayisi').prop('disabled', false);
                                        $('#sfrhrch').prop('disabled', false);

                                        var dateTime1 = new Date(date1);
                                        var dateTime2 = new Date(date2);

                                        // Zaman farkını hesapla
                                        var diff = Math.abs(dateTime2 - dateTime1);
                                        var diffHours = Math.floor(diff / 3600000);
                                        var diffMinutes = Math.floor((diff % 3600000) / 60000);

                                        // Mola saati varsa hesaplamaya dahil et
                                        if (molaSaat) {
                                            var molaHours = parseInt(molaSaat.split(":")[0]);
                                            var molaMinutes = parseInt(molaSaat.split(":")[1]);
                                            diffHours -= molaHours;
                                            diffMinutes -= molaMinutes;
                                            if (diffMinutes < 0) {
                                                diffHours--;
                                                diffMinutes += 60;
                                            }
                                        }

                                        // Sonucu ekranda göster
                                        $('#toplamsaat').val(diffHours+ " saat " + diffMinutes + " dakika");

                                        //Çıkış Tarihleri
                                        var year2 = dateTime2.getFullYear();
                                        var month2 = dateTime2.getMonth() + 1;
                                        var day2 = dateTime2.getDate();
                                        var dakika2=dateTime2.getMinutes();
                                        var cikisaat=dateTime2.getHours();

                                        //Giriş Tarihleri
                                        var day1 = dateTime1.getDate();
                                        var month1 = dateTime1.getMonth() + 1;
                                        var year1 = dateTime1.getFullYear();
                                        var dakika1=dateTime1.getMinutes();
                                        var girisaat=dateTime1.getHours();

                                        $('#saat_frk').hide();
                                        $('#saat_frk').val(diffHours+ ":" + diffMinutes);

                                        $('#giris_yil').val(year1);
                                        $('#giris_ay').val(month1);
                                        $('#giris_gun').val(day1);
                                        $('#giris_saat').val(girisaat+":"+dakika1);


                                        $('#cikis_yil').val(year2);
                                        $('#cikis_ay').val(month2);
                                        $('#cikis_gun').val(day2);
                                        $('#cikis_saat').val(cikisaat+":"+dakika2);

                                    }
                                    if($('#tatil_calis').is(":not(:checked)")){
                                        var dateTime1 = new Date(date1);

                                        //Giriş Tarihleri
                                        var day1 = dateTime1.getDate();
                                        var month1 = dateTime1.getMonth() + 1;
                                        var year1 = dateTime1.getFullYear();
                                        var dakika1=dateTime1.getMinutes();
                                        var girisaat=dateTime1.getHours();

                                        $('#giris_yil').val(year1);
                                        $('#giris_ay').val(month1);
                                        $('#giris_gun').val(day1);
                                        $('#giris_saat').val(girisaat+":"+dakika1);

                                        $('#timestop').prop('disabled', true);
                                        $('#molaSaat').prop('disabled', true);
                                        $('#sefer_sayisi').prop('disabled', true);
                                        $('#molaSaat').val("");
                                        $('#sefer_sayisi').val("");
                                        $('#timestop').val("");
                                        $('#toplamsaat').val("");
                                    }}

                                   // Hafta Tatil Bitiş





                                    if(selectedOption==="mazaret_izini"||selectedOption==="raporlu"||selectedOption==="yillik_izni" ){
                                        var dateTime1 = new Date(date1);

                                        //Giriş Tarihleri
                                        var day1 = dateTime1.getDate();
                                        var month1 = dateTime1.getMonth() + 1;
                                        var year1 = dateTime1.getFullYear();
                                        var dakika1=dateTime1.getMinutes();
                                        var girisaat=dateTime1.getHours();

                                        $('#giris_yil').val(year1);
                                        $('#giris_ay').val(month1);
                                        $('#giris_gun').val(day1);
                                        $('#giris_saat').val(girisaat+":"+dakika1);


                                        $('#timestop').prop('disabled', true);
                                        $('#molaSaat').prop('disabled', true);
                                        $('#sefer_sayisi').prop('disabled', true);
                                        $('#tatil_calis').prop('disabled', true);
                                        $('#sfrhrch').prop('disabled', true);
                                        $('#tatil_calis').hide();
                                        $('#tatil_calis_lbl').hide();
                                        $('#timestop').val("");
                                        $('#molaSaat').val("");
                                        $('#sefer_sayisi').val("");
                                        $('#toplamsaat').val("");

                                    }






                                        /*ÇALIŞTI VE RESMİ TATİLİ BAŞLANGIÇ*/
                                        if (selectedOption==="calisti" || selectedOption==="resmi_tatil"){

                                                var dateTime1 = new Date(date1);
                                                var dateTime2 = new Date(date2);

                                                $('#tatil_calis').hide();
                                                $('#tatil_calis').prop('disabled', false);
                                                $('#tatil_calis_lbl').hide();
                                                $('#molaSaat').prop('disabled', false);
                                                $('#sefer_sayisi').prop('disabled', false);
                                                $('#timestop').prop('disabled', false);
                                                $('#sfrhrch').prop('disabled', false);

                                                 $('#saat_frk').hide();
                                                //Çıkış Tarihleri
                                                var year2 = dateTime2.getFullYear();
                                                var month2 = dateTime2.getMonth() + 1;
                                                var day2 = dateTime2.getDate();
                                                var dakika2=dateTime2.getMinutes();
                                                var cikisaat=dateTime2.getHours();

                                                //Giriş Tarihleri
                                                var day1 = dateTime1.getDate();
                                                var month1 = dateTime1.getMonth() + 1;
                                                var year1 = dateTime1.getFullYear();
                                                var dakika1=dateTime1.getMinutes();
                                                var girisaat=dateTime1.getHours();



                                                // Zaman farkını hesapla
                                                var diff = Math.abs(dateTime2 - dateTime1);
                                                var diffHours = Math.floor(diff / 3600000);
                                                var diffMinutes = Math.floor((diff % 3600000) / 60000);

                                            // Mola saati varsa hesaplamaya dahil et
                                            if (molaSaat) {
                                                var molaHours = parseInt(molaSaat.split(":")[0]);
                                                var molaMinutes = parseInt(molaSaat.split(":")[1]);
                                                diffHours -= molaHours;
                                                diffMinutes -= molaMinutes;
                                                if (diffMinutes < 0) {
                                                    diffHours--;
                                                    diffMinutes += 60;
                                                }
                                            }





                                           $('#saat_frk').val(diffHours+":"+ diffMinutes);

                                                // Sonucu ekranda göster
                                                //  $('#result').text("yıl: " + year1 + " ay :" + month1 +"gün"+  day1 +" saaat :"+ girisaat +":" + dakika);
                                                $('#toplamsaat').val(diffHours+ " saat " + diffMinutes + " dakika");

                                           // $('#result').text(abc);

                                                $('#giris_yil').val(year1);
                                                $('#giris_ay').val(month1);
                                                $('#giris_gun').val(day1);
                                                $('#giris_saat').val(girisaat+":"+dakika1);


                                                $('#cikis_yil').val(year2);
                                                $('#cikis_ay').val(month2);
                                                $('#cikis_gun').val(day2);
                                                $('#cikis_saat').val(cikisaat+":"+dakika2);
                                            }
                                        }

                                        // Her saat veya tarih değiştiğinde hesaplaVeGoster fonksiyonunu çağır
                                        $('#timestart,#timestop,#calisma_durum,#molaSaat,#sefer_sayisi').on('input', function() {
                                            hesaplaVeGoster();
                                        });

                                        $('#tatil_calis').change(function() {
                                            hesaplaVeGoster();
                                        });

                                        hesaplaVeGoster();
                                    });
                            </script>

                        @endsection
                        <div id="result"></div>

                        <input type="hidden" name="giris_yil" id="giris_yil"/>
                        <input type="hidden" name="giris_ay" id="giris_ay"/>
                        <input type="hidden" name="giris_gun" id="giris_gun"/>
                        <input type="hidden" name="giris_saat" id="giris_saat"/>

                        <input type="text" name="saat_frk" id="saat_frk"/>


                        <input type="hidden" name="cikis_yil" id="cikis_yil"/>
                        <input type="hidden" name="cikis_ay" id="cikis_ay"/>
                        <input type="hidden" name="cikis_gun" id="cikis_gun"/>
                        <input type="hidden" name="cikis_saat" id="cikis_saat"/>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Çalıştığı Toplam Saat</label>
                                <input type="text" name="toplamsaat" id="toplamsaat" class="form-control" placeholder="Toplam Saat" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Açıklama</label>
                                <textarea name="aciklama" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>



                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Ekle</button>
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


    <!-- Select2 -->
    <script src="{{ asset('assets') }}/admin/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('assets') }}/admin/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>



    <script src="{{ asset('assets') }}/admin/plugins/inputmask/jquery.inputmask.min.js"></script>

    <script src="{{ asset('assets') }}/admin/plugins/moment/trk.js"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets') }}/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

    <!-- Bootstrap Switch -->
    <script src="{{ asset('assets') }}/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('assets') }}/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('assets') }}/admin/plugins/dropzone/min/dropzone.min.js"></script>


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

            //Date and time picker
            $('#reservationdatetime2').datetimepicker({ icons: { time: 'far fa-clock' } });

            //Date and time picker
            $('#reservationdatetime3').datetimepicker({ icons: { time: 'far fa-clock' } });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });



            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
@endsection()

