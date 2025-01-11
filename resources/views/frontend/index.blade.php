@extends('frontend.layout.app')

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        "language": {
            "lengthMenu": "{{ __('datatables.lengthMenu') }}",
            "zeroRecords": "{{ __('datatables.zeroRecords') }}",
            "info": "{{ __('datatables.info') }}",
            "infoEmpty": "{{ __('datatables.infoEmpty') }}",
            "infoFiltered": "{{ __('datatables.infoFiltered') }}",
            "search": "{{ __('datatables.search') }}",
            "paginate": {
                "first": "{{ __('datatables.paginate.first') }}",
                "last": "{{ __('datatables.paginate.last') }}",
                "next": "{{ __('datatables.paginate.next') }}",
                "previous": "{{ __('datatables.paginate.previous') }}"
            }
        },
        "dom": "lrtip",
        // "columnDefs": [
        //     { "targets": [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15], "visible": false }
        // ]
    });

    $('#mySearchInput').keyup(function() {
        $('#dataTable').DataTable().search(this.value).draw();

        if (this.value === '') {
            table.columns().search('').draw();
        }
    });
    function updateDropdown() {
        $('#addColumnDropdown').empty().append('<option value="" disabled selected>Select Column</option>');
        var columnNames = table.columns().header().toArray().slice(5, -1);
        columnNames.forEach(function(col, index) {
            var colText = $(col).text().trim();
            $('#addColumnDropdown').append(`
                <option value="${index + 5}">${colText}</option>
            `);
        });
    }
    updateDropdown();

    $('#dataTable th:last-child').on('click', function() {
        $('#addColumnDropdown').toggle();
    });

    $('#addColumnDropdown').on('click', function(event) {
        event.stopPropagation();
    });

    $(document).on('click', '.delete-icon', function(event) {
        event.stopPropagation();

        var colIndex = $(this).data('col');

        table.column(colIndex).visible(false);

        updateDropdown();
    });

    $('#addColumnDropdown').on('change', function() {
        var colIndex = $(this).val();
        table.column(colIndex).visible(true);
        updateDropdown();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#addColumnDropdown, #dataTable th:last-child').length) {
            $('#addColumnDropdown').hide();
        }
    });
});


</script>

<script>
    $(document).ready(function() {
        $('.alphabet').click(function() {
            var letter = $(this).text();
            $('#mySearchInput').val(letter);
            var table = $('#dataTable').DataTable();
            table.column(1).search(letter).draw();
            $('html, body').animate({
                scrollTop: $('#tableHeading').offset().top
            }, 600);
        });
    });
</script>
@endpush


