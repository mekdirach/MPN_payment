@extends('layout.coba')

@section('title', 'pelimpahan')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> MPN Status Koneksi
            </h4>

            <div class="card mb-4">
                <h6 class="card-header">
                    MPN STATUS KONEKSI
                </h6>


                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Connection to Host MPN</label>
                        <div class="col-sm-10">
                            <p class="col-form-label">
                                [<span style="font-weight: bold; color: red;" id="connected">NOT CONNECTED</span>]
                            </p>
                            <div style="margin-left: 14cm;" id="loading-spinner" class="sk-cube-grid sk-primary">
                                <div class="sk-cube sk-cube1"></div>
                                <div class="sk-cube sk-cube2"></div>
                                <div class="sk-cube sk-cube3"></div>
                                <div class="sk-cube sk-cube4"></div>
                                <div class="sk-cube sk-cube5"></div>
                                <div class="sk-cube sk-cube6"></div>
                                <div class="sk-cube sk-cube7"></div>
                                <div class="sk-cube sk-cube8"></div>
                                <div class="sk-cube sk-cube9"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button onclick="checkMPNConnection()" class="btn btn-round btn-info">Refresh</button>
                        </div>
                    </div>


                </div>

            </div>

        </div>
        <!-- Tambahkan elemen modal loading -->
        <div id="loading-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="col-form-label">Checking connection...</p>
                    </div>
                </div>
            </div>
        </div>


        </div>
        <style>
            #loading-spinner {
                display: none;
            }

            $red: #ca3737;
            $blue: #4cd4ee;

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
                justify-content: center;
                align-items: center;
            }

            .modal-dialog {
                width: 200px;
                /* Sesuaikan lebar modal sesuai kebutuhan Anda */
                text-align: center;
            }

            .modal-content {
                background-color: transparent;
                border: none;
                box-shadow: none;
            }

            .spinner-border {
                width: 3rem;
                height: 3rem;
                color: $blue;
            }

            .modal-body {
                padding: 20px;
            }

            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            @keyframes color {

                from,
                to {
                    background-color: $red;
                    filter: blur(1px);
                }

                50% {
                    background-color: $blue;
                    filter: blur(2px);
                }
            }
        </style>
    </main>
@endsection
@section('scripts')





    <script>
        function getCSRFToken() {
            var tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (tokenMeta) {
                return tokenMeta.getAttribute('content');
            }
            return null;
        }

        function checkMPNConnection() {
            var token = getCSRFToken();
            var requestData = {
                "_token": token
            };

            // Sembunyikan elemen spinner saat permintaan dimulai
            $('#loading-spinner').hide();

            $.ajax({
                url: '/admin/mpnstatus/koneksi', // Sesuaikan dengan rute yang Anda definisikan
                type: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    if (response[0] == 'success') {
                        // Kode jika terhubung
                        Swal.fire(
                            'Connected!',
                            '',
                            'success'
                        )
                        console.log('Connected');
                        $('#connected').text('CONNECTED').css('color', 'green');

                        // Tampilkan elemen spinner jika koneksi berhasil
                        $('#loading-spinner').show();
                    } else {
                        // Kode jika tidak terhubung
                        $('#connected').text('NOT CONNECTED').css('color', 'red');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error('Error:', error);
                }
            });
        }
    </script>

@endsection
