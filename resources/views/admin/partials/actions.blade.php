
    <a href="{{ route('admin.login.student', $data->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-title="Login as User" title="Login as User">
        <i class="fa-solid fa-sign-in"></i>
    </a>
    <a href="{{ route('admin.edit.student', $data->id) }}" class="btn btn-info btn-sm">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="{{ route('admin.delete.student', $data->id) }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-trash-can"></i>
    </a>
