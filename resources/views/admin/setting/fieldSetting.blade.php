@extends('admin.layout.app')
@section('admin-content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Fields Setting</h1>
        <div> 

        </div>


    </div>
 
    

    <!-- Content Row -->
    <div class="row">
 
        <div class="col-xl-12 col-md-12  mt-4 mb-4">
 
            
            <div class="table-responsive">
                {{-- {{$data}} --}}
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Fields Name</th>
                            <th>Status</th> 
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($fields as $field)
                            <tr>
                                <td>{{ $field->field_name }}</td>
                                <td>{{ $field->status }}</td> 
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ ucfirst($field->status) }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                            <li><a class="dropdown-item change-status" href="#" data-id="{{ $field->id }}" data-status="active">Active</a></li>
                                            <li><a class="dropdown-item change-status" href="#" data-id="{{ $field->id }}" data-status="inactive">Inactive</a></li> 
                                        </ul>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div> 
<script>
    document.querySelectorAll('.change-status').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
// alert('sfsdf');
            let fieldId = this.dataset.id;
            let newStatus = this.dataset.status;

            fetch(`/admin/fields/update-status/${fieldId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to see the updated status
                }
            });
        });
    });
</script>

@endsection
