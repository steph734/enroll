<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$username = ucfirst($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment System</title>
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../statics/css/bootstrap.min.css">
    <script src="../statics/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: rgb(155, 182, 243);
            background: linear-gradient(137deg, rgba(155, 182, 243, 1) 0%, rgba(203, 220, 255, 1) 21%, rgba(237, 243, 255, 0.999964951801033) 52%, rgba(184, 206, 255, 1) 100%, rgba(184, 206, 255, 1) 100%);
        }
    </style>

</head>


<body>

    <header id="navbar" class="shadow-sm">
        <div class="logo-container">
            <img src="../img/logo.png" alt="logo" class="logo" />
        </div>
        <div class="vl"></div>
        <h2>Enrollment System</h2>
        <div class="profile-container">
            <div class="dropdown">
                <a href="#" class="user-icon" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                    title="User Menu">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="web-layout.php?page=accounts">Accounts</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <p><?php echo $username; ?></p>
        </div>
    </header>
    <?php include '../views/sidebar.php'; ?>
    <main id="main-content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $allowed_pages = ['dashboard', 'students', 'teachers', 'subject-section', 'sections', 'payment', 'class_schedule', 'reports', 'accounts', 'enrollment_form', 'teacher_form'];
        $page_path = __DIR__ . "/../views/{$page}.php";

        if (in_array($page, $allowed_pages) && file_exists($page_path)) {
            include $page_path;
        } else {
            echo "<h2>Page not found</h2>";
        }
        ?>
    </main>
    <script src="../js/app.js"></script>
</body>

</html>