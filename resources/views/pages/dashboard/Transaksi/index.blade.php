@extends('layout.coba')



@section('title', 'Transaksi')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> Transaksi
            </h4>
            <div class="card mb-4">
                <h6 class="card-header">
                    Log Transaksi
                </h6>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 ">Pencarian</label>

                            <div class="col-sm-10">
                                <input type="cari" class="form-control" placeholder="Cari Data" name="keywords"
                                    id="keywords">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 ">NTPN</label>
                            <div class="col-sm-10">
                                <label>
                                    <select class="custom-select" id="nt-pn" name="nt_pn" required>
                                        <option value="1">
                                            Terisi
                                        </option>
                                        <option value="2">
                                            Kosong
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Tanggal</label>
                            <div class="col-sm-10">
                                <div class="input-daterange input-group" id="datepicker-range">
                                    <input type="text" class="form-control" id="start-date" name="start_date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="text" class="form-control" id="end-date" name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 ">Fillter Status</label>
                            <div class="col-sm-10">
                                <label>
                                    <select class="custom-select" id="status-filter" name="status_filter">
                                        <option value="1" class="success">Payment Success</option>
                                        <option value="0" class="progres">On posting</option>
                                        <option value="4" class="success">Posting success</option>
                                        <option value="5" class="progres">Payment Requested</option>
                                        <option value="6" class="progres">Reversal Requested</option>
                                        <option value="7" class="success">Reversal Success</option>
                                        <option value="8" class="failed">Reversal Failed</option>
                                        <option value="9" class="failed">Failed</option>

                                        <!-- Tambahkan opsi status lainnya jika diperlukan -->
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="button">
                            <ul class="right">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <h6 class="card-header">
                    Laporan Transaksi
                </h6>
                <div class="d-flex-container">
                    <div>
                        <!-- Tambahkan elemen atau teks jika diperlukan -->
                    </div>
                    <div>
                        <button id="export-btn" class="btn btn-sm btn-success">Export to Excel</button>
                    </div>
                </div>

                <div class="card-datatable table-responsive col-md-12">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="dataTables_length">
                                <label>
                                    <select id="row-count" name="row_count" aria-controls="DataTables_Table_1"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                    </div>



                    <table class="table table-striped mt-3">

                        <thead>
                            <tr>
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
                                <th></th>
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

        </div>
        <style media="screen">
            .d-flex-container {
                display: flex;
                justify-content: space-between;
                margin-top: 15px;
                margin-right: 15px;
            }

            #export-btn {
                align-self: flex-start;
            }

            .center-text {
                text-align: center;
            }

            #status-filter .success {
                color: green;
            }

            #status-filter .progres {
                color: blue;
            }

            #status-filter .failed {
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
                border-radius: 12px;
                padding: 10px;
                background: rgb(21, 126, 171);
                color: white;
            }

            .modal-lg {
                max-width: 100%;
            }

            .modal-dialog-centered.modal-lg {
                margin: auto;
            }
        </style>
    </main>
    @stack('costum-script')
@endsection

@section('scripts')
    <script src="{{ asset('js/mpn_transaksi.js') }}">
        function exportToExcel() {
            const token = getCSRFToken();

            const requestData = {
                "_token": token,
                // Add any additional data you need to send for exporting
            };

            $.ajax({
                url: '/admin/export-to-excel', // Update the URL to your export route
                type: 'post', // You may change the HTTP method based on your Laravel route configuration
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    // Handle the response, e.g., show a success message or trigger a download
                    // For example, you can create a download link and trigger a click event to simulate a click
                    const blob = new Blob([response], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'exported_data.xlsx';
                    link.click();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error('Error:', error);

                    // Handle errors, e.g., show an error message
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-danger">Failed to export data</span>',
                        text: 'An error occurred while exporting data.',
                    });
                }
            });
        }

        // Assuming you have a button with id "export-btn"
        document.getElementById('export-btn').addEventListener('click', function() {
            // Trigger the export function when the button is clicked
            exportToExcel();
        });
    </script>

@endsection
