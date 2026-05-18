<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventTicket - Discover & Book Now!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #000000;
        }
        /* Top Navigation Header Bar */
        .top-search-bar {
            background-color: #7a4988;
            padding: 10px 0;
        }
        .search-input-container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        .search-input-container input {
            border-radius: 20px;
            padding-left: 35px;
            font-size: 14px;
        }
        .search-input-container i {
            position: absolute;
            left: 12px;
            top: 11px;
            color: #6c757d;
        }
        .nav-links-top .nav-link {
            color: #000000 !important;
            font-size: 14px;
            font-weight: 500;
        }
        .nav-links-top .nav-link:hover {
            color: #7a4988 !important;
        }
        .btn-masuk {
            background-color: #be93d4;
            color: white;
            font-size: 13px;
            font-weight: bold;
            padding: 4px 20px;
            border-radius: 4px;
        }
        .btn-daftar {
            background-color: #9e7bb5;
            color: white;
            font-size: 13px;
            font-weight: bold;
            padding: 4px 20px;
            border-radius: 4px;
        }
        
        /* Banner Carousel Slider */
        .carousel-container {
            position: relative;
            margin-top: 10px;
        }
        .carousel-control-prev, .carousel-control-next {
            width: 5%;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-image: none;
            color: #000000;
            font-size: 30px;
            font-weight: bold;
        }

        /* Section Heading Customization */
        .section-title-center {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #333333;
            text-transform: uppercase;
        }
        .section-title-left {
            font-size: 28px;
            font-weight: bold;
            color: #000000;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        /* Category Circles */
        .category-circle-wrapper {
            text-align: center;
        }
        .category-circle {
            width: 110px;
            height: 110px;
            border: 2px solid #7a4988;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px auto;
            padding: 15px;
            transition: transform 0.2s;
        }
        .category-circle:hover {
            transform: scale(1.05);
        }
        .category-circle img {
            width: 100%;
            height: auto;
        }
        .category-text {
            font-size: 15px;
            font-weight: 500;
            color: #333333;
        }

        /* Event Grid Cards */
        .event-card {
            border: none;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .event-img {
            width: 100%;
            height: 380px;
            object-fit: cover;
        }
        .event-info-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #000000;
            color: #ffffff;
            padding: 12px;
            text-align: center;
        }
        .event-date-time {
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .event-location {
            font-size: 12px;
            color: #ffffff;
            margin-bottom: 0;
            text-transform: uppercase;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .event-location i {
            margin-right: 5px;
            font-size: 11px;
        }

        /* Center Control Buttons */
        .btn-action-purple {
            background-color: #7a4988;
            color: #ffffff !important;
            font-size: 14px;
            padding: 6px 25px;
            border-radius: 8px;
            border: none;
            display: inline-block;
            text-decoration: none;
        }
        .btn-action-purple:hover {
            background-color: #9e7bb5;
        }
        .info-text-contact {
            font-size: 15px;
            color: #333333;
            max-width: 450px;
            margin: 0 auto;
            line-height: 1.4;
        }

        /* Main Master Footer Section */
        .master-footer {
            background-color: #1a0926; /* Deep Dark Purple */
            color: #ffffff;
            padding: 40px 0 20px 0;
            font-size: 13px;
            margin-top: 50px;
        }
        .footer-logo-side img {
            width: 120px;
            margin-bottom: 15px;
        }
        .footer-logo-side p {
            color: #be93d4;
            line-height: 1.5;
            font-size: 12px;
        }
        .footer-column-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }
        .footer-links-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .footer-links-list li {
            margin-bottom: 8px;
        }
        .footer-links-list a {
            color: #be93d4;
            text-decoration: none;
        }
        .footer-links-list a:hover {
            color: #ffffff;
        }
        .footer-contact-info p {
            margin-bottom: 8px;
            color: #be93d4;
        }
        .footer-contact-info i {
            margin-right: 10px;
            width: 15px;
        }
        .footer-bottom-copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            padding-top: 15px;
            font-size: 11px;
            color: #be93d4;
        }
    </style>
</head>
<body>

    <div class="container py-2">
        <div class="row align-items-center">
            <div class="col-6 col-md-3">
                <img src="https://via.placeholder.com/130x40/7a4988/ffffff?text=EventTicket" alt="Logo EventTicket" class="img-fluid">
            </div>
            <div class="col-6 col-md-9 text-end">
                <div class="d-flex justify-content-end align-items-center gap-4 nav-links-top">
                    <a class="nav-link active" href="{{ url('/') }}">Beranda</a>
                    <a class="nav-link" href="#">Acara</a>
                    <a class="nav-link" href="#">Tentang kami</a>
                    <a class="btn btn-masuk text-white" href="{{ route('login') }}">Masuk</a>
                    <a class="btn btn-daftar text-white" href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="top-search-bar">
        <div class="container">
            <div class="search-input-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="form-control" placeholder="Mencari acara/kegiatan (otomatis)">
            </div>
        </div>
    </div>

    <div class="container carousel-container">
        <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/1200x320/7a4988/ffffff?text=EVENT+%26+TICKETING++|+Discover+%26+Book+Now!" class="d-block w-100 rounded" alt="Promo Banner 1">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true">&lt;</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true">&gt;</span>
            </button>
        </div>
    </div>

    <div class="container text-center my-4">
        <p class="section-title-center mb-3">KATEGORI ACARA</p>
        <div class="row justify-content-center g-4">
            <div class="col-4 col-sm-3 col-md-2 category-circle-wrapper">
                <div class="category-circle">
                    <img src="https://img.icons8.com/ios/100/7a4988/basketball-player.png" alt="Olahraga">
                </div>
                <div class="category-text">Olahraga</div>
            </div>
            <div class="col-4 col-sm-3 col-md-2 category-circle-wrapper">
                <div class="category-circle">
                    <img src="https://img.icons8.com/ios/100/7a4988/theatre-mask.png" alt="Hiburan">
                </div>
                <div class="category-text">Hiburan</div>
            </div>
            <div class="col-4 col-sm-3 col-md-2 category-circle-wrapper">
                <div class="category-circle">
                    <img src="https://img.icons8.com/ios/100/7a4988/training.png" alt="Seminar">
                </div>
                <div class="category-text">Seminar</div>
            </div>
        </div>
        <hr class="mt-4 bg-secondary opacity-25">
    </div>

    <div class="container mb-5">
        <h2 class="section-title-left">ACARA YANG SEDANG BERLANGSUNG</h2>
        
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="event-card shadow">
                    <img src="https://via.placeholder.com/300x420/7a4988/ffffff?text=SPORT+EVENT" class="event-img" alt="Sport Event">
                    <div class="event-info-overlay">
                        <div class="event-date-time">20 MEI , 16:00</div>
                        <p class="event-location"><i class="fa-solid fa-location-dot"></i>LAPANGAN POLITEKNIK</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="event-card shadow">
                    <img src="https://via.placeholder.com/300x420/9e7bb5/ffffff?text=FESTIVAL+BAND" class="event-img" alt="Festival Band">
                    <div class="event-info-overlay">
                        <div class="event-date-time">28 MEI , 13:00</div>
                        <p class="event-location"><i class="fa-solid fa-location-dot"></i>DEPAN TECHNO</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="event-card shadow">
                    <img src="https://via.placeholder.com/300x420/333333/ffffff?text=AI+FORUM" class="event-img" alt="AI Forum">
                    <div class="event-info-overlay">
                        <div class="event-date-time">28 MEI , 13:00</div>
                        <p class="event-location"><i class="fa-solid fa-location-dot"></i>GEDUNG UTAMA</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="event-card shadow">
                    <img src="https://via.placeholder.com/300x420/7a4988/ffffff?text=FUTSAL+CHAMP" class="event-img" alt="Futsal Kampus">
                    <div class="event-info-overlay">
                        <div class="event-date-time">30 MEI , 08:00</div>
                        <p class="event-location"><i class="fa-solid fa-location-dot"></i>LAPANGAN POLITEKNIK</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn-action-purple shadow mb-4">Lihat Semua Acara</a>
            <div class="info-text-contact mt-2 text-muted mb-3">
                Ingin membuat acara atau kegiatan baru? hubungi admin untuk informasi lebih lanjut melalui kontak kami
            </div>
            <a href="#" class="btn-action-purple shadow px-4">Kontak kami</a>
        </div>
    </div>

    <footer class="master-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-3 footer-logo-side">
                    <img src="https://via.placeholder.com/130x40/ffffff/7a4988?text=EventTicket" alt="Logo Bottom">
                    <p>Event&Ticketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.</p>
                </div>
                
                <div class="col-6 col-md-3">
                    <div class="footer-column-title">NAVIGASI</div>
                    <ul class="footer-links-list">
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Acara</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3">
                    <div class="footer-column-title">KATEGORI</div>
                    <ul class="footer-links-list">
                        <li><a href="#">Hiburan</a></li>
                        <li><a href="#">Olahraga</a></li>
                        <li><a href="#">Seminar</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-3 footer-contact-info">
                    <div class="footer-column-title">HUBUNGI KAMI</div>
                    <p><i class="fa-regular fa-envelope"></i> Jesinaaurora@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +62 895 3128 7505</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center footer-bottom-copyright">
                    &copy; 2026 Event Ticketing System | All Rights Reserved
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>