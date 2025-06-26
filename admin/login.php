<?php
session_start();
include('../connect.php');

$loginError = '';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $loginError = 'Please enter both username and password.';
    } else {
        $query_string = "SELECT id, username FROM admins WHERE username = ? AND password = ?";
        $prepared_query = $conn->prepare($query_string);
        $prepared_query->bind_param("ss", $username, $password);
        $prepared_query->execute();
        $query_outcome = $prepared_query->get_result();

        if ($query_outcome->num_rows == 1) {
            $admin_record = $query_outcome->fetch_assoc();
            session_regenerate_id(true);
            $_SESSION['is_logged_in'] = true;
            $_SESSION['admin_id'] = $admin_record['id'];
            $_SESSION['username'] = $admin_record['username'];
            header('Location: index.php');
            exit;
        } else {
            $loginError = 'Invalid username or password.';
        }

        $prepared_query->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-image: url('img/community.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 2.5rem 3rem;
            width: 100%;
            max-width: 450px;
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            padding-right: 3rem;
            width: 100%;
            color: white;
            transition: background 0.3s;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 1.25rem;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-login {
            background-color: #fdb17a;
            color: black;
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-login:hover {
            background-color: #e9a26d;
            color: black;
            box-shadow: 0 0 12px 2px rgba(253, 177, 122, 0.7);
        }

        .back-link {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.2s ease-in-out;
        }

        .back-link:hover {
            opacity: 1;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="glass-card">
            <h1 class="form-title">Admin Login</h1>
            <?php if (!empty($loginError)) { ?>
                <div class="alert alert-danger" role="alert" style="background-color: rgba(248, 215, 218, 0.3); border-color: rgba(220, 53, 69, 0.5); color: white;">
                    <?php echo htmlspecialchars($loginError); ?>
                </div>
            <?php } ?>
            <form action="login.php" method="POST">
                <div class="input-wrapper">
                    <input type="text" class="form-input" id="username" name="username" placeholder="Username" required autocomplete="username">
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
                <div class="input-wrapper">
                    <input type="password" class="form-input" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                    <i class="fa-solid fa-lock input-icon"></i>
                </div>
                <button class="btn-login" type="submit">Login</button>
            </form>
            <p class="mt-4 text-center">
                <a href="../" class="back-link">← Back to Public Site</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>