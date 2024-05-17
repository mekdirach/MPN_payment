<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('member.rolemanagement.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                            value="{{ $item->name }}" autofocus>

                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode</label>

                        <input type="text" class="form-control" name="code" placeholder="Singkatan"
                            value="{{ $item->code }}" required autofocus>

                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="description" value="{{ $item->description }}"
                            placeholder="" required autofocus>

                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center m-0">
                            <button type="submit" class="btn btn-primary" onclick="showAlert()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '<span class="text-success">{{ session('success') }}</span>',
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: '<span class="text-danger">{{ session('error') }}</span>',
        });
    @endif
</script>
