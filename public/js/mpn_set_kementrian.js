document.addEventListener("DOMContentLoaded", function() {
    getItems();
});

function addform() {

    var form = '<table class="table table-borderless">';
    form += '<tr>';
    form +=
        '<td>PNBP</td><td style="padding: 2px;"><input class="form-control" type="text" id="pnbp" name="MPN_TRX_PNBP" placeholder="Masukkan Kode" required><label id="tekskode" style="color:red; margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td>Kode K/L</td><td style="padding: 2px;"> <input class="form-control" type="text" id="code" name="KL_CODE" placeholder="Masukkan Id" ><label id="teksid" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td> Nama</td><td style="padding: 2px;"> <input class="form-control" type="text" id="name" name="TRX_NAME" placeholder="Masukkan Name" ><label id="teksname" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td> Kode Eselon</td><td style="padding: 2px;"><input class="form-control" type="text" id="eselon_code" name="TRX_ESELON_CODE" placeholder="Masukkan Kode Eselon"><label id="tekseselon" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td> Kode Satker</td><td style="padding: 2px;"><input class="form-control" type="text" id="satker_code" name="TRX_SATKER_CODE" placeholder="Masukkan Satker"><label id="teksatker" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td> Message Type</td><td style="padding: 15px;"><select class="form-select" id="type" name="TRX_MSG_TYPE" >';
    form += '<option value="2200" >WSDL</option>';
    form += '<option value="0200" >ISO 8583:1987</option>';
    form += '</select></td>';
    form += '<tr>';
    form += '<td> Status</td><td style="padding: 15px;"><select class="form-select" id="status" name="status">';
    form += '<option value="1" > Aktif</option>';
    form += '<option value="0" > Tidak Aktif</option>';
    form += '</select></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td>First Char </td><td style="padding: 2px;"><input class="form-control" type="text" id="chars" name="FIRST_CHARS" placeholder="Masukkan Chars"><label id="tekschars" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td>IP </td><td style="padding: 2px;"><input class="form-control" type="text" id="ip" name="TRX_IP" placeholder="Masukkan Ip" ><label id="teksip" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td>Port </td><td style="padding: 2px;"><input class="form-control" type="text" id="port" name="TRX_PORT" placeholder="Masukkan Port"><label id="teksport" style="color:red;  margin: 0; padding: 0;"></label></td>';
    form += '</tr>';
    form += '<tr>';
    form +=
        '<td>Timeout </td><td style="padding: 2px;"><input class="form-control" type="text" id="timeout" name="TRX_TIMEOUT" placeholder="Masukkan Timeout"><label id="tekstimeout" style="color:red;  margin: 0; padding: 0;"></label> millisecond</td>';
    form += '</tr>';
    form += '<td>Kolom </td><td>';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_BILL_CODE1"> Kode Billing ';
    form +=
        '<input type="checkbox" name="kolom[]" value="NAHUM_TM_BILLER_NAME"> Nama Wajib Bayar ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_KL_CODE"> Kode K/L ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_ESELON_CODE"> Kode Eselon ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_SATKER_CODE"> Kode Satker ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_PAYMENT"> Nominal ';
    form += '<br>';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_NTPN"> Nomor NPTN ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_CURRENCY"> Kode Mata Uang ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_TRAN_DT"> Tanggal Bayar ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_TRAN_DT|jam"> Jam Bayar ';
    form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_COMPANY_CODE"> Kode Bank ';
    form += '</td>';

    form += '<tr>';
    form += '<td colspan="2" class="text-right">';
    form += '<span class="ml-2"></span>';
    form += '<button  class="btn btn-primary" onclick="save()">Simpan</button>';
    form += '</td>';
    form += '</tr>';
    form += '</table>';

    $('#mymodal .modal-dialog').addClass('modal-lg');
    $('#mymodal').modal('show');
    $('.modal-title').html('Tambah Setting Kementrian');
    $('.modal-body').html(form);

}


