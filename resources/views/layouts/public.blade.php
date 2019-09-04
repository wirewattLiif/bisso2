
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Wirewatt</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('public_layout/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css')}} " rel="stylesheet">
    <!-- animation CSS -->
    {{--<link href="css/animate.css" rel="stylesheet">--}}
    <!-- Wizard CSS -->
    <link href=" {{  asset('assets/plugins/bower_components/register-steps/steps.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('public_layout/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('public_layout/css/colors/default.css') }} " id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- toast CSS -->
    <link href="{{ asset('assets/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('assets/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">


    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('extra-css')
</head>

<body>
<!-- Preloader -->

<nav class="navbar fixed-top" id="nav">
    <div class="container">


        <div class="col-md-4">
            <img src="{{ asset('img/logo_gris.png') }}" alt="" style="width:160px">
        </div>

        <div class="col-md-4"></div>
        <div class="col-md-4">
            <p>¿Ya iniciaste tu solicitud?
                <a href="/login" style="margin-left: 6px;" class="btn btn-outline btn-rounded btn-warning">
                    Continua aquí
                </a>
            </p>

        </div>
    </div>

</nav>


<section id="wrapper" class="step-register">
    @yield('content')
</section>



<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('public_layout/bootstrap/dist/js/tether.min.js')}} "></script>
<script src="{{ asset('public_layout/bootstrap/dist/js/bootstrap.min.js')}} "></script>
<script src="{{ asset('assets/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js')}} "></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}} "></script>
<script src="{{ asset('assets/plugins/bower_components/register-steps/jquery.easing.min.js')}} "></script>
<script src="{{ asset('assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>

<script src="{{ asset('assets/plugins/bower_components/register-steps/register-init.js') }}"></script>

<script src="{{ asset('public_layout/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('public_layout/js/custom.min.js') }}"></script>

@yield('extra-js')
</body>

</html>