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
                    Detail Laporan
                </h6>
                <div class="card-body">
                   <div id="fileContent"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/mpn_laporan.js') }}"></script>
    <script>
        // Ubah fileUrl sesuai kebutuhan
        var fileUrl = "{{ $url }}";

        // Gunakan fetch API untuk mengambil isi file
        fetch(fileUrl)
            .then(response => response.text())
            .then(data => {
                // Tampilkan isi file di elemen HTML dengan ID 'fileContent'
                document.getElementById('fileContent').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    </script>

@endsection