function save() {
    var token = getCSRFToken();
    var kode = $('#pnbp').val();
    var id = $('#code').val();
    var name = $('#name').val();
    var eselon_code = $('#eselon_code').val();
    var satker_code = $('#satker_code').val();
    var type = $('#type').val();
    var status = $('#status').val();
    var chars = $('#chars').val();
    var ip = $('#ip').val();
    var port = $('#port').val();
    var timeout = $('#timeout').val();
    var selectedColumns = $("input[name='kolom[]']:checked").map(function() {
        return $(this).val();
    }).get();

    function showError(field, message) {
        $(field).html(message);
        $(field).css("border-color", "red");
    }

    function clearError(field) {
        $(field).html('');
        $(field).css("border-color", "");
    }

    // Validasi kode dan id
    if (kode === "" || kode.length !== 4) {
        showError('#tekskode', '*Kolom PNBP harus diisi dan harus memiliki 4 digit');
    } else {
        clearError('#tekskode');
    }

    if (id === "" || id.length !== 3) {
        showError('#teksid', '*Kolom Kode K/L harus diisi dan harus memiliki 3 digit');
    } else {
        clearError('#teksid');
    }

    // Validasi kolom-kolom lainnya
    if (name === "") {
        showError('#teksname', '*Kolom Nama harus diisi');
    } else {
        clearError('#teksname');
    }

    if (eselon_code === "" || eselon_code.length !== 2) {
        showError('#tekseselon', '*Kolom Eselon harus diisi dan harus memiliki 2 digit');
    } else {
        clearError('#tekseselon');
    }

    if (satker_code === "" || satker_code.length !== 6) {
        showError('#teksatker', '*Kolom Satker harus diisi dan harus memiliki 6 digit');
    } else {
        clearError('#teksatker');
    }

    if (chars === "" || chars.length !== 3) {
        showError('#tekschars', '*Kolom Char harus diisi dan harus memiliki 3 digit');
    } else {
        clearError('#tekschars');
    }

    if (ip === "") {
        showError('#teksip', '*Kolom IP harus diisi');
    } else {
        clearError('#teksip');
    }

    if (port === "") {
        showError('#teksport', '*Kolom Port harus diisi');
    } else {
        clearError('#teksport');
    }

    if (timeout === "") {
        showError('#timeout', '*Kolom Timeout harus diisi');
    } else {
        clearError('#timeout');
    }


    // Jika tidak ada pesan kesalahan, kirim data dengan AJAX
    if ($('#tekskode').text() === '' &&
        $('#teksid').text() === '' &&
        $('#teksname').text() === '' &&
        $('#tekseselon').text() === '' &&
        $('#teksatker').text() === '' &&
        $('#tekschars').text() === '' &&
        $('#teksip').text() === '' &&
        $('#teksport').text() === '' &&
        $('#tekstimeout').text() === '' &&
        $('#kolomError').text() === '') {
        var json = {
            "_token": token,
            "MPN_TRX_PNBP": kode,
            "KL_CODE": id,
            "TRX_NAME": name,
            "TRX_ESELON_CODE": eselon_code,
            "TRX_SATKER_CODE": satker_code,
            "TRX_MSG_TYPE": type,
            "status": status,
            "FIRST_CHARS": chars,
            "TRX_IP": ip,
            "TRX_PORT": port,
            "TRX_TIMEOUT": timeout,
            "kolom": selectedColumns
        };
        console.log(json);

        $.ajax({
            url: '/setting/settingkementrian/AddKementrianSetting',
            type: 'post',
            data: json,
            dataType: 'json',

            success: function(result) {
                $('#mymodal').modal('hide');
                Swal.fire(
                    'Sukses Ditambahkan!',
                    'Klik button!',
                    'success'
                )
                getItems();
            },
            error: function(xhr) {

                $('#mymodal').modal('show');
                showErrorMessage("Terjadi Kesalahan: " + xhr.responseText);
                getItems();
            }
        })
    }
}

