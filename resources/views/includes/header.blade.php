<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://unpkg.com/feather-icons"></script>
<header id="mainHeader" class="transparent">
  <div class="logo">
    <img src="img/logo.png" alt="" />
  </div>
  <nav>
    <ul>
      <li class="home"><a href="{{ route('home') }}">Home</a></li>
      <li class="anak"><a href="{{ route('anak') }}">Anak</a></li>
      <li class="menu"><a href="{{ route('menu') }}">Menu</a></li>
      <li class="order"><a href="{{ route('order') }}">Order</a></li>
      <li class="od"><a href="{{ route('order_details') }}">Order Details</a></li>

    </ul>
  </nav>
  <div style="display: flex; align-items: center; gap: 20px">
    <button class="contact-button">Contact Us →</button>
    <div class="icon">

      <div class="user-dropdown">
        <a href="#" id="userIcon"><i data-feather="user"></i></a>
        <div class="user-dropdown-menu" id="userDropdown">
          <p id="userName">Nama User</p>
          <button>Help</button>
          <button>Send Feedback</button>
          <button>FAQ</button>
          <button onclick="logout()" class="log">Logout</button>
        </div>
      </div>
    </div>
  </div>
</header>
<div class="awal"></div>

<script>
      window.addEventListener("scroll", function () {
        const header = document.getElementById("mainHeader");
        if (window.scrollY > 400) {
          // 100px bisa kamu sesuaikan
          header.classList.add("scrolled");
        } else {
          header.classList.remove("scrolled");
        }
      });
    </script>

    <script>
      const currentLocation = window.location.href;
      const menuItems = document.querySelectorAll("nav ul li a");

      menuItems.forEach((item) => {
        if (item.href === currentLocation) {
          item.parentElement.classList.add("active");
        }
      });
    </script>

    <!-- JavaScript -->
    <script>
      // Toggle dropdown
      const userIcon = document.getElementById("userIcon");
      const userDropdown = document.getElementById("userDropdown");

      userIcon.addEventListener("click", function (e) {
        e.preventDefault();
        userDropdown.classList.toggle("show");
      });

      // Ambil nama user dari sessionStorage
      const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
      if (currentUser && currentUser.nama) {
        document.getElementById("userName").textContent =
          "Hi, " + currentUser.nama + "!";
      }

      // Logout function
      function logout() {
        sessionStorage.removeItem("currentUser");
        window.location.href = "login.html";
      }

      // Tutup dropdown saat klik di luar
      document.addEventListener("click", function (e) {
        if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
          userDropdown.style.display = "none";
        }
      });
      document.addEventListener("click", function (e) {
        if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
          userDropdown.classList.remove("show");
        }
      });
    </script>
     <script>
      feather.replace();
    </script>