 
  
    <a href="{{ route('admin.restore', $data->id) }}" class="btn btn-success btn-sm">
        <i class="fa-solid fa-trash-can-arrow-up"></i>

    </a> 
    <a href="{{ route('admin.delete.trashed', $data->id) }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-trash-can"></i>
    </a>  