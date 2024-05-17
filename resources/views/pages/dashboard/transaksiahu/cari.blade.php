<script>
    $(document).ready(function() {
        var currentPage = 1;
        var maxPages = 1;
        var rowCount = 10; // Jumlah rows awal


        // Fungsi untuk memanggil API pencarian
        function loadData(page) {
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var rowCount = $('#row-count').val();
            $.ajax({
                url: "/api/transaksiAhu",
                type: 'GET',
                data: {
                    "start_date": startDate,
                    "end_date": endDate,
                    "row_count": rowCount,
                    page: page,
                },
                success: function(response) {
                    var items = response.items;
                    var html = '';

                    if (items.length > 0) {
                        items.forEach(function(item, index) {
                            var rowNumber = (currentPage - 1) * rowCount + index + 1;
                            html += '<tr>';
                            html += '<td>' + rowNumber + '</td>';
                            html += '<td>' + item.tgb_tm_bill_id + '</td>';
                            html += '<td>' + item.tgb_tm_nama_wajib_pajak + '</td>';
                            html += '<td>' + item.tgb_tm_kode_jenis_setoran +
                                '</td>';
                            html += '<td>' + item.tgb_tm_kode_kpbc + '</td>';
                            html += '<td>' + item.tgb_tm_kode_satker + '</td>';
                            html += '<td>' + item.tgb_tm_amount + '</td>';
                            html += '<td>' + item.tgb_tm_refnum + '</td>';
                            html += '<td>' + item.tgb_tm_npwp + '</td>';
                            html += '<td>' + item.tgb_tm_pay_day + '</td>';
                            html += '<td>' + item.tgb_tm_pay_dt + '</td>';
                            html += '<td>' + item.tgb_tm_bank_refnum + '</td>';
                            html += '</tr>';
                        });

                    } else {
                        html += '<p> No items found.</p>';
                    }

                    $('#caridata').html(html);

                    currentPage = items.currentPage;
                    maxPages = items.lastPage;
                    updatePaginationButtons();
                }
            });
        }
        // Fungsi untuk mengupdate tombol "Previous" dan "Next"
        function updatePaginationButtons() {
            if (currentPage === 1) {
                $('#previous-btn').attr('disabled', true);
            } else {
                $('#previous-btn').removeAttr('disabled');
            }

            if (currentPage === maxPages) {
                $('#next-btn').attr('disabled', true);
            } else {
                $('#next-btn').removeAttr('disabled');
            }
        }

        // Event listener untuk perubahan jumlah data per halaman
        // Fungsi untuk mengubah jumlah rows
        function changeNumRows() {
            var rowCount = $('#row-count').val();
            loadData(1);
        }
        // Event listener untuk perubahan jumlah rows
        $('#numRows').change(changeNumRows);

        // Event listener untuk tombol "Previous"
        $('#previous-btn').click(function() {
            if (currentPage > 1) {
                loadData(currentPage - 1); // Memuat data sebelumnya
            }
        });

        // Event listener untuk tombol "Next"
        $('#next-btn').click(function() {
            if (currentPage < maxPages) {
                loadData(currentPage + 1); // Memuat data berikutnya
            }
        });

        // Memuat data pada saat halaman dimuat
        //loadData(currentPage);

        // Event listener untuk form pencarian
        $('#search-form').submit(function(e) {
            e.preventDefault();

            loadData(currentPage);
        });


        /*  // Fungsi untuk mengubah jumlah rows
                     function changeNumRows() {
                        var rowCount = $('#row-count').val();
                        getItems();
                    }
                    // Event listener untuk perubahan jumlah rows
                    $('#numRows').change(changeNumRows);
        */
    });
</script>


@extends('layouts.app')

