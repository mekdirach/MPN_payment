function getCSRFToken() {
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        return tokenMeta.getAttribute('content');
    }
    return null;
}

document.addEventListener("DOMContentLoaded", function() {
    const selectAllCheckbox = document.getElementById('allChek');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    getItems(1);
});

var currentPage = 1;
var maxPages = 1;
var rowCount = 10; // Jumlah rows awal
var token = getCSRFToken();

function getItems(page) {
    var keywords = "";
    var rowCount = $('#row-count').val();
    var url = "/admin/manualreveral/search";

    // Buat objek data dengan parameter-parameter awal
    var data = {
        "row_count": rowCount,
        "page": page,
        "_token": token
    };
    if (keywords.length > 0) {
        data.keywords = keywords;
    }

    // Buat URL dengan parameter-parameter yang sesuai
    url += "?keywords=" + keywords + "&row_count=" + rowCount + "&page=" + page +
        "&_token=" + token;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
         success: function(data) {
            var items = data.items.slice(0, data.items.length - 1); // Mengambil semua data kecuali yang terakhir

            var html = '';
            globalResponse = items;

            // Buat HTML tabel
            if (items && Array.isArray(items) && items.length-1 >= 0) {
                items.forEach(function(item) {

                    var urlkey = {
                        'id': encodeURIComponent(item.TGB_TM_ID)
                    };

                        if (item.TGB_TM_NTPN === null || item.TGB_TM_NTPN === '' || item
                            .TGB_TM_NTPN === '-') {
                            optionHtml =
                                '<button class="btn btn-xs btn-info" onclick="editSetting(\'' +
                                item.TGB_TM_BILL_ID +
                                '\')">Reversal</button>';
                        } else {
                            optionHtml =
                                '';
                        }

                        html += '<tr>';
                        html += '<td><input type="checkbox" class="rowCheck" value="' + item
                        .TGB_TM_BILL_ID + '"></td>';
                        html += '<td>' + item.TGB_TM_TRAN_DT + '</td>';
                        html += '<td>' + item.TGB_TM_BILL_ID + '</td>';
                        html += '<td>' + item.TGB_TM_NTB + '</td>';
                        html += '<td>' + item.TGB_TM_NTPN + '</td>';
                        html += '<td>' + item.TGB_TM_BANK_REFNUM + '</td>';
                        html += '<td>' + item.TGB_TM_NPWP + '</td>';
                        html += '<td>' + item.TGB_TM_NAMA_WAJIB_PAJAK + '</td>';
                        html += '<td>' + item.TGB_TM_NAMA_WAJIB_BAYAR + '</td>';
                        html += '<td>' + item.TGB_TM_AMOUNT + '</td>';
                        html += '<td>' + item.TGB_TM_BATCH_ID + '</td>';
                        html += '<td>' + item.TGB_TM_NO_SAKTI + '</td>';
                        html += '<td>' + item.TGB_TM_USER + '</td>';
                        html += '<td>' + item.TGB_TM_ACCOUNT + '</td>';
                        html += '<td style="color: ' + (item.STATUS ===
                                'Reversal Failed' || item.STATUS ===
                                'Payment Requested' ? 'red' : 'blue') + '">' + item
                            .STATUS + '</td>';
                        html += '<td>' + optionHtml + '</td>';
                        html += '</tr>';
                    
                });

                $('#caridata').html(html);
            } else {
                html += '<tr><td colspan="13">No items found.</td></tr>';
                $('#caridata').html(html);
            }

            // Setelah membangun HTML tabel, masukkan ke dalam elemen dengan id 'caridata'
            enableButtons();

            const rowCheckboxes = document.querySelectorAll('.rowCheck');
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckCheckbox = document.getElementById('allChek');
                    const allChecked = document.querySelectorAll(
                            '.rowCheck:checked')
                        .length === rowCheckboxes.length;
                    allCheckCheckbox.checked = allChecked;
                });
            });

            // Check the "Select All" checkbox initially if all row checkboxes are checked
            const allCheckCheckbox = document.getElementById('allChek');
            allCheckCheckbox.checked = rowCheckboxes.length > 0 && rowCheckboxes.length === document
                .querySelectorAll('.rowCheck:checked').length;
            currentPage = data.currentPage;
            maxPages = data.lastPage;
            updatePaginationButtons();
        },
        error: function(error) {
            console.log(error.responseText);
            console.log(error);
        }
    });
}
/*
function processAll() {
    enableButtons();
    const checkboxes = document.querySelectorAll('.rowCheck:checked');

    if (checkboxes.length === 0) {
        alert('Tidak ada data yang perlu di Manual Reversal');
        return;
    }else if(checkboxes.length != checkboxes.length){
		alert('Tidak ada data yang perlu di Manual Reversal');
        return;
	}

    const conf = window.confirm('Yakin mau melakukan proses Manual Reversal Semuanya??');
    if (conf) {
        const billIds = Array.from(checkboxes).map(checkbox => checkbox.value);
        const token = getCSRFToken();
        
        const requestData = {
            "_token": token,
            "bill_id": billIds.join(",")
        };

        // Continue with the AJAX request
        $.ajax({
            url: '/admin/manualreveral/aksi',
            type: 'put',
            data: requestData,
            dataType: 'json',
            success: function(response) {
				getItems(1);
                //console.log(response);
                if (response[0] === "error") {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-danger">' + response[1] + '</span>',
                        html: 'Opss..',
                    })
                } else if (response[0] === "success") {
                    Swal.fire(
                        '<span class="text-success">' + response[1] + '</span>!',
                        '',
                        'success'
                    )
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error('Error:', error);
            }
        });
    }
}*/

