// Profile Image Preview
function previewProfileImage() {
    const input = document.getElementById('foto_profil');
    const preview = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Form Validation
function validateProfileForm() {
    const nama = document.querySelector('input[name="nama"]').value;
    const telepon = document.querySelector('input[name="telepon"]').value;
    
    if (nama.trim() === '') {
        alert('Nama harus diisi');
        return false;
    }
    
    if (telepon.trim() === '') {
        alert('No. Telepon harus diisi');
        return false;
    }
    
    // Validasi format nomor telepon (opsional)
    const phoneRegex = /^[0-9]{10,15}$/;
    if (!phoneRegex.test(telepon.trim())) {
        alert('Format No. Telepon tidak valid');
        return false;
    }
    
    return true;
}

function validatePasswordForm() {
    const password = document.querySelector('input[name="password"]').value;
    const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
    
    if (password !== passwordConfirmation) {
        alert('Password baru dan konfirmasi password tidak cocok.');
        return false;
    }
    return true;
}

// Number formatting function
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
