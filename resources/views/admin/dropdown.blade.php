@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Dropdowns Settings </h1>
        <div>
 
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="speciality-area-btn"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Speciality Area</a>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"   id="speciality-btn"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Speciality </a>
 
 

        </div>


    </div>

    <div id="Speciality-form" style="display: none;" class="mb-4">
        <form action="{{ route('admin.save.speciality') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="speciality">Add Speciality Title</label>
                <input type="text" name="speciality" id="speciality" class="form-control  @error('speciality') is-invalid @enderror" required>
                @error('speciality')
                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <script>
        document.getElementById('speciality-btn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            var form = document.getElementById('Speciality-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle form visibility
        });
    </script>

<div id="speciality-area-form" style="display: none;">

    <form action="{{ route('admin.save.speciality.area') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="speciality_area">Add Speciality Area</label>
            <input type="text" name="speciality_area" class="form-control  @error('speciality_area') is-invalid @enderror" id="speciality_area" required>
            @error('speciality_area')
                <div class="invalid-feedback">{{ $message }}</div>

            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>

<script>
    document.getElementById('speciality-area-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
        var form = document.getElementById('speciality-area-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle form visibility
    });
</script>


    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12  mt-4 mb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Speciality Area</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($specialityArea) > 0)
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($specialityArea as $item)
                            <tr>
                            <th scope="row">{{ ++$count }}</th>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->type }}</td>
                            <td><a href="{{ route('admin.delete.dropdown', $item->id) }}" class="text-danger text-decoration-none"><i class="fa-solid fa-trash-can"></i></a></td>
                            </tr> 
                            
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">No records</td>
                        </tr>
                        @endif 
                    </tbody>
                  </table>
            </div>
        </div>

        
        <div class="col-xl-12 col-md-12  mt-4 mb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Speciality  </th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($speciality) > 0)
                        @php
                            $itemCount = 0;
                        @endphp
                        @foreach ($speciality as $item)
                            <tr>
                            <th scope="row">{{ ++$itemCount }}</th>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->type }}</td>
                            <td><a href="{{ route('admin.delete.dropdown', $item->id) }}" class="text-danger text-decoration-none"><i class="fa-solid fa-trash-can"></i></a></td>
                            </tr> 
                            
                        @endforeach
                            
                        @else
                        <tr>
                            <td colspan="4" class="text-center">No records</td>
                        </tr>
                        @endif 
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div> 

@endsection
