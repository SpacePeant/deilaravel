<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smarteats Menu</title>
    <link rel="stylesheet" href="{{ asset('css/MENU.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <section class="food-cart">
      <h2>Paket Menu</h2>
      <div class="backbutt">
  <button onclick="location.href='{{ url('/home') }}'" class="btn-back">← Kembali</button>

</div>

<div class="menu">
  <a href="{{ url('/Energi-Pagi') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Energi-Pagi.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Energi Pagi</h3>
        <p>Untuk sarapan bergizi & penuh tenaga</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Lunch-Hero') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Lunch-Hero.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Lunch Hero</h3>
        <p>Menu makan siang padat gizi</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Jajan-sehat') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Jajan-Sehat.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Jajan Sehat</h3>
        <p>Jajanan alternatif untuk buah hati yang sehat dan penuh gizi</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Happy-Tummy') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Happy-Tummy.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Happy Tummy</h3>
        <p>Aman untuk perut sensitif & picky eater</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Nusantara-Mini') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Nusantara-Mini.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Nusantara Mini</h3>
        <p>Kenalkan cita rasa lokal sejak dini</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Western-Fun') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Western-Fun.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Western Fun</h3>
        <p>Menu dengan sentuhan internasional yang tetap sehat</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>

  <a href="{{ url('/Plant-Power') }}" class="food-box">
    <div class="menu-card">
      <div class="circle-image">
        <img src="{{ asset('images/Plant-Power.png') }}" alt="paket lunch hero" />
      </div>
      <div class="menu-details">
        <h3>Plant Power</h3>
        <p>Ramah untuk vegetarian / preferensi nabati</p>
        <button>Lihat Detail</button>
      </div>
    </div>
  </a>
</div>

        <!-- Add more food-box cards as needed -->
      </div>

      <script>
        feather.replace();
      </script>
    </section>
  </body>
</html>
