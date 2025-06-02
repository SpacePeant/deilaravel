<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Header -->
    @include('includes.header')

    <section class="main-section">
      <img src="img/dash.png" alt="Fresh and Tasty" class="main-image" draggable="false"/>
    </section>
    <div class="butt">
    <button class="cta-button" onclick="window.location.href='menu.php'">Lihat Sekarang</button>
    </div>
    <div class="about">
      <img src="{{ asset('img/about.png') }}" alt="Smarteats Meal" draggable="false">
      <div class="text-container">
        <h1>All About Smarteats for Kids</h1>
        <p>
          Smarteats for Kids adalah solusi praktis untuk orang tua modern! Kami
          menghadirkan meal plan sehat dan lezat khusus untuk anak-anak, dengan
          gizi seimbang dan bahan pilihan berkualitas. Setiap menu dirancang
          oleh ahli gizi dan koki profesional demi tumbuh kembang optimal si
          kecil.
        </p>
        <p class="tagline">Treat yourself to a feel good meal today!</p>
      </div>
    </div>
    <div class="why">
      <img src="img/why.png" alt="" draggable="false"/>
      <div class="whyy">
        <h1>Why Choose US?</h1>
      </div>
      <div class="whychoose">
        <p>
          Smarteats for Kids hadir dengan menyediakan solusi nutrisi harian yang
          aman, seimbang, dan menyenangkan bagi anak-anak. Dengan standar
          kualitas tinggi dan pelayanan yang konsisten, kami mendampingi para
          orang tua dalam memastikan kebutuhan gizi buah hati terpenuhi setiap
          hari.
        </p>
      </div>
    </div>

    <section class="services-section">
      <img src="img/service.png" alt="" draggable="false"/>
      <div class="services-container">
        <div class="item1">
          <h3>Quality Food</h3>
          <p>
            Kami menghadirkan makanan anak yang sehat, lezat, dan dibuat dengan
            standar kualitas terbaik.
          </p>
        </div>
        <div class="item2">
          <h3>Cook like a Chef</h3>
          <p>
            Dimasak oleh tim profesional dengan teknik masak yang higienis dan
            penuh cinta.
          </p>
        </div>
        <div class="item3">
          <h3>Ingredients</h3>
          <p>
            Selalu menggunakan bahan segar pilihan tanpa pengawet, demi nutrisi
            optimal setiap hari.
          </p>
        </div>
        <div class="item4">
          <h3>Easy Recipes</h3>
          <p>
            Menu kami mudah dipahami dan bisa dipraktikkan ulang di rumah oleh
            orang tua.
          </p>
        </div>
        <div class="item5">
          <h3>Serve Hot</h3>
          <p>
            Setiap menu disajikan hangat agar rasa dan gizinya tetap maksimal
            saat disantap.
          </p>
        </div>
        <div class="item6">
          <h3>On-Time Delivery</h3>
          <p>
            Pengantaran cepat dan tepat waktu, langsung ke tempat Anda setiap
            hari.
          </p>
        </div>
      </div>
      <h1>Our Awesome Services</h1>
    </section>

    <div class="fakq">
      <img src="img/FAQ.png" alt="" draggable="false"/>
    </div>

    <section class="faq-section">
      <h2>FAQs</h2>
      <div class="faq-item">
        <button class="faq-question">
          Q: Seberapa lama menu Smarteats for Kids bisa disimpan hingga siap
          untuk disantap?
        </button>
        <div class="faq-answer">
          Menu dapat disimpan di kulkas selama 2–3 hari atau di freezer hingga 7
          hari, dengan petunjuk penyimpanan disertakan.
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Q: Apakah semua menu Smarteats for Kids dibuat fresh?
        </button>
        <div class="faq-answer">
          Ya, semua menu dibuat segar setiap hari dengan bahan berkualitas.
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Q: Apakah produk Smarteats for Kids Halal?
        </button>
        <div class="faq-answer">
          Seluruh bahan makanan bersertifikasi Halal.
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Q: Seberapa jauh jangkauan pengiriman makanan Smarteats for Kids?
          Apakah bisa langsung ke sekolah?
        </button>
        <div class="faq-answer">
          Kami melayani pengiriman ke rumah dan sekolah dalam jangkauan area
          operasional kami.
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Q: Apakah saya bisa memilih menu sesuai yang saya inginkan? Jika iya,
          bagaimana caranya?
        </button>
        <div class="faq-answer">
          Tentu! Kamu bisa memilih menu di website kami dan menyesuaikannya
          sesuai kebutuhan.
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Q: Apakah menunya bisa disesuaikan dengan alergi atau preferensi anak?
        </button>
        <div class="faq-answer">
          Ya, kami menyediakan opsi untuk menghindari bahan alergi dan
          menyesuaikan menu.
        </div>
      </div>
    </section>

    <script>
      const questions = document.querySelectorAll(".faq-question");
      questions.forEach((btn) => {
        btn.addEventListener("click", () => {
          const answer = btn.nextElementSibling;
          btn.classList.toggle("active");
          answer.style.maxHeight = answer.style.maxHeight
            ? null
            : answer.scrollHeight + "px";
        });
      });
    </script>

    <div class="foot">
      <img src="img/foot.png" alt="" draggable="false"/>
    </div>

    <section class="hero-banner">
      <div class="hero-content">
        <h1>Langkah Awal Menuju Anak Sehat</h1>
        <br />
        <p>
          Memberikan gizi terbaik adalah langkah awal membentuk
          <strong>generasi sehat dan <br />cerdas</strong>. Mulailah dari menu
          harian yang <strong>lezat, aman, dan ramah</strong> anak bersama
          <br />Smartetas for Kids.
        </p>
      </div>
    </section>

    <footer>
      <div class="footer-grid">
        <div>
          <h3>Products</h3>
          <ul>
            <li href="">Paket Energi Pagi</li>
            <li href="">Paket Lunch Hero</li>
            <li href="">Paket Jajan Sehat</li>
            <li href="">Paket Komplit Harian</li>
            <li href="">Paket Happy Tummy</li>
            <li href="">Paket Nusantara Mini</li>
            <li href="">Paket Western Fun</li>
            <li href="">Paket Plant Power</li>
          </ul>
        </div>

        <div>
          <h3>Information</h3>
          <ul>
            <li href="">Articles</li>
            <li href="">FAQ</li>
            <li href="">Privacy Policy</li>
            <li href="">Terms and Conditions</li>
                  
          </ul>
        </div>

        <div>
          <h3>Connected With Us</h3>
          <ul>
            <li class="icon-row">
              <i data-feather="instagram"></i><span>@smarteatsforkids.com</span>
            </li>
            <li class="icon-row">
              <i data-feather="mail"></i>
              <span>@smarteatsforkids</span>
            </li>
          </ul>
        </div>

        <div class="footer-right">
          <div class="footer-logo">
            <img src="img/logo.png" width="" height="70" alt="Logo" />
          </div>
          <div class="contact-info">
            <div class="icon-row">
              <i data-feather="phone"></i><span>‪+62822-4792-7700‬</span>
            </div>
            <div class="icon-row">
              <i data-feather="calendar"></i><span>Senin - Jumat</span>
            </div>
            <div class="icon-row">
              <i data-feather="clock"></i><span>08:00 - 17:00 WIB</span>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        © 2025 Smarteats for Kids. All rights reserved.
      </div>
    </footer>

    <script>
      feather.replace();
    </script>
  </body>
</html>
