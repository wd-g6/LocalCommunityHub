<?php

$categories_data = [
    1 => ['id' => 1, 'name' => 'Healthcare',        'icon_class' => 'fa-solid fa-notes-medical'],
    2 => ['id' => 2, 'name' => 'Food Banks',        'icon_class' => 'fa-solid fa-utensils'],
    3 => ['id' => 3, 'name' => 'Community Centers', 'icon_class' => 'fa-solid fa-people-roof'],
    4 => ['id' => 4, 'name' => 'Education',         'icon_class' => 'fa-solid fa-book-open-reader'],
    5 => ['id' => 5, 'name' => 'Legal Aid',         'icon_class' => 'fa-solid fa-gavel']
];

$resources_data = [];

$selected_category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$filtered_resources = [];

if ($selected_category_id > 0) {
    $resource_count = count($resources_data);
    for ($i = 0; $i < $resource_count; $i++) {
        if ($resources_data[$i]['category_id'] == $selected_category_id) {
            $filtered_resources[] = $resources_data[$i];
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Community Hub | Final Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-body-tertiary">
    <header class="text-white p-3 shadow-sm" style="background-color: #2d3250;">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="admin/img/sto tomas.jpg" alt="Community Hub Logo" class="header-logo me-3">
                <div>
                    <h1><a href="" class="text-white text-decoration-none">Local Community Hub</a></h1>
                    <p class="lead mb-0">Your guide to local resources and services (Sto.Tomas, Batangas)</p>
                </div>
            </div>
            <div>
                <button id="modeButton" class="btn btn-light" onclick="changeMode()">Dark Mode</button>
            </div>
        </div>
    </header>

    <main class="flex-shrink-0">
        <div class="container py-4">
            <div class="card mb-4" style="background-color: #fdb17a;">
                <div class="card-body">
                    <form action="" method="GET" class="d-flex align-items-center">
                        <label for="category-filter" class="form-label me-2 mb-0 fw-bold">Filter by Category:</label>
                        <select name="category" id="category-filter" class="form-select w-auto me-2">
                            <option value="0">All Categories</option>
                            <?php 
                                $category_keys = array_keys($categories_data);
                                for ($i = 0; $i < count($category_keys); $i++) {
                                    $key = $category_keys[$i];
                                    $category = $categories_data[$key];
                            ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo
                                ($selected_category_id==$category['id']) ? 'selected' : '' ; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-primary d-none">Filter</button>
                    </form>
                </div>
            </div>

            <section class="resource-list">
                <h2 class="pb-2 border-bottom mb-4">
                    <?php echo htmlspecialchars($page_title); ?>
                </h2>

                <div class="alert alert-warning" role="alert">
                    No resources found for the selected category.
                </div>
            </section>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-white" style="background-color: #2d3250;">
        <div class="container text-center">
            <span>©
                <?php echo date('Y'); ?> Local Community Hub.
                <a href="admin/index.php" class="text-white-50">Admin Login</a>
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let mode = "light";

        function changeMode() {
            const body = document.body;
            const btnMode = document.getElementById("modeButton");

            mode = (mode == "light") ? "dark" : "light";

            const btnText = (mode == "dark") ? "Light Mode" : "Dark Mode";
            const btnClass = (mode == "dark") ? "btn-light" : "btn-dark";

            btnMode.classList.remove("btn-light", "btn-dark");
            btnMode.classList.add(btnClass);
            btnMode.innerHTML = btnText;

            body.setAttribute("data-bs-theme", mode);
        }

        var filter = document.getElementById('category-filter');
        if (filter) {
            filter.addEventListener('change', function () {
                this.form.submit();
            });
        }
    </script>
</body>

</html>