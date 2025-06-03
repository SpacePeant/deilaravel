

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Nutrition Facts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your CSS styles here */
        .menu-item-card {
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .menu-item-card:hover {
            transform: translateY(-5px);
        }
        .menu-item-img {
            height: 350px;
            object-fit: cover;
            width: 100%;
        }
        .menu-item-body {
            padding: 15px;
        }
        .category-title {
            color: #738e2a;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #738e2a;
        }

        /* Nutrition Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .modal-header {
            background-color: #738e2a;
            color: white;
            border-radius: 15px 15px 0 0;
            border-bottom: none;
        }
        .nutrition-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        .nutrition-table th,
        .nutrition-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .nutrition-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .nutrition-table tr:last-child td {
            border-bottom: none;
        }
        .nutrition-badge {
            background: #e9f5db;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-right: 5px;
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
<body>
    <a href="javascript:history.back()" class="back-button">← Back</a>

    <div class="container py-4">
        <h1 class="text-center mb-4">Our Menu</h1>

        {{-- Loop through categories with their associated menu items --}}
        @foreach ($categoriesWithMenus as $category)
         
            {{-- Only display category title if it has menu items --}}
            @if ($category->menus->isNotEmpty())
             
                <h2 class="category-title">{{ htmlspecialchars($category->nama) }}</h2>
                
                <div class="row">
                    @foreach ($category->menus as $item)
                        <div class="col-md-4 mb-4">
                            <div class="menu-item-card">
                                {{-- Use asset() helper for images, assuming they are in public/images/ --}}
                                <img src="{{ asset('images/' . $item->gambar) }}"
                                     alt="{{ htmlspecialchars($item->nama) }}"
                                     class="menu-item-img">
                                     <?php echo("tai"); ?>
                                
                                <div class="menu-item-body">
                                    <h4>{{ htmlspecialchars($item->nama) }}</h4>
                                    <p class="text-muted">{{ htmlspecialchars($item->deskripsi) }}</p>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        {{-- Assuming 'harga' is the price column --}}
                                        <h5 class="mb-0">Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</h5>
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#nutritionModal{{ $item->id }}">
                                            Nutrition Facts
                                        </button>
                                    </div>

                                    <div class="nutrition-badges">
                                        {{-- Assuming kalori, protein, etc., are direct columns --}}
                                        <span class="nutrition-badge">{{ $item->kalori ?? 0 }} kcal</span>
                                        <span class="nutrition-badge">{{ $item->protein ?? 0 }}g protein</span>
                                        {{-- Add other nutrition badges as needed --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="nutritionModal{{ $item->id }}" tabindex="-1"
                             aria-labelledby="nutritionModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nutritionModalLabel{{ $item->id }}">
                                            Nutrition Facts: {{ htmlspecialchars($item->nama) }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <h6>Description</h6>
                                        <p>{{ htmlspecialchars($item->deskripsi) }}</p>

                                        <table class="table nutrition-table">
                                            <thead>
                                                <tr>
                                                    <th>Nutrition Component</th>
                                                    <th>Amount (per serving)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Calories</td>
                                                    <td>{{ $item->kalori ?? 0 }} kcal</td>
                                                </tr>
                                                <tr>
                                                    <td>Carbohydrates</td>
                                                    <td>{{ $item->karbohidrat ?? 0 }}g</td>
                                                </tr>
                                                <tr>
                                                    <td>Protein</td>
                                                    <td>{{ $item->protein ?? 0 }}g</td>
                                                </tr>
                                                <tr>
                                                    <td>Sodium</td>
                                                    <td>{{ $item->sodium ?? 0 }}mg</td>
                                                </tr>
                                                <tr>
                                                    <td>Sugar</td>
                                                    <td>{{ $item->gula ?? 0 }}g</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="text-center mt-3">
                                            <small class="text-muted">* Percent Daily Values are based on a 2000 calorie diet</small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>