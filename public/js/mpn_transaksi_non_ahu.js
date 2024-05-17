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
$(document).ready(function() {
 // Jumlah rows awal
    var token = getCSRFToken();

    // Fungsi untuk memanggil API pencarian
    function getItems(page) {
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        // await updateMaxPages();
        $.ajax({
            url: "/trans/transaksinonahu/search",
            type: 'GET',
            data: {
                "start_date": startDate,
                "end_date": endDate,
                "_token": token
            },
            success: function(response) {
                var items = response.items;
                var html = '';
                console.log(items);

                if (items && Array.isArray(items) && items.length >
                    0) {
                    items.forEach(function(item, index) {
                        var rowNumber = (currentPage - 1) * rowCount + index + 1;

                        var dateTime = item.AHUM_TM_TRX_DT_TM;
                        var datetimeObj = new Date(dateTime);
                        // Mendapatkan tanggal
                        var day = datetimeObj.getDate();
                        var month = datetimeObj.getMonth() + 1;
                        var year = datetimeObj.getFullYear();

                        // Menambahkan nol di depan jika nilai day atau month kurang dari 10
                        day = day < 10 ? "0" + day : day;
                        month = month < 10 ? "0" + month : month;

                        // Mendapatkan waktu
                        var timePart = datetimeObj.toLocaleTimeString();
                        html += '<tr>';
                        html += '<td>' + item.AHUM_TM_BILL_CODE1 + '</td>';
                        html += '<td>' + item.AHUM_TM_BILLER_NAME + '</td>';
                        html += '<td>' + item.AHUM_TM_KL_CODE + '</td>';
                        html += '<td>' + item.AHUM_TM_ESELON_CODE + '</td>';
                        html += '<td>' + item.AHUM_TM_SATKER_CODE + '</td>';
                        html += '<td>' + item.AHUM_TM_PAYMENT + '</td>';
                        html += '<td>' + item.AHUM_TM_TRX_ID + '</td>';
                        html += '<td>' + item.AHUM_TM_NTPN + '</td>';
                        html += '<td>' + day + "-" + month + "-" + year + '</td>';
                        html += '<td>' + timePart + '</td>';
                        html += '<td>' + item.AHUM_TM_COMPANY_CODE + '</td>';
                        html += '</tr>';
                    });

                } else {
                    html += '<p> No items found.</p>';
                }

                $('#caridata').html(html);


            },
            error: function(error) {
                console.log(error);
            }
        });
    }


    // Event listener untuk form pencarian
    $('#search-form').submit(function(e) {
        e.preventDefault();
        performSearch();
    });

    // Fungsi untuk melakukan pencarian
    function performSearch() {
       
        getItems();
    }

  
});
   