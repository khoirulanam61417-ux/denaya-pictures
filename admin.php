<?php
session_start();

// 1. Proteksi Halaman
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// 2. Ambil data About
$konten_about = "";
$query_about = $conn->query("SELECT konten FROM about_section WHERE id = 1");
if ($query_about && $query_about->num_rows > 0) {
    $data_about = $query_about->fetch_assoc();
    $konten_about = $data_about['konten'];
}

// 3. Ambil data Harga (Perbaikan logika fetching agar tidak eror)
$harga_wedding = 0; $harga_prewed = 0; $harga_grad = 0;
$query_services = $conn->query("SELECT * FROM services");
if ($query_services) {
    while ($row_data = $query_services->fetch_assoc()) {
        if ($row_data['id'] == 1) $harga_wedding = $row_data['harga'];
        if ($row_data['id'] == 2) $harga_prewed = $row_data['harga'];
        if ($row_data['id'] == 3) $harga_grad = $row_data['harga'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Dashboard | Denaya Pictures</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="grain-overlay"></div>

    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2 class="logo-text">DENAYA</h2>
                <p class="subtitle">Studio Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active" onclick="showTab('tab-about', event)"><i class="fas fa-pen-nib"></i> About Section</a></li>
                <li><a href="#" onclick="showTab('tab-services', event)"><i class="fas fa-tags"></i> Pricelist</a></li>
                <li><a href="#" onclick="showTab('tab-gallery', event)"><i class="fas fa-images"></i> Gallery</a></li>
                <li class="menu-divider"></li>
                <li><a href="index.php" target="_blank" class="view-site"><i class="fas fa-external-link-alt"></i> View Live Site</a></li>
                <li><a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
            </ul>
        </aside>

        <main class="main-content">
            
            <?php if (isset($_GET['status'])): ?>
                <div id="alert-notif" class="alert <?php echo ($_GET['status'] == 'success' || $_GET['status'] == 'upload_success') ? 'alert-success' : 'alert-error'; ?>" style="margin-bottom: 20px; padding: 15px; border-radius: 5px;">
                    <i class="fas <?php echo ($_GET['status'] == 'success' || $_GET['status'] == 'upload_success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php 
                        if($_GET['status'] == 'success') echo " Perubahan berhasil disimpan!";
                        elseif($_GET['status'] == 'upload_success') echo " Foto berhasil diterbitkan!";
                        else echo " Terjadi kesalahan sistem.";
                    ?>
                </div>
            <?php endif; ?>

            <div id="tab-about" class="tab-content active-tab">
                <div class="section-header">
                    <span class="section-subtitle">Profile Content</span>
                    <h2>Edit About Section</h2>
                </div>
                <div class="card">
                    <form action="proses_admin.php" method="POST">
                        <div class="form-group">
                            <label>Teks Filosofi Studio</label>
                            <textarea name="konten_about" rows="8" placeholder="Tuliskan filosofi studio..." required><?php echo htmlspecialchars($konten_about); ?></textarea>
                        </div>
                        <button type="submit" name="update_about" class="btn-primary">Update Content</button>
                    </form>
                </div>
            </div>

            <div id="tab-services" class="tab-content">
                <div class="section-header">
                    <span class="section-subtitle">Packages</span>
                    <h2>Edit Pricelist</h2>
                </div>
                <div class="card">
                    <form action="proses_admin.php" method="POST">
                        <div class="form-group">
                            <label><i class="fas fa-ring"></i> Wedding Photography (Rp)</label>
                            <input type="number" name="harga_wedding" value="<?php echo $harga_wedding; ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-heart"></i> Pre-Wedding Session (Rp)</label>
                            <input type="number" name="harga_prewed" value="<?php echo $harga_prewed; ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-graduate"></i> Graduation / Portrait (Rp)</label>
                            <input type="number" name="harga_grad" value="<?php echo $harga_grad; ?>" required>
                        </div>
                        <button type="submit" name="update_services" class="btn-primary">Save Pricing</button>
                    </form>
                </div>
            </div>

         <div id="tab-gallery" class="tab-content">
    <div class="section-header">
        <span class="section-subtitle">Portfolio</span>
        <h2>Manage Gallery</h2>
    </div>

    <div class="card" style="margin-bottom: 30px;">
        <div class="info-note">
            <i class="fas fa-info-circle"></i> Tambahkan karya terbaru ke dalam galeri utama.
        </div>
        <form action="proses_admin.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Pilih File Foto</label>
                <input type="file" name="foto_galeri" accept="image/*" class="file-input" required>
            </div>
            <div class="form-group">
                <label>Kategori / Judul Alt</label>
                <input type="text" name="alt_text" placeholder="Contoh: Intimate Wedding at Beach" required>
            </div>
            <button type="submit" name="upload_gallery" class="btn-primary">Publish to Website</button>
        </form>
    </div>

    <div class="section-header" style="margin-top: 50px;">
        <span class="section-subtitle">Aset Terbit</span>
        <h2>Daftar Foto Galeri</h2>
    </div>
    <div class="card">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-family: 'Montserrat', sans-serif;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; text-align: left;">
                        <th style="padding: 15px;">Preview</th>
                        <th style="padding: 15px;">Keterangan</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_gallery = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
                    if ($query_gallery->num_rows > 0) {
                        while($row = $query_gallery->fetch_assoc()) {
                            echo "<tr style='border-bottom: 1px solid #f0f0f0;'>
                                    <td style='padding: 15px;'>
                                        <img src='uploads/".$row['file_gambar']."' style='width: 80px; height: 60px; object-fit: cover; border-radius: 4px;'>
                                    </td>
                                    <td style='padding: 15px; font-size: 0.9rem;'>".$row['alt_text']."</td>
                                    <td style='padding: 15px; text-align: center;'>
                                        <a href='javascript:void(0);' onclick='konfirmasiHapus(".$row['id'].")' 
                                           style='color: #a84b4b; text-decoration: none; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;'>
                                           <i class='fas fa-trash-alt'></i> Hapus
                                        </a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='padding: 20px; text-align: center; color: #999;'>Belum ada foto di galeri.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <script src="admin-script.js"></script>

    <script>
        // Logika Auto-Hide Notifikasi
        window.addEventListener('DOMContentLoaded', (event) => {
            const notification = document.getElementById('alert-notif');
            if (notification) {
                // Notifikasi terlihat selama 3 detik
                setTimeout(() => {
                    notification.style.transition = "opacity 0.8s ease";
                    notification.style.opacity = "0";
                    
                    // Hapus elemen setelah animasi pudar
                    setTimeout(() => {
                        notification.remove();
                        // Bersihkan parameter status di URL agar tidak muncul lagi saat F5
                        const url = new URL(window.location);
                        url.searchParams.delete('status');
                        window.history.replaceState({}, document.title, url);
                    }, 800);
                }, 3000);
            }
        });
    </script>
</body>
</html>