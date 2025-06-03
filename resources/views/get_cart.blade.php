

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
  /* (Gaya CSS tetap seperti yang Anda buat sebelumnya, tidak diubah) */
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

  .jum{
    border-radius: 25px;
    padding: 3px 15px 3px 15px;
    font-size: 13px;
  }
  .menu-container {
    display: none;
    margin-top: 16px;
}

.menu-kotak {
    display: flex;
    margin-bottom: 16px;
    background-color: #ffffff;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    position: relative;
}

.menu-image-cont {
    width: 100px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 30px;  /* Tambahkan margin kanan */
}

.menu-image-cont img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.menu-inf {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.menu-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.menu-pri {
    font-weight: bold;
    color: #333;
    font-size: 16px;
    position: absolute;
    top: 16px;
    right: 16px;
}

.menu-opt ul {
    margin: 0;
    padding-left: 20px;
    list-style-type: none;
}

.quantity-control {
    position: absolute;
    bottom: 12px;
    right: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 4px;
    background-color: #ddd;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.menu-right-bottom {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.menu-kotak{
  align-items: center;
}

.menu-image-cont img{
  width: 150%;
  height: 150%;
}
.menu-image-cont{
  margin: 0px 60px 0px 60px;
}
  .back-button {
      display: inline-block;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 6px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 20px;
      transition: background-color 0.3s ease;
    }

    .back-button:hover {
      background-color: #218838;
    }

  </style>
</head>
<body class="container mt-4">
<a href="javascript:history.back()" class="back-button">← Back</a>

  <section class="menu-section">
    <h2>Paket Menu</h2>

    <!-- Filter Buttons -->
    <div class="filters">
        <button class="filter-btn active" data-filter="all">Semua</button>
        @foreach ($categories as $category)
            <button class="filter-btn" data-filter="{{ $category->id_cat }}">
                {{ $category->name_cat }}
            </button>
        @endforeach
    </div>
  </section>

  <!-- Menu Cards -->
    <div class="menu-grid">
    <?php foreach ($men as $index => $menu): ?>
    <?php
    // Hitung jumlah item menu ini dalam cart
    $stmt = $conn->prepare("
        SELECT COUNT(*) AS jumlah 
        FROM cart c
        WHERE c.child_id = ? AND c.day_of_week = ? AND c.menu_id = ?
    ");
    $ha = $_GET['day'] ?? '';
    $day = strtolower(trim($ha));
    $stmt->bind_param("isi", $id_anak, $day, $menu['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $jumlah = ($row = $result->fetch_assoc()) ? $row['jumlah'] : 0;
    ?>
    
    <!-- Tombol Menu / Card -->
    <div class="menu-card" data-category="<?= htmlspecialchars($menu['category_id']) ?>">
        <div class="plate-image">
            <img src="images/<?= htmlspecialchars($menu['image']) ?>" alt="<?= htmlspecialchars($menu['name']) ?>" />
            
            <?php if ($jumlah > 0): ?>
              <button class="jum" data-id="<?= $menu['id'] ?>"
              data-bs-toggle="modal" data-bs-target="#modalCart"><?= $jumlah ?> item</button>
            <?php endif; ?>
        </div>
        <div>
            <h3><?= htmlspecialchars($menu['name']) ?></h3>
            <p><?= htmlspecialchars($menu['description']) ?></p>
            <p><strong>Rp <?= htmlspecialchars(number_format($menu['price'], 0, ',', '.')) ?></strong></p>
            <button class="detail-btn" data-bs-toggle="modal" data-bs-target="#modal<?= $index ?>">Tambah</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal<?= $index ?>" tabindex="-1" aria-labelledby="modalLabel<?= $index ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel<?= $index ?>">Kustomisasi - <?= htmlspecialchars($menu['name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($menu['customizations'] as $kategori => $opsiList): ?>
                        <div class="mb-3">
                            <label class="form-label"><?= htmlspecialchars($kategori) ?></label>
                            <select name="custom_<?= htmlspecialchars($kategori) ?>" class="form-select" required>
                                <option value="">Pilih opsi</option>
                                <?php foreach ($opsiList as $opsi): ?>
                                    <option value="<?= htmlspecialchars($opsi) ?>"><?= htmlspecialchars($opsi) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" name="note" rows="2" placeholder="Contoh: tanpa timun, pedas banget, lombok dipisah"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Pengantaran</label>
                        <textarea class="form-control" name="delivery_address" rows="2" required placeholder="Masukkan alamat lengkap..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Pengantaran</label>
                        <select class="form-select" name="delivery_time" required>
                            <option value="">Pilih Jam</option>
                            <option value="07:00">07:00 WIB</option>
                            <option value="12:00">12:00 WIB</option>
                            <option value="18:00">18:00 WIB</option>
                        </select>
                    </div>

                    <input type="hidden" name="name" value="<?= htmlspecialchars($menu['name']) ?>">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($menu['image']) ?>">
                    <input type="hidden" name="price" value="<?= (int)$menu['price'] ?>">
                    <input type="hidden" name="day" value="<?= htmlspecialchars($day) ?>">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input type="hidden" name="child_id" value="<?= $id_anak ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah ke Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Cart Details -->
<?php if (isset($data_per_hari[$day]) && !empty($data_per_hari[$day])): ?>
<div class="modal fade" id="modalCart" tabindex="-1" aria-labelledby="modalCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCartLabel">Detail Menu Hari <?= ucfirst($day) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Input Hidden untuk Menu ID -->
                <input type="hidden" id="modalMenuId" value="">

                <?php foreach ($data_per_hari[$day] as $cartItem): 
                    // Pastikan $cartItem['aidi'] dibandingkan dengan nilai menu_id yang dipassing
                    ?>
                    <div class="menu-kotak" data-cart-id="<?= $cartItem['aidi'] ?>">
                        <div class="menu-image-cont">
                            <img src="images/<?= htmlspecialchars($cartItem['gambar']) ?>" alt="<?= htmlspecialchars($cartItem['menu_name']) ?>">
                        </div>
                        <div class="menu-inf">
                            <div class="menu-head">
                                <h4><?= htmlspecialchars($cartItem['menu_name']) ?></h4>
                                <div class="menu-pri">Rp <?= number_format($cartItem['harga'], 0, ',', '.') ?></div>
                            </div>

                            <div class="menu-opt">
                                <ul>
                                    <?php 
                                    // Mengambil dan menampilkan opsi kustomisasi
                                    $options = json_decode($cartItem['options'], true);
                                    foreach ($options as $key => $value): ?>
                                        <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <p><strong>Alamat:</strong> <?= htmlspecialchars($cartItem['alamat']) ?></p>
                            <p><strong>Jam Pengiriman:</strong> <?= htmlspecialchars($cartItem['jam_pengantaran']) ?></p>

                            <?php if (!empty($cartItem['note'])): ?>
                                <div class="tulis"><strong>Catatan:</strong></div>
                                <div class="note-container">
                                    <textarea class="note-textarea" readonly><?= htmlspecialchars($cartItem['note']) ?></textarea>
                                </div>
                            <?php endif; ?>

                            <div class="menu-ki" data-cart-id="<?= $cartItem['cart_id'] ?>">
                              <div class="quantity-control">
                                  <button class="qty-btn minus">−</button>
                                  <span class="qty"><?= $cartItem['quantity'] ?></span>
                                  <button class="qty-btn plus">+</button>
                              </div>
                          </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php endforeach; ?>

    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".menu-ki").forEach(function (menuBox) {
    const cartId = menuBox.getAttribute("data-cart-id");

    // Debugging log untuk memastikan cartId didapatkan
    console.log(cartId);  // Periksa apakah cartId benar-benar ada

    const qtySpan = menuBox.querySelector(".qty");

    menuBox.querySelector(".qty-btn.plus").addEventListener("click", function () {
        updateQuantity(cartId, 1, qtySpan);
    });

    menuBox.querySelector(".qty-btn.minus").addEventListener("click", function () {
        updateQuantity(cartId, -1, qtySpan);
    });
});
    function updateQuantity(cartId, change, qtySpan) {
        fetch("update_quantity.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `cart_id=${cartId}&change=${change}`
        })
        .then(res => res.json())
.then(data => {
    console.log(data);  // Debugging response
    if (data.success) {
        qtySpan.textContent = data.new_quantity;
    } else {
        alert("Gagal mengupdate jumlah.");
    }
});
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const jumButtons = document.querySelectorAll(".jum");

    jumButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const menuId = this.getAttribute("data-id");

            // Set ke input hidden (jika dibutuhkan)
            const modalMenuIdInput = document.getElementById("modalMenuId");
            if (modalMenuIdInput) {
                modalMenuIdInput.value = menuId;
            }

            // Seleksi semua elemen menu-kotak
            const allMenus = document.querySelectorAll(".menu-kotak");
            allMenus.forEach(function (menu) {
                const cartMenuId = menu.getAttribute("data-cart-id");

                // Tampilkan hanya yang cocok
                if (cartMenuId === menuId) {
                    menu.style.display = "flex"; // atau "block" tergantung layout kamu
                } else {
                    menu.style.display = "none";
                }
            });
        });
    });
});

