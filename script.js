document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Navbar Scroll Effect (Membaca Scroll untuk merubah warna background & Teks)
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        // Jika scroll lebih dari 50px dari atas, tambahkan class 'scrolled'
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 2. Smooth Scrolling untuk Link Navigasi
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // 3. Staggered Fade-Up Animation (Animasi Muncul Berurutan)
    const setStaggerDelay = (selector, delayIncrement) => {
        const items = document.querySelectorAll(selector);
        items.forEach((item, index) => {
            item.style.transitionDelay = `${index * delayIncrement}s`;
        });
    };

    if(window.innerWidth > 768) {
        setStaggerDelay('.services .card', 0.15);
        setStaggerDelay('.masonry-item', 0.1);
        setStaggerDelay('.process-step', 0.15);
    }

    const appearOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
    const appearOnScroll = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('appear');
            observer.unobserve(entry.target);
        });
    }, appearOptions);

    document.querySelectorAll('.fade-up').forEach(fader => {
        appearOnScroll.observe(fader);
    });

    // 4. Parallax Effect Sederhana untuk Gambar Hero
    const heroImage = document.querySelector('.parallax-bg');
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                let scrollPosition = window.pageYOffset;
                if(window.innerWidth > 768 && heroImage) {
                    heroImage.style.transform = `translateY(${scrollPosition * 0.3}px)`;
                }
                ticking = false;
            });
            ticking = true;
        }
    });

    // 5. Integrasi Formulir ke WhatsApp
    const form = document.getElementById('booking-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Mencegah form memuat ulang halaman
            
            // Mengambil nilai dari input form
            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const tanggal = document.getElementById('tanggal').value;
            const layanan = document.getElementById('layanan').value;
            const pesan = document.getElementById('pesan').value;

            // Masukkan Nomor WhatsApp Anda di sini (Gunakan 62, hilangkan angka 0 di depan)
            const noWa = '6289669333080'; // <-- UBAH NOMOR INI

            // Merangkai pesan yang akan dikirim
            const textWa = `Halo Denaya Pictures, saya ingin berdiskusi mengenai reservasi sesi foto. Berikut adalah detailnya:
            
*Detail Reservasi:*
 Nama: ${nama}
 Email: ${email}
 Tanggal Acara: ${tanggal}
 Layanan: ${layanan}
 Pesan Tambahan: ${pesan ? pesan : '-'}

Apakah untuk tanggal tersebut masih tersedia? Terima kasih!`;

            // URL Encoding agar teks aman di URL
            const encodedText = encodeURIComponent(textWa);
            
            // Membuat link menuju WhatsApp
            const waUrl = `https://wa.me/6289669333080?text=${encodedText}`;

            // Membuka link WhatsApp di tab baru
            window.open(waUrl, '_blank');
            
            // Mereset form setelah dikirim
            form.reset();
        });
    }
});