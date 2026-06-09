<?php
session_start();
include 'koneksi.php';

// 1. Proteksi halaman: Cek apakah sudah login
// Gunakan pengecekan yang ketat (=== true)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// --- LOGIKA 1: UPDATE ABOUT ---
if (isset($_POST['update_about'])) {
    $konten = mysqli_real_escape_string($conn, $_POST['konten_about']);
    
    // Pastikan ID 1 ada di database
    $query = "UPDATE about_section SET konten = '$konten' WHERE id = 1";
    if ($conn->query($query)) {
        header("Location: admin.php?status=success");
        exit;
    } else {
        header("Location: admin.php?status=error");
        exit;
    }
}

// --- LOGIKA 2: UPDATE PRICELIST ---
if (isset($_POST['update_services'])) {
    $h_wedding = (int)$_POST['harga_wedding']; // Paksa jadi angka (integer)
    $h_prewed  = (int)$_POST['harga_prewed'];
    $h_grad    = (int)$_POST['harga_grad'];

    // Update satu per satu
    $conn->query("UPDATE services SET harga = '$h_wedding' WHERE id = 1");
    $conn->query("UPDATE services SET harga = '$h_prewed' WHERE id = 2");
    $conn->query("UPDATE services SET harga = '$h_grad' WHERE id = 3");

    header("Location: admin.php?status=success");
    exit;
}

// --- LOGIKA 3: UPLOAD GALLERY ---
if (isset($_POST['upload_gallery'])) {
    $alt_text = mysqli_real_escape_string($conn, $_POST['alt_text']);
    
    $nama_file = $_FILES['foto_galeri']['name'];
    $ukuran_file = $_FILES['foto_galeri']['size'];
    $tmp_file = $_FILES['foto_galeri']['tmp_name'];
    $error_file = $_FILES['foto_galeri']['error'];
    
    // Cek apakah ada file yang diupload
    if ($error_file === 4) {
        header("Location: admin.php?status=error");
        exit;
    }

    // Buat folder 'uploads' secara otomatis jika belum ada
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Berikan nama unik agar tidak bentrok
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'webp');
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));
    $nama_baru = "denaya_" . time() . "." . $ekstensi;
    $target_dir = "uploads/" . $nama_baru;

    // Validasi: Ekstensi & Ukuran (Maks 2MB)
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran_file <= 2000000) { 
            if (move_uploaded_file($tmp_file, $target_dir)) {
                $conn->query("INSERT INTO gallery (file_gambar, alt_text) VALUES ('$nama_baru', '$alt_text')");
                header("Location: admin.php?status=success"); // Menggunakan status=success agar alert muncul
                exit;
            } else {
                // Jika gagal pindah folder, mungkin masalah izin (permission)
                die("Gagal memindahkan file ke folder uploads. Pastikan folder uploads ada.");
            }
        } else {
            die("File terlalu besar (Maks 2MB).");
        }
    } else {
        die("Ekstensi file tidak didukung (Gunakan JPG/PNG/WebP).");
    }
}
// --- LOGIKA 4: HAPUS FOTO GALERI ---
if (isset($_GET['hapus_foto'])) {
    $id = (int)$_GET['hapus_foto'];

    // Ambil nama file dari database dulu
    $query_cek = $conn->query("SELECT file_gambar FROM gallery WHERE id = $id");
    if ($query_cek->num_rows > 0) {
        $data = $query_cek->fetch_assoc();
        $file_lama = "uploads/" . $data['file_gambar'];

        // Hapus file fisik jika ada
        if (file_exists($file_lama)) {
            unlink($file_lama);
        }

        // Hapus data dari database
        if ($conn->query("DELETE FROM gallery WHERE id = $id")) {
            header("Location: admin.php?status=success");
        } else {
            header("Location: admin.php?status=error");
        }
    }
    exit;
}
?>