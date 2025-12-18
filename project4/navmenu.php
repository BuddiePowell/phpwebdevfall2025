<?php
    $page_title = isset($page_title) ? $page_title : "";

    if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

?>
<nav class="navbar sticky-top navbar-expand-md navbar-dark"
     style="background: linear-gradient(to right, #3a7bd5, #3a6073);">
    <a class="navbar-brand" href=<?= dirname($_SERVER['PHP_SELF']) ?>>
        Video Game Collection
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link<?= $page_title == "Home" ? ' active' : '' ?>"
               href=<?= dirname($_SERVER['PHP_SELF']) ?>>Home</a>
            <a class="nav-item nav-link<?= $page_title == "Edit Profile" ? ' active' : '' ?>" href="editprofile.php">Edit Profile</a>
            <a class="nav-item nav-link<?= $page_title == "Add Video Game" ? ' active' : '' ?>" href="addvideogame.php">Add Video Game</a>
            <a class="nav-item nav-link<?= $page_title == "View Profile" ? ' active' : '' ?>" href="viewprofile.php">View Profile</a>
            <?php if (!isset($_SESSION['user_name'])): ?>
                <a class="nav-item nav-link<?= $page_title == "Login" ? ' active' : '' ?>" href="login.php">Login</a>
                <a class="nav-item nav-link<?= $page_title == "Create User" ? ' active' : '' ?>" href="signup.php">Sign Up</a>
            <?php else: ?>
                <a class='nav-item nav-link' href='logout.php'>Logout (<?=$_SESSION['user_name'] ?>)</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