function qwe() {
    var token = getCSRFToken();
    var kode = $('#pnbp').val();
    var id = $('#code').val();
    var name = $('#name').val();
    var eselon_code = $('#eselon_code').val();
    var satker_code = $('#satker_code').val();
    var type = $('#type').val();
    var status = $('#status').val();
    var chars = $('#chars').val();
    var ip = $('#ip').val();
    var port = $('#port').val();
    var timeout = $('#timeout').val();
    var selectedColumns = $("input[name='kolom[]']:checked").map(function() {
        return $(this).val();
    }).get();



    if (kode == "" && id == "" && name == "" && eselon_code == "" && satker_code == "" && chars == "" && ip == "" &&
        port == "" && timeout == "") {
        $('#tekskode').html('*Kolom Kode Harus Diisi')
        $('#pnbp').css("border-color", "red")
        $('#teksid').html('*Kolom ID Harus Diisi')
        $('#code').css("border-color", "red")
        $('#teksname').html('*Kolom Nama Harus Diisi')
        $('#name').css("border-color", "red")
        $('#tekseselon').html('*Kolom Eselon Harus Diisi')
        $('#eselon_code').css("border-color", "red")
        $('#teksatker').html('*Kolom Satker Harus Diisi')
        $('#satker_code').css("border-color", "red")
        $('#tekschars').html('*Kolom Char Harus Diisi')
        $('#chars').css("border-color", "red")
        $('#teksip').html('*Kolom IP Harus Diisi')
        $('#ip').css("border-color", "red")
        $('#teksport').html('*Kolom Port Harus Diisi')
        $('#port').css("border-color", "red")
        $('#timeout').css("border-color", "red")

    } else {
        // Jika tidak semua kolom kosong, hapus pesan kesalahan dan warna merah
        $('#tekskode').html('');
        $('#pnbp').css("border-color", "");

        $('#teksid').html('');
        $('#code').css("border-color", "");

        $('#teksname').html('');
        $('#name').css("border-color", "");

        $('#tekseselon').html('');
        $('#eselon_code').css("border-color", "");

        $('#teksatker').html('');
        $('#satker_code').css("border-color", "");

        $('#tekschars').html('');
        $('#chars').css("border-color", "");

        $('#teksip').html('');
        $('#ip').css("border-color", "");

        $('#teksport').html('');
        $('#port').css("border-color", "");

        $('#timeout').css("border-color", "");


        if (kode === "" && kode.length > 5) {
            $('#tekskode').html('*Kolom PNBP dan 4 Digit Harus Diisi');
            $('#pnbp').css("border-color", "red");
        } else {
            $('#tekskode').html('');
            $('#pnbp').css("border-color", "");
        }

        if (id === "" && kode.length > 4) {
            $('#teksid').html('*Kolom Kode K/L dan 3 Digit Harus Diisi');
            $('#code').css("border-color", "red");
        } else {
            $('#teksid').html('');
            $('#code').css("border-color", "");
        }

        if (name === "") {
            $('#teksname').html('*Kolom Nama Harus Diisi');
            $('#name').css("border-color", "red");
        } else {
            $('#teksname').html('');
            $('#name').css("border-color", "");
        }

        if (eselon_code === "") {
            $('#tekseselon').html('*Kolom Eselon Harus Diisi');
            $('#eselon_code').css("border-color", "red");
        } else {
            $('#tekseselon').html('');
            $('#eselon_code').css("border-color", "");
        }

        if (satker_code === "") {
            $('#teksatker').html('*Kolom Satker Harus Diisi');
            $('#satker_code').css("border-color", "red");
        } else {
            $('#teksatker').html('');
            $('#satker_code').css("border-color", "");
        }

        if (chars === "") {
            $('#tekschars').html('*Kolom Char Harus Diisi');
            $('#chars').css("border-color", "red");
        } else {
            $('#tekschars').html('');
            $('#chars').css("border-color", "");
        }


        if (ip === "") {
            $('#teksip').html('*Kolom IP Harus Diisi');
            $('#ip').css("border-color", "red");
        } else {

            $('#teksip').html('');
            $('#ip').css("border-color", "");
        }
        if (port === "") {
            $('#teksport').html('*Kolom Port Harus Diisi');
            $('#port').css("border-color", "red");
        } else {
            $('#teksport').html('');
            $('#port').css("border-color", "");
        }

        if (timeout === "") {
            $('#timeout').css("border-color", "red");
        } else {
            $('#timeout').css("border-color", "");
        }

        var json = {
            "_token": token,
            "MPN_TRX_PNBP": kode,
            "KL_CODE": id,
            "TRX_NAME": name,
            "TRX_ESELON_CODE": eselon_code,
            "TRX_SATKER_CODE": satker_code,
            "TRX_MSG_TYPE": type,
            "status": status,
            "FIRST_CHARS": chars,
            "TRX_IP": ip,
            "TRX_PORT": port,
            "TRX_TIMEOUT": timeout,
            "kolom": selectedColumns
        };


        $.ajax({
            url: '/setting/settingkementrian/AddKementrianSetting',
            type: 'post',
            data: json,
            dataType: 'json',

            success: function(result) {
                $('#mymodal').modal('hide');
                showSuccessMessage("Data Berhasil Di Tambah");
                getItems();
            },
            error: function(xhr) {

                $('#mymodal').modal('hide');
                showErrorMessage("Terjadi Kesalahan: " + xhr.responseText);
                getItems();
            }
        })
    }
}



