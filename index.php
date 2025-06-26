<?php
include('connect.php');

$allCategories = [];
$fetchCategories = $conn->query("SELECT id, name, icon_class FROM categories ORDER BY name ASC");
if ($fetchCategories) {
    while ($record = $fetchCategories->fetch_assoc()) {
        $allCategories[$record['id']] = $record;
    }
}

$activeCategoryID = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if ($activeCategoryID > 0) {
    $query_string = "SELECT r.*, c.name as category_name, c.icon_class FROM resources r
            JOIN categories c ON r.category_id = c.id
            WHERE r.category_id = ?
            ORDER BY r.name ASC";
    $prepared_query = $conn->prepare($query_string);
    $prepared_query->bind_param("i", $activeCategoryID);
} else {
    $query_string = "SELECT r.*, c.name as category_name, c.icon_class FROM resources r
            JOIN categories c ON r.category_id = c.id
            ORDER BY r.name ASC";
    $prepared_query = $conn->prepare($query_string);
}

$prepared_query->execute();
$db_data = $prepared_query->get_result();

$page_title = $activeCategoryID > 0 && isset($allCategories[$activeCategoryID])
    ? $allCategories[$activeCategoryID]['name']
    : 'All Resources';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Community Hub - Sto. Tomas, Batangas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #212529;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header {
            background-color: rgba(45, 50, 80, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-logo {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fdb17a;
            transition: transform 0.3s ease;
        }

        .header-logo:hover {
            transform: scale(1.1) rotate(10deg);
        }

        .hero-section {
            position: relative;
            background-image: url('content/background_sto_tomas.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 75vh;
            min-height: 550px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(45, 50, 80, 0.7), rgba(66, 71, 105, 0.6));
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
            animation: fadeInHeroAnimation 1s ease-out forwards;
        }

        @keyframes fadeInHeroAnimation {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section h1 {
            font-weight: 700;
            font-size: clamp(2.5rem, 5vw, 4rem);
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
        }

        .hero-section p {
            font-size: 1.3rem;
            font-weight: 300;
            max-width: 650px;
            margin: 1rem auto 2.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .btn-discover {
            font-weight: 600;
            padding: 14px 35px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(253, 177, 122, 0.4);
        }

        .btn-discover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(253, 177, 122, 0.6);
        }

        .card-resource {
            border: 1px solid transparent;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
            visibility: hidden;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
        }

        .card-resource.is-visible {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .card-resource:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 28px rgba(45, 50, 80, 0.15);
        }

        .card-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .card-img-body {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card-resource:hover .card-img-body {
            transform: scale(1.05);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 0;
            padding: 1.25rem 1.25rem 0.5rem;
        }

        .card-header i {
            color: #2d3250;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding-top: 0.5rem;
        }

        .card-text {
            flex-grow: 1;
        }

        .category-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 0.8rem;
            background-color: #424769 !important;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 3;
        }

        .list-group-item {
            background-color: transparent;
            font-size: 0.9rem;
            border-top: 1px solid #e9ecef;
        }

        .list-group-item:first-child {
            border-top: 0;
        }

        .list-group-item i {
            min-width: 24px;
            color: #fdb17a;
        }

        #category-filters {
            text-align: center;
        }

        .filter-btn {
            border: 1px solid #ddd;
            border-radius: 50px;
            padding: 8px 20px;
            margin: 5px;
            text-decoration: none;
            color: #424769;
            background-color: #fff;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover {
            background-color: #fdb17a;
            color: #212529;
            border-color: #fdb17a;
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background-color: #2d3250;
            color: #f8f9fa;
            border-color: #2d3250;
            font-weight: 600;
        }

        .footer {
            background-color: #2d3250;
        }

        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #f8f9fa;
        }

        [data-bs-theme="dark"] .header {
            background-color: rgba(31, 42, 64, 0.85);
        }

        [data-bs-theme="dark"] .header-logo {
            border-color: #ffb88c;
        }

        [data-bs-theme="dark"] .card-resource {
            background-color: #1f2a40;
            border-color: #34495e;
            box-shadow: none;
        }

        [data-bs-theme="dark"] .card-resource:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border-color: #ffb88c;
        }

        [data-bs-theme="dark"] .card-header i {
            color: #ffb88c;
        }

        [data-bs-theme="dark"] .category-tag {
            background-color: #2c3e50 !important;
        }

        [data-bs-theme="dark"] .list-group-item {
            border-top-color: #34495e;
        }

        [data-bs-theme="dark"] .list-group-item i {
            color: #ffb88c;
        }

        [data-bs-theme="dark"] .filter-btn {
            background-color: #2c3e50;
            border-color: #444;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .filter-btn.active,
        [data-bs-theme="dark"] .filter-btn:hover {
            background-color: #ffb88c;
            color: #121212;
        }

        [data-bs-theme="dark"] .footer {
            background-color: #0d121c;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="header text-white p-3 shadow-sm sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="text-white text-decoration-none d-flex align-items-center">
                <img src="content/sto tomas.jpg" alt="Community Hub Logo" class="header-logo me-3">
                <span class="fs-4 fw-bold">Local Community Hub</span>
            </a>
            <div>
                <button id="modeButton" class="btn btn-outline-light">Dark Mode</button>
            </div>
        </div>
    </header>

    <main class="flex-shrink-0">
        <section class="hero-section">
            <div class="container px-4">
                <h1>Welcome to the Sto. Tomas Community Hub</h1>
                <p>Your one-stop guide to essential services, places, and support within our vibrant city.</p>
                <a href="#resources-section" id="discoverBtn" class="btn btn-warning btn-lg btn-discover">
                    Explore Resources <i class="fas fa-arrow-down ms-2"></i>
                </a>
            </div>
        </section>

        <div class="container py-5">
            <section id="category-filters" class="mb-5">
                <h2 class="text-center fw-bold mb-4">Explore by Category</h2>
                <div class="d-flex flex-wrap justify-content-center">
                    <a href="index.php" class="filter-btn <?php if ($activeCategoryID == 0) echo 'active'; ?>">
                        <i class="fas fa-globe me-1"></i> All
                    </a>
                    <?php
                    reset($allCategories);
                    while ($category = current($allCategories)) {
                    ?>
                        <a href="?category=<?php echo $category['id']; ?>#resources-section" class="filter-btn <?php if ($activeCategoryID == $category['id']) echo 'active'; ?>">
                            <i class="<?php echo htmlspecialchars($category['icon_class']); ?> me-1"></i>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php
                        next($allCategories);
                    }
                    ?>
                </div>
            </section>

            <section id="resources-section">
                <h2 class="pb-2 border-bottom mb-4 fw-bold"><?php echo htmlspecialchars($page_title); ?></h2>

                <?php if ($db_data->num_rows == 0) { ?>
                    <div class="alert alert-warning text-center p-5 shadow-sm" role="alert">
                        <i class="fas fa-info-circle fa-3x mb-3 text-warning"></i>
                        <h4 class="alert-heading">No Resources Found</h4>
                        <p class="mb-0">There are no resources listed in this category yet. Please check back later or select another category.</p>
                    </div>
                <?php } else { ?>
                    <div class="row g-4">
                        <?php while ($listing = $db_data->fetch_assoc()) { ?>
                            <div class="col-md-6 col-lg-4 d-flex">
                                <div class="card card-resource w-100 shadow-sm">
                                    <div class="card-img-container">
                                        <span class="badge rounded-pill category-tag">
                                            <i class="<?php echo htmlspecialchars($listing['icon_class']); ?> me-1"></i>
                                            <?php echo htmlspecialchars($listing['category_name']); ?>
                                        </span>
                                        <?php if (!empty($listing['image_path'])) { ?>
                                            <img src="content/resource_images/<?php echo htmlspecialchars($listing['image_path']); ?>"
                                                class="card-img-body"
                                                alt="<?php echo htmlspecialchars($listing['name']); ?>">
                                        <?php } else { ?>
                                            <div class="card-img-body bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image fa-3x text-light-emphasis"></i>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="card-header">
                                        <h5 class="mb-0 card-title fw-bold">
                                            <?php echo htmlspecialchars($listing['name']); ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text text-muted small">
                                            <?php echo nl2br(htmlspecialchars($listing['description'])); ?>
                                        </p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php if (!empty($listing['address'])) { ?>
                                            <li class="list-group-item">
                                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($listing['address']); ?>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($listing['phone'])) { ?>
                                            <li class="list-group-item">
                                                <i class="fas fa-phone"></i>
                                                <a href="tel:<?php echo htmlspecialchars(str_replace([' ', '-'], '', $listing['phone'])); ?>" class="text-decoration-none text-body">
                                                    <?php echo htmlspecialchars($listing['phone']); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-white">© <?php echo date('Y'); ?> Local Community Hub. </span>
            <a href="admin/" class="text-white-50">Admin Login</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let mode = localStorage.getItem('theme') || 'light';

            function applyTheme() {
                var htmlElement = document.documentElement;
                var btnMode = document.getElementById("modeButton");
                var btnText = mode == "dark" ? "Light Mode" : "Dark Mode";
                var btnClass = mode == "dark" ? "btn-light" : "btn-dark";

                btnMode.classList.remove("btn-light", "btn-dark", "btn-outline-light");
                btnMode.classList.add(btnClass);
                btnMode.textContent = btnText;
                htmlElement.setAttribute("data-bs-theme", mode);
            }

            function changeMode() {
                mode = mode == "light" ? "dark" : "light";
                localStorage.setItem('theme', mode);
                applyTheme();
            }

            applyTheme();

            document.getElementById('modeButton').addEventListener('click', changeMode);

            const discoverBtn = document.getElementById('discoverBtn');
            if (discoverBtn) {
                discoverBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }

            const cards = document.querySelectorAll('.card-resource');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>

</html>