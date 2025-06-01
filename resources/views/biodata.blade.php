<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lengkapi Profil</title>
    <link rel="stylesheet" href="login.css" />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }

      body,
      html {
        height: 100%;
      }

      section {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url("img/log.jpg") no-repeat;
        background-size: cover;
      }

      .form-box {
        background: #ffffffcc;
        padding: 10px 60px;
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        width: 700px;
        height: 600px;
      }

      h2 {
        text-align: center;
        margin-bottom: 45px;
        font-size: 2em;
        color: #333;
      }

      .inputbox {
        position: relative;
        margin: 35px 0;
        width: 500px;
      }

      .inputbox input {
        width: 100%;
        padding: 10px 0; /* hilangkan padding kiri/kanan */
        font-size: 1.1em;
        border: none;
        border-bottom: 2px solid #999;
        background: transparent;
        outline: none;
        color: #333;
      }

      .inputbox label {
        position: absolute;
        left: 0;
        top: 10px;
        padding-left: 0;
        color: #666;
        pointer-events: none;
        transition: 0.3s;
        background: transparent;
      }

      .inputbox input:focus ~ label,
      .inputbox input:valid ~ label {
        top: -12px;
        font-size: 0.85em;
        color: #333;
      }

      button {
        width: 100%;
        padding: 14px;
        background: #333;
        color: white;
        border: none;
        border-radius: 30px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 30px;
        margin-bottom: 15px;
      }

      button:hover {
        background: #555;
      }
    </style>
  </head>
  <body>
    <section>
      <div class="form-box">
        <form id="profileForm">
          <h2>Data Orang Tua</h2>

          <div class="inputbox">
            <input type="text" id="fullname" required />
            <label>Nama Lengkap</label>
          </div>

          <div class="inputbox">
            <input type="tel" id="phone" required />
            <label>Nomor Telepon</label>
          </div>

          <div class="inputbox">
            <input type="text" id="address" required />
            <label>Alamat</label>
          </div>

          <button type="submit">Simpan Profil</button>
        </form>
      </div>
    </section>

    <script>
      const form = document.getElementById("profileForm");

      form.addEventListener("submit", function (e) {
        e.preventDefault();

        const fullName = document.getElementById("fullname").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const address = document.getElementById("address").value.trim();

        // Ambil data user yang sedang login
        const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
        if (!currentUser) {
          alert("User tidak ditemukan, silakan login ulang.");
          window.location.href = "login.html";
          return;
        }

        // Update data user yang sedang login
        currentUser.nama = fullName;
        currentUser.telepon = phone;
        currentUser.alamat = address;

        // Update ke localStorage (update array users)
        const users = JSON.parse(localStorage.getItem("users")) || [];
        const userIndex = users.findIndex((u) => u.email === currentUser.email);
        if (userIndex !== -1) {
          users[userIndex] = currentUser;
          localStorage.setItem("users", JSON.stringify(users));
          sessionStorage.setItem("currentUser", JSON.stringify(currentUser));
          alert("Profil berhasil disimpan!");
          window.location.href = "home.php";
        } else {
          alert("User tidak ditemukan dalam database.");
        }
      });
    </script>
  </body>
</html>
