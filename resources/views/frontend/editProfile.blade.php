@extends('frontend.layout.app')
@section('home-content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

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
            var latitude = "{{ $data[0]['studentinfo']?->lattitude ?? 'null' }}";
            var longitude = "{{ $data[0]['studentinfo']?->longitude ?? 'null' }}";
            var address = "{{ $data[0]['studentinfo']?->address ?? '' }}";

            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
            console.log('Address:', address);

            var map;
            var marker;

            function initializeMap(lat, lng, title) {
                map = new google.maps.Map(document.getElementById('map-div'), {
                    center: {lat: lat, lng: lng},
                    zoom: 15
                });

                marker = new google.maps.Marker({
                    position: {lat: lat, lng: lng},
                    map: map,
                    title: title
                });

                // Add click event listener to log lat/lng on map click
                map.addListener('click', function(event) {
                    var clickedLat = event.latLng.lat();
                    var clickedLng = event.latLng.lng();

                    // Update the marker position
                    marker.setPosition(new google.maps.LatLng(clickedLat, clickedLng));

                    // Optionally, you can center the map at the new marker position
                    map.panTo(new google.maps.LatLng(clickedLat, clickedLng));

                    console.log('Map clicked at latitude:', clickedLat, 'longitude:', clickedLng);

                    // If you have input fields to display the latitude and longitude:
                    if (document.getElementById('latitude') && document.getElementById('longitude')) {
                        document.getElementById('latitude').value = clickedLat;
                        document.getElementById('longitude').value = clickedLng;
                    }
                });
            }

            function geocodeAddress(address) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status === 'OK') {
                        var location = results[0].geometry.location;
                        initializeMap(location.lat(), location.lng(), address);
                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            if (latitude !== 'null' && longitude !== 'null') {
                initializeMap(parseFloat(latitude), parseFloat(longitude), address);
            } else if (address) {
                geocodeAddress(address);
            } else {
                console.error('No valid location data available.');
            }
        }

        window.onload = initMap;
    </script>

    <style>
        .form-group select {

            line-height: 6.5ex;
        }

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
            padding: 10px;
            gap: 20px;
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
            height: 395px;
        }

        .main-img {
            border: 1px solid #ccc;
            /* height: 300px; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-side img {
            height: 395px;
            width: 100%;
        }

        .right-side {
            flex: 2;
            margin-left: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 33px;
        }

        .wide-item {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ccc;
            /* padding: 10px; */
            /* background-color: #f2f2f2; */
            height: 70px;
        }

        .form-group span {
            margin-right: 10px;
            color: #666;
        }

        .form-group input {
            color: black;
            height: 100%;
            font-weight: bold;
            font-size: 24px;
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

        .labal-class {
            background: #c00000;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;

        }

        .text-area {
            color: #4e65b2;
            font-weight: bold;
            font-size: 1rem;
        }

        .php-email-form .row {
            padding: 5px 30px;
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


            .main-img {
                width: 100%;
                /* height: auto; */
            }

            .main-img img {
                height: 325px;
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

            }

            .lower-page .col-md-7 .col-lg-12 {
                padding: 0px !important;
                margin-bottom: 20px;
            }

        }
    </style>

    <form action="{{ route('update.profile') }}" method="post" enctype="multipart/form-data" id="addressForm">
        @csrf
        <section class=" p-0">
            <div class="container-fluid pt-3  pr-0 pl-0" style="background: rgb(79, 141, 166)">
                <div class="container-fluid section-title pr-0 pl-0" style="padding-bottom: 0px">
                    <h2>{{ __('messages.view_heading') }}</h2>
                </div>

                <div class="container">


                    <div class="">

                        <div class="form row align-items-center" style="padding: 0px 50px 50px 50px;  ">

                            <div class="col-md-12 m-auto">
                                <div class="row">

                                    <div class="col-md-8">

                                        <div style="background: #d8d8d8; border: 1px solid #7f7f7f; padding: 20px 10px">
                                            <h1 class="text-center" style="color: #5a5278">
                                                {{ __('messages.update_profile_heading') }} </h1>
                                            <h3 class="text-center" style="color: #f90909">
                                                {{ __('messages.update_profile_heading2') }} </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4"
                                         style=" align-content:center; width: 17.333333%;     margin-left: 100px;">

                                        <button type="submit" class="btn-getstarted"
                                                style="background: #52b252; color: black; border: 2px solid black; border-radius: 40px; padding: 19px 50px;align-content:center">
                                            Save
                                        </button>

                                        <button type="reset" class="btn-getstarted"
                                                style="background: #a3a098; color: black; border: 2px solid black; border-radius: 40px; padding: 19px 40px;font-weight: 1000;     margin-top: 10px;">
                                            <a href="{{ route('view.profile') }}"
                                               class="text-black text-decoration-none">Cancel</a></button>


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

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="php-email-form">
                        <div class="container-new">
                            <div class="left-side">
                                <div class="main-img">
                                    <img
                                        src="{{ isset($data[0]->studentinfo->image) && $data[0]->studentinfo->image != null ? asset('uploads/' . $data[0]->studentinfo->image) : asset('images/avatar-659651_1280.png') }}"
                                        alt="" style="">
                                </div>
                                <div class="col-12 mt-3">
                                    <!-- Image -->
                                    <div class="form-group">
                                        <label class="labal-class" style="background: #28ff89; color:#7e7e7e;"
                                               for="image">{{ __('Image') }}</label>
                                        <input type="file" name="image" id="image"
                                               class="form-control @error('image') is-invalid @enderror"
                                               style="font-size: 1rem; padding:20px; color: #4e65b2;"
                                               @if (!$activeFields->contains('field_name', 'image')) disabled @endif>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="right-side">
                                <!-- User ID -->
                                <div class="form-group wide-item">
                                    <label class="labal-class" style="width: 31%"
                                           for="name">{{ __('messages.full_name') }}</label>
                                    <input type="text" name="name" id="name"
                                           value="{{ $data[0]->name ?? '' }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           readonly contenteditable="false" disabled >
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- First Name -->
                                <div class="form-group">
                                    <label class="labal-class" for="title"
                                        {{-- @if ($activeFields->contains('field_name', 'title'))   style="background: #28ff89; color:#7e7e7e;" @endif --}}>{{ __('messages.view_heading_title') }}</label>
                                    <input type="text" name="title" id="title"
                                           value="{{ $data[0] ? $data[0]['studentinfo']?->title : '' }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           readonly contenteditable="false" disabled >
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="form-group">
                                    <label class="labal-class" for="years_of_experience">{{ __('messages.years_of_experience') }} </label>
                                    @php
                                        $years_till_now = Carbon\Carbon::parse($data[0]['studentinfo']?->registration_date)->diff(Carbon\Carbon::now())->format('%y years');
                                    @endphp
                                    <input type="text" name="years_of_experience" id="years_of_experience"
                                           value="{{ $years_till_now }}"
                                           class="form-control @error('years_of_experience') is-invalid @enderror"
                                           readonly contenteditable="false" disabled >
                                    @error('years_of_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group  ">
                                    <label class="labal-class" for="uuid">{{ __('messages.member_id') }}</label>
                                    <input type="text" name="uuid" id="uuid"
                                           value="{{ $data[0] ? $data[0]->uuid : '' }}"
                                           class="form-control @error('uuid') is-invalid @enderror" readonly
                                           contenteditable="false"
                                           @if (!$activeFields->contains('field_name', 'uuid')) disabled @endif>
                                    @error('uuid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Department -->
                                <div class="form-group">
                                    <label class="labal-class" for="department">{{ __('messages.association') }}</label>
                                    <input type="text" name="department" id="department"
                                           value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->department : '' }}"
                                           disabled readonly contenteditable="false"
                                           class="form-control @error('department') is-invalid @enderror"
                                           @if (!$activeFields->contains('field_name', 'department')) disabled @endif>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Speciality -->
                                <div class="form-group">
                                    <label class="labal-class" for="speciality_area"
                                           style="background: #28ff89; color:#7e7e7e;">{{ __('messages.speciality_area') }}
                                    </label>
                                    <select name="speciality_area" class="form-control" id="">
                                        <option value="" selected disabled>--select--</option>
                                        @if (count($specialityArea) > 0)
                                            @foreach ($specialityArea as $item)
                                                <option value="{{ $item->title }}"
                                                        @selected(old('speciality_area', $data[0]['studentinfo']?->speciality_area) == $item->title ? 'selected' : '')>
                                                    {{ $item->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!-- Speciality -->
                                <div class="form-group">
                                    <label class="labal-class" for="speciality"
                                           style="background: #28ff89; color:#7e7e7e;">{{ __('messages.speciality') }}</label>
                                    <select name="speciality" class="form-control" id="">
                                        <option value="" selected disabled>--select--</option>
                                        @if (count($speciality) > 0)
                                            @foreach ($speciality as $specialityItem)
                                                <option value="{{ $specialityItem->title }}"
                                                        @selected(old('speciality', $data[0]['studentinfo']?->speciality) == $specialityItem->title ? 'selected' : '')>
                                                    {{ $specialityItem->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="promotion_year"
                                           class="pb-2 labal-class">{{ __('messages.promotion_year') }} </label>
                                    <input type="text" name="promotion_year"
                                           value="{{ isset($data[0]['studentinfo']) && $data[0]['studentinfo']?->registration_date ? Carbon\Carbon::parse($data[0]['studentinfo']?->registration_date)->format('Y') : '' }}"
                                           class="form-control "
                                            disabled readonly>
                                </div>
                                <!-- Country -->
                                <div class="form-group">
                                    <label for="country" class="pb-2 labal-class">{{ __('messages.country') }}</label>
{{--                                    <select id="countrySelect-show" name="country" class="form-control ">--}}
{{--                                        <input value="{{ $data[0]['studentinfo']?->country ?? 'N/A' }}" readonly>--}}
                                    <input type="text" name="promotion_year"
                                           value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->country : '' }}"
                                           class="form-control "
                                           disabled readonly>
{{--                                    </select>--}}
                                    <select id="countrySelect" name="country" class="form-control d-none">
                                        <option value="">--Select Country--</option>
{{--                                        @if($data[0]['studentinfo']?->country)--}}
{{--                                            <option value="{{ $data[0]['studentinfo']?->country }}">{{ $data[0]['studentinfo']?->country }}</option>--}}
{{--                                        @endif--}}
                                    </select>
                                    {{-- <input type="text" name="country" id="countrySelect"
                                        value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->country : '' }}"    readonly contenteditable="false"
                                        class="form-control @error('country') is-invalid @enderror"
                                        @if (!$activeFields->contains('field_name', 'country')) disabled @endif> --}}
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

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
                                width: 210px;
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
{{--                                    <!-- Phone Input -->--}}
{{--                                    <div class="row mb-4">--}}

{{--                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">--}}
{{--                                            <div>--}}
{{--                                                <label for=""> {{ __('messages.phone') }}</label>--}}
{{--                                                <input id="phone1" type="tel" name="phone"--}}
{{--                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->phone : '' }}"/>--}}
{{--                                                <input type="hidden" id="country_code_1" name="country_code_1">--}}
{{--                                            </div>--}}
{{--                                            <div class="input-wrapper-select">--}}
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

{{--                                                <select class="label-select" disabled name="phone">--}}
{{--                                                    <option selected>{{ __('messages.primary') }}</option>--}}
{{--                                                    <option>{{ __('messages.professional') }}</option>--}}
{{--                                                    <option>{{ __('messages.select_other') }}</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">--}}
{{--                                            <div>--}}
{{--                                                <label for=""> {{ __('messages.phone') }}</label>--}}
{{--                                                <input id="phone2" type="tel" name="professional_phone"--}}
{{--                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->professional_phone : '' }}"/>--}}
{{--                                                <input type="hidden" id="country_code_2" name="country_code_2">--}}
{{--                                            </div>--}}
{{--                                            <div class="input-wrapper-select">--}}
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

{{--                                                <select class="label-select" disabled name="professional_phone_label">--}}
{{--                                                    --}}{{-- <option selected disabled>--select--</option> --}}
{{--                                                    <option selected>{{ __('messages.professional') }}</option>--}}
{{--                                                    <option>{{ __('messages.select_other') }}</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">--}}
{{--                                            <div>--}}
{{--                                                <label for=""> {{ __('messages.phone') }}</label>--}}
{{--                                                <input id="phone3" type="tel" name="other_phone"--}}
{{--                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->other_phone : '' }}"/>--}}
{{--                                                <input type="hidden" id="country_code_3" name="country_code_3">--}}
{{--                                            </div>--}}
{{--                                            <div class="input-wrapper-select">--}}
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

{{--                                                <select class="label-select" disabled name="other_phone_label">--}}
{{--                                                    --}}{{-- <option selected disabled>--select--</option> --}}
{{--                                                    <option>{{ __('messages.professional') }}</option>--}}
{{--                                                    <option selected>{{ __('messages.select_other') }}</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <!-- Phone Input -->
                                    <div class="row mb-4">
                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                            <div>
                                                <label for="phone1"> {{ __('messages.phone') }}</label>
                                                <input id="phone1" type="tel" name="phone" readonly
                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->phone : '' }}"/>
                                                <input type="hidden" id="country_code_1" name="country_code_1">
                                                <span id="valid-msg-1" class="text-success d-none"><i class="fa-solid fa-check"></i> Valid</span>
                                                <span id="error-msg-1" class="text-danger d-none"><i class="fa-solid fa-xmark"></i></span>
                                            </div>
                                            <div class="input-wrapper-select">
                                                <select class="label-select" disabled name="phone_label">
                                                    <option selected>{{ __('messages.primary') }}</option>
                                                    <option>{{ __('messages.professional') }}</option>
                                                    <option>{{ __('messages.select_other') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                            <div>
                                                <label for="phone2"> {{ __('messages.phone') }}</label>
                                                <input id="phone2" type="tel" name="professional_phone"
                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->professional_phone : '' }}"/>
                                                <input type="hidden" id="country_code_2" name="country_code_2">
                                                <span id="valid-msg-2" class="text-success d-none"><i class="fa-solid fa-check"></i> Valid</span>
                                                <span id="error-msg-2" class="text-danger d-none"></span>
                                            </div>
                                            <div class="input-wrapper-select">
                                                <select class="label-select" disabled name="professional_phone_label">
                                                    <option selected>{{ __('messages.professional') }}</option>
                                                    <option>{{ __('messages.select_other') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="input-wrapper col-12 col-lg-6 col-xl-4 d-flex">
                                            <div>
                                                <label for="phone3"> {{ __('messages.phone') }}</label>
                                                <input id="phone3" type="tel" name="other_phone"
                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->other_phone : '' }}"/>
                                                <input type="hidden" id="country_code_3" name="country_code_3">
                                                <span id="valid-msg-3" class="text-success d-none"><i class="fa-solid fa-check"></i> Valid</span>
                                                <span id="error-msg-3" class="text-danger d-none"></span>
                                            </div>
                                            <div class="input-wrapper-select">
                                                <select class="label-select" disabled name="other_phone_label">
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
                                                <input type="email" name="email" class="email-input"
                                                       placeholder="Email" value="{{ $data[0] ? $data[0]->email : '' }}"
                                                       readonly contenteditable="false" style="margin: 0px">

                                            </div>
                                            <div class="input-wrapper-select">
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

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
                                                       placeholder="Email"
                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->professional_email : '' }}"
                                                       style="margin: 0px">

                                            </div>
                                            <div class="input-wrapper-select">
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

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
                                                <input type="email" class="email-input" placeholder="Email"
                                                       name="other_email"
                                                       value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->other_email : '' }}"
                                                       style="margin: 0px">

                                            </div>
                                            <div class="input-wrapper-select">
{{--                                                <label for=""> {{ __('messages.label') }}</label>--}}

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

{{--                        <script>--}}
{{--                            const phoneInputField1 = document.querySelector("#phone1");--}}
{{--                            const phoneInputField2 = document.querySelector("#phone2");--}}
{{--                            const phoneInputField3 = document.querySelector("#phone3");--}}
{{--                            const phoneInput1 = window.intlTelInput(phoneInputField1, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput2 = window.intlTelInput(phoneInputField2, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput3 = window.intlTelInput(phoneInputField3, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            // Update hidden country code fields before form submission--}}
{{--                            document.querySelector('#addressForm').addEventListener('submit', function () {--}}
{{--                                const countryData1 = phoneInput1.getSelectedCountryData();--}}
{{--                                const countryData2 = phoneInput2.getSelectedCountryData();--}}
{{--                                const countryData3 = phoneInput3.getSelectedCountryData();--}}

{{--                                document.querySelector('#country_code_1').value = countryData1.dialCode;--}}
{{--                                document.querySelector('#country_code_2').value = countryData2.dialCode;--}}
{{--                                document.querySelector('#country_code_3').value = countryData3.dialCode;--}}
{{--                            });--}}
{{--                        </script>--}}

{{--                        <script>--}}
{{--                            const phoneInputField1 = document.querySelector("#phone1");--}}
{{--                            const phoneInputField2 = document.querySelector("#phone2");--}}
{{--                            const phoneInputField3 = document.querySelector("#phone3");--}}

{{--                            const phoneInput1 = window.intlTelInput(phoneInputField1, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput2 = window.intlTelInput(phoneInputField2, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput3 = window.intlTelInput(phoneInputField3, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            function validatePhoneLength(phoneInput) {--}}
{{--                                const countryData = phoneInput.getSelectedCountryData();--}}
{{--                                console.log('Country Data:', countryData);--}}
{{--                                const nationalNumber = phoneInput.getNationalNumber();--}}
{{--                                const isValid = phoneInput.isValidNumber();--}}

{{--                                // This will vary depending on how you want to validate the number--}}
{{--                                const minLength = 10;  // or whatever length based on the country format--}}
{{--                                const maxLength = 15;  // or whatever length based on the country format--}}

{{--                                if (nationalNumber.length < minLength || nationalNumber.length > maxLength) {--}}
{{--                                    phoneInputField1.setCustomValidity(`Phone number must be between ${minLength} and ${maxLength} digits.`);--}}
{{--                                    alert('Please enter valid phone numbers.');--}}
{{--                                } else {--}}
{{--                                    phoneInputField1.setCustomValidity(""); // Clear the error if valid--}}
{{--                                }--}}

{{--                                return isValid;--}}
{{--                            }--}}

{{--                            phoneInputField1.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput1);--}}
{{--                            });--}}

{{--                            phoneInputField2.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput2);--}}
{{--                            });--}}

{{--                            phoneInputField3.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput3);--}}
{{--                            });--}}

{{--                            // Update hidden country code fields before form submission--}}
{{--                            document.querySelector('#addressForm').addEventListener('submit', function (e) {--}}
{{--                                const countryData1 = phoneInput1.getSelectedCountryData();--}}
{{--                                const countryData2 = phoneInput2.getSelectedCountryData();--}}
{{--                                const countryData3 = phoneInput3.getSelectedCountryData();--}}

{{--                                document.querySelector('#country_code_1').value = countryData1.dialCode;--}}
{{--                                document.querySelector('#country_code_2').value = countryData2.dialCode;--}}
{{--                                document.querySelector('#country_code_3').value = countryData3.dialCode;--}}

{{--                                if (!validatePhoneLength(phoneInput1) || !validatePhoneLength(phoneInput2) || !validatePhoneLength(phoneInput3)) {--}}
{{--                                    e.preventDefault(); // Prevent form submission if validation fails--}}
{{--                                    alert('Please enter valid phone numbers.');--}}
{{--                                }--}}
{{--                            });--}}
{{--                        </script>--}}

{{--                        <script>--}}
{{--                            const phoneInputField1 = document.querySelector("#phone1");--}}
{{--                            const phoneInputField2 = document.querySelector("#phone2");--}}
{{--                            const phoneInputField3 = document.querySelector("#phone3");--}}

{{--                            const phoneInput1 = window.intlTelInput(phoneInputField1, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput2 = window.intlTelInput(phoneInputField2, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            const phoneInput3 = window.intlTelInput(phoneInputField3, {--}}
{{--                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                            });--}}

{{--                            function validatePhoneLength(phoneInput, inputField) {--}}
{{--                                const isValid = phoneInput.isValidNumber();--}}
{{--                                const nationalNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.NATIONAL);--}}

{{--                                const minLength = 10;  // Minimum length (adjust as needed)--}}
{{--                                const maxLength = 15;  // Maximum length (adjust as needed)--}}

{{--                                if (nationalNumber.length < minLength || nationalNumber.length > maxLength) {--}}
{{--                                    inputField.setCustomValidity(`Phone number must be between ${minLength} and ${maxLength} digits.`);--}}
{{--                                } else {--}}
{{--                                    inputField.setCustomValidity(""); // Clear the error if valid--}}
{{--                                }--}}

{{--                                return isValid;--}}
{{--                            }--}}

{{--                            phoneInputField1.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput1, phoneInputField1);--}}
{{--                            });--}}

{{--                            phoneInputField2.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput2, phoneInputField2);--}}
{{--                            });--}}

{{--                            phoneInputField3.addEventListener('blur', function () {--}}
{{--                                validatePhoneLength(phoneInput3, phoneInputField3);--}}
{{--                            });--}}

{{--                            // Update hidden country code fields before form submission--}}
{{--                            document.querySelector('#addressForm').addEventListener('submit', function (e) {--}}
{{--                                const countryData1 = phoneInput1.getSelectedCountryData();--}}
{{--                                const countryData2 = phoneInput2.getSelectedCountryData();--}}
{{--                                const countryData3 = phoneInput3.getSelectedCountryData();--}}

{{--                                document.querySelector('#country_code_1').value = countryData1.dialCode;--}}
{{--                                document.querySelector('#country_code_2').value = countryData2.dialCode;--}}
{{--                                document.querySelector('#country_code_3').value = countryData3.dialCode;--}}

{{--                                if (!validatePhoneLength(phoneInput1, phoneInputField1) ||--}}
{{--                                    !validatePhoneLength(phoneInput2, phoneInputField2) ||--}}
{{--                                    !validatePhoneLength(phoneInput3, phoneInputField3)) {--}}
{{--                                    e.preventDefault(); // Prevent form submission if validation fails--}}
{{--                                    alert('Please enter valid phone numbers.');--}}
{{--                                }--}}
{{--                            });--}}
{{--                        </script>--}}


                        <script>
                            // Initialize phone inputs
                            const phoneInputField1 = document.querySelector("#phone1");
                            const phoneInputField2 = document.querySelector("#phone2");
                            const phoneInputField3 = document.querySelector("#phone3");

                            // Error and success message elements
                            const errorMsg1 = document.querySelector("#error-msg-1");
                            const validMsg1 = document.querySelector("#valid-msg-1");

                            const errorMsg2 = document.querySelector("#error-msg-2");
                            const validMsg2 = document.querySelector("#valid-msg-2");

                            const errorMsg3 = document.querySelector("#error-msg-3");
                            const validMsg3 = document.querySelector("#valid-msg-3");

                            // Error message map
                            const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

                            // Initialize intlTelInput instances
                            const phoneInput1 = window.intlTelInput(phoneInputField1, {
                                initialCountry: "us",
                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                            });

                            const phoneInput2 = window.intlTelInput(phoneInputField2, {
                                initialCountry: "us",
                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                            });

                            const phoneInput3 = window.intlTelInput(phoneInputField3, {
                                initialCountry: "us",
                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                            });

                            const reset = (inputField, errorMsg, validMsg) => {
                                inputField.classList.remove("error");
                                errorMsg.innerHTML = "";
                                errorMsg.classList.add("d-none");
                                validMsg.classList.add("d-none");
                            };

                            const showError = (inputField, errorMsg, msg) => {
                                inputField.classList.add("error");
                                errorMsg.innerHTML = `<i class="fa-solid fa-xmark"></i> ${msg}`;
                                errorMsg.classList.remove("d-none");
                            };

                            // Phone validation function
                            const validatePhoneNumber = (phoneInput, inputField, errorMsg, validMsg) => {
                                reset(inputField, errorMsg, validMsg);
                                // if (!inputField.value.trim()) {
                                //     showError(inputField, errorMsg, "Required");
                                // } else
                                if (phoneInput.isValidNumber()) {
                                    validMsg.classList.remove("d-none");
                                } else {
                                    const errorCode = phoneInput.getValidationError();
                                    const msg = errorMap[errorCode] || "Invalid number";
                                    showError(inputField, errorMsg, msg);
                                }
                            };

                            // Add event listeners for each phone input
                            phoneInputField1.addEventListener('blur', function () {
                                validatePhoneNumber(phoneInput1, phoneInputField1, errorMsg1, validMsg1);
                            });

                            phoneInputField2.addEventListener('blur', function () {
                                validatePhoneNumber(phoneInput2, phoneInputField2, errorMsg2, validMsg2);
                            });

                            phoneInputField3.addEventListener('blur', function () {
                                validatePhoneNumber(phoneInput3, phoneInputField3, errorMsg3, validMsg3);
                            });

                            // Reset on change or keyup
                            phoneInputField1.addEventListener('change', function () {
                                reset(phoneInputField1, errorMsg1, validMsg1);
                                validatePhoneNumber(phoneInput1, phoneInputField1, errorMsg1, validMsg1);
                            });
                            phoneInputField1.addEventListener('keyup', function () {
                                reset(phoneInputField1, errorMsg1, validMsg1);
                                validatePhoneNumber(phoneInput1, phoneInputField1, errorMsg1, validMsg1);
                            });

                            phoneInputField2.addEventListener('change', function () {
                                reset(phoneInputField2, errorMsg2, validMsg2);
                                validatePhoneNumber(phoneInput2, phoneInputField2, errorMsg2, validMsg2);
                            });
                            phoneInputField2.addEventListener('keyup', function () {
                                reset(phoneInputField2, errorMsg2, validMsg2);
                                validatePhoneNumber(phoneInput2, phoneInputField2, errorMsg2, validMsg2);
                            });

                            phoneInputField3.addEventListener('change', function () {
                                reset(phoneInputField3, errorMsg3, validMsg3);
                                validatePhoneNumber(phoneInput3, phoneInputField3, errorMsg3, validMsg3);
                            });
                            phoneInputField3.addEventListener('keyup', function () {
                                reset(phoneInputField3, errorMsg3, validMsg3);
                                validatePhoneNumber(phoneInput3, phoneInputField3, errorMsg3, validMsg3);
                            });

                            // Update hidden country code fields before form submission
                            document.querySelector('#addressForm').addEventListener('submit', function () {
                                const countryData1 = phoneInput1.getSelectedCountryData();
                                const countryData2 = phoneInput2.getSelectedCountryData();
                                const countryData3 = phoneInput3.getSelectedCountryData();

                                document.querySelector('#country_code_1').value = countryData1.dialCode;
                                document.querySelector('#country_code_2').value = countryData2.dialCode;
                                document.querySelector('#country_code_3').value = countryData3.dialCode;

                                validatePhoneNumber(phoneInput1, phoneInputField1, errorMsg1, validMsg1);
                                validatePhoneNumber(phoneInput2, phoneInputField2, errorMsg2, validMsg2);
                                validatePhoneNumber(phoneInput3, phoneInputField3, errorMsg3, validMsg3);
                            });
                        </script>



                        <div class="lower-page" style="display: flex; flex-direction: row; margin-top:20px;">
                            <div class="col-md-7">
                                <div class="col-lg-12" style="padding: 1.5rem;">
                                    <div id="map-div">
                                    </div>
                                </div>
                                <div class="col-lg-12" style="padding: 1.5rem;">
                                    <span class="text-danger fw-bold">
                                        {{ __('messages.map_note') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5"
                                 style="display:flex; gap:30px; flex-direction: column; padding: 20px 20px 20px 0px;">


                                <div class="form-group">
                                    <label class="labal-class" style="background: #28ff89; color:#7e7e7e;"
                                           for="office_name">{{ __('messages.office_name') }}</label>
                                    <input type="text" name="office_name"
                                           value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->office_name : '' }}"
                                           class="form-control @error('office_name') is-invalid @enderror"
                                           @if (!$activeFields->contains('field_name', 'office_name')) disabled
                                           readonly @endif>
                                    @error('office_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Region -->
                                <div class="form-group">
                                    <label class="labal-class" style="background: #28ff89; color:#7e7e7e;"
                                           for="region">{{ __('messages.region_prov') }}</label>
                                    <select id="stateSelect" name="region" class="form-control ">
                                        <option value="no">Select {{ __('messages.region_prov') }}</option>
                                    </select>
                                    {{-- <input type="text" name="region" id="stateSelect"
                                        value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->region : '' }}"
                                        class="form-control @error('region') is-invalid @enderror"
                                        @if (!$activeFields->contains('field_name', 'region')) disabled @endif> --}}
                                    @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lattitude -->
                                <div class="form-group">
                                    <label for="name-field" class="pb-2 labal-class"
                                           style="background: #28ff89; color:#7e7e7e;"
                                           for="city">{{ __('messages.city') }}</label>
                                    <select id="citySelect" name="city" class="form-control ">
                                        <option value="">
                                            {{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->city : 'Select City' }}
                                        </option>
                                    </select>
                                    {{-- <input type="text" name="city" id="citySelect"
                                        value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->city : '' }}"
                                        class="form-control @error('city') is-invalid @enderror"
                                        @if (!$activeFields->contains('field_name', 'city')) disabled @endif> --}}
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                                <div class="form-group">
                                    <label class="labal-class" for="address"
                                           style="background: #28ff89; color:#7e7e7e;">{{ __('messages.address') }}</label>
                                    <input type="text" name="address" id="address"
                                           class="form-control @error('address') is-invalid @enderror"
                                             value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->address : '' }}"
                                           placeholder="Enter your address" onkeypress="loadnap()"
                                           @if (!$activeFields->contains('field_name', 'address')) disabled @endif>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row p-0">

                                    <div class="col-12">
                                        <!-- Lattitude -->
                                        <div class="form-group">
                                            <label for="name-field" class="pb-2 labal-class"
                                                   style="background: #28ff89; color:#7e7e7e;"
                                                   for="lattitude">GPS</label>
                                            <input type="text" name="lattitude" id="latitude"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->lattitude : '' }}"
                                                   placeholder="latitude"
                                                   class="form-control @error('lattitude') is-invalid @enderror"
                                                   @if (!$activeFields->contains('field_name', 'lattitude')) disabled @endif>
                                            <input type="text" name="longitude" id="longitude"
                                                   value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->longitude : '' }}"
                                                   placeholder="longitude"
                                                   class="form-control @error('longitude') is-invalid @enderror"
                                                   @if (!$activeFields->contains('field_name', 'longitude')) disabled @endif>
                                            @error('lattitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>

                                    </div>
                                    {{-- <div class="col-6">
                                        <!-- Longitude -->
                                        <div class="form-group">
                                            <label class="labal-class" style="background: #28ff89; color:#7e7e7e;"
                                                for="longitude">{{ __('Longitude') }}</label>
                                            <input type="text" name="longitude" id="longitude"
                                                value="{{ $data[0]['studentinfo'] ? $data[0]['studentinfo']?->longitude : '' }}"
                                                class="form-control @error('longitude') is-invalid @enderror"
                                                @if (!$activeFields->contains('field_name', 'longitude')) disabled @endif>
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div> --}}
                                </div>


                                @if (!empty($data[0]['extrafield']))
                                    @foreach ($data[0]['extrafield'] as $item)
                                        <div class="col-md-6">
                                            <label for="{{ $item['label'] }}" class="pb-2">{{ $item['label'] }}
                                                :</label>
                                            <input type="text" name="extrafield[{{ $item['label'] }}]"
                                                   class="form-control @error('extrafield.' . $item['label']) is-invalid @enderror"
                                                   value="{{ $item['value'] }}">
                                            @error('extrafield.' . $item['label'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                        </div>


                        <div>
                            {{-- <label for="countrySelect">Country:</label>
                            <select id="countrySelect">
                                <option value="">Select Country</option>
                            </select>
                     --}}
                            {{-- <label for="stateSelect">State/Province:</label>
                            <select id="stateSelect" disabled>
                                <option value="">Select State/Province</option>
                            </select>

                            <label for="citySelect">City:</label>
                            <select id="citySelect" disabled>
                                <option value="">Select City</option>
                            </select> --}}
                        </div>

                        <script>
                            const dataUrl =
                                'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json';

                            // Fetch the JSON data
                            fetch(dataUrl)
                                .then(response => response.json())
                                .then(data => {
                                    const countrySelect = document.getElementById('countrySelect');
                                    const stateSelect = document.getElementById('stateSelect');
                                    const citySelect = document.getElementById('citySelect');

                                    const userCountry = '{{ $data[0]['studentinfo']?->country }}';
                                    const userState = '{{ $data[0]['studentinfo']?->region }}';
                                    const userCity = '{{ $data[0]['studentinfo']?->city }}';

                                    // Populate countries dropdown
                                    data.forEach(country => {
                                        const option = document.createElement('option');
                                        option.value = country.name;
                                        option.textContent = country.name;
                                        countrySelect.appendChild(option);
                                    });

                                    // Event listener for country selection
                                    // countrySelect.addEventListener('change', function () {
                                    //
                                    // });
                                    const selectedCountry = '{{ $data[0]['studentinfo']?->country }}';
                                    const selectedCountryData = data.find(country => country.name === selectedCountry);

                                    // Populate states dropdown
                                    if (selectedCountryData && selectedCountryData.states) {
                                        stateSelect.innerHTML =
                                            '<option value="no">Select State/Province</option>'; // Clear previous options
                                        selectedCountryData.states.forEach(state => {
                                            const option = document.createElement('option');
                                            option.value = state.name;
                                            option.textContent = state.name;
                                            if (state.name === '{{ $data[0]['studentinfo']?->region }}') {
                                                option.selected = true;
                                            }
                                            stateSelect.appendChild(option);
                                        });
                                        stateSelect.disabled = false;
                                    } else {
                                        stateSelect.innerHTML = '<option value="no">' +
                                            'Select State/Province' +
                                            // if userState is not empty, set it as selected otherwise show the 'Select State/Province' option
                                            // (userState ? userState : 'Select State/Province') +
                                            '</option>';
                                        stateSelect.disabled = true;
                                        citySelect.innerHTML = '<option value="no">' +
                                            'Select City' +
                                            // if userCity is not empty, set it as selected otherwise show the 'Select City' option
                                            // (userCity ? userCity : 'Select City') +
                                            '</option>';
                                        citySelect.disabled = true;
                                    }

                                    // Event listener for state selection
                                    stateSelect.addEventListener('change', function () {
                                        const selectedCountry = "{{ $data[0]['studentinfo']?->country }}";
                                        const selectedState = this.value;
                                        const selectedCountryData = data.find(country => country.name === selectedCountry);

                                        if (selectedCountryData) {
                                            const selectedStateData = selectedCountryData.states.find(state => state.name ===
                                                selectedState);

                                            // Populate cities dropdown
                                            if (selectedStateData && selectedStateData.cities) {
                                                citySelect.innerHTML =
                                                    '<option value="no">Select City</option>'; // Clear previous options
                                                selectedStateData.cities.forEach(city => {
                                                    const option = document.createElement('option');
                                                    option.value = city.name;
                                                    option.textContent = city.name;
                                                    citySelect.appendChild(option);
                                                });
                                                citySelect.disabled = false;
                                            } else {
                                                citySelect.innerHTML = '<option value="no">' +
                                                    'Select City' +
                                                    // if userCity is not empty, set it as selected otherwise show the 'Select City' option
                                                    // (userCity ? userCity : 'Select City') +
                                                    '</option>';
                                                citySelect.disabled = true;
                                            }
                                        } else {
                                            citySelect.innerHTML = '<option value="no">' +
                                                'Select City' +
                                                // if userCity is not empty, set it as selected otherwise show the 'Select City' option
                                                // (userCity ? userCity : 'Select City') +
                                                '</option>';
                                            citySelect.disabled = true;
                                        }
                                    });
                                })
                                .catch(error => console.error('Error fetching data:', error));

                            // trigger the change event on country select to populate the state select on document ready and when the country is already selected
                            document.addEventListener('DOMContentLoaded', function () {
                                const event = new Event('change');
                                // document.getElementById('stateSelect').dispatchEvent(event);
                            });

                        </script>

                    </div>
                </div>
        </section>
    </form>

    <section class="about section"
             style="padding: 0px; background: #94a3d0; display:flex; justify-content: center; align-items:center; text-align:center; padding: 20px 0px">
        <span style="font-size: 1rem; font-weight: 900px;">{{ __('messages.footer_label') }}</span>
    </section><!-- /Contact Section -->

    <!-- /Contact Section -->

    <script>
        function initAutocomplete() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    return;
                }

                // Get the address components and populate the form fields
                var addressComponents = place.address_components;
                var country = '';
                var city = '';

                for (var i = 0; i < addressComponents.length; i++) {
                    var component = addressComponents[i];
                    var componentType = component.types[0];

                    if (componentType === 'country') {
                        country = component.long_name;
                    } else if (componentType === 'locality') {
                        city = component.long_name;
                    } else if (componentType === 'administrative_area_level_1' && !city) {
                        city = component.long_name;
                    }
                }


                console.log('map load');
                console.log(country);
                console.log(city);
                console.log(place.geometry.location.lat());
                console.log(place.geometry.location.lng());
                // document.getElementById('country').empty();
                // document.getElementById('country').value = country;
                // document.getElementById('city').value = city;
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }

        function initMap() {
            const userLocation = {
                lat: 0,
                lng: 0
            };
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: userLocation,
            });

            const marker = new google.maps.Marker({
                position: userLocation,
                map: map,
            });
        }


        function loadnap() {
            initAutocomplete();
            initMap();
        }
    </script>

@endsection
