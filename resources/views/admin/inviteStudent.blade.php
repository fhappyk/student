@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Invitations</h1>
        <div>

            <a href="{{ route('admin.create.invite') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="import-json-btn"><i
                    class="fas fa-download fa-sm text-white-50"></i> Send New Invitation</a>
 

        </div>


    </div>
 
 

    <!-- Content Row -->
    <div class="row">
 
        <div class="col-xl-12 col-md-12  mt-4 mb-4">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>  
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
@endsection
