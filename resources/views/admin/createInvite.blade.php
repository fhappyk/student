@extends('admin.layout.app')
@section('admin-content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Students</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 mb-4">

            <form action="{{ route('admin.send.invite') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button class="btn btn-primary">Send Invitation <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">


                                <div class="form-row ">
                                    <div class="col-sm-6 mb-3 ">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control form-control-user   @error('name') is-invalid @enderror" id="exampleFirstName" name="name"
                                            placeholder="Full Name">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-row mt-4">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="uuid">Member ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('uuid') is-invalid @enderror" name="uuid" required>
                                            @error('uuid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
