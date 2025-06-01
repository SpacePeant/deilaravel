<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu Mingguan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .menu-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .menu-image {
      width: 100%;
      height: auto;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .menu-options {
      font-size: 0.9em;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Menu Mingguan</h2>
    <div id="menu-container"></div>
  </div>

  <script>
    // Ambil data dari cart.json
    fetch('cart.json')
      .then(response => response.json())
      .then(data => displayWeeklyMenu(data))
      .catch(error => console.error('Gagal memuat data:', error));

    function displayWeeklyMenu(menuData) {
      const container = document.getElementById('menu-container');
      container.innerHTML = ''; // Kosongkan dulu

      for (const day in menuData) {
        const dayName = capitalizeFirstLetter(day);
        const items = menuData[day];

        const daySection = document.createElement('div');
        daySection.classList.add('mb-5');

        const header = document.createElement('h4');
        header.textContent = dayName;
        daySection.appendChild(header);

        const row = document.createElement('div');
        row.classList.add('row');

        items.forEach(item => {
          const col = document.createElement('div');
          col.className = 'col-md-6 col-lg-4';

          const card = document.createElement('div');
          card.className = 'menu-card';

          // Gambar (gunakan placeholder jika tidak ada)
          const img = document.createElement('img');
          img.src = `images/${item.image}`;
          img.alt = item.name;
          img.className = 'menu-image';

          const title = document.createElement('h5');
          title.textContent = item.name;

          const price = document.createElement('p');
          price.innerHTML = `<strong>Rp${item.price.toLocaleString()}</strong>`;

          const options = document.createElement('div');
          options.className = 'menu-options';
          options.innerHTML = Object.entries(item.options).map(([key, value]) => `${key}: ${value}`).join('<br>');

          const drink = document.createElement('p');
          drink.innerHTML = `<strong>Minuman:</strong> ${item.minuman}`;

          card.appendChild(img);
          card.appendChild(title);
          card.appendChild(price);
          card.appendChild(options);
          card.appendChild(drink);
          col.appendChild(card);
          row.appendChild(col);
        });

        daySection.appendChild(row);
        container.appendChild(daySection);
      }
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