function getItems() {

    var token = getCSRFToken();
    var requestData = {
        "_token": token
    };

    $.ajax({
        url: '/setting/settingkementrian/getdata',
        type: 'get',
        data: requestData,
        dataType: 'json',
        success: function(data) {

            tableHtml = '';
            for (var i = 0; i < data[0].length - 1; i++) {
                var setting = data[0][i];
                const mtype = (setting.MPN_TRX_MSG_TYPE === '2200') ? 'WSDL' : 'ISO 8583:1987';
                const status = (setting.MPN_TRX_STATUS === '1') ? 'Aktif' : 'Tidak Aktif';

                tableHtml += '<tr>';
                tableHtml += '<td>' + setting.MPN_TRX_PNBP + '</td>';
                tableHtml += '<td>' + setting.MPN_TRX_KL_CODE + '</td>';
                tableHtml += '<td>' + setting.MPN_TRX_NAME + '</td>';
                tableHtml += '<td>' + setting.MPN_TRX_ESELON_CODE + '</td>';
                tableHtml += '<td>' + setting.MPN_TRX_SATKER_CODE + '</td>';
                tableHtml += '<td>' + mtype + '</td>';
                tableHtml += '<td>' + status + '</td>';
                tableHtml += '<td>';
                tableHtml +=
                    '<button class="btn btn-xs btn-danger" value="' + setting.MPN_TRX_PNBP +
                    '" onclick="delete_(\'' +
                    setting.MPN_TRX_PNBP +
                    '\')">Hapus <span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                tableHtml += '<span class="ml-2"></span>';
                tableHtml +=
                    '<button class="btn btn-xs btn-info" value="' + (setting.MPN_TRX_PNBP || setting
                        .KL_code) +
                    '" onclick="printOption(\'' +
                    (setting.MPN_TRX_PNBP || setting.KL_code) +
                    '\')">Edit <span class="btn-label"><i class="fa fa-pencil"></i></span></button>';

                tableHtml += '</td>';
                tableHtml += '</tr>';
            };
            $('#kementrian-setting').html(tableHtml);
        }
    });
}

