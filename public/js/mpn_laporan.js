document.addEventListener("DOMContentLoaded", function() {
    getItems();
});


$(document).ready(function() {
    var responseDiv = document.getElementById("response");
    $('#uploadForm').submit(function(e) {
        e.preventDefault();
        uploadFile()

    });

    function uploadFile() {
        var token = getCSRFToken();
        var fileInput = document.getElementById('fileToUpload');
        var file = fileInput.files[0]; // Get the selected file
        if (!fileInput.value) {
            responseDiv.innerHTML = "File tidak boleh kosong!";
            return;
        }
        responseDiv.innerHTML = "";
        if (file) {
            var formData = new FormData(); // Create a new FormData object
            formData.append('fileToUpload', file);
            formData.append('_token', token);

            $.ajax({
                url: '/limpahkan/laporan/upload', // Ganti dengan URL yang sesuai di aplikasi Anda
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    var html = ''; // Inisialisasi variabel HTML
					console.log(response);
                    if (response.success) {
                        Swal.fire(
                            'Sukses!',
                            'Klik button!',
                            'success'
                        )
                        var rawDateTime = response.tanggal;
                        var formattedDateTime = rawDateTime.substr(6, 2) + '-' +
                            rawDateTime.substr(4, 2) + '-' +
                            rawDateTime.substr(0, 4) + ' ' +
                            rawDateTime.substr(8, 2) + ':' +
                            rawDateTime.substr(10, 2) + ':' +
                            rawDateTime.substr(12, 2);

                        // Tampilkan pesan berhasil
                        html += '<tr>';
                        html += '<td>' + formattedDateTime + '</td>';
                        html += '<td>';
						for (var i = 0; i < response.links.length; i++) {
							var fileName = response.links[i].name;
							var fileUrl = response.links[i].url;

    html += '<li><a href="#" class="file-detail-link" onclick="showFileDetail(\'' + fileName + '\', \'' + fileUrl + '\')">' + fileName + '</a></li>';
						}

                        html += '</ul>';
                        html += '</td>'
                        html += '</tr>';
                    } else {
                        html = '<br><div class="badge badge-danger">' + response.message +
                            '</div>';
                    }

                    $('#responseMessage').html(html);
                },
                error: function(xhr, status, error) {
                    console.log(status);
                    console.log(xhr.responseText);
                    $('#responseMessage').html('<br><p class="error">Error: ' + error + '</p>');
                }

            });
        }
    }
	
});


function showFileDetail(fileName, fileUrl) {
	console.log(fileUrl);
    var detailUrl = '/limpahkan/laporan/detail/' + encodeURIComponent(fileUrl);

    console.log(detailUrl);

    $.ajax({
        url: detailUrl,
        type: 'get',
        success: function(response) {
            console.log(response);
            $('#fileresponse').html(response); 
        },
        error: function() {
            alert('Gagal memuat konten file.');
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

function getItems() {
    var token = getCSRFToken();

    var data = {
        "_token": token
    };

    $.ajax({
        url: '/limpahkan/laporan/list', // Ganti dengan URL yang sesuai di aplikasi Anda
        type: 'get',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
		
// Sort the response array based on the date in descending order
response.sort(function(a, b) {
    var dateA = a.Tanggal.split('-').reverse().join('');
    var dateB = b.Tanggal.split('-').reverse().join('');
    return dateB.localeCompare(dateA);
});



var html = ''; // Initialize HTML variable

// Loop through the sorted response array and display files for each date
for (var i = 0; i < response.length; i++) {
    var date = response[i].Tanggal;
    var files = response[i].FILE;

    html += '<tr>';
    html += '<td>' + date + '</td>';
    html += '<td>';

    // Loop through files of the current date
    for (var j = 0; j < files.length; j++) {
        var fileName = files[j].name;
        var fileUrl = files[j].url;

        html += '<li><a href="' + fileUrl + '" target="_blank">' + fileName + '</a></li>';
    }

    html += '</td>';
    html += '</tr>';
}

$('#responseMessage').html(html);

        },
        error: function (xhr, status, error) {
            console.log(status);
            console.log(xhr.responseText);
            // Tampilkan pesan kesalahan umum jika terjadi kesalahan dalam AJAX
            $('#responseMessage').html('<br><p class="error">Error: ' + error + '</p>');
        }
    });
}
