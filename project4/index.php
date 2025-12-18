<?php
session_start();
require_once "pagetitles.php";
$page_title = HOME;
require_once "videogamedbconnection.php";
require_once "queryutils.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $page_title ?></title>
</head>
<body>
    <?php require_once "navmenu.php"; ?>
    <div class="container mt-5">
        <h1>Welcome to Your Video Game Collection</h1>
        <?php if (isset($_SESSION["user_id"])): ?>
            <p class="lead">Manage and explore your personal video game library.</p>
            <div class="mt-4">
                <a href="addvideogame.php" class="btn btn-primary me-2">Add a Game</a>
                <a href="editprofile.php" class="btn btn-secondary me-2">Edit Profile</a>
                <a href="viewprofile.php" class="btn btn-info">View Profile</a>
            </div>
        <?php else: ?>
            <p class="lead">Manage and explore your personal video game library.</p>
            <div class="mt-4">
                <a href="login.php" class="btn btn-primary me-2">Login</a>
                <a href="signup.php" class="btn btn-secondary">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
