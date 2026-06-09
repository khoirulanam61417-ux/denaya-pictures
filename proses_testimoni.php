<?php
include 'koneksi.php';

if (isset($_POST['kirim_testimoni'])) {
    // Ambil data dan bersihkan dari karakter berbahaya
    $nama = mysqli_real_escape_string($conn, $_POST['nama_klien']);
    $kerja = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $rating = (int)$_POST['rating'];
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "INSERT INTO testimonials (nama_klien, pekerjaan, rating, pesan) 
              VALUES ('$nama', '$kerja', '$rating', '$pesan')";

    if ($conn->query($query)) {
        // Alihkan kembali ke index dengan notifikasi sukses
        echo "<script>
                alert('Terima kasih! Testimoni Anda sangat berarti bagi kami.');
                window.location.href='index.php#testimonials';
              </script>";
    } else {
        echo "Gagal mengirim testimoni.";
    }
}
?>