@section('content')
    <main>
        <!-- Content -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light"></span> LAPORAN TRANSAKSI AHU
            </h4>

            <div class="card mb-4">
                <h6 class="card-header">
                    Log Transaksi AHU
                </h6>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2">Tanggal</label>
                            <div class="col-sm-10">
                                <div class="input-daterange input-group" id="datepicker-range">
                                    <input type="text" class="form-control" id="start-date" name="start_date" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="text" class="form-control" id="end-date" name="end_date" required>
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
            </div>

            <div class="card">
                <h6 class="card-header">
                    Laporan Transaksi
                </h6>

                <div class="card-datatable table-responsive">
                    <div class="row" style=" margin-left: 1%; margin-top: 1%;">
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
                                <th scope="col">NO</th>
                                <th scope="col">BILL ID</th>
                                <th scope="col">NAMA WAJIB BAYAR</th>
                                <th scope="col">KODE K/L</th>
                                <th scope="col">KODE ESELON</th>
                                <th scope="col">KODE SATKER</th>
                                <th scope="col">NOMINAL</th>
                                <th scope="col">NO INVOICE</th>
                                <th scope="col">NO NPTN</th>
                                <th scope="col">TANGGAL BAYAR</th>
                                <th scope="col">JAM BAYAR</th>
                                <th scope="col">KODE BANK</th>
                            </tr>
                        </thead>
                        <tbody id="caridata">

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="pagination">
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
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var currentPage = 1;
            var maxPages = 1;
            var rowCount = 10; // Jumlah rows awal

            // Fungsi untuk memanggil API pencarian
            function getItems(page) {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();
                var rowCount = $('#row-count').val();

                $.ajax({
                    url: "/api/transaksiAhu",
                    type: 'GET',
                    data: {
                        "start_date": startDate,
                        "end_date": endDate,
                        "row_count": rowCount,
                        "page": page,
                    },
                    success: function(response) {
                        var items = response.items;
                        var html = '';

                        if (items.length > 0) {
                            items.forEach(function(item, index) {
                                var rowNumber = (currentPage - 1) * rowCount + index + 1;
                                html += '<tr>';
                                html += '<td>' + rowNumber + '</td>';
                                html += '<td>' + item.tgb_tm_bill_id + '</td>';
                                html += '<td>' + item.tgb_tm_nama_wajib_pajak + '</td>';
                                html += '<td>' + item.tgb_tm_kode_jenis_setoran + '</td>';
                                html += '<td>' + item.tgb_tm_kode_kpbc + '</td>';
                                html += '<td>' + item.tgb_tm_kode_satker + '</td>';
                                html += '<td>' + item.tgb_tm_amount + '</td>';
                                html += '<td>' + item.tgb_tm_refnum + '</td>';
                                html += '<td>' + item.tgb_tm_npwp + '</td>';
                                html += '<td>' + item.tgb_tm_pay_day + '</td>';
                                html += '<td>' + item.tgb_tm_pay_dt + '</td>';
                                html += '<td>' + item.tgb_tm_kode_bank + '</td>';
                                html += '</tr>';
                            });
                        } else {
                            html +=
                                '<tr><td colspan="12" class="text-center">No data available</td></tr>';
                        }

                        $('#caridata').html(html);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Fungsi untuk mengambil data pertama kali saat halaman dimuat
            getItems(currentPage);

            // Fungsi untuk memperbarui jumlah halaman maksimal
            function updateMaxPages() {
                $.ajax({
                    url: "/api/transaksiAhu",
                    type: 'GET',
                    data: {
                        "start_date": $('#start-date').val(),
                        "end_date": $('#end-date').val(),
                        "row_count": rowCount,
                        "get_total_pages": true,
                    },
                    success: function(response) {
                        maxPages = response.total_pages;

                        if (currentPage === 1) {
                            $('#previous-btn').prop('disabled', true);
                        } else {
                            $('#previous-btn').prop('disabled', false);
                        }

                        if (currentPage === maxPages) {
                            $('#next-btn').prop('disabled', true);
                        } else {
                            $('#next-btn').prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Fungsi untuk memperbarui halaman saat tombol Previous diklik
            $('#previous-btn').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    getItems(currentPage);
                    updateMaxPages();
                }
            });

            // Fungsi untuk memperbarui halaman saat tombol Next diklik
            $('#next-btn').click(function() {
                if (currentPage < maxPages) {
                    currentPage++;
                    getItems(currentPage);
                    updateMaxPages();
                }
            });

            // Fungsi untuk memperbarui halaman saat tombol Cari diklik
            $('#search-form').submit(function(event) {
                event.preventDefault();
                currentPage = 1;
                getItems(currentPage);
                updateMaxPages();
            });

            // Fungsi untuk memperbarui halaman saat jumlah rows per halaman berubah
            $('#row-count').change(function() {
                rowCount = $(this).val();
                currentPage = 1;
                getItems(currentPage);
                updateMaxPages();
            });
        });
    </script>

    <script>
        function getCSRFToken() {
            var tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (tokenMeta) {
                return tokenMeta.getAttribute('content');
            }
            return null;
        }
        $(document).ready(function() {
            var currentPage = 1;
            var maxPages = 1;
            var rowCount = 10; // Jumlah rows awal
            var token = getCSRFToken();

            // Fungsi untuk memanggil API pencarian
            function getItems(page) {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();
                var keywords = $('#keywords').val().split(',');
                var rowCount = $('#row-count').val();
                var ntpn = $('#nt-pn').val();
                var url = "/member/transaksi/search";
                var data = {
                    "row_count": rowCount,
                    "nt_pn": ntpn,
                    "page": page,
                    "_token": token
                };
                // Cek apakah terdapat tanggal pencarian
                if (startDate && endDate && keywords) {
                    data.start_date = startDate;
                    data.end_date = endDate;
                    url += "?start_date=" + startDate + "&end_date=" + endDate;
                }

                // Cek apakah terdapat kata kunci pencarian
                if (keywords.length > 0) {
                    data.keywords = keywords;
                    if (startDate && endDate) {
                        url += "&keywords=" + keywords;
                    } else {
                        url += "?keywords=" + keywords;
                    }
                }

                url += "&row_count=" + rowCount + "&nt_pn=" + ntpn + "&page=" + page + "&_token=" + token;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        var items = response.items;
                        var html = '';
                        console.log(items);

                        if (items && Array.isArray(items) && items.length > 0) {
                            items.forEach(function(item, index) {
                                var dateTime = item.AHUM_TM_TRX_DT_TM;
                                var datetimeObj = new Date(dateTime);

                                var day = datetimeObj.getDate();
                                var month = datetimeObj.getMonth() + 1;
                                var year = datetimeObj.getFullYear();

                                day = day < 10 ? "0" + day : day;
                                month = month < 10 ? "0" + month : month;

                                var timePart = datetimeObj.toLocaleTimeString();
                                html += '<tr>';
                                html += '<td>' + day + "-" + month + "-" + year + ' ' +
                                    timePart +
                                    '</td>';
                                html += '<td>' + item.TGB_TM_BILL_ID + '</td>';
                                html += '<td>' + item.TGB_TM_REFNUM + '</td>';
                                html += '<td>' + item.TGB_TM_NTPN + '</td>';
                                html += '<td>' + item.TGB_TM_BANK_REFNUM + '</td>';
                                html += '<td>' + item.TGB_TM_NPWP + '</td>';
                                html += '<td>' + item.TGB_TM_NAMA_WAJIB_PAJAK + '</td>';
                                html += '<td>' + item.TGB_TM_NAMA_WAJIB_BAYAR + '</td>';
                                html += '<td>' + item.TGB_TM_AMOUNT + '</td>';
                                html += '<td>' + item.TGB_TM_BATCH_ID + '</td>';
                                html += '<td>' + item.TGB_TM_NO_SAKTI + '</td>';
                                html += '<td>' + item.TGB_TM_USER + '</td>';
                                html += '<td>' + item.TGB_TM_NTPN + '</td>';
                                html += '</tr>';
                            });
                        } else {
                            html += '<tr><td colspan="13">No items found.</td></tr>';
                        }

                        $('#caridata').html(html);
                        currentPage = response.currentPage;
                        maxPages = response.lastPage;
                        updatePaginationButtons();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Fungsi untuk mengupdate tombol "Previous" dan "Next"
            function updatePaginationButtons() {
                if (currentPage === 1) {
                    $('#previous-btn').attr('disabled', true);
                } else {
                    $('#previous-btn').removeAttr('disabled');
                }

                if (currentPage === maxPages) {
                    $('#next-btn').attr('disabled', true);
                } else {
                    $('#next-btn').removeAttr('disabled');
                }
            }

            // Event listener untuk perubahan jumlah data per halaman
            // Fungsi untuk mengubah jumlah rows
            function changeNumRows() {
                rowCount = $('#row-count').val();

                performSearch();
            }

            // Event listener untuk perubahan jumlah rows
            $('#row-count').change(changeNumRows);

            // Event listener untuk tombol "Previous"
            $('#previous-btn').click(function() {
                if (currentPage > 1) {
                    getItems(currentPage - 1); // Memuat data sebelumnya
                }
            });

            // Event listener untuk tombol "Next"
            $('#next-btn').click(function() {
                if (currentPage < maxPages) {
                    getItems(currentPage + 1); // Memuat data berikutnya
                }
            });

            // Event listener untuk form pencarian
            $('#search-form').submit(function(e) {
                e.preventDefault();
                performSearch();
            });

            // Fungsi untuk melakukan pencarian
            function performSearch() {
                currentPage = 1;
                getItems(currentPage);
            }

            // Fungsi untuk mereset form pencarian
            function resetSearchForm() {
                var startDateInput = $('#start-date');
                var endDateInput = $('#end-date');

                if (startDateInput.length > 0) {
                    startDateInput.val('');
                }

                if (endDateInput.length > 0) {
                    endDateInput.val('');
                }
            }


            // Event listener saat tombol Reset diklik
            $('#reset-btn').click(function() {
                resetSearchForm();
                performSearch();
            });
        });
    </script>
@endsection
