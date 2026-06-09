<?php
// 1. Panggil koneksi database
include 'koneksi.php';

// 2. Ambil data About (ID 1)
// Berikan teks default jika database kosong atau gagal dimuat
$konten_about = "Kami percaya bahwa foto terbaik bukan sekadar pose, melainkan tawa yang jujur dan tatapan yang tulus. Dengan pendekatan warm minimalism, kami menjaga memori Anda tetap hidup selamanya."; 
$query_about = $conn->query("SELECT konten FROM about_section WHERE id = 1");
if ($query_about && $query_about->num_rows > 0) {
    $data_about = $query_about->fetch_assoc();
    $konten_about = $data_about['konten'];
}

// 3. Ambil data Harga Pricelist
$harga_wedding = 2000000;
$harga_prewed = 2000000;
$harga_grad = 350000;
$query_services = $conn->query("SELECT * FROM services");
if ($query_services) {
    while ($row = $query_services->fetch_assoc()) {
        if ($row['id'] == 1) $harga_wedding = $row['harga'];
        if ($row['id'] == 2) $harga_prewed = $row['harga'];
        if ($row['id'] == 3) $harga_grad = $row['harga'];
    }
    // 4. Ambil data Testimoni (Dummy)
$query_testi = $conn->query("SELECT * FROM testimonials ORDER BY id DESC LIMIT 3");
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denaya Pictures | Minimalist & Warm Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Tambahan styling sederhana untuk FAQ agar rapi */
        .faq-list details {
            margin-bottom: 1rem;
            padding: 1.2rem;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .faq-list details:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .faq-list summary {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            list-style: none; /* Hilangkan default arrow di beberapa browser */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-list summary::-webkit-details-marker {
            display: none;
        }
        .faq-list summary::after {
            content: '\f078'; /* FontAwesome chevron-down */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.9rem;
            color: #555;
            transition: transform 0.3s ease;
        }
        .faq-list details[open] summary::after {
            transform: rotate(180deg);
        }
        .faq-list p {
            margin-top: 15px;
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        /* Tambahan styling untuk tombol login di navbar agar sedikit berbeda */
        .nav-links .login-btn {
            background-color: #222;
            color: #fff !important;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        .nav-links .login-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="grain-overlay"></div>

    <nav id="navbar">
        <div class="nav-container">
            <h1 class="logo-denaya">DENAYA PICTURES</h1>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Pricelist</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Contact</a></li>
                <!-- Menu Login Dikembalikan -->
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="hero-content fade-up">
            <h2>Abadikan setiap detik <i>berharga.</i></h2>
            <p>Menangkap momen dengan estetika yang abadi dan sentuhan warna hangat yang bercerita. Spesialis dokumentasi pernikahan dan pre-wedding.</p>
            <div class="hero-buttons">
                <a href="#services" class="btn btn-primary">Lihat Pricelist</a>
                <a href="#contact" class="btn btn-ghost">Reservasi Tanggal</a>
            </div>
        </div>
        <div class="hero-image parallax-bg"></div>
    </section>

    <section id="about" class="philosophy container fade-up">
        <div class="section-header">
            <span class="subtitle">Behind The Lens</span>
            <h2>About Denaya</h2>
        </div>
        <p class="philosophy-text"><?php echo $konten_about; ?></p>
    </section>

    <section id="services" class="services container">
        <div class="grid-3">
            <div class="card fade-up stagger-item">
                <h3>Wedding Photography</h3>
                <p class="price">Rp <?php echo number_format($harga_wedding, 0, ',', '.'); ?></p>
                <ul>
                    <li>Full day coverage</li>
                    <li>Edited photos (All files)</li>
                    <li>Premium Flashdisk</li>
                    <li>Printed Wooden Frame</li>
                </ul>
                <a href="#contact" class="btn btn-ghost full-width">Pilih Paket</a>
            </div>
            <div class="card fade-up stagger-item">
                <h3>Pre-Wedding Session</h3>
                <p class="price">Rp <?php echo number_format($harga_prewed, 0, ',', '.'); ?></p>
                <ul>
                    <li>2 Locations</li>
                    <li>Makeup Artist (Included)</li>
                    <li>Cinematic Video Teaser</li>
                    <li>20 Edited Photos</li>
                </ul>
                <a href="#contact" class="btn btn-ghost full-width">Pilih Paket</a>
            </div>
            <div class="card fade-up stagger-item">
                <h3>Graduation / Portrait</h3>
                <p class="price">Rp <?php echo number_format($harga_grad, 0, ',', '.'); ?></p>
                <ul>
                    <li>Studio / Outdoor</li>
                    <li>Individual & Group shots</li>
                    <li>High-res files via Cloud</li>
                    <li>1 Day Editing</li>
                </ul>
                <a href="#contact" class="btn btn-ghost full-width">Pilih Paket</a>
            </div>
        </div>
    </section>

    <section id="gallery" class="gallery container">
    <h2 class="text-center fade-up">Featured Gallery</h2>
    <div class="masonry-grid">
        <?php
        $query_gallery = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
        
        if ($query_gallery && $query_gallery->num_rows > 0) {
            while ($img = $query_gallery->fetch_assoc()) {
                // Cek apakah file fisik ada di folder uploads
                $path_foto = 'uploads/' . $img['file_gambar'];
                
                // Jika file tidak ada di folder, kita gunakan gambar default agar tidak kosong
                if (!file_exists($path_foto) || empty($img['file_gambar'])) {
                    $path_foto = 'prewed.jpg'; // Pastikan file prewed.jpg ada di folder utama
                }

                echo '<div class="masonry-item fade-up stagger-item">';
                echo '<img src="' . $path_foto . '" alt="' . htmlspecialchars($img['alt_text']) . '">';
                echo '</div>';
            }
        } else {
            // Tampilan default jika database benar-benar kosong
            echo '<div class="masonry-item fade-up stagger-item"><img src="prewed.jpg" alt="Wedding"></div>';
            echo '<div class="masonry-item fade-up stagger-item"><img src="prewed.jpg" alt="Pre Wedding"></div>';
            echo '<div class="masonry-item fade-up stagger-item"><img src="prewed.jpg" alt="Detail"></div>';
        }
        ?>
    </div>
    </section>
             
    <section class="process container">
        <h2 class="text-center fade-up">How We Work</h2>
        <div class="grid-4">
            <div class="process-step fade-up stagger-item">
                <h4>01. Konsultasi</h4>
                <p>Diskusi konsep dan penyusunan moodboard.</p>
            </div>
            <div class="process-step fade-up stagger-item">
                <h4>02. Sesi Foto</h4>
                <p>Pengambilan gambar dengan suasana santai.</p>
            </div>
            <div class="process-step fade-up stagger-item">
                <h4>03. Editing</h4>
                <p>Proses retouching dengan warm tone khas Denaya.</p>
            </div>
            <div class="process-step fade-up stagger-item">
                <h4>04. Penyerahan</h4>
                <p>Pengiriman hasil melalui cloud dan cetakan fisik.</p>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ -->
    <section id="faq" class="faq container fade-up">
        <div class="section-header text-center">
            <span class="subtitle">Got Questions?</span>
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="faq-list" style="max-width: 800px; margin: 0 auto;">
            <details>
                <summary>Berapa lama proses editing foto?</summary>
                <p>Proses editing biasanya memakan waktu 1-2 minggu untuk sesi Pre-Wedding / Graduation, dan 3-4 minggu untuk full coverage Wedding.</p>
            </details>
            <details>
                <summary>Bagaimana sistem pembayarannya?</summary>
                <p>Untuk mengamankan slot tanggal, kami mewajibkan DP (Down Payment) sebesar 30%. Sisa pelunasan dapat dilakukan maksimal H-3 sebelum hari acara.</p>
            </details>
            <details>
                <summary>Apakah Denaya Pictures melayani foto di luar kota?</summary>
                <p>Tentu saja! Kami berbasis di Sidoarjo/Surabaya namun bersedia mengabadikan momen Anda di mana pun. Untuk luar kota, akan ada penyesuaian biaya tambahan untuk transportasi dan akomodasi kru.</p>
            </details>
            <details>
                <summary>Apakah ada biaya tambahan untuk lokasi foto / perizinan?</summary>
                <p>Biaya sewa lokasi atau tiket masuk perizinan tempat pre-wedding (jika ada) ditanggung oleh pihak klien. Kami dengan senang hati akan membantu merekomendasikan lokasi gratis maupun berbayar yang estetik dan sesuai konsep Anda.</p>
            </details>
            <details>
                <summary>Apakah file mentah (RAW) akan diberikan?</summary>
                <p>Kami hanya memberikan file berupa JPEG resolusi tinggi yang sudah melalui tahap penyortiran. File RAW tidak kami bagikan karena proses editing warna (color grading) adalah bagian dari identitas karya Denaya Pictures.</p>
            </details>
        </div>
    </section>

    <section id="testimonials" class="testimonials container">
        <h2 class="text-center fade-up">What Our Clients Say</h2>
        <div class="grid-3">
            <?php
            if ($query_testi && $query_testi->num_rows > 0) {
                while ($testi = $query_testi->fetch_assoc()) {
                    echo '<div class="card-testi fade-up stagger-item">';
                    echo '    <div class="rating">';
                    for($i=1; $i<=$testi['rating']; $i++) {
                        echo '<i class="fas fa-star" style="color: #d4af37;"></i>';
                    }
                    echo '    </div>';
                    echo '    <p class="testi-text">"' . htmlspecialchars($testi['pesan']) . '"</p>';
                    echo '    <div class="testi-user">';
                    echo '        <h4 class="testi-name">' . htmlspecialchars($testi['nama_klien']) . '</h4>';
                    echo '        <span class="testi-role">' . htmlspecialchars($testi['pekerjaan']) . '</span>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">Belum ada testimoni.</p>';
            }
            ?>
        </div>
    </section>

    <section id="contact" class="contact container fade-up">
        <div class="contact-box">
            <div class="contact-header text-center">
                <h2>Book Your Session</h2>
                <p>Ceritakan rencana Anda, mari kita buat sesuatu yang indah.</p>
                <div class="location-info">
                    <i class="fas fa-map-marker-alt"></i> 
                    <span><strong>Studio Denaya:</strong> Dusun Kp. Baru, Buncitan, Sedati, Sidoarjo Regency, East Java</span>
                </div>
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d247.28835289039964!2d112.78704595858979!3d-7.397114441049526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1775019834905!5m2!1sid!2sid"width="100%" height="250" style="border:0; border-radius: 15px; margin-top: 1.5rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            
            <form id="booking-form">
                <div class="form-group">
                    <input type="text" id="nama" placeholder="Nama Lengkap" required>
                    <input type="email" id="email" placeholder="Alamat Email" required>
                </div>
                <div class="form-group">
                    <input type="date" id="tanggal" required>
                    <select id="layanan" required>
                        <option value="">Pilih Layanan</option>
                        <option value="Wedding Photography">Wedding</option>
                        <option value="Pre-Wedding Session">Pre-Wedding</option>
                        <option value="Graduation / Portrait">Portrait</option>
                    </select>
                </div>
                <textarea id="pesan" placeholder="Pesan Tambahan (Opsional)" rows="4"></textarea>
                <button type="submit" class="btn btn-primary full-width"><i class="fab fa-whatsapp"></i> Kirim via WhatsApp</button>
            </form>
        </div>
    </section>

    <a href="https://wa.me/6289669333080" class="floating-wa" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
    </a>

<div class="card-form-testi fade-up" style="margin-top: 50px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div class="section-header text-center">
        <span class="subtitle">Share Your Experience</span>
        <h3>Kirim Testimoni</h3>
    </div>
    <form action="proses_testimoni.php" method="POST" class="feedback-form">
        <div class="form-group">
            <input type="text" name="nama_klien" placeholder="Nama Anda" required>
        </div>
        <div class="form-group">
            <input type="text" name="pekerjaan" placeholder="Kategori (Contoh: Pasangan Wedding / Lulusan UNUSIDA)" required>
        </div>
        <div class="form-group">
            <select name="rating" required>
                <option value="5">Rating: ⭐⭐⭐⭐⭐ (Sempurna)</option>
                <option value="4">Rating: ⭐⭐⭐⭐ (Sangat Bagus)</option>
                <option value="3">Rating: ⭐⭐⭐ (Cukup)</option>
            </select>
        </div>
        <div class="form-group">
            <textarea name="pesan" rows="4" placeholder="Ceritakan pengalaman Anda menggunakan jasa Denaya Pictures..." required></textarea>
        </div>
        <button type="submit" name="kirim_testimoni" class="btn btn-primary full-width">Kirim Review</button>
    </form>
</div>
<div style="height: 80px;"></div><div style="height: 80px;"></div>

    <footer>
        <div class="footer-content">
            <h3 class="logo-footer">DENAYA PICTURES</h3>
            <div class="social-links">
                <a href="https://www.instagram.com/denaya.pictures?igsh=eWo1M2RyZ3pnbm5l" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://tiktok.com" target="_blank"><i class="fab fa-tiktok"></i></a>
            </div>
            <p>© 2026 Denaya Pictures. Capturing Moments, Preserving Memories Forever.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>