function processAll() {
    enableButtons();
    const conf = window.confirm('Yakin mau melakukan proses Manual Reversal Semuanya??');
	
    if (conf) {
        const checkboxes = document.querySelectorAll('.rowCheck');
        const billIds = Array.from(checkboxes).map(checkbox => checkbox.value);
        const token = getCSRFToken();

        const requestData = {
            "_token": token,
            "bill_id": billIds.join(",")
        };
		console.log(billIds.join(","));

        // Continue with the AJAX request
        $.ajax({
            url: '/admin/manualreveral/aksi',
            type: 'put',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                getItems(1);
                
                // Accessing the first element of the 'responses' array
                var firstResponse = response.responses[0];
            
                if (firstResponse[0] === "error") {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-danger">' + firstResponse[1] + '</span>',
                        html: 'Total Sukses: ' + response.successCount + '<br>Total Errors: ' + response.errorCount,
                    });
                    
                } else if (firstResponse[0] === "success") {
                    Swal.fire(
                        '<span class="text-success">' + firstResponse[1] + '</span>!',
                        'Total Sukses: ' + response.successCount,
                        'success'
                    );
                }
            },
            
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error('Error:', error);
            }
        });
    }else{
		const checkboxes = document.querySelectorAll('.rowCheck');
		const checkedCheckboxes = document.querySelectorAll('.rowCheck:checked');

		if (checkedCheckboxes.length === 0) {
			alert('Tidak ada data yang dipilih.');
			return;
		}
	}
}



function process() {
    enableButtons();
    const billIds = Array.from(document.querySelectorAll('.rowCheck:checked')).map(checkbox => checkbox.value);

    if (billIds.length === 0) {
        alert('Pilih setidaknya satu bill untuk diproses');
        return;
    }

    const token = getCSRFToken();
    const requestData = {
        "_token": token,
        "bill_id": billIds.join(",")
    };
	console.log(billIds.join(","));

    const conf = window.confirm('Yakin mau melakukan proses Manual Reversal??');
    if (conf) {
        $.ajax({
            url: '/admin/manualreveral/aksi',
            type: 'put',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                getItems(1);
                
                // Accessing the first element of the 'responses' array
                var firstResponse = response[0];
            
                if (firstResponse[0] === "error") {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-danger">' + firstResponse[1] + '</span>',
                        html: 'Total Errors: ' + response.errorCount,
                    });
                } else if (firstResponse[0] === "success") {
                    Swal.fire(
                        '<span class="text-success">' + firstResponse[1] + '</span>!',
                        'Total Sukses: ' + response.successCount,
                        'success'
                    );
                }
            },
            
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error('Error:', error);
            }
        });
    }
}



function enableButtons() {
    // Mengaktifkan tombol "Process Selected" dan "Process All"
    document.getElementById("processButton").disabled = false;
    document.getElementById("processAllButton").disabled = false;
}

$(document).ready(function() {

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

function editSetting(urlKey) {
    var token = getCSRFToken();
    var conf = window.confirm('Apakah Anda Yakin untuk Manual Reversal ?');
    var json = {
        "_token": token,
    };
    if (conf) {
        $.ajax({
            url: '/admin/manualreveral/search/' + urlKey,
            type: 'post',
            data: json,
            dataType: 'json',
            success: function(data) {
              
			  getItems(1);
                if (data[0] === "error") {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-danger">' + data[1] + '</span>',
                        html: 'Opss..',
                    })
                } else if (data[0] === "success") {
                    Swal.fire(
                        '<span class="text-success">' + data[1] + '</span>!',
                        '',
                        'success'
                    )
                }

                 // 1000 milidetik = 1 detik
            },
            error: function(error) {
                console.log(error.responseText);
                console.log(error);
            }
        });

    }

}