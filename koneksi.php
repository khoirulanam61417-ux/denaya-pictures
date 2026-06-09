<?php
/**
 * File: koneksi.php
 * Deskripsi: Menghubungkan aplikasi web Denaya Pictures ke database MySQL
 */

// 1. Konfigurasi Database
$host = "localhost";    // Nama host server (biasanya localhost untuk XAMPP)
$user = "root";         // Username default MySQL di XAMPP
$pass = "";             // Password default MySQL di XAMPP (biasanya kosong)
$db   = "denaya_db";    // Nama database yang Anda buat di phpMyAdmin

// 2. Mengaktifkan pelaporan error mysqli
// Ini akan mengubah error MySQL menjadi 'Exception' agar mudah ditangkap oleh blok try-catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 3. Membuat koneksi ke database
    $conn = new mysqli($host, $user, $pass, $db);

    // 4. Mengatur karakter set ke utf8mb4
    // Sangat penting agar simbol atau karakter khusus tersimpan dengan benar di database
    $conn->set_charset("utf8mb4");

    // Jika sampai baris ini, berarti koneksi berhasil (Opsional: bisa dikosongkan)
    // echo "Koneksi Berhasil!"; 

} catch (mysqli_sql_exception $e) {
    // 5. Menangani kesalahan koneksi
    // Jika gagal, tampilkan pesan error dan hentikan script
    die("Gagal terhubung ke database: " . $e->getMessage());
}
?>