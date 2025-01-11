@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">InActive Students</h1>
        <div>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="import-json-btn"><i
                    class="fas fa-download fa-sm text-white-50"></i> Import JSON </a>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"   id="import-btn"><i
                    class="fas fa-download fa-sm text-white-50"></i> Import XLSX, CSV </a>
 

            <a href="{{ route('admin.export.json') }}" class="btn btn-sm btn-success"><i
                class="fas fa-upload fa-sm text-white-50"></i> Export JSON</a>

        </div>


    </div>

    <div id="import-form" style="display: none;" class="mb-4">
    <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Upload File (CSV, Excel)</label>
            <input type="file" name="file" id="file" class="form-control  @error('file') is-invalid @enderror" required>
            @error('file')
                <div class="invalid-feedback">{{ $message }}</div>

            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

<script>
    document.getElementById('import-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
        var form = document.getElementById('import-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle form visibility
    });
</script>

<div id="import-json-form" style="display: none;">

    <form action="{{ route('admin.import.json') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="json_file">Upload JSON File</label>
            <input type="file" name="json_file" class="form-control  @error('json_file') is-invalid @enderror" id="json_file" required>
            @error('json_file')
                <div class="invalid-feedback">{{ $message }}</div>

            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Import JSON</button>
    </form>
</div>
    
<script>
    document.getElementById('import-json-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
        var form = document.getElementById('import-json-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle form visibility
    });
</script>
    

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-11 col-md-11 mx-auto mt-4 mb-4">
            {{ $dataTable->table() }}
 
        </div>
    </div>
</div> 
 
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@endsection
