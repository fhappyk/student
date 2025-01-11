<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dashboard</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">--}}






    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>     --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom JS (should be after the libraries) -->
    <script src="{{ asset('path/to/chart-area-demo.js') }}"></script>
    <script src="{{ asset('path/to/chart-pie-demo.js') }}"></script>

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>

        #toastBox{
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            overflow: hidden;
            padding: 20px;
            z-index: 1111111111;

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
        .error{
            font-size: 15px !important;
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

    @stack('styles')

</head>

<body id="page-top">


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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layout.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layout.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('admin-content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.layout.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    {{-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div> --}}




    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>--}}

{{--        <script>--}}
{{--            toastr.options = {--}}
{{--                "closeButton": false,--}}
{{--                "debug": false,--}}
{{--                "newestOnTop": false,--}}
{{--                "progressBar": false,--}}
{{--                "positionClass": "toast-top-right",--}}
{{--                "preventDuplicates": false,--}}
{{--                "onclick": null,--}}
{{--                "showDuration": "300",--}}
{{--                "hideDuration": "1000",--}}
{{--                "timeOut": "5000",--}}
{{--                "extendedTimeOut": "1000",--}}
{{--                "showEasing": "swing",--}}
{{--                "hideEasing": "linear",--}}
{{--                "showMethod": "fadeIn",--}}
{{--                "hideMethod": "fadeOut"--}}
{{--            };--}}

{{--            $(document).ready(function() {--}}
{{--                toastr.error("Error");--}}
{{--                @if (session('success'))--}}
{{--                toastr.success("{{ session('success') }}");--}}
{{--                @endif--}}
{{--                @if (session('error'))--}}
{{--                toastr.error("{{ session('error') }}");--}}
{{--                @endif--}}
{{--                @if (session('warning'))--}}
{{--                toastr.warning("{{ session('warning') }}");--}}
{{--                @endif--}}
{{--                @if (session('info'))--}}
{{--                toastr.info("{{ session('info') }}");--}}
{{--                @endif--}}
{{--                // Validation Errors--}}
{{--                @if(isset($page) && isset($page->hasFormErrorAlerts) && $page->hasFormErrorAlerts)--}}
{{--                @if ($errors->any())--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                toastr.error("{{ $error }}");--}}
{{--                @endforeach--}}
{{--                @endif--}}
{{--                @endif--}}
{{--            });--}}

{{--        </script>--}}

    <script>
        $( function() {
            $( document ).tooltip();
        } );
    </script>









    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ asset('admin/vendor/jquery/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js')}}"></script>






<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

        @stack('scripts')
</body>

</html>
