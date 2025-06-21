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
                        <h1>Yeni Tanım</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Yeni Tanım</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @include('admin.message')
        <!-- Main content -->
        <section class="content">
            <!-- general form elements disabled -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Yeni Tanım Ekle</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{route('admin_tanimlamalar_store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Yıl Seçiniz :</label>
                                <select name="yil" id="yil" class="form-control">
                                    <option value="#">Yıl Seçiniz</option>
                                    @php
                                        $yil = date('Y');
                                        for ($i=$yil;$i<=$yil+35;$i++)
															{
														  echo   "<option value=$i>$i</option>";
															}
                                    @endphp
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asgari Ücret Dönem 1:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₺</span>
                                    </div>
                                    <input type="text" name="asgari_ucret" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asgari Ücret Dönem 2 :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₺</span>
                                    </div>
                                    <input type="text" name="asgari_ucret2" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ramazan Bayramı  1. Gün:</label>
                                <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                    <input type="text"  name="ramazan1" class="form-control datetimepicker-input" required data-target="#reservationdate2"/>
                                    <div class="input-group-append" data-target="#reservationdate2"  data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ramazan Bayramı  2. Gün:</label>
                                <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                                    <input type="text"  name="ramazan2" class="form-control datetimepicker-input" required data-target="#reservationdate3"/>
                                    <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ramazan Bayramı  3. Gün:</label>
                                <div class="input-group date" id="reservationdate4" data-target-input="nearest">
                                    <input type="text"  name="ramazan3" class="form-control datetimepicker-input" required data-target="#reservationdate4"/>
                                    <div class="input-group-append" data-target="#reservationdate4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kurban Bayramı  1. Gün:</label>
                                <div class="input-group date" id="reservationdate6" data-target-input="nearest">
                                    <input type="text"  name="kurban1" class="form-control datetimepicker-input" required data-target="#reservationdate6"/>
                                    <div class="input-group-append" data-target="#reservationdate6" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kurban Bayramı  2. Gün:</label>
                                <div class="input-group date" id="reservationdate7" data-target-input="nearest">
                                    <input type="text"  name="kurban2" class="form-control datetimepicker-input" required data-target="#reservationdate7"/>
                                    <div class="input-group-append" data-target="#reservationdate7" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kurban Bayramı  3. Gün:</label>
                                <div class="input-group date" id="reservationdate8" data-target-input="nearest">
                                    <input type="text"  name="kurban3" class="form-control datetimepicker-input" required data-target="#reservationdate8"/>
                                    <div class="input-group-append" data-target="#reservationdate8" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kurban Bayramı  4. Gün:</label>
                                <div class="input-group date" id="reservationdate9" data-target-input="nearest">
                                    <input type="text"  name="kurban4" class="form-control datetimepicker-input" required data-target="#reservationdate9"/>
                                    <div class="input-group-append" data-target="#reservationdate9" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Ekle</button>
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

            //Date picker
            $('#reservationdate2').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate3').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate4').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate5').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate6').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate7').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate8').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate9').datetimepicker({
                format: 'L'
            });

            //Date picker
            $('#reservationdate10').datetimepicker({
                format: 'L'
            });










            //Date and time picker
            $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

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
@endsection
