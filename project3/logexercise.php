<?php
session_start();
require_once('pagetitles.php');
$page_title = LOG_EXERCISE;
require_once('activitylogdbconnection.php');
require_once('queryutils.php');
require_once('navmenu.php');

// Access restriction: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userid = $_SESSION['user_id'];

$type = $date = $time = $heart_rate = $message = "";
$is_success = false;

// Handle POST request for logging exercise
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $heart_rate = $_POST['heart_rate'];
    
    $errors = [];
    if (empty($type)) {
        $errors[] = "Exercise type is required.";
    }
    if (empty($date) || !($dateObj = DateTime::createFromFormat('Y-m-d', $date)) || $dateObj->format('Y-m-d') !== $date) {
        $errors[] = "Valid date (YYYY-MM-DD) is required.";
    }
    if (empty($time) || !is_numeric($time) || $time <= 0) {
        $errors[] = "Time must be a positive number.";
    }
    if (empty($heart_rate) || !is_numeric($heart_rate) || $heart_rate <= 0) {
        $errors[] = "Heart rate must be a positive number.";
    }
    
    // Function to calculate calories burned
    function calculateCalories($gender, $hr, $w, $a, $t) {
        if ($gender == 'Male') {
            return ((-55.0969 + (0.6309 * $hr) + (0.090174 * $w) + (0.2017 * $a)) / 4.184) * $t;
        } elseif ($gender == 'Female') {
            return ((-20.4022 + (0.4472 * $hr) - (0.057288 * $w) + (0.074 * $a)) / 4.184) * $t;
        } elseif ($gender == 'Non-Binary') {
            return ((-37.7495 + (0.5391 * $hr) + (0.01644 * $w) + (0.1379 * $a)) / 4.184) * $t;
        }
        return 0;
    }
        // If no validation errors, proceed to log exercise
    if (empty($errors)) {
        $formatted_date = $dateObj->format('Y-m-d');
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);
        
        // Fetch user details for calorie calculation
        $query = "SELECT gender, weight, birthdate FROM exercise_user WHERE id = ?";
        $result = parameterizedQuery($dbc, $query, 'i', $userid)
            or trigger_error(mysqli_error($dbc), E_USER_ERROR);
        // Calculate calories and insert log
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $gender_map = ['m' => 'Male', 'f' => 'Female', 'n' => 'Non-Binary'];
            $gender = $gender_map[$row['gender']] ?? 'Non-Binary';
            $weight = $row['weight'];
            $birthdate = $row['birthdate'];
            $age = date_diff(date_create($birthdate), date_create(date('Y-m-d')))->format('%y');
            $calories_float = calculateCalories($gender, $heart_rate, $weight, $age, $time);
            $calories_int = max(0, round($calories_float, 0));
            
            // Insert exercise log
            $insert_query = "INSERT INTO exercise_log (user_id, date, exercise_type, time_in_minutes, heartrate, calories) VALUES (?, ?, ?, ?, ?, ?)";
            parameterizedQuery($dbc, $insert_query, 'issiii', $userid, $formatted_date, $type, $time, $heart_rate, $calories_int)
                or trigger_error(mysqli_error($dbc), E_USER_ERROR);
            
            $message = "Exercise logged successfully! Calories burned: " . $calories_int;
            $is_success = true;
            $type = $date = $time = $heart_rate = "";  // Reset form fields
        } else {
            $message = "User details not found.";
            $is_success = false;
        }
        mysqli_close($dbc);
    } else {
        $message = implode(" ", $errors);
        $is_success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $page_title ?></title>
</head>
</head>
<body class="container">
    <h1 class="pt-3 text-center"><?php echo $page_title; ?></h1>
    <hr>
    
    <?php if ($message): ?>
        <div class="alert <?php echo $is_success ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="<?php echo ($_SERVER['PHP_SELF']); ?>">
        <div class="mb-3">
            <label for="type" class="form-label">Type of Exercise:</label>
            <select id="type" name="type" class="form-select" required>
                <option value="">Choose an Exercise Type</option>
                <option value="Running" <?php echo ($type == 'Running') ? 'selected' : ''; ?>>Running</option>
                <option value="Walking" <?php echo ($type == 'Walking') ? 'selected' : ''; ?>>Walking</option>
                <option value="Weightlifting" <?php echo ($type == 'Weightlifting') ? 'selected' : ''; ?>>Weightlifting</option>
                <option value="Cycling" <?php echo ($type == 'Cycling') ? 'selected' : ''; ?>>Cycling</option>
                <option value="Swimming" <?php echo ($type == 'Swimming') ? 'selected' : ''; ?>>Swimming</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date of Exercise:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?php echo $date; ?>" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time (in minutes):</label>
            <input type="number" id="time" name="time" class="form-control" min="1" value="<?php echo $time; ?>" required>
        </div>
        <div class="mb-3">
            <label for="heart_rate" class="form-label">Average Heart Rate:</label>
            <input type="number" id="heart_rate" name="heart_rate" class="form-control" min="1" value="<?php echo $heart_rate; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Log Exercise</button>
    </form>
</body>
</html>
