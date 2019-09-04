
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Wirewatt</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('public_layout/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css')}} " rel="stylesheet">
    <!-- animation CSS -->

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

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    @yield('extra-css')

    <style>
        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one      */
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

<section id="wrapper" class="step-register">
    @yield('content')
</section>


<script src="{{ asset('public_layout/bootstrap/dist/js/bootstrap-3.3.7.min.js') }}"></script>
@yield('extra-js')
</body>

</html>