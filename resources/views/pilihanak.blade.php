<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Data Anak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
      .child-card {
        cursor: pointer;
        border-radius: 1rem;
        transition: transform 0.2s;
      }
      .child-card:hover {
        transform: scale(1.02);
      }
      .child-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
      }
    </style>
  </head>
  <body class="bg-light">
    @include('includes.header') 

    <div class="container py-5">
      <h2 class="mb-4">Pilih Anak</h2>
      <div class="row row-cols-1 row-cols-md-2 g-4" id="childList">
        @foreach ($children as $child)
          @php
            $imgSrc = $child->gender === 'L' ? asset('images/cowok.png') : asset('images/cewek.png');
          @endphp
          <div class="col">
            <div onclick="selectChild({{ $child->id }}, '{{ $child->nama }}')" class="text-decoration-none text-dark">
              <div class="card p-3 shadow-sm child-card">
                <div class="d-flex align-items-center">
                  <img src="{{ $imgSrc }}" alt="Foto Anak" class="child-img me-3" />
                  <div>
                    <h5 class="mb-1">{{ $child->nama }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <script>
      function selectChild(id, name) {
        sessionStorage.setItem("selectedChild", JSON.stringify({ id, name }));
        window.location.href = "/hari?id=" + id + "&name=" + encodeURIComponent(name);
      }
    </script>

    <script>feather.replace();</script>
  </body>
</html>
