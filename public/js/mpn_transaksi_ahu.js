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
        var rowCount = $('#row-count').val();

        var url = "/trans/transaksiahu/search";
        var data = {
            "row_count": rowCount,
            "page": page,
            "_token": token
        };

        if (startDate && endDate) {
            data.start_date = startDate;
            data.end_date = endDate;
            url += "?start_date=" + startDate + "&end_date=" + endDate;
        } else {
            url += "?row_count=" + rowCount + "&page=" + page;
        }


        // await updateMaxPages();
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function(response) {
                var items = response.items;
                var html = '';

                if (items && Array.isArray(items) && items.length >
                    0) {
                    items.forEach(function(item, index) {
                        if (item.AHUM_TM_TRAN_DT) {
                            var rowNumber = (currentPage - 1) * rowCount + index + 1;
                            var formattedAmount = formatRupiah(item.AHUM_TM_PAYMENT);
                            var dateTime = item.AHUM_TM_TRAN_DT;
                            var yearPart = dateTime.substr(0, 4);
                            var monthPart = dateTime.substr(4, 2);
                            var dayPart = dateTime.substr(6, 2);
                            var hourPart = dateTime.substr(8, 2);
                            var minutePart = dateTime.substr(10, 2);
                            var secondPart = dateTime.substr(12, 2);

                            var formattedDateTime = yearPart + '-' + monthPart + '-' +
                                dayPart + ' ' +
                                hourPart + ':' + minutePart + ':' + secondPart;

                            var datetimeObj = new Date(formattedDateTime);

                            // Mendapatkan tanggal
                            var day = datetimeObj.getDate();
                            var month = datetimeObj.getMonth() + 1;
                            var year = datetimeObj.getFullYear();

                            // Menambahkan nol di depan jika nilai day atau month kurang dari 10
                            var formattedDay = day < 10 ? '0' + day : day;
                            var formattedMonth = month < 10 ? '0' + month : month;

                            // Mendapatkan waktu
                            var timePart = datetimeObj.toLocaleTimeString();

                            html += '<tr>';
                            html += '<td>' + item.AHUM_TM_BILL_CODE1 + '</td>';
                            html += '<td>' + item.AHUM_TM_BILLER_NAME + '</td>';
                            html += '<td>' + item.AHUM_TM_KL_CODE + '</td>';
                            html += '<td>' + item.AHUM_TM_ESELON_CODE + '</td>';
                            html += '<td>' + item.AHUM_TM_SATKER_CODE + '</td>';
                            html += '<td>' + formattedAmount + '</td>';
                            html += '<td>' + item.AHUM_TM_TRX_ID + '</td>';
                            html += '<td>' + item.AHUM_TM_NTPN + '</td>';
                            html += '<td>' + formattedDay + '-' + formattedMonth + '-' +
                                year + '</td>';
                            html += '<td>' + timePart + '</td>';
                            html += '<td>' + item.AHUM_TM_COMPANY_CODE + '</td>';
                            html += '</tr>';
                        }
                    });

                    $('#caridata').html(html);
                } else {
                    html += '<tr><td colspan="13">No items found.</td></tr>';
                    $('#caridata').html(html);
                }
                currentPage = response.currentPage;
                maxPages = response.lastPage;
                updatePaginationButtons();


            },
            error: function(error) {
                  var html = '';
   html += '<tr>';
                html += '<td>' + error.error + '</td>';
  html += '</tr>';
                $('#caridata').html(html);
                //console.log(error);
            }
        });
    }

    function formatRupiah(nominal) {
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        });

        return formatter.format(nominal);
    }

    // Fungsi untuk mengupdate tombol "Previous" dan "Next"
    function updatePaginationButtons() {
        if (currentPage === 1 || maxPages === 1) {
            $('#previous-btn').attr('disabled', true);
            $('#next-btn').attr('disabled', true);
        } else if (currentPage === maxPages) {
            $('#previous-btn').removeAttr('disabled');
            $('#next-btn').attr('disabled', true);
        } else if (currentPage === 1) {
            $('#previous-btn').attr('disabled', true);
            $('#next-btn').removeAttr('disabled');
        } else {
            $('#previous-btn').removeAttr('disabled');
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

    // Event listener untuk tombol "Previous"
    $('#previous-btn').click(function() {
        if (currentPage > 1) {
            currentPage--; // Mengurangi currentPage
            getItems(currentPage); // Memuat data sebelumnya
        }
    });

    // Event listener untuk tombol "Next"
    $('#next-btn').click(function() {
        if (currentPage < maxPages) {
            currentPage++; // Menambah currentPage
            getItems(currentPage); // Memuat data berikutnya
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