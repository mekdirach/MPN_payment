$(document).ready(function() {

    var responseDiv = document.getElementById("response");
    var itemDetails = document.getElementById("itemDetails");
    var responseData = null; // Menyimpan respons dari AJAX

    // Fungsi untuk mengirim permintaan AJAX
     function getItems(responseDiv) {
                var token = getCSRFToken();
                var batchId = $('#batch-Id').text();
                var nomorSakti = $('#nomorSaktiInput').val();

                if (nomorSakti === "") {
					$("#response").text("Nomor Sakti tidak boleh kosong!");
                    //responseDiv.innerHTML = "Nomor Sakti tidak boleh kosong!";
                    return;
                }
                if (nomorSakti.length !== 16) {
					$("#response").text("Nomor Sakti harus terdiri dari 16 digit!");
                   // responseDiv.innerHTML = "Nomor Sakti harus terdiri dari 16 digit!";
                    return;
                }
                console.log(nomorSakti);
				//responseDiv.innerHTML = "";

                $.ajax({
                    url: '/limpahkan/nomorsakti/check-nomor-sakti', // Ganti dengan path yang sesuai
                    type: 'POST',
                    data: {
                        "nomorSakti": nomorSakti,
                        "_token": token
                    },
                    dataType: 'json',
                    success: function(checkResponse) {
                        if (!checkResponse.success) {
                            // If not successful, display the error message in the "respone" label
                            $("#response").text(checkResponse.message);
                        } else {
							$("#response").text("");
                            var requestData = {
                                "batchId": batchId,
                                "nomorSakti": nomorSakti,
                                "_token": token
                            };

                            
                            $.ajax({
                                url: '/limpahkan/nomorsakti/telahlimpahkan',
                                type: 'POST',
                                data: requestData,
                                dataType: 'json',
                                success: function(response) {
                                    responseData = response;
                                    $("#tanggalPelimpahan").text(responseData.data[
                                        'Tgl Pelimpahan']);
                                    $("#batchID").text(responseData.data['Batch Id']);
                                    $("#mataUang").text(responseData.data['Mata Uang']);
                                    $("#nomorSakti").text(responseData.data['Nomor Sakti']);
                                    $("#noRek").text(responseData.data['Nomor Rekening']);
                                    $("#totalTransaksi").text(responseData.data[
                                        'Total Pembayaran']);
                                    $("#jumlahTransaksi").text(responseData.data[
                                        'Jumlah Transaksi']);

                                    // Menampilkan detail item
                                    $(itemDetails).removeClass("hidden");

                                    if (responseData.success) {
                                        // Membuat dan menambahkan elemen table ke dalam itemDetails
                                        var table = $('<table>').addClass(
                                            'table product-item-table').css(
                                            'border-collapse', 'collapse');
                                        var tbody = $('<tbody>').appendTo(table);

                                        // Loop untuk setiap detail dalam foot
                                        responseData.foot.forEach(function(field) {
                                            if (field.type === 'hidden') {
                                                $('<input>').attr({
                                                    type: 'hidden',
                                                    name: field.name,
                                                    value: field.value
                                                }).appendTo(itemDetails);
                                            } else if (field.type === 'submit') {
                                                var submitButton = $('<button>')
                                                    .attr({
                                                        type: field.type,
                                                        name: 'submit_lanjutkan',
                                                        class: 'btn btn-primary',
                                                        onClick: 'return pre_submit()' // Memanggil fungsi pre_submit
                                                    }).text(field.value);

                                                submitButton.addClass(
                                                    'right-aligned-button');
                                                submitButton.appendTo(itemDetails);
                                            } else {
                                                var tr = $('<tr>').appendTo(tbody);
                                                $('<td>').text(field.name + ':')
                                                    .appendTo(tr);
                                                $('<td>').text(':').appendTo(tr);
                                                $('<td>').append($('<span>').text(
                                                    field.value)).appendTo(tr);
                                            }
                                        });
                                        $(itemDetails).addClass("hidden");
                                    } else {
                                        var html = '<div class="badge badge-danger">' +
                                            responseData.error + '</div>';
                                        $(html).insertBefore(
                                            "#itemDetails"
                                        ); // Menampilkan pesan di atas itemDetails
                                        $("#itemDetails").remove();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    var pesanKesalahan = '';
                                    if (xhr.responseText) {
                                        pesanKesalahan += 'Tidak Ada Respone Dari Sistem!';
                                    }
                                    $("#itemDetails").html(
                                        '<div class="badge badge-danger">' +
                                        pesanKesalahan + '</div>');
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle kesalahan jika terjadi error saat pengecekan nomor sakti
                    }
                });
            }
    // Menggunakan event listener untuk tombol submit
    $(document).on('click', 'button[name="submit_lanjutkan"]', function(event) {
        event.preventDefault();
        pre_submit();
    });

    function pre_submit() {
        // Contoh validasi sederhana

        if (responseData && responseData.success) {
            console.log(responseData.success);
            var data = responseData.data;
            var token = getCSRFToken();
            var requestData = {
                "batchId": data['Batch Id'],
                "nomorSakti": data['Nomor Sakti'],
                "dtlp": data['Tgl Pelimpahan'],
                "cur": data['Mata Uang'],
                "totalSum": data['Total Pembayaran'],
                "totalRow": data['Jumlah Transaksi'],
                "noRek": data['Nomor Rekening'],
                "refnum": data['REFNUM'],
                "_token": token
            };

            // Lakukan permintaan AJAX untuk mengirim data
            $.ajax({
                url: '/limpahkan/nomorsakti/sukses',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    var html = '<div class="badge badge-success">' + response.message +
                        '</div>';
                    $(html).insertBefore(
                        "#itemDetails"); // Menampilkan pesan di atas itemDetails
                    $("#itemDetails").remove();
                    // Mengosongkan dan menyembunyikan elemen itemDetails
                    //$(itemDetails).empty().hide();
                },
                error: function(xhr, status, error) {
                    // Handle kesalahan jika terjadi error saat pengiriman data
                }
            });
        } else {
            alert("Validasi gagal. Mohon periksa input Anda.");
            return false; // Jangan submit form
        }
    }

    // Event listener untuk form pencarian
    $('#search-form').submit(function(e) {
        e.preventDefault();
        getItems();
    });

    // Fungsi untuk mengambil CSRF Token
    function getCSRFToken() {
        var tokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (tokenMeta) {
            return tokenMeta.getAttribute('content');
        }
        return null;
    }

});

 // Fungsi untuk menghapus cookie berdasarkan namanya
 function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

// Mendapatkan elemen dengan ID "batch-Id"
var batchIdLabel = document.getElementById("batch-Id");

// Cek apakah cookie 'batchid' ada
if (document.cookie.indexOf('batchid=') !== -1) {
    // Ambil nilai cookie 'batchid'
    var batchIdValue = batchIdLabel.textContent.trim();

    // Hapus cookie 'batchid'
    deleteCookie('batchid');

    // Gantilabel dengan nilai yang dihapus dari cookie
    batchIdLabel.textContent = '';

    // Selanjutnya, Anda dapat memperbarui atau melakukan tindakan apa pun sesuai kebutuhan
}



