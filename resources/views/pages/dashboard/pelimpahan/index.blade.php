@extends('layout.coba')

@section('title', 'pelimpahan')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> Pelimpahan
            </h4>

            <div class="card mb-4">
                <h6 class="card-header">
                    Pelimpahan Transaksi (Batch ID)
                </h6>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Mata Uang :</label>
                            <div class="col-sm-10">
                                <label>
                                    <select class="custom-select" id="mata-uang" name="mata_uang" required>
                                        <option value="IDR">
                                            IDR
                                        </option>
                                        <option value="USD">
                                            USD
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="button">
                            <ul class="right">
                                <button class="btn btn-primary" type="submit">Limpahkan</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-start pb-3">
                            <div>
                                <a href="javascript:void(0)" class="text-dark text-big font-weight-semibold">Data Transaksi
                                    Pelimpahan</a>
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
                                    <div class="font-weight-bold hidden">
                                        <table class="table product-item-table" style="border-collapse: collapse;">
                                            <tbody id="itemDetails"
                                                style="word-wrap: break-word; max-height: 150px; overflow-y: auto; background-color: #f0f0f0; padding: 10px;">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>
    <style>
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

        .product - item - table {
            border - collapse: collapse;
        }

        .product - item - table td,
        .product - item - table th {
            border - top: none;
            border - bottom: none;
            border - left: none;
            border - right: none;
            padding: 5 px 10 px;
        }

        #itemDetails {
            max-height: 150px;
            /* Atur tinggi maksimum yang sesuai */
            overflow: auto;
            /* Tampilkan bilah geser jika kontennya lebih panjang dari tinggi maksimum */
        }

        /* Atur tampilan pesan sebagai inline-block untuk memastikan bahwa pesan tetap dalam elemen */
        #itemDetails span {
            display: inline-block;
        }


        .badge.badge-danger {
            font-size: 1em;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/mpn_pelimpahan.js') }}"></script>

@endsection
