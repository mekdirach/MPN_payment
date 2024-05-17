@extends('layout.coba')

@section('title', 'Cek Status')
@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/libs/datatables/datatables.css') }}">
@endsection
@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> CEK STATUS PAYMENT
            </h4>

            <div class="card">
                <h6 class="card-header">
                    Cek Status Payment
                </h6>
                <div class="card-body">
                    <div class="button-container text-right">
                        <button id="processButton" type="button" class="btn btn-outline-primary" onclick="process()">
                            <i class="fa fas fa-server" style="margin-right: 5px; vertical-align: middle;"></i>Process
                            Selected
                        </button>
                        <span class="ml-2"></span>
                        <button id="processAllButton" type="button" class="btn btn-outline-primary" onclick="processAll()">
                            <i class="f fas fa-plus-circle" style="margin-right: 5px;"></i>Process All
                        </button>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <div class="row" style=" margin-left: 1%; margin-top: 1%;">
                        <div class="right">
                            <div class="dataTables_length"><label>
                                    <select id="row-count" name="row_count" aria-controls="DataTables_Table_1"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> </label></div>
                        </div>

                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="allChek"></th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">BILL ID</th>
                                <th scope="col">NTB</th>
                                <th scope="col">NTPN</th>
                                <th scope="col">BANK REFNUM</th>
                                <th scope="col">NPWP</th>
                                <th scope="col">NAMA WAJIB PAJAK</th>
                                <th scope="col">NAMA WAJIB BAYAR</th>
                                <th scope="col">AMOUNT</th>
                                <th scope="col">BATCH ID</th>
                                <th scope="col">NO SAKTI</th>
                                <th scope="col">USER</th>
                                <th scope="col">SRC ACC NUMBER</th>
                                <th scope="col">STATUS</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="caridata">

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">

                                <div id="pagination">
                                    <ul class="right">
                                        <button id="previous-btn" class="btn btn-xs btn-info" disabled>Previous</button>
                                        <button id="next-btn" class="btn btn-xs btn-info">Next</button>
                                    </ul>
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

    <!-- Libs -->
    <script src="{{ asset('js/mpn_cek_status_payment.js') }}">

    </script>

    <!-- Demo -->
@endsection
