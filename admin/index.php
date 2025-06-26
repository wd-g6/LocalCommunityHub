<?php
session_start();
include('../connect.php');

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != true) {
    header('Location: login.php');
    exit;
}

$allCategories = [];
$category_prep = $conn->prepare("SELECT id, name, icon_class FROM categories ORDER BY name ASC");
$category_prep->execute();
$categories_from_db = $category_prep->get_result();
if ($categories_from_db) {
    while ($cat_record = $categories_from_db->fetch_assoc()) {
        $allCategories[$cat_record['id']] = $cat_record;
    }
}
$category_prep->close();

$resource_prep = $conn->prepare("SELECT id, name, category_id FROM resources ORDER BY name ASC");
$resource_prep->execute();
$resources_from_db = $resource_prep->get_result();

$resourceCount = $resources_from_db->num_rows;
$categoryCount = count($allCategories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #F6A17A, #F7F8FA);
            background-attachment: fixed;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #2c3e50;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #1a252f;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 1.1em;
            display: block;
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        #sidebar ul li a:hover {
            color: #ffffff;
            background: #34495e;
        }

        #sidebar ul li.active>a {
            color: #fff;
            background: #1c2a38;
            border-left: 3px solid #fdb17a;
        }

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .stat-card {
            border: none;
            color: white;
            border-radius: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            font-size: 4rem;
            opacity: 0.15;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease-out;
        }

        .stat-card:hover .stat-icon {
            transform: translateY(-50%) scale(1.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-load {
            opacity: 0;
            animation: fadeInUp 0.7s ease-out forwards;
        }

        .table-hover tbody tr:hover {
            color: var(--bs-table-hover-color);
            background-color: var(--bs-table-hover-bg);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header text-center">
                <h3><i class="fa-solid fa-shield-halved me-2"></i>Admin Panel</h3>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="index.php"><i class="fas fa-tachometer-alt me-3"></i>Dashboard</a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded animate-on-load" style="animation-delay: 0.1s;">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <div class="ms-auto">
                        <a href="../" target="_blank" class="btn btn-outline-primary"><i class="fas fa-globe me-1"></i> View Public Site</a>
                        <a href="?action=logout" class="btn btn-outline-danger ms-2"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    </div>
                </div>
            </nav>

            <h1 class="mb-4 text-dark animate-on-load" style="animation-delay: 0.2s;">Dashboard Overview</h1>

            <section class="stats mb-5">
                <div class="row g-4">
                    <div class="col-md-6 animate-on-load" style="animation-delay: 0.3s;">
                        <div class="card stat-card shadow-sm" style="background-color: #424769;">
                            <div class="card-body p-4">
                                <i class="fa-solid fa-book-bookmark stat-icon"></i>
                                <h2 class="card-title display-4 fw-bold"><?php echo $resourceCount; ?></h2>
                                <p class="card-text fs-5">Total Resources</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate-on-load" style="animation-delay: 0.4s;">
                        <div class="card stat-card shadow-sm" style="background-color: #fdb17a; color: #2d3250;">
                            <div class="card-body p-4">
                                <i class="fa-solid fa-tags stat-icon"></i>
                                <h2 class="card-title display-4 fw-bold"><?php echo $categoryCount; ?></h2>
                                <p class="card-text fs-5">Total Categories</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="data-table animate-on-load" style="animation-delay: 0.5s;">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h4 class="card-title mb-0"><i class="fas fa-list me-2"></i>All Resources</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Resource Name</th>
                                        <th>Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($resources_from_db->num_rows == 0) { ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted p-4">
                                                <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                                No resource data found in the database.
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <?php while ($res_record = $resources_from_db->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($res_record['id']); ?></td>
                                                <td><?php echo htmlspecialchars($res_record['name']); ?></td>
                                                <td>
                                                    <?php
                                                    $category_details = $allCategories[$res_record['category_id']] ?? null;
                                                    if ($category_details) {
                                                        echo '<i class="' . htmlspecialchars($category_details['icon_class']) . ' me-2"></i>';
                                                        echo htmlspecialchars($category_details['name']);
                                                    } else {
                                                        echo '<span class="text-muted fst-italic">Uncategorized</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>