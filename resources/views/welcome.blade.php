<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  </head>
  
  <body>
    <section>
      <div class="form-box">
        <div class="form-value">
          <form id="loginForm">
            <h2>Login</h2>
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="email" id="email" required />
              <label>Email</label>
            </div>
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" id="password" required />
              <label>Password</label>
            </div>
            <div class="forget">
              <label><input type="checkbox" /> Remember me</label>
              <label><a href="#">Forgot password?</a></label>
            </div>
            <button type="submit">Log in</button>
            <div class="register">
              <p>Don't have an account? <a href="register.html">Register</a></p>
            </div>
          </form>
        </div>
      </div>
    </section>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <script>
      if (!localStorage.getItem("users")) {
        let users = [
          {
            email: "ber@gmail.com",
            password: "ber123",
            nama: "Bernard",
            telepon: "082247947700",
            alamat: "Universitas Ciputra",
          },
        ];
        localStorage.setItem("users", JSON.stringify(users));
      }

      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault(); // Mencegah reload
          const email = document.getElementById("email").value.trim();
          const password = document.getElementById("password").value.trim();

          const users = JSON.parse(localStorage.getItem("users")) || [];
          const user = users.find(
            (u) => u.email === email && u.password === password
          );

          if (user) {
            alert("Login berhasil!");

            // Simpan data user yang login ke sessionStorage (untuk digunakan di halaman lain)
            sessionStorage.setItem("currentUser", JSON.stringify(user));

            if (!user.nama || !user.telepon || !user.alamat) {
              window.location.href = "biodata.php"; // Lengkapi data dulu
            } else {
              window.location.href = "home.php"; // Sudah lengkap
            }
          } else {
            alert("Email atau password salah!");
          }
        });
    </script>
  </body>
</html>
