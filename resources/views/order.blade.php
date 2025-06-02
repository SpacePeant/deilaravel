<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/MENU.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="food-cart">
        <h2>Paket Menu</h2>

        <div class="backbutt">
            <a href="{{ route('home') }}">
                <button>Back</button>
            </a>
        </div>

        {{-- <h2>Hari yang dipilih: {{ $day }}</h2> --}}

    <div class="filter-section" style="margin-bottom: 20px;">
        <form action="{{ url()->current() }}" method="GET">
            <label for="category_filter">Filter by Category:</label>
            <select name="category_id" id="category_filter" onchange="this.form.submit()">
                <option value="">All Categories</option> @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $selectedCategoryIdFromDropdown == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }} 
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="day" value="{{ $day }}">
            </form>
    </div>

    <div class="menu" id="menu-container">
        @foreach ($pakets as $paket)
            <a href="{{ route('order.show', ['paket' => $paket->id, 'day' => $day]) }}" class="food-box">
                <div class="menu-card">
                    <div class="circle-image">
                        <img src="{{ asset('images_makanan/' . $paket->gambar) }}" alt="{{ $paket->nama }}">
                    </div>
                    <div class="menu-details">
                        <span class="label">Paket</span>
                        <h3>{{ $paket->nama }}</h3>
                        <p>{{ $paket->deskripsi }}</p>
                        <button>Lihat Detail</button>
                        
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    </section>
</body>
</html>
