
@section('css')
    <!-- Toastr
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    -->
    <link rel="stylesheet" href="{{ asset('assets') }}/admin/plugins/toastr/toastr.min.css">

@endsection
@section('js')
    <!-- Toastr -->
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

@endsection
