@extends('frontend.layout.app')
@section('home-content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzVmoS_yZcLG6ThG-ns5rCHWrkYfUMrJA&libraries=places"></script> --}}
    <style>
        /* Ensure the map has a defined height */
        #map-div {
            width: 100%;
            height: 370px;
        }
    </style>

    <script>
        function initMap() {
            console.log('initMap function called');
            // Pass the latitude, longitude, city, and country from PHP to JavaScript
            var latitude = "{{ $data[0]['studentinfo']->lattitude ?? 'null' }}";
            var longitude = "{{ $data[0]['studentinfo']->longitude ?? 'null' }}";
            var address = "{{ $data[0]['studentinfo']->address ?? '' }}";
            var city = "{{ $data[0]['studentinfo']->city ?? '' }}";
            var country = "{{ $data[0]['studentinfo']->country ?? '' }}";

            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
            console.log('Address:', address);
            console.log('City:', city);
            console.log('Country:', country);

            var map;
            var marker;

            // Function to initialize the map
            function initializeMap(lat, lng, title) {
                console.log('initializeMap function called with lat:', lat, 'lng:', lng, 'title:', title);
                map = new google.maps.Map(document.getElementById('map-div'), {
                    center: {
                        lat: lat,
                        lng: lng
                    },
                    zoom: 15
                });

                marker = new google.maps.Marker({
                    position: {
                        lat: lat,
                        lng: lng
                    },
                    map: map,
                    title: title
                });

                console.log('Map and marker initialized successfully with title: ' + title);
            }

            // Function to use Geocoding API to get coordinates from address
            function geocodeAddress(address) {
                console.log('geocodeAddress function called with address:', address);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': address
                }, function (results, status) {
                    if (status === 'OK') {
                        var location = results[0].geometry.location;
                        console.log('Geocoding successful, location:', location);
                        initializeMap(location.lat(), location.lng(), address);
                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            // Logic to decide which location data to use
            if (latitude !== 'null' && longitude !== 'null') {
                console.log("Using latitude and longitude.");
                initializeMap(parseFloat(latitude), parseFloat(longitude), address);
            } else if (city) {
                console.log("Using city.");
                geocodeAddress(city);
            } else if (country) {
                console.log("Using country.");
                geocodeAddress(country);
            } else {
                console.error('No valid location data available.');
            }
        }

        // Initialize the map when the window loads
        window.onload = initMap;
    </script>
    <style>
        .contact.section {
            background: none;
        }

        .contact .php-email-form {
            border: 1px solid gray;
            box-shadow: none;
        }

        .container-new {
            display: flex;
            align-items: flex-start;
            margin: 20px;
        }

        #shadow-host-companion {
            background: none;
            display: none;
        }

        .left-side {
            /* flex: 1; */
            /* padding: 20px; */
            /* border: 1px solid #ccc; */
            text-align: center;
            height: 100%;
            max-width: 50%;
        }


        .main-img img {
            height: 325px;
        }

        .main-img {
            border: 1px solid #ccc;
            /* height: 300px; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-side {
            flex: auto;
            margin-left: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        @media (max-width: 768px) {
            .container-new {
                flex-direction: column;
                gap: 20px;
            }

            .right-side {
                margin-left: 0;
                display: flex;
                flex-wrap: wrap;
                width: 100%;
                gap: 20px;
                /* Optional: to control spacing between the items */
            }

            .navbar-brand img {
                width: 60px;
                height: auto;
            }

            .header .logo h1 {
                font-size: 1.2rem;
            }
        }

        .wide-item {
            grid-column: span 2;
        }

        .short-items {
            width: 100%;
        }

        .php-email-form .col-lg-12 {
            padding: 1.5rem;
        }

        @media (max-width: 968px) {
            .container-new {
                flex-direction: column;
                gap: 20px;
                padding: 0px;
                margin: 0px;
                margin-bottom: 20px;
                justify-content: center;
                align-items: center;

            }


            .left-side {
                border: none;
                display: flex;
                justify-content: center;
                text-align: center;
                height: auto;
                max-width: 100%;
            }


            .left-side img {
                width: 100%;
                /* height: auto; */
            }

            .main-img {
                width: 100%;
                height: auto;
            }

            .main-img img {
                width: 100%;
            }

            .right-side {
                margin-left: 0;
                display: flex;
                flex-wrap: wrap;
                width: 100%;

                gap: 20px;
                /* Optional: to control spacing between the items */
            }

            .wide-item {
                width: 100%;
            }

            .contact {
                padding-bottom: 0px;
            }

            .row form {
                /* margin: 0px; */
                /* margin-top: 0px !important; */
                padding: 0px;
            }

            .php-email-form .row {
                gap: 20px;
            }

            .php-email-form .col-lg-12 {
                padding: 0px;
                margin-bottom: 20px;
            }

            .row {
                padding: 0px;
            }

            .php-email-form .row {
                padding: 0px;
                margin: 0px;
                margin-top: 20px;
                margin-top: 0px;
            }

            .row .col-md-4 {
                margin: 0px;
                padding: 0px;

            }

            .row .col-md-4,
            .row .col-md-6 {
                padding: 0px;
                width: 100%;
            }

            .right-side .form-group {
                width: 100%;
            }

            .contact .php-email-form {
                border-bottom: 0px;
                border-top: 0px;
            }

            .wide-item .labal-class {
                width: 100% !important;
            }

            .lower-page {
                display: flex;
                flex-direction: column !important;
                gap: 20px;
            }

            .lower-page,
            .col-md-5 {
                padding: 0px !important;
                order: 1;
                width: 100%;

            }

            .lower-page .col-md-7 {
                order: 2;
                width: 100%;
                padding: 0px;

            }

            .lower-page .col-md-7 .col-lg-12 {
                padding: 0px !important;
                margin-bottom: 20px;
            }

        }

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f2f2f2;
        }

        .form-group span {
            margin-right: 10px;
            color: #666;
        }

        .form-group strong {
            color: #007bff;
        }

        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            width: 100%;
        }

        .input-group select,
        .input-group input {
            border: none;
            outline: none;
            padding: 10px;
            font-size: 14px;
        }

        .input-group select {
            background: url('https://upload.wikimedia.org/wikipedia/commons/a/a4/Flag_of_the_United_States.svg') no-repeat left center;
            background-size: 20px;
            padding-left: 30px;
            width: 60px;
            appearance: none;
        }

        .input-group input {
            flex: 1;
            min-width: 0;
        }

        .input-group input.label {
            max-width: 100px;
            text-align: center;
        }

        . equal-width input-group-text {
            display: flex;
            align-items: center;
            padding: 1rem 1.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #817b7b;
            text-align: center;
            white-space: nowrap;
            background-color: #d1d1d1;
            border: none;
            border-radius: none;

            /* width: 30%; */
        }

        .input-group input::placeholder {
            color: #2e4f9b !important;
            opacity: 1;
        }
    </style>


    {{-- heading section  --}}
    <section class=" p-0">
        <div class="container-fluid pt-3  pr-0 pl-0" style="background: rgb(79, 141, 166)">
            <div class="container-fluid section-title pr-0 pl-0" style="padding-bottom: 0px">
                <h2>{{ __('messages.view_heading') }}  </h2>
            </div>

            <div class="container">


                <div class="">

                    <div class="form row align-items-center"
                         style="padding: 0px 50px 50px 50px;  ">

                        <div class="col-md-9 m-auto">
                            <div class="row">

                                <div class="col-md-9">

                                    <div class="form-group" style="background: #d8d8d8; border: 1px solid #7f7f7f;">
                                        <h1 class="text-center"
                                            style="color: #5a5278">{{ __('messages.view_heading2') }}   </h1>
                                    </div>
                                </div>
                                <div class="col-md-3" style=" align-content:center">


                                    @if (!auth()->user())
                                        <a class="btn-getstarted" href="{{ route('login') }}"
                                           style="background: #fabd05; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 40px;align-content:center; text-wrap: nowrap;">{{ __('messages.login') }}</a>
                                    @else
                                        <a class="btn-getstarted" href="{{ route('logout') }}"
                                           style="background: #fabd05; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 40px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.logout') }}</a><a class="btn-getstarted" href="{{ route('edit.profile') }}"
                                           style="background: #fabd05; color: black; border: 2px solid black; border-radius: 40px; padding: 20px 40px;font-weight: 1000; text-wrap: nowrap;">{{ __('messages.edit_profile') }}</a>
                                    @endif

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        {{-- <div class="container section-title" data-aos="fade-up">
            <h2>{{ __('messages.view_student') }}</h2>
        </div> --}}
        <!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">
                <div class="php-email-form">
                    <div class="container-new">
                        <div class="left-side">
                            <div class="main-img">

                                <img
                                    src="{{ isset($data[0]->studentinfo->image) && $data[0]->studentinfo->image != null ? asset('uploads/' . $data[0]->studentinfo->image) : asset('images/avatar-659651_1280.png') }}"
                                    class="img-fluid" alt="" style="">
                            </div>
                        </div>

                        <div class="right-side">

                            <div class="input-group  wide-item">
                                <span class=" equal-width input-group-text">{{ __('messages.full_name') }}</span>
                                <input type="text" class="form-control" value="{{ $data[0]->name ?? '' }}"
                                       readonly>
                            </div>
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.view_heading_title') }}  </span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0] ? $data[0]['studentinfo']->title : '' }}" readonly>
                            </div>
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.years_of_experience') }}  </span>
                                @php
                                $years_till_now = Carbon\Carbon::parse($data[0]['studentinfo']->registration_date)->diff(Carbon\Carbon::now())->format('%y years');
                                @endphp
                                <input type="text" class="form-control"
                                       value="{{ $years_till_now }}"
                                       readonly>
                            </div>
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.member_id') }}</span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0] ? $data[0]->uuid : '' }}" readonly>
                            </div>
                            {{-- <div class="input-group  mb-3">
                              <span class=" equal-width input-group-text" id="basic-addon1">{{ __('messages.first_name') }}</span>
                              <input type="text" class="form-control" placeholder="{{ $data[0] ? $data[0]->first_name : '' }}" readonly>
                            </div>
                            <div class="input-group  mb-3">
                              <span class=" equal-width input-group-text" id="basic-addon1">{{ __('messages.last_name') }}</span>
                              <input type="text" class="form-control" placeholder="{{ $data[0] ? $data[0]->last_name : '' }}" readonly>
                            </div> --}}
                            {{-- <div class="input-group  mb-3">
                              <span class=" equal-width input-group-text" id="basic-addon1">{{ __('messages.email') }}</span>
                              <input type="text" class="form-control" placeholder="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->professional_email : '' }}" readonly>
                            </div>   --}}


                            {{-- <div class="input-group  mb-3">
                              <span class=" equal-width input-group-text" id="basic-addon1">{{ __('messages.professional_phone') }}</span>
                              <input type="text" class="form-control" placeholder="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->professional_phone : '' }}" readonly>
                            </div>
                            <div class="input-group  mb-3">
                              <span class=" equal-width input-group-text" id="basic-addon1">{{ __('messages.phone') }}</span>
                              <input type="text" class="form-control" placeholder="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->phone : '' }}" readonly>
                            </div> --}}
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.association') }}</span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->department : '' }}"
                                       readonly>
                            </div>
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1"> {{ __('messages.speciality_area') }}   </span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->speciality_area : '' }}"
                                       readonly>
                            </div>
                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.speciality') }}</span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->speciality : '' }}"
                                       readonly>
                            </div>

                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.promotion_year') }}</span>
                                <input type="text" class="form-control"
                                       value="{{ isset($data[0]['studentinfo']) && $data[0]['studentinfo']->registration_date ? Carbon\Carbon::parse($data[0]['studentinfo']->registration_date)->format('Y') : '' }}"
                                       readonly>
                            </div>

                            <div class="input-group  mb-3">
                                <span class=" equal-width input-group-text"
                                      id="basic-addon1">{{ __('messages.country') }}</span>
                                <input type="text" class="form-control"
                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->country : '' }}"
                                       readonly>
                            </div>


                            @if ($data[0]['extrafield'])
                                @foreach ($data[0]['extrafield'] as $item)
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text"
                                          id="basic-addon1">{{ $item->label }}</span>
                                        <input type="text" class="form-control"
                                           value="{{ $item->value }}"
                                           readonly>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <style>
                        .input-wrapper {
                            position: relative;
                        }

                        .input-wrapper input {
                            border: 1px solid gray;
                            border-radius: 6px;
                            position: relative;
                            width: 230px;
                            margin: 10px;
                            line-height: 5ex;
                        }

                        .input-wrapper label {
                            position: absolute;
                            top: -1.8ex;
                            z-index: 1;
                            left: 2em;
                            background-color: white;
                            padding: 0 5px;
                        }


                        .input-wrapper-select label {
                            position: absolute;
                            top: -1.8ex;
                            z-index: 1;
                            left: 14em;
                            background-color: white;
                            padding: 0 5px;
                        }

                        .input-wrapper-select select {
                            margin-top: 0px !important;
                            border: 1px solid gray;
                            border-radius: 6px;
                            position: relative;
                            /* width: 200px; */
                            margin: 10px;
                            line-height: 5ex;
                            padding: 11px 15px;
                        }
                    </style>
                    <style>
                        .input-group {
                            align-items: normal;
                        }

                        .equal-width {
                            width: 130px;
                            white-space: normal;
                            word-wrap: break-word;
                            text-align: center;
                            background: #e1e0e0;
                        }
                    </style>
                    <style>
                        .contact-info select {
                            -webkit-appearance: none;
                            height: 47px;
                            text-align: center;
                            padding: 0 !important;
                            width: 150px;
                        }
                    </style>
                    <div class="row">
                        <div class="col-12">
                            <div class="contact-info">
                                <!-- Phone Input -->
                                <div class="row mb-4">

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> {{ __('messages.phone') }}</label>
                                            <input id="phone1" type="tel" name="phone"
                                                   placeholder="N/A"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->phone : 'N/A' }}"
                                                   disabled readonly contenteditable="false"/>

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for=""> {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="phone">
                                                <option selected>{{ __('messages.primary') }}</option>
                                                <option>{{ __('messages.professional') }}</option>
                                                <option>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> {{ __('messages.phone') }}</label>
                                            <input id="phone2" type="tel" name="professional_phone"
                                                    placeholder="N/A"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->professional_phone : 'N/A' }}"
                                                   disabled readonly contenteditable="false"/>

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for=""> {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="professional_phone_label">
                                                {{-- <option selected disabled>--select--</option> --}}
                                                <option selected>{{ __('messages.professional') }}</option>
                                                <option>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> {{ __('messages.phone') }}</label>
                                            <input id="phone3" type="tel" name="other_phone"
                                                   placeholder="N/A"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->other_phone : 'N/A' }}"
                                                   disabled readonly contenteditable="false"/>

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for=""> {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="other_phone_label">
                                                {{-- <option selected disabled>--select--</option> --}}
                                                <option>{{ __('messages.professional') }}</option>
                                                <option selected>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> Email</label>
                                            <input type="email" name="email" class="email-input" placeholder="Email"
                                                   value="{{ $data[0]  ? $data[0]->email : '' }}"
                                                   disabled readonly contenteditable="false"
                                                   style="margin: 0px">

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for="">  {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="email_label">
                                                <option selected>{{ __('messages.primary') }}</option>
                                                <option>{{ __('messages.professional') }}</option>
                                                <option>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> Email</label>
                                            <input type="email" name="professional_email" class="email-input"
                                                   placeholder="N/A"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->professional_email : '' }}"
                                                   disabled readonly contenteditable="false"
                                                   style="margin: 0px">

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for="">  {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="professional_email_label">
                                                {{-- <option selected disabled > --select--  </option> --}}
                                                <option selected>{{ __('messages.professional') }}</option>
                                                <option>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                        <div>
                                            <label for=""> Email</label>
                                            <input type="email" class="email-input"
                                                   placeholder="N/A"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->other_email : '' }}"
                                                   disabled readonly contenteditable="false"
                                                   style="margin: 0px">

                                        </div>
                                        <div class="input-wrapper-select">
{{--                                            <label for="">  {{ __('messages.label') }}</label>--}}

                                            <select class="label-select" disabled name="other_email_label">
                                                {{-- <option selected disabled> --select--  </option> --}}
                                                <option>{{ __('messages.professional') }}</option>
                                                <option selected>{{ __('messages.select_other') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <script>
                        const phoneInputField1 = document.querySelector("#phone1");
                        const phoneInputField2 = document.querySelector("#phone2");
                        const phoneInputField3 = document.querySelector("#phone3");
                        const phoneInput1 = window.intlTelInput(phoneInputField1, {
                            utilsScript:
                                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                        });

                        const phoneInput2 = window.intlTelInput(phoneInputField2, {
                            utilsScript:
                                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                        });

                        const phoneInput3 = window.intlTelInput(phoneInputField3, {
                            utilsScript:
                                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                        });
                    </script>
                    <div class="row">
                        <div class="col-lg-8">
                            <div id="map-div">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text"
                                              id="basic-addon1">{{ __('messages.office_name') }}</span>
                                        <input type="text" class="form-control"
                                               placeholder="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->office_name : '' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text"
                                              id="basic-addon1"> {{ __('messages.region_prov') }}</span>
                                        <input type="text" class="form-control" name="region"
                                               value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->region : '' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text"
                                              id="basic-addon1">{{ __('messages.city') }}</span>
                                        <input type="text" class="form-control" name="city"
                                               value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->city : '' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text"
                                              id="basic-addon1">{{ __('messages.address') }}</span>
                                        <input type="text" class="form-control" name="address"
                                               value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->address : '' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group  mb-3">
                                        <span class=" equal-width input-group-text" id="basic-addon1">GPS</span>
                                        <input type="text" class="form-control"
                                               value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->lattitude : '' }}"
                                               readonly>
                                        <input type="text" class="form-control"
                                               value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']->longitude : '' }}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


    </section>
    <section class="about section"
             style="padding: 0px; background: #94a3d0; display:flex; justify-content: center; align-items:center; text-align:center; padding: 20px 0px">
        <span style="font-size: 1rem; font-weight: 900px;"> {{ __('messages.footer_label') }}</span>
    </section><!-- /Contact Section -->

@endsection
