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
    <title>Wirewat</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('app_layout/bootstrap/dist/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('app_layout/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('app_layout/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('app_layout/css/colors/megna.css') }}" rel="stylesheet">



    <!-- toast CSS -->
    <link href="{{ asset('assets/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('assets/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <!-- sweetalert CSS -->

    @yield('extra-css')
    <link href="{{ asset('app_layout/css/app.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>



</head>
<body class="">
    <div id="wrapper">
        @include('layouts.partials.nav')
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('breadcrumb')
                @yield('content')
            </div>

            <footer class="footer text-center">2018 Powered by Bisso</footer>
        </div>
    </div>


    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('app_layout/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')  }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('app_layout/js/jquery.slimscroll.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('app_layout/js/custom.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

    <script src="{{ asset('assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>


    <script>
        $(function(){
            resizeImgNav();
            $(window).resize(function() {
                resizeImgNav();
            });

            $('.button-destroy').on('click', function(e){
                e.stopPropagation();
                e.preventDefault();
                var a = $(this);
                var _token = $('meta[name="csrf-token"]').attr('content');
                var confirmButtonColor = $(this).attr('data-confirmButtonColor');
                console.log(confirmButtonColor);
                if (typeof confirmButtonColor == typeof undefined || confirmButtonColor == false) {
                    confirmButtonColor = "#DC6B55"
                }

                swal({
                        title: a.data('trans-title'),
                        text: a.data('trans-subtitle'),
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: confirmButtonColor,
                        confirmButtonText: a.data('trans-button-confirm'),
                        cancelButtonText: a.data('trans-button-cancel'),
                        closeOnConfirm: false
                    },
                    function(){
                        var form =
                            $('<form>', {
                                'method': 'POST',
                                'action': a.data('url')
                            });

                        var token =
                            $('<input>', {
                                'name': '_token',
                                'type': 'hidden',
                                'value': _token
                            });

                        var hiddenInput =
                            $('<input>', {
                                'name': '_method',
                                'type': 'hidden',
                                'value': a.data('method')
                            });

                        form.append(token, hiddenInput).appendTo('body').submit();

                    });
            })
        });

        function resizeImgNav(){
            var width = $( window ).width();
            if( width <= 1150){
                $('#logoSmall').show();
                $('#logoNormal').hide();

            }else{
                $('#logoSmall').hide();
                $('#logoNormal').show();
            }
        }
    </script>
    @include('errors/alerts')
    @yield('extra-js')
</body>

</html>
