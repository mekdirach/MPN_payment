@extends('layout.coba')

@section('title', 'Holiday')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light">Master Data /</span> Holiday
            </h4>

            <!-- Modal -->
            <div class="card mb-4">
                <h6 class="card-header">
                    Holiday
                </h6>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Tanggal</label>
                            <div class="col-sm-10">
                                <div class="input-group" >
                                    <input type="date" class="form-control" id="start-date" name="start_date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" class="form-control" id="end-date" name="end_date">
                                </div>
                            </div>
                        </div>

                        <div class="button">
                            <ul class="right">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </ul>
                        </div>
                    </form>
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

                    .pagination-buttons {
                        text-align: center;
                        /* Mengatur tata letak tombol di tengah */
                        margin-top: 10px;
                        /* Atur margin atas sesuai kebutuhan Anda */
                    }

                    .pagination-buttons button {
                        margin: 0 10px;
                    }

                    .text-success {
                        color: green;
                        font-size: 20px;
                        /* Atur ukuran font sesuai kebutuhan */
                    }
                </style>

            </div>

            <div class="card">
                <h6 class="card-header">
                    Hari Libur
                </h6>

                <div class="card-datatable table-responsive">
                    <div class="row" style=" margin-left: 1%; margin-top: 1%;">
                        <div class="right">
                            <div class="dataTables_length">
                                <form id="numRows">
                                    <label>
                                        <select id="row-count" id="row-count-info" name="row_count"
                                            aria-controls="DataTables_Table_1"
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
                                <th scope="col">Tanggal</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody id="caridata">

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-sm-7 col-md7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">

                                <div id="pagination-buttons">
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

    </main>


@endsection
@section('scripts')



    <script src="{{ asset('js/mpn_holiday.js') }}"></script>

    <!-- Demo -->
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('js/forms_pickers.js') }}"></script>
@endsection
