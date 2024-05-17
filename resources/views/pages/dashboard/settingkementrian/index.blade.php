@extends('layout.coba')

@section('title', 'Kementrian')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> SETTING KEMENTRIAN
            </h4>


            <div class="card mb-4">
                <h6 class="card-header">
                    Daftar Setting & Konfigurasi Kementrian
                </h6>
                <div id="success-message" class="message hidden">
                    <!-- Isi pesan sukses akan ditampilkan di sini -->
                </div>



                <div class="card-body">
                    <div class="button-container">
                        <button type="button" class="btn btn-outline-primary" onclick="addform()"><i
                                class="fa fas fa-plus-circle" style="margin-right: 5px;"></i>Tambah
                            Kementrian</button>

                    </div>

                    <table class="table">


                        <thead>
                            <tr>
                                <th>PNBP</th>
                                <th>Kode K/L</th>
                                <th>Nama</th>
                                <th>Kode Eselon</th>
                                <th>Kode Satker</th>
                                <th>Message Type</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="kementrian-setting">


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <style>
        .message {
            background: #6bd86f;
            /* Warna latar belakang pesan sukses (hijau) */
            color: white;
            /* Warna teks pesan */
            padding: 10px;
            /* Ruang bingkai pesan */
            border-radius: 5px;
            /* Sudut bulat pesan */
            text-align: center;
            /* Pusatkan teks pesan */
            display: none;
            /* Pesan disembunyikan secara default */
        }



        .hidden {
            display: none;
        }

        .td-form {
            padding: 0;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Tombol akan ditempatkan di kanan */
            align-items: center;
            margin-bottom: 20px;


        }


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

        /* Mengatur lebar modal agar lebih lebar */
        .modal-lg {
            max-width: 100%;
            /* Anda dapat menyesuaikan nilai ini sesuai kebutuhan */
        }

        /* Mengatur margin vertikal dan horizontal pada modal agar lebih rapi */
        .modal-dialog-centered.modal-lg {
            margin: auto;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('js/mpn_set_kementrian.js') }}"></script>


@endsection
