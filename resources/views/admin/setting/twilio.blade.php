@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Twilio Configurations</h1>
    </div>

    <!-- Content Row -->
    <div class="card">
        <div class="card-body p-0">
            <div class="offset-sm-2">
                <div class="card-body col-sm-8">
                    <form class="form-horizontal" action="{{ route('admin.setting.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Mode</label>
                                <div class="col-sm-8">
                                    <select id="twilio_mode" name="twilio_mode" class="form-control " required="">
                                        <option value="">Select Mode</option>
                                        <option value="0" @selected(settings('twilio_mode') === '0')>Sandbox</option>
                                        <option value="1" @selected(settings('twilio_mode') === '1')>Live</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Account SID</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" required="true" value="{{ settings('twilio_sid') }}" id="ss_account_sid" name="twilio_sid" placeholder="Enter twilio account sid">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Auth Token</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" required="true" value="{{ settings('twilio_token') }}" id="ss_auth_token" name="twilio_token" placeholder="Enter twilio auth token">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Twilio number</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" required="true" value="{{ settings('twilio_number') }}" id="ss_number" name="twilio_number" placeholder="Enter twilio number">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Twilio Status</label>
                                <div class="col-sm-8">
                                    <select id="ss_is_active" name="twilio_status" class="form-control " required="">
                                        <option value="">Select Status</option>
                                        <option value="1" @selected(settings('twilio_status') === '1')>Active</option>
                                        <option value="0" @selected(settings('twilio_status') === '0')>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div style="background-color:white" class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"> Update Settings</button>
                            </div>

                        </div></form>
                </div>
            </div>
        </div>
    </div>
@endsection
