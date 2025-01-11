<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">


    <style>
        
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
        
        .error{
            font-size: 15px !important;
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
        
        <script>
        var toast = document.getElementById('toastBox');
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
        </script>


    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img src="{{ asset('images/view-living-room_1048944-2636784.avif') }}" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('messages.create_account') }} </h1>
                            </div>
              
                            <form class="user" action="{{ route('user.register') }}" method="post">
                                @csrf

                                <input type="hidden" name="uuid" value="{{ $uuid }}">

                                {{-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('first_name') is-invalid @enderror" id="exampleFirstName" name="first_name"
                                            placeholder="First Name">
                                            @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user  @error('last_name') is-invalid @enderror" id="exampleLastName" name="last_name"
                                            placeholder="Last Name">
                                            @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>  --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('professional_email') is-invalid @enderror" id="exampleFirstName" name="professional_email"
                                            placeholder="Professional Email">
                                            @error('professional_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user  @error('professional_phone') is-invalid @enderror" id="exampleLastName" name="professional_phone"
                                            placeholder="Professional Phone">
                                        @error('professional_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>  --}}
                                
                                <div class="form-group row">
                                    {{-- <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('phone') is-invalid @enderror" id="exampleFirstName" name="phone"
                                            placeholder="Phone">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>  --}}
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="email"  value="{{ $email  }}" class="form-control form-control-user   @error('email') is-invalid @enderror" id="exampleFirstName" name="email" readonly contenteditable="false"
                                            placeholder="Email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div> 
                                </div> 

                                
                                {{-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('department') is-invalid @enderror" id="exampleFirstName" name="department"
                                            placeholder="Department">
                                            @error('department')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user  @error('speciality') is-invalid @enderror" id="exampleLastName" name="speciality"
                                            placeholder="Speciality">
                                            @error('speciality')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>  --}}

                                
                                {{-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('country') is-invalid @enderror" id="exampleFirstName" name="country"
                                            placeholder="Country">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user  @error('city') is-invalid @enderror" id="exampleLastName" name="city"
                                            placeholder="City">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>  --}}
                                
                                
                                {{-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user   @error('region') is-invalid @enderror" id="exampleFirstName" name="region"
                                            placeholder="Region/Province">
                                            @error('region')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user  @error('address') is-invalid @enderror" id="exampleLastName" name="address"
                                            placeholder="Address">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>  --}}


 
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" placeholder="{{ __('messages.password') }} ">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                            id="exampleRepeatPassword" placeholder="{{ __('messages.confirm_new_password') }} ">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('messages.register_account') }} 
                                </button> 
                            </form>
                            <hr>
                            {{-- <div class="text-center">
                                <a class="small" href="{{ route('forgot.password') }}">Forgot Password?</a>
                            </div> --}}
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">{{ __('messages.already_account') }} </a>
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