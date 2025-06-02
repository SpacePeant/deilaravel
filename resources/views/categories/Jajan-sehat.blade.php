<?php


// Fetch all menu items with categories
$sql = "SELECT m.*, c.nama AS category_name 
        FROM menu m
        JOIN category c ON m.category_id = c.id
        WHERE m.category_id = 'jajan_sehat'
        ORDER BY c.id, m.id";
$result = $conn->query($sql);

// Group by category
$menuByCategory = [];
while ($row = $result->fetch_assoc()) {
    $category = $row['category_id'];
    if (!isset($menuByCategory[$category])) {
        $menuByCategory[$category] = [
            'category_name' => $row['category_name'],
            'items' => []
        ];
    }
    $menuByCategory[$category]['items'][] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Nutrition Facts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menu Item Styling */
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
        
        <?php foreach ($menuByCategory as $categoryId => $categoryData): ?>
            <h2 class="category-title"><?= htmlspecialchars($categoryData['category_name']) ?></h2>
            
            <div class="row">
                <?php foreach ($categoryData['items'] as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="menu-item-card">
                            <img src="images/<?= htmlspecialchars($item['gambar']) ?>" 
                                 alt="<?= htmlspecialchars($item['nama']) ?>" 
                                 class="menu-item-img">
                            
                            <div class="menu-item-body">
                                <h4><?= htmlspecialchars($item['nama']) ?></h4>
                                <p class="text-muted"><?= htmlspecialchars($item['deskripsi']) ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Rp <?= number_format($item['harga'], 0, ',', '.') ?></h5>
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#nutritionModal<?= $item['id'] ?>">
                                        Nutrition Facts
                                    </button>
                                </div>
                                
                                <div class="nutrition-badges">
                                    <span class="nutrition-badge"><?= $item['kalori'] ?> kcal</span>
                                    <span class="nutrition-badge"><?= $item['protein'] ?>g protein</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nutrition Modal for this item -->
                    <div class="modal fade" id="nutritionModal<?= $item['id'] ?>" tabindex="-1" 
                         aria-labelledby="nutritionModalLabel<?= $item['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nutritionModalLabel<?= $item['id'] ?>">
                                        Nutrition Facts: <?= htmlspecialchars($item['nama']) ?>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" 
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <h6>Description</h6>
                                    <p><?= htmlspecialchars($item['deskripsi']) ?></p>
                                    
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
                                                <td><?= $item['kalori'] ?> kcal</td>
                                            </tr>
                                            <tr>
                                                <td>Carbohydrates</td>
                                                <td><?= $item['karbohidrat'] ?>g</td>
                                            </tr>
                                            <tr>
                                                <td>Protein</td>
                                                <td><?= $item['protein'] ?>g</td>
                                            </tr>
                                            <tr>
                                                <td>Sodium</td>
                                                <td><?= $item['sodium'] ?>mg</td>
                                            </tr>
                                            <tr>
                                                <td>Sugar</td>
                                                <td><?= $item['gula'] ?>g</td>
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
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>