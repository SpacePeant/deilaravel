<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Data Anak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      .plus-card {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 48px;
        color: #198754;
        border: 2px dashed #198754;
        height: 250px;
        border-radius: 1rem;
        transition: background-color 0.2s;
      }
      .plus-card:hover {
        background-color: #eafaf1;
      }
    </style>
  </head>
  <body class="bg-light">
    @include('includes.header')

    <div class="container py-5">
      <h2 class="mb-4">Data Anak</h2>
      <div class="row row-cols-1 row-cols-md-2 g-4" id="childList">
        @foreach ($children as $child)
    <div class="col">
      <a href="{{ route('anak.show', $child->id) }}" class="text-decoration-none text-dark">
        <div class="card p-3 shadow-sm child-card">
          <div class="d-flex align-items-center">
            <img src="{{ asset($child->gender == 'L' ? 'images/cowok.png' : 'images/cewek.png') }}" class="child-img me-3" />
            <div>
              <h5 class="mb-1">{{ $child->nama }}</h5>
            </div>
          </div>
        </div>
      </a>
    </div>
@endforeach


        <!-- Tombol untuk menambah anak -->
        <div class="col">
          <a href="{{ route('add') }}" class="text-decoration-none">
            <div class="plus-card w-100 h-100">
              +
            </div>
          </a>
        </div>
      </div>
    </div>

    <script>
      feather.replace();
    </script>
  </body>
</html>
