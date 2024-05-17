document.addEventListener("DOMContentLoaded", function() {
    getPnpb();
});

function getPnpb() {
    var token = getCSRFToken();
    var requestData = {
        "_token": token
    };
    $.ajax({
        url: '/trans/transaksinonahu/create',
        type: 'get',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            var Html = '';
            console.log(response);
        
            // Akses data "items" dari respons JSON
            var items = response.items;
        
            // Loop melalui objek-objek dalam "items" dan tampilkan data yang diinginkan
            for (var i = 0; i < items.length-1; i++) {
                var item = items[i];
                if (item.MPN_TRX_PNBP !== '') {

                  Html += '<option value="'+item.MPN_TRX_PNBP+'">' + item.MPN_TRX_NAME + ' </option>';

                }
            }
            $('#non-ahu').html(Html);

        },
        error: function(xhr, status, error) {

            var pesanKesalahan = '';
            if (xhr.responseText) {
                pesanKesalahan += 'Tidak Ada Respone Dari Sistem!';
            }

            $("#itemDetails").html('<div class="badge badge-danger">' +
                pesanKesalahan + '</div>');
        }
    });
}

function getCSRFToken() {
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        return tokenMeta.getAttribute('content');
    }
    return null;
}

    var currentPage = 1;
    var maxPages = 1;
    var rowCount = 10; // Jumlah rows awal
    var token = getCSRFToken();

    // Fungsi untuk memanggil API pencarian
    function getItems(page) {
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        var keywords = $('#keywords').val();
        var rowCount = $('#row-count').val();
        var ntpn = $('#nt-pn').val();
        var status = $('#status-filter').val();


        var url = "/trans/transaksi/search";
        var data = {
            "row_count": rowCount,
            "nt_pn": ntpn,
            "page": page,
            "status_filter": status,
            "_token": token
        };
        // Cek apakah terdapat tanggal pencarian
        if (startDate && endDate) {
            data.start_date = startDate;
            data.end_date = endDate;
            url += "?start_date=" + startDate + "&end_date=" + endDate;
        }

        if (!startDate && !endDate) {
            data.start_date = startDate;
            data.end_date = endDate;
            url += "?start_date=" + startDate + "&end_date=" + endDate;
        }

        // Cek apakah terdapat kata kunci pencarian
			if (keywords.length > 0) {
				data.keywords = keywords;
				if (startDate || endDate) {
					url += "&keywords=" + keywords;
				} else {
					url += "?keywords=" + keywords;
				}
			}
        url += "&row_count=" + rowCount + "&nt_pn=" + ntpn + "&page=" + page + "&status_filter=" + status +
            "&_token=" + token;

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                var items = response.items;
                var html = '';
                globalResponse = items;
                

                if (items && Array.isArray(items) && items.length >= 0) {
                    items.forEach(function(item) {

                        if (item.TGB_TM_TRAN_DT) {
							var rawDateTime = item.TGB_TM_TRAN_DT;
                            var formattedDateTime = rawDateTime.substr(6, 2) + '-' +
                            rawDateTime.substr(4, 2) + '-' +
                            rawDateTime.substr(0, 4) + ' ' +
                            rawDateTime.substr(8, 2) + ':' +
                            rawDateTime.substr(10, 2) + ':' +
                            rawDateTime.substr(12, 2);

                            var json = JSON.parse(item.TGB_TM_JSON_STREAM);
                            var srcAccNumber = json.hasOwnProperty('PAN') ? json.PAN :
                                '';
                            if (item.TGB_TM_NTPN == "" || item.TGB_TM_NTPN == "-") {
                                optionHtml =
                                    '<button class="btn btn-xs btn-info" onclick="editSetting(\'' +
                                    item.TGB_TM_ID +
                                    '\')">Edit</button>';
                            } else {
                                optionHtml =
                                    '';
                            }
                            var statusText = getStatusText(item.TGB_TM_STATUS);

                            html += '<tr>';
                            html += '<td>' + formattedDateTime + '</td>';
                            html += '<td>' + item.TGB_TM_BILL_ID + '</td>';
                            html += '<td>' + (item.TGB_TM_REFNUM ? item.TGB_TM_REFNUM : '') + '</td>';
                            html += '<td>' + (item.TGB_TM_NTPN ? item.TGB_TM_NTPN : '') + '</td>';
                            html += '<td>' + (item.TGB_TM_BANK_REFNUM ? item.TGB_TM_BANK_REFNUM : '') + '</td>';
                            html += '<td>' + (item.TGB_TM_NPWP ? item.TGB_TM_NPWP : '') + '</td>';
                            html += '<td>' + item.TGB_TM_NAMA_WAJIB_PAJAK + '</td>';
                            html += '<td>' + item.TGB_TM_NAMA_WAJIB_BAYAR + '</td>';
                            html += '<td>' + item.TGB_TM_AMOUNT + '</td>';
                            html += '<td>' + item.TGB_TM_BATCH_ID + '</td>';
                            html += '<td>' + item.TGB_TM_NO_SAKTI + '</td>';
                            html += '<td>' + item.TGB_TM_USER + '</td>';
                            html += '<td>' + srcAccNumber + '</td>';
                            html += '<td>' + statusText + '</td>';
                            html += '<td>' + optionHtml + '</td>';
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
                console.log(error);
            }
        });
    }

    function getStatusText(status) {
    switch (status) {
        case '0':
            return '<span class="text-primary">On Posting</span>';
        case '9':
            return '<span class="text-danger">Failed</span>';
        case '4':
            return '<span class="text-success">Posting Success</span>';
        case '5':
            return '<span class="text-primary">Payment Requested</span>';
        case '1':
            return '<span class="text-success">Payment Success</span>';
        case '6':
            return '<span class="text-primary">Reversal Requested</span>';
        case '7':
            return '<span class="text-success">Reversal Success</span>';
        case '8':
            return '<span class="text-danger">Reversal Failed</span>';
        default:
            return '';
    }
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


function editSetting(urlkey) {
    var settingData = globalResponse.find(setting => {
        var settingKey = encodeURIComponent(setting.TGB_TM_ID);
        return settingKey === urlkey;
    });
    globalTGB_TM_ID = settingData.TGB_TM_ID;
    // Menyiapkan form HTML
    console.log("TGB_TM_BILL_ID", settingData.TGB_TM_BILL_ID);
    console.log("settingData.TGB_TM_ID", globalTGB_TM_ID);
    var form = '<table class="table table-borderless">';
  
    form += '<tr>';
    form += '<td> Tgl Transaksi</td>';
    form += '<td><span id="TRAN-DT" name="TRAN_DT">' + settingData.TGB_TM_TRAN_DT + '</span></td>';
    form += '</tr>';
    form += '<tr>';
    form += '<td> Bill ID</td>';
    form += '<td><span id="BILL-ID" name="BILL_ID">' + settingData.TGB_TM_BILL_ID + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> NPWP</td>';
    form += '<td><span id="TM-NPWP" name="TM_NPWP">' + settingData.TGB_TM_NPWP + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> NAMA</td>';
    form += '<td><span id="WAJIB-PAJAK" name="WAJIB_PAJAK">' + settingData.TGB_TM_NAMA_WAJIB_PAJAK + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> AMOUNT</td>';
    form += '<td><span id="AMOUNT" name="TM_AMOUNT">' + settingData.TGB_TM_AMOUNT + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> BANK REFNUM</td>';
    form += '<td><span id="BANK-REFNUM" name="BANK_REFNUM">' + (settingData.TGB_TM_BANK_REFNUM ? settingData.TGB_TM_BANK_REFNUM : '') + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> BATCH ID</td>';
    form += '<td><span id="BATCH-ID" name="BATCH_ID">' + settingData.TGB_TM_BATCH_ID + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> NO SAKTI</td>';
    form += '<td><span id="NO-SAKTI" name="NO_SAKTI">' + settingData.TGB_TM_NO_SAKTI + '</span></td>';
    form += '</tr>';

    form += '<tr>';
    form +=
        '<td>NTPN</td><td style="padding: 2px;"> <input placeholder="Masukkan NTPN"  class="form-control" type="text" id="NTPN" name="TM_NTPN" ><label id="teksntpn" style="color:red; margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form += '<td colspan="2" class="text-right">';
    form += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
    form += '<span class="ml-2"></span>';
    form += '<button onclick="saveid(\'' + urlkey + '\')" class="btn btn-primary">Simpan</button>';
    form += '</td>';
    form += '</tr>';
    form += '</table>';

    // Menampilkan form dalam modal
    $('#mymodal').modal('show');
    $('.modal-title').html('Detail Transaksi');
    $('.modal-body').html(form);
}

function saveid(id) {
    var token = getCSRFToken();
    var ntpn = $('#NTPN').val();
    var TGB_TM_ID = globalTGB_TM_ID;

    if (ntpn == "" || ntpn.length !== 16) {
        $('#teksntpn').html('*Kolom NTPN Harus Diisi dan harus memiliki 16 digit')
        $('#NTPN').css("border-color", "red")
    } else {
        var json = {
            "_token": token,
            "TM_NTPN": ntpn,
            "TM_ID": TGB_TM_ID,
        };

        $.ajax({
            url: '/trans/transaksi/edit/' + id,
            type: 'put',
            data: json,
            dataType: 'json',
            success: function(result) {

                // Respons sukses dari server
                    Swal.fire(
                        'Sukses Diperbarui!',
                        'Klik button!',
                        'success'
                    )
                    $('#mymodal').modal('hide');
                    getItems(1);

            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    }
}