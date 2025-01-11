@extends('admin.layout.app')
@section('admin-content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Students</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 mb-4">

            <form action="{{ route('admin.update.student') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button class="btn btn-primary">Update Student <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <input type="hidden" name="id"  value="{{$data->id}}" >

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <!-- Heading with separator -->
                                    <div class="col-lg-12">
                                        <div class="form-group mt-3">
                                            <h4 class="card-title mb-4">Personal Information</h4>
                                            <div class="border-bottom"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="uuid">Member ID <span class="text-danger">*</span></label>
                                            <input type="text" value="{{$data->uuid}}" class="form-control @error('uuid') is-invalid @enderror" name="uuid" contenteditable="false">
                                            @error('uuid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$data->studentinfo->title}}" required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{ $data->name }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email"> Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"  value="{{$data->email}}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="professional_email">Professional Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control  @error('professional_email') is-invalid @enderror"  value="{{ $data->studentinfo->professional_email }}"  name="professional_email" >
                                            @error('professional_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">Phone </label>
                                            <input type="text" class="form-control" name="phone"  value="{{$data->studentinfo->phone}}">
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="professional_phone">Professional Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control  @error('professional_phone') is-invalid @enderror"  value="{{ $data->studentinfo->professional_phone }}"  name="professional_phone" >
                                            @error('professional_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <!-- Heading with separator -->
                                    <div class="col-lg-12">
                                        <div class="form-group mt-3">
                                            <h4 class="card-title mb-4">Professional Information</h4>
                                            <div class="border-bottom"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="speciality_area">Speciality Area </label>
                                            <select class="form-control  @error('speciality_area') is-invalid @enderror" name="speciality_area" id="speciality_area" required>
                                                <option value="" selected disabled>--Select Speciality Area--</option>
                                                @foreach($specialityAreas as $specialityArea)
                                                    <option value="{{ $specialityArea->title }}" @selected(old('speciality_area', $data->studentinfo->speciality_area) == $specialityArea->title)>
                                                        {{ $specialityArea->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('speciality_area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="speciality">Speciality </label>
                                            <select class="form-control  @error('speciality') is-invalid @enderror" name="speciality" id="speciality" required>
                                                <option value="" selected disabled>--Select Speciality--</option>
                                                @foreach($specialities as $speciality)
                                                    <option value="{{ $speciality->title }}" @selected(old('speciality', $data->studentinfo->speciality) == $speciality->title)>
                                                        {{ $speciality->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('speciality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="department">Association </label>
                                            <input type="text" class="form-control" name="department"  value="{{ $data->studentinfo->department }}" >
                                            @error('department')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="department">Registration Date </label>
                                            <input type="date" class="form-control" name="registration_date" title="We get the Promotion Year from here." value="{{ $data->studentinfo->registration_date }}">
                                            @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="office_name">Office Name </label>
                                            <input type="text" class="form-control" name="office_name" value="{{ $data->studentinfo->office_name }}" >
                                            @error('office_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>


                                <div class="form-row">
                                    <!-- Heading with separator -->
                                    <div class="col-lg-12">
                                        <div class="form-group mt-3">
                                            <h4 class="card-title mb-4">Address Information</h4>
                                            <div class="border-bottom"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="country">Country </label>
                                            <input type="text" class="form-control" name="country" value="{{$data->studentinfo->country}}" >
                                            @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="city">City </label>
                                            <input type="text" class="form-control" name="city"  value="{{$data->studentinfo->city}}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="region">Region/Province </label>
                                            <input type="text" class="form-control" name="region"  value="{{ $data->studentinfo->region }}" >
                                            @error('region')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="address">Address </label>
                                            <input type="text" class="form-control" name="address" value="{{$data->studentinfo->address}}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>



                                <div class="form-row">


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lattitude">Lattitude </label>
                                            <input type="text" class="form-control" name="lattitude" value="{{$data->studentinfo->lattitude}}">
                                            @error('lattitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="longitude">Longitude </label>
                                            <input type="text" class="form-control" name="longitude" value="{{$data->studentinfo->longitude}}">
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <!-- Heading with separator -->
                                    <div class="col-lg-12">
                                        <div class="form-group mt-3">
                                            <h4 class="card-title mb-4">Account Information</h4>
                                            <div class="border-bottom"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control  @error('status') is-invalid @enderror" name="status" id="status" required>
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="active" @selected(old('status', $data->status) == 'active')>Active</option>
                                                <option value="pending"  @selected(old('status', $data->status) == 'pending')>Pending</option>
                                                <option value="inactive"  @selected(old('status', $data->status) == 'inactive')>InActive</option>

                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="longitude">Password <span class="text-danger">*</span></label>

                                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" >
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="longitude">Confirm Password <span class="text-danger">*</span></label>

                                        <input type="password" name="password_confirmation" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" >
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <hr>

                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label for="image">Image <span class="text-danger">*</span></label>

                                        <input type="file" name="image" class="form-control form-control-user @error('image') is-invalid @enderror" >
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        @if ($data->studentinfo->image)
                                            <div class="mb-4">
                                                <img src="{{ asset('uploads/'. $data->studentinfo->image) }}" alt="" style="width: 200px; height:200px">
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-row">
                                    @if (!empty($data['extrafield']))
                                        @foreach ($data['extrafield'] as $item)
                                            <div class="col-md-6 mt-3">
                                                <label for="{{ $item['label'] }}" class="form-label pb-2">{{ $item['label'] }} :</label>
                                                <input type="text" name="extrafield[{{ $item['label'] }}]" class="form-control @error('extrafield.'.$item['label']) is-invalid @enderror" value="{{ $item['value'] }}">
                                                @error('extrafield.'.$item['label'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif

                                </div>


                                <div id="dynamic-fields-container"></div>

                                <button type="button" class="btn btn-success mt-3" id="add-field-button">Add an Extra Field</button>

                                  {{-- {{$data}} --}}



                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('add-field-button').addEventListener('click', function() {
        addField();
    });

    function addField() {
        const container = document.getElementById('dynamic-fields-container');
        const index = container.children.length;

        const fieldWrapper = document.createElement('div');
        fieldWrapper.classList.add('row', 'mt-2');
        fieldWrapper.setAttribute('data-index', index);

        const labelField = `
            <div class="col-lg-5">
                <div class="form-group">
                    <input type="text" name="fields[${index}][label]" class="form-control" placeholder="Label">
                </div>
            </div>
        `;

        const valueField = `
            <div class="col-lg-5">
                <div class="form-group">
                    <input type="text" name="fields[${index}][value]" class="form-control" placeholder="Value">
                </div>
            </div>
        `;

        const deleteButton = `
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger" onclick="removeField(this)">Delete</button>
            </div>
        `;

        fieldWrapper.innerHTML = labelField + valueField + deleteButton;
        container.appendChild(fieldWrapper);
    }

    function removeField(button) {
        const fieldWrapper = button.closest('.row');
        fieldWrapper.remove();
    }
</script>


@endsection