</script>

  <!-- Filter Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const filterButtons = document.querySelectorAll('.filter-btn');

      filterButtons.forEach(button => {
        button.addEventListener('click', () => {
          document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');

          const filter = button.getAttribute('data-filter');
          const menuCards = document.querySelectorAll('.menu-card');

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
    });
  </script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const buttons = document.querySelectorAll(".btn-view-cart-item");

  buttons.forEach(button => {
    button.addEventListener("click", function() {
      document.getElementById("modalMenuName").textContent = this.dataset.menu;
      document.getElementById("modalQty").textContent = this.dataset.qty;

      // Options
      const optionsList = document.getElementById("modalOptions");
      optionsList.innerHTML = "";
      try {
        const options = JSON.parse(this.dataset.options);
        for (const key in options) {
          const li = document.createElement("li");
          li.textContent = `${key}: ${options[key]}`;
          optionsList.appendChild(li);
        }
      } catch (e) {
        optionsList.innerHTML = "<li>(tidak ada opsi)</li>";
      }

      // Alamat, jam, dan note
      document.getElementById("modalAlamat").textContent = this.dataset.alamat;
      document.getElementById("modalJam").textContent = this.dataset.jam;
      document.getElementById("modalNote").value = this.dataset.note || "(Tidak ada catatan)";
    });
  });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".menu-kotak").forEach(menuBox => {
    const cartId = menuBox.dataset.cartId;
    const minusBtn = menuBox.querySelector(".qty-btn.minus");
    const plusBtn = menuBox.querySelector(".qty-btn.plus");
    const qtySpan = menuBox.querySelector(".qty");

    minusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      if (qty > 1) {
        qty--;
        qtySpan.textContent = qty;
      }
    });

    plusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      qty++;
      qtySpan.textContent = qty;
    });
  });
});
</script>
</body>
</html>

