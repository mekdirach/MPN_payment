document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah ada data yang tersimpan di local storage
    if (localStorage.getItem('rememberMe') === 'true') {
        // Jika ada, setel nilai checkbox "Remember Me" menjadi dicentang
        document.getElementById('remember').checked = true;

        // Jika ada, isi juga kolom email dan password dari local storage
        document.getElementById('email').value = localStorage.getItem('email') || '';
        document.getElementById('password').value = localStorage.getItem('password') || '';
    }

    // Tangani perubahan pada checkbox "Remember Me"
    document.getElementById('remember').addEventListener('change', function() {
        // Jika dicentang, simpan data di local storage
        if (this.checked) {
            localStorage.setItem('rememberMe', 'true');
            localStorage.setItem('email', document.getElementById('email').value);
            localStorage.setItem('password', document.getElementById('password').value);
        } else {
            // Jika tidak dicentang, hapus data dari local storage
            localStorage.removeItem('rememberMe');
            localStorage.removeItem('email');
            localStorage.removeItem('password');
        }
    });
});