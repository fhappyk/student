<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }} - {{ __('messages.forgot_password_2') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">


    <style>


        .error{
            font-size: 15px !important;
        }
        #toastBox{
            position: absolute;
            top: 10px;
            right: 50px;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            overflow: hidden;
            padding: 20px;
            z-index: 11;

            /* bottom: 1px solid red; */

        }
        .toastBox{
            width: 400px;
            height: 80px;
            background: #fff;
            font-weight: 500;margin: 15px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: left;
            position: relative;
        }
        .toastBox span{
            margin-right: auto;
        }
        .valid{
            color: green;
        }
        .invalid{
            color: red;
        }
        .toastBox::after{
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: green;
            animation: anim 3s linear forwards
        }
        .error::after{
            background: red;
        }

        @keyframes anim{
            100%{
                width: 0;
            }
        }


        @media (max-width: 768px){


            #toastBox{
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
            .toastBox{
                width: 340px;
                height: 60px;
                background: #fff;
                font-weight: 500;margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
            }
            .toastBox span{
                margin-right: auto;
            }
        }


        @media (max-width: 425px){


            #toastBox{
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
            .toastBox{
                width: 320px;
                height: 45px;
                background: #fff;
                font-weight: 500;margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
                font-size: 14px;
            }
            .toastBox span{
                margin-right: auto;
            }
        }
        @media (max-width: 320px){


            #toastBox{
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
            .toastBox{
                width: 220px;
                height: 45px;
                background: #fff;
                font-weight: 500;margin: 15px 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                text-align: left;
                position: relative;
                font-size: 10px;
            }
            .toastBox span{
                margin-right: auto;
            }
        }

    </style>

</head>

<body class="bg-gradient-primary">


    @if (Session::has('success'))
    <div id="toastBox" class="toastBox"><span>
            <i class="fa-solid fa-circle-check valid"></i> {{ Session::get('success') }}</span></div>

    @elseif (Session::has('error'))
    <div id="toastBox" class="toastBox error "><span>
            <i class="fa-solid fa-circle-xmark invalid"></i> {{ Session::get('error') }}</span></div>
    @endif

    <script>
    var toast = document.getElementById('toastBox');

    setTimeout(() => {
        toast.remove();
    }, 3000);
    </script>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image">
                                <img src="{{asset('images/view-living-room_1048944-2636784.avif')}}" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('messages.forgot_password_2') }}</h1>
                                        <p class="mb-4">{{ __('messages.forgot_password_text') }}</p>
                                    </div>
                                    <form class="user" action="{{ route('forgot.password.email') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="{{ __('messages.email_placeholder') }}">
                                        </div>
                                        <button type="submit"  class="btn btn-primary btn-user btn-block">{{ __('messages.send_password_reset_link') }}</button>

                                    </form>
                                    <hr>
                                    {{-- <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    </div> --}}
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">{{ __('messages.login_2') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js')}}"></script>

</body>

</html>
