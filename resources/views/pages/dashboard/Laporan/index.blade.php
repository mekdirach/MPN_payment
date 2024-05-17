@extends('layout.coba')

@section('title', 'Laporan')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> Laporan
            </h4>


            <div class="card mb-4">
                <h6 class="card-header">
                    Upload File Laporan
                </h6>
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-1">File input</label>
                            <div class="col-sm-8">
                                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                                <label class="respone" id="response"></label>
                            </div>
                        </div>
                        <div class="button">
                            <ul class="right">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <h6 class="card-header">
                    Laporan
                </h6>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>File-File</th>
                            </tr>
                        </thead>
                        <tbody id="responseMessage">
                        </tbody>

                    </table>
                </div>
            </div>

            <style media="screen">
                .respone {
                    color: red;
                }

                .button {
                    width: 100%;
                    height: 50px;

                }

                .left {
                    float: left;
                    display: block;
                }

                .right {
                    float: right;
                    display: block;
                }

                .button ul a {
                    border-radius: 15px;
                    padding: 10px;
                    background: rgb(21, 126, 171);
                    color: white;
                }
            </style>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/mpn_laporan.js') }}"></script>

@endsection
