@extends('layout.coba')

@section('title', 'Force')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> FORCE FLAGING
            </h4>



            <div class="card">
                <h6 class="card-header">
                    FORCE FLAGING
                </h6>
                <div class="card-body">
                    <div class="button-container">
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
                    <div class="row" style=" margin-left: 1%; margin-top: 0%;">
                        <div class="right">
                            <div class="dataTables_length">
                                <form id="numRows">
                                    <label>
                                        <select id="row-count" name="row_count" aria-controls="DataTables_Table_1"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </label>
                                </form>
                            </div>
                        </div>

                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="allChek"></th>
                                <th>BILL ID</th>
                                <th>REK. PENGIRIM</th>
                                <th>REK. PENERIMA</th>
                                <th>NTB</th>
                                <th>NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody id="force-flaging">

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">

                                <div id="pagination">
                                    <ul class="right">
                                        <button id="previous-btn" class="btn btn-xs btn-info" disabled>Previous</button>
                                        <button id="next-btn" class="btn btn-xs btn-info" disabled>Next</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <style media="screen">
            .button-container {
                display: flex;
                justify-content: flex-end;
                /* Tombol akan ditempatkan di kanan */
                align-items: center;
                margin-bottom: 10px;


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
                border-radius: 12px;
                padding: 8px;
                background: rgb(21, 126, 171);
                color: white;
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

            .modal-lg {
                max-width: 100%;
            }

            .modal-dialog-centered.modal-lg {
                margin: auto;
            }
        </style>
    </main>

@endsection
@section('scripts')


    <script src="{{ asset('js/mpn_force_flaging.js') }}"></script>

@endsection
