<?php
require_once 'data.php';

$selected_category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$filtered_resources = [];

if ($selected_category_id > 0) {
    foreach ($resources_data as $resource) {
        if ($resource['category_id'] == $selected_category_id) {
            $filtered_resources[] = $resource;
        }
    }
} else {
    $filtered_resources = $resources_data; 
}
$page_title = $selected_category_id > 0 && isset($categories_data[$selected_category_id])
    ? $categories_data[$selected_category_id]['name']
    : 'All Resources';
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Community Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .card-header i {
            color: #0d6efd; 
        }
        .category-tag {
            font-size: 0.85rem;
        }
    </style>
</head>
<body class="d-flex flex-column h-100 bg-body-tertiary">
    <header class="bg-dark text-white p-3 shadow-sm">
        <div class="container">
            <h1><a href="index.php" class="text-white text-decoration-none">Local Community Hub</a></h1>
            <p class="lead mb-0">Your guide to local resources and services (Sto.Tomas, Batangas)</p>
        </div>
    </header>

    <main class="flex-shrink-0">
        <div class="container py-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="index.php" method="GET" class="d-flex align-items-center">
                        <label for="category-filter" class="form-label me-2 mb-0 fw-bold">Filter by Category:</label>
                        <select name="category" id="category-filter" class="form-select w-auto me-2">
                            <option value="0">All Categories</option>
                            <?php foreach ($categories_data as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo ($selected_category_id == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>

            <section class="resource-list">
                <h2 class="pb-2 border-bottom mb-4"><?php echo htmlspecialchars($page_title); ?></h2>

                <?php if (count($filtered_resources) > 0): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($filtered_resources as $resource): ?>
                            <?php $category = $categories_data[$resource['category_id']]; ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header bg-light d-flex align-items-center">
                                        <i class="<?php echo htmlspecialchars($category['icon_class']); ?> fs-4 me-3"></i>
                                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($resource['name']); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><?php echo htmlspecialchars($resource['description']); ?></p>
                                    </div>
                                    <div class="card-footer text-end">
                                        <span class="badge bg-secondary category-tag"><?php echo htmlspecialchars($category['name']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        No resources found for the selected category.
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('category-filter');
            const filterForm = document.querySelector('.filters form, .card-body form'); 
            if (categoryFilter) {
                const filterButton = filterForm.querySelector('button');
                if (filterButton) { 
                    filterButton.classList.add('d-none');
                }
                categoryFilter.addEventListener('change', function() {
                    filterForm.submit();
                });
            }
        });
    </script>
</body>
</html>