// Function to simulate the printOption function
function printOption(urlKey) {
    $.ajax({
        url: '/setting/settingkementrian/getby/' + urlKey,
        type: 'get',
        dataType: 'json',
        success: function(response) {

            var form = '<table class="table table-borderless">';
            form += '<tr>';
            form += '<td> PNBP</td>';
            form += '<td><span  value="' +
                response[0][0].MPN_TRX_NAME +
                '" >' + response[0][0].MPN_TRX_PNBP +
                '</span></td>';
            form += '</tr>';

            form += '<tr>';
            form +=
                '<td>Kode K/L<td><input class="form-control" type="text" id="code" name="KL_CODE" value="' +
                (response[0][0].MPN_TRX_KL_CODE !== null ? response[0][0].MPN_TRX_KL_CODE : '') +
                '"><label id="teksid" style="color:red;  margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td> Nama</td><td><input class="form-control" type="text" id="name" name="TRX_NAME" value="' +
                (response[0][0].MPN_TRX_NAME !== "null" ? response[0][0].MPN_TRX_NAME : '') +
                '"><label id="teksname" style="color:red;  margin: 0; padding: 0;"></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td> Kode Eselon</td><td><input class="form-control" type="text" id="eselon_code" name="TRX_ESELON_CODE" value="' +
                (response[0][0].MPN_TRX_ESELON_CODE !== "null" ? response[0][0].MPN_TRX_ESELON_CODE : '') +
                '"><label id="tekseselon" style="color:red;  margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td> Kode Satker</td><td><input class="form-control" type="text" id="satker_code" name="TRX_SATKER_CODE" value="' +
                  (response[0][0].MPN_TRX_SATKER_CODE !== "null" ? response[0][0].MPN_TRX_SATKER_CODE : '') +
                '"><label id="teksatker" style="color:red;  margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td> Message Type</td><td><select class="form-select" id="type" name="TRX_MSG_TYPE" >';
            form += '<option value="2200" ' + (response[0][0].MPN_TRX_MSG_TYPE === '2200' ? 'selected' :
                    '') +
                '>WSDL</option>';
            form += '<option value="0200" ' + (response[0][0].MPN_TRX_MSG_TYPE === '0200' ? 'selected' :
                    '') +
                '>ISO 8583:1987</option>';
            form += '</select></td>';
            form += '<tr>';
            form += '<td> Status</td><td><select class="form-select" id="status" name="status">';
            form += '<option value="1" ' + (response[0][0].MPN_TRX_STATUS === '1' ? 'selected' : '') +
                '>Aktif</option>';
            form += '<option value="0" ' + (response[0][0].MPN_TRX_STATUS === '0' ? 'selected' : '') +
                '>Tidak Aktif</option>';
            form += '</select></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td>First Char </td><td><input class="form-control" type="text" id="chars" name="FIRST_CHARS" value="' +
                 (response[0][0].MPN_TRX_BILL_ID_FIRST_CHARS  !== "null" ? response[0][0].MPN_TRX_BILL_ID_FIRST_CHARS  : '') +
                '"><label id="tekschars" style="color:red;  margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td>IP </td><td><input class="form-control" type="text" id="ip" name="TRX_IP" value="' +
				(response[0][0].MPN_TRX_IP !== "null" ? response[0][0].MPN_TRX_IP : '') +
				'"><label id="teksip" style="color:red; margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td>Port </td><td><input class="form-control" type="text" id="port" name="TRX_PORT" value="' +
                (response[0][0].MPN_TRX_PORT  !== "null" ? response[0][0].MPN_TRX_PORT  : '') +
                '"><label id="teksport" style="color:red;  margin: 0; padding: 0;"></label></td>';
            form += '</tr>';
            form += '<tr>';
            form +=
                '<td>Timeout </td><td><input class="form-control" type="text" id="timeout" name="TRX_TIMEOUT" value="' +
              (response[0][0].MPN_TRX_TIMEOUT !== "null" ? response[0][0].MPN_TRX_TIMEOUT : '') +
                '"><label id="tekstimeout" style="color:red;  margin: 0; padding: 0;"></label> millisecond</td>';
            form += '</tr>';
            form += '<td>Kolom </td><td>';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_BILL_CODE1"> Kode Billing ';
            form +=
                '<input type="checkbox" name="kolom[]" value="NAHUM_TM_BILLER_NAME"> Nama Wajib Bayar ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_KL_CODE"> Kode K/L ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_ESELON_CODE"> Kode Eselon ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_SATKER_CODE"> Kode Satker ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_PAYMENT"> Nominal ';
            form += '<br>';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_NTPN"> Nomor NPTN ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_CURRENCY"> Kode Mata Uang ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_TRAN_DT"> Tanggal Bayar ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_TRAN_DT|jam"> Jam Bayar ';
            form += '<input type="checkbox" name="kolom[]" value="NAHUM_TM_COMPANY_CODE"> Kode Bank ';
            form += '</td>';

            form += '<tr>';
            form += '<td colspan="2" class="text-right">';
            form += '<span class="ml-2"></span>';
            form += '<button onclick="saveid(this.value)" class="btn btn-primary" value="' +
                response[0][0].MPN_TRX_PNBP + '">Simpan</button>';
            form += '</td>';
            form += '</tr>';
            form += '</table>';

            $('#mymodal .modal-dialog').addClass('modal-lg');
            $('#mymodal').modal('show');
            $('.modal-title').html('Edit Setting');
            $('.modal-body').html(form);
        },
    });

}