@section('home-content')
    <main class="main">


        {{--  About Section  --}}
        <section id="about" class="about section" style="padding: 0px;">

            {{--   Section Title   --}}
            <div class="container section-title" data-aos="fade-up" style="padding: 30px 50px 0px 50px;">
                <h2 style="border: 1px solid #7f7f7f;">{{ __('messages.hero_headline') }}</h2>
            </div>
            {{--  End Section Title  --}}

            <div class="container">

                <div class="">

                    <div class="form row align-items-center px-2 px-lg-5 pb-5">

                        <div class="col-md-10 m-auto">
                            <div class="row">

                        <div class="col-lg-7" >

                            <div class="form-group" style="background: #d8d8d8; border: 1px solid #7f7f7f;">
                                <label for="select-filter"
                                    style="display: flex; justify-content:center; align-items:center; font-size: 1.5rem; font-weight: 700; padding: 10px; color: #645287;border: 1px solid #7f7f7f;">{{ __('messages.search_member') }}
                                </label>
                                <div
                                    style="display: flex; justify-content:space-around; flex-direction:row; align-items:center; height: 60px; border: none; background: white;">
                                    <input id="mySearchInput" class="form-control"
                                        placeholder="{{ __('messages.member_search_placeholder') }}"
                                        style="font-size: 12px; font-weight: 700; display:flex; outline: 2px black; box-shadow:none; text-align: center; padding:20px; border:none;"
                                        onfocus="this.style.boxShadow='none';">
                                    <a href="#tableHeading">
                                        <i class="bi bi-search"
                                            style="font-size: 20px; color: blue; background: white; display: flex; justify-content:center; align-items:center; padding: 0 50px 0 0px">
                                        </i>
                                    </a>
                                </div>
                                <div
                                    style="display: flex; justify-content:space-around; flex-direction:row; height: 100%; border: 1px solid #7f7f7f;">

                                    <label for="select-filter"
                                        style="display: flex; justify-content:center; align-items:center; font-size: 12px; font-weight: 700; padding: 0px; color: #645287; border-right: 2px solid black; padding: 0 20px;">
                                        {{ __('messages.member_search_tite') }}
                                    </label>

                                    <label for="select-filter"
                                        style=" display: flex; gap: 6px; flex-wrap: wrap; justify-content:center; align-items:center; font-size: 12px font-weight: 700; padding: 10px; color: #161ad1 !important;">
{{--                                        A B C D E F G H I J K L M N O P Q R S T U V W X Y Z--}}
                                        <style>
                                            .alphabet {
                                                cursor: pointer;
                                            }
                                        </style>
                                        <span class="alphabet">A</span>
                                        <span class="alphabet">B</span>
                                        <span class="alphabet">C</span>
                                        <span class="alphabet">D</span>
                                        <span class="alphabet">E</span>
                                        <span class="alphabet">F</span>
                                        <span class="alphabet">G</span>
                                        <span class="alphabet">H</span>
                                        <span class="alphabet">I</span>
                                        <span class="alphabet">J</span>
                                        <span class="alphabet">K</span>
                                        <span class="alphabet">L</span>
                                        <span class="alphabet">M</span>
                                        <span class="alphabet">N</span>
                                        <span class="alphabet">O</span>
                                        <span class="alphabet">P</span>
                                        <span class="alphabet">Q</span>
                                        <span class="alphabet">R</span>
                                        <span class="alphabet">S</span>
                                        <span class="alphabet">T</span>
                                        <span class="alphabet">U</span>
                                        <span class="alphabet">V</span>
                                        <span class="alphabet">W</span>
                                        <span class="alphabet">X</span>
                                        <span class="alphabet">Y</span>
                                        <span class="alphabet">Z</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5 mt-3 mt-lg-0" style=" align-content:center">

                            <div class="d-flex justify-content-center align-items-center">

                                <div class="m-1 d-flex justify-content-center align-items-center">
                                    @if (!auth()->user())
                                        <a class="btn-getstarted m-1" href="{{ route('login') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 25px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.login') }}</a>
                                    @else
                                        <a class="btn-getstarted" href="{{ route('logout') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 25px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.logout') }}</a>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-center align-items-center">
                                    @if (auth()->user() && auth()->user()->role == 'student')
                                        <div class="d-flex flex-column flex-lg-column flex-sm-row">
                                            <a class="btn-getstarted m-1" href="{{ route('view.profile') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 25px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.view_profile') }}</a>


                                            <a class="btn-getstarted m-1" href="{{ route('edit.profile') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 25px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.edit_profile') }}</a>

                                            {{-- <a class="btn-getstarted" href="{{ route('view.profile') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 40px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.view_profile') }}</a>
                                            <a class="btn-getstarted" href="{{ route('edit.profile') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 40px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.edit_profile') }}</a> --}}
                                        </div>

        {{--                                <li class="dropdown lang-select"--}}
        {{--                                    style="display: flex; justify-content: center; align-items:center; color:black !important;">--}}
        {{--                                    <a href="#"><span--}}
        {{--                                            style="font-size: 1rem; font-weight: 600;">{{ __('messages.account') }}</span> <i--}}
        {{--                                            class="bi bi-chevron-down toggle-dropdown"></i></a>--}}
        {{--                                    <ul>--}}
        {{--                                        <li><a href="{{ route('view.profile') }}">{{ __('messages.view_profile') }}</a></li>--}}
        {{--                                        <li><a href="{{ route('edit.profile') }}">{{ __('messages.edit_profile') }}</a></li>--}}
        {{--                                    </ul>--}}
        {{--                                </li>--}}
                                    @endif
                                    @if (auth()->user() && auth()->user()->role == 'admin')
                                    <a class="btn-getstarted" href="{{ route('admin.dashboard') }}" style="background: #adadad; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 20px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.dashboard') }}</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        </div>
                        </div>


                    </div>
                </div>
            </div>

        </section>
          {{-- /About Section   --}}
        <style>
            #addColumnDropdown {
                width: 150px; /* Adjust width if necessary */
                background: #fff;
                border: 1px solid #ccc;
                z-index: 1000;
                padding: 5px;
            }

            #shadow-host-companion{
                background: #fff;
                display: none;
            }
            #dataTable_length{
                display: none;
            }
            #dataTable_info{
                background: white;
                color: blue !important;
                width: 20%;
                padding: 20px 15px;
                margin-top: 4rem;
            }
            #dataTable_paginate{
                width: 20%;
                margin-top: -3rem;
                float: right;
            }
            .pagination #dataTable_previous .page-link{
                color: blue;
                text-decoration: underline;
            }
            .pagination .active .page-link{
                background: #4e044e;
                text-decoration: underline;
            }
            .pagination #dataTable_next .page-link{
                color: blue;
                text-decoration: underline;
            }
            .section {
                padding: 0px;
            }

            .content {
                padding: 50px 150px;
                background: #00b0f0;
            }
            /* .table-responsive{
                overflow: hidden;
            } */

            .content .span-box span {
                background: white;
                width: 100%;
                height: 80px;
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 50px;
                padding: 20px;
                text-transform: uppercase;
                position: relative;
                color: black;
                background: #d8d8d8;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                border: 1px solid #7f7f7f;
            }

            table {
                border: black;
            }

            thead {
                background: #94a3d0;
            }

            .pagination {
                padding: 0px;
                display: flex;
                justify-content: space-between;
            }

            .pagination-info {
                display: flex;
                align-items: center;
                text-align: center;
                justify-content: center;
                background: white;
                padding: 0px 20px;
            }

            .pagination-number {
                background: white;
                display: flex;
                align-items: center;
                gap: 30px;
                padding: 0 20px;
            }

            .active-page {
                display: flex;
                align-items: center;
                text-align: center;
                justify-content: center;
                color: white;
                height: 50px;
                width: 50px;
                background: #43365a;
            }
            @media (max-width: 768px) {
                .content {
                    padding: 50px 20px;
                }
                .content .span-box span {
                    font-size: 20px;
                    height: 60px;
                    margin-bottom: 30px;
                }
                th{
                    font-size: 12px;
                }
                td{
                    font-size: 12px;
                }
                .pagination-info{
                    font-size: 12px;
                    padding: 0 5px;
                }
                .pagination-number{
                    padding: 0 5px;
                    font-size: 12px;
                    gap: 10px;
                }
                .pagination-number span{
                    font-size: 12px;
                }
            }
        </style>
        <section class="about section">
            <div class="row gy-4">

                <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100" style="min-height: calc(100vh - 500px);">
                    <div class="span-box" id="tableHeading" >
                        <span style="">{{ __('messages.table_heading') }}
                        </span>
                    </div>
                    <div class="table-responsive">
                        {{-- {{$data}} --}}

                        <table class="table table-bordered" style="width: 100%;" cellspacing="0" id="dataTable" >
                            <thead>
                                <tr>
                                    <th style="background: #94a3d0">{{ __('messages.member_id') }}</th>
                                    <th style="background: #94a3d0">{{ __('messages.full_name') }}</th>
                                    <th style="background: #94a3d0">{{ __('messages.association') }}</th>
                                    <th style="background: #94a3d0">{{ __('messages.promotion_year') }}</th>
                                    <th style="background: #94a3d0">{{ __('messages.country') }}</th>
{{--                                    <th style="background: #94a3d0">{{ __('messages.user_name') }} <span class="delete-icon" data-col="5" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.phone') }} <span class="delete-icon" data-col="6" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.city') }} <span class="delete-icon" data-col="7" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.address') }} <span class="delete-icon" data-col="8" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.Lattitude') }} <span class="delete-icon" data-col="9" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.Longitude') }} <span class="delete-icon" data-col="10" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.professional_email') }} <span class="delete-icon" data-col="11" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.professional_phone') }} <span class="delete-icon" data-col="12" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.speciality') }} <span class="delete-icon" data-col="13" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.region') }} <span class="delete-icon" data-col="14" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}
{{--                                    <th style="background: #94a3d0">{{ __('messages.office_name') }} <span class="delete-icon" data-col="15" style="cursor: pointer; color: red; margin-left: 10px;"><i class="fa-regular fa-trash-can"></i></span></th>--}}

