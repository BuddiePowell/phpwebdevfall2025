<?php
require_once('pagetitles.php');
$page_title = 'CREATE_USER';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1><?php echo $page_title; ?></h1>
            <hr/>
            <?php
            $show_create_user_form = true;

            if (isset($_POST['create_user_submission'])) {
                // Get input values
                $name = $_POST['name'];
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];

                $errors = [];

                if (empty($name)) {
                    $errors[] = "Name is required.";
                }
                if (empty($user_name)) {
                    $errors[] = "User name is required.";
                }
                if (empty($password)) {
                    $errors[] = "Password is required.";
                }

                if (empty($errors)) {
                    require_once('videogamedbconnection.php');
                    require_once('queryutils.php');

                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                            or trigger_error(
                                    'Error connecting to MySQL server for DB_NAME.', 
                                    E_USER_ERROR);

                    // Check if user already exists
                    $query = "SELECT * FROM users WHERE user_name = ?";
                    $results = parameterizedQuery($dbc, $query, 's', $user_name);

                    if (mysqli_num_rows($results) == 0) {
                        $salted_hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        $query = "INSERT INTO users (name, user_name, password_hash) VALUES (?, ?, ?)";
                        $results = parameterizedQuery($dbc, $query, 'sss', $name, $user_name, $salted_hashed_password);

                        $id = mysqli_insert_id($dbc);

                        if ($id > 0) {
                            // Redirect to login page after successful signup
                            header('Location: login.php');
                            exit();
                        } else {
                            $errors[] = "Failed to create account. Please try again.";
                        }
                    } else {
                        $errors[] = "An account already exists for this username: <strong>" . $user_name . "</strong>. Please use a different user name.";
                    }

                    mysqli_close($dbc);
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'><ul>";
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                    echo "</ul></div><hr/>";
                }
            }

            if ($show_create_user_form):
            ?>
            <form class="needs-validation" novalidate method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label-lg">Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                        <div class="invalid-feedback">Please provide a valid name.</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user_name" class="col-sm-2 col-form-label-lg">User Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter a user name" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" required>
                        <div class="invalid-feedback">Please provide a valid user name.</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label-lg">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" required>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="show_password_check" onclick="togglePassword()">
                            <label class="form-check-label" for="show_password_check">Show Password</label>
                        </div>
                        <div class="invalid-feedback">Please provide a valid password.</div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="create_user_submission">Sign Up</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function togglePassword() {
    var password_entry = document.getElementById("password");
    password_entry.type = password_entry.type === "password" ? "text" : "password";
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
