@extends('layout.coba')

@section('Role Management')

@section('content')

    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            <span class="text-muted font-weight-light"></span> Role Management
        </h4>


        <div class="card mb-4">
            <h6 class="card-header">
                Role Management
            </h6>

            <div class="card-body">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Tambah Data
                    </button>
                </div>


            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">Kode</th>
                            <th scope="col">description</th>
                            <th scope="col">Tanggal Dibuat</th>
                            <th scope="col">Tanggal Perbaharui</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data) > 0)
                            <?php $no = 1; ?>
                            @foreach ($data as $item)
                                <tr>

                                    <th>{{ $no++ }}</th>
                                    <th>{{ $item->name }}</th>
                                    <th>{{ $item->code }}</th>
                                    <th>{{ $item->description }}</th>
                                    <th>{{ $item->created_at }}</th>
                                    <th>{{ $item->updated_at }}</th>
                                    <th>

                                        <a href="#edit{{ $item->id }}" type="button" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"><i class="ion ion-ios-construct d-block"></i></a>

                                        <form onsubmit="return confirm('yakin akan menghapus data?')" class="d-inline"
                                            action="{{ url('member/rolemanagement/delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete{{ $item->id }}" name="submit"
                                                class="btn btn-danger btn-sm"><i
                                                    class="ion ion-ios-trash d-block"></i></button>
                                        </form>

                                    </th>
                                </tr>
                                @include('pages.dashboard.rolemanagement.edit')
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ada...</td>
                            </tr>
                        @endif

                    </tbody>

                </table>


            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('member.rolemanagement.input') }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" autofocus>
                            @if ($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode</label>

                            <input type="text" class="form-control" name="code" placeholder="Singkatan" required
                                autofocus>
                            @if ($errors->has('code'))
                                <p class="text-danger">{{ $errors->first('code') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" name="description" placeholder="" required autofocus>
                            @if ($errors->has('code'))
                                <p class="text-danger">{{ $errors->first('code') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center m-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="mdl_modal_form" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="content_modal_form"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //fungsi untuk load form edit
        function edit(id) {
            $("#mdl_modal_form").modal({
                backdrop: 'static',
                keyboard: false
            });

            var param = {
                id: id
            };

        }

        function editform(id) {

            $.ajax({
                url: '/variants/edit/' + id,
                type: 'get',
                contentType: 'html',
                success: function(result) {
                    console.log(result)
                    $("#mymodal").modal('show')
                    $(".modal-title").html('Tambah data category')
                    $(".modal-body").html(result)
                }
            })
        }
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @endif
    </script>

@endsection