{{--                                    <th id="addColTh" style="background: #94a3d0; position: relative; color:red; border: 2px solid red">--}}
{{--                                        {{ __('messages.add_col') }}--}}
{{--                                        <select id="addColumnDropdown" style="position: absolute; top: 100%; left: 0; display: none;">--}}
{{--                                            <option value="" disabled selected>{{ __('messages.select') }}</option>--}}
{{--                                            <!-- Options will be populated by JavaScript -->--}}
{{--                                        </select>--}}
{{--                                    </th>--}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @forelse ($data as $item)
                                    {{-- {{$item->studentinfo}} --}}
                                        <tr>

                                            <td> <a href="{{ route('view.student', $item->uuid ?? $item->user->uuid) }}" class="text-underline" style="text-decoration: underline; color: green">{{ $item->uuid ?? $item->user->uuid }} </a></td>
                                            <td> <a href="{{ route('view.student', $item->uuid ?? $item->user->uuid) }}" class="text-underline" style="text-decoration: underline; color: blue"> {{ $item->name }} </a></td>
                                             <td  style=" color: black">{{ $item->studentinfo->department ? $item->studentinfo->department : '' }}</td>
                                            <td  style=" color: black">{{ $item->studentinfo->registration_date ? Carbon\Carbon::parse($item->studentinfo->registration_date)->format('Y') : '' }}</td>
                                            <td  style=" color: black">{{ $item->studentinfo->country ?? $item->studentinfo->country }}</td>
{{--                                            <td  style=" color: black  ">{{ $item->user_name   }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->phone   }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->city  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->address  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->lattitude  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->longitude   }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->professional_email  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->professional_phone  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->speciality   }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->region  }}</td>--}}
{{--                                            <td  style=" color: black  ">{{ $item->studentinfo->office_name  }}</td>--}}
{{--                                            <td  style=" color: black ">  </td>--}}

                                        </tr>
                                    @empty
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                        <style>
                            div#dataTable_info {
                                color: #ffff00;
                            }
                            div#dataTable_length {
                                color: #ffff00;
                            }
                        </style>

{{--                        <div class="pagination">--}}
{{--                            <span class="pagination-info">Showing--}}
{{--                                1 to 10 of 13,822 entries</span>--}}
{{--                            <div class="pagination-number">--}}
{{--                                <span>Previus</span>--}}
{{--                                <span style="">1</span>--}}
{{--                                <span style="">2</span>--}}
{{--                                <span class="active-page">3</span>--}}
{{--                                <span style="">4</span>--}}
{{--                                <span style="">5</span>--}}
{{--                                <span style="">Next</span>--}}
{{--                            </div>--}}
                       {{-- </div> --}}
                    </div>

                </div>

            </div>
        </section>

        <section class="about section"
            style="padding: 0px; background: #94a3d0; display:flex; justify-content: center; align-items:center; text-align:center; padding: 20px 0px">
            <span style="font-size: 1rem; font-weight: 900px;">{{ __('messages.footer_text') }}</span>
        </section>



    </main>
@endsection
