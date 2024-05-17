 
 document.addEventListener("DOMContentLoaded", function() {
    getItems(1);
});
// Fungsi untuk memperoleh token CSRF dari elemen meta
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
var globalResponse = []; // Variabel globalResponse dideklarasikan di sini

// Fungsi untuk memanggil API pencarian
function getItems(page) {
    var startDate = $('#start-date').val();
    var endDate = $('#end-date').val();
    rowCount = $('#row-count').val(); // Update rowCount
    var url = "/member/holiday/search";
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
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function(response) {
            var items = response.items;
            var html = '';
            globalResponse = items;
            for (var i = 0; i < items.length - 1; i++) { // Perubahan di sini
                var item = items[i];
				
				var formattedDate = ubahFormatTanggal(item.TGB_HL_TGL);
                html += '<tr>';
                html += '<td>' + formattedDate + '</td>';
                html += '<td>';
                html +=
                    '<button  class="btn btn-xs btn-danger" value="' + item.TGB_HL_TGL +
                    '" onclick="delete_(\'' +
                    item.TGB_HL_TGL +
                    '\')">Hapus <span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                html += '<span class="ml-2"></span>';
                html += '<button class="btn btn-sm btn-primary" value="' + item.TGB_HL_TGL +
                    '" onclick="editform(\'' + item.TGB_HL_TGL +
                    '\')">Edit <span class="btn-label"><i class="fa fa-pencil"></i></span></button>';
                html += '</td>';
                html += '</tr>';
            }
            $('#caridata').html(html);

            currentPage = response.currentPage;
            maxPages = response.lastPage;
            updatePaginationButtons();
        },
        error: function(xhr, status, error) {
            
        }
    });
}

 function ubahFormatTanggal(tanggal) {
                // Ubah format tanggal dari "YYYYMMDD" menjadi "DD/MM/YYYY"
                var tahun = tanggal.substr(0, 4);
                var bulan = tanggal.substr(4, 2);
                var hari = tanggal.substr(6, 2);
                return hari + '-' + bulan + '-' + tahun;
 }

/// Fungsi untuk mengupdate tombol "Previous" dan "Next"
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

function editform(id) {
    var settingData = globalResponse.find(setting => {
        var settingKey = setting.TGB_HL_TGL;
        return settingKey === id;
    });
    var form = '<table class="table table-borderless">';
    form += '<tr>';
    form += '<td> Tanggal</td>';
    form += '<td><input class="form-control" type="date" id="tanggal" value="' +
        formatDate(settingData.TGB_HL_TGL) + '"></td>';
    form += '</tr>';
    form += '<tr>';
    form += '<td colspan="2" class="text-right">';
    form += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
    form += '<span class="ml-2"></span>';
    form += '<button onclick="saveSetting(\'' + id + '\')" class="btn btn-primary">Simpan</button>';
    form += '</td>';
    form += '</tr>';
    form += '</table>';
    $('#mymodal').modal('show');
    $('.modal-title').html('Edit Holiday');
    $('.modal-body').html(form);
}

// Fungsi untuk memformat tanggal dari "20140816" menjadi "yyyy-MM-dd"
function formatDate(inputDate) {
    var year = inputDate.substr(0, 4);
    var month = inputDate.substr(4, 2);
    var day = inputDate.substr(6, 2);
    return year + '-' + month + '-' + day;
}

function saveSetting(id) {
    var settingData = globalResponse.find(setting => {
        var settingKey = setting.TGB_HL_TGL;
        return settingKey === id;
    });
   
    var token = getCSRFToken();
    var date = $('#tanggal').val();
    var requestData = {
        "_token": token,
        "tanggal": date,
    };
    
    $.ajax({
        url: '/member/holiday/update/' + id,
        type: 'put',
        data: requestData,
        dataType: 'json',
        success: function(response) {
           
            // Handle sukses, misalnya tutup modal atau muat ulang data
            $('#mymodal').modal('hide');
            Swal.fire(
                'Sukses Diupdate!',
                'Klik button!',
                'success'
            )
            getItems(currentPage);
        },
        error: function(xhr, status, error) {
           
            $('#mymodal').modal('hide');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal Pemperbaharui Data!',
              })
            getItems(currentPage);
        }
    });
}

function delete_(id) {
    var token = getCSRFToken();
    var conf = window.confirm('Yakin mau menghapus ini?');
    var json = {
        "_token": token,
        "tanggal": id,
    };
   
    if (conf) {
        $.ajax({
            url: '/member/holiday/deleteby/' + id,
            type: 'delete',
            data: json,
            dataType: 'json',
            success: function(result) {
                $('#mymodal').modal('hide');
                Swal.fire(
                    'Sukses Dihapus!',
                    'Klik button!',
                    'success'
                )

                // Ambil kembali data setelah penghapusan yang sukses
                getItems(currentPage);
                // Reload data after successful delete
            },
            error: function(xhr) {
                
                var errorMessage = xhr.responseText; // Pesan kesalahan dalam respons teks
               
            }
        });
    }
}