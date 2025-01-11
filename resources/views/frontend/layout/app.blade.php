<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('frontend/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzVmoS_yZcLG6ThG-ns5rCHWrkYfUMrJA&libraries=places">
    </script>



    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend/assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">



    <style>
        .container-main {
            padding: 0px 50px;
        }

        #toastBox {
            position: absolute;
            top: 30px;
            right: 50px;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            overflow: hidden;
            padding: 20px;
            z-index: 1111111111;

            /* bottom: 1px solid red; */

        }

        .toastBox {
            width: 400px;
            height: 80px;
            background: #c0f0a4;
            font-weight: 500;
            margin: 15px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: left;
            position: relative;
        }

        .toastBox.error {
            background: #f0a8a4;
        }

        .error {
            font-size: 15px !important;
        }

        .toastBox span {
            margin-right: auto;
        }

        .valid {
            color: green;
        }

        .invalid {
            color: red;
        }

        .toastBox::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: green;
            animation: anim 3s linear forwards
        }

        .error::after {
            background: red;
        }

        .mobile-nav-toggle {
            color: Black;
        }

        @keyframes anim {
            100% {
                width: 0;
            }
        }

        @media (max-width: 768px) {

            .container-main {
                padding: 0px 5px;
                display: flex;
                justify-content: space-around;
            }

            .sitename {
                margin-right: 3px !important;
                font-size: 1.2rem !important;
            }

            #toastBox {
                position: absolute;
                top: 7px;
                right: 25px;
                display: flex;
                align-items: flex-end;
                flex-direction: column;
                overflow: hidden;
                padding: 15px;
                z-index: 11;

                /* bottom: 1px solid red; */

            }

            .toastBox {
                width: 340px;
                height: 60px;
                background: #fff;
                font-weight: 500;
                margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
            }

            .toastBox span {
                margin-right: auto;
            }

            .navbar-brand {
                margin-right: 5px;
            }
            .navbar-brand img {
                width: 60px;
                height: 60px;
            }

            .mobile-nav-toggle {
                color: Black;
            }
        }


        @media (max-width: 425px) {
            .container-main {
                padding: 0px 5px;
            }

            #toastBox {
                position: absolute;
                top: 18px;
                right: 10px;
                display: flex;
                align-items: flex-end;
                flex-direction: column;
                overflow: hidden;
                padding: 10px;
                z-index: 11;

                /* bottom: 1px solid red; */

            }

            .toastBox {
                width: 320px;
                height: 45px;
                background: #fff;
                font-weight: 500;
                margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
                font-size: 14px;
            }

            .toastBox span {
                margin-right: auto;
            }
        }

        @media (max-width: 320px) {
            .container-main {
                padding: 0px 5px;
            }

            #toastBox {
                position: absolute;
                top: 18px;
                right: 0px;
                display: flex;
                align-items: flex-end;
                flex-direction: column;
                overflow: hidden;
                z-index: 11;

                /* padding: 10px; */
                /* bottom: 1px solid red; */

            }

            .toastBox {
                width: 220px;
                height: 45px;
                background: #fff;
                font-weight: 500;
                margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
                font-size: 10px;
            }

            .toastBox span {
                margin-right: auto;
            }
        }

        .lang-select {
            border: none;
            width: 120px;
            height: 50px;
            padding: 7px 10px;
            border-radius: 100px;
            background: #dbeef3;
            color: black;
            font-weight: 700;
            font-size: 1rem;
            border: none;
        }
    </style>

    @if (Session::has('success'))
        <div id="toastBox" class="toastBox"><span>
                <i class="fa-solid fa-circle-check valid"></i> {{ Session::get('success') }}</span></div>
    @elseif (Session::has('error'))
        <div id="toastBox" class="toastBox "><span>
                <i class="fa-solid fa-circle-xmark invalid"></i> {{ Session::get('error') }}</span></div>
    @endif

    <script>
        var toast = document.getElementById('toastBox');

        setTimeout(() => {
            toast.remove();
        }, 3000);
    </script>







    <header id="header" class="header d-flex align-items-center sticky-top" style="padding: 0;">
        <div class="container-xl position-relative d-flex align-items-center container-main">
            <div class="navbar navbar-light bg-none">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('frontend/assets/img/logo.png') }}" width="80" height="80"
                        alt="">
                </a>
            </div>
            <a href="/" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png')}}" alt=""> -->
                <h1 class="sitename">Association for Free Peace & Love</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('home') }}" class="active">{{ __('messages.home') }}</a></li>

                    <form action="{{ route('change.language') }}" method="POST">
                        @csrf
                        <select class="lang-select m-4" name="locale" onchange="this.form.submit()">
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>Lang - EN
                            </option>
                            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Lang - FR
                            </option>
                        </select>
                    </form>





{{--                    @if (auth()->user() && auth()->user()->role == 'student')--}}
{{--                        <li class="dropdown lang-select"--}}
{{--                            style="display: flex; justify-content: center; align-items:center; color:black !important;">--}}
{{--                            <a href="#"><span--}}
{{--                                    style="font-size: 1rem; font-weight: 600;">{{ __('messages.account') }}</span> <i--}}
{{--                                    class="bi bi-chevron-down toggle-dropdown"></i></a>--}}
{{--                            <ul>--}}
{{--                                <li><a href="{{ route('view.profile') }}">{{ __('messages.view_profile') }}</a></li>--}}
{{--                                <li><a href="{{ route('edit.profile') }}">{{ __('messages.edit_profile') }}</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endif--}}


                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <!--@if (!auth()->user())-->
            <!--    <a class="btn-getstarted" href="{{ route('login') }}">{{ __('messages.login') }}</a>-->
            <!--    {{-- <a class="btn-getstarted" href="{{ route('register') }}">Get Registered</a> --}}-->
            <!--@else-->
            <!--    <a class="btn-getstarted" href="{{ route('logout') }}">{{ __('messages.logout') }}</a>-->
            <!--@endif-->

        </div>
    </header>


    @yield('home-content')




    {{-- @push('scripts')
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush --}}
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}

    <!-- Core plugin JavaScript-->
    {{-- <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script> --}}

    <!-- Custom scripts for all pages-->
    {{-- <script src="{{ asset('admin/js/sb-admin-2.min.js')}}"></script> --}}
    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>


    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}



    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    {{--    <script src="{{ asset('admin/js/demo/datatables-demo.js')}}"></script> --}}
    {{--    <script> --}}
    {{--        $(document).ready(function() { --}}
    {{--            $('#dataTable').DataTable(); --}}
    {{--        }); --}}
    {{--    </script> --}}

    @stack('scripts')


</body>

</html>
