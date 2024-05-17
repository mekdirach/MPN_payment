@extends('layout.coba')

@section('title', 'Nomor Sakti')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> Nomor Sakti
            </h4>


            <div class="card mb-4">
                <h6 class="card-header">
                    Pengisian Nomor Sakti
                </h6>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Batch ID</label>
                            <div class="col-sm-10">
                                <label class="col-form-label" id="batch-Id"
                                    name="batchid"><strong>{{ $batchId }}</strong></label>
                                <br>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Nomor Sakti</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nomorSakti" id="nomorSaktiInput"
                                    placeholder="nomorsakti">
                                <label class="respone" id="response"></label>
                            </div>
                        </div>
                        <div class="button">
                            <ul class="right">
                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-8 col-xl-6">
                    <div class="card mb-5">
                        <div class="card-body d-flex justify-content-between align-items-start pb-3">
                            <div>
                                <a href="javascript:void(0)" class="text-dark text-big font-weight-semibold">Data Pengisian
                                    Nomor Sakti</a>
                            </div>
                        </div>
                        <div class="progress rounded-0" style="height: 3px;">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <br>
                                    <div class="message success"></div>
                                    <div id="itemDetails" class="font-weight-bold hidden">
                                        <table class="table product-item-table" style="border-collapse: collapse;">
                                            <tbody>

                                                <tr>
                                                    <td>Tanggal Pelimpahan</td>
                                                    <td>:</td>
                                                    <td><strong><span id="tanggalPelimpahan"></span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Batch ID</td>
                                                    <td>:</td>
                                                    <td><span id="batchID"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mata Uang</td>
                                                    <td>:</td>
                                                    <td><span id="mataUang"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Sakti</td>
                                                    <td>:</td>
                                                    <td><span id="nomorSakti"></span></td>
                                                </tr>

                                                <tr>
                                                    <td>Nomor Rekening</td>
                                                    <td>:</td>
                                                    <td><span id="noRek"></span></td>
                                                </tr>

                                                <tr>
                                                    <td>Total Transaksi</td>
                                                    <td>:</td>
                                                    <td><span id="totalTransaksi"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Transaksi</td>
                                                    <td>:</td>
                                                    <td><span id="jumlahTransaksi"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style media="screen">
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
                    border-radius: 12px;
                    padding: 10px;
                    background: rgb(21, 126, 171);
                    color: white;
                }
            </style>
        </div>
    </main>
@endsection
@section('scripts')
    <style>
        .respone {
            color: red;
        }

        .custom-table-layout {
            width: 100%;
            table-layout: fixed;
        }

        .custom-table-layout td {
            word-wrap: break-word;
            white-space: nowrap;
        }

        .custom-table-layout .submit-cell {
            text-align: right;
        }

        .right-aligned-button {
            float: right;
        }

        .badge.badge-danger {
            font-size: 1em;
        }
    </style>




    <script src="{{ asset('js/mpn_nomor_sakti.js') }}"></script>
	<!-- Contoh skrip JavaScript yang bisa menghapus cookie -->
<script>
    function logout() {
        // Logika logout
        // ...

        // Menghapus cookie secara tidak sengaja
        document.cookie = 'batchid=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        
        // Redirect atau langkah-langkah logout lainnya
        // ...
    }
</script>


@endsection
