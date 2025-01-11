@extends('admin.layout.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $('#et_body').summernote({
            height: 200
        });
        // $('#emailcontent').summernote({
        //     height: 150
        // });
    </script>

    <script>
        // on submit of #new-email-template form
        $('#new-email-template-btn').click(function(e) {
            e.preventDefault();
            var form = $('#new-email-template');
            var url = form.attr('action');
            var type = form.attr('method');
            // var data = form.serialize();
            //get the body content from summernote
            // var data = new FormData(form[0]);
            // data.append('et_body', $('#et_body').summernote('code'));
            var data = {
                et_name: $('#et_name').val(),
                et_subject: $('#et_subject').val(),
                et_body: $('#et_body').summernote('code'),
                et_for: $('#et_for').val()
            };
            var token = $('meta[name="csrf-token"]').attr('content');
            console.log(data);
            // return false;
            $.ajax({
                type: type,
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response) {
                    if(response.status == 'success') {
                        alert('Email template added successfully');
                        location.reload();
                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        });
    </script>

    <script>
        // on submit of #new-email-template form
        $('#update-template-btn').click(function(e) {
            e.preventDefault();
            var form = $('#update-template-form');
            var url = form.attr('action');
            var type = form.attr('method');
            // var data = form.serialize();
            //get the body content from summernote
            // var data = new FormData(form[0]);
            // data.append('et_body', $('#et_body').summernote('code'));
            var data = {
                et_id: $('#edit_et_id').val(),
                et_name: $('#edit_et_name').val(),
                et_subject: $('#edit_et_subject').val(),
                et_body: $('#edit_et_body').summernote('code'),
                et_for: $('#edit_et_for').val(),
            };
            var token = $('meta[name="csrf-token"]').attr('content');
            console.log(data);
            // return false;
            $.ajax({
                type: type,
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response) {
                    if(response.status == 'success') {
                        alert('Email template Updated successfully');
                        location.reload();
                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        function loaddata(edit_et_id) {
            if(edit_et_id!='') {
                var url = "{{ route('admin.setting.edit-email-template', ':id') }}";
                url = url.replace(':id', edit_et_id);
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    cache: false,
                    success: function (result) {
                        console.log(result.result);
                        $('#edit_et_id').val(result.result.id);
                        $('#edit_et_name').val(result.result.name);
                        $('#edit_et_subject').val(result.result.subject);
                        $('#edit_et_body').summernote("code",result.result.body);
                        $('#edit_et_for').val(result.result.et_for);
                    }
                });
            } else {
                $("#edit_et_body").summernote("code", "");

            }
        }
    </script>

    <script>
        let html = `
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="text-align: left;">Field</th>
            <th style="text-align: left;">Value</th>
        </tr>
        <tr><td><strong class="text-danger">Reset Password Link:</strong></td><td>{resetUrl}</td></tr>
        <tr><td>Platform Name</td><td>{app.name}</td></tr>
        <tr><td>Student Name</td><td>{name}</td></tr>
        <tr><td>Email</td><td>{email}</td></tr>
        <tr><td>Status</td><td>{status}</td></tr>
        <tr><td>User Name</td><td>{user_name}</td></tr>
        <tr><td>Member ID</td><td>{uuid}</td></tr>
        <tr><td>Phone</td><td>{phone}</td></tr>
        <tr><td>Country</td><td>{country}</td></tr>
        <tr><td>Region</td><td>{region}</td></tr>
        <tr><td>City</td><td>{city}</td></tr>
        <tr><td>Address</td><td>{address}</td></tr>
        <tr><td>Lattitude</td><td>{lattitude}</td></tr>
        <tr><td>Longitude</td><td>{longitude}</td></tr>
        <tr><td>Professional Email</td><td>{professional_email}</td></tr>
        <tr><td>Professional Phone</td><td>{professional_phone}</td></tr>
        <tr><td>Department</td><td>{department}</td></tr>
        <tr><td>Speciality Area</td><td>{speciality_area}</td></tr>
        <tr><td>Speciality</td><td>{speciality}</td></tr>
        <tr><td>Registration Date</td><td>{registration_date}</td></tr>
        <tr><td>Title</td><td>{title}</td></tr>
        <tr><td>Years of Experience</td><td>{years_of_experience}</td></tr>
        <tr><td>Other Phone</td><td>{other_phone}</td></tr>
        <tr><td>Other Email</td><td>{other_email}</td></tr>
        <tr><td>Image</td><td>{image}</td></tr>
        <tr><td>Office Name</td><td>{office_name}</td></tr>
    </table>
`;
        $('.et_variables_info').html(html);

        function showHideVariables(value) {
            if(value === 'import') {
                $('.et_variables_info').html(html);
            } else if(value === 'create') {
                let html = `
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="text-align: left;">Field</th>
            <th style="text-align: left;">Value</th>
        </tr>
        <tr><td><strong class="text-danger">Login Link:</strong></td><td>{login_url}</td></tr>
        <tr><td><strong class="text-danger">Email:</strong></td><td>{email}</td></tr>
        <tr><td><strong class="text-danger">Password:</strong></td><td>{password}</td></tr>
        <tr><td>Platform Name</td><td>{app.name}</td></tr>
        <tr><td>Student Name</td><td>{name}</td></tr>
        <tr><td>Status</td><td>{status}</td></tr>
        <tr><td>User Name</td><td>{user_name}</td></tr>
        <tr><td>Member ID</td><td>{uuid}</td></tr>
        <tr><td>Phone</td><td>{phone}</td></tr>
        <tr><td>Country</td><td>{country}</td></tr>
        <tr><td>Region</td><td>{region}</td></tr>
        <tr><td>City</td><td>{city}</td></tr>
        <tr><td>Address</td><td>{address}</td></tr>
        <tr><td>Lattitude</td><td>{lattitude}</td></tr>
        <tr><td>Longitude</td><td>{longitude}</td></tr>
        <tr><td>Professional Email</td><td>{professional_email}</td></tr>
        <tr><td>Professional Phone</td><td>{professional_phone}</td></tr>
        <tr><td>Department</td><td>{department}</td></tr>
        <tr><td>Speciality Area</td><td>{speciality_area}</td></tr>
        <tr><td>Speciality</td><td>{speciality}</td></tr>
        <tr><td>Registration Date</td><td>{registration_date}</td></tr>
        <tr><td>Title</td><td>{title}</td></tr>
        <tr><td>Years of Experience</td><td>{years_of_experience}</td></tr>
        <tr><td>Other Phone</td><td>{other_phone}</td></tr>
        <tr><td>Other Email</td><td>{other_email}</td></tr>
        <tr><td>Image</td><td>{image}</td></tr>
        <tr><td>Office Name</td><td>{office_name}</td></tr>
    </table>
`;
                $('.et_variables_info').html(html);
            } else if(value === 'invite') {
                let html = `
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="text-align: left;">Field</th>
            <th style="text-align: left;">Value</th>
        </tr>
        <tr><td>Registration Link</td><td>{register_url}</td></tr>
        <tr><td>Platform Name</td><td>{app.name}</td></tr>
        <tr><td>Student Name</td><td>{name}</td></tr>
        <tr><td>Email</td><td>{email}</td></tr>
        <tr><td>Member ID</td><td>{uuid}</td></tr>
    </table>
`;
                $('.et_variables_info').html(html);
            } else if(value === 'otp') {
                let html = `
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr>
            <th style="text-align: left;">Field</th>
            <th style="text-align: left;">Value</th>
        </tr>
        <tr><td><strong class="text-danger">OTP Code:</strong></td><td>{otp_code}</td></tr>
        <tr><td>Platform Name</td><td>{app.name}</td></tr>
        <tr><td>Email</td><td>{email}</td></tr>
    </table>
`;
                $('.et_variables_info').html(html);
            } else if(value === 'forgot') {
                $('.et_variables_info').html(html);
            }
        }
        $('#et_for').change(function() {
            let value = $(this).val();
            showHideVariables(value);
        });
        $('#edit_et_for').change(function() {
            let value = $(this).val();
            showHideVariables(value);
        });
    </script>
@endpush

@section('admin-content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Email Templates</h1>
        </div>

        <!-- Content Row -->
        <div class="card">
            <div class="card-header">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#addnewtemplate">Add New</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="custtbl" class="table card-table table-vcenter datatable">
                        <thead>
                        <tr>
                            <th class="w-1">S.No</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>For</th>
                            <th style="width:60%">Template Content</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ $template->name }}</td>
                                <td> {{ $template->subject }}</td>
                                <td> {{ $template->for }}</td>
                                <td>{!! $template->body !!}</td>
                                <td>
                                    <a href="" class="btn btn-info btn-sm" data-toggle="modal" onclick="loaddata('{{ $template->id }}')" data-target="#edit_model">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
{{--                        <tr>--}}
{{--                            <td> 2</td>--}}
{{--                            <td> Booking Time Reminder</td>--}}
{{--                            <td> Booking Time Reminder</td>--}}
{{--                            <td></td>--}}
{{--                            <td>--}}
{{--                                <a href="" class="btn btn-info btn-sm" data-toggle="modal" onclick="loaddata('3')" data-target="#edit_model">--}}
{{--                                    <i class="fa fa-edit"></i></a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade show" id="addnewtemplate" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Email Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal emailtemplate" id="new-email-template" action="{{ route('admin.setting.email-templates-post') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Template Name</label>
                                    <div class="col-sm-9 form-group">
                                        <input type="text" class="form-control" required name="et_name" id="et_name" placeholder="Enter name of template" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Email Subject</label>
                                    <div class="col-sm-9 form-group">
                                        <input type="text" class="form-control" required name="et_subject" id="et_subject" placeholder="Enter subject of template" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Template For</label>
                                    <div class="col-sm-9 form-group">
                                        <select class="form-control" required name="et_for" id="et_for">
                                            <option value="">--Select Template Type--</option>
                                            <option value="import">Import From File</option>
                                            <option value="create">Create Student</option>
                                            <option value="invite">Invite</option>
                                            <option value="otp">OTP Email</option>
{{--                                            <option value="forgot">Forgot Password</option>--}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="emailcontent" class="col-sm-3 col-form-label">Email Content</label>
                                    <div class="form-group col-sm-9">
                                        <textarea class="form-control" required id="et_body" name="et_body" rows="10" placeholder="Enter email content"></textarea>
{{--                                        Customer Name : {{name}}, Booking Time: {{time}}, Booking Status: {{status}}, Cost: {{amt}}, Company Name:  {{companyname}}--}}
                                        <p class="text-dark et_variables_info"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="new-email-template-btn" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade show" id="edit_model" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Email Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal emailtemplate" id="update-template-form" action="{{ route('admin.setting.update-email-template') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Template Name</label>
                                    <div class="col-sm-9 form-group">
                                        <input type="text" class="form-control" required name="et_name" id="edit_et_name" placeholder="Enter name of template" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Email Subject</label>
                                    <div class="col-sm-9 form-group">
                                        <input type="text" class="form-control" required name="et_subject" id="edit_et_subject" placeholder="Enter subject of template" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="smsno" class="col-sm-3 col-form-label">Template For</label>
                                    <div class="col-sm-9 form-group">
                                        <select class="form-control" required name="et_for" id="edit_et_for">
                                            <option value="">--Select Template Type--</option>
                                            <option value="import">Import From File</option>
                                            <option value="create">Create Student</option>
                                            <option value="invite">Invite</option>
                                            <option value="otp">OTP Email</option>
{{--                                            <option value="forgot">Forgot Password</option>--}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="emailcontent" class="col-sm-3 col-form-label">Email Content</label>
                                    <div class="form-group col-sm-9">
                                        <textarea class="form-control" required id="edit_et_body" name="et_body" rows="10" placeholder="Enter email content"></textarea>
                                        <p class="text-dark et_variables_info"></p>
{{--                                        Customer Name : {{name}}, Booking Time: {{time}}, Booking Status: {{status}}, Cost: {{amt}}, Company Name:  {{companyname}}--}}
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="et_id" id="edit_et_id">

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="update-template-btn" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="myModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <form id="action" method="post">
                        <div class="modal-header flex-column">
                            <input class="form-control del_id" type="hidden" name="del_id">
                            <h4 class="modal-title w-100">Are you sure?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
