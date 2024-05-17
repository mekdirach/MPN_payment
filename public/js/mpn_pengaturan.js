document.addEventListener("DOMContentLoaded", function() {
    getItems();
});

function getItems() {
    var token = getCSRFToken();
    var requestData = {
        "_token": token
    };
    $.ajax({
        url: '/setting/pengaturan/getdata',
        type: 'get',
        data: requestData,
        dataType: 'json',
        success: function(response) {
			
            var Html = '';
            globalResponse = response;

            for (var i = 0; i < response[0].length - 1; i++) {
                var setting = response[0][i];

                var urlkey = encodeURIComponent(setting.TGC_PC_M_CODE + '_' + setting
                    .TGC_PC_CONFIG_KEY);
                //var configDesc = setting.TGC_PC_CONFIG_DESC;
                var mpnType = (setting.TGC_PC_M_CODE === '03021') ? 'MPN' : 'MPN BO';
                globalMyType = mpnType;
                var optionHtml = '<button class="btn btn-xs btn-info" onclick="editSetting(\'' +
                    urlkey +
                    '\')">Edit</button>';
                Html += '<tr>';
                Html += '<td>' + mpnType + '</td>';
				Html += '<td>' + (setting.TGC_PC_CONFIG_KEY !== "null" ? setting.TGC_PC_CONFIG_KEY : '') + '</td>';
				Html += '<td>' + (setting.TGC_PC_CONFIG_VAL !== "null" ? setting.TGC_PC_CONFIG_VAL : '') + '</td>';
				Html += '<td>' + (setting.TGC_PC_CONFIG_DESC !== "null" ? setting.TGC_PC_CONFIG_DESC : '') + '</td>';

                if (setting.TGC_PC_LAST_UPDATE) {
                    var dateTime = setting.TGC_PC_LAST_UPDATE;
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

                    Html += '<td>' + formattedDay + '-' + formattedMonth + '-' +
                        year + ' ' + timePart + '</td>';
                } else {
                    Html += '<td></td>'; // Kolom waktu kosong
                }
                Html += '<td>' + (setting.TGC_PC_UPDATE_BY ? setting.TGC_PC_UPDATE_BY : '') + '</td>';
                Html += '<td>' + optionHtml + '</td>';
                Html += '</tr>';
            }

            $('#tableContainer').html(Html);

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

function editSetting(urlkey) {
    var settingData = globalResponse[0].find(setting => {
        var settingKey = encodeURIComponent(setting.TGC_PC_M_CODE + '_' + setting.TGC_PC_CONFIG_KEY);
        return settingKey === urlkey;
    });
    var mpnType = (settingData.TGC_PC_M_CODE === '03021') ? 'MPN' : 'MPN BO';

    var form = '<table class="table table-borderless">';
    form += '<tr>';
    form +=
        '<td> Jenis</td><td><input type="hidden" id="code" value="' +
        settingData.TGC_PC_M_CODE + '">' + mpnType + '</td>';
    form += '</tr>';
    form += '<tr>';
    form += '<td> Key</td><td><input class="no-border" type="text" id="key" value="' + settingData
        .TGC_PC_CONFIG_KEY + '"></td>';
    form += '</tr>';

    form += '<tr>';
    form += '<td> Value</td><td><input class="form-control" type="text" name="value" id="val" value="' +
        (settingData.TGC_PC_CONFIG_VAL  !== "null" ? settingData.TGC_PC_CONFIG_VAL  : '') + '"></td>';
    form += '</tr>';

    form += '<tr>'
    form += '<td> Deskripsi</td><td><input  class="form-control" type="text" id="description" value="' +
        (settingData.TGC_PC_CONFIG_DESC !== "null" ? settingData.TGC_PC_CONFIG_DESC : '') + '"></td>'
    form += '</tr>'

    form += '<td colspan="2" class="text-right">';
    form += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
    form += '<span class="ml-2"></span>';
    form += '<button onclick="saveSetting(\'' + urlkey + '\')" class="btn btn-primary">Simpan</button>';
    form += '</td>';
    form += '</tr>';
    form += '</table>';

    $('#mymodal').modal('show');
    $('.modal-title').html('Edit Setting & Konfigurasi');
    $('.modal-body').html(form);
}


function saveSetting(urlkey) {
    var settingData = globalResponse[0].find(setting => {
        var settingKey = encodeURIComponent(setting.TGC_PC_M_CODE + '_' + setting.TGC_PC_CONFIG_KEY);
        return settingKey === urlkey;
    });
    var token = getCSRFToken();
    var code = $('#code').val();
    var key = $('#key').val();
    var value = $('#val').val();
    var deskripsi = $('#description').val();

    var requestData = {
        "_token": token,
        "key": key,
        "value": value,
        "deskripsi": deskripsi
    };

    $.ajax({
        url: '/setting/pengaturan/update/' + code,
        type: 'put', // Ganti dengan metode yang sesuai (POST atau PUT)
        data: requestData,
        dataType: 'json',
        success: function(response) {
 	 	
            // Handle sukses, misalnya tutup modal atau muat ulang data
            $('#mymodal').modal('hide');
		Swal.fire(
                    'Sukses Diubah!',
                    'Klik button!',
                    'success'
                )

            getItems(); // Muat ulang data setelah update
        },
        error: function(xhr, status, error) {
            $('#mymodal').modal('hide');
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