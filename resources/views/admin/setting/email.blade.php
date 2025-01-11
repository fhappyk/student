@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">SMTP Configurations</h1>
    </div>

    <!-- Content Row -->
    <div class="card">
        <div class="card-body p-0">
            <div class="">
                <div class="card-body">
                    <form role="form" action="{{ route('admin.setting.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Host</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="{{ settings('smtp_host') }}" id="smtp_host" name="smtp_host" placeholder="Enter Host">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-md-12 control-label">SMTPAuth</label>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <select class="form-control" id="smtp_auth" required="true" name="smtp_auth">--}}
{{--                                            <option value="">Select SMTPAuth</option>--}}
{{--                                            <option selected="" value="true">True</option>--}}
{{--                                            <option value="false">False</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Username</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="{{ settings('smtp_uname') }}" id="smtp_uname" name="smtp_uname" placeholder="Enter Username">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Password</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="" id="smtp_pwd" name="smtp_pwd" placeholder="Enter SMTP Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">SMTPSecure</label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="smtp_issecure" required="true" name="smtp_issecure">
                                            <option value="">Select SMTP Secure</option>
                                            <option value="ssl" @selected(settings('smtp_issecure') === 'ssl')>SSL</option>
                                            <option value="tls" @selected(settings('smtp_issecure') === 'tls')>TLS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Port</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="{{ settings('smtp_port') }}" id="smtp_port" name="smtp_port" placeholder="Enter Port">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Email From</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="{{ settings('smtp_emailfrom') }}" id="smtp_emailfrom" name="smtp_emailfrom" placeholder="Enter Email From Address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">ReplyTo</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" required="true" value="{{ settings('smtp_replyto') }}" id="smtp_replyto" name="smtp_replyto" placeholder="Enter ReplyTo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-check"></i></button>
                                <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-success">Test Email <i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-default" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Test SMTP Configuration</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="{{ route('admin.setting.testemail') }}" method="post" >
                    @csrf

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Enter Test Email ID</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="" required="true" id="testemailto" name="testemailto" placeholder="Enter test email id to receive email">
                                    </div>
                                </div>

                            </div><!-- roe -->
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>

                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
@endsection
