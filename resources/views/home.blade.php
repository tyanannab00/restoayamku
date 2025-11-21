<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    /* CSS untuk header hitam */
    .header-wrap {
        background-color: #000;
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-top {
        background-color: #000;
        padding: 10px 0;
        color: #fff;
    }

    .header-top a {
        color: #fff;
        text-decoration: none;
    }

    .header-top a:hover {
        color: #ccc;
    }

    .header-top i {
        margin-right: 8px;
        color: #fff;
    }

    .navigation-wrap {
        background-color: #000 !important;
        padding: 15px 0;
    }

    .navbar-brand img {
        max-height: 40px;
    }

    .nav-link {
        color: #fff !important;
        padding: 8px 15px !important;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #ccc !important;
    }

    .navbar-toggler {
        border-color: rgba(255,255,255,0.5) !important;
    }

    .navbar-toggler-icon {
        color: #fff;
    }

    /* Style untuk tombol Order Now */
    .main-btn.style-1 {
        background: #ff6b00;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .main-btn.style-1 a {
        color: #fff !important;
        text-decoration: none;
    }

    .main-btn.style-1:hover {
        background: #e05d00;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .navbar-collapse {
            background: #000;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .contact-item p, .contact-item a {
        margin: 0;
        font-size: 14px;
    }
    </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="Description" content="Enter your description here" />
  <title>YONGKRU</title> 

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> 

  <!-- OWN CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive-style.css') }}">
</head>

<body> 
  <!-- Header Section -->
  <header class="header-wrap">
    <!-- Header Top -->
    
    <nav class="navbar navbar-expand-lg navigation-wrap">
      <div class="container pr-0">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-stream navbar-toggler-icon"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#about">About US</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#services">Services</a>
            </li>
          <li>
            <button class="main-btn style-1">
                <a href="{{ route('menu.index') }}">Order Now <i class="fas fa-long-arrow-alt-right ms-1"></i></a>
            </button>
        </li>
        </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Section-1 Top-Banner -->
  <section id="home">
    <div class="top-banner">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-md-8">
            <h1>RESTO AYAM KU SERASA RESTO AYAM BAPAK MU LOHH !!</h1>
            <h4>Pembelian hari ini ada diskon 20% nihh!!</h4>
            <!-- <button class="main-btn style-1 mt-4"><a href="#apps"><i class="fas fa-shopping-basket pe-3"></i> Download Now</a> -->
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us -->
  <section id="about">
    <div class="about-section wrapper pb-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-12">
            <img src="{{ asset('images/offer/classic.jpg') }}" class="img-fluid"/>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-12 ps-lg-5" style="background:#e3cb62;">
              
              <h2>We Provide new street food experience</h2>
              <p>Resto Ayam Ku bukan sekadar tempat makan ayam goreng biasa. Kami adalah perwujudan dari rasa otentik yang diracik dari rempah-rempah pilihan terbaik Indonesia. Setiap potong ayam kami dimarinasi sempurna, menghasilkan tekstur yang renyah di luar dan super juicy di dalam.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services">
    <div class="service-section wrapper">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="text-center">
              
              <h2>Beberapa Menu Andalan Kami</h2>
            </div>
          </div>
        </div>
        <div class="row service-cards">
          <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
            <div class="card">
              <img src="{{ asset('images/offer/classic.jpg') }}" class="img-fluid"/>
              <div class="p-4">
                <h3>Ayam Goreng Klasik Krispi</h3>
                <p>Potongan ayam goreng dengan kulit renyah keemasan dan daging yang empuk, disajikan polos untuk menikmati rasa otentik.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
            <div class="card">
              <img src="{{ asset('images/offer/sambalmatah.jpg') }}" class="img-fluid"/>
              <div class="p-4">
                <h3>Ayam Sambal Matah</h3>
                <p>Ayam goreng krispi yang disiram dengan sambal matah segar khas Bali, memberikan sensasi pedas dan aroma jeruk yang menggoda.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
            <div class="card">
              <img src="{{ asset('images/offer/sausmadu.jpg') }}" class="img-fluid"/>
              <div class="p-4">
                <h3>Ayam Goreng Saus Madu Pedas Korea</h3>
                <p>Potongan sayap atau paha ayam goreng yang dilumuri saus madu pedas ala Korea, cocok untuk pecinta rasa manis pedas yang unik.</p>
              </div>
            </div> 
          </div>
          <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
            <div class="card">
              <img src="{{ asset('images/offer/kemangi.jpg') }}" class="img-fluid"/>
              <div class="p-4">
                <h3>Ayam Goreng Kemangi Pedas</h3>
                <p>Ayam goreng dengan bumbu rempah yang meresap sempurna, disajikan dengan taburan daun kemangi segar dan irisan cabai rawit untuk aroma dan rasa pedas yang khas.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  
  <!-- Download App Section
  <section id="apps">
    <div class="app-section wrapper">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-8 col-sm-10 mb-4">
            <span>Our App</span>
            <h2 class="mb-xl-5 mb-3">Order With Our Application</h2>
            <div class="mb-xl-4 mb-3">
              <h4><i class="far fa-check-square me-2"></i>Order And Pay In A Few Minutes</h4>
            </div>
            <div class="mb-xl-4 mb-3">
              <h4><i class="far fa-check-square me-2"></i>Check Delivery Status</h4>
            </div><br>
            <br><br>
            <br>
            <div class="d-flex flex-wrap mt-xl-5 mt-4 download-app-btn">
              <a href="#" class="me-3"><img src="{{ asset('images/app/google-playstore.png') }}" class="img-fluid"/></a>
              <a href="#"><img src="{{ asset('images/app/apple-playstore.png') }}" class="img-fluid"/></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <!-- MainJS -->
  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const suggestionForm = document.getElementById('suggestion-form');
      
      if (suggestionForm) {
        suggestionForm.addEventListener('submit', function(e) {
          const emailInput = document.getElementById('suggestion-email');
          if (emailInput.value.trim() === '') {
            e.preventDefault();
            alert('Silakan masukkan saran Anda terlebih dahulu');
          }
        });
      }
    });
  </script>
</body>
</html>