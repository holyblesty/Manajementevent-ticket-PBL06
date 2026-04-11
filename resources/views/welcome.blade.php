<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Event & Ticketing - Laravel Version</title>
<link rel="stylesheet" href="{{ asset('styles/style_holy.css') }}">
<h1>Ini Judul Merah</h1>

<img src="{{ asset('images/gambar1.png') }}" alt="">
<img src="{{ asset('images/gambar2.png') }}" alt="">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --purple: #7B2FBE;
    --purple-dark: #5A1F8C;
    --purple-light: #9B59D0;
    --purple-pale: #F3EAFD;
    --orange: #FF6B1A;
    --orange-dark: #E05510;
    --white: #ffffff;
    --gray-50: #F9F7FC;
    --gray-100: #F0EBF8;
    --gray-200: #E2D9F3;
    --gray-600: #6B5E7A;
    --gray-800: #2D1B42;
    --text: #1A0F2E;
    --font-display: 'Syne', sans-serif;
    --font-body: 'DM Sans', sans-serif;
  }

  body {
    font-family: var(--font-body);
    color: var(--text);
    background: var(--white);
    min-width: 1024px;
    line-height: 1.5;
  }

  /* ── NAVBAR ── */
  nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 60px;
    height: 68px;
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 12px rgba(123,47,190,0.06);
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }

  .logo-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, var(--purple) 0%, var(--purple-light) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .logo-icon svg { width: 22px; height: 22px; }

  .logo-text {
    font-family: var(--font-display);
    font-weight: 800;
    font-size: 15px;
    line-height: 1.2;
    color: var(--purple);
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 32px;
    list-style: none;
  }

  .nav-links a {
    font-size: 14px;
    font-weight: 500;
    color: var(--gray-600);
    text-decoration: none;
    transition: color 0.2s;
    position: relative;
  }

  .nav-links a.active { color: var(--purple); }
  .nav-links a.active::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0; right: 0;
    height: 2px;
    background: var(--purple);
    border-radius: 2px;
  }

  .nav-links a:hover { color: var(--purple); }

  .nav-actions { display: flex; align-items: center; gap: 12px; }

  .btn-masuk {
    padding: 8px 22px;
    font-size: 14px;
    font-weight: 600;
    color: var(--purple);
    background: var(--purple-pale);
    border: 1.5px solid var(--purple-light);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }

  .btn-masuk:hover { background: var(--gray-200); }

  .btn-daftar {
    padding: 8px 22px;
    font-size: 14px;
    font-weight: 600;
    color: var(--white);
    background: var(--purple);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }

  .btn-daftar:hover { background: var(--purple-dark); transform: translateY(-1px); }

  /* ── SEARCH BAR SECTION ── */
  .search-section {
    background: var(--purple);
    padding: 14px 60px;
    position: relative;
    z-index: 90;
  }

  .search-inner {
    display: flex;
    align-items: center;
    background: var(--white);
    border-radius: 10px;
    overflow: hidden;
    max-width: 600px;
    margin: 0 auto;
    border: 2px solid transparent;
    transition: border-color 0.2s;
  }

  .search-inner:focus-within { border-color: var(--orange); }

  .search-inner svg {
    margin-left: 14px;
    flex-shrink: 0;
    color: var(--gray-600);
  }

  .search-inner input {
    flex: 1;
    padding: 10px 14px;
    font-family: var(--font-body);
    font-size: 14px;
    color: var(--text);
    border: none;
    outline: none;
    background: transparent;
  }

  .btn-cari {
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    color: var(--white);
    background: var(--purple);
    border: none;
    cursor: pointer;
    transition: background 0.2s;
  }

  /* ── HERO BANNER ── */
  .hero {
    position: relative;
    height: 320px;
    background: linear-gradient(120deg, #0D0628 0%, #2A0869 40%, #6B0FAC 70%, #4B1FBF 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
  }

  .hero-bg-circles {
    position: absolute;
    inset: 0;
    z-index: 1;
  }

  .hero-bg-circles::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,107,26,0.2) 0%, transparent 70%);
    right: 10%; top: -100px;
  }

  .hero-content {
    position: relative;
    z-index: 5;
    padding-left: 80px;
    max-width: 600px;
  }

  .hero-tag {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--orange);
    background: rgba(255,107,26,0.1);
    border: 1px solid rgba(255,107,26,0.3);
    padding: 4px 12px;
    border-radius: 99px;
    margin-bottom: 15px;
  }

  .hero-title {
    font-family: var(--font-display);
    font-size: 56px;
    font-weight: 800;
    color: var(--white);
    line-height: 1.1;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .hero-title span { color: var(--orange); }

  .hero-subtitle {
    font-size: 18px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 25px;
  }

  .hero-visual {
    position: relative;
    z-index: 5;
    padding-right: 100px;
  }

  .ticket-stack {
    position: relative;
    width: 150px;
    height: 180px;
  }

  .ticket {
    position: absolute;
    width: 120px;
    height: 65px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
  }

  .ticket-1 { background: var(--orange); top: 0; left: 20px; transform: rotate(-8deg); }
  .ticket-2 { background: var(--purple-light); top: 55px; left: 0; transform: rotate(5deg); }
  .ticket-3 { background: rgba(255,255,255,0.2); top: 105px; left: 15px; transform: rotate(-3deg); border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(5px); }
  .ticket svg { width: 30px; height: 30px; stroke: white; }

  /* ── KATEGORI ── */
  .kategori { padding: 60px 60px 40px; text-align: center; }
  .section-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--purple); margin-bottom: 30px;
    display: flex; align-items: center; justify-content: center; gap: 15px;
  }
  .section-label::before, .section-label::after { content: ''; height: 1px; width: 50px; background: var(--gray-200); }

  .kategori-grid { display: flex; justify-content: center; gap: 25px; }
  .kat-item { display: flex; flex-direction: column; align-items: center; gap: 12px; cursor: pointer; transition: 0.3s; }
  .kat-circle {
    width: 80px; height: 80px; border-radius: 50%; background: var(--gray-50);
    border: 2px solid var(--gray-200); display: flex; align-items: center; justify-content: center;
    font-size: 32px; transition: 0.3s;
  }
  .kat-item.active .kat-circle, .kat-item:hover .kat-circle { background: var(--purple); border-color: var(--purple-dark); transform: translateY(-5px); color: white; }
  .kat-label { font-size: 13px; font-weight: 600; color: var(--gray-600); }
  .kat-item.active .kat-label { color: var(--purple); }

  /* ── ACARA BERLANGSUNG ── */
  .acara { padding: 40px 60px 80px; }
  .section-heading { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
  .section-title { font-family: var(--font-display); font-size: 28px; font-weight: 800; text-transform: uppercase; }
  
  .cards-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
  .event-card { border-radius: 16px; overflow: hidden; background: #1a1a1a; cursor: pointer; transition: 0.3s; }
  .event-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(123,47,190,0.2); }
  
  .card-placeholder { aspect-ratio: 3/4; display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; position: relative; }
  .card-bg-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 80px; opacity: 0.1; }
  .card-content { position: relative; z-index: 2; }
  .card-tag { font-size: 10px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 10px; display: inline-block; text-transform: uppercase; }
  .card-name { color: white; font-family: var(--font-display); font-size: 18px; font-weight: 800; margin-bottom: 5px; text-transform: uppercase; }
  .card-info { color: rgba(255,255,255,0.6); font-size: 12px; }

  /* Card Colors */
  .card-sport { background: linear-gradient(180deg, #1e3a8a, #1e1b4b); }
  .card-music { background: linear-gradient(180deg, #701a75, #4a044e); }
  .card-tech  { background: linear-gradient(180deg, #164e63, #083344); }
  .card-futsal { background: linear-gradient(180deg, #9a3412, #431407); }
  
  .tag-sport { background: #3b82f6; color: white; }
  .tag-music { background: #d946ef; color: white; }
  .tag-tech  { background: #06b6d4; color: white; }
  .tag-futsal { background: #f97316; color: white; }

  /* ── GALLERY ── */
/* ── GALLERY ── */
.gallery { padding: 0 60px 80px; }

.gallery-grid { 
display: grid; 
grid-template-columns: repeat(3, 1fr); 
gap: 20px; 
}

.gallery-item { 
border-radius: 16px; 
overflow: hidden; 
aspect-ratio: 2/3; 
position: relative; 
cursor: pointer; 
}

.gallery-item img { 
width: 100%; 
height: 100%; 
object-fit: cover; 
transition: 0.5s; 
}

.gallery-item:hover img { 
transform: scale(1.1); 
}

.gallery-overlay { 
position: absolute; 
inset: 0; 
background: linear-gradient(to top, rgba(123,47,190,0.8), transparent); 
opacity: 0; 
display: flex; 
align-items: flex-end; 
padding: 20px; 
transition: 0.3s; 
}

.gallery-item:hover .gallery-overlay { 
opacity: 1; 
}

.gallery-overlay h4 { 
color: white; 
font-family: var(--font-display); 
font-size: 14px; 
text-transform: uppercase; 
}


  /* ── FOOTER & CTA ── */
  .cta-strip { background: var(--gray-50); padding: 50px; text-align: center; border-top: 1px solid var(--gray-200); }
  .btn-purple { background: var(--purple); color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: 0.3s; }
  .btn-purple:hover { background: var(--purple-dark); transform: translateY(-2px); }

  footer { background: var(--gray-800); color: rgba(255,255,255,0.5); padding: 60px 60px 30px; }
  .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
  .footer-title { color: white; font-family: var(--font-display); font-size: 14px; text-transform: uppercase; margin-bottom: 20px; }
  .footer-links { list-style: none; }
  .footer-links li { margin-bottom: 10px; }
  .footer-links a { color: inherit; text-decoration: none; font-size: 13px; }
  .footer-links a:hover { color: white; }
  .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; font-size: 12px; text-align: right; }
</style>
</head>
<body>

<nav>
  <a href="#" class="logo">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/><path d="M13 5v2M13 17v2M13 11v2"/></svg>
    </div>
    <div class="logo-text">Event &<br>Ticketing</div>
  </a>
  <ul class="nav-links">
    <li><a href="#" class="active">Beranda</a></li>
    <li><a href="#">Acara</a></li>
    <li><a href="#">Tentang kami</a></li>
    <li><a href="#">Kontak kami</a></li>
  </ul>
  <div class="nav-actions">
    <a href="#" class="btn-masuk">Masuk</a>
    <a href="#" class="btn-daftar">Daftar</a>
  </div>
</nav>

<div class="search-section">
  <div class="search-inner">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    <input type="text" placeholder="Mencari acara atau kegiatan..." />
    <button class="btn-cari">Cari</button>
  </div>
</div>

<div class="hero">
  <div class="hero-bg-circles"></div>
  <div class="hero-content">
    <div class="hero-tag">✦ Platform Terpercaya #1</div>
    <h1 class="hero-title">Event &<br><span>Ticketing</span></h1>
    <p class="hero-subtitle">Discover & Book Your Best Experience Now!</p>
    <a href="#" class="btn-purple" style="background: var(--orange);">Book Now</a>
  </div>

  <div class="hero-visual">
    <div class="ticket-stack">
      <div class="ticket ticket-1"><svg viewBox="0 0 24 24" fill="none"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg></div>
      <div class="ticket ticket-2"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
      <div class="ticket ticket-3"><svg viewBox="0 0 24 24" fill="none"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/></svg></div>
    </div>
  </div>
</div>

<div class="kategori">
  <div class="section-label">Pilih Kategori</div>
  <div class="kategori-grid">
    <div class="kat-item active"><div class="kat-circle">⚽</div><span class="kat-label">Olahraga</span></div>
    <div class="kat-item"><div class="kat-circle">💡</div><span class="kat-label">Seminar</span></div>
    <div class="kat-item"><div class="kat-circle">🎭</div><span class="kat-label">Hiburan</span></div>
  </div>
</div>

<div class="acara">
  <div class="section-heading">
    <h2 class="section-title">Acara Terpopuler</h2>
    <a href="#" style="color: var(--purple); text-decoration: none; font-weight: 600;">Lihat Semua →</a>
  </div>
  
  <div class="cards-grid">
    <img src="{{ asset('images/gambar1.png') }}" alt="Event 1" style="width: 100%; border-radius: 16px;">
    <img src="{{ asset('images/gambar2.png') }}" alt="Event 2" style="width: 100%; border-radius: 16px;">

    <div class="event-card card-tech">
      <div class="card-placeholder">
        <div class="card-bg-icon">🤖</div>
        <div class="card-content">
          <span class="card-tag tag-tech">Seminar</span>
          <h3 class="card-name">AI Future Tech</h3>
          <p class="card-info">22 Nov • Auditorium</p>
        </div>
      </div>
    </div>
    <div class="event-card card-futsal">
      <div class="card-placeholder">
        <div class="card-bg-icon">🏆</div>
        <div class="card-content">
          <span class="card-tag tag-futsal">Kompetisi</span>
          <h3 class="card-name">Futsal Champ</h3>
          <p class="card-info">9 Juni • GOR Utama</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="gallery">
 
  <div class="section-heading"><h1 class="section-title" style="color: red; font-family: var(--font-display); margin-bottom: 10px;">Ini Judul Merah</h1></div>
  <div class="gallery-grid">
    <div class="gallery-item">
  <img src="{{ url('images/poster1.png') }}"alt="poster voli">>
      <div class="gallery-overlay"><h4>Lomba Voli</h4></div>
    </div>
    <div class="gallery-item">
     <img src="{{ url('images/poster2.png') }}" alt="poster futsal">>
      <div class="gallery-overlay"><h4>Lomba futsal</h4></div>
    </div>
    <div class="gallery-item">
     <img src="{{ asset('images/poster1.jpg') }}" alt="">
      <div class="gallery-overlay"><h4>Football Match</h4></div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=600&q=80">
      <div class="gallery-overlay"><h4>Business Forum</h4></div>
    </div>
    <div class="gallery-item">
      <img src= <img src="{ asset('images/poster-lomba-5.png') }" alt="poster nari">>
      <div class="gallery-overlay"><h4>lomba nari</h4></div>
    </div>
    <div class="gallery-item">
      <img src= <img src="{ asset('images/poster-lomba-6.jpeg') }" alt="poster band">>
      <div class="gallery-overlay"><h4>lomba band</h4></div>
    </div>
  </div>
</div>

<div class="cta-strip">
  <p style="margin-bottom: 20px; color: var(--gray-600);">Ingin buat acara sendiri? Hubungi admin kami sekarang.</p>
  <a href="#" class="btn-purple">Hubungi Kami</a>
</div>

<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-title" style="color: var(--purple-light)">Event & Ticketing</div>
      <p style="font-size: 13px; line-height: 1.6;">Platform pemesanan tiket event tercepat dan terpercaya untuk berbagai kegiatan kampus dan umum.</p>
    </div>
    <div>
      <h4 class="footer-title">Navigasi</h4>
      <ul class="footer-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="#">Acara</a></li>
        <li><a href="#">Kontak</a></li>
      </ul>
    </div>
    <div>
      <h4 class="footer-title">Kategori</h4>
      <ul class="footer-links">
        <li><a href="#">Olahraga</a></li>
        <li><a href="#">Seminar</a></li>
        <li><a href="#">Hiburan</a></li>
      </ul>
    </div>
    <div>
      <h4 class="footer-title">Kontak</h4>
      <ul class="footer-links">
        <li><a href="#">admin@event.id</a></li>
        <li><a href="#">+62 812 345 678</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">© 2026 Event Ticketing System | All Rights Reserved</div>
</footer>

<script>
  document.querySelectorAll('.kat-item').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.kat-item').forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });
</script>

</body>
</html>