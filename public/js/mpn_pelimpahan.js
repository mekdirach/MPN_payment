$(document).ready(function() {

    // Fungsi untuk mengirim permintaan AJAX
    function getItems() {
        var token = getCSRFToken();
        var mataUang = $('#mata-uang').val();
        var requestData = {
            "mata_uang": mataUang,
            "_token": token
        };
        console.log(requestData);
        $.ajax({
            url: '/limpahkan/pelimpahan/limpahkan',
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function(responseData) {
               
                var html = '';
                if(responseData.message){
                    
                    html += '<tr>';
                    html += '<td><strong><span class="badge badge-success" >' + responseData.message + '</span></strong></td>';
                    html += '</tr>';
                }
                else if (responseData.Status) {
                    
                    html += '<tr>';
                    html += '<td>' + "Status" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td><span class="badge badge-success" >' + responseData.Status +
                        '</span></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Tanggal Pelimpahan" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Tanggal_Pelimpahan +
                        '</span></strong></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Mata Uang" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Tanggal_Pelimpahan +
                        '</span></strong></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Mata Uang" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Mata_Uang +
                        '</span></strong></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Batch Id" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Batch_ID +
                        '</span></strong></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Total Transaksi" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Total_Transaksi +
                        '</span></strong></td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td>' + "Jumlah Transaksi" + '</td>';
                    html += '<td>' + ":" + '</td>';
                    html += '<td> <strong><span >' + responseData
                        .Jumlah_Transaksi +
                        '</span></strong></td>';
                    html += '</tr>';
                } else {
                    var html = '<div class="badge badge-danger">' + responseData.error +
                        '</div>';
                    $(html).insertBefore(
                        "#itemDetails");
                    $("#itemDetails").remove();
                }
                $("#itemDetails").html(html);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tidak Ada Respone Dari Sistem!',
                    //footer: '<a href="">Why do I have this issue?</a>'
                  })
               
            }

        });
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