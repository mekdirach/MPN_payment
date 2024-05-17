@extends('layout.coba')

@section('title', 'Pengaturan')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> SETTING & KONFIGURASI
            </h4>


            <div class="card mb-4">
                <h6 class="card-header">
                    Daftar Setting & Konfigurasi MPN & MPN BO
                </h6>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Deskripsi</th>
                                <th>Last Update</th>
                                <th>Update By</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tableContainer">

                        </tbody>

                    </table>
                </div>
            </div>


        </div>
    </main>
@endsection
<style>
    .table-borderless {
        border-collapse: separate;
        border-spacing: 0;
        border: none;
    }

    .table-borderless td,
    .table-borderless th {
        border: none;
    }

    .no-border {
        border: none;
    }
</style>
@section('scripts')
    <script src="{{ asset('js/mpn_pengaturan.js') }}"></script>
@endsection
