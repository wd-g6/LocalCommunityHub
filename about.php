<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Local Community Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- CORE STYLES --- */
        body {
            font-family: 'Poppins', sans-serif;
            color: #2d3250;
            background: linear-gradient(to bottom, #F6A17A, #F7F8FA);
            background-attachment: fixed;
            overflow-x: hidden;
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

        .header .nav-link {
            transition: color 0.2s ease-in-out;
            font-weight: 500;
        }

        .header .nav-link:hover,
        .header .nav-link.active {
            color: #fdb17a !important;
        }

        .footer {
            background-color: #2d3250;
        }

        /* --- STUNNING ABOUT PAGE STYLES --- */

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: radial-gradient(circle, rgba(45, 50, 80, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-animate {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .about-badge {
            display: inline-block;
            padding: 0.35em 0.8em;
            font-size: 0.8rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 50rem;
            background-color: #e9eef7;
            color: #424769;
        }

        .core-value-card i {
            font-size: 2.5rem;
            color: #fdb17a;
            margin-bottom: 1rem;
        }

        .mission-vision-card {
            border-radius: 1rem;
            padding: 2.5rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mission-vision-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 32px rgba(45, 50, 80, 0.15);
        }

        .mission-vision-card .icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        
        /* --- TEAM CARD STYLES (NOW MORE COMPACT) --- */
        .team-card-wrapper {
            margin-top: 60px;
            height: 100%; 
        }

        .team-card {
            position: relative;
            background-color: #424769;
            color: #e0e0e0;
            border-radius: 1rem;
            padding-top: 50px; /* UPDATED: Slightly reduced top padding */
            text-align: center;
            box-shadow: 0 8px 24px rgba(45, 50, 80, 0.08);
            transition: all 0.4s ease;
            border-top: 4px solid transparent;
            display: flex;
            flex-direction: column;
            height: 100%; 
        }

        .team-card .card-title {
            color: #ffffff;
        }

        .team-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(45, 50, 80, 0.12);
            border-top-color: #fdb17a;
        }

        .team-img-container {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
        }

        .team-member-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid #424769;
            box-shadow: 0 5px 15px rgba(45, 50, 80, 0.1);
        }

        .team-title {
            color: #fdb17a;
            font-weight: 600;
        }
        
        .team-social-links {
            margin-top: auto; 
            /* UPDATED: Reduced space above the links */
            padding-top: 0.5rem; 
        }

        .team-social-links a {
            color: #adb5bd;
            margin: 0 0.5rem;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .team-social-links a:hover {
            color: #fdb17a;
        }

        /* --- DARK MODE STYLES --- */
        [data-bs-theme="dark"] body {
            background: linear-gradient(to bottom, #121212, #1a1a2e);
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] body::before {
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }

        [data-bs-theme="dark"] .header {
            background-color: rgba(31, 42, 64, 0.85);
        }

        [data-bs-theme="dark"] .header .nav-link:hover,
        [data-bs-theme="dark"] .header .nav-link.active {
            color: #ffb88c !important;
        }

        [data-bs-theme="dark"] .header-logo {
            border-color: #ffb88c;
        }

        [data-bs-theme="dark"] .footer {
            background-color: #0d121c;
        }

        [data-bs-theme="dark"] .about-badge {
            background-color: #2c3e50;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .core-value-card i {
            color: #ffb88c;
        }

        [data-bs-theme="dark"] .mission-vision-card:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
        }
        
        [data-bs-theme="dark"] .mission-card-override {
            background-color: #ffb88c !important;
            color: #1f2a40 !important;
        }
        [data-bs-theme="dark"] .vision-card-override {
             background-color: #424769 !important;
             color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .mission-vision-card .icon {
            color: inherit;
        }
        
        [data-bs-theme="dark"] .team-card {
            background-color: #1f2a40;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            border-top-color: transparent;
            color: #e0e0e0;
        }
        
        [data-bs-theme="dark"] .team-card .card-title {
             color: #ffffff;
        }

        [data-bs-theme="dark"] .team-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-top-color: #ffb88c;
        }

        [data-bs-theme="dark"] .team-member-img {
            border-color: #1f2a40;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .team-title {
            color: #ffb88c;
        }

        [data-bs-theme="dark"] .team-social-links a {
            color: #9ab;
        }

        [data-bs-theme="dark"] .team-social-links a:hover {
            color: #ffb88c;
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
            <div class="d-flex align-items-center">
                <nav class="nav me-3">
                    <a class="nav-link text-white" href="index.php">Home</a>
                    <a class="nav-link text-white active" href="about.php">About</a>
                </nav>
                <button id="modeButton" class="btn btn-outline-light">Dark Mode</button>
            </div>
        </div>
    </header>

    <main class="flex-shrink-0">
        <div class="container py-5 mt-4">
            <!-- INTRO SECTION -->
            <section class="text-center mb-5 section-animate">
                <span class="about-badge mb-3">ABOUT US</span>
                <h1 class="display-3 fw-bold">Bridging Sto. Tomas, One Connection at a Time.</h1>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">We are a passionate team dedicated to empowering our community by making vital information accessible, clear, and reliable for every Tomasino.</p>
            </section>

            <!-- CORE VALUES -->
            <section class="mb-5 pb-5 section-animate" style="animation-delay: 0.2s;">
                <div class="row g-4 text-center">
                    <div class="col-md-4 core-value-card">
                        <i class="fas fa-users"></i>
                        <h4 class="fw-bold">Community-Focused</h4>
                        <p class="text-muted">Our primary goal is to serve the people of Sto. Tomas. Every feature is built with the community's needs in mind.</p>
                    </div>
                    <div class="col-md-4 core-value-card">
                        <i class="fas fa-bullseye"></i>
                        <h4 class="fw-bold">Accuracy & Reliability</h4>
                        <p class="text-muted">We are committed to providing up-to-date and verified information to ensure you can trust what you find here.</p>
                    </div>
                    <div class="col-md-4 core-value-card">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h4 class="fw-bold">Simplicity & Access</h4>
                        <p class="text-muted">Technology should be easy. We design for everyone, ensuring our platform is simple to navigate for all ages.</p>
                    </div>
                </div>
            </section>

            <!-- MISSION & VISION -->
            <section class="mb-5 pb-5 section-animate" style="animation-delay: 0.4s;">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6">
                        <div class="mission-vision-card shadow-lg mission-card-override" style="background-color: #fdb17a;">
                            <div class="icon"><i class="fas fa-rocket"></i></div>
                            <h2 class="fw-bold">Our Mission</h2>
                            <p>To be the central, single source of truth for all public services, local businesses, and emergency resources in Sto. Tomas, eliminating confusion and empowering residents with the knowledge they need to thrive.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mission-vision-card text-white shadow-lg vision-card-override" style="background-color: #424769;">
                            <div class="icon"><i class="fas fa-eye"></i></div>
                            <h2 class="fw-bold">Our Vision</h2>
                            <p>To foster a digitally-connected and resilient Sto. Tomas where every citizen can effortlessly access support, engage with local opportunities, and contribute to a more informed and collaborative community.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TEAM SECTION -->
            <section class="text-center section-animate" style="animation-delay: 0.6s;">
                <h2 class="display-5 fw-bold">Meet the Team</h2>
                <p class="lead text-muted mb-5">The passionate minds behind the Community Hub.</p>

                <div class="row justify-content-center align-items-stretch">
                    <!-- Member 1 -->
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-card-wrapper">
                            <div class="team-card">
                                <div class="team-img-container">
                                    <img src="https://placehold.co/120x120/fdb17a/2d3250?text=AJ" class="team-member-img" alt="Aaron James Garcia Landicho">
                                </div>
                                <h4 class="card-title fw-bold mt-3">Aaron James Garcia Landicho</h4>
                                <div class="team-social-links mt-4">
                                    <a href="https://www.facebook.com/share/1MRoxuGoCk/" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="https://github.com/Drawn2AJI" aria-label="Github"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Member 2 -->
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-card-wrapper">
                            <div class="team-card">
                                <div class="team-img-container">
                                    <img src="https://placehold.co/120x120/2d3250/ffffff?text=JM" class="team-member-img" alt="Jerome Medrano">
                                </div>
                                <h4 class="card-title fw-bold mt-3">Jerome Medrano</h4>
                                <div class="team-social-links mt-4">
                                    <a href="https://www.facebook.com/share/166L5hTaWP/" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="https://github.com/Jerome1405" aria-label="Github"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Member 3 -->
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-card-wrapper">
                            <div class="team-card">
                                <div class="team-img-container">
                                    <img src="https://placehold.co/120x120/424769/ffffff?text=AA" class="team-member-img" alt="Aljon Arnan">
                                </div>
                                <h4 class="card-title fw-bold mt-3">Aljon Arnan</h4>
                                <div class="team-social-links mt-4">
                                    <a href="https://www.facebook.com/share/16mFbdiWm8/" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="https://github.com/aljonarnan" aria-label="Github"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Member 4 -->
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-card-wrapper">
                            <div class="team-card">
                                <div class="team-img-container">
                                    <img src="https://placehold.co/120x120/6c757d/ffffff?text=AS" class="team-member-img" alt="Aivan Sawali">
                                </div>
                                <h4 class="card-title fw-bold mt-3">Aivan Sawali</h4>
                                <div class="team-social-links mt-4">
                                    <a href="https://www.facebook.com/share/1G7gRSTvwj/" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="https://github.com/aivansawali" aria-label="Github"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Member 5 -->
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-card-wrapper">
                            <div class="team-card">
                                <div class="team-img-container">
                                    <img src="https://placehold.co/120x120/F6A17A/ffffff?text=KA" class="team-member-img" alt="Karl Andrei">
                                </div>
                                <h4 class="card-title fw-bold mt-3">Karl Andrei</h4>
                                <div class="team-social-links mt-4">
                                    <a href="https://www.facebook.com/share/16U7oMNZBr/?mibextid=wwXIfr" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="" aria-label="Github"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-white-50">© <?php echo date('Y'); ?> Local Community Hub. Built for the people of Sto. Tomas.</span><br>
            <a href="admin/" class="text-white">Admin Login</a>
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
                var btnClass = mode == "dark" ? "btn-light" : "btn-outline-light";
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
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            document.querySelectorAll('.section-animate').forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</body>

</html>