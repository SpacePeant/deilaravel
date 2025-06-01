<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smarteats Menu</title>
  <style>
    /* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    padding: 20px;
  }
  
  /* Section title */
  .menu-section h2 {
    font-family: 'Tangerine', cursive;
    font-size: 48px;
    color: #738e2a;
    text-align: center;
    margin-bottom: 30px;
  }
  
  /* Filter buttons */
  .filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
  }
  
  .filters button {
    padding: 10px 20px;
    border: 2px solid #738e2a;
    background-color: white;
    color: #738e2a;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
  }
  
  .filters button:hover,
  .filters button.active {
    background-color: #738e2a;
    color: white;
  }
  
  /* Menu grid */
  .menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  /* Menu card */
  .menu-card {
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    padding: 15px;
    text-align: center;
    transition: 0.3s ease;
    text-decoration: none;
    color: inherit;
  }
  
  .menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }
  
  .menu-card img {
    width: 100%;
    height: auto;
    max-height: 180px;
    object-fit: contain;
    margin-bottom: 10px;
  }
  
  .menu-card h3 {
    font-size: 18px;
    margin: 10px 0 5px;
    color: #333;
  }
  
  .menu-card p {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
  }
  
  /* Detail button */
  .detail-btn {
    padding: 8px 16px;
    background-color: #738e2a;
    border: none;
    color: white;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s ease;
  }
  
  .detail-btn:hover {
    background-color: #738e2a;
  }
  
  /* Cart Icon */
  .cart-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1000;
  }
  
  .cart-icon i {
    width: 24px;
    height: 24px;
  }
  
  .cart-icon span {
    position: absolute;
    top: 8px;
    right: 8px;
    background: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 6px;
  }
  
  /* Cart sidebar (optional styling) */
  .cart-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 300px;
    height: 100%;
    background-color: white;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    overflow-y: auto;
    z-index: 1001;
  }
  
  .cart-sidebar.hidden {
    display: none;
  }
  
  .cart-sidebar h2 {
    margin-bottom: 15px;
    font-size: 24px;
  }
  
  .cart-sidebar ul {
    list-style: none;
    margin-bottom: 20px;
  }
  
  .cart-sidebar button {
    width: 100%;
    padding: 10px;
    background-color: #f57c00;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease;
  }
  
  .cart-sidebar button:hover {
    background-color: #d96200;
  }
  </style>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <section class="menu-section">
    <h2>Paket Menu</h2>

    <div class="filters">
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="breakfast">Energi Pagi</button>
      <button class="filter-btn" data-filter="lunch">Lunch Hero</button>
      <button class="filter-btn" data-filter="snack">Jajan Sehat</button>
      <button class="filter-btn" data-filter="safe">Happy Tummy</button>
      <button class="filter-btn" data-filter="nusantara">Nusantara Mini</button>
      <button class="filter-btn" data-filter="western">Western Fun</button>
      <button class="filter-btn" data-filter="vegan">Plant Power</button>
    </div>
    
    <!-- Breakfast -->
    <div class="menu-grid">
      <a href="../html-page/energi-roti-panggang.html" class="menu-card" data-category="breakfast">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Energi-Roti-Panggang.png" alt="Roti panggang alpukat + telor rebus" />
        </div>
        <h3>Roti Panggang Alpukat</h3>
        <p>Roti panggang alpukat + telor rebus</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/energi-bubur-ayam.html" class="menu-card" data-category="breakfast">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Energi-Bubur-Ayam.png" alt="Bubur ayam komplit" />
        </div>
        <h3>Bubur Ayam Komplit</h3>
        <p>Bubur ayam komplit</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/energi-roti-gandum.html" class="menu-card" data-category="breakfast">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Energi-Roti-Gandum.png" alt="Roti gandum + omelet" />
        </div>
        <h3>Roti Gandum & Omelet</h3>
        <p>Roti gandum + omelet</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/energi-oatmeal.html" class="menu-card" data-category="breakfast">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Energi-Oatmeal.png" alt="Oatmeal + pisang + madu + chiaseed" />
        </div>
        <h3>Oatmeal Komplit</h3>
        <p>Oatmeal + pisang + madu + chiaseed</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/energi-yogurt.html" class="menu-card" data-category="breakfast">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Energi-Yogurt.png" alt="Yogurt + madu + buah" />
        </div>
        <h3>Yogurt Segar</h3>
        <p>Yogurt + madu + buah</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!--Breakfast End -->
      
      <!-- Lunch -->
      <a href="../html-page/lunch-ayam-crispy.html" class="menu-card" data-category="lunch">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lunch-Ayam-Crispy.png" alt="Nasi ayam crispy + salad segar" />
        </div>
        <h3>Ayam Crispy & Salad</h3>
        <p>Nasi ayam crispy + salad segar</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/lunch-nasi-kuning.html" class="menu-card" data-category="lunch">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lunch-Nasi-Kuning.png" alt="Nasi kuning + telur dadar + tempe orek" />
        </div>
        <h3>Nasi Kuning Komplit</h3>
        <p>Nasi kuning + telur dadar + tempe orek</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/lunch-beef-teriyaki.html" class="menu-card" data-category="lunch">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lunch-Beef-Teriyaki.png" alt="Nasi beef teriyaki + brokoli kukus" />
        </div>
        <h3>Beef Teriyaki & Brokoli</h3>
        <p>Nasi beef teriyaki + brokoli kukus</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/lunch-nasi-uduk.html" class="menu-card" data-category="lunch">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lunch-Nasi-Uduk.png" alt="Nasi uduk ayam panggang + tempe + lalapan" />
        </div>
        <h3>Nasi Uduk Ayam Panggang</h3>
        <p>Nasi uduk ayam panggang + tempe + lalapan</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/lunch-ikan-dory.html" class="menu-card" data-category="lunch">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lunch-Ikan-Dory.png" alt="Nasi ikan dory crispy + sayur capcay" />
        </div>
        <h3>Ikan Dory & Capcay</h3>
        <p>Nasi ikan dory crispy + sayur capcay</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Lunch End -->

      <!-- Snack -->
      <a href="../html-page/jajan-pisang-coklat-keju.html" class="menu-card" data-category="snack">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Jajan-Pisang-Coklat-Keju.png" alt="Pisang Coklat Keju" />
        </div>
        <h3>Pisang Coklat Keju</h3>
        <p>Pisang panggang isi coklat & keju, manis dan lembut</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/jajan-macaroni-schotel.html" class="menu-card" data-category="snack">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Jajan-Macaroni-Schotel.png" alt="Macaroni Schotel" />
        </div>
        <h3>Macaroni Schotel</h3>
        <p>Macaroni panggang dengan keju dan daging cincang</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/jajan-banana-pancake.html" class="menu-card" data-category="snack">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Jajan-Banana-Pancake.png" alt="Banana Pancake" />
        </div>
        <h3>Banana Pancake</h3>
        <p>Pancake lembut dari pisang & gandum, disukai anak-anak</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/jajan-mini-pizza.html" class="menu-card" data-category="snack">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Jajan-Mini-Pizza.png" alt="Mini Pizza" />
        </div>
        <h3>Mini Pizza</h3>
        <p>Pizza mungil dengan topping sayur dan keju</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/jajan-tahu-pong-keju.html" class="menu-card" data-category="snack">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Jajan-Tahu-Pong-Keju.png" alt="Tahu Pong Keju" />
        </div>
        <h3>Tahu Pong Keju</h3>
        <p>Tahu isi keju, gurih dan sehat untuk ngemil</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Snack End -->

      <!-- Happy Tummy -->
      <a href="../html-page/happy-sup-ayam-lembut.html" class="menu-card" data-category="safe">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Happy-Sup-Ayam-Lembut.png" alt="Sup Ayam Lembut" />
        </div>
        <h3>Sup Ayam Lembut</h3>
        <p>Sup kaldu ayam dengan wortel dan kentang yang mudah dicerna</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/happy-pudding-oatmilk.html" class="menu-card" data-category="safe">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Happy-Puding-Oatmilk.png" alt="Puding Oatmilk" />
        </div>
        <h3>Puding Oatmilk</h3>
        <p>Puding lembut dari oat milk dan agar-agar, rendah gula dan laktosa</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/happy-bola-nasi-keju.html" class="menu-card" data-category="safe">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Happy-Bola-Nasi.png" alt="Bola Nasi Keju" />
        </div>
        <h3>Bola Nasi Keju</h3>
        <p>Nasi lembut dibentuk bola isi keju, menarik untuk picky eater</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/happy-macaroni-lembut-sayur.html" class="menu-card" data-category="safe">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Happy-Macaroni-Sayur.png" alt="Macaroni Lembut Sayur" />
        </div>
        <h3>Macaroni Lembut Sayur</h3>
        <p>Macaroni lembut dimasak dengan saus tomat manis & campuran sayur</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/happy-bubur-sumsum-kurma.html" class="menu-card" data-category="safe">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Happy-Bubur-Sumsum.png" alt="Bubur Sumsum Kurma" />
        </div>
        <h3>Bubur Sumsum Kurma</h3>
        <p>Bubur halus tanpa santan dengan topping kurma lembut dan madu</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Happy Tummy End-->

      <!-- Nusantara Mini-->
      <a href="../html-page/nusantara-nasi-uduk-mini.html" class="menu-card" data-category="nusantara">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Nasi-Uduk-Mini.png" alt="Nasi Uduk Mini" />
        </div>
        <h3>Nasi Uduk Mini</h3>
        <p>Nasi uduk lembut dengan telur dadar dan kerupuk mini, kaya rasa dan ringan</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/nusantara-bubur-manado-anak.html" class="menu-card" data-category="nusantara">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Bubur-Manado-Anak.png" alt="Bubur Manado Anak" />
        </div>
        <h3>Bubur Manado</h3>
        <p>Bubur khas Manado dengan sayur lembut dan ayam suwir, cocok untuk anak-anak</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/nusantara-lontong-mini-sayur.html" class="menu-card" data-category="nusantara">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Lontong-Mini.png" alt="Lontong Mini Sayur" />
        </div>
        <h3>Lontong Mini Sayur</h3>
        <p>Lontong kecil-kecil dengan sayur lodeh ringan dan tempe bacem mini</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/nusantara-ayam-kecap-manis.html" class="menu-card" data-category="nusantara">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Ayam-Kecap-Manis.png" alt="Ayam Kecap Manis" />
        </div>
        <h3>Ayam Kecap Manis</h3>
        <p>Ayam masak kecap manis gurih, disajikan dengan nasi dan wortel kukus</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/nusantara-perkedel-nasi.html" class="menu-card" data-category="nusantara">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Perkedel-Nasi.png" alt="Perkedel Nasi" />
        </div>
        <h3>Perkedel Nasi</h3>
        <p>Perkedel kentang isi ayam cincang dan nasi, bentuk menarik untuk anak</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Nusantara mini End -->

      <!-- Western Fun -->
      <a href="../html-page/western-mini-pasta.html" class="menu-card" data-category="western">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Mini-Pasta.png" alt="Mini Pasta Bolognese" />
        </div>
        <h3>Mini Pasta Bolognese</h3>
        <p>Pasta bolognese dengan saus tomat manis dan daging cincang, cocok untuk anak</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/western-macaroni-cheese.html" class="menu-card" data-category="western">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Mac-and-Cheese.png" alt="Mac & Cheese" />
        </div>
        <h3>Mac & Cheese</h3>
        <p>Macaroni lembut dengan saus keju creamy, tanpa MSG</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/western-chicken-finger.html" class="menu-card" data-category="western">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Chicken-Finger.png" alt="Chicken Finger & Veggie" />
        </div>
        <h3>Chicken Finger & Veggie</h3>
        <p>Potongan ayam renyah dengan sayur kukus dan kentang tumbuk</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/western-pizza-mini.html" class="menu-card" data-category="western">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Pizza-Mini.png" alt="Mini Pizza Sehat" />
        </div>
        <h3>Mini Pizza Sehat</h3>
        <p>Pizza roti gandum dengan topping sayur, keju, dan ayam</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/western-pancake-buah.html" class="menu-card" data-category="western">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Pancake-Buah.png" alt="Pancake Buah" />
        </div>
        <h3>Pancake Buah</h3>
        <p>Pancake lembut dengan topping madu dan potongan buah segar</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Western Fun End -->

      <!-- Vegan -->
      <a href="../html-page/vegan-nugget-sayur.html" class="menu-card" data-category="vegan">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Vegan-Nugget-Sayur.png" alt="Vegan Nugget Sayur" />
        </div>
        <h3>Vegan Nugget Sayur</h3>
        <p>Nugget dari sayuran dan tahu, dipanggang renyah tanpa pengawet</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/vegan-pasta-pesto.html" class="menu-card" data-category="vegan">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Vegan-Pasta-Pesto.png" alt="Pasta Pesto Vegan" />
        </div>
        <h3>Pasta Pesto Vegan</h3>
        <p>Pasta dengan saus pesto bayam dan kacang mete, tinggi serat dan zat besi</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/vegan-burger-mini.html" class="menu-card" data-category="vegan">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Vegan-Burger-Mini.png" alt="Mini Vegan Burger" />
        </div>
        <h3>Mini Vegan Burger</h3>
        <p>Roti gandum isi patty kacang merah dan sayur, tanpa mayones</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/vegan-pizza-sayur.html" class="menu-card" data-category="vegan">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Vegan-Pizza.png" alt="Pizza Sayur Vegan" />
        </div>
        <h3>Pizza Sayur Vegan</h3>
        <p>Pizza mini dengan saus tomat, jamur, paprika, dan keju vegan</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      
      <a href="../html-page/vegan-bola-energi.html" class="menu-card" data-category="vegan">
        <div class="plate-image">
          <img src="../Smarteats for Kids/Bola-Energi.png" alt="Bola Energi Kurma" />
        </div>
        <h3>Bola Energi Kurma</h3>
        <p>Camilan sehat dari kurma, oat, dan kacang-kacangan, tanpa gula tambahan</p>
        <button class="detail-btn">Lihat Detail</button>
      </a>
      <!-- Vegan End-->   
    </div>
    

    <div class="cart-icon" onclick="toggleCart()">
      <i data-feather="shopping-cart"></i>
      <span id="cart-count">0</span>
    </div>

    <div id="cart-sidebar" class="cart-sidebar hidden">
      <h2>Your Cart</h2>
      <ul id="cart-items"></ul>
      <p>Total: Rp <span id="cart-total">0</span></p>
      <button onclick="checkout()">Checkout</button>
    </div>

    <script>
      feather.replace();
    </script>
  </section>

  <script>
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuCards = document.querySelectorAll('.menu-card');
  
    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
  
        const filter = button.getAttribute('data-filter');
  
        menuCards.forEach(card => {
          const category = card.getAttribute('data-category');
          if (filter === 'all' || category === filter) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  </script>
  
</body>
</html>