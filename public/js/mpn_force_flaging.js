document.addEventListener("DOMContentLoaded", function() {
    const selectAllCheckbox = document.getElementById('allChek');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    processSelected();
});
var currentPage = 1;
var maxPages = 1;

function processAll() {
    enableButtons();
    var checkboxes = document.querySelectorAll('.rowCheck:checked');

    if (checkboxes.length === 0) {
        alert('TIdak ada data yang perlu di force flaging');
        return;
    } else {
        var conf = window.confirm('Yakin mau melakukan proses force flaging Semunya??');
        if (conf) {
            var billIds = [];


            var rows = document.querySelectorAll('#force-flaging tr');
            rows.forEach(row => {
                var checkbox = row.querySelector('.rowCheck');
                if (checkbox) {
                    billIds.push(checkbox.value);
                }
            });


            var token = getCSRFToken();
            var requestData = {
                "_token": token,
                "bill_id": billIds.join(",")
            };

            // Lanjutkan dengan permintaan AJAX
            $.ajax({
                url: '/admin/force/flalaging/aksi',
                type: 'put',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    if (response.message) {
                        Swal.fire(
                            'Sukses force flaging!',
                            response.message,
                            'Klik button!',
                            'success'
                        )
                        processSelected();
                    } else if (response.error) {

                        alert(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error('Error:', error);
                }
            });
        }
    }
}

function process() {
    enableButtons();
    var billIds = [];


    var checkboxes = document.querySelectorAll('.rowCheck:checked');
    checkboxes.forEach(checkbox => {
        billIds.push(checkbox.value);
    });


    if (billIds.length > 0) {

        var token = getCSRFToken();
        var requestData = {
            "_token": token,
            "bill_id": billIds.join(",")
        };


        $.ajax({
            url: '/admin/force/flalaging/aksi',
            type: 'put',
            data: requestData,
            dataType: 'json',
            success: function(response) {

                if (response.message) {
                    Swal.fire(
                        'Sukses force flaging!',
                        response.message,
                        'Klik button!',
                        'success'
                      )
                      processSelected();
                } else if (response.error) {
                    // Terdapat kesalahan dalam permintaan
                    alert(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error('Error:', error);
            }
        });
    } else {
        alert('Pilih setidaknya satu bill untuk diproses');
    }
}

function processSelected() {
    var rowCount = $('#row-count').val();
    var token = getCSRFToken();
    var requestData = {
        "_token": token,
        "page": currentPage,
        "row_count": rowCount
    };
    $.ajax({
        url: '/admin/force/flagingdata',
        type: 'get',
        data: requestData,
        dataType: 'json',
        success: function(data) {
            var items = data.items;
            var tableHtml = '';

            if (items.length === 0) {
                enableButtons();
                // Tambahkan data dummy jika data dari server tidak ada
                tableHtml += '<tr style="text-align: center;">';
                tableHtml += '<td colspan="6">Data not found</td>';
                tableHtml += '</tr>';
             
            } else {
               

                for (var i = 0; i < items.length - 1; i++) {
                    var setting = items[i];

                    const formattedNominal = "Rp. " + number_format(setting.AMOUNT, 0, '.', ',');
                    tableHtml += '<tr>';
                    tableHtml += '<td><input type="checkbox" class="rowCheck" value="' + setting
                        .BILLID + '"></td>';
                    tableHtml += '<td>' + setting.BILLID + '</td>';
                    tableHtml += '<td>' + setting.ACCOUNT_SRC + '</td>';
                    tableHtml += '<td>' + setting.ACCOUNT_DST + '</td>';
                    tableHtml += '<td>' + setting.BANK_REFFNUM + '</td>';
                    tableHtml += '<td>' + formattedNominal + '</td>';
                    tableHtml += '</tr>';
                }

            }

            // Gantikan seluruh isi dari <tbody> dengan data baru termasuk data dummy
            $('#force-flaging').html(tableHtml);
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
        error: function(xhr, status, error) {
             var html = '';
            
            html += '<tr>' + xhr.responseJSON.error + '</tr>';
            $('#force-flaging').html(html);        
	}
    });
}

function enableButtons() {
    // Mengaktifkan tombol "Process Selected" dan "Process All"
    document.getElementById("processButton").disabled = false;
    document.getElementById("processAllButton").disabled = false;
}

function disableButtons() {
    // Menonaktifkan tombol "Process Selected" dan "Process All"
    document.getElementById("processButton").disabled = true;
    document.getElementById("processAllButton").disabled = true;
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

function performSearch() {
    currentPage = 1;
    processSelected(currentPage);
}

function changeNumRows() {
    rowCount = $('#row-count').val();

    performSearch();
}

// Event listener untuk perubahan jumlah rows
$('#row-count').change(changeNumRows);



// Event listener untuk tombol "Previous"
$('#previous-btn').click(function() {
    if (currentPage > 1) {
        currentPage--;
        processSelected(currentPage);
    }
});

// Event listener untuk tombol "Next"
$('#next-btn').click(function() {
    if (currentPage < maxPages) {
        currentPage++;
        processSelected(currentPage);
    }
});


// Event listener saat tombol Reset diklik
$('#reset-btn').click(function() {
    resetSearchForm();
    performSearch();
});

function getCSRFToken() {
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        return tokenMeta.getAttribute('content');
    }
    return null;
}

function number_format(number, decimals, decimalSeparator, thousandsSeparator) {
    number = parseFloat(number);
    if (isNaN(number) || !isFinite(number)) return NaN;
    decimals = decimals || 0;
    decimalSeparator = decimalSeparator || '.';
    thousandsSeparator = thousandsSeparator || ',';

    var fixedNumber = number.toFixed(decimals);
    var parts = fixedNumber.split('.');
    var integerPart = parts[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + thousandsSeparator);
    var decimalPart = parts.length > 1 ? decimalSeparator + parts[1] : '';

    return integerPart + decimalPart;
}