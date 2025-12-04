<?php
require_once('authorizeaccess.php');
session_start();
require_once('pagetitles.php');
require_once('navmenu.php');
$page_title = EDIT_PROFILE;  

// Access restriction: Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once('activitylogdbconnection.php');
require_once('queryutils.php');

$message = "";
$is_success = false;

// Handle POST request for updating profile
if (isset($_POST['update_profile'])) {
    $first_name = ($_POST['first_name']);
    $last_name = ($_POST['last_name']);
    $gender = ($_POST['gender']);
    $birthdate = ($_POST['birthdate']);
    $weight = ($_POST['weight']);

    $errors = [];
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($gender) || !in_array($gender, ['m', 'f', 'n'])) $errors[] = "Valid gender is required.";
    if (empty($birthdate)) $errors[] = "Birthdate is required.";
    if (empty($weight) || !is_numeric($weight) || $weight <= 0) $errors[] = "Weight must be a positive number.";

    if (empty($errors)) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);
        $update_query = "UPDATE exercise_user SET first_name = ?, last_name = ?, gender = ?, birthdate = ?, weight = ? WHERE id = ?";
        parameterizedQuery($dbc, $update_query, 'ssssdi', $first_name, $last_name, $gender, $birthdate, $weight, $_SESSION['user_id']);
        mysqli_close($dbc);
        $message = "Profile updated successfully.";
        $is_success = true;
        // Re-fetch data after update
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT first_name, last_name, gender, birthdate, weight FROM exercise_user WHERE id = ?";
        $user_result = parameterizedQuery($dbc, $query, 'i', $_SESSION['user_id']);
        $user = mysqli_fetch_array($user_result);
        mysqli_close($dbc);
    } else {
        $message = implode(" ", $errors);
        $is_success = false;
    }
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or trigger_error('Error connecting to MySQL server for ActivityLog' . DB_NAME, E_USER_ERROR);

// Fetch user profile data
$query = "SELECT first_name, last_name, gender, birthdate, weight FROM exercise_user WHERE id = ?";
$user_result = parameterizedQuery($dbc, $query, 'i', $_SESSION['user_id'])
    or trigger_error(mysqli_error($dbc), E_USER_ERROR);
$user = mysqli_fetch_array($user_result);

mysqli_close($dbc);
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
    <?php require_once('navmenu.php'); ?>
    <h1 class="pt-3 text-center"><?= $page_title ?></h1>
    <hr>

    <?php if ($message): ?>
        <div class="alert <?php echo $is_success ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- User Profile Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Edit Profile Information</h5>
            <form method="post" action="">
                <input type="hidden" name="update_profile" value="1">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="m" <?= $user['gender'] == 'm' ? 'selected' : '' ?>>Male</option>
                        <option value="f" <?= $user['gender'] == 'f' ? 'selected' : '' ?>>Female</option>
                        <option value="n" <?= $user['gender'] == 'n' ? 'selected' : '' ?>>Non-binary</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate:</label>
                    <input type="date" id="birthdate" name="birthdate" class="form-control" value="<?= htmlspecialchars($user['birthdate']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (lbs):</label>
                    <input type="number" id="weight" name="weight" class="form-control" min="1" value="<?= htmlspecialchars($user['weight']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
