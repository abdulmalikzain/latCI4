<?php
// Ganti ini dengan password yang kamu ketik di form login
$input = 'wonosobo12345';

// // Ganti ini dengan hash yang ada di database kamu (kolom password_hash)
$hash = '$2y$10$li4vbwOMeSPXgPoCpoEQneb23PpUL1q6vXs/TLT2pShPLOB7Xn8rK';

// Fungsi ini akan membandingkan apakah password dan hash cocok
if (password_verify($input, $hash)) {
    echo "✅ Password cocok!";
} else {
    echo "❌ Password SALAH!";
}

// Ganti "admin123" dengan password baru yang kamu mau
// echo password_hash('semarang123', PASSWORD_DEFAULT);

// var_dump(password_verify('admin123', '$2y$10$nuFrDFbqAQH4yIcmdjl./ufC8JKLxoFF6LGEB77NML79ykCBMs6vW'));
