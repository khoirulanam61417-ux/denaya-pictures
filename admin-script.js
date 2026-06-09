// ==========================================
// 1. Logika Navigasi Tab Menu (Sidebar)
// ==========================================
function showTab(tabId) {
    // Mencegah browser melompat ke atas saat link '#' diklik
    if (event) {
        event.preventDefault();
    }

    // Sembunyikan semua konten tab terlebih dahulu
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active-tab'));

    // Hapus warna background 'active' dari semua menu di sidebar
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    menuItems.forEach(item => item.classList.remove('active'));

    // Tampilkan bagian tab yang ID-nya dipanggil
    document.getElementById(tabId).classList.add('active-tab');

    // Berikan warna background 'active' pada menu yang sedang diklik
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}


// ==========================================
// 2. Validasi Ukuran Foto (Frontend)
// ==========================================
// Fungsi ini mencegah pengguna mengupload file > 500KB sebelum diproses oleh PHP
const galleryForm = document.querySelector('form[action="proses_admin.php"][enctype="multipart/form-data"]');

if (galleryForm) {
    galleryForm.addEventListener('submit', function(e) {
        const fileInput = document.querySelector('input[name="foto_galeri"]');
        
        if (fileInput && fileInput.files.length > 0) {
            const fileSize = fileInput.files[0].size; // Ukuran file dalam byte
           // Ganti 500 menjadi 2048 (2MB) agar sinkron dengan standar server
            const maxSize = 2048 * 1024;
            if (fileSize > maxSize) {
                // Cegah form dikirim ke proses_admin.php
                e.preventDefault(); 
                alert('Gagal! Ukuran gambar terlalu besar. Maksimal ukuran file adalah 2MB.');
            }
        }
    });
}
// Fungsi Konfirmasi Hapus Foto
function konfirmasiHapus(id) {
    if (confirm("Apakah Anda yakin ingin menghapus foto ini secara permanen dari website?")) {
        window.location.href = "proses_admin.php?hapus_foto=" + id;
    }
}