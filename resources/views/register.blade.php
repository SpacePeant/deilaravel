<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  </head>
  <body>
    <section>
      <div class="form-box">
        <div class="form-value">
          <form id="registerForm">
            <h2>Register</h2>
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
            </div>
            <button type="submit">Register</button>
            <div class="register">
              <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
          </form>
        </div>
      </div>
    </section>

    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <script>
      document
        .getElementById("registerForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const email = document.getElementById("email").value.trim();
          const password = document.getElementById("password").value.trim();

          let users = JSON.parse(localStorage.getItem("users")) || [];

          const existingUser = users.find((u) => u.email === email);
          if (existingUser) {
            alert("Email sudah terdaftar!");
            return;
          }

          users.push({
            email,
            password,
            nama: "",
            telepon: "",
            alamat: "",
          });

          localStorage.setItem("users", JSON.stringify(users));
          alert("Registrasi berhasil! Silakan login.");
          window.location.href = "login.html";
        });
    </script>
  </body>
</html>
