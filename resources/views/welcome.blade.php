<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang | Sistem Pengaduan Fasilitas</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --dark: #0f172a;
            --light: #f1f5f9;
            --white: #ffffff;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--white);
            color: var(--dark);
        }
        .header {
            z-index: 100;
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 2px rgba(15,23,42,0.1);
        }
        .header .nav-link {
            font-weight: 600;
            color: var(--secondary) !important;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }
        .header .nav-link:hover {
            color: var(--primary) !important;
            background: var(--light);
        }
        .hero-section {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            background: linear-gradient(to bottom, #f8fafc, #fff);
            overflow: hidden;
            padding: 6rem 0 4rem;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
        }
        .hero-text {
            max-width: 600px;
        }
        .hero-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(15,23,42,0.1);
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--dark);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--secondary);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        .btn-lapor {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-lapor:hover {
            background: var(--primary-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.15);
        }
        .hero-illustration {
            width: 500px;
            max-width: 100%;
            height: auto;
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(15,23,42,0.1);
        }
        .visi-misi-section {
            background: var(--white);
            padding: 6rem 0;
            position: relative;
        }
        .visi-misi-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(15,23,42,0.1), transparent);
        }
        .visi-misi-card {
            background: var(--white);
            border-radius: 1.5rem;
            padding: 3rem;
            box-shadow: 0 4px 6px -1px rgba(15,23,42,0.1),
                        0 2px 4px -2px rgba(15,23,42,0.05);
        }
        .visi-misi-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            background: var(--light);
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
        }
        .visi-misi-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        .visi-misi-text {
            color: var(--secondary);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        .visi-misi-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .visi-misi-list li {
            margin-bottom: 1rem;
            padding-left: 2rem;
            position: relative;
            color: var(--secondary);
            font-size: 1.1rem;
            line-height: 1.7;
        }
        .visi-misi-list li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
        }
        .footer {
            background: var(--dark);
            color: var(--light);
            padding: 4rem 0 2rem;
        }
        .footer-brand {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: block;
        }
        .footer a { 
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover { 
            color: var(--primary);
        }
        .footer .social-links a {
            font-size: 1.5rem;
            margin-right: 1.5rem;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .footer .social-links a:hover {
            opacity: 1;
            transform: translateY(-2px);
        }
        .btn-login {
            background: transparent;
            color: var(--light);
            border: 1px solid rgba(241,245,249,0.2);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: rgba(241,245,249,0.1);
            color: var(--white);
            border-color: transparent;
        }
        @media (max-width: 992px) {
            .hero-content { 
                flex-direction: column;
                text-align: center;
            }
            .hero-title { 
                font-size: 2.5rem;
            }
            .hero-illustration {
                width: 100%;
                max-width: 400px;
                margin: 2rem auto 0;
            }
            .visi-misi-card {
                padding: 2rem;
            }
        }
        @media (max-width: 576px) {
            .hero-title { 
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .hero-logo {
                width: 60px;
                height: 60px;
            }
            .btn-lapor {
                width: 100%;
            }
            .visi-misi-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="header fixed-top py-3">
        <div class="container-xl d-flex align-items-center justify-content-between">
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Klinik" style="width:42px; height:42px; border-radius:8px;">
                <span class="ms-3 fw-bold text-dark" style="font-size: 1.1rem;">Klinik Pratama Inggit Medika</span>
            </a>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="#visi-misi">Visi & Misi</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero-section">
        <div class="container hero-content">
            <div class="hero-text">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Klinik" class="hero-logo">
                <h1 class="hero-title">Sistem Pengaduan Kerusakan Fasilitas</h1>
                <p class="hero-subtitle">Memastikan kualitas pelayanan terbaik melalui penanganan cepat dan efisien untuk setiap kerusakan fasilitas di Klinik Pratama Inggit Medika.</p>
                <a href="{{ route('pelapor.dashboard') }}" class="btn btn-lapor">Laporkan Kerusakan</a>
            </div>
            <div>
                <img src="https://plus.unsplash.com/premium_photo-1675686363504-ba2df7786f16?q=80&w=2091&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D-592x532.png?auto=format" 
                     alt="Ilustrasi Sistem Pengaduan" 
                     class="hero-illustration">
            </div>
        </div>
    </section>

    <section id="visi-misi" class="visi-misi-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="visi-misi-card">
                        <div class="text-center">
                            <div class="visi-misi-icon mx-auto">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <h2 class="visi-misi-title">Visi</h2>
                            <p class="visi-misi-text">Menjadi klinik pratama pilihan utama masyarakat yang unggul dalam pelayanan kesehatan, profesional, ramah, dan berorientasi pada keselamatan serta kepuasan pasien.</p>
                        </div>
                        
                        <div class="text-center mt-5">
                            <div class="visi-misi-icon mx-auto">
                                <i class="bi bi-stars"></i>
                            </div>
                            <h2 class="visi-misi-title">Misi</h2>
                        </div>
                        <ul class="visi-misi-list">
                            <li>Memberikan pelayanan kesehatan yang cepat, tepat, dan berkualitas dengan mengutamakan keselamatan pasien.</li>
                            <li>Meningkatkan kompetensi dan profesionalisme seluruh tenaga kesehatan dan staf klinik.</li>
                            <li>Menciptakan lingkungan klinik yang bersih, nyaman, dan ramah bagi pasien dan keluarga.</li>
                            <li>Mengembangkan sistem pelayanan berbasis teknologi untuk kemudahan akses dan transparansi informasi.</li>
                            <li>Berperan aktif dalam upaya promotif dan preventif kesehatan masyarakat sekitar.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-5">
                    <span class="footer-brand">Klinik Pratama Inggit Medika</span>
                    <p class="mb-4" style="opacity:0.8;">Memberikan pelayanan kesehatan terbaik dengan mengutamakan keselamatan dan kepuasan pasien.</p>
                    <div class="social-links mb-4">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/inggit.healthcare"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="d-flex flex-column gap-2">
                                <a href="https://maps.app.goo.gl/bSuyxwtHrmexNefB6" target="_blank">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Jl. Bumi Tamalanrea Permai No.15-16 Blok G, Kec. Tamalanrea, Kota Makassar
                                </a>
                                <a href="https://api.whatsapp.com/send/?phone=6281366619997">
                                    <i class="bi bi-telephone me-2"></i>
                                    0813-6661-9997
                                </a>
                                <a href="mailto:info@klinikinggitmedika.com">
                                    <i class="bi bi-envelope me-2"></i>
                                    info@klinikinggitmedika.com
                                </a>
                            </div>
                        </div>
                        <div class="col-12 text-lg-end mt-4">
                            <a href="{{ route('login') }}" class="btn btn-login">
                                <i class="bi bi-person-circle me-2"></i>Login
                            </a>
                            <div class="mt-4">
                                <small style="opacity:0.6;">&copy; {{ date('Y') }} Klinik Pratama Inggit Medika. All rights reserved.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
