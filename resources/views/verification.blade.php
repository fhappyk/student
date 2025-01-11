<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">





</head>

<body class="bg-gradient-primary">


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
            background: #c0f0a4;
            font-weight: 500;margin: 15px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: left;
            position: relative;
        }

        .toastBox.error{
            background: #f0a8a4;
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

        @if (Session::has('success'))
        <div id="toastBox" class="toastBox"><span>
                <i class="fa-solid fa-circle-check valid"></i> {{ Session::get('success') }}</span></div>

        @elseif (Session::has('error'))
        <div id="toastBox" class="toastBox error "><span>
                <i class="fa-solid fa-circle-xmark invalid"></i> {{ Session::get('error') }}</span></div>
        @endif



    <div class="container">


        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="{{ asset('images/view-living-room_1048944-2636784.avif') }}" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('messages.check_mail') }} </h1>
                                    </div>


                                    <form  method="post" id="verificationForm">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="form-group">
                                            <input  type="number" name="otp" placeholder="{{ __('messages.enter_otp') }}" required class="form-control form-control-user @error('otp')
                                                is-invalid
                                            @enderror"
                                                id="otp" placeholder="otp">
                                                @error('otp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="message_error" class="text-danger"></div>
                                        </div>
                                        <p class="time"></p>

                                        <button class="btn btn-primary btn-user btn-block"  type="submit"  value="{{ __('messages.verify') }}">
                                           {{ __('messages.login') }}
                                        </button>
                                    </form>

                                    <hr>

                                    <button class="btn btn-primary btn-user btn-block"  id="resendOtpVerification" >
                                        {{ __('messages.resend_verification') }}
                                    </button>


                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

                                    <script>
                                        $(document).ready(function() {
                                            $('#verificationForm').submit(function(e) {
                                                e.preventDefault();

                                                var formData = $(this).serialize();

                                                $.ajax({
                                                    url: "{{ route('verifiedOtp') }}",
                                                    type: "POST",
                                                    data: formData,
                                                    success: function(res) {
                                                        if (res.success) {
                                                            // alert(res.msg);
                                                            {{--window.open("{{ route('home') }}", "_self");--}}
                                                            // window.open("/", "_self");
                                                            window.location.href = res.redirect;
                                                        } else {

                                                            $('#message_error').text(res.msg);
                                                            // setTimeout(() => {
                                                            //     $('#message_error').text('');
                                                            // }, 10000);
                                                        }
                                                    }
                                                });

                                            });

                                            $('#resendOtpVerification').click(function() {
                                                $(this).text('Wait...');
                                                var userMail = @json($email);

                                                $.ajax({
                                                    url: "{{ route('resendOtp') }}",
                                                    type: "GET",
                                                    data: {
                                                        email: userMail
                                                    },
                                                    success: function(res) {
                                                        $('#resendOtpVerification').text('Resend Verification OTP');
                                                        if (res.success) {
                                                            timer();
                                                            $('#message_success').text(res.msg);
                                                            setTimeout(() => {
                                                                $('#message_success').text('');
                                                            }, 3000);
                                                        } else {
                                                            $('#message_error').text(res.msg);
                                                            setTimeout(() => {
                                                                $('#message_error').text('');
                                                            }, 3000);
                                                        }
                                                    }
                                                });

                                            });
                                        });

                                        function timer() {
                                            var seconds = 0;
                                            var minutes = 2;

                                            var timer = setInterval(() => {

                                                if (minutes < 0) {
                                                    $('.time').text('');
                                                    clearInterval(timer);
                                                } else {
                                                    let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                                                    let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                                                    $('.time').text(tempMinutes + ':' + tempSeconds);
                                                }

                                                if (seconds <= 0) {
                                                    minutes--;
                                                    seconds = 59;
                                                }

                                                seconds--;

                                            }, 1000);
                                        }

                                        timer();
                                    </script>


                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('forgot.password') }}">{{ __('messages.forgot_password') }} </a>
                                    </div>
                                    {{-- <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js')}}"></script>

</body>

</html>