function saveid(id) {
    var token = getCSRFToken();
    var kl = $('#code').val();
    var name = $('#name').val();
    var eselon_code = $('#eselon_code').val();
    var satker_code = $('#satker_code').val();
    var type = $('#type').val();
    var status = $('#status').val();
    var chars = $('#chars').val();
    var ip = $('#ip').val();
    var port = $('#port').val();
    var timeout = $('#timeout').val();

    var selectedColumns = $("input[name='kolom[]']:checked").map(function() {
        return $(this).val();
    }).get();

    function showError(field, message) {
        $(field).html(message);
        $(field).css("border-color", "red");
    }

    function clearError(field) {
        $(field).html('');
        $(field).css("border-color", "");
    }

    if (kl === "" || kl.length !== 3) {
        showError('#teksid', '*Kolom Kode K/L harus diisi dan harus memiliki 3 digit');
    } else {
        clearError('#teksid');
    }

    // Validasi kolom-kolom lainnya
    if (name === "") {
        showError('#teksname', '*Kolom Nama harus diisi');
    } else {
        clearError('#teksname');
    }

    if (eselon_code === "" || eselon_code.length !== 2) {
        showError('#tekseselon', '*Kolom Eselon harus diisi dan harus memiliki 2 digit');
    } else {
        clearError('#tekseselon');
    }

    if (satker_code === "" || satker_code.length !== 6) {
        showError('#teksatker', '*Kolom Satker harus diisi dan harus memiliki 6 digit');
    } else {
        clearError('#teksatker');
    }

    if (chars === "" || chars.length !== 3) {
        showError('#tekschars', '*Kolom Char harus diisi dan harus memiliki 3 digit');
    } else {
        clearError('#tekschars');
    }

    if (ip === "") {
        showError('#teksip', '*Kolom IP harus diisi');
    } else {
        clearError('#teksip');
    }

    if (port === "") {
        showError('#teksport', '*Kolom Port harus diisi');
    } else {
        clearError('#teksport');
    }

    if (timeout === "" || timeout.length !== 5) {
    showError('#tekstimeout', '*Kolom Timeout harus diisi dan harus memiliki 5 digit');
	} else if (isNaN(timeout) || parseInt(timeout) <= 0) {
		showError('#tekstimeout', '*Kolom Timeout harus diisi dengan angka positif');
	} else {
		clearError('#tekstimeout');
	}
	
    if ($('#tekskode').text() === '' &&
    $('#teksid').text() === '' &&
    $('#teksname').text() === '' &&
    $('#tekseselon').text() === '' &&
    $('#teksatker').text() === '' &&
    $('#tekschars').text() === '' &&
    $('#teksip').text() === '' &&
    $('#teksport').text() === '' &&
    $('#tekstimeout').text() === '' &&
    $('#kolomError').text() === '')  {
        var json = {
            "_token": token,
            "KL_CODE": kl,
            "TRX_NAME": name,
            "TRX_ESELON_CODE": eselon_code,
            "TRX_SATKER_CODE": satker_code,
            "TRX_MSG_TYPE": type,
            "status": status,
            "FIRST_CHARS": chars,
            "TRX_IP": ip,
            "TRX_PORT": port,
            "TRX_TIMEOUT": timeout,
            "kolom": selectedColumns
        };

        console.log(id);

        $.ajax({
            url: '/setting/settingkementrian/getbysave/' + id,
            type: 'put',
            data: json,
            dataType: 'json',
            success: function(result) {
                $('#mymodal').modal('hide');
                Swal.fire(
                    'Sukses Diubah!',
                    'Klik button!',
                    'success'
                )
                getItems();
            },
            error: function(xhr) {

                $('#mymodal').modal('hide');
                showErrorMessage("Terjadi Kesalahan: " + xhr.responseText);
                getItems();
            }
        });
    }
}


function delete_(id) {
    var token = getCSRFToken();
    var conf = window.confirm('Yakin mau menghapus ini?');
    var json = {
        "_token": token,
        "pnbp": id,
    };

    if (conf) {
        $.ajax({
            url: '/setting/settingkementrian/deleteby/' + id,
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
                getItems();
            },
            error: function(xhr) {

                $('#mymodal').modal('hide');
                showErrorMessage("Terjadi Kesalahan: " + xhr.responseText);
                getItems();
            }
        });
    }
}

function getCSRFToken() {
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        return tokenMeta.getAttribute('content');
    }
    return null;
}


// Menampilkan pesan sukses
function showSuccessMessage(message) {
    var successMessageElement = document.getElementById('success-message');
    successMessageElement.innerHTML = message;
    successMessageElement.style.display = 'block';

    setTimeout(function() {
        successMessageElement.style.display = 'none';
    }, 2000);
}


//