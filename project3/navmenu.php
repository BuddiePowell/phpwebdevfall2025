<!-- Horizontal Navbar with Custom Colors -->
<nav class="navbar navbar-expand-lg bg-gradient-primary navbar-dark shadow-sm">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    
                    <!-- View Profile -->
                    <li class="nav-item me-2">
                        <a href="viewprofile.php" class="btn btn-primary">View Profile</a>
                    </li>
                    
                    <!-- Log Exercise -->
                    <li class="nav-item me-2">
                        <a href="logexercise.php" class="btn btn-info">Log Exercise</a>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item me-2">
                        <a href="logout.php" class="btn btn-info">Logout</a>
                    </li>

                   
                    <!-- Sign Up -->
                    <li class="nav-item me-2">
                        <a href="editprofile.php" class="btn btn-success">Edit Profile </a>
                    </li>
               
                    <!-- Sign Up -->
                    <li class="nav-item me-2">
                        <a href="signup.php" class="btn btn-success">Sign Up</a>
                    </li>
                    
                    <!-- Log In -->
                    <li class="nav-item me-2">
                        <a href="login.php" class="btn btn-outline-light">Log In</a>
                    </li>
                
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Custom CSS for Gradient Background -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .navbar-nav .btn:hover {
        opacity: 0.8;
    }
</style>