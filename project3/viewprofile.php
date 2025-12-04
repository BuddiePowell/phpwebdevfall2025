<?php
session_start();
require_once "pagetitles.php";
$page_title = "VIEW PROFILE";

require_once "activitylogdbconnection.php";
require_once "queryutils.php";

// Initialize variables
$message = "";
$userid = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$logData = [];

// Check if user is logged in
if (!$userid) {
    $message = "You must be logged in to view this page.";
    header("Location: login.php"); exit;
}

// Fetch profile and log data (only if logged in)
if ($userid) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or
        trigger_error("Error connecting to database.", E_USER_ERROR);
    $query_profile = "SELECT first_name, last_name, gender, birthdate, weight FROM exercise_user WHERE id = ?";
    $result_profile = parameterizedQuery($dbc, $query_profile, "i", $userid);
    $profile = mysqli_fetch_array($result_profile);
    $query_log = "SELECT id, date, exercise_type, time_in_minutes, heartrate, calories FROM exercise_log WHERE user_id = ? ORDER BY id DESC";
    $result_log = parameterizedQuery($dbc, $query_log, "i", $userid);
    while ($row = mysqli_fetch_array($result_log)) {
        $logData[] = $row;
    }
    mysqli_close($dbc);
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
    <?php require_once "navmenu.php"; ?>
    <h1 class="pt-3 text-center"><?= $page_title ?></h1>
    <hr>

    <?php if ($message): ?>
        <div class="alert <?php echo strpos($message, "successfully") !== false ? "alert-success" : "alert-danger"; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="profile mb-4">
        <h2>Personal Information</h2>
        <?php if ($profile): ?>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($profile["first_name"]); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($profile["last_name"]); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($profile["gender"]); ?></p>
            <p><strong>Birthdate:</strong> <?php echo date("m/d/Y", strtotime($profile["birthdate"])); ?></p>
            <p><strong>Weight:</strong> <?php echo htmlspecialchars($profile["weight"]); ?> pounds</p>
        <?php else: ?>
            <p class="text-danger">Profile information not found. Please contact support.</p>
        <?php endif; ?>
    </div>

    <hr>
    <h2>Latest Exercise Entries</h2>
    <?php if (empty($logData)): ?>
        <p>No exercises logged yet.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Time (minutes)</th>
                    <th>Average Heart Rate</th>
                    <th>Calories Burned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logData as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry["date"]); ?></td>
                        <td><?php echo htmlspecialchars($entry["exercise_type"]); ?></td>
                        <td><?php echo htmlspecialchars($entry["time_in_minutes"]); ?></td>
                        <td><?php echo htmlspecialchars($entry["heartrate"]); ?></td>
                        <td><?php echo htmlspecialchars($entry["calories"]); ?></td>
                        <td>
                            <a href="removelogentry.php?id=<?php echo htmlspecialchars($entry["id"]); ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
